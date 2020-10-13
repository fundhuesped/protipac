<?php
include_once 'includes/config.php';
//error_reporting(E_ALL);
//ini_set("display_errors","On");
include_once 'clases/cContenido.php';
include_once 'clases/cFormulario.php';
include_once 'clases/cProtocolo.php';
include_once 'clases/cEstadoProPaciente.php';
include_once 'clases/cPaciente.php';
include_once 'clases/cMedico.php';

$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
$permisoEnrolar=seguridadFuncion("ENROLARPACIENTES");
$permisoVerVisitasPacientes=seguridadFuncion("VERVISITASPACIENTES");

if(!$permisoEnrolar){
	cDB::cerrar($conexion);
	header("Location:login.php");
	exit();
}
	$formulario="pacientes";
	$_SESSION['pagina_volver']="formulario_protocolo_paciente.php";
	$accion=filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	$id_proto=filter_var($_REQUEST['id_proto'], FILTER_SANITIZE_NUMBER_INT);
	$dest=filter_var($_POST['dest'], FILTER_SANITIZE_STRING);

	$permisoGuardar=true;
	if(!empty($id)){
		$rPac=cPaciente::obtenerPaciente($id);
		if($rPac->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		} else {
			foreach(array_keys($rPac->CAMPOS) as $campo){
				${$campo}=$rPac->campo($campo,0);
			}
		}
	} else {
		cDB::cerrar($conexion);
		header("Location:index.php");
		exit();
	}
	

	if(!empty($id_proto)){
		$rPro=cProtocolo::obtenerProtocolo($id_proto,$id);
		if($rPro->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		} else {
			$faltan_visitas=false;
			if(!cProtocolo::tieneScrBasal($id_proto)){
				$permisoGuardar=false;
				$faltan_visitas=true;
			}
			foreach(array_keys($rPro->CAMPOS) as $campo){
				${$campo}=$rPro->campo($campo,0);
			}
			$sql="SELECT PPAC.ppaclog_fecha_estado FROM protocolo_paciente_log PPAC INNER JOIN (SELECT MAX(ppaclog_id) id FROM protocolo_paciente_log pl WHERE pl.ppaclog_pro_id='$id_proto' AND pl.ppaclog_pac_id='$id' AND pl.ppaclog_spp_id=$propac_spp_id) ppl ON (ppl.id=PPAC.ppaclog_id)";
			$rFecha=cComando::consultar($sql);
			if($rFecha->cantidad()>0){
				$fecha_estado=$rFecha->campo('ppaclog_fecha_estado',0);
			}
		}
		if($permisoGuardar){
			$titulo_pagina="Editar paciente ".strtoupper($pac_apellido).", ".ucfirst($pac_nombre).", HC: ".$pac_id." en protocolo: ".$pro_titulo_breve;
		} else {
			$titulo_pagina="Ver paciente ".strtoupper($pac_apellido).", ".ucfirst($pac_nombre).", HC: ".$pac_id." en protocolo: ".$pro_titulo_breve;
		}
	} else {
		$titulo_pagina="Cargar nuevo protocolo para ".strtoupper($pac_apellido).", ".ucfirst($pac_nombre).", HC: ".$pac_id;
	}


if($accion=="GUARDAR" && $permisoGuardar){
	$errorVar=$_POST['errorVar'];
	$res=cPaciente::modificarPacienteProtocolo($_POST, $errorVar, $id, $id_proto);
	if($res==-2){
		$mensaje="Para guardar los cambios, el protocolo debe tener al menos cargadas en su cronograma las visitas screening y basal";
	} else {
		cDB::cerrar($conexion);
		header("Location:".$dest."?id=".$id);
		exit();
	}
}

