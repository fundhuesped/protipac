<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cEntidad
{

	static function insertarPatrocinador($razon_social, $estado_empresa)
	{
		$sql = "SELECT emp_id FROM empresa WHERE emp_razon_social = '$razon_social'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0){
			return $rDatos->campo('emp_id',0);
		}
		
		$sql="INSERT INTO empresa (emp_razon_social,emp_captura_status) VALUES ('".addslashes($razon_social)."', '".addslashes($estado_empresa)."')";
		$status = cComando::ejecutar($sql, INSERT, $id_emp);
		if($status==FALSE){
			return -1;
		}
		return $id_emp;
	}


	static function getEntidad($ent_id, $vecEntidadStatus){
		$sql="SELECT entidad.*, empresa.*, investigador.*, ast_status as entidad_status, ast_dateCreated fecha_alta, provincia.nombre_provincia, localidad.nombre_localidad ";
		$sql_from="FROM entidad INNER JOIN asset ON (ent_ast_id=ast_id";
		if(!empty($vecEntidadStatus)){
			$status_asset="";
			for($vi=0;$vi<count($vecEntidadStatus);$vi++){
				if($vi>0){
					$status_asset.=",";
				}
				$status_asset.=$vecEntidadStatus[$vi];
			}
			if(count($vecEntidadStatus)>0){
				$sql_temp=" AND ast_status IN (|STA|)";
				$sql_where.=str_replace("|STA|", $status_asset, $sql_temp);
			}
		}			
		$sql_from.=")";
		$sql_from.=" LEFT JOIN empresa ON (entidad.ent_id=empresa.emp_ent_id) LEFT JOIN investigador ON (investigador.inv_ent_id=entidad.ent_id) LEFT JOIN provincia ON (ent_domicilio_id_provincia=provincia.id_provincia) LEFT JOIN localidad ON (ent_domicilio_id_localidad=localidad.id_localidad) ";
		$sql_where=" WHERE ent_id='$ent_id'";
		return cComando::consultar($sql.$sql_from.$sql_where);
	}
	static function obtenerComboPatrocinador($inv_id,$com_id){
		$sql="SELECT EMP.emp_id, EMP.emp_razon_social descripcion ";
		$sql_from="FROM empresa EMP";
		if(!empty($inv_id) && empty($com_id)){
			$sql_from.=" INNER JOIN protocolo_patrocinador PPAT ON (PPAT.propat_emp_id=EMP.emp_id) INNER JOIN protocolo_investigador PINV ON (PINV.proinv_pro_id=PPAT.propat_pro_id AND PINV.proinv_inv_id='$inv_id') INNER JOIN protocolo P ON (P.pro_id=PPAT.propat_pro_id)";
		}
		if(!empty($com_id) && empty($inv_id)){
			$sql_from.=" INNER JOIN protocolo_patrocinador PPAT ON (PPAT.propat_emp_id=EMP.emp_id) INNER JOIN protocolo P ON (P.pro_id=PPAT.propat_pro_id AND P.pro_com_id='$com_id' AND P.pro_status<>".ST_BORRADOR.")";
		}
		if(!empty($inv_id) || !empty($com_id)){
			$sql_group_by=" GROUP BY EMP.emp_id";
		}
		return cComando::consultar($sql.$sql_from.$sql_group_by);
	}
	static function obtenerComboInvestigador($tinv_id){
		$sql="SELECT INV.inv_id, CONCAT(INV.inv_apellido,', ',INV.inv_nombre) descripcion ";
		$sql_from="FROM investigador INV INNER JOIN investigador_tipo ON (invtipo_inv_id=inv_id AND invtipo_tinv_id='$tinv_id')";
		return cComando::consultar($sql.$sql_from);
	}
	/*static function obtener($inicio="", $tamanioPagina="", $busqueda="",$busqueda_contacto,$estado_usuario, &$cantResultados, &$cantPaginas, $status,  $fecha_alta_desde, $fecha_alta_hasta, $orden, $direccion, $vecTipoEntidad, $ent_id)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(*), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			$sql_from=" FROM entidad E INNER JOIN asset ASTEMP ON (E.ent_ast_id=ASTEMP.ast_id)";
			$sql = "SELECT E.*, ASTEMP.ast_dateCreated as fecha_alta,ASTEMP.ast_dateModified as fecha_modificacion, ASTEMP.ast_status estado_empresa, usr_id, usr_status ";
			if(!empty($ent_id)){
				$sql_where.=" AND E.ent_id='$ent_id'";
			}
			if(in_array(TIPO_INVESTIGADOR,$vecTipoEntidad)){
				$sql.=", INV.*, U.*";
				$sql_from.=" INNER JOIN investigador INV ON (INV.inv_ent_id=E.ent_id) ";
				if(!empty($busqueda)){
					$sql_from.=" INNER JOIN usuario_entidad UE ON (UE.uent_ent_id=E.ent_id) INNER JOIN user U ON (UE.uent_usr_id=U.usr_id)";	
					$sql_where.= " AND (U.usr_name LIKE '%$busqueda%' OR U.usr_lastname LIKE '%$busqueda%' OR CONCAT(U.usr_name,' ',U.usr_lastname) LIKE '%$busqueda%' OR U.usr_login LIKE '%$busqueda%') ";
				}
			}
			if(in_array(TIPO_PATROCINADOR,$vecTipoEntidad)){
				$sql.=", EMP.*";
				$sql_from.=" INNER JOIN empresa EMP ON (EMP.emp_ent_id=E.ent_id) ";
				if(!empty($busqueda)){
					$sql_where.= " AND (EMP.emp_razon_social LIKE '%$busqueda%' OR EMP.emp_cuit LIKE '%$busqueda%')";
				}
				if(!empty($busqueda_contacto)){
					$sql_where.= " AND (EMP.emp_persona_contacto_apellido LIKE '%$busqueda_contacto%' OR EMP.emp_persona_contacto_nombre LIKE '%$busqueda_contacto%') ";
				}
			}
			if(in_array(TIPO_CEI,$vecTipoEntidad)){
				$sql.=", COM.*";
				$sql_from.=" INNER JOIN comite COM ON (COM.com_ent_id=E.ent_id) ";
				if(!empty($busqueda)){
					$sql_where.= " AND (COM.com_descripcion LIKE '%$busqueda%' OR COM.com_nro_registro LIKE '%$busqueda%')";
				}
				if(!empty($busqueda_contacto)){
					$sql_where.= " AND (COM.com_persona_contacto_apellido LIKE '%$busqueda_contacto%' OR COM.com_persona_contacto_nombre LIKE '%$busqueda_contacto%') ";
				}
			}

				

			if(count($status)>0)
				$sql_where.= " AND ASTEMP.ast_status IN (".implode(",",$status).")";

			if(!empty($fecha_alta_desde))
				$sql_where.= " AND ASTEMP.ast_dateCreated>='".addslashes(str_replace("-","",$fecha_alta_desde))."'";

			if(!empty($fecha_alta_hasta))
				$sql_where.= " AND ASTEMP.ast_dateCreated<='".addslashes(str_replace("-","",$fecha_alta_hasta))."'";
				
			if(!empty($estado_usuario)){
				$sql_where.=" AND usr_status='$estado_usuario'";
			}		

					
			$rDatos = cComando::consultar($sql_count.$sql_from.$sql_where);
			$cantResultados=$rDatos->campo('cantidad', 0);
			$cantPaginas = ceil($rDatos->campo('cantidad', 0) / $tamanioPagina);
			if(strlen($inicio) && strlen($tamanioPagina)){
				$limit = " LIMIT $inicio , $tamanioPagina";
			}



		if(empty($orden) || $empty($direccion)){
			$orden="fecha_alta";
			$direccion="DESC";
		}
		$sql_order= " ORDER BY $orden $direccion";
		$sql_limit= $limit;
		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_order.$sql_limit);
		return $rDatos;
	}*/
	


	static function insertarEntidad($username,  $usr_name, $usr_lastname,$cuit, $email, $razon_social, $clave, $estado, $fecha_ingreso, $hora_ingreso, $var_persona_contacto_apellido,$var_persona_contacto_nombre, $var_persona_contacto_cargo,$var_persona_contacto_telefono,$var_persona_contacto_email, $var_domicilio_calle, $var_domicilio_numero, $var_domicilio_otros_datos, $var_domicilio_cod_pos, $var_domicilio_id_provincia, $var_domicilio_id_localidad, $var_tie_id, $var_perfil,$var_tid_id,$var_nro_documento,$var_titulo_profesional,$var_matricula,$var_especialidad,$var_nombre_institucion_titulo, $var_domicilio_institucion, $var_temp_id, $var_tinv_id, $errorVar, $var_cuil,$var_sexo,$var_fecha_nacimiento)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM user WHERE usr_login = '$username'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0){
			return -1;
		} else {
			$alta_usuario=1;
		}

		

		
		
		if($var_tie_id==TIPO_PATROCINADOR){
			$sql="SELECT emp_id FROM empresa WHERE emp_cuit='$cuit'";
			$rDatos=cComando::consultar($sql);
			
			if($rDatos->cantidad()==0){
				$alta_empresa=1;	
			} else {
				return -1;
			}
		}
		if($var_tie_id==TIPO_INVESTIGADOR){
			$sql="SELECT inv_ent_id FROM investigador WHERE inv_tid_id='$var_tid_id' AND inv_nro_documento='$var_nro_documento'";
			$rDatos=cComando::consultar($sql);
			
			if($rDatos->cantidad()==0){
				$alta_investigador=1;	
			} else {
				return -1;
			}
		}
		if(($alta_empresa==1 || $alta_investigador==1) && $alta_usuario==1){
			if($alta_empresa==1){
				$usr_name=addslashes($var_persona_contacto_nombre);
				$usr_lastname=addslashes($var_persona_contacto_apellido);
				$email=addslashes($var_persona_contacto_email);
			}
			$resultadoAsset=cContenido::GuardarAsset($_SESSION['id_usu'], USUARIO, "", "", ST_PENDIENTE);
			$sql = "INSERT INTO user(usr_login, usr_pass, usr_email, usr_status, usr_dateCreated, usr_timeCreated,  usr_ast_id, usr_lng_id, usr_name, usr_lastname) VALUES ";
			$sql .= "('$username', '".md5($clave)."', '$email', '".ST_ACTIVO."', '$fecha_ingreso', '$hora_ingreso', '$resultadoAsset', ".ID_IDIOMA.", '$usr_name', '$usr_lastname')";
			$status = cComando::ejecutar($sql, INSERT, $id_new_user);
			cUsuario::asociarPerfil($id_new_user, $var_perfil);
			$resultadoAsset2=cContenido::GuardarAsset($_SESSION['id_usu'], ENTIDAD, "", "", ST_PENDIENTE);
			$sql="INSERT INTO entidad (ent_ast_id, ent_tie_id, ent_domicilio_calle, ent_domicilio_numero, ent_domicilio_otros_datos, ent_domicilio_cod_pos, ent_domicilio_id_provincia, ent_domicilio_id_localidad) VALUES ";
			$sql.="('$resultadoAsset2','".addslashes($var_tie_id)."','".addslashes($var_domicilio_calle)."','".addslashes($var_domicilio_numero)."','".addslashes($var_domicilio_otros_datos)."','".addslashes($var_domicilio_cod_pos)."','".addslashes($var_domicilio_id_provincia)."','".addslashes($var_domicilio_id_localidad)."')";
			$status2 = cComando::ejecutar($sql, INSERT, $ent_id_new);
			$sql="INSERT INTO usuario_entidad (uent_ent_id, uent_usr_id) VALUES ('$ent_id_new', '$id_new_user')";	
			$status3 = cComando::ejecutar($sql, INSERT, $id_u);
			$status4=$status5=TRUE;
			if($alta_empresa==1){
				$sql="INSERT INTO empresa (emp_ent_id, emp_razon_social, emp_email, emp_cuit, emp_persona_contacto_apellido,emp_persona_contacto_nombre, emp_persona_contacto_cargo,emp_persona_contacto_telefono,emp_persona_contacto_email,emp_temp_id) VALUES ('$ent_id_new', '".addslashes($razon_social)."', '".addslashes($email)."', '".addslashes($cuit)."','".addslashes($var_persona_contacto_apellido)."','".addslashes($var_persona_contacto_nombre)."','".addslashes($var_persona_contacto_cargo)."','".addslashes($var_persona_contacto_telefono)."','".addslashes($var_persona_contacto_email)."','".addslashes($var_temp_id)."')";
				$status4 = cComando::ejecutar($sql, INSERT, $id_emp);
			}
			if($alta_investigador==1){
				$sql="INSERT INTO investigador (inv_ent_id, inv_tid_id, inv_nro_documento, inv_titulo_profesional, inv_especialidad ,inv_matricula, inv_nombre_institucion_titulo, inv_domicilio_institucion, inv_tinv_id, inv_cuit, inv_nombre, inv_apellido,inv_sexo,inv_fecha_nacimiento) VALUES ('$ent_id_new', '".addslashes($var_tid_id)."', '".addslashes($var_nro_documento)."', '".addslashes($var_titulo_profesional)."','".addslashes($var_especialidad)."','".addslashes($var_matricula)."','".addslashes($var_nombre_institucion_titulo)."','".addslashes($var_domicilio_institucion)."','".addslashes($var_tinv_id)."','".addslashes($var_cuil)."','".addslashes($usr_name)."','".addslashes($usr_lastname)."','".addslashes($var_sexo)."','".addslashes($var_fecha_nacimiento)."')";
				$status4 = cComando::ejecutar($sql, INSERT, $id_inv_new);
			}
			
		}
		
		if($status==FALSE || $status2==FALSE || $status3==FALSE || $resultadoAsset2==-1 || $resultadoAsset==-1 || $status4==FALSE || $status5==FALSE){
			return -1;
		}
		return $id_new_user;
	}
	
	static function modificarEntidad($var_ent_id, $var_usr_id, $username,  $usr_name, $usr_lastname,$cuit, $email, $razon_social, $clave, $estado, $fecha_ingreso, $hora_ingreso, $var_persona_contacto_apellido,$var_persona_contacto_nombre, $var_persona_contacto_cargo,$var_persona_contacto_telefono,$var_persona_contacto_email, $var_domicilio_calle, $var_domicilio_numero, $var_domicilio_otros_datos, $var_domicilio_cod_pos, $var_domicilio_id_provincia, $var_domicilio_id_localidad, $var_tie_id, $var_perfil,$var_tid_id,$var_nro_documento,$var_titulo_profesional,$var_matricula,$var_especialidad,$var_nombre_institucion_titulo, $var_domicilio_institucion, $var_temp_id, $var_tinv_id, $errorVar,$var_cuil,$var_sexo,$var_fecha_nacimiento)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM user WHERE usr_id = '$var_usr_id'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0){
			$modificar_usuario=1;
		} else {
			return -1;
		}

		
		
		if($var_tie_id==TIPO_PATROCINADOR){
			$sql="SELECT emp_id FROM empresa WHERE emp_ent_id='$var_ent_id'";
			$rDatos=cComando::consultar($sql);
			
			if($rDatos->cantidad()>0){
				$modificar_empresa=1;	
			} else {
				return -1;
			}
		}
		if($var_tie_id==TIPO_INVESTIGADOR){
			$sql="SELECT inv_ent_id FROM investigador WHERE inv_ent_id='$var_ent_id'";
			$rDatos=cComando::consultar($sql);
			
			if($rDatos->cantidad()>0){
				$modificar_investigador=1;	
			} else {
				return -1;
			}
		}
		if(($modificar_empresa==1 || $modificar_investigador==1) && $modificar_usuario==1){
			if($modificar_empresa==1){
				$usr_name=addslashes($var_persona_contacto_nombre);
				$usr_lastname=addslashes($var_persona_contacto_apellido);
				$email=addslashes($var_persona_contacto_email);
			}
			$sql="UPDATE user SET ";
			$sql.=" usr_login='$username', ";
			if (strlen($clave)>0){
				$sql.="usr_pass = '".md5(addslashes($clave))."', ";
			}
			$sql.=" usr_name='$usr_name', ";
			$sql.=" usr_lastname='$usr_lastname', ";
			$sql.=" usr_email='$email', ";
			$sql.=" usr_dateModified='$fecha_ingreso', ";
			$sql.=" usr_timeModified='$hora_ingreso' ";
			$sql.=" WHERE usr_id='$var_usr_id'";
			$status1 = cComando::ejecutar($sql, UPDATE, $id);
			
			$sql="UPDATE entidad SET ";
			$sql.=" ent_domicilio_calle='".addslashes($var_domicilio_calle)."',";
			$sql.=" ent_domicilio_numero='".addslashes($var_domicilio_numero)."',";
			$sql.=" ent_domicilio_otros_datos='".addslashes($var_domicilio_otros_datos)."',";
			$sql.=" ent_domicilio_cod_pos='".addslashes($var_domicilio_cod_pos)."',";
			$sql.=" ent_domicilio_id_provincia='".addslashes($var_domicilio_id_provincia)."',";
			$sql.=" ent_domicilio_id_localidad='".addslashes($var_domicilio_id_localidad)."'";
			$sql.=" WHERE ent_id='$var_ent_id'";
			$status2 = cComando::ejecutar($sql, UPDATE, $id);

			if($modificar_empresa==1){
				$sql="UPDATE empresa SET ";
				$sql.=" emp_razon_social='".addslashes($razon_social)."',";
				$sql.=" emp_email='".addslashes($email)."',";
				$sql.=" emp_cuit='".addslashes($cuit)."',";
				$sql.=" emp_persona_contacto_apellido='".addslashes($var_persona_contacto_apellido)."',";
				$sql.=" emp_persona_contacto_nombre='".addslashes($var_persona_contacto_nombre)."',";
				$sql.=" emp_persona_contacto_cargo='".addslashes($var_persona_contacto_cargo)."',";
				$sql.=" emp_persona_contacto_telefono='".addslashes($var_persona_contacto_telefono)."',";
				$sql.=" emp_persona_contacto_email='".addslashes($var_persona_contacto_email)."',";
				$sql.=" emp_temp_id='".addslashes($var_temp_id)."'";
				$sql.=" WHERE emp_ent_id='$var_ent_id'";
				$status3 = cComando::ejecutar($sql, UPDATE, $id);
			}
			if($modificar_investigador==1){
				$sql="UPDATE investigador SET ";
				$sql.=" inv_tid_id='".addslashes($var_tid_id)."',";
				$sql.=" inv_tinv_id='".addslashes($var_tinv_id)."',";
				$sql.=" inv_nombre='".addslashes($usr_name)."',";
				$sql.=" inv_apellido='".addslashes($usr_lastname)."',";
				$sql.=" inv_nro_documento='".addslashes($var_nro_documento)."',";
				$sql.=" inv_titulo_profesional='".addslashes($var_titulo_profesional)."',";
				$sql.=" inv_especialidad='".addslashes($var_especialidad)."',";
				$sql.=" inv_matricula='".addslashes($var_matricula)."',";
				$sql.=" inv_cuit='".addslashes($var_cuil)."',";
				$sql.=" inv_sexo='".addslashes($var_sexo)."',";
				$sql.=" inv_fecha_nacimiento='".addslashes($var_fecha_nacimiento)."'";
				//$sql.=" inv_nombre_institucion_titulo='".addslashes($var_nombre_institucion_titulo)."'";
				$sql.=" WHERE inv_ent_id='$var_ent_id'";
				$status3 = cComando::ejecutar($sql, UPDATE, $id);
			}
			
		}
		
		if($status1==FALSE || $status2==FALSE || $status3==FALSE){
			return -1;
		}
		return 1;
	}
	static function getAdjuntosInvestigador($ast_id, $vecStatus, $tadj_id){
		$sql="SELECT lnk_file_full_size, lnk_tadj_id, tadj_carpeta, lnk_fecha_hora_creacion, lnk_id, lnk_caption";
		$sql_from=" FROM link l, tipo_adjunto ta";
		$sql_where=" WHERE l.lnk_ast_id='$ast_id' AND ta.tadj_id=l.lnk_tadj_id";
		if(!empty($vecStatus)){
			$status_asset="";
			for($vi=0;$vi<count($vecStatus);$vi++){
				if($vi>0){
					$status_asset.=",";
				}
				$status_asset.=$vecStatus[$vi];
			}
			if(count($vecStatus)>0){
				$sql_temp=" AND lnk_status IN (|STA|)";
				$sql_where.=str_replace("|STA|", $status_asset, $sql_temp);
			}
		}
		if(!empty($tadj_id)){
			$sql_where.=" AND ta.tadj_id='$tadj_id'";
		}
		$sql_order_by=" ORDER BY lnk_id DESC";
		return cComando::consultar($sql.$sql_from.$sql_where.$sql_order_by);
	}


	static function obtenerComentarios($inicio="", $tamanioPagina="", $empresa_id, &$cantPaginas, $status, $fecha_alta_desde, $fecha_alta_hasta, $com_tic_id, $orden, $direccion)
	{
			// Consulto la cantidad total (para paginar)
			$sql_count = "SELECT IFNULL(COUNT(*), 0) AS cantidad ";
			$sql_where=" WHERE 1 ";
			
			if(count($status)>0)
				$sql_where.= " AND COM.com_status IN (".implode(",",$status).")";

			if(!empty($fecha_alta_desde))
				$sql_where.= " AND COM.com_dateCreated>='".addslashes(str_replace("-","",$fecha_alta_desde))."'";

			if(!empty($fecha_alta_hasta))
				$sql_where.= " AND COM.com_dateCreated<='".addslashes(str_replace("-","",$fecha_alta_hasta))."'";
				
			if(!empty($com_tic_id))
				$sql_where.= " AND COM.com_tic_id='".addslashes($com_tic_id)."'";

			$sql_from=" FROM assetcomment COM  INNER JOIN asset ASTCOM ON (ASTCOM.ast_id=COM.com_ast_id AND COM.com_emp_id='$empresa_id') LEFT JOIN user USRCREA ON (USRCREA.usr_id=COM.com_usr_id) LEFT JOIN user USRMODIF ON (USRMODIF.usr_id=COM.com_usr_id_modified) ";
					
			$rDatos = cComando::consultar($sql_count.$sql_from.$sql_where);
			if(strlen($inicio) && strlen($tamanioPagina)){
				$cantPaginas = ceil($rDatos->campo('cantidad', 0) / $tamanioPagina);
				$limit = " LIMIT $inicio , $tamanioPagina";
			}

		$sql = "SELECT COM.*, CONCAT(USRCREA.usr_lastname,', ',USRCREA.usr_name) as usuario_creacion, CONCAT(USRMODIF.usr_lastname,', ',USRMODIF.usr_name) as usuario_modificacion ";

		$sql_order= " ORDER BY $orden $direccion";
		$sql_limit= $limit;
		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_order.$sql_limit);
		return $rDatos;
	}




}
?>