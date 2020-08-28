<?php
include_once 'includes/config.php';
//error_reporting(E_ALL);
//ini_set("display_errors","On");
include_once 'clases/cProtocolo.php';
include_once 'clases/cVisitaNombre.php';
include_once 'clases/cTipoVisita.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
$permisoCargarCronograma=seguridadFuncion("CARGARCRONOGRAMA");
$permisoVerCronograma=seguridadFuncion("VERVISITASCRONOGRAMA");
$permisoEliminarCronograma=seguridadFuncion("ELIMINARCRONOGRAMA");

if(!$permisoVerCronograma){
	cDB::cerrar($conexion);
	header("Location:login.php");
	exit();
}
	$formulario="protocolos";
	$accion=filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	$id_visita=filter_var($_REQUEST['id_visita'], FILTER_SANITIZE_NUMBER_INT);
	$dest=filter_var($_POST['dest'], FILTER_SANITIZE_STRING);

	$permisoBorrar=false;

	if($permisoCargarCronograma){
		$permisoGuardar=true;
	} else {
		if(strlen($id_visita)==0){
			cDB::cerrar($conexion);
			header("Location:login.php");
			exit();
		}
		$permisoGuardar=false;
	}

	if(!empty($id)){
		$rPro=cProtocolo::obtenerProtocolo($id,"");
		if($rPro->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		}
	} else {
		cDB::cerrar($conexion);
		header("Location:index.php");
		exit();
	}

	if(!empty($id_visita)){
		$rVis=cProtocolo::obtenerCronogramaVisita($id_visita,$id);
		if($rVis->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		}
		if(!cProtocolo::tieneVisitasPacientes($id_visita) && $permisoEliminarCronograma){
			$permisoBorrar=true;
		}

		foreach(array_keys($rVis->CAMPOS) as $campo){
			${$campo}=$rVis->campo($campo,0);
		}
	}
