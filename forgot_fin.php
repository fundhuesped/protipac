<?php
include_once 'includes/config.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
	include_once 'clases/cUsuario.php';
	include_once 'clases/cEmpresa.php';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
	<? include_once("includes/head.php");?>
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
                	<h3 class="subtitulo_generico">Contrase&ntilde;a restablecida</h3>
					<div class="linea_sky"></div>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <p>Hemos enviado la nueva contrase&ntilde;a a su direcci&oacute;n de e-mail registrada<br />
                            en nuestro sistema.</p>
                            <br />
                            <p>Muchas gracias.</p>
                          </div>
                        </div>             
                </div>
            </div>
        </section>
        <? include_once("indexf.php");?>
    	</form>
    </body>
</html>
<? cDB::cerrar($conexion);?>