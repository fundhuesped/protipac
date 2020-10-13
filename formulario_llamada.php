<?php
include_once 'includes/config.php';
//error_reporting(E_ALL);
//ini_set("display_errors","On");
include_once 'clases/cPaciente.php';
include_once 'clases/cProtocolo.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
$permisoCargarVisitasPacientes=seguridadFuncion("CARGARVISITASPACIENTES");

if(!$permisoCargarVisitasPacientes){
	cDB::cerrar($conexion);
	header("Location:login.php");
	exit();
}
	$formulario="pacientes";
	$accion=filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$id_pac=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	$id_proto=filter_var($_REQUEST['id_proto'], FILTER_SANITIZE_NUMBER_INT);
	$id_visita=filter_var($_REQUEST['id_visita'], FILTER_SANITIZE_NUMBER_INT);

	$dest=filter_var($_POST['dest'], FILTER_SANITIZE_STRING);

	$permisoGuardar=true;
	echo($id_visi);
	if(!empty($id_visita) && !empty($id_proto)){
		$rVis=cPaciente::obtenerVisitaPaciente($id_visita,$id_proto);
		if($rVis->cantidad()==0){
			cDB::cerrar($conexion);
			echo("aaa");
			die();
			header("Location:index.php");
			exit();
		}
		$rPac=cPaciente::obtenerPaciente($id_pac);
		if($rPac->cantidad()==0){
			cDB::cerrar($conexion);
			echo("bbb");
			die();
			header("Location:index.php");
			exit();
		}
		$pac_apellido=$rPac->campo('pac_apellido',0);
		$pac_nombre=$rPac->campo('pac_nombre',0);
		$rVis=cPaciente::obtenerVisitaPaciente($id_visita,$id_proto);
		if($rVis->cantidad()==0){
			cDB::cerrar($conexion);
			echo("ccc");
			die();
			header("Location:index.php");
			exit();
		} 
		$nombre_visita=$rVis->campo('nombre_visita',0);
		
		$rPro=cProtocolo::obtenerProtocolo($id_proto,$id_pac);
		if($rPro->cantidad()==0){
			cDB::cerrar($conexion);
			echo("ddd");
			die();
			header("Location:index.php");
			exit();
		}
		$pro_titulo_breve=$rPro->campo('pro_titulo_breve',0);

	} else {
		cDB::cerrar($conexion);
			echo("eee");
			die();
		header("Location:index.php");
		exit();
	}