if($accion=="ELIMINAR" && $permisoBorrar){
	//solo borrar si cumple condiciones que NO tenga visitas de pacientes
	cProtocolo::eliminarVisita($id_visita);
	cDB::cerrar($conexion);
	header("Location:".$dest."?v=1");
	exit();
}
if($accion=="GUARDAR" && $permisoGuardar){
	$errorVar=$_POST['errorVar'];
	$res=cProtocolo::modificarCronogramaVisita($_POST, $errorVar, $id, $id_visita);
	cDB::cerrar($conexion);
	header("Location:".$dest."?v=1");
	exit();
}
$porcentaje=0;
if(!empty($id_visita)){
	if($permisoGuardar){
		$titulo_pagina="Editar visita";
	} else {
		$titulo_pagina="Ver visita";
	}
} else {
	$titulo_pagina="Cargar nueva visita al cronograma";
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
				if($("#visita_crvn_id").val()==""){
					errores+="- Debe elegir el nombre de la visita<br>";
				} else {
					if($("#visita_crvn_id").val()=="-1"){
						if($("#descripcion_nombre").val()==""){
							errores+="- Debe ingresar el nombre de la visita<br>";
						}
					}
				}
				if($('#var_dias_basal').val()==""){
					errores+="- Debe la cantidad de días desde la visita target<br>";
				}
				if($('#var_ventana_max').val()!="" && $('#var_ventana_min').val()!=""){
				
				} else {
					if($('#var_ventana_max').val()==""){
						errores+="- Debe ingresar la ventana máxima<br>";
					}
					if($('#var_ventana_min').val()==""){
						errores+="- Debe ingresar la ventana mínima<br>";
					}
				}
				if($('#var_laboratorio').val()==""){
					errores+="- Debe ingresar el laboratorio<br>";
				}
				if($('#var_tiv_id').val()==""){
					errores+="- Debe ingresar el tipo de visita<br>";
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
					$("#alerta-formulario").find("#alerta-titulo").text("Faltan completar datos.");
					$("#alerta-formulario").find('#alerta-cuerpo').html(errores.replace(/\n/g, "<br />"));
					$('#alerta-formulario').modal('show');
				}
			} else {
				if(varDest==""){
					varDest="formulario_protocolo.php";
					document.datos.dest.value=varDest;
					document.datos.menu.value=varMenu;
					document.datos.errorVar.value=varError;
					document.datos.accion.value="GUARDAR";
					document.datos.v.value=1;
					document.datos.id.value=<?=$id?>;
					document.datos.target="_self";
					document.datos.action="";
					document.datos.submit();
				} else {
					$("#alerta-formulario").find("#alerta-titulo").text("Los datos no se guardaron.");
					$('#boton_modal_continuar').click(function(){
						document.datos.v.value=1;
						document.datos.target="_self";
						document.datos.accion.value="";			
						document.datos.action=varDest;
						document.datos.submit();
					});
					$('#boton_modal_continuar').text("Abandonar SIN guardar");
					$('#boton_modal_cerrar').text("Permanecer en el formulario");
					$("#alerta-formulario").find('#alerta-cuerpo').html("Debe indicar si desea abandonar el formulario sin guardar los datos, o bien permanecer y hacer clic en el botón guardar");
					$("#alerta-formulario").modal('show');				
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
	
	<?php if($permisoBorrar){?>
	function eliminarVis(){
		if(confirm("Está a punto de eliminar la visita del cronograma.\nNo podrá ser recuperada\n¿Está seguro?")){
			document.datos.accion.value="ELIMINAR";
			document.datos.submit();
		}
	}
	<?php }?>
	
	function verVisita(){
		document.location='formulario_visita.php';
	}
	$(document).ready(function() {
		$('#var_dias_basal').autoNumeric('init');
		$('#var_ventana_max').autoNumeric('init');
		$('#var_ventana_min').autoNumeric('init');
		$("#var_observaciones").MaxLength(
		{
			MaxLength: 1000,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_caracteres_observaciones')
		});



		
		$('select[name=visita_crvn_id]').change(function() {
			switch(parseInt($(this).val(),10)){
				case -1:
					$("#descripcion_nombre").removeAttr("disabled");
					$("#capa_otro_nombre").show();
				break;
				default:
					$("#descripcion_nombre").attr("disabled","disabled");
					$("#capa_otro_nombre").hide();
				break;
			}
		});
		switch(parseInt($('select[name=visita_crvn_id]').val(),10)){
			case -1:
				$("#descripcion_nombre").removeAttr("disabled");
				$("#capa_otro_nombre").show();
			break;
			default:
				$("#descripcion_nombre").attr("disabled","disabled");
				$("#capa_otro_nombre").hide();
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
        <input type="hidden" name="errorVar" />
        <input type="hidden" name="dest" />
        <input type="hidden" name="menu" />
        <input type="hidden" name="id" value="<?=$id?>" />
        <input type="hidden" name="v" value="" />
        <input type="hidden" name="id_visita" value="<?=$id_visita?>" />
		<? include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Protocolo&nbsp;<?=$rPro->campo('pro_codigo_estudio',0).'&nbsp;-&nbsp;'.$rPro->campo('pro_titulo_breve',0)?></h2>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 right mt-20">
	                <a href="javascript:validarFormulario('formulario_protocolo.php','')" class="white back-bread"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Volver</a>
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
                        <? if($permisoBorrar){?>
                        <div class="row">
                          <div class="form-group col-md-12">
						  	<button type="button" class="btn boton-generico btn-primary" onClick="eliminarVis()"><i class="fa fa-trash fa-2x"></i>&nbsp;&nbsp;Eliminar Visita Cronograma</button>
                          </div>
                        </div>
                        <? }?>
                        <div class="row">
                          <div class="form-group col-md-3">
                            <label>*Visita</label>&nbsp;
                            <div class="ayuda">
                                <img src="images/ayuda.png">
                              <span class="tooltiptext">
                                Elegir nombre de visita. Si no se encuentra, elegir opción OTRO al final.
                              </span>
                            </div>
                            &nbsp;Elegir nombre de visita:
                            <? 	armarCombo(cVisitaNombre::obtenerCombo(), "visita_crvn_id", "form-control", " id=\"visita_crvn_id\" ".$estadoDis, $cron_crvn_id, "[Buscar nombre]");?>
                            <div id="capa_otro_nombre">
                                <label>*Otro nombre visita</label>
                                <input type="text" class="form-control" name="descripcion_nombre" id="descripcion_nombre" value="<?=$cron_descripcion?>" placeholder="Ingrese nombre" maxlength="255">
                            </div>
                          </div>
                          <div class="form-group col-md-3">
                            <label>*Días target</label>
                            <input type="text" name="var_dias_basal" id="var_dias_basal" maxlength="255" class="form-control" data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="-999" data-v-max="999" <?=$estadoRO?> value="<?=$cron_dias_basal?>" />
                          </div>
                          <div class="form-group col-md-3">
                            <label>*Ventana Máx.</label>
                            <input type="text" name="var_ventana_max" id="var_ventana_max" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$cron_ventana_max?>"  data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="-999" data-v-max="999"/>
                          </div>
                          <div class="form-group col-md-3">
                            <label>*Ventana Mín.</label>
                            <input type="text" name="var_ventana_min" id="var_ventana_min" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$cron_ventana_min?>" data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="-999" data-v-max="999"/>
                          </div>
						</div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Laboratorio</label>
                            <select name="var_laboratorio" id="var_laboratorio" class="form-control" <?=$estadoDis?>>
                            	<option value=""  <?=($cron_laboratorio=="" || is_null($cron_laboratorio) ? "selected" : "")?>>[Elegir]</option>
                                <option value="1" <?=($cron_laboratorio==1 ? "selected" : "")?>>Sí</option>
                                <option value="0" <?=($cron_laboratorio==0 && !is_null($cron_laboratorio) ? "selected" : "")?>>No</option>
                            </select>
                          </div>
                          <div class="form-group col-md-4">
                            <label>Observaciones</label>&nbsp;
                            <textarea style="resize:none" name="var_observaciones" id="var_observaciones" class="form-control" <?=$estadoRO?>><?=$cron_observaciones?></textarea>
                            <label>
                                <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_observaciones" class="letra_help" style="float:left"></div>
                            </label>
                          </div>
                          <div class="form-group col-md-4">
                                <label>*Tipo visita</label>&nbsp;
                                <?php armarCombo(cTipoVisita::obtenerCombo(array()), "var_tiv_id", "form-control", " id=\"var_tiv_id\" ".$estadoDis, $cron_tiv_id, "[Elegir]");?>
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
