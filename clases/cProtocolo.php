<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cProtocolo
{
	static function modificarProtocolo($camposPost, $errorVar, $pro_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecCamposFecha=array();
		$vecPatrocinador=array();
		$vecInvestigador=array();
		array_push($vecCamposInt,"var_sp_id");
		array_push($vecCamposInt,"var_tes_id");
		array_push($vecCamposInt,"var_tex_id");
		array_push($vecCamposInt,"var_target");
		array_push($vecCamposInt,"var_fase_id");
		array_push($vecCamposInt,"var_cro");
		array_push($vecCamposInt,"var_financiamiento");
		
		array_push($vecCamposFecha,"var_fecha_inicio");
		array_push($vecCamposFecha,"var_fecha_fin");
	

		$vecCamposInsertInvestigadorProyecto=array();
		$vecCamposInsertPatrocinadorProyecto=array();

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","pro_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","pro_",$key)."='".$value."'");
					}
				} else {
					if(in_array($key,$vecCamposFecha)){
						if($value==''){
							array_push($vecCamposSet,str_replace("var_","pro_",$key)."=NULL");
						} else {
							$value= date("Y-m-d", strtotime(str_replace("/","-",$value)));
							array_push($vecCamposSet,str_replace("var_","pro_",$key)."='".$value."'");
						}
					} else {
						if($value=="true" || $value=="false"){
							array_push($vecCamposSet,str_replace("var_","pro_",$key)."=$value");				
						} else {
							array_push($vecCamposSet,str_replace("var_","pro_",$key)."='".$value."'");
						}
					}
				}
			  }				
			}
		  cComando::autocommit(false);
		  $propat_emp_id=-1;
		  if($camposPost["proyecto_patrocinador_spo"]=="-1"){
			  $status_patrocinador_captura=ST_PENDIENTE;
			  $propat_emp_id=cEntidad::insertarPatrocinador($camposPost['razon_social_sponsor_nuevo'], ST_PENDIENTE);
		  } else {
		  	  $propat_emp_id=intval($camposPost["proyecto_patrocinador_spo"],10);
		  }
		  if($propat_emp_id<0){

		  
			cComando::rollback();
		  	return -1;
		  }
		  array_push($vecPatrocinador,array("propat_emp_id"=>intval($propat_emp_id,10),"propat_trolpat_id"=>TIPO_ROL_SPONSOR));

		  $propat_emp_id=-1;
		  if(intval($camposPost["var_cro"],10)==TIPO_CRO){
			  if($camposPost["proyecto_patrocinador_cro"]=="-1"){
				  $status_patrocinador_captura=ST_PENDIENTE;
				  $propat_emp_id=cEntidad::insertarPatrocinador($camposPost['razon_social_cro_nuevo'], ST_PENDIENTE);
			  } else {
				  $propat_emp_id=intval($camposPost["proyecto_patrocinador_cro"],10);
			  }
			  if($propat_emp_id<0){
				cComando::rollback();
				return -1;
			  }
			  array_push($vecPatrocinador,array("propat_emp_id"=>intval($propat_emp_id,10),"propat_trolpat_id"=>TIPO_ROL_CRO));
		  }


		  $propat_emp_id=-1;
		  if(intval($camposPost["var_financiamiento"],10)==TIPO_FINANCIADO){
			  if($camposPost["proyecto_patrocinador_fin"]=="-1"){
				  $status_patrocinador_captura=ST_PENDIENTE;
				  $propat_emp_id=cEntidad::insertarPatrocinador($camposPost['razon_social_financiador_nuevo'], ST_PENDIENTE);
			  } else {
				  $propat_emp_id=intval($camposPost["proyecto_patrocinador_fin"],10);
			  }
			  if($propat_emp_id<0){
				cComando::rollback();
				return -1;
			  }
			  array_push($vecPatrocinador,array("propat_emp_id"=>intval($propat_emp_id,10),"propat_trolpat_id"=>TIPO_ROL_FINANCIADOR));
		  }

			
			
		  $proinv_inv_id=-1;
		  if(strlen($camposPost["proyecto_investigador_princ"])>0){
			  array_push($vecInvestigador,array("proinv_inv_id"=>intval($camposPost["proyecto_investigador_princ"],10),"proinv_tinv_id"=>TIPO_INV_PRINCIPAL));
		  }
		  $proinv_inv_id=-1;
		  if(strlen($camposPost["proyecto_investigador_sub1"])>0){
			  array_push($vecInvestigador,array("proinv_inv_id"=>intval($camposPost["proyecto_investigador_sub1"],10),"proinv_tinv_id"=>TIPO_INV_SUB));
		  }
		  $proinv_inv_id=-1;
		  if(strlen($camposPost["proyecto_investigador_sub2"])>0){
			  array_push($vecInvestigador,array("proinv_inv_id"=>intval($camposPost["proyecto_investigador_sub2"],10),"proinv_tinv_id"=>TIPO_INV_SUB));
		  }


		if(count($vecCamposSet)>0){
			if(empty($pro_id)){
				$resultadoAsset2=cContenido::GuardarAsset($_SESSION['id_usu'], PROTOCOLO, "", "", ST_ACTIVO);
				$sql="INSERT INTO protocolo (pro_sp_id,pro_ast_id) VALUES (".ST_PRO_ABIERTO.",'".$resultadoAsset2."')";
				$status1 = cComando::ejecutar($sql, INSERT, $pro_id);
				
				if($status1==FALSE){
					cComando::rollback();
					return -1;
				}
			} 
			if(!empty($pro_id)){
				$sql="UPDATE protocolo SET ".implode(",",$vecCamposSet)." WHERE pro_id='".$pro_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					cComando::rollback();
					return -1;
				}
			} else {			
				cComando::rollback();
				return -1;
			}

			$sql="INSERT INTO protocolo_log (plog_pro_id,plog_fecha_hora,plog_usr_id,plog_sp_id,plog_comentario) VALUES ('$pro_id','".date("Y-m-d H:i:s")."','".$_SESSION['id_usu']."',(SELECT pro_sp_id FROM protocolo WHERE pro_id='$pro_id'),'')";
			$status = cComando::ejecutar($sql, INSERT, $plog_id);
			if($status==FALSE){
				cComando::rollback();
				return -1;
			}
		}
			if(!empty($pro_id)){
				//se inserta patrocinadores
				for($i=0;$i<count($vecPatrocinador);$i++){
					$propat_emp_id=$vecPatrocinador[$i]["propat_emp_id"];
					$propat_trolpat_id=$vecPatrocinador[$i]["propat_trolpat_id"];
					array_push($vecCamposInsertPatrocinadorProyecto,"('$pro_id','$propat_emp_id','$propat_trolpat_id')");
				}

				$sql="DELETE FROM protocolo_patrocinador WHERE propat_pro_id='$pro_id'";
				$status5 = cComando::ejecutar($sql, DELETE, $id);
					if($status5==FALSE){
						cComando::rollback();
						return -1;
					}
					
				if(count($vecCamposInsertPatrocinadorProyecto)>0){
					$sql="INSERT INTO protocolo_patrocinador (propat_pro_id, propat_emp_id, propat_trolpat_id) VALUES ".implode(",",$vecCamposInsertPatrocinadorProyecto);
					$status6 = cComando::ejecutar($sql, INSERT, $id);
					if($status6==FALSE){
						cComando::rollback();
						return -1;
					}
				}

				//se insertan investigadores
				for($i=0;$i<count($vecInvestigador);$i++){
					$proinv_inv_id=$vecInvestigador[$i]["proinv_inv_id"];
					$proinv_tinv_id=$vecInvestigador[$i]["proinv_tinv_id"];
					array_push($vecCamposInsertInvestigadorProyecto,"('$pro_id','$proinv_inv_id','$proinv_tinv_id')");
				}

				$sql="DELETE FROM protocolo_investigador WHERE proinv_pro_id='$pro_id'";
				$status5 = cComando::ejecutar($sql, DELETE, $id);
					if($status5==FALSE){
						cComando::rollback();
						return -1;
					}
				if(count($vecCamposInsertInvestigadorProyecto)>0){
					$sql="INSERT INTO protocolo_investigador (proinv_pro_id, proinv_inv_id, proinv_tinv_id) VALUES ".implode(",",$vecCamposInsertInvestigadorProyecto);
					$status6 = cComando::ejecutar($sql, INSERT, $id);
					if($status6==FALSE){
						cComando::rollback();
						return -1;
					}
				}
			}// end if(empty($pro_id))
			cComando::commit();
			return $pro_id;
	}

	static function obtener($inicio="", $tamanioPagina="", $busqueda="", $estado_protocolo,  &$cantResultados, &$cantPaginas, $inv_id, $emp_id, $orden, $direccion_orden,$busqueda_ref,$pro_id,$estado_asset)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(distinct P.pro_id), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			$sql = "SELECT P.pro_codigo_estudio,P.pro_titulo_breve,P.pro_id,P.pro_financiamiento,P.pro_sp_id,P.pro_ast_id,MAX(plog_fecha_hora) as fecha_ultima_accion,  TEX.tex_descripcion, FAS.fase_descripcion, SP.sp_descripcion, SP.sp_estilo, EPAT.emp_razon_social, EPAT.emp_id, INV.inv_id, INV.inv_nombre, INV.inv_apellido, TES.tes_descripcion";

			$sql_from=" FROM protocolo P INNER JOIN asset AST ON (AST.ast_id=P.pro_ast_id) LEFT JOIN protocolo_log PLOG ON (PLOG.plog_pro_id=P.pro_id) LEFT JOIN tipo_investigacion_experimental TEX ON (TEX.tex_id=P.pro_tex_id) LEFT JOIN fase_investigacion FAS ON (FAS.fase_id=P.pro_fase_id) LEFT JOIN status_protocolo SP ON (SP.sp_id=P.pro_sp_id) LEFT JOIN protocolo_patrocinador PPAT ON (PPAT.propat_pro_id=P.pro_id AND PPAT.propat_trolpat_id=".TIPO_ROL_FINANCIADOR.") LEFT JOIN empresa EPAT ON (EPAT.emp_id=PPAT.propat_emp_id) LEFT JOIN protocolo_investigador PINV ON (PINV.proinv_pro_id=P.pro_id) LEFT JOIN investigador INV ON (INV.inv_id=PINV.proinv_inv_id) LEFT JOIN tipo_estudio TES ON (TES.tes_id=P.pro_tes_id)";
			if(!empty($busqueda))
				$sql_where.= " AND (P.pro_titulo LIKE '%$busqueda%' OR P.pro_titulo_breve LIKE '%$busqueda%') ";
				
			if(!empty($busqueda_ref))
				$sql_where.= " AND P.pro_codigo_estudio LIKE '%$busqueda_ref%' ";

			if(is_array($estado_protocolo)){
				if(count($estado_protocolo)>0){
					$sql_where.= " AND P.pro_sp_id IN (".implode(",",$estado_protocolo).")";
				}
			} else {
				if(!empty($estado_protocolo)){
					$sql_where.= " AND P.pro_sp_id='$estado_protocolo'";
				}
			}
			if(is_array($estado_asset)){
				if(count($estado_asset)>0){
					$sql_where.= " AND AST.ast_status IN (".implode(",",$estado_asset).")";
				}
			} else {
				if(!empty($estado_asset)){
					$sql_where.= " AND AST.ast_status='$estado_asset'";
				}
			}
			if(!empty($emp_id)){
				//por patrocinador
				$sql_where.= " AND PPAT.propat_emp_id='$emp_id'";
			}
			if(!empty($inv_id)){
				//por investigador
				$sql_where.= " AND PINV.proinv_inv_id='$inv_id'";
			}
			if(!empty($pro_id)){
				//por nro protocolo
				$sql_where.= " AND P.pro_id='$pro_id'";
			}
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
	static function obtenerProtocolo($pro_id, $pac_id){
		$sql="SELECT PRO.*, PPAT.propat_emp_id, PINV.proinv_inv_id, PAT.emp_razon_social, PAT.emp_cuit, INV.inv_nombre, INV.inv_apellido, ASTPRO.ast_type, PPAT.propat_emp_id empresa_financiador, PCRO.propat_emp_id empresa_cro, PSPO.propat_emp_id empresa_sponsor";
		$sql_from=" FROM protocolo PRO INNER JOIN asset ASTPRO ON (ASTPRO.ast_id=PRO.pro_ast_id) LEFT JOIN protocolo_patrocinador PPAT ON (PPAT.propat_pro_id=PRO.pro_id AND PPAT.propat_trolpat_id=".TIPO_ROL_FINANCIADOR.") LEFT JOIN protocolo_patrocinador PCRO ON (PCRO.propat_pro_id=PRO.pro_id AND PCRO.propat_trolpat_id=".TIPO_ROL_CRO.") LEFT JOIN protocolo_patrocinador PSPO ON (PSPO.propat_pro_id=PRO.pro_id AND PSPO.propat_trolpat_id=".TIPO_ROL_SPONSOR.") LEFT JOIN protocolo_investigador PINV ON (PINV.proinv_pro_id=PRO.pro_id) LEFT JOIN investigador INV ON (INV.inv_id=PINV.proinv_inv_id) LEFT JOIN empresa PAT ON (PAT.emp_id=PPAT.propat_emp_id)";
		$sql_where=" WHERE PRO.pro_id='$pro_id' AND PRO.pro_sp_id<>".ST_ELIMINAR;
		if(strlen($pac_id)>0){
			$sql.=",PPAC.*, PVISSCR.provis_fecha_agenda fecha_screening, PVISBASAL.provis_fecha_agenda fecha_basal, PVISBASAL.provis_fecha_realizada fecha_basal_realizada, CASE PPAC.propac_spp_id WHEN ".ST_PP_SCR." THEN PVISSCR.provis_med_id WHEN ".ST_PP_PROTOCOLO." THEN PVISSCR.provis_med_id ELSE '' END as medico_id";
			$sql_from.=" LEFT JOIN protocolo_paciente PPAC ON (PPAC.propac_pro_id=PRO.pro_id AND PPAC.propac_pac_id='$pac_id')";
			$sql_from.=" LEFT JOIN protocolo_paciente_visita PVISSCR ON (PVISSCR.provis_pro_id=PPAC.propac_pro_id AND PVISSCR.provis_pac_id=PPAC.propac_pac_id AND PVISSCR.provis_tiv_id=".TIPO_VIS_SCR.")
						 LEFT JOIN protocolo_paciente_visita PVISBASAL ON (PVISBASAL.provis_pro_id=PPAC.propac_pro_id AND PVISBASAL.provis_pac_id=PPAC.propac_pac_id AND PVISBASAL.provis_tiv_id=".TIPO_VIS_BASAL.")";
			$sql_where.=" AND PPAC.propac_pac_id IS NOT NULL";
		}

		return cComando::consultar($sql.$sql_from.$sql_where);
	}
	static function tienePacientes($pro_id){
		$sql="SELECT COUNT(propac_pac_id) cant FROM protocolo_paciente WHERE propac_pro_id=$pro_id";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			if($rDatos->campo('cant',0)>0){
				return true;
			}
		}
		return false;
	}
	static function tieneVisitasPacientes($cron_id){
		$sql="SELECT COUNT(provis_pac_id) cant FROM protocolo_paciente_visita WHERE provis_cron_id=$cron_id";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			if($rDatos->campo('cant',0)>0){
				return true;
			}
		}
		return false;
	}
	static function obtenerProtocoloInvestigadores($pro_id){
		$sql="SELECT PINV.proinv_inv_id, PINV.proinv_tinv_id FROM protocolo_investigador PINV WHERE PINV.proinv_pro_id='$pro_id'";
		return cComando::consultar($sql);
	}
	
	static function obtenerCronogramaVisita($cron_id,$pro_id){
		$sql="SELECT C.*, TIV.tiv_descripcion, CRVN.crvn_descripcion FROM cronograma_visita C INNER JOIN tipo_visita TIV ON (TIV.tiv_id=C.cron_tiv_id) LEFT JOIN cronograma_visita_nombre CRVN ON (CRVN.crvn_id=C.cron_crvn_id)  WHERE C.cron_id='$cron_id' AND C.cron_pro_id='$pro_id'";
		return cComando::consultar($sql);
	}
	static function tieneScrBasal($pro_id){
		$sql="SELECT COUNT(DISTINCT cron_tiv_id) cant FROM cronograma_visita C WHERE C.cron_pro_id='$pro_id' AND cron_tiv_id IN (".TIPO_VIS_SCR.",".TIPO_VIS_BASAL.")";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			if($rDatos->campo('cant',0)==2){
				return true;
			}
		}
		return false;
	}

	static function obtenerCronograma($inicio="", $tamanioPagina="",  &$cantResultados, &$cantPaginas, $orden, $direccion_orden,$pro_id)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(distinct C.cron_id), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			$sql = "SELECT C.cron_id, IF(C.cron_crvn_id=-1, C.cron_descripcion,CRVN.crvn_descripcion) nombre_visita, C.cron_ventana_max, C.cron_ventana_min, C.cron_observaciones, C.cron_dias_basal, C.cron_laboratorio, TIV.tiv_descripcion";

			$sql_from=" FROM cronograma_visita C INNER JOIN tipo_visita TIV ON (TIV.tiv_id=C.cron_tiv_id) LEFT JOIN cronograma_visita_nombre CRVN ON (CRVN.crvn_id=C.cron_crvn_id)";
			if(!empty($pro_id)){
				//por nro protocolo
				$sql_where.= " AND C.cron_pro_id='$pro_id'";
			}
			$rDatos = cComando::consultar($sql_count.$sql_from.$sql_where);
			if(strlen($inicio) && strlen($tamanioPagina)){
				$cantResultados=$rDatos->campo('cantidad', 0);
				$cantPaginas = ceil($rDatos->campo('cantidad', 0) / $tamanioPagina);
				$limit = " LIMIT $inicio , $tamanioPagina";
			}

		$sql_group_by=" GROUP BY C.cron_id";
		$sql_order= " ORDER BY $orden $direccion";
		$sql_limit= $limit;
		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_group_by.$sql_having.$sql_order.$sql_limit);
		return $rDatos;
	}
	static function modificarCronogramaVisita($camposPost, $errorVar, $pro_id, $cron_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();

		array_push($vecCamposInt,"visita_crvn_id");
		array_push($vecCamposInt,"var_laboratorio");
		array_push($vecCamposInt,"var_tiv_id");
		array_push($vecCamposInt,"var_dias_basal");
		array_push($vecCamposInt,"var_ventana_max");
		array_push($vecCamposInt,"var_ventana_min");

		if(intval($camposPost["var_tiv_id"],10)==TIPO_VIS_BASAL){
			$camposPost["var_dias_basal"]=0;
		}

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","cron_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","cron_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","cron_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","cron_",$key)."='".$value."'");
					}
				}
			  }				
			}
		  cComando::autocommit(false);
		  $cron_crvn_id=-1;
		  if(intval($camposPost["visita_crvn_id"],10)==-1){
			  //$cron_crvn_id=cVisitaNombre::insertarNombreVisita($camposPost['descripcion_nombre'], ST_PENDIENTE);
		      array_push($vecCamposSet,"cron_descripcion='".$camposPost['descripcion_nombre']."'");
		  } else {
		  	  $cron_crvn_id=intval($camposPost["visita_crvn_id"],10);
		  }
		  if(strlen($cron_crvn_id)==0){
			cComando::rollback();
		  	return -1;
		  }
	      array_push($vecCamposSet,"cron_crvn_id='".$cron_crvn_id."'");

		if(count($vecCamposSet)>0){
			$sql="SELECT cron_id FROM cronograma_visita C WHERE cron_pro_id='$pro_id' AND cron_tiv_id=".intval($camposPost["var_tiv_id"],10)." AND cron_tiv_id IN (".TIPO_VIS_SCR.",".TIPO_VIS_BASAL.")";
			if(strlen($cron_id)>0){
				$sql.=" AND cron_id<>'$cron_id'";
			}
			//echo($sql);
			$rVisExiste=cComando::consultar($sql);
			if($rVisExiste->cantidad()==0){
				$cron_existe=0;
			} else {
				$cron_existe=$rVisExiste->campo('cron_id',0);
			}
			if(empty($cron_id)){
				if($cron_existe==0){
					$sql="INSERT INTO cronograma_visita (cron_pro_id) VALUES ('$pro_id')";
					$status1 = cComando::ejecutar($sql, INSERT, $cron_id);
					
					if($status1==FALSE){		
						cComando::rollback();
						return -1;
					}
				} else {
					cComando::rollback();
					return -1;
				}
			}
			if(!empty($cron_id)){
				if($cron_existe==0){
					$sql="UPDATE cronograma_visita SET ".implode(",",$vecCamposSet)." WHERE cron_id='".$cron_id."'";
					$status2 = cComando::ejecutar($sql, UPDATE, $id);
					if($status2==FALSE){
						cComando::rollback();
						return -1;
					}
				} else {
					cComando::rollback();
					return -1;	
				}
			} else {
				cComando::rollback();
				return -1;
			}
		}
		cComando::commit();
		return $cron_id;
	}

	
	static function obtenerRegistro($est_id){
		$sql="SELECT PRO.pro_id, COM.com_descripcion, COM.com_titulo, CEN.cen_razon_social, INV.inv_nombre, INV.inv_apellido, PAT.emp_razon_social, PAT.emp_cuit, EST.est_titulo,EST.est_id, EPAT.epat_codigo_estudio, DIC.dic_status,DIC.dic_fecha_hora,RES.resdic_descripcion FROM proyecto PRO INNER JOIN asset ASTPRO ON (ASTPRO.ast_id=PRO.pro_ast_id) LEFT JOIN proyecto_centro PCEN ON (PRO.pro_id=PCEN.procen_pro_id) LEFT JOIN centro CEN ON (CEN.cen_id=PCEN.procen_cen_id) LEFT JOIN proyecto_patrocinador PPAT ON (PPAT.propat_pro_id=PRO.pro_id) LEFT JOIN proyecto_investigador PINV ON (PINV.proinv_pro_id=PRO.pro_id) LEFT JOIN investigador INV ON (INV.inv_id=PINV.proinv_inv_id) LEFT JOIN estudio EST ON (EST.est_id=PRO.pro_est_id) LEFT JOIN estudio_patrocinador EPAT ON (EPAT.epat_est_id=EST.est_id AND EPAT.epat_emp_id=PPAT.propat_emp_id) LEFT JOIN empresa PAT ON (PAT.emp_id=PPAT.propat_emp_id) LEFT JOIN comite COM ON (COM.com_id=PRO.pro_com_id) LEFT JOIN dictamen DIC ON (DIC.dic_pro_id=PRO.pro_id)  LEFT JOIN resultado_dictamen RES ON (RES.resdic_id=DIC.dic_resdic_id) WHERE DIC.dic_status=".ST_DIC_PUBLICADO." AND EST.est_id=$est_id  
		ORDER BY DIC.dic_fecha_hora DESC, PRO.pro_id ASC";
		return cComando::consultar($sql);
	}
	static function obtenerRegistroEstudiosAgrupamiento(){
		$sql="SELECT EST.est_id,EST.est_titulo, FM.fecha_hora as fecha_estudio FROM proyecto PRO INNER JOIN estudio EST ON (EST.est_id=PRO.pro_est_id) INNER JOIN (SELECT MAX(DF.dic_fecha_hora) fecha_hora, EF.est_id FROM estudio EF INNER JOIN proyecto PF ON (PF.pro_est_id=EF.est_id) INNER JOIN dictamen DF ON (DF.dic_pro_id=PF.pro_id AND DF.dic_status=".ST_DIC_PUBLICADO.") GROUP BY EF.est_id) as FM ON (FM.est_id=EST.est_id) INNER JOIN dictamen DIC ON (DIC.dic_pro_id=PRO.pro_id) WHERE DIC.dic_status=".ST_DIC_PUBLICADO." GROUP BY EST.est_id ORDER BY fecha_estudio DESC, EST.est_titulo ASC";
		return cComando::consultar($sql);
	}
	static function obtenerStatusProyecto($id_status)
	{
		$sql = "SELECT * FROM status_protocolo WHERE sp_id = '$id_status'";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
	static function obtenerStatusProtocoloPaciente($id_status)
	{
		$sql = "SELECT * FROM status_protocolo_paciente WHERE spp_id = '$id_status'";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
	static function obtenerComboStatus(){
		$sql="SELECT sp_id, sp_descripcion FROM status_protocolo WHERE sp_status=1 ORDER BY sp_descripcion";
		return cComando::consultar($sql);
	}
	static function obtenerCombo(){
		$sql="SELECT pro_id, pro_titulo_breve FROM protocolo ORDER BY pro_titulo_breve";
		return cComando::consultar($sql);
	}
	static function obtenerComboNotPaciente($pac_id,$vecStatus){
		$sql="SELECT pro_id, pro_titulo_breve FROM protocolo LEFT JOIN protocolo_paciente ON (pro_id=propac_pro_id AND propac_pac_id='$pac_id') WHERE propac_pro_id IS NULL AND pro_sp_id IN (".implode(",",$vecStatus).") ORDER BY pro_titulo_breve";
		return cComando::consultar($sql);
	}
	static function obtenerComboPaciente($pac_id){
		$sql="SELECT pro_id, pro_titulo_breve FROM protocolo LEFT JOIN protocolo_paciente ON (pro_id=propac_pro_id AND propac_pac_id='$pac_id') WHERE propac_pro_id IS NOT NULL ORDER BY pro_titulo_breve";
		return cComando::consultar($sql);
	}
	static function cambiarEstadoProyecto($usr_id,$fecha_hora,$pro_id,$sp_id,$texto){
		$rPerfil=cUsuario::obtenerPerfilUsuario($usr_id);
		if($rPerfil->cantidad()==0){
			return -1;
		}
		$rPro=cProtocolo::obtenerProtocolo($pro_id);
		if($rPro->cantidad()==0){
			return -1;
		}
		$estado_actual=$rPro->campo('pro_status',0);
		$cambiar=0;
		$perfil_usuario=$rPerfil->campo('rol_id',0);
		if($perfil_usuario==PERFIL_INVESTIGADOR){
			if(($estado_actual==ST_BORRADOR || $estado_actual==ST_REABIERTO) && $sp_id==ST_ENVIADO){
				$cambiar=1;
				$nuevo_estado=ST_ENVIADO;
			}
		}
		if($perfil_usuario==PERFIL_CEI || $perfil_usuario==PERFIL_CIS){
			switch($estado_actual){
				case ST_ENVIADO:
					if($sp_id==ST_APROBADO || $sp_id==ST_RECHAZADO || $sp_id==ST_REABIERTO){
						$nuevo_estado=$sp_id;
						$cambiar=1;
					}
				break;
				case ST_APROBADO:
					if($sp_id==ST_REABIERTO){
						$nuevo_estado=$sp_id;
						$cambiar=1;
					}
				break;
				case ST_REABIERTO:
					if($sp_id==ST_APROBADO || $sp_id==ST_RECHAZADO || $sp_id==ST_REABIERTO){
						$nuevo_estado=$sp_id;
						$cambiar=1;
					}
				break;
				case ST_PROCESO:
					if($sp_id==ST_APROBADO || $sp_id==ST_RECHAZADO || $sp_id==ST_REABIERTO){
						$nuevo_estado=$sp_id;
						$cambiar=1;
					}
				break;
			}
		}
		if($cambiar==1){
			if(strlen($texto)==0){
				$rSp=cProtocolo::obtenerStatusProyecto($nuevo_estado);
				if($rSp->cantidad()>0){
					$texto=$rSp->campo('sp_texto_comentario',0);
				}
			}
			$sql="INSERT INTO proyecto_log (plog_pro_id,plog_fecha_hora,plog_usr_id,plog_sp_id,plog_comentario) VALUES ('$pro_id','$fecha_hora','$usr_id','$nuevo_estado','$texto')";
			$status = cComando::ejecutar($sql, INSERT, $plog_id);
			$sql="UPDATE proyecto SET pro_status='$nuevo_estado' WHERE pro_id='$pro_id'";
			$status1 = cComando::ejecutar($sql, UPDATE, $id);
			if($status==FALSE || $status1==FALSE){
				return -1;
			} else {
				return $plog_id;
			}
		} else {
			return -1;
		}
	}
	static function eliminarProyecto($pro_id){
		if(is_numeric($pro_id)){
			$sql="UPDATE protocolo SET pro_sp_id=".ST_ELIMINAR." WHERE pro_id='$pro_id'";
			$status = cComando::ejecutar($sql, UPDATE, $id);
		}
	}
	static function eliminarVisita($cron_id){
		if(is_numeric($cron_id)){
			$sql="DELETE FROM cronograma_visita WHERE cron_id='$cron_id'";
			$status = cComando::ejecutar($sql, UPDATE, $id);
		}
	}
	static function getProyectoLog($pro_id){
		$sql="SELECT protocolo_log.*, status_protocolo.sp_descripcion FROM protocolo_log, status_protocolo WHERE plog_sp_id=sp_id AND plog_pro_id='$pro_id' ORDER BY plog_fecha_hora";
		return cComando::consultar($sql);
	}
}
?>