if($accion=="GUARDAR" && $permisoGuardar){
	$errorVar=$_POST['errorVar'];
	$res=cPaciente::modificarLlamada($_POST, $errorVar, $id_visita, $id_llamada);
	cDB::cerrar($conexion);
	header("Location:".$dest."?id=".$id_pac."&id_proto=".$id_proto."&id_visita=".$id_visita);
	exit();
}
$porcentaje=0;
$vecEmpresaStatus=array(ST_ACTIVO);
if(!empty($id_llamada)){
	if($permisoGuardar){
		$titulo_pagina="Editar visita";
	} else {
		$titulo_pagina="Ver visita";
	}
} else {
	$titulo_pagina="Cargar nueva llamada";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>

<? include_once("includes/head.php");?>
<script language="javascript" charset="utf-8">
	function validarFormulario(varDest, varMenu){
		<? if($permisoGuardar){?>
			varError=0;
			var errores="";
			with(document.datos){
				if($('#var_observaciones').val()==""){
					errores+="- Completar observaciones llamada<br>";
				}
			}
		
			if(errores!=""){
				if(varDest==""){
					$("#alerta").find("#alerta-titulo").text("Faltan completar datos.");
					$("#alerta").find("#alerta-cuerpo").html(errores.replace(/\n/g, "<br />"));
					$("#alerta").modal('show');
				} else {
					if(varDest!=""){
						$('#boton_modal_continuar').click(function(){
							document.datos.action=varDest;
							document.datos.target="_self";
							document.datos.submit();
						});
					}
				
					<?php if($permisoGuardar){?>
					$("#alerta-formulario").find("#alerta-titulo").text("Faltan completar datos.");
					$("#alerta-formulario").find('#alerta-cuerpo').html(errores.replace(/\n/g, "<br />"));
					$('#alerta-formulario').modal('show');
					<?php } else {?>
							document.datos.action=varDest;
							document.datos.target="_self";
							document.datos.submit();
					<?php }?>
				}
			} else {
				if(varDest==""){
					varDest="formulario_visita_paciente.php";
					document.datos.dest.value=varDest;
					document.datos.menu.value=varMenu;
					document.datos.errorVar.value=varError;
					document.datos.accion.value="GUARDAR";
					document.datos.v.value=1;
					document.datos.target="_self";
					document.datos.action="";
					document.datos.submit();
				} else {	
					<?php if($permisoGuardar){?>
					$("#alerta-formulario").find("#alerta-titulo").text("Si ha modificado datos, no se guardarán.");
					$('#boton_modal_continuar').click(function(){
						document.datos.v.value=1;
						document.datos.target="_self";
						document.datos.accion.value="";			
						document.datos.action=varDest;
						document.datos.submit();
					});
					$('#boton_modal_continuar').text("Abandonar SIN guardar");
					$('#boton_modal_cerrar').text("Permanecer en el formulario");
					$("#alerta-formulario").find('#alerta-cuerpo').html("Debe indicar si desea abandonar el formulario sin guardar, o bien permanecer y hacer clic en el botón guardar");
					$("#alerta-formulario").modal('show');
					<?php } else {?>
						document.datos.v.value=1;
						document.datos.target="_self";
						document.datos.accion.value="";			
						document.datos.action=varDest;
						document.datos.submit();
					<?php }?>
				}
			}
		<? } else {?>
			document.datos.v.value=1;
			document.datos.target="_self";
			document.datos.accion.value="";			
			document.datos.action=varDest;
			document.datos.submit();
		<? }//end if $permisoGuardar?>
	}
	
	function verVisita(){
		document.location='formulario_visita.php';
	}
	$(document).ready(function() {
		$("#var_observaciones").MaxLength(
		{
			MaxLength: 1000,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_caracteres_observaciones')
		});



	});
</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <body>
		<iframe name="frm" id="frm" class="hidden" width="0" height="0"></iframe>
		<? include_once("modal.php");?>
		<? include_once("modal_formulario.php");?>
	    <form name="datos" method="post" enctype="multipart/form-data">
        <input type="hidden" name="accion" />
        <input type="hidden" name="v" />
        <input type="hidden" name="errorVar" />
        <input type="hidden" name="dest" />
        <input type="hidden" name="menu" />
        <input type="hidden" name="id" value="<?=$id_pac?>" />
        <input type="hidden" name="id_proto" value="<?=$id_proto?>" />
        <input type="hidden" name="id_visita" value="<?=$id_visita?>" />
		<? include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Visitas de pacientes</h2>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 right mt-20">
	                <a href="javascript:validarFormulario('formulario_visita_paciente.php','')" class="white back-bread"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Volver</a>
                </div>
            </div>
        </section>
        <section class="main-content generico-container">
            <div class="container">
				<? include_once("indexl_fichas.php");?>
                <div class="col-md-10 col-sm-10 col-xs-12 container-right fondo_home">
                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 fondo_blanco">
	                	<h3 class="subtitulo_generico"><?=$titulo_pagina?>&nbsp;-&nbsp;<?=$nombre_visita?>&nbsp;-&nbsp;<?=strtoupper($pac_apellido).', '.ucfirst($pac_nombre)?><?="&nbsp;-&nbsp;Protocolo&nbsp;".$pro_titulo_breve?></h3>
						<div class="linea_sky"></div>
								<p id="submenu">

								</p>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Observaciones llamada</label>&nbsp;
                            <textarea style="resize:none" name="var_observaciones" id="var_observaciones" class="form-control" <?=$estadoRO?>><?=$proseg_observaciones?></textarea>
                            <label>
                                <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_observaciones" class="letra_help" style="float:left"></div>
                            </label>
                          </div>

                        </div>
                        
                        <div class="row">
                        <? if($permisoGuardar){?>
						  	<button type="button" class="btn boton-generico btn-primary" onClick="validarFormulario('','')">Guardar</button>
                        <? }?>
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
