<?php

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cUsuario
{
	static function getUsersFromEfector($efe_id){
		$sql="SELECT usr_id, usr_status, usr_login, usr_name, usr_lastname, usr_email FROM user, usuario_efector WHERE usr_id=uefe_usr_id AND uefe_efe_id='$efe_id'";
		return cComando::consultar($sql);
	}
	static function getEfectorUsuario($usr_id){
		$sql="SELECT  efe.efe_id,efe.efe_nombre, efe.efe_nombre_corto, efe.efe_nivel_id FROM efector efe INNER JOIN usuario_efector ue ON (ue.uefe_efe_id=efe.efe_id AND ue.uefe_usr_id='$usr_id')";
		return cComando::consultar($sql);
	}
	static function getUsersFromEmpresa($emp_id){
		$sql="SELECT usr_id, usr_status FROM user, user_empresa WHERE usr_id=uem_usr_id AND uem_emp_id='$emp_id'";
		return cComando::consultar($sql);
	}
	static function activationKey($length)
	{
	  $pattern = "123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  for($i=0;$i<$length;$i++)
	  {
	   if(isset($key))
    	 $key .= $pattern{rand(0,35)};
	   else
    	 $key = $pattern{rand(0,35)};
	  }
	  return $key;
	}
	static function insertarProveedor($cuit, $razon_social,  $estado_empresa,$emp_persona_contacto_comercial_nombre,$emp_persona_contacto_comercial_apellido,$emp_persona_contacto_comercial_email,$emp_persona_contacto_comercial_telefono)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT emp_id FROM empresa WHERE emp_cuit = '$cuit'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0){
			return $rDatos->campo('emp_id',0);
		}
		
		$resultadoAsset2=cContenido::GuardarAsset($_SESSION['id_usu'], EMPRESA, "", "", ST_PENDIENTE);
		$sql="INSERT INTO empresa (emp_ast_id, emp_razon_social, emp_cuit, emp_programa_status,emp_persona_contacto_comercial_nombre,emp_persona_contacto_comercial_apellido,emp_persona_contacto_comercial_email,emp_persona_contacto_comercial_telefono) VALUES ('$resultadoAsset2', '".addslashes($razon_social)."','".addslashes($cuit)."','".$estado_empresa."','".addslashes($emp_persona_contacto_comercial_nombre)."','".addslashes($emp_persona_contacto_comercial_apellido)."','".addslashes($emp_persona_contacto_comercial_email)."','".addslashes($emp_persona_contacto_comercial_telefono)."')";
		$status2 = cComando::ejecutar($sql, INSERT, $id_emp);
		
		if($status2==FALSE){
			return -1;
		}
		return $id_emp;
	}

	static function modificarEmpresa($username,$cuit,$var_persona_contacto_dni,$email, $razon_social, $forma_juridica_id, $otra_forma_juridica, $clave, $id_empresa, $id_usuario, $var_persona_contacto_apellido,$var_persona_contacto_nombre, $var_persona_contacto_cargo,$var_persona_contacto_telefono,$var_persona_contacto_email,$formulario, $errorVar,$var_es_renovar)
	{

		$sql = "UPDATE user SET 
				usr_login = '".addslashes($username)."',";
				if (strlen($clave)>0){
					$sql.="usr_pass = '".md5(addslashes($clave))."', ";
				}
				$sql.="usr_email = '".addslashes($email)."'";
				$sql.=" WHERE usr_id = $id_usuario";
		$status=cComando::ejecutar($sql, UPDATE, $id);
		
		$sql = "UPDATE empresa SET 
				emp_cuit= '".addslashes($cuit)."',
				emp_es_renovar= '".addslashes($var_es_renovar)."',
				emp_razon_social = '".addslashes($razon_social)."',
				emp_email = '".addslashes($email)."',
				emp_forma_juridica_id = ".(intval($forma_juridica_id,10)==-1 ? "NULL":"'".addslashes($forma_juridica_id)."'").",
				emp_persona_contacto_apellido = '".addslashes($var_persona_contacto_apellido)."',
				emp_persona_contacto_nombre = '".addslashes($var_persona_contacto_nombre)."',
				emp_persona_contacto_cargo = '".addslashes($var_persona_contacto_cargo)."',
				emp_persona_contacto_telefono = '".addslashes($var_persona_contacto_telefono)."',
				emp_persona_contacto_email = '".addslashes($var_persona_contacto_email)."',
				emp_persona_contacto_dni = '".addslashes($var_persona_contacto_dni)."',
				emp_otra_forma_juridica = '".addslashes($otra_forma_juridica)."'";
				$sql.=" WHERE emp_id = '".addslashes($id_empresa)."'";
		$status2=cComando::ejecutar($sql, UPDATE, $id);
		if($status!=FALSE && $status2!=FALSE){
			cFormulario::guardarEstadoFormulario($formulario, !$errorVar, $id_empresa);
			return $id_empresa;
		} else {
			return -1;
		}
	}



	static function insertar($username, $clave, $email, $activo, $cod_activacion, $fecha_ingreso, $hora_ingreso, $perfil_usuario, $nombre, $apellido)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM user WHERE usr_login = '$username'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0)
			return -1;
		$resultadoAsset=cContenido::GuardarAsset($_SESSION['id_usu'], USUARIO, "", "", ST_ACTIVO);
			
		$sql = "INSERT INTO user(usr_login, usr_pass, usr_email, usr_status, usr_activation_key, usr_dateCreated, usr_timeCreated,  usr_ast_id, usr_lng_id, usr_name, usr_lastname) VALUES ";
		$sql .= "('$username', '".md5($clave)."', '$email', '$activo', '$cod_activacion', '$fecha_ingreso', '$hora_ingreso', '$resultadoAsset', ".ID_IDIOMA.", '$nombre', '$apellido')";
		$status = cComando::ejecutar($sql, INSERT, $id_new_user);
		//$id_usuario=$id;
		cUsuario::insertarPreferencia($id_new_user, 'TOPIC_MAIL_PREF', 2); //agregar preferncia individual mails de follow asset
		if(!empty($perfil_usuario)){
			for($i=0;$i<count($perfil_usuario);$i++){
				cUsuario::asociarPerfil($id_new_user, $perfil_usuario[$i]);
			}
		}		
		return $id_new_user;
	}


	
	static function insertarBackOffice($username, $clave, $nombre, $apellido, $email, $id_empresa, $estado, $id_idioma, $fecha_ingreso, $hora_ingreso, $id_usuario_creador, $workspace_id){
		$sql = "SELECT * FROM user WHERE usr_login = '$username' OR usr_email = '$email'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0)
			return -1;
			
		$id_contenido=cContenido::GuardarAsset($id_usuario_creador, USUARIO, "", "", $estado);

		$sql = "INSERT INTO user(usr_login, usr_pass, usr_name, usr_lastname, usr_email, usr_status, usr_lng_id, usr_dateCreated, usr_timeCreated, usr_ast_id) VALUES ";
		$sql.="('$username', '".md5($clave)."', '".addslashes($nombre)."', '".addslashes($apellido)."', '$email', '$estado', '$id_idioma', '$fecha_ingreso', '$hora_ingreso', $id_contenido)";
		cComando::ejecutar($sql, INSERT, $id_usuario);
		cUsuario::insertarPreferencia($id_usuario, 'TOPIC_MAIL_PREF', 2); //agregar preferncia individual mails de follow asset
		cUsuario::agregarUsuarioEmpresa($id_usuario, $id_empresa);
		cUsuario::asociarPerfil($id_usuario, PERFIL_DEFECTO);
		for($i=0;$i<count($workspace_id);$i++){
			cWorkspace::agregarUsuarioWorkspace($id_usuario, $workspace_id[$i], ST_ACTIVO);
		}
	}
	
	static function agregarUsuarioEmpresa($id_usuario, $id_empresa){
		$sql="INSERT INTO profilecompany (pco_usr_id, pco_cny_id, pco_active) VALUES ('$id_usuario', '$id_empresa', ".ST_ACTIVO.")";
		cComando::ejecutar($sql, INSERT, $id);
	}
	
	static function desvincularUsuarioEmpresa($id_usuario){
		$sql="DELETE FROM profilecompany WHERE pco_usr_id=$id_usuario";
		cComando::ejecutar($sql, DELETE, $id);
	}
	
	static function obtenerUsuarioEmpresa($id_usuario){
		$sql="SELECT profilecompany.pco_cny_id, company.cny_name, pco_busunit, pco_title FROM profilecompany, company WHERE pco_usr_id=$id_usuario AND pco_active=1 AND pco_cny_id=cny_id ";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}


	static function modificar($id_usuario, $username, $clave, $nombre, $apellido, $email, $fecha_modificado, $hora_modificado)
	{
		$sql = "SELECT * FROM user WHERE (usr_login = '$username') AND usr_id<>$id_usuario";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0)
			return -1;
		
		$sql = "UPDATE user SET 
				usr_login = '".addslashes($username)."',
				usr_name = '".addslashes($nombre)."',
				usr_lastname = '".addslashes($apellido)."',
				usr_email = '".addslashes($email)."',
				usr_dateModified = '$fecha_modicado', 
				usr_timeModified	 = '$hora_modificado'";
				if (strlen($clave)>0){
					$sql.=", usr_pass = '".md5($clave)."' ";
				}
				$sql.=" WHERE usr_id = $id_usuario";
		$status=cComando::ejecutar($sql, UPDATE, $id);
		return 1;
	}
	
	static function modificarEmail($id_usuario, $email)
	{
		$sql = "UPDATE user SET 
				usr_email = '$email' WHERE usr_id = $id_usuario";
		cComando::ejecutar($sql, UPDATE, $id);
		return 0;
	}
	
	static function modificarPassword($id_usuario, $clave)
	{	
		if (strlen($clave)>0){
			$sql = "UPDATE user SET usr_pass = '".md5($clave)."' ";
			$sql.=" WHERE usr_id = $id_usuario";
			cComando::ejecutar($sql, UPDATE, $id);
		}
		return 0;
	}
	
	

	static function modificarBackOffice($id_usuario, $username, $clave, $nombre, $apellido, $email, $id_empresa, $id_idioma, $workspace_id)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM user WHERE (usr_login = '$username' OR usr_email = '$email') AND usr_id<>$id_usuario";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0)
			return -1;
		
		$sql = "UPDATE user SET 
				usr_name = '$nombre',
				usr_lastname = '$apellido',
				usr_email = '$email',
				usr_login = '$username',
				usr_lng_id = $id_idioma";
				if (strlen($clave)>0){
					$sql.=", usr_pass = '".md5($clave)."' ";
				}
				$sql.=" WHERE usr_id = $id_usuario";
		cComando::ejecutar($sql, UPDATE, $id);
		cUsuario::desvincularUsuarioEmpresa($id_usuario);
		cUsuario::agregarUsuarioEmpresa($id_usuario, $id_empresa);
		
		cWorkspace::eliminarTodosUsuario($id_usuario);
		for($i=0;$i<count($workspace_id);$i++){
			cWorkspace::agregarUsuarioWorkspace($id_usuario, $workspace_id[$i], ST_ACTIVO);
		}
		//cDB::cerrar();
		return 0;
	}


	static function BuscarUsuarios(&$cantRegTotal, $inicio="", $tamanioPagina="", $orden_campo="", $orden_direccion="", $estado="", $nombre_apellido="", $email="", $username="", $fecha_desde="", $fecha_hasta="")
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);

		#Consulto la cantidad total de usuarios q cumplan con las claves de busqueda
		$sql = "SELECT COUNT(*) as total FROM user  WHERE 1";

		if(!empty($nombre_apellido))
			$sql.= " AND CONCAT(usr_name, ' ', usr_lastname) LIKE '%" . $nombre_apellido. "%'";

		if(!empty($email))
			$sql.= " AND usr_email LIKE '%$email%'";

		if(!empty($username))
			$sql.= " AND usr_login LIKE '%".trim($username)."%'";
			
		if(!empty($estado))
			$sql.= " AND usr_status IN ".$estado;

		if(!empty($fecha_desde))
			$sql.= " AND usr_dateCreated >= '$fecha_desde'";

		if(!empty($fecha_hasta))
			$sql.= " AND usr_dateCreated <= '$fecha_hasta'";

		$rDatos = cComando::consultar($sql);
		$cantRegTotal = $rDatos->campo('total', 0);

		$sql = "SELECT usr_id, CONCAT(usr_name, ' ', usr_lastname) as nombre_apellido, usr_login, id_pais, usr_dateCreated, usr_status 
				FROM user WHERE 1 ";

		if(!empty($nombre_apellido))
			$sql.= " AND CONCAT(usr_name, ' ', usr_lastname) LIKE '%" . $nombre_apellido. "%'";

		if(!empty($email))
			$sql.= " AND usr_email LIKE '%$email%'";

		if(!empty($username))
			$sql.= " AND usr_login LIKE '%".trim($username)."%'";
		if(!empty($estado))
			$sql.= " AND usr_status IN ".$estado;

		if(!empty($fecha_desde))
			$sql.= " AND usr_dateCreated >= '$fecha_desde'";

		if(!empty($fecha_hasta))
			$sql.= " AND usr_dateCreated <= '$fecha_hasta'";

		if(strlen($orden_campo))
			$sql .= " ORDER BY $orden_campo $orden_direccion";
		else
			$sql .= " ORDER BY usr_name";

		if(strlen($inicio) && strlen($tamanioPagina))
			$sql.= " LIMIT $inicio , $tamanioPagina ";

		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	static function obtenerPerfilUsuario($id_usuario){
		$sql="SELECT role.rol_id,role.rol_code,role.rol_status FROM role, userrole WHERE uro_rol_id=rol_id AND uro_usr_id='$id_usuario' ";
		return cComando::consultar($sql);
	}
	static function tienePermisoActivo($id_usuario, $cod_permiso){
		$sql="SELECT role.rol_status, function.fnc_type FROM role, role_function, function, userrole  
		WHERE role.rol_status='".ST_ACTIVO."' AND role.rol_id=role_function.rfu_rol_id AND role_function.rfu_fnc_id=function.fnc_id AND function.fnc_code='$cod_permiso' AND userrole.uro_rol_id=role.rol_id AND userrole.uro_usr_id=$id_usuario";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			if($_SESSION['usu_status']==ST_PENDIENTE){
				if(BLOQUEAR_PENDIENTES_LEER==1 && $rDatos->campo('fnc_type', 0)==READ){
					return false;
				} else {
					if(BLOQUEAR_PENDIENTES_ESCRIBIR==1 && $rDatos->campo('fnc_type', 0)==WRITE){
						return false;
					} else {
						return true;
					}
				}
			} else {
				if($_SESSION['usu_status']==ST_NO_CONFIRMADO && $cod_permiso!="PROFILESELFEDIT"){
					return false;
				} else {
					return true;			
				}
			}
		} else {
			return false;
		}
	}
	static function tienePerfilActivo($id_usuario, $cod_perfil){
		$sql="SELECT role.rol_status FROM role, userrole  
		WHERE role.rol_status='".ST_ACTIVO."' AND role.rol_code='$cod_perfil' AND userrole.uro_rol_id=role.rol_id AND userrole.uro_usr_id=$id_usuario";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			if($_SESSION['usu_status']==ST_PENDIENTE){
				if(BLOQUEAR_PENDIENTES_LEER==1 && $rDatos->campo('fnc_type', 0)==READ){
					return false;
				} else {
					if(BLOQUEAR_PENDIENTES_ESCRIBIR==1 && $rDatos->campo('fnc_type', 0)==WRITE){
						return false;
					} else {
						return true;
					}
				}
			} else {
				if($_SESSION['usu_status']==ST_NO_CONFIRMADO && $cod_permiso!="PROFILESELFEDIT"){
					return false;
				} else {
					return true;			
				}
			}
		} else {
			return false;
		}
	}
	
	static function BuscarUsuariosAdmin(&$cantRegTotal, $inicio="", $tamanioPagina="", $orden_campo="", $orden_direccion="", $estado="", $busqueda_usuario="", $roles)
	{
		#Consulto la cantidad total de usuarios q cumplan con las claves de busqueda
		$sql = "SELECT COUNT(*) as total ";
		$sql_from=" FROM user";
		if(is_array($roles) && count($roles)>0){
			$sql_from.=" INNER JOIN userrole ON (uro_usr_id=usr_id) INNER JOIN role ON (uro_rol_id=rol_id AND rol_code IN(".implode(",",$roles)."))";
		}
		$sql_where=" WHERE 1";
		
		
		if(!empty($busqueda_usuario))
			$sql_where.= " AND ((CONCAT(usr_name, ' ', usr_lastname) LIKE '%" . $busqueda_usuario. "%') OR (usr_login LIKE '%".trim($busqueda_usuario)."%'))";

		
		if(!empty($estado)){
			$sql_where.= " AND usr_status ='$estado'";
		}
		$sql_group_by=" GROUP BY usr_id";

		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_group_by);
		$cantRegTotal = $rDatos->campo('total', 0);

		$sql = "SELECT user.usr_id, user.usr_name, user.usr_lastname, user.usr_login, usr_email, user.usr_status, usr_ast_id, GROUP_CONCAT(DISTINCT rol_name ORDER BY rol_name DESC SEPARATOR ' | ') roles_usuario ";

		$sql_order=" ORDER BY ";
		if(strlen($orden_campo))
			$sql_order .= $orden_campo." ".$orden_direccion;
		else
			$sql_order .= "user.usr_name";

		if(strlen($inicio) && strlen($tamanioPagina))
			$sql_limit= " LIMIT $inicio , $tamanioPagina ";

		$rDatos = cComando::consultar($sql.$sql_from.$sql_where.$sql_group_by.$sql_order.$sql_limit);
		return $rDatos;
	}	

	static function obtenerPorId($id_usuario)
	{
		$sql = "SELECT * FROM user  WHERE user.usr_id = $id_usuario";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
	

	static function obtenerPorIdContenido($id_contenido)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM user WHERE user.usr_ast_id = $id_contenido";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	

	static function eliminar($id_usuario)
	{
		$sql = "UPDATE user SET usr_status='".ST_BLOQUEADO."' WHERE usr_id = $id_usuario";
		cComando::ejecutar($sql, DELETE, $id);
		return;
	}
	
	
	static function GetMailsUsuarios()
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT usr_email FROM user WHERE usr_status='".ST_ACTIVO."' OR usr_status='".ST_PENDIENTE."'";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	


	static function loginFrontEnd($username, $password)
	{
		$sql = "SELECT user.*, DATE_FORMAT(usr_dateLastLogin, '%d de %M de %Y') as fecha_last_login
 FROM user WHERE usr_login = '".addslashes($username)."' AND usr_pass='". md5($password) ."'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			switch($rDatos->campo('usr_status', 0)){
				case ST_ACTIVO:
					$valor=$rDatos;
				break;
				case ST_BLOQUEADO:
					$valor=-4;
				break;
				case ST_NO_CONFIRMADO:
					$valor=-2;
				break;
				case ST_PENDIENTE:
					switch(BLOQUEAR_LOGIN_PENDIENTES){
						case 1:
							$valor=-1;
						break;
					
						case 0:
							$valor=$rDatos;
						break;
					}
				break;
			}
		} else {
			//No existe el usuario
			$valor=-3;
		}
		if(is_object($valor)){
			$sql="UPDATE user SET usr_dateLastLogin=".date("Ymd")." WHERE usr_id=".$rDatos->campo('usr_id', 0);
			cComando::ejecutar($sql, UPDATE, $id);
		}
		return $valor;
	}
	
	static function loginFrontEndCook($username, $password)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT user.*, DATE_FORMAT(usr_dateLastLogin, '%D %M, %Y') as fecha_last_login
 FROM user WHERE usr_login = '$username' AND usr_pass='".$password ."'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			switch($rDatos->campo('usr_status', 0)){
				case ST_ACTIVO:
					$valor=$rDatos;
				break;
				case ST_BLOQUEADO:
					$valor=-1;
				break;
				case ST_NO_CONFIRMADO:
					$valor=$rDatos;
				break;
				case ST_PENDIENTE:
					switch(BLOQUEAR_LOGIN_PENDIENTES){
						case 1:
							$valor=-1;
						break;
					
						case 0:
							$valor=$rDatos;
						break;
					}
				break;
			}
		} else {
			//No existe el usuario
			$valor=-1;
		}
		if(is_object($valor)){
			$sql="UPDATE user SET usr_dateLastLogin=".date("Ymd")." WHERE usr_id=".$rDatos->campo('usr_id', 0);
			cComando::ejecutar($sql, UPDATE, $id);
		}
		return $valor;
	}
	
	static function getNickName()
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT usr_id, usr_login FROM user ORDER BY usr_login";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function getUsuarioByEmail($email)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT usr_email, usr_login, usr_lng_id, usr_id FROM user WHERE usr_email='$email'";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function getUsuarioByUsername($username)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT usr_id, usr_email, emp_persona_contacto_email, emp_email FROM user, user_empresa, empresa WHERE usr_login='$username' AND usr_id=uem_usr_id AND uem_emp_id=emp_id";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function forgotClave($id_usuario)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$clave=cUsuario::activationKey(8);
		$sql="UPDATE user SET usr_pass='".md5($clave)."' WHERE usr_id=".$id_usuario;
		cComando::ejecutar($sql, UPDATE, $id);
		//cDB::cerrar();
		return $clave;
	}
	
	static function asociarPerfil($usuarioId, $perfilId)
	{
		$sql = "INSERT INTO userrole(uro_usr_id, uro_rol_id) VALUES ($usuarioId, $perfilId)";
		cComando::ejecutar($sql, INSERT, $id);
		return;
	}

	static function desasociarPerfiles($usuarioId)
	{
		$sql = "DELETE FROM userrole WHERE uro_usr_id=$usuarioId";
		cComando::ejecutar($sql, DELETE, $id);
		return;
	}

	static function perteneceAPerfil($usuarioId, $codigoPerfil)
	{
		$sql = "SELECT * 
				FROM userrole UP 
				INNER JOIN role P ON UP.uro_rol_id = P.rol_id 
					AND P.rol_code='$codigoPerfil' AND UP.uro_usr_id = $usuarioId";
		$rDatos = cComando::consultar($sql);
		return $rDatos->cantidad() > 0;
	}
	
	static function obtenerPerfiles($id_usuario)
	{
		$sql = "SELECT UP.*, P.roL_name as nombrePerfil
				FROM userrole UP
				INNER JOIN role P ON UP.uro_rol_id = P.rol_id
				WHERE uro_usr_id = $id_usuario";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
	
	static function getUserPreference($id_usuario, $pre_code){
		$sql="SELECT * FROM userpreference, preference WHERE upr_usr_id=$id_usuario AND pre_id=upr_pre_id AND pre_code='$pre_code'";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
	
	static function insertarPreferencia($id_usuario, $pre_code, $valor){
		$sql="DELETE FROM userpreference WHERE upr_usr_id=$id_usuario AND upr_pre_id=(SELECT pre_id FROM preference WHERE pre_code='$pre_code')";
		cComando::ejecutar($sql, DELETE, $id);
		$sql="INSERT INTO userpreference (upr_usr_id, upr_pre_id, upr_value) VALUES ($id_usuario, (SELECT pre_id FROM preference WHERE pre_code='$pre_code'), '$valor')";
		cComando::ejecutar($sql, INSERT, $id);
	}
	
}
?>