if($accion=="PROGRAMAR" && $permisoGuardar){
	$hora_inicio=filter_var($_POST['hora_inicio'], FILTER_SANITIZE_NUMBER_INT);
	$minutos_inicio=filter_var($_POST['minutos_inicio'], FILTER_SANITIZE_NUMBER_INT);
	cPaciente::programarVisitasPacienteProtocolo($id_proto,$id,$hora_inicio,$minutos_inicio);
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
			var err_fecha_scr=0;
			var err_fecha_basal=0;
			var aprob_scr=0;
			var realiz_basal=0;
			with(document.datos){
                <?php if(strlen($id_proto)==0){?>
					if($('#var_pro_id').val()==""){
						errores+="- Protocolo<br>";
					}
				<?php }?>
				if($('#var_nro_protocolo').val()==""){
					errores+="- Número Scr.<br>";
				}
				/*if($('#var_nro_random').val()==""){
					errores+="- Número Random<br>";
				}*/
				if(parseInt($('#var_spp_id').val(),10)!=<?=ST_PP_SCR?> && parseInt($('#var_spp_id').val(),10)!=<?=ST_PP_PROTOCOLO?>){
					if($('#fecha_estado').val()==""){
						errores+="- Fecha estado<br>";
					}
				}
				<?php if(strlen($id_proto)>0){?>
				/*if($('#var_basal').val()!=""){
					if($('#var_basal').val()=="1"){
						realiz_basal=1;
					}
					if($('#fecha_basal').val()==""){
						errores+="- Fecha basal<br>";
						err_fecha_basal=1;
					} else {
						if($('#fecha_screening').val()==""){
							errores+="- Fecha screening<br>";
							err_fecha_scr=1;
						}
						if($('#var_screening').val()==""){
							errores+="- Aprobó screening<br>";
						} else {
							if($('#var_screening').val()=="1"){
								aprob_scr=1;
							}
						}
					}
				}*/
				if($('#fecha_screening').val()!="" && $('#fecha_basal').val()!=""){
					varFechaScreening=new Date($('#fecha_screening').val());
					varFechaBasal=new Date($('#fecha_basal').val());
					
					if(varFechaScreening>=varFechaBasal){
						errores+="- La fecha de screening debe ser menor a la fecha de la visita basal<br>";
						//err_fecha_scr=1;
						//err_fecha_basal=1;
					}
				}
				<?php } else {?>
					if($('#fecha_screening').val()==""){
						errores+="- Fecha screening<br>";
						//err_fecha_scr=1;
					}
				<?php }?>

				if($('#var_spp_id').val()==<?=ST_PP_SCR?> || $('#var_spp_id').val()==<?=ST_PP_PROTOCOLO?>){
					if($('#var_med_id').val()==""){
						errores+="- Médico<br>";
					}
				}
				if($('#var_spp_id').val()==<?=ST_PP_PROTOCOLO?>){
					if($('#fecha_basal_realizada').val()==""){
						errores+="- Fecha realización basal<br>";
					}
				}
				if($('#var_spp_id').val()==""){
					errores+="- Estado del paciente en el protocolo<br>";
				} else {
					/*if(parseInt($('#var_spp_id').val(),10)==<?//=ST_PP_SCR?>){
						if(!(err_fecha_scr==0 && aprob_scr==1) || err_fecha_basal==0 && realiz_basal==1){
							errores+="- Solo puede pasar a estado SCREENING si no realizó visita basal y aprobó screening";
						}
						
					}*/
					/*if(parseInt($('#var_spp_id').val(),10)==<?//=ST_PP_PROTOCOLO?>){
						if(err_fecha_scr==1 || aprob_scr==0 || err_fecha_basal==1 || realiz_basal==0){
							errores+="- Solo puede pasar a estado EN PROTOCOLO si aprobó el screening y realizó la visita basal";
						}
						
					}
					if(parseInt($('#var_spp_id').val(),10)==<?//=ST_PP_COMPLETADO?>){
						if(err_fecha_scr==1 || aprob_scr==0 || err_fecha_basal==1 || realiz_basal==0){
							errores+="- Solo puede pasar a estado COMPLETADO si aprobó el screening y realizó la visita basal";
						}
						
					}
					if(parseInt($('#var_spp_id').val(),10)==<?//=ST_PP_FALLOSCR?>){
						if((err_fecha_scr==0 && aprob_scr==1) || (err_fecha_basal==0 && realiz_basal==1)){
							errores+="- Solo puede pasar a estado FALLO SCREENING si aprobó el screening y realizó la visita basal";
						}
						
					}*/
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
					varDest="formulario_paciente.php";
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
	
	function verVisita(varIdVisita){
		document.datos.id_visita.value=varIdVisita;
		document.datos.action="formulario_visita_paciente.php";
		document.datos.submit();
	}
	function programar(){
		<?php if($propac_spp_id==ST_PP_PROTOCOLO){?>
			if($("#hora_inicio").val()!="" && $("#minutos_inicio").val()!=""){
				$("#alerta-formulario").find("#alerta-titulo").text("Programar las visitas.");
				$('#boton_modal_continuar').click(function(){
					document.datos.accion.value="PROGRAMAR";
					document.datos.action="formulario_protocolo_paciente.php";
					document.datos.submit();
				});
				$('#boton_modal_continuar').text("Continuar con la acción");
				$('#boton_modal_cerrar').text("Cancelar");
				$("#alerta-formulario").find('#alerta-cuerpo').html("Programar las visitas significa que todas las visitas que aún no hayan sido realizadas serán programadas para este paciente según el cronograma definido para el protocolo en el horario elegido.<br>Si ya las programó anteriormente, esta acción sobre escribirá lo hecho en aquella oportunidad.");
				$("#alerta-formulario").modal('show');
			} else {
				$("#alerta").find("#alerta-titulo").text("Programar las visitas.");
				$("#alerta").find('#alerta-cuerpo').html("Debe elegir horario de inicio que aplicará a todas las visitas.");
				$("#alerta").modal('show');
			}
		<?php } else {?>
			$("#alerta").find("#alerta-titulo").text("No se puede programar.");
			$("#alerta").find('#alerta-cuerpo').html("Solo puede programar las visitar automáticamente si el estado es \"En protocolo\"");
			$('#alerta').modal('show');
		<?php }?>
	}

	$(document).ready(function() {
		$('#fecha_screening').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#fecha_basal').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#fecha_basal_realizada').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#fecha_estado').datepicker({ dateFormat: 'yy-mm-dd' });
		/*$("#obs_visitas").MaxLength(
		{
			MaxLength: 1000,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_caracteres_obs')
		});*/

		$.fn.select2.defaults.set("theme", "bootstrap");
		$('#var_pro_id').select2({
			width: null,
			tags:true
		});		
		<?php if(strlen($mensaje)>0){?>
			$("#alerta").find("#alerta-titulo").text("Ocurrió un error.");
			$("#alerta").find("#alerta-cuerpo").html("<?=$mensaje?>");
			$("#alerta").modal('show');
		<?php }?>
		
		$('#var_spp_id').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?=ST_PP_FALLOSCR?>:
					$("#var_nro_protocolo").attr("readonly","readonly");
					$("#var_nro_random").attr("readonly","readonly");
					$("#caja_rnd").hide();
					$("#caja_scr").show();
					$("#caja_fecha_scr").hide();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_estado").show();
					$('#fecha_estado').removeAttr("disabled");
					$('#var_med_id').attr("disabled","disabled");
					$('#caja_medico').hide();
				break;
				case <?=ST_PP_SCR?>:
					$("#caja_scr").removeAttr("readonly");
					$("#var_nro_random").attr("readonly","readonly");
					$("#caja_rnd").hide();
					$("#caja_scr").show();
					$("#caja_fecha_scr").show();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').removeAttr("disabled");
					$("#caja_fecha_estado").hide();
					$('#fecha_estado').attr("disabled","disabled");
					$('#var_med_id').removeAttr("disabled");
					$('#caja_medico').show();
				break;
				case <?=ST_PP_PROTOCOLO?>:
					$("#var_nro_protocolo").attr("readonly","readonly");
					$("#var_nro_random").removeAttr("readonly");
					$("#caja_rnd").show();
					$("#caja_scr").show();
					$("#caja_fecha_basal").show();
					$('#fecha_basal_realizada').removeAttr("disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_estado").hide();
					$('#fecha_estado').attr("disabled","disabled");
					$('#var_med_id').removeAttr("disabled");
					$('#caja_medico').show();
				break;
				case <?=ST_PP_COMPLETADO?>:
					$("#caja_scr").attr("readonly","readonly");
					$("#caja_rnd").attr("readonly","readonly");
					$("#caja_rnd").show();
					$("#caja_scr").show();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_scr").hide();
					$("#caja_fecha_basal").hide();
					$("#caja_fecha_estado").show();
					$('#fecha_estado').removeAttr("disabled");
					<?php if($propac_spp_id==ST_PP_PROTOCOLO){?>
						$('#fecha_estado').val("");
					<?php }?>
					$('#var_med_id').attr("disabled","disabled");
					$('#caja_medico').hide();
				break;
				case <?=ST_PP_DISCONTINUADO?>:
					$("#caja_scr").attr("readonly","readonly");
					$("#caja_rnd").attr("readonly","readonly");
					$("#caja_rnd").show();
					$("#caja_scr").show();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_scr").hide();
					$("#caja_fecha_basal").hide();
					$("#caja_fecha_estado").show();
					$('#fecha_estado').removeAttr("disabled");
					<?php if($propac_spp_id==ST_PP_PROTOCOLO){?>
						$('#fecha_estado').val("");
					<?php }?>
					$('#var_med_id').attr("disabled","disabled");
					$('#caja_medico').hide();
				break;
			}
		});
			switch(parseInt($('#var_spp_id').val(),10)){
				case <?=ST_PP_FALLOSCR?>:
					$("#var_nro_protocolo").attr("readonly","readonly");
					$("#var_nro_random").attr("readonly","readonly");
					$("#caja_rnd").hide();
					$("#caja_scr").show();
					$("#caja_fecha_scr").hide();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_estado").show();
					$('#fecha_estado').removeAttr("disabled");
					$('#var_med_id').attr("disabled","disabled");
					$('#caja_medico').hide();
				break;
				case <?=ST_PP_SCR?>:
					$("#caja_scr").removeAttr("readonly");
					$("#var_nro_random").attr("readonly","readonly");
					$("#caja_rnd").hide();
					$("#caja_scr").show();
					$("#caja_fecha_scr").show();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').removeAttr("disabled");
					$("#caja_fecha_estado").hide();
					$('#fecha_estado').attr("disabled","disabled");	
					$('#caja_medico').show();
				break;
				case <?=ST_PP_PROTOCOLO?>:
					$("#var_nro_protocolo").attr("readonly","readonly");
					$("#var_nro_random").removeAttr("readonly");
					$("#caja_rnd").show();
					$("#caja_scr").show();
					$("#caja_fecha_basal").show();
					$('#fecha_basal_realizada').removeAttr("disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_estado").hide();
					$('#fecha_estado').attr("disabled","disabled");
					$('#caja_medico').show();
				break;
				case <?=ST_PP_COMPLETADO?>:
					$("#caja_scr").attr("readonly","readonly");
					$("#caja_rnd").attr("readonly","readonly");
					$("#caja_rnd").show();
					$("#caja_scr").show();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_scr").hide();
					$("#caja_fecha_basal").hide();
					$("#caja_fecha_estado").show();
					$('#fecha_estado').removeAttr("disabled");
					$('#var_med_id').attr("disabled","disabled");
					$('#caja_medico').hide();
				break;
				case <?=ST_PP_DISCONTINUADO?>:
					$("#caja_scr").attr("readonly","readonly");
					$("#caja_rnd").attr("readonly","readonly");
					$("#caja_rnd").show();
					$("#caja_scr").show();
					$("#caja_fecha_basal").hide();
					$('#fecha_basal_realizada').attr("disabled","disabled");
					$('#fecha_screening').attr("disabled","disabled");
					$("#caja_fecha_scr").hide();
					$("#caja_fecha_basal").hide();
					$("#caja_fecha_estado").show();
					$('#fecha_estado').removeAttr("disabled");
					$('#var_med_id').attr("disabled","disabled");
					$('#caja_medico').hide();
				break;
			}
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
        <input type="hidden" name="id" value="<?=$id?>" />
        <input type="hidden" name="id_proto" value="<?=$id_proto?>" />
        <input type="hidden" name="id_visita" value="" />
        <input type="hidden" name="id_cont" value="<?=$pro_ast_id?>" />
		<? include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Protocolo - Paciente</h2>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 right mt-20">
	                <a href="javascript:validarFormulario('formulario_paciente.php','')" class="white back-bread"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Volver</a>
                </div>
            </div>
        </section>
        <section class="main-content generico-container">
            <div class="container">
				<? include_once("indexl_fichas.php");?>
                <div class="col-md-10 col-sm-10 col-xs-12 container-right fondo_home">
                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 fondo_blanco">
	                	<h3 class="subtitulo_generico"><?=$titulo_pagina?></h3>
						<div class="linea_sky"></div>
								<p id="submenu">

								</p>
                        <div class="row">
                        <?php if(strlen($id_proto)==0){?>
                          <div class="form-group col-md-4">
                            <label>*Protocolo</label>
                            <? armarCombo(cProtocolo::obtenerComboNotPaciente($id, array(ST_ACTIVO)), "var_pro_id", "form-control", $estadoDis, $propac_pro_id, "[Elegir]");?>
                          </div>
                         <?php }?>
                          <div class="form-group col-md-4" id="caja_scr">
                            <label>*Número Scr</label>
                            <input type="text" name="var_nro_protocolo" id="var_nro_protocolo" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$propac_nro_protocolo?>" />
                          </div>
                          <div class="form-group col-md-4" id="caja_rnd">
                            <label>Número random</label>
                            <input type="text" name="var_nro_random" id="var_nro_random" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$propac_nro_random?>" />
                          </div>
						</div>
                        <div class="row" id="caja_fecha_estado">
                          <div class="form-inline col-md-4">
                            <label>*Fecha estado</label><br>
                            <input type="text" readonly="readonly" size="20" id="fecha_estado" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="fecha_estado" class="form-control" value="<?=(strlen($fecha_estado)>0 ? $fecha_estado : date("Y-m-d"))?>">&nbsp;<? if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.fecha_estado.value = '';"><? }?>
                          </div>
						</div>
                        <div class="row" id="caja_fecha_scr">
                          <div class="form-inline col-md-4">
                            <br><label>*Fecha screening</label><br>
                            <input type="text" readonly="readonly" size="20" id="fecha_screening" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="fecha_screening" class="form-control" value="<?=substr((strlen($fecha_screening)>0 ? $fecha_screening : date("Y-m-d")),0,10)?>">&nbsp;<? if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.fecha_screening.value = '';"><? }?>
                          </div>
                          <!--
                          <div class="form-group col-md-4">
                            <label>Aprobó screening</label><br>
                            <select name="var_screening" id="var_screening" class="form-control" <?//=$estadoDis?>>
                            	<option value=""  <?//=($propac_screening==="" || is_null($propac_screening) ? "selected" : "")?>>[Elegir]</option>
                                <option value="1" <?//=($propac_screening==1 ? "selected" : "")?>>Sí</option>
                                <option value="0" <?//=($propac_screening===0 && !is_null($propac_screening) ? "selected" : "")?>>No</option>
                            </select>
                          </div>-->
                        </div>
                        <?php if(strlen($id_proto)>0){?>
                            <div class="row" id="caja_fecha_basal">
                              <div class="form-inline col-md-4">
                                <label>Fecha basal agenda</label><br>
                                <input type="text" disabled readonly="readonly" size="20" id="fecha_basal" style="z-index:100;position:relative;max-width:99%;background-color:#eee" name="fecha_basal" class="form-control" value="<?=substr($fecha_basal,0,10)?>">&nbsp;<?php //if($permisoGuardar){<input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.fecha_basal.value = '';">}?>
                              </div>
                              <div class="form-inline col-md-4">
                                <label>*Fecha realización basal</label><br>
                                <input type="text" readonly="readonly" size="20" id="fecha_basal_realizada" style="z-index:100;position:relative;max-width:99%;background-color:#fff" name="fecha_basal_realizada" class="form-control" value="<?=substr($fecha_basal_realizada,0,10)?>">&nbsp;<?php if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.fecha_basal_realizada.value = '';"><?php }?>
                              </div>
                              <div class="form-group col-md-4">
                                <!--<label>*Realizó visita basal (es como el OK)</label><br>
                                <select name="var_basal" id="var_basal" class="form-control" <?//=$estadoDis?>>
                                    <option value=""  <?//=($propac_basal=="" || is_null($propac_basal) ? "selected" : "")?>>[Elegir]</option>
                                    <option value="1" <?//=($propac_basal==1 ? "selected" : "")?>>Sí</option>
                                    <option value="0" <?//=($propac_basal==0 && strlen($propac_basal)>0 ? "selected" : "")?>>No</option>
                                </select>-->
                              </div>
                            </div>
                        <?php }?>
                        <div class="row">
                          <div class="form-group col-md-4" id="caja_medico">
                            <label><br>
*Médico</label>&nbsp;
                            <? 	armarCombo(cMedico::obtenerCombo(), "var_med_id", "form-control", " id=\"var_med_id\" ".$estadoDis, $medico_id, "[Elegir]");?>

                          </div>
                          <div class="form-group col-md-4"><br>

                            <label>*Estado paciente en protocolo</label>&nbsp;
							<?php 
							if(strlen($id_proto)>0){
								switch($propac_spp_id){
									case ST_PP_SCR:
										$vecEstadosProPac=array(ST_PP_SCR,ST_PP_PROTOCOLO,ST_PP_FALLOSCR);
									break;
									case ST_PP_FALLOSCR:
										$vecEstadosProPac=array(ST_PP_SCR,ST_PP_FALLOSCR);
									break;
									case ST_PP_PROTOCOLO:
										$vecEstadosProPac=array(ST_PP_PROTOCOLO,ST_PP_COMPLETADO,ST_PP_DISCONTINUADO);
									break;
									case ST_PP_DISCONTINUADO:
										$vecEstadosProPac=array(ST_PP_DISCONTINUADO,ST_PP_COMPLETADO,ST_PP_PROTOCOLO);
									break;
									case ST_PP_COMPLETADO:
										$vecEstadosProPac=array(ST_PP_COMPLETADO,ST_PP_DISCONTINUADO,ST_PP_PROTOCOLO);
									break;
								}?>
                                <?php armarCombo(cEstadoProPaciente::obtenerCombo(ST_ACTIVO,$vecEstadosProPac), "var_spp_id", "form-control", " id=\"var_spp_id\" ".$estadoDis, $propac_spp_id, "[Elegir]");?>

							<?php } else {
								echo('<select disabled class="form-control"><option value="'.ST_PP_SCR.'">Screening</option></select>');
								echo('<input type="hidden" name="var_spp_id" id="var_spp_id" value="'.ST_PP_SCR.'">');
							}?>
                           </div>
                        </div>
                        <div class="row">
                        <?php if($permisoGuardar){?>
						  	<button type="button" class="btn boton-generico btn-primary" onClick="validarFormulario('','')">Guardar</button>
                        <?php } else {
							if($faltan_visitas==true){?>
						  	<button type="button" class="btn boton-generico btn-primary" onClick="alert('Para guardar los cambios, el protocolo debe tener al menos cargadas en su cronograma las visitas screening y basal')">Guardar</button>
						<?php }
						}?>
                        </div>
                            <?php //if($permisoVerLogProyecto){?>
                            		<div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                         <h4>Historial del paciente en el protocolo</h4>
                                          <div class="table-responsive">          
                                          <table class="table table-hover">
                                            <thead>
                                              <tr>
                                                <th>Fecha estado</th>
                                                <th>Estado</th>
                                                <th>Comentario</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                <?
                                                /*$rProLog=cProtocolo::getProyectoLog($pro_id);
                                                if($rProLog->cantidad()>0 && ($pro_status!=ST_BORRADOR)){
                                                    for($i=0;$i<$rProLog->cantidad();$i++){*/?>
                                                      <!--<tr>
                                                        <td><p class="texto-publicacion letra-gris-oscuro"><?//=convertirFechaHora($rProLog->campo('plog_fecha_hora',$i))?></p></td>
                                                        <td><p class="texto-publicacion letra-gris-oscuro"><?//=$rProLog->campo('sp_descripcion',$i)?></p></td>
                                                        <td><p class="texto-publicacion letra-gris-oscuro"><?//=$rProLog->campo('plog_comentario',$i)?></p></td>
                                                      </tr>-->
                                                 <? //}//end for
                                               // } else {?>
                                                      <tr>
                                                        <td colspan="3">No se encontraron registros</td>
                                                      </tr>
                                                <? //}//end if?>
                                            </tbody>
                                          </table>
                                          </div>
                                        </div>
                                        </div>
							<?php //}?>
                            
							<? if($permisoGuardar && !empty($id_proto) && $permisoVerVisitasPacientes){?>
							<a name="visitas"></a>
                           <div class="row"><div class="col-md-12 col-lg-12 col-xs-12 col-md-12 col-sm-12 linea_gris"></div></div>
                           <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h3 class="subtitulo_generico">Visitas programadas</h3>
                                </div>
                           </div>
                           <div class="row">
                           <?php if($propac_spp_id==ST_PP_PROTOCOLO){?>
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-inline">
                                      <div class="form-inline mr-15">
                                        <label>*Hora inicio</label>
                                        <select style="max-width:100px" name="hora_inicio" id="hora_inicio" class="form-control">
                                        	<option value="">[Hora]</option>
                                            <?php
											for($i=0;$i<=23;$i++){
												echo('<option value="'.$i.'">'.completarNumeroIzq($i,2).'</option>');
											}
                                            ?>
                                        </select>:
										<select style="max-width:100px" name="minutos_inicio" id="minutos_inicio" class="form-control">
                                        	<option value="">[Min.]</option>
                                            <?php
											for($i=0;$i<=59;$i++){
												echo('<option value="'.$i.'">'.completarNumeroIzq($i,2).'</option>');
											}
                                            ?>
                                        </select>
                                      </div>
                                      <!--<div class="form-group mr-15">
                                        <label>*Obs.</label>&nbsp;
                                        <textarea style="resize:none" name="obs_visitas" id="obs_visitas" class="form-control" <?//=$estadoRO?>></textarea>
                                        <label>
                                            <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_obs" class="letra_help" style="float:left"></div>
                                        </label>
                                      </div>-->

                                    <button type="button" class="btn boton-generico-left btn-primary" onClick="programar()">Programar visitas</button>&nbsp;
                                    </div>
                                </div>
                                <?php }//end if($propac_spp_id=ST_PP_PROTOCOLO)?>

										<?php 
										$rVisitas=cPaciente::obtenerVisitasProgramadasPacienteProtocolo("", "", $cantResultados, $cantPaginas, "cron_dias_basal", "ASC", $id_proto,$id,"","","","");
										if($rVisitas->cantidad()==0){?>
                                           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">No hay visitas</div>
                                        <?php } else {?>
											<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                              <div class="table-responsive">          
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Visita</th>
                                                    <th>Días Basal</th>
                                                    <th>Fecha / Hora</th>
                                                    <th>Estado</th>
                                                    <th>Tipo</th>
                                                    <th>Obs.</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php for($i=0;$i<$rVisitas->cantidad();$i++){?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita(<?=$rVisitas->campo('provis_id',$i)?>)"><?=$rVisitas->campo('nombre_visita',$i)?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=(is_null($rVisitas->campo('cron_dias_basal',$i)) ? "--":$rVisitas->campo('cron_dias_basal',$i))?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro">
													<?php 
													switch($rVisitas->campo('sv_id',$i)){
														case ST_VIS_REALIZADA:
															echo convertirFechaComprimido($rVisitas->campo('provis_fecha_realizada',$i)).' '.$rVisitas->campo('provis_hora_realizada',$i);
														break;
														case ST_VIS_PROGRAMADA:
															echo convertirFechaComprimido($rVisitas->campo('provis_fecha_agenda',$i)).(!is_null($rVisitas->campo('provis_hora_agenda',$i)) ? '&nbsp;'.$rVisitas->campo('provis_hora_agenda',$i) : "");
														break;
														case ST_VIS_ESPONTANEA:
															echo convertirFechaComprimido($rVisitas->campo('provis_fecha_agenda',$i)).(!is_null($rVisitas->campo('provis_hora_realizada',$i)) ? '&nbsp;'.$rVisitas->campo('provis_hora_agenda',$i) : "");
														break;
														case ST_VIS_CANCELADA:
															echo convertirFechaComprimido($rVisitas->campo('provis_fecha_agenda',$i)).(!is_null($rVisitas->campo('provis_hora_agenda',$i)) ? '&nbsp;'.$rVisitas->campo('provis_hora_agenda',$i) : "");
														break;
													}
													?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><span class="label <?=$rVisitas->campo('sv_estilo',$i)?>"><?=$rVisitas->campo('sv_descripcion',$i)?></span></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('nombre_visita',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=(is_null($rVisitas->campo('provis_observaciones',$i)) ? "--":$rVisitas->campo('provis_observaciones',$i))?></p></td>
                                                  </tr>
                                                  <?php }?>
                                                </tbody>
                                              </table>
                                              
                                              </div>
                                              </div>
										<? }//$rVisitas->cantidad()
										}//end if ?>
                                        
                                    </div>
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
