<?php
include_once 'includes/config.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
	include_once 'clases/cEmpresa.php';
	include_once 'clases/cPais.php';
	$accion			= filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$usuario		= filter_var($_POST['usuario'], FILTER_SANITIZE_STRING);
	if(seguridadFuncion("REGISTRAREMPRESA")){
		cDB::cerrar($conexion);
		header("Location:index.php");
		exit();
	}
	switch($accion){
		case "GUARDAR":
				$rDatos = cUsuario::getUsuarioByUsername($usuario);
				if($rDatos->cantidad() > 0)
				{

					$id_usuario				= $rDatos->campo('usr_id', 0);
					$emp_email=$rDatos->campo('emp_email',0);
					$emp_persona_contacto_email=$rDatos->campo('emp_persona_contacto_email',0);

					$clave=cUsuario::forgotClave($id_usuario);
					//enviar mail
					$contenido_email = leerArchivo('templates/olvido_clave.tpl');
					$contenido_email = str_replace("##USERNAME##", utf8_decode($username), $contenido_email);
					$contenido_email = str_replace("##CLAVE##", utf8_decode($clave), $contenido_email);
					$contenido_email = str_replace("##SITIO##", SITIO,  $contenido_email);
					$contenido_email = str_replace("##LINK##", LINK_LOGIN , $contenido_email);
					$contenido_email = str_replace("##NOMBRE_WEBMASTER##", NOMBRE_WEBMASTER , $contenido_email);
	
					include_once('clases/class.phpmailer.php');
					$mail = new phpmailer();
					$mail->Host       = MAILER; // SMTP server
					//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
					//$mail->SMTPAuth   = _MAIL_AUTH;                  // enable SMTP authentication
					//$mail->Port       = _MAIL_PORT;                    // set the SMTP port for the GMAIL server
					//$mail->IsSMTP();
					//$mail->Encoding = "base64";
					//$mail->CharSet = 'ISO-8859-1';
					//$mail->SMTPSecure = _MAIL_SECURE;
					$mail->IsHTML(false);
					//$mail->Username = _MAIL_USER;
					//$mail->Password = _MAIL_PASS;
					//$mail->AddReplyTo($var_email, $var_razon_social);
					$mail->AddAddress($usuario_email, $usuario_email);
					$mail->SetFrom(_MAIL_FROM, utf8_decode(NOMBRE_WEBMASTER_MAIL));
					$mail->Subject    = utf8_decode("Reiniciar Contraseña Protipac");
					$mail->Body    = str_replace("?","",utf8_decode($contenido_email));
					
					if(!$mail->Send()){
						cDB::cerrar($conexion);
						$mail->ClearAddresses();
						header("Location:forgot_error.php");
						exit();		
						//echo $mail->ErrorInfo;
		
					} else {
						cDB::cerrar($conexion);
						$mail->ClearAddresses();
						header("Location:forgot_fin.php");
						exit();
					}
		

				} else {
					$error="El Usuario ingresado no está registrado o bien ha sido inhabilitado.";				
				}
		break;
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>

<? include_once("includes/head.php");?>
<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
    <!--
    	function validar(varAccion)
		{
			
			var errores = "";
			with(document.datos)
			{		
				if(usuario.value==""){
					errores+="- Debe completar el nombre de Usuario\n";
				}
				if(errores=="")
				{
					accion.value = "GUARDAR";
					submit();
				}
				else
				{
					alert(errores);
				}
			}
		}
		

		$(document).ready(function() {

		});

    //-->
    </SCRIPT>
	<? if(strlen($mensaje_login)>0){?>
        <script language="javascript">
            alert("<?=$mensaje_login?>");
        </script>
    <? }?>
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
                	<h3 class="subtitulo_generico">Ingrese su Usuario para reestablecer su contraseña</h3>
					<div class="linea_sky"></div>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label for="razon_social">Usuario</label>
                                <input type="text" class="form-control" name="usuario" value="<?=$usuario?>"maxlength="8" placeholder="Sin guiones ni puntos" <?=$estado?>>
                          </div>
						<? echo('<div class="form-group col-md-12">
                                <p style="float:left;color:#FF0000"><strong>'.$error.'</strong></p>
                        </div>');?>
                        </div>
                        <div class="row">
					  	<button type="button" class="btn boton-generico btn-primary" onClick="validar('')">Enviar</button>
                        </div>
              
                </div>
            </div>
        </section>
        <? include_once("indexf.php");?>
    	</form>
    </body>
</html>
<? cDB::cerrar($conexion);?>