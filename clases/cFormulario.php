<?
incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cFormulario
{
	static function modificarEmpresa($camposPost, $emp_id, $errorVar, $form_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		array_push($vecCamposInt,"var_id_pais");
		array_push($vecCamposInt,"var_id_provincia");
		array_push($vecCamposInt,"var_id_localidad");
		array_push($vecCamposInt,"var_id_municipalidad");
		array_push($vecCamposInt,"var_id_provincia_fiscal");
		array_push($vecCamposInt,"var_id_localidad_fiscal");
		array_push($vecCamposInt,"var_id_municipalidad_fiscal");
		array_push($vecCamposInt,"var_id_parque_industrial");
		array_push($vecCamposInt,"var_tipo_planta_id");
		array_push($vecCamposInt,"var_forma_juridica_id");
		array_push($vecCamposInt,"var_rubro_id");
		array_push($vecCamposInt,"var_porcentaje_capital_extranjero");
		array_push($vecCamposInt,"var_antiguedad_rubro");
		array_push($vecCamposInt,"var_clasificacion_clanae");
		array_push($vecCamposInt,"var_prueba_acida");
		array_push($vecCamposInt,"var_endeudamiento_total");
		array_push($vecCamposInt,"var_facturacion_pesos_ultimo_ejercicio");
		array_push($vecCamposInt,"var_facturacion_pesos_penultimo_ejercicio");
		array_push($vecCamposInt,"var_facturacion_pesos_antepenultimo_ejercicio");
		array_push($vecCamposInt,"var_cantidad_empleados_linea");
		array_push($vecCamposInt,"var_cantidad_empleados_no_linea");
		array_push($vecCamposInt,"var_cantidad_empleados_invdes");
		array_push($vecCamposInt,"var_cantidad_empleados");
		array_push($vecCamposInt,"var_cantidad_ingenieros");
		array_push($vecCamposInt,"var_cantidad_tecnicos");
		array_push($vecCamposInt,"var_cantidad_otros_profesionales");
		array_push($vecCamposInt,"var_cantidad_otros_trabajadores");
		
		if($form_id==1){
			$vecCamposInsertSector=array();
			$vecCamposInsertSectorEnergias=array();
			$vecCamposInsertSectorPertenece=array();
			$vecCamposInsertRubro=array();
		}
		if($form_id==9){
			$vecCamposInsertCamara=array();
		}
		if($form_id==4){
			$vecCamposInsertCertificacion=array();
		}
		if($form_id==6){
			$vecCamposInsertVinculaciones=array();
			$vecCamposInsertFinanciamiento=array();
			$vecCamposInsertAsistenciaTecnica=array();
			$vecCamposInsertSectoresParticipar=array();
		}
		foreach($camposPost as $key => $value) {
		  if($key=="var_forma_juridica_id"){
		  	if(intval($value,10)==-1){
				$value='';
			}
		  }
		  if(substr($key,0,4)=="var_" && $key!="var_email_confirmacion" && $key!="var_clave" && $key!="var_clave_confirmacion"){
			if(in_array($key,$vecCamposInt)){
				$valor=str_replace(".","", $value);
				$valor=str_replace("$","", $valor);
				$valor=str_replace(" ","", $valor);
				$valor=str_replace(",",".", $valor);
				if($valor==''){
				  	array_push($vecCamposSet,str_replace("var_","emp_",$key)."=NULL");
				} else {
				 	array_push($vecCamposSet,str_replace("var_","emp_",$key)."='".$valor."'");				
				}
		  	} else {
				if($value=="true" || $value=="false"){
					array_push($vecCamposSet,str_replace("var_","emp_",$key)."=$value");				
				} else {
					array_push($vecCamposSet,str_replace("var_","emp_",$key)."='".$value."'");
				}
			}
		  }
			if($form_id==1){
				//se insertan los rubros o ramas secundarios del formulario 1
				if($key=='rubro_secundario_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de rubro si no, guardo com otro
						array_push($vecCamposInsertRubro,"('".$emp_id."','".($i+1)."','".(is_numeric($value[$i]) ? $value[$i] : '')."','".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
				//se insertan los sectores que abastece del formulario 1
				if($key=='sector_abastece_id_guardar'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de sector si no, guardo com otro
						array_push($vecCamposInsertSector,"('".$emp_id."','".($i+1)."',".(is_numeric($value[$i]) ? "'".$value[$i]."'" : "NULL").",'".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
				/*if($key=='sectores_abastece_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de sector si no, guardo com otro
						array_push($vecCamposInsertSector,"('".$emp_id."','".($i+1)."',".(is_numeric($value[$i]) ? "'".$value[$i]."'" : "NULL").",'".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}*/
				//se insertan los sectores que abastece de energías renovables formulario 1
				/*if($key=='sectores_abastece_energias_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de sector si no, guardo com otro
						array_push($vecCamposInsertSectorEnergias,"('".$emp_id."','".($i+1)."',".(is_numeric($value[$i]) ? "'".$value[$i]."'" : "NULL").",'".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}*/

				//se insertan los sectores que pertenece del formulario 1
				/*if($key=='sectores_pertenece_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de sector si no, guardo com otro
						array_push($vecCamposInsertSectorPertenece,"('".$emp_id."','".($i+1)."',".(is_numeric($value[$i]) ? "'".$value[$i]."'" : "NULL").",'".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}*/
			}
			if($form_id==9){
				//se insertan las cámaras a las que pertenece la empresa en formulario 3
				if($key=='camara_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de camara si no, guardo com otro
						array_push($vecCamposInsertCamara,"('".$emp_id."','".($i+1)."','".(is_numeric($value[$i]) ? $value[$i] : '')."','".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
			}
			if($form_id==4){
				//se insertan las normas de certificacion la empresa en formulario 4
				if($key=='norma_calidad'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de camara si no, guardo com otro
						array_push($vecCamposInsertCertificacion,"('".$emp_id."','".($i+1)."',".(is_numeric($camposPost['porcentaje_norma_calidad'][$i]) ? "'".$camposPost['porcentaje_norma_calidad'][$i]."'" : "NULL").",".($camposPost['norma_certificada_'.$camposPost['norma'][$i]]=='' ? "NULL" : $camposPost['norma_certificada_'.$camposPost['norma'][$i]]).",'".$value[$i]."')");
					}
				}
			}
			if($form_id==6){
				//se insertan las los campos para el formulario 6
				if($key=='vinculaciones_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de vinculacion si no, guardo com otro
						array_push($vecCamposInsertVinculaciones,"('".$emp_id."','".($i+1)."','".(is_numeric($value[$i]) ? $value[$i] : '')."','".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
				if($key=='financiamiento_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de financiamiento si no, guardo com otro
						array_push($vecCamposInsertFinanciamiento,"('".$emp_id."','".($i+1)."','".(is_numeric($value[$i]) ? $value[$i] : '')."','".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
				if($key=='asistencia_tecnica_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de asistencia tecnica si no, guardo com otro
						array_push($vecCamposInsertAsistenciaTecnica,"('".$emp_id."','".($i+1)."','".(is_numeric($value[$i]) ? $value[$i] : '')."','".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
				if($key=='sectores_participar_opcion'){
					for($i=0;$i<count($value);$i++){
						//armo el array de registros a insertar, si es numerico guardo como id de sectores_participar tecnica si no, guardo com otro
						array_push($vecCamposInsertSectoresParticipar,"('".$emp_id."','".($i+1)."','".(is_numeric($value[$i]) ? $value[$i] : '')."','".(!is_numeric($value[$i]) ? $value[$i] : '')."')");
					}
				}
			}
		}
		//cComando::autocommit(FALSE);
		if(count($vecCamposSet)>0 || $form_id==6){
			if(count($vecCamposSet)>0){
				$sql="UPDATE empresa SET ".implode(",",$vecCamposSet)." WHERE emp_id='$emp_id'";
				$status = cComando::ejecutar($sql, UPDATE, $id);
				if($status!==FALSE){
					cFormulario::guardarEstadoFormulario($form_id, !$errorVar, $emp_id);
				}
			} else {
				cFormulario::guardarEstadoFormulario($form_id, !$errorVar, $emp_id);
			}
		}
		if($form_id==1){
			$sql="DELETE FROM empresa_rubro WHERE emprub_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertRubro)>0){
				$sql="INSERT INTO empresa_rubro (emprub_emp_id, emprub_nro, emprub_rub_id, emprub_otro) VALUES ".implode(",",$vecCamposInsertRubro);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			$sql="DELETE FROM empresa_sectores_abastece WHERE esec_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertSector)>0){
				$sql="INSERT INTO empresa_sectores_abastece (esec_emp_id, esec_nro, esec_sec_id, esec_otro) VALUES ".implode(",",$vecCamposInsertSector);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			/*$sql="DELETE FROM empresa_sectores_abastece_energias WHERE esee_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertSectorEnergias)>0){
				$sql="INSERT INTO empresa_sectores_abastece_energias (esee_emp_id, esee_nro, esee_see_id, esee_otro) VALUES ".implode(",",$vecCamposInsertSectorEnergias);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}*/

			/*$sql="DELETE FROM empresa_sectores_pertenece WHERE esecper_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertSectorPertenece)>0){
				$sql="INSERT INTO empresa_sectores_pertenece (esecper_emp_id, esecper_nro, esecper_sec_id, esecper_otro) VALUES ".implode(",",$vecCamposInsertSectorPertenece);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}*/
		}
		if($form_id==9){
			$sql="DELETE FROM empresa_camara WHERE empcam_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertCamara)>0){
				$sql="INSERT INTO empresa_camara (empcam_emp_id, empcam_nro, empcam_cam_id, empcam_otro) VALUES ".implode(",",$vecCamposInsertCamara);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
		}
		if($form_id==4){
			$sql="DELETE FROM empresa_certificacion WHERE empcer_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertCertificacion)>0){
				$sql="INSERT INTO empresa_certificacion (empcer_emp_id, empcer_nro, empcer_porcentaje, empcer_certificado, empcer_norma) VALUES ".implode(",",$vecCamposInsertCertificacion);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			cFormulario::guardarEstadoFormulario($form_id, !$errorVar, $emp_id);
		}
		if($form_id==6){
			$sql="DELETE FROM empresa_asistencia_tecnica WHERE empate_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertAsistenciaTecnica)>0){
				$sql="INSERT INTO empresa_asistencia_tecnica (empate_emp_id, empate_nro, empate_ate_id, empate_otro) VALUES ".implode(",",$vecCamposInsertAsistenciaTecnica);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			$sql="DELETE FROM empresa_financiamiento WHERE empfin_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertFinanciamiento)>0){
				$sql="INSERT INTO empresa_financiamiento (empfin_emp_id, empfin_nro, empfin_fin_id, empfin_otro) VALUES ".implode(",",$vecCamposInsertFinanciamiento);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			$sql="DELETE FROM empresa_vinculaciones WHERE empvin_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertVinculaciones)>0){
				$sql="INSERT INTO empresa_vinculaciones (empvin_emp_id, empvin_nro, empvin_vin_id, empvin_otro) VALUES ".implode(",",$vecCamposInsertVinculaciones);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			$sql="DELETE FROM empresa_sectores_participar WHERE empspa_emp_id='$emp_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertSectoresParticipar)>0){
				$sql="INSERT INTO empresa_sectores_participar (empspa_emp_id, empspa_nro, empspa_spa_id, empspa_otro) VALUES ".implode(",",$vecCamposInsertSectoresParticipar);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
		}
		cFormulario::modificarEstadoEmpresa($_SESSION['usr_emp_id'], $_SESSION['id_usu']);
		/*if(!cComando::commit()){
			cComando::rollback();
		}*/
	}
	
	static function modificarComponenteProducto($camposPost, $emp_id, $errorVar,$comp_id, $prod_id, $form_id, $comp_raiz_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		//array_push($vecCamposInt,"var_ncm_id");
		array_push($vecCamposInt,"var_cantidad_unidad_producto");
		array_push($vecCamposInt,"var_tcom_id");
		array_push($vecCamposInt,"var_porcentaje_incidencia_precio_producto");
		array_push($vecCamposInt,"var_torig_id");
		array_push($vecCamposInt,"var_uni_id_producto");
			
			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","com_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","com_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","com_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","com_",$key)."='".$value."'");
					}
				}
			  }
			  
			  /*if($key=="var_ncm_id" && $value=="-1"){
				$ncm_id=cPosicionArancelaria::nuevaPosicionArancelaria($camposPost['otro_ncm'], $emp_id, ST_PENDIENTE);
				if($ncm_id>0){
					$vecCamposSet[count($vecCamposSet)-1]="com_ncm_id='".$ncm_id."'";
				} else {
					$vecCamposSet[count($vecCamposSet)-1]="com_ncm_id=NULL";
				}
			  }*/
			  if($key=="ncm_opcion"){
			  	for($i=0;$i<count($value);$i++){
					if($value[$i]!=""){
						array_push($vecCamposSet,"com_ncm='$value[$i]'");
					} else {
						array_push($vecCamposSet,"com_ncm=NULL");
					}
				}
			  }
				
			}
		    $prn_id="";
		    $man_id="";
			$es_miscelanea=0;
			if($camposPost["var_tcom_id"]=="4" || $camposPost["var_tcom_id"]=="5"){
				$es_miscelanea=1;
				$prn_id=$camposPost["misc_prn_id"];
				$man_id=$camposPost["misc_man_id"];
				$mon_id=$camposPost["misc_mon_id"];
			} else {
				if($camposPost["prod_prn_id"]=="-1"){
				  $prn_id=cProductoNormalizado::nuevoProductoNormalizado($camposPost['otro_nombre_producto'], $emp_id, ST_PENDIENTE);
				} else {
				  $prn_id=$camposPost["prod_prn_id"];
				}
				if($camposPost["prod_man_id"]=="-1"){
					$man_id=cMarcaNormalizado::nuevaMarcaNormalizado($camposPost['otro_nombre_marca'], $emp_id, ST_PENDIENTE);
				} else {
					$man_id=$camposPost["prod_man_id"];
				}
				if($prn_id!="" && $man_id!=""){
				  if($camposPost["prod_mon_id"]=="-1"){
					if(strlen(trim($camposPost['otro_nombre_modelo']))>0){
						$mon_id=cModeloNormalizado::nuevoModeloNormalizado($camposPost['otro_nombre_modelo'], $emp_id, ST_PENDIENTE, $man_id, $prn_id,"");
					} else {
						$mon_id="";
					}
				  } else {
					$mon_id=$camposPost["prod_mon_id"];
				  }
				}
			}
			//se verifica que no exista otro componente con el mismo modelo para el mismo producto
			$sql="SELECT com_id FROM componente WHERE com_prod_id='$prod_id' AND com_emp_id='$emp_id' AND com_mon_id='$mon_id'";
			if(!empty($comp_id) && is_numeric($comp_id)){
				//si se trata de modificar un componente, hay que verificar que no haya otro que no sea este
				$sql.=" AND com_id<>'$comp_id'";
			}
			$rComp=cComando::consultar($sql);
			if($rComp->cantidad()>0){
				//no se debe poder dejar guardar el componente
				return -2;
			}


			if($mon_id!="" && $mon_id>0){
				array_push($vecCamposSet,"com_mon_id='".$mon_id."'");
			} else {
				array_push($vecCamposSet,"com_mon_id=NULL");
			}
			$estado=ST_INCOMPLETO;
			if(empty($comp_id)){
				$sql="INSERT INTO componente (com_emp_id,com_prod_id,com_status,com_raiz_id) VALUES ('$emp_id','$prod_id',".$estado.",".(empty($comp_raiz_id) ? "NULL":"'".$comp_raiz_id."'").")";
				$status1 = cComando::ejecutar($sql, INSERT, $comp_id);
				if($status1==FALSE){
					$fallo=true;
				}
			}
			if($errorVar!=1){
				$estado=ST_ACTIVO;
			}
			if(!empty($comp_id)){
				$sql="UPDATE componente SET ".implode(",",$vecCamposSet).",com_status=".$estado." WHERE com_prod_id='".$prod_id."' AND com_emp_id='$emp_id' AND com_id='$comp_id'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}
				
			if($fallo){
				return -1;
			} else {
				cProducto::anularCI($prod_id);
				cProducto::cerrarComponentes($prod_id,0);
				if($es_miscelanea==1){
					//en este caso el costo del componente se calcula utilizando el precio unitario del producto por el porcentaje de incidencia del misceláneo
					$sql="SELECT epr_precio_unitario FROM empresa_producto WHERE epr_prod_id='$prod_id' AND epr_precio_unitario IS NOT NULL";
					$rProd=cComando::consultar($sql);
					if($rProd->cantidad()>0){
						cFormulario::calcularCostoComponenteMiscelanea($rProd->campo('epr_precio_unitario',0),$camposPost["var_porcentaje_incidencia_precio_producto"],$mon_id,$emp_id);
					}
				} else {
					$sql="SELECT cpr_precio_unitario FROM compras_componente WHERE cpr_mon_id='$mon_id' AND cpr_emp_id='$emp_id' AND cpr_precio_unitario IS NOT NULL";
					$rCpr=cComando::consultar($sql);
					if($rCpr->cantidad()>0){
						//se calcular el costo del componente para cada registro del componente que tenga este normalizado para esta empresa
						cFormulario::calcularCostoComponente($rCpr->campo('cpr_precio_unitario',0),$mon_id,$emp_id);
					}
				}
				return $comp_id;
			}
	}
	static function modificarComponenteServicio($camposPost, $emp_id, $errorVar,$comp_id, $serv_id, $form_id, $comp_raiz_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		//array_push($vecCamposInt,"var_ncm_id");
		array_push($vecCamposInt,"var_cantidad_unidad_producto");
		array_push($vecCamposInt,"var_tcom_id");
		array_push($vecCamposInt,"var_porcentaje_incidencia_precio_producto");
		array_push($vecCamposInt,"var_torig_id");
		array_push($vecCamposInt,"var_uni_id_producto");
			
			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","coms_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","coms_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","coms_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","coms_",$key)."='".$value."'");
					}
				}
			  }
			  
			  /*if($key=="var_ncm_id" && $value=="-1"){
				$ncm_id=cPosicionArancelaria::nuevaPosicionArancelaria($camposPost['otro_ncm'], $emp_id, ST_PENDIENTE);
				if($ncm_id>0){
					$vecCamposSet[count($vecCamposSet)-1]="com_ncm_id='".$ncm_id."'";
				} else {
					$vecCamposSet[count($vecCamposSet)-1]="com_ncm_id=NULL";
				}
			  }*/
			  if($key=="ncm_opcion"){
			  	for($i=0;$i<count($value);$i++){
					if($value[$i]!=""){
						array_push($vecCamposSet,"coms_ncm='$value[$i]'");
					} else {
						array_push($vecCamposSet,"coms_ncm=NULL");
					}
				}
			  }
				
			}
		    $prn_id="";
		    $man_id="";
			$es_miscelanea=0;
			if($camposPost["var_tcom_id"]=="4" || $camposPost["var_tcom_id"]=="5"){
				$es_miscelanea=1;
				$prn_id=$camposPost["misc_prn_id"];
				$man_id=$camposPost["misc_man_id"];
				$mon_id=$camposPost["misc_mon_id"];
			} else {
				if($camposPost["prod_prn_id"]=="-1"){
				  $prn_id=cProductoNormalizado::nuevoProductoNormalizado($camposPost['otro_nombre_producto'], $emp_id, ST_PENDIENTE);
				} else {
				  $prn_id=$camposPost["prod_prn_id"];
				}
				if($camposPost["prod_man_id"]=="-1"){
					$man_id=cMarcaNormalizado::nuevaMarcaNormalizado($camposPost['otro_nombre_marca'], $emp_id, ST_PENDIENTE);
				} else {
					$man_id=$camposPost["prod_man_id"];
				}
				if($prn_id!="" && $man_id!=""){
				  if($camposPost["prod_mon_id"]=="-1"){
					if(strlen(trim($camposPost['otro_nombre_modelo']))>0){
						$mon_id=cModeloNormalizado::nuevoModeloNormalizado($camposPost['otro_nombre_modelo'], $emp_id, ST_PENDIENTE, $man_id, $prn_id,"");
					} else {
						$mon_id="";
					}
				  } else {
					$mon_id=$camposPost["prod_mon_id"];
				  }
				}
			}
			//se verifica que no exista otro componente con el mismo modelo para el mismo servicio
			$sql="SELECT coms_id FROM componente_servicio WHERE coms_serv_id='$serv_id' AND coms_emp_id='$emp_id' AND coms_mon_id='$mon_id'";
			if(!empty($comp_id) && is_numeric($comp_id)){
				//si se trata de modificar un componente, hay que verificar que no haya otro que no sea este
				$sql.=" AND coms_id<>'$comp_id'";
			}
			$rComp=cComando::consultar($sql);
			if($rComp->cantidad()>0){
				//no se debe poder dejar guardar el componente
				return -2;
			}


			if($mon_id!="" && $mon_id>0){
				array_push($vecCamposSet,"coms_mon_id='".$mon_id."'");
			} else {
				array_push($vecCamposSet,"coms_mon_id=NULL");
			}
			$estado=ST_INCOMPLETO;
			if(empty($comp_id)){
				$sql="INSERT INTO componente_servicio (coms_emp_id,coms_serv_id,coms_status,coms_raiz_id) VALUES ('$emp_id','$serv_id',".$estado.",".(empty($comp_raiz_id) ? "NULL":"'".$comp_raiz_id."'").")";
				$status1 = cComando::ejecutar($sql, INSERT, $comp_id);
				if($status1==FALSE){
					$fallo=true;
				}
			}
			if($errorVar!=1){
				$estado=ST_ACTIVO;
			}
			if(!empty($comp_id)){
				$sql="UPDATE componente_servicio SET ".implode(",",$vecCamposSet).",coms_status=".$estado." WHERE coms_serv_id='".$serv_id."' AND coms_emp_id='$emp_id' AND coms_id='$comp_id'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}
				
			if($fallo){
				return -1;
			} else {
				cServicio::anularCI($serv_id);
				cServicio::cerrarComponentes($serv_id,0);
				if($es_miscelanea==1){
					//en este caso el costo del componente se calcula utilizando el precio unitario del servicio por el porcentaje de incidencia del misceláneo
					$sql="SELECT ese_precio_unitario FROM empresa_servicio WHERE ese_serv_id='$serv_id' AND ese_precio_unitario IS NOT NULL";
					$rProd=cComando::consultar($sql);
					if($rProd->cantidad()>0){
						cFormulario::calcularCostoComponenteMiscelaneaServicio($rProd->campo('ese_precio_unitario',0),$camposPost["var_porcentaje_incidencia_precio_producto"],$mon_id,$emp_id);
					}
				} else {
					$sql="SELECT cpr_precio_unitario FROM compras_componente WHERE cpr_mon_id='$mon_id' AND cpr_emp_id='$emp_id' AND cpr_precio_unitario IS NOT NULL";
					$rCpr=cComando::consultar($sql);
					if($rCpr->cantidad()>0){
						//se calcular el costo del componente para cada registro del componente que tenga este normalizado para esta empresa
						cFormulario::calcularCostoComponenteServicio($rCpr->campo('cpr_precio_unitario',0),$mon_id,$emp_id);
					}
				}
				return $comp_id;
			}
	}

	static function modificarCompraComponente($camposPost, $errorVar,$mon_id, $form_id,$emp_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		array_push($vecCamposInt,"var_cantidad_unidad_producto");
		array_push($vecCamposInt,"var_torigcom_id");
		array_push($vecCamposInt,"var_id_pais");
		array_push($vecCamposInt,"var_precio_unitario");
		array_push($vecCamposInt,"var_uni_id");
		array_push($vecCamposInt,"var_compras_uni_id");
		array_push($vecCamposInt,"var_cantidad_compras_uno_anterior");
		array_push($vecCamposInt,"var_cantidad_compras_uno_posterior");
		array_push($vecCamposInt,"var_cantidad_compras_anio_actual");
		array_push($vecCamposInt,"var_cantidad_compras_anio_actual");
		$vecCamposInsertProductoProveedor=array();
		$vecCamposInsertProductoEmbarque=array();
			$precio_unitario=0;
			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","cpr_",$key)."=NULL");
					} else {
						if($key=="var_precio_unitario"){
							$precio_unitario=$value;
						}
						array_push($vecCamposSet,str_replace("var_","cpr_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","cpr_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","cpr_",$key)."='".$value."'");
					}
				}
			  }
			  
				
			}
			$fallo=false;
			$estado=ST_INCOMPLETO;
			if($errorVar!=1){
				$estado=ST_ACTIVO;
			}
			$sql="INSERT INTO compras_componente (cpr_mon_id,cpr_emp_id,cpr_status) VALUES ('$mon_id','$emp_id',".$estado.") ON DUPLICATE KEY UPDATE cpr_status='$estado' ";
			$status1 = cComando::ejecutar($sql, INSERT, $id);
			if($status1==FALSE){
				$fallo=true;
			}
			$sql="UPDATE compras_componente SET ".implode(",",$vecCamposSet).",cpr_status=".$estado." WHERE cpr_mon_id='".$mon_id."' AND cpr_emp_id='$emp_id'";
			$status2 = cComando::ejecutar($sql, UPDATE, $id);
			if($status2==FALSE){
				$fallo=true;
			} else {
					cFormulario::calcularCostoComponente($precio_unitario,$mon_id,$emp_id);
					cFormulario::calcularCostoComponenteServicio($precio_unitario,$mon_id,$emp_id);
			}
			if(!$fallo){
				foreach($camposPost as $key => $value) {
					//se insertan los proveedores
					if($key=='razon_social_proveedores_valor'){
						for($i=0;$i<count($value);$i++){
							/*if($camposPost['var_torigcom_id']==1){
								$sql="SELECT IFNULL(com_ncm, coms_ncm) ncm, IFNULL(com_caracteristicas_tecnicas, coms_caracteristicas_tecnicas) caracteristicas_tecnicas, mon_id, mon_prn_id prn_id, mon_man_id man_id,  mon_descripcion, uem_emp_id, epr_prod_id, epr_emp_id, emp_id, IFNULL(com_emp_id, coms_emp_id) empresa_id, epr_emp_id FROM modelo_normalizado LEFT JOIN componente ON (com_mon_id=mon_id) LEFT JOIN componente_servicio ON (coms_mon_id=mon_id) LEFT JOIN empresa ON (emp_cuit='".$camposPost['cuit_proveedor_valor'][$i]."' ) LEFT JOIN empresa_producto ON (emp_id=epr_emp_id AND epr_mon_id=mon_id) LEFT JOIN user_empresa ON (uem_emp_id=emp_id) WHERE mon_id='$mon_id' AND (com_emp_id='$emp_id' OR coms_emp_id='$emp_id') AND emp_id IS NOT NULL ";
								$sql.=" GROUP BY mon_id";
								$rMon=cComando::consultar($sql);
							}*/
							//armo el array de registros a insertar
							array_push($vecCamposInsertProductoProveedor,"('".$mon_id."','".($i+1)."','".$emp_id."','".$value[$i]."','".($camposPost['var_torigcom_id']==1 ? $camposPost['cuit_proveedor_valor'][$i] : 0)."','".$camposPost['apellido_proveedor_valor'][$i]."','".$camposPost['nombre_proveedor_valor'][$i]."','".$camposPost['telefono_proveedor_valor'][$i]."','".$camposPost['email_proveedor_valor'][$i]."')");
							if($camposPost['var_torigcom_id']==1){
								//si es nacional, verificar si existe el cuit de la empresa.
								//si existe, entonces agregar un producto nuevo
								//si no existe, agregar la empresa (sin usuario) y un producto nuevo.
								if(validarCUIT($camposPost['cuit_proveedor_valor'][$i])){
									$empresa_proveedor=cUsuario::insertarProveedor($camposPost['cuit_proveedor_valor'][$i], $value[$i], ST_PENDIENTE,$camposPost['nombre_proveedor_valor'][$i],$camposPost['apellido_proveedor_valor'][$i],$camposPost['email_proveedor_valor'][$i],$camposPost['telefono_proveedor_valor'][$i]);
									$sql="SELECT IFNULL(com_ncm, coms_ncm) ncm, IFNULL(com_caracteristicas_tecnicas, coms_caracteristicas_tecnicas) caracteristicas_tecnicas, mon_id, mon_prn_id prn_id, mon_man_id man_id,  mon_descripcion, uem_emp_id, epr_prod_id, epr_emp_id, emp_id, IFNULL(com_emp_id, coms_emp_id) empresa_id, epr_emp_id FROM modelo_normalizado LEFT JOIN componente ON (com_mon_id=mon_id) LEFT JOIN componente_servicio ON (coms_mon_id=mon_id) LEFT JOIN empresa ON (emp_cuit='".$camposPost['cuit_proveedor_valor'][$i]."' ) LEFT JOIN empresa_producto ON (emp_id=epr_emp_id AND epr_mon_id=mon_id) LEFT JOIN user_empresa ON (uem_emp_id=emp_id) WHERE mon_id='$mon_id' AND (com_emp_id='$emp_id' OR coms_emp_id='$emp_id') AND emp_id IS NOT NULL ";
									$sql.=" GROUP BY mon_id";
									$rMon=cComando::consultar($sql);
									if($empresa_proveedor!=-1){
										if($rMon->cantidad()>0){
											//if(is_null($rMon->campo('uem_emp_id',0)) || is_null($rMon->campo('empresa_id',0))){
												if($rMon->campo('epr_emp_id',0)!=$empresa_proveedor){
													//si la empresa es diferente a la que tiene asignado el producto, se crea un nuevo producto
													$producto_id="";
												} else {
													//se modifica el producto existente
													$producto_id=$rMon->campo('epr_prod_id',0);
												}
												if(($producto_id!="" && is_null($rMon->campo('uem_emp_id',0))) || $producto_id==""){
													//Si el producto no existe para el proveedor, se agrega, si existe, solo se modifica si el proveedor no está registrado. Si el proveedor está registrado y ya tiene el producto, no se modifica.
													cFormulario::modificarProductoEmpresa(array("prod_prn_id"=>$rMon->campo('prn_id',0),"prod_man_id"=>$rMon->campo('man_id',0),"prod_mon_id"=>$rMon->campo('mon_id',0),"var_descripcion"=>$rMon->campo('caracteristicas_tecnicas',0),"epr_ncm"=>$rMon->campo('ncm',0),"otro_nombre_modelo"=>$rMon->campo('mon_descripcion',0)), $empresa_proveedor, 0,$producto_id, "");
												}
											//}
										}
									}
								}
							}
						}
					}
					if($key=='fecha_embarque_valor'){
						for($i=0;$i<count($value);$i++){
							//armo el array de registros a insertar
							if(strstr(",",$camposPost['cantidad_embarque_valor'][$i])){
								$valor_cantidad=str_replace(".","", $camposPost['cantidad_embarque_valor'][$i]);
							} else {
								$valor_cantidad=$camposPost['cantidad_embarque_valor'][$i];
							}
							$valor_cantidad=str_replace("$","", $valor_cantidad);
							$valor_cantidad=str_replace(" ","", $valor_cantidad);
							$valor_cantidad=str_replace(",",".", $valor_cantidad);

							array_push($vecCamposInsertProductoEmbarque,"('".$mon_id."','".($i+1)."','".$emp_id."','".$value[$i]."','".$valor_cantidad."')");
						}
					}
				}
			}
			$status3=true;
			$status4=true;
			$sql="DELETE FROM compras_componente_proveedores WHERE cprpro_mon_id='$mon_id' AND cprpro_emp_id='$emp_id'";
			$status3 = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertProductoProveedor)>0){
				$sql="INSERT INTO compras_componente_proveedores (cprpro_mon_id,cprpro_nro,cprpro_emp_id,cprpro_razon_social,cprpro_cuit,cprpro_apellido,cprpro_nombre,cprpro_telefono,cprpro_email) VALUES ".implode(",",$vecCamposInsertProductoProveedor);
				$status3 = cComando::ejecutar($sql, INSERT, $id);
			}
			if($status3==FALSE){
				$fallo=true;
			}
			$sql="DELETE FROM compras_componente_embarques WHERE cpremb_mon_id='$mon_id' AND cpremb_emp_id='$emp_id'";
			$status4 = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertProductoEmbarque)>0){
				$sql="INSERT INTO compras_componente_embarques (cpremb_mon_id,cpremb_nro,cpremb_emp_id,cpremb_fecha,cpremb_cantidad) VALUES ".implode(",",$vecCamposInsertProductoEmbarque);
				$status4 = cComando::ejecutar($sql, INSERT, $id);
			}
			if($status4==FALSE){
				$fallo=true;
			}
			if($fallo){
				return -1;
			} else {
				//calcula el CI del producto si están cargadas todas las compras de todos los componentes
				cProducto::cerrarCompras($emp_id);
				cServicio::cerrarCompras($emp_id);
				return $mon_id;
			}
	}

	static function modificarProcesoProducto($camposPost, $emp_id, $errorVar,$proceso_id, $prod_id, $form_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		array_push($vecCamposInt,"var_tpro_id");
		array_push($vecCamposInt,"var_prt_id");
		array_push($vecCamposInt,"var_es_ensamblado");
		array_push($vecCamposInt,"var_es_mano_obra");
		array_push($vecCamposInt,"var_torigcom_id");
		array_push($vecCamposInt,"var_id_pais");
		array_push($vecCamposInt,"var_precio_unitario");
		array_push($vecCamposInt,"var_nom_id");

		$vecCamposInsertCertificacion=array();
		$vecCamposInsertComponentes=array();
		$vecCamposInsertProductoProveedor=array();
			
			foreach($camposPost as $key => $value) {
				  if(substr($key,0,4)=="var_" && substr($key,0,4)!="var_nom_id"){
						if(in_array($key,$vecCamposInt)){
							$value=str_replace(".","", $value);
							$value=str_replace("$","", $value);
							$value=str_replace(" ","", $value);
							$value=str_replace(",",".", $value);
							if($value==''){
								array_push($vecCamposSet,str_replace("var_","prp_",$key)."=NULL");
							} else {
								array_push($vecCamposSet,str_replace("var_","prp_",$key)."='".$value."'");
							}
						} else {
							if($value=="true" || $value=="false"){
								array_push($vecCamposSet,str_replace("var_","prp_",$key)."=$value");				
							} else {
								array_push($vecCamposSet,str_replace("var_","prp_",$key)."='".$value."'");
							}
						}
				  }
				  //se insertan las normas de certificacion

			  
			}
			$estado=ST_INCOMPLETO;
			if(empty($proceso_id)){
				$sql="INSERT INTO proceso_productivo (prp_prod_id,prp_status) VALUES ('$prod_id',".$estado.")";
				$status1 = cComando::ejecutar($sql, INSERT, $proceso_id);
				if($status1==FALSE){
					$fallo=true;
				}
			}
			if($errorVar!=1){
				$estado=ST_ACTIVO;
			}
			if(strlen($camposPost['var_nom_id'])>0 && $camposPost['var_nom_id']>0){
				$nom_id=$camposPost['var_nom_id'];
			}
			if($camposPost['var_nom_id']<=0 && strlen($camposPost['var_nom_otro'])>0){
				//si se eligió un nombre no normalizado
				$sql="INSERT INTO nombre_servicio (nom_descripcion, nom_status) VALUES ('".$camposPost['var_nom_otro']."',3)";
				$statusServicio = cComando::ejecutar($sql, INSERT, $nom_id);
			}
			array_push($vecCamposSet,"prp_nom_id='".$nom_id."'");
			if(!empty($proceso_id)){
				$sql="UPDATE proceso_productivo SET ".implode(",",$vecCamposSet).",prp_status=".$estado." WHERE prp_prod_id='".$prod_id."' AND prp_id='$proceso_id'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}
			
			
			for($i=0;$i<count($camposPost["componentes_proceso_opcion"]);$i++){
				array_push($vecCamposInsertComponentes,"('".$proceso_id."','".($i+1)."','".(is_numeric($camposPost['componentes_proceso_opcion'][$i]) ? $camposPost['componentes_proceso_opcion'][$i] : '')."','".(!is_numeric($camposPost['componentes_proceso_opcion'][$i]) ? $camposPost['componentes_proceso_opcion'][$i] : '')."')");
			}

			for($i=0;$i<count($camposPost["norma_calidad"]);$i++){
				  //armo el array de registros a insertar, si es numerico guardo como id si no, guardo com otro
				  array_push($vecCamposInsertCertificacion,"('".$proceso_id."','".($i+1)."',".(is_numeric($camposPost['porcentaje_norma_calidad'][$i]) ? "'".$camposPost['porcentaje_norma_calidad'][$i]."'" : "NULL").",".($camposPost['norma_certificada_'.$camposPost['norma'][$i]]=='' ? "NULL" : $camposPost['norma_certificada_'.$camposPost['norma'][$i]]).",'".$camposPost["norma_calidad"][$i]."')");
			}
			if($camposPost['var_prt_id']==2){
				//es externo
				for($i=0;$i<count($camposPost["razon_social_proveedores_valor"]);$i++){
					//armo el array de registros a insertar
					array_push($vecCamposInsertProductoProveedor,"('".$proceso_id."','".($i+1)."','".$prod_id."','".$camposPost["razon_social_proveedores_valor"][$i]."','".($camposPost['var_torigcom_id']==1 ? $camposPost['cuit_proveedor_valor'][$i] : 0)."','".$camposPost['apellido_proveedor_valor'][$i]."','".$camposPost['nombre_proveedor_valor'][$i]."','".$camposPost['telefono_proveedor_valor'][$i]."','".$camposPost['email_proveedor_valor'][$i]."')");
					if($camposPost['var_torigcom_id']==1){
						//si es nacional, verificar si existe el cuit de la empresa.
						//si existe, entonces agregar un servicio nuevo
						//si no existe, agregar la empresa (sin usuario) y un servicio nuevo.
						if(validarCUIT($camposPost['cuit_proveedor_valor'][$i])){
							$empresa_proveedor=cUsuario::insertarProveedor($camposPost['cuit_proveedor_valor'][$i], $camposPost["razon_social_proveedores_valor"][$i], ST_PENDIENTE,$camposPost['nombre_proveedor_valor'][$i],$camposPost['apellido_proveedor_valor'][$i],$camposPost['email_proveedor_valor'][$i],$camposPost['telefono_proveedor_valor'][$i]);
							if($empresa_proveedor!=-1){
								if($camposPost['var_prt_id']==2){
									//si esl proceso es externo
									if($nom_id>0){
										$rNom=cNombreServicio::obtenerNombrePorId($nom_id);
										if($rNom->cantidad()>0){
											if($rNom->campo('nom_status',0)==ST_ACTIVO){
												//si son los servicios ensamblaje de góndola, ensamblaje de buje o mecanizado de buje. Incluso cualquiera destinado a tal fin que en el futuro tenga status activo
												//se da de alta el servicio si no existe otro con el mismo nombre
												$sql="SELECT ese_serv_id FROM empresa_servicio INNER JOIN empresa ON (emp_id='".$empresa_proveedor."' AND ese_emp_id=emp_id AND ese_nom_id='".$camposPost['var_nom_id']."')";
												$rServ=cComando::consultar($sql);
												if($rServ->cantidad()==0){
													//solo agrega el servicio o se modifica si no existe usuario para la empresa que lo provee en el sistema o si el servicio nunca fue agregado
													cFormulario::modificarServicioEmpresa(array("var_nom_id"=>$nom_id,"var_act_id"=>32), $empresa_proveedor, $errorVar,"", "");
												}
											}
										}
									}
								}//var_prt_id==2
							}
						}
					}
				}
			}			

			$sql="DELETE FROM proceso_productivo_certificacion WHERE prpcer_prp_id='$proceso_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertCertificacion)>0){
				$sql="INSERT INTO proceso_productivo_certificacion (prpcer_prp_id, prpcer_nro, prpcer_porcentaje, prpcer_certificado, prpcer_norma) VALUES ".implode(",",$vecCamposInsertCertificacion);
				$statusNormas = cComando::ejecutar($sql, INSERT, $id);
				if($statusNormas==FALSE){
					$fallo=true;
				}
			}
			$sql="DELETE FROM proceso_productivo_componente WHERE prpcom_prp_id='$proceso_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertComponentes)>0 && $camposPost['var_es_mano_obra']<1){
				$sql="INSERT INTO proceso_productivo_componente (prpcom_prp_id, prpcom_nro, prpcom_com_id, prpcom_otro) VALUES ".implode(",",$vecCamposInsertComponentes);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			
			if($camposPost['var_prt_id']==2){
				$sql="DELETE FROM compras_proceso_proveedores WHERE prppro_prp_id='$proceso_id' AND prppro_prod_id='$prod_id'";
				$status = cComando::ejecutar($sql, DELETE, $id);
				if(count($vecCamposInsertProductoProveedor)>0){
					$sql="INSERT INTO compras_proceso_proveedores (prppro_prp_id,prppro_nro,prppro_prod_id,prppro_razon_social,prppro_cuit,prppro_apellido,prppro_nombre,prppro_telefono,prppro_email) VALUES ".implode(",",$vecCamposInsertProductoProveedor);
					$statusPro = cComando::ejecutar($sql, INSERT, $id);
					if($statusPro==FALSE){
						$fallo=true;
					}
				}
				if($status==FALSE){
					$fallo=true;
				}
			}
				
			if($fallo){
				return -1;
			} else {
				cProducto::cerrarProcesos($prod_id,0);
				return $proceso_id;
			}
	}

	static function modificarProcesoServicio($camposPost, $emp_id, $errorVar,$proceso_id, $serv_id, $form_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		array_push($vecCamposInt,"var_tpro_id");
		array_push($vecCamposInt,"var_prt_id");
		array_push($vecCamposInt,"var_es_ensamblado");
		array_push($vecCamposInt,"var_es_mano_obra");
		array_push($vecCamposInt,"var_torigcom_id");
		array_push($vecCamposInt,"var_id_pais");
		array_push($vecCamposInt,"var_precio_unitario");
		array_push($vecCamposInt,"var_nom_id");

		$vecCamposInsertCertificacion=array();
		$vecCamposInsertComponentes=array();
		$vecCamposInsertProductoProveedor=array();
			
			foreach($camposPost as $key => $value) {
				  if(substr($key,0,4)=="var_" && substr($key,0,4)!="var_nom_id"){
						if(in_array($key,$vecCamposInt)){
							$value=str_replace(".","", $value);
							$value=str_replace("$","", $value);
							$value=str_replace(" ","", $value);
							$value=str_replace(",",".", $value);
							if($value==''){
								array_push($vecCamposSet,str_replace("var_","prps_",$key)."=NULL");
							} else {
								array_push($vecCamposSet,str_replace("var_","prps_",$key)."='".$value."'");
							}
						} else {
							if($value=="true" || $value=="false"){
								array_push($vecCamposSet,str_replace("var_","prps_",$key)."=$value");				
							} else {
								array_push($vecCamposSet,str_replace("var_","prps_",$key)."='".$value."'");
							}
						}
				  }
				  //se insertan las normas de certificacion

			  
			}
			$estado=ST_INCOMPLETO;
			if(empty($proceso_id)){
				$sql="INSERT INTO proceso_productivo_servicio (prps_serv_id,prps_status) VALUES ('$serv_id',".$estado.")";
				$status1 = cComando::ejecutar($sql, INSERT, $proceso_id);
				if($status1==FALSE){
					$fallo=true;
				}
			}
			if($errorVar!=1){
				$estado=ST_ACTIVO;
			}
			
			if(strlen($camposPost['var_nom_id'])>0 && $camposPost['var_nom_id']>0){
				$nom_id=$camposPost['var_nom_id'];
			}
			if($camposPost['var_nom_id']<=0 && strlen($camposPost['var_nom_otro'])>0){
				//si se eligió un nombre no normalizado
				$sql="INSERT INTO nombre_servicio (nom_descripcion, nom_status) VALUES ('".$camposPost['var_nom_otro']."',3)";
				$statusServicio = cComando::ejecutar($sql, INSERT, $nom_id);
			}
			array_push($vecCamposSet,"prps_nom_id='".$nom_id."'");
			if(!empty($proceso_id)){
				$sql="UPDATE proceso_productivo_servicio SET ".implode(",",$vecCamposSet).",prps_status=".$estado." WHERE prps_serv_id='".$serv_id."' AND prps_id='$proceso_id'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}
			
			
			for($i=0;$i<count($camposPost["componentes_proceso_opcion"]);$i++){
				array_push($vecCamposInsertComponentes,"('".$proceso_id."','".($i+1)."','".(is_numeric($camposPost['componentes_proceso_opcion'][$i]) ? $camposPost['componentes_proceso_opcion'][$i] : '')."','".(!is_numeric($camposPost['componentes_proceso_opcion'][$i]) ? $camposPost['componentes_proceso_opcion'][$i] : '')."')");
			}

			for($i=0;$i<count($camposPost["norma_calidad"]);$i++){
				  //armo el array de registros a insertar, si es numerico guardo como id si no, guardo com otro
				  array_push($vecCamposInsertCertificacion,"('".$proceso_id."','".($i+1)."',".(is_numeric($camposPost['porcentaje_norma_calidad'][$i]) ? "'".$camposPost['porcentaje_norma_calidad'][$i]."'" : "NULL").",".($camposPost['norma_certificada_'.$camposPost['norma'][$i]]=='' ? "NULL" : $camposPost['norma_certificada_'.$camposPost['norma'][$i]]).",'".$camposPost["norma_calidad"][$i]."')");
			}
			if($camposPost['var_prt_id']==2){
				//es externo
				for($i=0;$i<count($camposPost["razon_social_proveedores_valor"]);$i++){
					//armo el array de registros a insertar
					array_push($vecCamposInsertProductoProveedor,"('".$proceso_id."','".($i+1)."','".$serv_id."','".$camposPost["razon_social_proveedores_valor"][$i]."','".($camposPost['var_torigcom_id']==1 ? $camposPost['cuit_proveedor_valor'][$i] : 0)."','".$camposPost['apellido_proveedor_valor'][$i]."','".$camposPost['nombre_proveedor_valor'][$i]."','".$camposPost['telefono_proveedor_valor'][$i]."','".$camposPost['email_proveedor_valor'][$i]."')");		
					if($camposPost['var_torigcom_id']==1){
						//si es nacional, verificar si existe el cuit de la empresa.
						//si no existe, agregar la empresa (sin usuario) y un producto nuevo.
						if(validarCUIT($camposPost['cuit_proveedor_valor'][$i])){
							$empresa_proveedor=cUsuario::insertarProveedor($camposPost['cuit_proveedor_valor'][$i], $camposPost["razon_social_proveedores_valor"][$i], ST_PENDIENTE,$camposPost['nombre_proveedor_valor'][$i],$camposPost['apellido_proveedor_valor'][$i],$camposPost['email_proveedor_valor'][$i],$camposPost['telefono_proveedor_valor'][$i]);
							if($empresa_proveedor!=-1){
								if($camposPost['var_prt_id']==2){
									//si es proceso es externo
									if($nom_id>0){
										//se da de alta el servicio si no existe otro con el mismo nombre
										$sql="SELECT ese_serv_id FROM empresa_servicio INNER JOIN empresa ON (emp_id='".$empresa_proveedor."' AND ese_emp_id=emp_id AND ese_nom_id='".$camposPost['var_nom_id']."')";
										$rServ=cComando::consultar($sql);
										if($rServ->cantidad()==0){
											//solo agrega el servicio o se modifica si no existe usuario para la empresa que lo provee en el sistema o si el servicio nunca fue agregado
											cFormulario::modificarServicioEmpresa(array("var_nom_id"=>$nom_id,"var_act_id"=>32), $empresa_proveedor, $errorVar,"", "");
										}
									}
								}//var_prt_id==2
							}
						}
					}
				}
			}			

			$sql="DELETE FROM proceso_productivo_servicio_certificacion WHERE prpscer_prps_id='$proceso_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertCertificacion)>0){
				$sql="INSERT INTO proceso_productivo_servicio_certificacion (prpscer_prps_id, prpscer_nro, prpscer_porcentaje, prpscer_certificado, prpscer_norma) VALUES ".implode(",",$vecCamposInsertCertificacion);
				$statusNormas = cComando::ejecutar($sql, INSERT, $id);
				if($statusNormas==FALSE){
					$fallo=true;
				}
			}
			$sql="DELETE FROM proceso_productivo_servicio_componente WHERE prpscom_prps_id='$proceso_id'";
			$status = cComando::ejecutar($sql, DELETE, $id);
			if(count($vecCamposInsertComponentes)>0 && $camposPost['var_es_mano_obra']<1){
				$sql="INSERT INTO proceso_productivo_servicio_componente (prpscom_prps_id, prpscom_nro, prpscom_coms_id, prpscom_otro) VALUES ".implode(",",$vecCamposInsertComponentes);
				$status = cComando::ejecutar($sql, INSERT, $id);
			}
			
			if($camposPost['var_prt_id']==2){
				$sql="DELETE FROM compras_proceso_servicio_proveedores WHERE prpspro_prps_id='$proceso_id' AND prpspro_serv_id='$serv_id'";
				$status = cComando::ejecutar($sql, DELETE, $id);
				if(count($vecCamposInsertProductoProveedor)>0){
					$sql="INSERT INTO compras_proceso_servicio_proveedores (prpspro_prps_id,prpspro_nro,prpspro_serv_id,prpspro_razon_social,prpspro_cuit,prpspro_apellido,prpspro_nombre,prpspro_telefono,prpspro_email) VALUES ".implode(",",$vecCamposInsertProductoProveedor);
					$statusPro = cComando::ejecutar($sql, INSERT, $id);
					if($statusPro==FALSE){
						$fallo=true;
					}
				}
				if($status==FALSE){
					$fallo=true;
				}
			}
				
			if($fallo){
				return -1;
			} else {
				cServicio::cerrarProcesos($serv_id,0);
				return $proceso_id;
			}
	}



	static function modificarDictamen($camposPost, $pro_id, $dic_id, $usr_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecDocumentos=array();
		array_push($vecCamposInt,"var_resdic_id");
		array_push($vecCamposInt,"var_subroga_institucion");

		$vecCamposInsertDocumentos=array();

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","dic_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","dic_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","dic_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","dic_",$key)."='".$value."'");
					}
				}
			  }
			  		
			}
		  
		  if(strlen($camposPost['tipi_id'])>0){
		  	$sql="UPDATE proyecto SET pro_tipi_id='".$camposPost['tipi_id']."' WHERE pro_id='$pro_id'";
			$statusPro = cComando::ejecutar($sql, UPDATE, $id);
		  }
		if(count($vecCamposSet)>0){
			if(empty($dic_id)){
				$sql="INSERT INTO dictamen (dic_usr_id,dic_status,dic_pro_id) VALUES ('$usr_id',".ST_DIC_BORRADOR.",'".$pro_id."')";
				$status1 = cComando::ejecutar($sql, INSERT, $dic_id);
				if($status1==FALSE){
					$fallo=true;
				} else {
					cDictamen::cambiarEstadoDictamen($usr_id,date("Y-m-d H:i:s"),$dic_id,$pro_id,ST_DIC_BORRADOR,"");
				}
			}
			if(!empty($dic_id)){
				$sql="UPDATE dictamen SET ".implode(",",$vecCamposSet)." WHERE dic_id='".$dic_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
				  //se obtienen los documentos maestros
				  $rDocm=cDictamen::obtenerDocumentos(ST_ACTIVO, "");
				  for($i=0;$i<$rDocm->cantidad();$i++){
					  $id_doc=$rDocm->campo('docm_id',$i);
					  $corresponde=$camposPost["docm_".$id_doc];
					  $fecha=$camposPost["fecha_".$id_doc];
					  $version=$camposPost["version_".$id_doc];
					  $otros=$camposPost["otros_".$id_doc];
					array_push($vecCamposInsertDocumentos,"('$dic_id','".$id_doc."','".$corresponde."','".$fecha."','".$version."','".$otros."')");
				  }
			}
			
		}
			if(!empty($dic_id)){
				if(count($vecCamposInsertDocumentos)>0){
					$sql="REPLACE INTO dictamen_documentos_sujetos (dds_dic_id,dds_docm_id,dds_corresponde,dds_fecha,dds_version,dds_otros) VALUES ".implode(",",$vecCamposInsertDocumentos);
					$status3 = cComando::ejecutar($sql, INSERT, $id);
				}
				if($status1==FALSE || $status2==FALSE || $status3==FALSE){
					$fallo=true;
				}
			}// end if(empty($dic_id))
			
			if($fallo){
				return -1;
			} else {
				return $dic_id;
			}
	}
	
	static function modificarObservacion($camposPost, $id, $obs_id, $usr_id, $ast_type){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecDocumentos=array();

		$vecCamposInsertDocumentos=array();

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","obs_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","obs_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","obs_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","obs_",$key)."='".$value."'");
					}
				}
			  }
			  		
			}
		$relacion=0;
		if(count($vecCamposSet)>0){
			if(empty($obs_id)){
				$resultadoAsset2=cContenido::GuardarAsset($_SESSION['id_usu'], OBSERVACION, "", "", ST_ACTIVO);
				$sql="INSERT INTO observacion (obs_ast_id, obs_fecha_hora) VALUES ('".$resultadoAsset2."','".date("Y-m-d H:i:s")."')";
				$status1 = cComando::ejecutar($sql, INSERT, $obs_id);
				if($status1!=FALSE){
					if($ast_type==PROYECTO){
						$relacion=1;
						$sql="INSERT INTO observacion_proyecto (obpro_pro_id,obpro_obs_id) VALUES ('$id','$obs_id')";
						$status4 = cComando::ejecutar($sql, INSERT, $id_op);
					}
					if($ast_type==VALIDACION_ANMAT){
						$relacion=1;
						$sql="INSERT INTO observacion_validacion (obval_val_id,obval_obs_id, obval_acciones_requeridas) VALUES ('".$_POST['val_id']."','$obs_id','".$_POST['texto_acciones_requeridas']."')";
						$status4 = cComando::ejecutar($sql, INSERT, $id_op);
					}
				}

				if($relacion==0 || ($status4==FALSE && $relacion==1)){
					$fallo=true;
				} else {
					if($ast_type==PROYECTO){
						$plog_id=cProtocolo::cambiarEstadoProyecto($usr_id,date("Y-m-d H:i:s"),$id,ST_REABIERTO,"");
					}
					if($ast_type==VALIDACION_ANMAT){
						$valog_id=cValidacion::cambiarEstadoValidacion($usr_id,date("Y-m-d H:i:s"),$_POST['val_id'],$id,ST_VAL_OBSERVADO,"");
					}
				}
			} else {
				$status1=true;
			}
			if(!empty($obs_id)){
				if($ast_type==PROYECTO){
					$sql="UPDATE observacion_proyecto SET obpro_plog_id='$plog_id' WHERE obpro_pro_id=$id AND obpro_obs_id='$obs_id'";
					$status5 = cComando::ejecutar($sql, UPDATE, $id_obpro);
				}
				if($ast_type==VALIDACION_ANMAT){
					$sql="UPDATE observacion_validacion SET obval_valog_id='$valog_id' WHERE obval_val_id='".$_POST['val_id']."' AND obval_obs_id='$obs_id'";
					$status5 = cComando::ejecutar($sql, UPDATE, $id_obpro);
				}
				$sql="UPDATE observacion SET ".implode(",",$vecCamposSet)." WHERE obs_id='".$obs_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}
			
		}
			if(!empty($obs_id)){
				if($status1==FALSE || $status2==FALSE){
					$fallo=true;
				}
			}// end if(empty($obs_id))
			
			if($fallo){
				return -1;
			} else {
				return $obs_id;
			}
	}
	
	static function modificarValidacion($camposPost, $pro_id, $val_id, $usr_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
			/*foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","val_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","val_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","val_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","val_",$key)."='".$value."'");
					}
				}
			  }
			  		
			}*/
		  
		//if(count($vecCamposSet)>0){
			if(empty($val_id)){
				$resultadoAsset2=cContenido::GuardarAsset($_SESSION['id_usu'], VALIDACION_ANMAT, "", "", ST_ACTIVO);
				$sql="INSERT INTO validacion (val_status,val_ast_id,val_fecha) VALUES ('".ST_VAL_SOLICITADO."','".$resultadoAsset2."','".date("Y-m-d H:i:s")."')";
				$status1 = cComando::ejecutar($sql, INSERT, $val_id);
				if($status1!=FALSE){
					$sql="INSERT INTO validacion_proyecto (vpro_pro_id,vpro_val_id) VALUES ('$pro_id','$val_id')";
					$status4 = cComando::ejecutar($sql, INSERT, $id_pp);
				}

				if($status1==FALSE || $status4==FALSE){
					$fallo=true;
				} else {
					cValidacion::cambiarEstadoValidacion($usr_id,date("Y-m-d H:i:s"),$val_id,$pro_id,ST_VAL_SOLICITADO,"");
				}
			} else {
				$rVal=cValidacion::obtenerValidacion($val_id);
				if($rVal->cantidad()>0){
					$estado_actual=$rVal->campo('val_status',0);
					if($estado_actual==ST_VAL_OBSERVADO){
						cValidacion::cambiarEstadoValidacion($usr_id,date("Y-m-d H:i:s"),$val_id,$pro_id,ST_VAL_REVISADO,"");
					}
				}

			}
			/*if(!empty($val_id)){
				$sql="UPDATE validacion SET ".implode(",",$vecCamposSet)." WHERE val_id='".$val_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}*/
			
		//}//count($vecCamposSet)>0
			if(!empty($val_id)){
				//if($status1==FALSE || $status2==FALSE){
				if($status1==FALSE){
					$fallo=true;
				}
			}// end if(empty($pag_id))
			
			if($fallo){
				return -1;
			} else {
				return $val_id;
			}
	}
	
	static function vincularPagoValidacion($pag_id,$val_id){
		$sql="INSERT INTO pago_validacion (pval_val_id,pval_pag_id) VALUES ('$val_id','$pag_id')";
		$status = cComando::ejecutar($sql, INSERT, $id_pv);
	}
	
	static function modificarPago($camposPost, $pro_id, $pag_id, $usr_id, $pag_ent_id){
		array_walk_recursive($camposPost, function(&$item, $key) {
		    $item = addslashes($item);
		});
		$vecCamposSet=array();
		$vecCamposInt=array();
		$vecDocumentos=array();
		array_push($vecCamposInt,"var_tpp_id");
		array_push($vecCamposInt,"var_monto");

		$vecCamposInsertDocumentos=array();

			foreach($camposPost as $key => $value) {
			  if(substr($key,0,4)=="var_"){
				if(in_array($key,$vecCamposInt)){
					$value=str_replace(".","", $value);
					$value=str_replace("$","", $value);
					$value=str_replace(" ","", $value);
					$value=str_replace(",",".", $value);
					if($value==''){
						array_push($vecCamposSet,str_replace("var_","pag_",$key)."=NULL");
					} else {
						array_push($vecCamposSet,str_replace("var_","pag_",$key)."='".$value."'");
					}
				} else {
					if($value=="true" || $value=="false"){
						array_push($vecCamposSet,str_replace("var_","pag_",$key)."=$value");				
					} else {
						array_push($vecCamposSet,str_replace("var_","pag_",$key)."='".$value."'");
					}
				}
			  }
			  		
			}
		  
		if(count($vecCamposSet)>0){
			if(empty($pag_id)){
				$resultadoAsset2=cContenido::GuardarAsset($_SESSION['id_usu'], PAGO, "", "", ST_ACTIVO);
				$sql="INSERT INTO pago (pag_status,pag_ast_id,pag_ent_id) VALUES ('".ST_PAG_REALIZADO."','".$resultadoAsset2."','$pag_ent_id')";
				$status1 = cComando::ejecutar($sql, INSERT, $pag_id);
				if($status1!=FALSE){
					$sql="INSERT INTO pago_proyecto (ppro_pro_id,ppro_pag_id) VALUES ('$pro_id','$pag_id')";
					$status4 = cComando::ejecutar($sql, INSERT, $id_pp);
				}

				if($status1==FALSE || $status4==FALSE){
					$fallo=true;
				} else {
					cPago::cambiarEstadoPago($usr_id,date("Y-m-d H:i:s"),$pag_id,$pro_id,ST_PAG_REALIZADO,"");
				}
			}
			if(!empty($pag_id)){
				$sql="UPDATE pago SET ".implode(",",$vecCamposSet)." WHERE pag_id='".$pag_id."'";
				$status2 = cComando::ejecutar($sql, UPDATE, $id);
				if($status2==FALSE){
					$fallo=true;
				}
			}
			
		}
			if(!empty($pag_id)){
				if($status1==FALSE || $status2==FALSE){
					$fallo=true;
				}
			}// end if(empty($pag_id))
			
			if($fallo){
				return -1;
			} else {
				return $pag_id;
			}
	}
	
	
	static function modificarEstadoEmpresa($emp_id, $usr_id){
		$sql="SELECT ast_status, ast_id FROM asset, empresa WHERE emp_ast_id=ast_id AND emp_id='".$emp_id."'";
		$rEstado=cComando::consultar($sql);
		if($rEstado->cantidad()>0){
			$nuevo_estado=0;
			switch($rEstado->campo('ast_status', 0)){
				case ST_ENVIADO:
					$nuevo_estado=ST_MODIFICADO;
				break;
			}
			if($nuevo_estado>0){
				$sql="UPDATE asset SET ast_status='".$nuevo_estado."', ast_usr_id_modified='".$usr_id."', ast_dateModified='".date("Ymd")."', ast_timeModified='".date("H:i:s")."' WHERE ast_id='".$rEstado->campo('ast_id', 0)."'";
				$status = cComando::ejecutar($sql, UPDATE, $id);
			} else {
				$porcentaje=0;
				$rForm=cFormulario::getEstadoFormulario($emp_id,"");
				if($rForm->cantidad()>0){
					$porcentaje=round($rForm->campo('cant_completos',0)/$rForm->campo('cant_formularios',0)*100,0);
				}
				if($porcentaje==100){
					if($rEstado->cantidad()>0){
						$nuevo_estado=0;
						switch($rEstado->campo('ast_status', 0)){
							case ST_PENDIENTE:
								$nuevo_estado=ST_ENVIADO;
							break;
							case ST_ENVIADO:
								$nuevo_estado=ST_MODIFICADO;
							break;
							case ST_MODIFICADO:
								$nuevo_estado=ST_MODIFICADO;
							break;
						}
						if($nuevo_estado>0){
							$sql="UPDATE asset SET ast_status='".$nuevo_estado."', ast_usr_id_modified='".$_SESSION['id_usu']."', ast_dateModified='".date("Ymd")."', ast_timeModified='".date("H:i:s")."' WHERE ast_id='".$rEstado->campo('ast_id', 0)."'";
							$status = cComando::ejecutar($sql, UPDATE, $id);
						}
					}
				}
			}
		}	
	}
	static function guardarEstadoFormulario($form_id, $fcomp_completo, $ent_id){
		$sql="INSERT INTO formulario_completo (fcomp_ent_id, fcomp_form_id, fcomp_completo) VALUES ('$ent_id','$form_id','$fcomp_completo') ON DUPLICATE KEY UPDATE fcomp_completo = '$fcomp_completo'";
		$status = cComando::ejecutar($sql, INSERT, $id);
	}
	static function getEstadoFormulario($ent_id,$tipo_entidad){
		$sql="SELECT SUM(fcomp_completo) as completos,COUNT(fast_form_id) as totales FROM formulario_completo RIGHT JOIN formulario_tipo_entidad ON (fast_form_id=fcomp_form_id AND fast_tie_id='$tipo_entidad' AND fast_requerido=1) WHERE fcomp_ent_id='$ent_id' AND fcomp_completo=1";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()==0){
			return true;
		} else {
			if($rDatos->campo('completos',0)==$rDatos->campo('totales',0)){
				return true;
			} else {
				return false;
			}
		}
	}
	static function getCantFormularios(){
		$sql="SELECT COUNT(form_id) as cant_formularios FROM formulario";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			return $rDatos->campo('cant_formularios',0);
		}
	}	
	static function getEstadoFormulariosFull($ent_id){
		$sql="SELECT form_id, IFNULL(fcomp_completo,0) as fcomp_completo FROM formulario LEFT JOIN formulario_completo ON (fcomp_form_id=form_id AND fcomp_ent_id=$ent_id) ORDER BY form_id";
		return cComando::consultar($sql);
	}
	
	static function SalvarAdjunto($emp_id, $prod_id, $pathAdjunto, $adjunto)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$prod_id)){
			if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id)){
				mkdir(PATH.$pathAdjunto.BARRA.$emp_id);
			}
			mkdir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$prod_id);			
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$prod_id.BARRA.strtolower($nuevo_adjunto));
		if(strlen($emp_id) && strlen($prod_id)){
			$sql="INSERT empresa_producto_link (epl_archivo,epl_emp_id,epl_prod_id) VALUES ('".strtolower($nuevo_adjunto)."','$emp_id','$prod_id')";
		}
		$status = cComando::ejecutar($sql, INSERT, $id);
	}
	static function SalvarAdjuntoFoto($emp_id, $prod_id, $pathAdjunto, $adjunto)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$prod_id)){
			if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id)){
				mkdir(PATH.$pathAdjunto.BARRA.$emp_id);
			}
			mkdir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$prod_id);			
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$prod_id.BARRA.strtolower($nuevo_adjunto));
		if(strlen($emp_id) && strlen($prod_id)){
			$sql="UPDATE empresa_producto SET epr_archivo='".strtolower($nuevo_adjunto)."' WHERE epr_emp_id='$emp_id' AND epr_prod_id='$prod_id'";
			$status = cComando::ejecutar($sql, UPDATE, $id);
		}
	}

	static function SalvarAdjuntoLogoEmpresa($emp_id, $pathAdjunto, $adjunto)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.'logo')){
			if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id)){
				mkdir(PATH.$pathAdjunto.BARRA.$emp_id);
			}
			mkdir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.'logo');			
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$emp_id.BARRA."logo".BARRA.strtolower($nuevo_adjunto));
		if(strlen($emp_id)){
			$sql="UPDATE empresa SET emp_logo='".strtolower($nuevo_adjunto)."' WHERE emp_id='$emp_id'";
		}
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}

	static function SalvarAdjuntoCustomEmpresa($emp_id, $pathAdjunto, $adjunto,$carpeta,$campo)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta)){
			if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id)){
				mkdir(PATH.$pathAdjunto.BARRA.$emp_id);
			}
			mkdir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta);			
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta.BARRA.strtolower($nuevo_adjunto));
		if(strlen($emp_id)){
			$sql="UPDATE empresa SET ".$campo."='".strtolower($nuevo_adjunto)."' WHERE emp_id='$emp_id'";
		}
		$status = cComando::ejecutar($sql, UPDATE, $id);
	}
	static function SalvarAdjuntoCustom($emp_id, $identificador_tabla,$valor_id, $tabla,$pathAdjunto, $adjunto,$carpeta,$campo, $nombre_campo_empresa)
	{
		if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id)){
				mkdir(PATH.$pathAdjunto.BARRA.$emp_id);
		}
		if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta.BARRA.$valor_id)){
			if(!is_dir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta)){
				mkdir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta);
			}			
			mkdir(PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta.BARRA.$valor_id);
		}
		$nuevo_adjunto=str_replace("_temp", "", $adjunto);
		rename(PATH.imagenestemp.BARRA.$adjunto, PATH.$pathAdjunto.BARRA.$emp_id.BARRA.$carpeta.BARRA.$valor_id.BARRA.strtolower($nuevo_adjunto));
		$sql="INSERT $tabla ($campo,$nombre_campo_empresa,$identificador_tabla) VALUES ('".strtolower($nuevo_adjunto)."','$emp_id','$valor_id')";
		$status = cComando::ejecutar($sql, INSERT, $id);
	}

	static function actualizarEstadoEntidad($ent_id,$ent_tipo){
		$porcentaje=0;
		$completo=cFormulario::getEstadoFormulario($ent_id,$ent_tipo);
		$sql="SELECT ast_status, ast_id FROM asset, entidad WHERE ent_ast_id=ast_id AND ent_id='".$ent_id."'";
		$rEstado=cComando::consultar($sql);
		if($rEstado->cantidad()>0){
			$nuevo_estado=0;
			if($completo){
				switch($rEstado->campo('ast_status', 0)){
					case ST_PENDIENTE:
						$nuevo_estado=ST_ACTIVO;
					break;
					case ST_ACTIVO:
						$nuevo_estado=ST_MODIFICADO;
					break;
					case ST_MODIFICADO:
						$nuevo_estado=ST_MODIFICADO;
					break;
					case ST_INCOMPLETO:
						$nuevo_estado=ST_ACTIVO;
					break;
				}
			} else {
				$nuevo_estado=ST_PENDIENTE;
			}
			if($nuevo_estado>0){
				$sql="UPDATE asset, entidad SET ast_status='".$nuevo_estado."', ast_usr_id_modified='".$_SESSION['id_usu']."', ast_dateModified='".date("Ymd")."', ast_timeModified='".date("H:i:s")."' WHERE ast_id='".$rEstado->campo('ast_id', 0)."' AND ast_id=ent_ast_id";
				$status = cComando::ejecutar($sql, UPDATE, $id);
			}
		}
	}
}
?>