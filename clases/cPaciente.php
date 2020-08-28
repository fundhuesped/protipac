<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cPaciente
{
	static function modificarPaciente($camposPost, $errorVar, $pac_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecCamposFecha=array();
		array_push($vecCamposInt,"var_tid_id");
		array_push($vecCamposInt,"var_sex_id");
		array_push($vecCamposInt,"var_gen_id");
		
		array_push($vecCamposFecha,"var_fecha_ingreso");
		array_push($vecCamposFecha,"var_fecha_nacimiento");
	

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","pac_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","pac_",$key)."='".$value."'");
					}
				} else {
					if(in_array($key,$vecCamposFecha)){
						if($value==''){
							array_push($vecCamposSet,str_replace("var_","pac_",$key)."=NULL");
						} else {
							$value= date("Y-m-d", strtotime(str_replace("/","-",$value)));
							array_push($vecCamposSet,str_replace("var_","pac_",$key)."='".$value."'");
						}
					} else {
						if($value=="true" || $value=="false"){
							array_push($vecCamposSet,str_replace("var_","pac_",$key)."=$value");
						} else {
							array_push($vecCamposSet,str_replace("var_","pac_",$key)."='".$value."'");
						}
					}
				}
			  }				
			}
		  cComando::autocommit(false);
		  $pac_reh_id=-1;
		  if($camposPost["pac_reh_id"]=="-1"){
			  if(strlen($camposPost['otro_hospital'])<=0){
				cComando::rollback();
				return -1;
			  }
			  $status_hospital=ST_PENDIENTE;
			  $pac_reh_id=cHospital::insertarHospital($camposPost['otro_hospital'], $status_hospital);
		  } else {
		  	  $pac_reh_id=intval($camposPost["pac_reh_id"],10);
		  }
		  if($pac_reh_id<0){
			cComando::rollback();
		  	return -1;
		  }
		  array_push($vecCamposSet,"pac_reh_id=".$pac_reh_id);
		  $nombre=$camposPost['var_nombre'];
		  $snombre=$camposPost['var_segundo_nombre'];
		  $apellido=$camposPost['var_apellido'];
		  $sapellido=$camposPost['var_segundo_apellido'];
		  array_push($vecCamposSet,"pac_iniciales='".strtoupper(substr($nombre,0,1).substr($snombre,0,1).substr($apellido,0,1).substr($sapellido,0,1))."'");

		if(count($vecCamposSet)>0){
			if(empty($pac_id)){
				$sql="INSERT INTO paciente (pac_usr_id_alta, pac_fecha_hora_alta) VALUES (".$_SESSION['id_usu'].",'".date("Y-m-d H:i:s")."')";
				$status1 = cComando::ejecutar($sql, INSERT, $pac_id);
				
				if($status1==FALSE){
					cComando::rollback();
					return -1;
				}
			}
			array_push($vecCamposSet,"pac_usr_id_modifica='".$_SESSION['id_usu']."'");
			array_push($vecCamposSet,"pac_fecha_hora_modifica='".date("Y-m-d H:i:s")."'");
			
			if(!empty($pac_id)){
				$sql="UPDATE paciente SET ".implode(",",$vecCamposSet)." WHERE pac_id='".$pac_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					cComando::rollback();
					return -1;
				}
			} else {			
				cComando::rollback();
				return -1;
			}
		}
		cComando::commit();
		return $pac_id;
	}
	static function obtener($inicio="", $tamanioPagina="", $buscar_paciente="", $buscar_protocolo, $buscar_hc, $buscar_iniciales, $buscar_fecha_desde,$buscar_fecha_hasta, &$cantResultados, &$cantPaginas, $orden, $direccion_orden,$pac_id)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(distinct PAC.pac_id), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			$sql = "SELECT PAC.pac_id,PAC.pac_apellido, PAC.pac_segundo_apellido, PAC.pac_nombre, PAC.pac_segundo_nombre, PAC.pac_iniciales, PAC.pac_fecha_ingreso, GROUP_CONCAT(DISTINCT P.pro_codigo_estudio SEPARATOR ' | ') as protocolos";

			$sql_from=" FROM  paciente PAC LEFT JOIN protocolo_paciente PPAC ON (PPAC.propac_pac_id=PAC.pac_id) LEFT JOIN protocolo P ON (P.pro_id=PPAC.propac_pro_id)";

			if(!empty($buscar_paciente))
				$sql_where.= " AND (CONCAT(PAC.pac_nombre,' ',PAC.pac_segundo_nombre,' ',PAC.pac_apellido,' ',PAC.pac_segundo_apellido) LIKE '%$buscar_paciente%' OR CONCAT(PAC.pac_nombre,' ',PAC.pac_apellido) LIKE '%$buscar_paciente%' OR PAC.pac_nombre LIKE '%$buscar_paciente%' OR PAC.pac_apellido LIKE '%$buscar_paciente%') ";
				
			if(!empty($buscar_protocolo))
				$sql_where.= " AND P.pro_id='$buscar_protocolo'";

			if(!empty($pac_id))
				$sql_where.= " AND PAC.pac_id='$pac_id'";

			if(!empty($buscar_hc))
				$sql_where.= " AND PAC.pac_id='$buscar_hc'";

			if(!empty($buscar_iniciales))
				$sql_where.= " AND PAC.pac_iniciales='$buscar_iniciales'";
				
			if(!empty($buscar_fecha_desde))
				$sql_where.= " AND PAC.pac_fecha_ingreso>='$buscar_fecha_desde'";

			if(!empty($buscar_fecha_hasta))
				$sql_where.= " AND PAC.pac_fecha_ingreso<='$buscar_fecha_hasta'";

			$rDatos = cComando::consultar($sql_count.$sql_from.$sql_where);
			if(strlen($inicio) && strlen($tamanioPagina)){
				$cantResultados=$rDatos->campo('cantidad', 0);
				$cantPaginas = ceil($rDatos->campo('cantidad', 0) / $tamanioPagina);
				$limit = " LIMIT $inicio , $tamanioPagina";
			}

		$sql_group_by=" GROUP BY PAC.pac_id";
		$sql_order= " ORDER BY $orden $direccion";
		$sql_limit= $limit;
		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_group_by.$sql_having.$sql_order.$sql_limit);
		return $rDatos;
	}
	static function obtenerPaciente($pac_id){
		$sql="SELECT P.pac_id, P.pac_nro_documento,P.pac_tid_id, pac_apellido, pac_nombre,pac_segundo_nombre,pac_segundo_apellido, pac_iniciales, pac_fecha_nacimiento,pac_fecha_ingreso,pac_gen_id,pac_sex_id,pac_alias,pac_obra_social,
		pac_medico_deriva,pac_reh_id,pac_observaciones FROM paciente P WHERE pac_id='$pac_id'";
		return cComando::consultar($sql);
	}
	
	static function modificarPacienteProtocolo($camposPost, $errorVar, $pac_id, $pro_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecCamposFecha=array();
		array_push($vecCamposInt,"var_pro_id");
		array_push($vecCamposInt,"var_spp_id");
		array_push($vecCamposInt,"var_med_id");
		array_push($vecCamposInt,"var_screening");
		array_push($vecCamposInt,"var_basal");
		
		$fecha_screening=$camposPost['fecha_screening'];
		$fecha_screening_iso="";
		if(strlen($fecha_screening)>0){
			$fecha_screening_iso=date("Y-m-d", strtotime(str_replace("/","-",$fecha_screening)));
		}
		$fecha_basal=$camposPost['fecha_basal'];
		$fecha_basal_iso="";
		if(strlen($fecha_basal)>0){
			$fecha_basal_iso=date("Y-m-d", strtotime(str_replace("/","-",$fecha_basal)));
		}
		
		$scr=0;
		$basal=0;
		if(strlen($fecha_screening_iso)>0 && $fecha_screening_iso<$fecha_basal_iso && intval($camposPost['var_screening'],10)==1){
			$scr=1;
		}
		if(strlen($fecha_basal_iso)>0 && $fecha_basal_iso>$fecha_screening_iso && $scr==1 && intval($camposPost['var_basal'],10)==1){
			$basal=1;
		}

		
		if(intval($camposPost['var_spp_id'],10)==ST_PP_SCR){
			//estado screening
			if($scr==0 || ($basal==1 && $scr==1)){
				//si no aprobó screening o sí aprobó screening pero también realizó basal, no puede tomar este estado
				return -1;
			}
		}
		if(intval($camposPost['var_spp_id'],10)==ST_PP_PROTOCOLO){
			//estado en protocolo
			if($scr==0 || $basal==0){
				//si no aprobó screening o sí no realizó basal, no puede tomar este estado
				return -1;
			}
		}
		if(intval($camposPost['var_spp_id'],10)==ST_PP_COMPLETADO){
			//estado completado
			if($scr==0 || $basal==0){
				//si no aprobó screening o sí no realizó basal, no puede tomar este estado
				return -1;
			}
		}
		if(intval($camposPost['var_spp_id'],10)==ST_PP_FALLOSCR){
			//estado fallo screening
			if(scr==1 || $basal==1){
				//si aprobó screening o si realizó la visita basal no puede tomar este estado
				return -1;
			}
		}

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","propac_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","propac_",$key)."='".$value."'");
					}
				} else {
					if(in_array($key,$vecCamposFecha)){
						if($value==''){
							array_push($vecCamposSet,str_replace("var_","propac_",$key)."=NULL");
						} else {
							$value= date("Y-m-d", strtotime(str_replace("/","-",$value)));
							array_push($vecCamposSet,str_replace("var_","propac_",$key)."='".$value."'");
						}
					} else {
						if($value=="true" || $value=="false"){
							array_push($vecCamposSet,str_replace("var_","propac_",$key)."=$value");
						} else {
							array_push($vecCamposSet,str_replace("var_","propac_",$key)."='".$value."'");
						}
					}
				}
			  }				
			}
		  cComando::autocommit(false);

		if(count($vecCamposSet)>0){		
			if(strlen($pro_id)==0){
				array_push($vecCamposSet,"propac_spp_id=".ST_PP_ACTIVO);//por defecto estado activo
				$sql="INSERT INTO protocolo_paciente (propac_pac_id, propac_pro_id) VALUES ('".$pac_id."','".$camposPost['var_pro_id']."')";
				$status1 = cComando::ejecutar($sql, INSERT, $idpropac);	
				if($status1==FALSE){
					cComando::rollback();
					return -1;
				}
				$pro_id=$camposPost['var_pro_id'];
			}
			$sql="UPDATE protocolo_paciente SET ".implode(",",$vecCamposSet)." WHERE propac_pac_id='$pac_id' AND propac_pro_id='$pro_id'";
			$status2 = cComando::ejecutar($sql, UPDATE, $idpropac);
			if($status2==FALSE){
				cComando::rollback();
				return -1;
			}
		}
		
		if($fecha_screening_iso!=""){
			$vis=cPaciente::insertarVisitaPacienteProtocolo($pro_id,$pac_id,TIPO_VIS_SCR,$fecha_screening_iso,$fecha_screening_iso,$camposPost['var_med_id'],ST_VIS_REALIZADA);
			if($vis==-1){
				cComando::rollback();
				return -1;
			}
		}
		if($fecha_basal_iso!=""){
			if(intval($camposPost['var_basal'],10)==1){
				$st_basal=ST_VIS_REALIZADA;
				$fecha_realizacion_basal=$fecha_basal_iso;
			} else {
				$st_basal=ST_VIS_PROGRAMADA;
				$fecha_realizacion_basal=null;
			}
			$vis=cPaciente::insertarVisitaPacienteProtocolo($pro_id,$pac_id,TIPO_VIS_BASAL,$fecha_basal_iso,$fecha_realizacion_basal,$camposPost['var_med_id'],$st_basal);
			if($vis==-1){
				cComando::rollback();
				return -1;
			}
		}
		
		cComando::commit();
		return 1;
	}
	static function obtenerProtocolos($inicio="", $tamanioPagina="",  &$cantResultados, &$cantPaginas, $orden, $direccion_orden,$pac_id)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(distinct P.pro_id), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			$sql = "SELECT P.pro_id,P.pro_codigo_estudio, P.pro_titulo_breve, SPP.spp_descripcion, SPP.spp_id, SPP.spp_estilo, PVISSCR.provis_fecha_realizada fecha_screening, IFNULL(PVISBASAL.provis_fecha_realizada,PVISBASAL.provis_fecha_agenda) fecha_basal, MED.med_apellido, MED.med_nombre, PPAC.propac_observaciones";

			$sql_from=" FROM protocolo P INNER JOIN protocolo_paciente PPAC ON (PPAC.propac_pac_id=$pac_id AND P.pro_id=PPAC.propac_pro_id)
						INNER JOIN status_protocolo_paciente SPP ON (SPP.spp_id=PPAC.propac_spp_id)
						INNER JOIN medico MED ON (MED.med_id=PPAC.propac_med_id)
						LEFT JOIN protocolo_paciente_visita PVISSCR ON (PVISSCR.provis_pro_id=PPAC.propac_pro_id AND PVISSCR.provis_pac_id=PPAC.propac_pac_id AND PVISSCR.provis_tiv_id=".TIPO_VIS_SCR.")
						LEFT JOIN protocolo_paciente_visita PVISBASAL ON (PVISBASAL.provis_pro_id=PPAC.propac_pro_id AND PVISBASAL.provis_pac_id=PPAC.propac_pac_id AND PVISBASAL.provis_tiv_id=".TIPO_VIS_BASAL.")";
			$rDatos = cComando::consultar($sql_count.$sql_from.$sql_where);
			if(strlen($inicio) && strlen($tamanioPagina)){
				$cantResultados=$rDatos->campo('cantidad', 0);
				$cantPaginas = ceil($rDatos->campo('cantidad', 0) / $tamanioPagina);
				$limit = " LIMIT $inicio , $tamanioPagina";
			}

		$sql_group_by=" GROUP BY P.pro_id";
		$sql_order= " ORDER BY $orden $direccion";
		$sql_limit= $limit;
		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_group_by.$sql_having.$sql_order.$sql_limit);
		return $rDatos;
	}
	static function insertarVisitaPacienteProtocolo($pro_id,$pac_id,$tiv_id,$provis_fecha_agenda,$provis_fecha_realizada,$med_id,$sv_id){
		$sql="SELECT CV.cron_id, CV.cron_ventana_max, CV.cron_ventana_min, PPV.provis_id FROM cronograma_visita CV LEFT JOIN protocolo_paciente_visita PPV ON (PPV.provis_cron_id=CV.cron_id AND PPV.provis_pro_id='$pro_id' AND PPV.provis_pac_id='$pac_id' AND PPV.provis_tiv_id='$tiv_id') WHERE CV.cron_tiv_id='$tiv_id' AND CV.cron_pro_id='$pro_id'";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			if(is_null($rDatos->campo('provis_id',0))){
				$sql="INSERT INTO protocolo_paciente_visita (provis_pro_id, provis_pac_id, provis_cron_id, provis_fecha_agenda, provis_fecha_realizada, provis_sv_id, provis_med_id, provis_tiv_id, provis_ventana_max, provis_ventana_min) VALUES ('$pro_id','$pac_id','".$rDatos->campo('cron_id',0)."','$provis_fecha_agenda',".(is_null($provis_fecha_realizada) ? "NULL" : "'$provis_fecha_realizada'").",'$sv_id','$med_id','$tiv_id','".$rDatos->campo('cron_ventana_max',0)."','".$rDatos->campo('cron_ventana_min',0)."')";
				$status = cComando::ejecutar($sql, INSERT, $idVis);
			} else {
				$sql="UPDATE protocolo_paciente_visita SET provis_fecha_agenda='$provis_fecha_agenda',provis_fecha_realizada=".(is_null($provis_fecha_realizada) ? "NULL" : "'$provis_fecha_realizada'").",provis_med_id='$med_id',provis_sv_id='$sv_id'
				WHERE provis_id=".$rDatos->campo('provis_id',0);
				$status = cComando::ejecutar($sql, UPDATE, $idVis);
				$idVis=$rDatos->campo('provis_id',0);
			}

			if($status){
				return 1;		
			}
		}
		return -1;
	}
	static function obtenerVisitasProgramadasPacienteProtocolo($inicio="", $tamanioPagina="",  &$cantResultados, &$cantPaginas, $orden, $direccion_orden,$pro_id,$pac_id,$buscar_laboratorio, $buscar_protocolo,$buscar_fecha_desde,$buscar_fecha_hasta)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(distinct C.cron_id), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			$sql = "SELECT C.cron_id, IFNULL(PPV.provis_descripcion,IF(C.cron_crvn_id=-1, C.cron_descripcion,CRVN.crvn_descripcion)) nombre_visita, C.cron_dias_basal, TIV.tiv_descripcion, PPV.provis_fecha_agenda, PPV.provis_hora_agenda, PPV.provis_fecha_realizada, PPV.provis_hora_realizada, SV.sv_descripcion, SV.sv_estilo, SV.sv_id, PPV.provis_id,PPV.provis_observaciones";

			$sql_from=" FROM protocolo_paciente_visita PPV INNER JOIN tipo_visita TIV ON (TIV.tiv_id=PPV.provis_tiv_id) INNER JOIN status_visita SV ON (SV.sv_id=PPV.provis_sv_id) LEFT JOIN cronograma_visita C ON (PPV.provis_cron_id=C.cron_id) LEFT JOIN cronograma_visita_nombre CRVN ON (CRVN.crvn_id=C.cron_crvn_id)";
			$sql_where.= " AND PPV.provis_pac_id='$pac_id'";
			if(strlen($pro_id)>0){
				$sql_where.=" AND PPV.provis_pro_id='$pro_id'";
			} else {
				$sql.=",C.cron_laboratorio,P.pro_titulo_breve,PPV.provis_pro_id";
				$sql_from.=" LEFT JOIN protocolo P ON (P.pro_id=PPV.provis_pro_id)";
			}
			
			if(strlen($buscar_laboratorio)>0){
				$sql_where.=" AND C.cron_laboratorio='".intval($buscar_laboratorio,10)."'";
			}
			if(strlen($buscar_protocolo)>0){
				$sql_where.=" AND PPV.provis_pro_id='".intval($buscar_protocolo,10)."'";
			}
			if(strlen($buscar_fecha_desde)>0){
				$buscar_fecha_desde=date("Y-m-d", strtotime(str_replace("/","-",$buscar_fecha_desde)));
				if(validateDate($buscar_fecha_desde)){
					$sql_where.=" AND PPV.provis_fecha_agenda>='$buscar_fecha_desde'";
				}
			}
			if(strlen($buscar_fecha_hasta)>0){
				$buscar_fecha_hasta=date("Y-m-d", strtotime(str_replace("/","-",$buscar_fecha_hasta)));
				if(validateDate($buscar_fecha_hasta)){
					$sql_where.=" AND PPV.provis_fecha_agenda<='$buscar_fecha_hasta'";
				}
			}

			$rDatos = cComando::consultar($sql_count.$sql_from.$sql_where);
			if(strlen($inicio) && strlen($tamanioPagina)){
				$cantResultados=$rDatos->campo('cantidad', 0);
				$cantPaginas = ceil($rDatos->campo('cantidad', 0) / $tamanioPagina);
				$limit = " LIMIT $inicio , $tamanioPagina";
			}
		$sql_order= " ORDER BY $orden $direccion";
		$sql_limit= $limit;
		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_order.$sql_limit);
		return $rDatos;
	}
	static function obtenerVisitaPaciente($provis_id,$pro_id){
		$sql = "SELECT C.cron_id, IFNULL(PPV.provis_descripcion,IF(C.cron_crvn_id=-1, C.cron_descripcion,CRVN.crvn_descripcion)) nombre_visita, C.cron_dias_basal, TIV.tiv_descripcion, PPV.provis_fecha_agenda, PPV.provis_hora_agenda, PPV.provis_fecha_realizada, PPV.provis_hora_realizada, SV.sv_descripcion, SV.sv_estilo, SV.sv_id, PAC.pac_nombre, PAC.pac_apellido, PPV.provis_pac_id, PPV.provis_tiv_id, PPV.provis_ventana_max, PPV.provis_ventana_min,PPV.provis_med_id,PPV.provis_observaciones";
		$sql_from=" FROM protocolo_paciente_visita PPV INNER JOIN tipo_visita TIV ON (TIV.tiv_id=PPV.provis_tiv_id) INNER JOIN status_visita SV ON (SV.sv_id=PPV.provis_sv_id) INNER JOIN paciente PAC ON (PAC.pac_id=PPV.provis_pac_id) LEFT JOIN cronograma_visita C ON (PPV.provis_cron_id=C.cron_id) LEFT JOIN cronograma_visita_nombre CRVN ON (CRVN.crvn_id=C.cron_crvn_id)";
		$sql_where= " WHERE PPV.provis_id='$provis_id' AND PPV.provis_pro_id='$pro_id'";
		return cComando::consultar($sql.$sql_from.$sql_where);
	}
	
	static function modificarVisitaPacienteProtocolo($camposPost, $errorVar, $pro_id, $pac_id, $provis_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecCamposFecha=array();

		array_push($vecCamposInt,"var_ventana_max");
		array_push($vecCamposInt,"var_ventana_min");
		array_push($vecCamposInt,"var_tiv_id");
		array_push($vecCamposInt,"var_med_id");
		array_push($vecCamposInt,"var_sv_id");
		array_push($vecCamposInt,"var_pro_id");
		
		array_push($vecCamposFecha,"var_fecha_agenda");
		array_push($vecCamposFecha,"var_fecha_realizada");
		
		if(strlen(intval($pac_id,10))==0){
			return -1;
		}
		if(strlen($provis_id)==0){
			if(strlen(intval($pro_id,10))==0){
				return -1;
			} else {
				if(!cPaciente::tieneProtocolo($pac_id,$pro_id)){
					return -1;
				}
			}
		}

		if($camposPost['var_tiv_id']!=TIPO_VIS_ESPO || strlen($provis_id)>0){
			//remover de array campos que solo van en visita espontánea
			unset($camposPost['var_descripcion']);
		}
		if($provis_tiv_id==TIPO_VIS_ESPO || strlen($provis_id)==0){
			//remover campos
			unset($camposPost['var_ventana_max']);
			unset($camposPost['var_ventana_min']);
		}


			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","provis_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","provis_",$key)."='".$value."'");
					}
				} else {
					if(in_array($key,$vecCamposFecha)){
						if($value==''){
							array_push($vecCamposSet,str_replace("var_","provis_",$key)."=NULL");
						} else {
							//$value= date("Y-m-d", strtotime(str_replace("/","-",$value)));
							array_push($vecCamposSet,str_replace("var_","provis_",$key)."='".$value."'");
						}
					} else {
						if($value=="true" || $value=="false"){
							array_push($vecCamposSet,str_replace("var_","provis_",$key)."=$value");
						} else {
							array_push($vecCamposSet,str_replace("var_","provis_",$key)."='".$value."'");
						}
					}
				}
			  }				
			}
			
			if(strlen($camposPost['var_sv_id'])>0){
				$estado_visita=intval($camposPost['var_sv_id'],10);
			} else {
				if(strlen($provis_id)>0){
					$sql="SELECT provis_sv_id FROM protocolo_paciente_visita WHERE provis_id=".intval($provis_id,10);
					$rDatos=cComando::consultar($sql);
					if($rDatos->cantidad()>0){
						$estado_visita=$rDatos->campo('provis_sv_id',0);
					    array_push($vecCamposSet,"provis_sv_id='".$estado_visita."'");
					} else {
						return -1;
					}
				} else {
					return -1;
				}
			}
			if(strlen($camposPost['var_fecha_agenda'])==0 || strlen($camposPost['hora_inicio_agenda'])==0 || strlen($camposPost['minutos_inicio_agenda'])==0){
				return -1;
			} else {
				$hora_agenda=completarNumeroIzq(intval($camposPost['hora_inicio_agenda'],10),2).":".completarNumeroIzq(intval($camposPost['minutos_inicio_agenda'],10),2).":00";
				array_push($vecCamposSet,"provis_hora_agenda='".$hora_agenda."'");
			}			

			if($estado_visita==ST_VIS_REALIZADA){
				if(strlen($camposPost['var_fecha_realizada'])==0 || strlen($camposPost['hora_inicio_realizada'])==0 || strlen($camposPost['minutos_inicio_realizada'])==0){
					return -1;
				} else {
					$hora_realizada=completarNumeroIzq(intval($camposPost['hora_inicio_realizada'],10),2).":".completarNumeroIzq(intval($camposPost['minutos_inicio_realizada'],10),2).":00";
				    array_push($vecCamposSet,"provis_hora_realizada='".$hora_realizada."'");
				}
			} else {
				unset($camposPost['var_fecha_realizada']);
				unset($camposPost['hora_inicio_realizada']);
				unset($camposPost['minutos_inicio_realizada']);
				array_push($vecCamposSet,"provis_fecha_realizada=NULL");
				array_push($vecCamposSet,"provis_hora_realizada=NULL");
			}
		  cComando::autocommit(false);

		if(count($vecCamposSet)>0){
			if(empty($provis_id)){
				$sql="INSERT INTO protocolo_paciente_visita (provis_pro_id, provis_pac_id, provis_sv_id) VALUES ('$pro_id','$pac_id','$estado_visita')";
				$status1 = cComando::ejecutar($sql, INSERT, $provis_id);
				
				if($status1==FALSE){		
					cComando::rollback();
					return -1;
				}			
			}
			if(!empty($provis_id)){
				$sql="UPDATE protocolo_paciente_visita SET ".implode(",",$vecCamposSet)." WHERE provis_id='".$provis_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					cComando::rollback();
					return -1;
				}
			} else {
				cComando::rollback();
				return -1;
			}
		}
		cComando::commit();
		return $provis_id;
	}
	static function tieneProtocolo($pac_id,$pro_id){
		$sql="SELECT propac_pac_id FROM protocolo_paciente PP WHERE PP.propac_pro_id='$pro_id' AND PP.propac_pac_id=$pac_id";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			return true;
		}
		return false;
	}
	static function modificarLlamada($camposPost, $errorVar, $provis_id,$proseg_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		if(strlen($camposPost['var_observaciones'])==0){
			return -1;
		}
		if(strlen($provis_id)==0){
			return -1;
		}
		array_push($vecCamposSet,"proseg_observaciones='".substr($camposPost['var_observaciones'],0,1000)."'");
		  cComando::autocommit(false);

		if(count($vecCamposSet)>0){
			if(empty($proseg_id)){
				$sql="INSERT INTO protocolo_paciente_visita_follow (proseg_provis_id, proseg_fecha_hora) VALUES (".$provis_id.",'".date("Y-m-d H:i:s")."')";
				$status1 = cComando::ejecutar($sql, INSERT, $proseg_id);
				
				if($status1==FALSE){
					cComando::rollback();
					return -1;
				}
			}			
			if(!empty($proseg_id)){
				$sql="UPDATE protocolo_paciente_visita_follow SET ".implode(",",$vecCamposSet)." WHERE proseg_id='".$proseg_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					cComando::rollback();
					return -1;
				}
			} else {			
				cComando::rollback();
				return -1;
			}
		}
		cComando::commit();
		return $proseg_id;
	}
	static function obtenerLlamadasVisitaPaciente($provis_id){
		$sql = "SELECT PSEG.proseg_id, PSEG.proseg_fecha_hora, PSEG.proseg_observaciones";
		$sql_from=" FROM protocolo_paciente_visita_follow PSEG";
		$sql_where= " WHERE PSEG.proseg_provis_id='$provis_id'";
		$sql_order_by=" ORDER BY PSEG.proseg_fecha_hora";
		return cComando::consultar($sql.$sql_from.$sql_where.$sql_order_by);
	}
	static function programarVisitasPacienteProtocolo($pro_id,$pac_id,$hora_inicio,$minutos_inicio){
		$fallo=false;
		cComando::autocommit(FALSE);
		$sql="SELECT provis_fecha_realizada FROM protocolo_paciente_visita PPV WHERE PPV.provis_tiv_id=".TIPO_VIS_BASAL." AND PPV.provis_pro_id='".intval($pro_id,10)."' AND PPV.provis_pac_id='".intval($pac_id,10)."'";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			$fecha_basal=$rDatos->campo('provis_fecha_realizada',0);
			$sql="SELECT PP.provis_id, C.cron_id, C.cron_pro_id, C.cron_crvn_id, C.cron_descripcion, C.cron_ventana_max, C.cron_ventana_min, C.cron_observaciones, C.cron_tiv_id, DATE_ADD('".$fecha_basal."', INTERVAL C.cron_dias_basal DAY) fecha_agenda FROM cronograma_visita C LEFT JOIN protocolo_paciente_visita PP ON (PP.provis_cron_id=C.cron_id AND C.cron_pro_id=PP.provis_pro_id AND PP.provis_pac_id=$pac_id) WHERE C.cron_tiv_id NOT IN (".TIPO_VIS_BASAL.",".TIPO_VIS_SCR.") AND C.cron_pro_id='".intval($pro_id,10)."' AND C.cron_id NOT IN (SELECT provis_cron_id FROM protocolo_paciente_visita PPV WHERE PPV.provis_pro_id='".intval($pro_id,10)."' AND PPV.provis_pac_id='".intval($pac_id,10)."' AND provis_cron_id IS NOT NULL AND (provis_tiv_id IN (".TIPO_VIS_BASAL.",".TIPO_VIS_SCR.",".TIPO_VIS_ESPO.") OR provis_sv_id IN('".ST_VIS_REALIZADA."','".ST_VIS_CANCELADA."')))";

			$rVis=cComando::consultar($sql);
			$hora_agenda=completarNumeroIzq(intval($hora_inicio,10),2).":".completarNumeroIzq(intval($minutos_inicio,10),2).":00";
			for($i=0;$i<$rVis->cantidad();$i++){
				if(is_null($rVis->campo('provis_id',$i))){
					//insertar
					$sql="INSERT INTO protocolo_paciente_visita
						 (provis_pro_id,provis_pac_id,provis_cron_id,provis_descripcion,provis_fecha_agenda,provis_hora_agenda,provis_sv_id,provis_tiv_id,provis_observaciones,provis_ventana_max,provis_ventana_min) VALUES (";
					$sql.="'".intval($pro_id,10)."','".intval($pac_id,10)."','".$rVis->campo('cron_id',$i)."',".(is_null($rVis->campo('cron_descripcion',$i)) ? "NULL" :"'".$rVis->campo('cron_descripcion',$i)."'").",'".$rVis->campo('fecha_agenda',$i)."','".$hora_agenda."','".ST_VIS_PROGRAMADA."','".$rVis->campo('cron_tiv_id',$i)."','".$rVis->campo('cron_observaciones',$i)."','".$rVis->campo('cron_ventana_max',$i)."','".$rVis->campo('cron_ventana_min',$i)."'";
					$sql.=")";
					$status = cComando::ejecutar($sql, INSERT, $id);
					if(!$status){
						$fallo=true;
					}
				} else {
					//modificar
					$sql="UPDATE protocolo_paciente_visita SET provis_fecha_agenda='".$rVis->campo('fecha_agenda',$i)."',provis_hora_agenda='".$hora_agenda."',
					provis_sv_id='".ST_VIS_PROGRAMADA."',provis_tiv_id='".$rVis->campo('cron_tiv_id',$i)."',provis_observaciones='".$rVis->campo('cron_observaciones',$i)."',provis_ventana_max='".$rVis->campo('cron_ventana_max',$i)."',provis_ventana_min='".$rVis->campo('cron_ventana_min',$i)."' WHERE provis_id='".$rVis->campo('provis_id',$i)."'";
					$status = cComando::ejecutar($sql, UPDATE, $id);
					if(!$status){
						$fallo=true;
					}
				}
			}
		}
		if($fallo){
			cComando::rollback();
			return -1;
		} else {
			cComando::commit();
			return 1;
		}
	}
}
?>