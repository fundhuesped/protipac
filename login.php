<?php
include_once 'includes/config.php';
if($_SESSION['id_usu']!=-1){
	header("Location:protocolos.php");
	exit();
}
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
	include_once 'clases/cUsuario.php';
	$accion			= filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$username		= substr(filter_var($_POST['username'], FILTER_SANITIZE_STRING),0,11);
	$password		= filter_var($_POST['clave'], FILTER_SANITIZE_STRING);
	$mensaje_login="";

	if($accion=="LOGIN"){
		$rDatos = cUsuario::loginFrontEnd($username, $password);
			if(is_object($rDatos)){
				$id_usuario				= $rDatos->campo('usr_id', 0);			
				$username				= $rDatos->campo('usr_login', 0);			
				$apellido				= $rDatos->campo('usr_lastname', 0);
				$nombre					= $rDatos->campo('usr_name', 0);
				$email					= $rDatos->campo('usr_email', 0);
				$usr_status				= $rDatos->campo('usr_status', 0);

				$_SESSION['id_usu']=$id_usuario;
				$_SESSION['usr_username']=$username;
				$_SESSION['usu_name']=$nombre;
				$_SESSION['usu_lastname']=$apellido;
				$_SESSION['usu_status']=$usr_status;
				$destino="protocolos.php";
				switch($accion){
					case "LOGIN":
						if($usr_status==ST_NO_CONFIRMADO){
							cDB::cerrar($conexion);
							header("Location:".$destino);
							exit();
						} else {
							cDB::cerrar($conexion);
							header("Location:".$destino);
							exit();
						}
					break;					
				}
			} else {
				switch($rDatos){
					case -1:
						$mensaje_login="Aún no tiene permitido el acceso, ante cualquier duda, contáctenos.";
					break;
					case -4:
						$mensaje_login="Ha sido inhabilitado para operar con el registro, ante cualquier duda, contáctenos.";
					break;
					case -3:
						$mensaje_login="Usuario y / o Contraseña incorrectos.";
					break;
					case -2:
						$mensaje_login="Su acceso aún no ha sido confirmado. Se envió un mensaje de confirmación a su dirección de E-mail\nPor favor siga las instrucciones allí consignadas.";		
					break;
				}
			}
	}
	

	

	
?>
<!DOCTYPE html>
<html lang="en">
    <head>

<? include_once("includes/head.php");?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
    <!--
    	function validar()
		{
			
			var errores = "";
			
			with(document.datos)
			{
				if(username.value == "")
					errores += "- Debe ingresar el Usuario del operador\n";

				if(clave.value == "")
					errores += "- Debe ingresar la Contraseña\n";

				if(errores=="")
				{
					accion.value = "LOGIN";
					submit();
				}
				else
				{
					alert(errores);
				}
			}
		}
		

		$(document).ready(function() {
			<? if(strlen($mensaje_login)>0){?>
				$('#alerta-titulo').text("Atención");
				$('#alerta-cuerpo').html("<?=$mensaje_login?>");
				$('#alerta').modal('show');
			<? }?>

		});
    //-->
    </SCRIPT>
    </head>
    <body>
		<? include_once("modal.php");?>
	    <form name="datos" method="post">
        <input type="hidden" name="accion" />
        <input type="hidden" name="errorVar" />
        <input type="hidden" name="dest" />
		<? include_once("indexh.php");?>
        <section class="main-content generico-container">
            <div class="container container-full">
                <div class="col-md-12 col-xs-12 container-generico">
                	<h3 class="subtitulo_generico">Ingresar</h3>
					<div class="linea_sky"></div>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label for="razon_social">Usuario</label>
                                <input type="text" class="form-control" name="username" maxlength="11" placeholder="Sin guiones ni puntos">
                          </div>
                          <div class="form-group col-md-12">
                            <label for="razon_social">Contraseña</label>
                                <input type="password" class="form-control" name="clave" maxlength="255">
                          </div>
                          <div class="col-md-12">
							<a href="forgot.php">Olvidé mi contraseña</a>
                          </div>
                        </div>
                        <div class="row">
					  	<button type="button" class="btn boton-generico btn-primary" onClick="validar()">Ingresar</button>
                        </div>
              
                </div>
            </div>
        </section>
        <? include_once("indexf.php");?>
    	</form>
    </body>
</html>
<? cDB::cerrar($conexion);?>