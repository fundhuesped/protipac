<?php
include_once 'includes/config.php';
//error_reporting(E_ALL);
//ini_set("display_errors","On");
include_once 'clases/cContenido.php';
include_once 'clases/cFormulario.php';
include_once 'clases/cEntidad.php';
include_once 'clases/cFase.php';
include_once 'clases/cTipoEstudio.php';
include_once 'clases/cTipoInvestigacionExp.php';
include_once 'clases/cProtocolo.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
$permisoCargarProtocolo=seguridadFuncion("CARGARPROTOCOLOS");
$permisoEliminarProtocolo=seguridadFuncion("ELIMINARPROTOCOLOS");
$permisoVerCronograma=seguridadFuncion("VERVISITASCRONOGRAMA");
$permisoCargarCronograma=seguridadFuncion("CARGARCRONOGRAMA");

if(!$permisoCargarProtocolo){
	cDB::cerrar($conexion);
	header("Location:login.php");
	exit();
}


	$formulario="protocolos";
	$accion=filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	$v=filter_var($_REQUEST['v'], FILTER_SANITIZE_NUMBER_INT);
	$dest=filter_var($_POST['dest'], FILTER_SANITIZE_STRING);

	$permisoGuardar=true;
	$permisoBorrar=false;
	if(strlen($id)==0){
		if($v==1){
			$id=$_SESSION['id_pro'];
		}
	}
	if(!empty($id)){
		$rPro=cProtocolo::obtenerProtocolo($id,"");
		if($rPro->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		} else {
			if(!cProtocolo::tienePacientes($id) && $permisoEliminarProtocolo){
				$permisoBorrar=true;
			}
			$_SESSION['id_pro']=$id;
			foreach(array_keys($rPro->CAMPOS) as $campo){
				${$campo}=$rPro->campo($campo,0);
			}
			$rProInv=cProtocolo::obtenerProtocoloInvestigadores($id);
			$proinv_inv_id_sub1="";
			$proinv_inv_id_sub2="";
			for($i=0;$i<$rProInv->cantidad();$i++){
				switch($rProInv->campo('proinv_tinv_id',$i)){
					case TIPO_INV_PRINCIPAL:
						$proinv_inv_id_princ=$rProInv->campo('proinv_inv_id',$i);
					break;
					case TIPO_INV_SUB:
						if(strlen($proinv_inv_id_sub1)==0){
							$proinv_inv_id_sub1=$rProInv->campo('proinv_inv_id',$i);
						} else {
							if(strlen($proinv_inv_id_sub2)==0){
								$proinv_inv_id_sub2=$rProInv->campo('proinv_inv_id',$i);
							}
						}
					break;
				}
			}
		}
	}
if($accion=="ELIMINAR" && $permisoBorrar){
	//solo borrar si cumple condiciones que NO tenga pacientes
	cProtocolo::eliminarProyecto($id);
	cDB::cerrar($conexion);
	header("Location: protocolos.php");
	exit();
}


if($accion=="GUARDAR" && $permisoGuardar){
	$errorVar=$_POST['errorVar'];
	$res=cProtocolo::modificarProtocolo($_POST, $errorVar, $id);
	if($res>0 && strlen($id)==0){
		$rPro=cProtocolo::obtenerProtocolo($res,"");
		if($rPro->cantidad()>0){
			$pro_ast_id=$rPro->campo('pro_ast_id',0);
		}
	}
	cDB::cerrar($conexion);
	header("Location:".$dest);
	exit();
}
$porcentaje=0;
$vecEmpresaStatus=array(ST_ACTIVO);
if(!empty($id)){
	if($permisoGuardar){
		$titulo_pagina="Editar protocolo";
	} else {
		$titulo_pagina="Ver protocolo";
	}
} else {
	$titulo_pagina="Cargar nuevo protocolo";
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
				if($('#var_titulo_breve').val()==""){
					errores+="- Debe ingresar el título breve del estudio<br>";
				}
				if($('#var_titulo').val()==""){
					errores+="- Debe ingresar la descripción del estudio<br>";
				}
				if($('#var_codigo_estudio').val()==""){
					errores+="- Debe ingresar nombre referencia / código estudio<br>";
				}
				if($('#var_sp_id').val()==""){
					errores+="- Debe ingresar el estado<br>";
				}
				if($('#var_tes_id').val()==""){
					errores+="- Debe ingresar el tipo de estudio<br>";
				}
				if($('#var_tex_id').val()==""){
					errores+="- Indicar si la investigación es con o sin uso de drogas<br>";
				} else {
					if(parseInt($('#var_tex_id').val(),10)==<?=TIPO_CON_DROGAS?>){
						if($('#var_fase_id').val()==""){
							errores+="- Debe elegir la fase de la investigación<br>";
						}
					}
				}
				if($('#var_target').val()==""){
					errores+="- Debe ingresar el número para Target<br>";
				}

				if($("#proyecto_investigador").val()==""){
					errores+="- Debe elegir el Investigador<br>";
				}
				/*if($('#var_sponsor').val()==""){
					errores+="- Elegir si tiene Sponsor<br>";
				} else {
					if(parseInt($('#var_sponsor').val(),10)==<?//=TIPO_SPONSOR?>){*/
						if($("#proyecto_patrocinador_spo").val()==""){
							errores+="- Debe elegir el Sponsor<br>";
						} else {
							if($("#proyecto_patrocinador_spo").val()=="-1"){
								if($("#razon_social_sponsor_nuevo").val()==""){
									errores+="- Debe ingresar la Razón social del sponsor<br>";
								}
							}
						}
					/*}
				}*/
				if($('#var_cro').val()==""){
					errores+="- Elegir si tiene CRO<br>";
				} else {
					if(parseInt($('#var_cro').val(),10)==<?=TIPO_CRO?>){
						if($("#proyecto_patrocinador_cro").val()==""){
							errores+="- Debe elegir la CRO<br>";
						} else {
							if($("#proyecto_patrocinador_cro").val()=="-1"){
								if($("#razon_social_cro_nuevo").val()==""){
									errores+="- Debe ingresar la Razón social de la CRO<br>";
								}
							}
						}
					}
				}
				if($('#var_financiamiento').val()==""){
					errores+="- Elegir si tiene Financiador<br>";
				} else {
					if(parseInt($('#var_financiamiento').val(),10)==<?=TIPO_FINANCIADO?>){
						if($("#proyecto_patrocinador_fin").val()==""){
							errores+="- Debe elegir la Entidad Financiadora<br>";
						} else {
							if($("#proyecto_patrocinador_fin").val()=="-1"){
								if($("#razon_social_financiador_nuevo").val()==""){
									errores+="- Debe ingresar la Razón social del financiador<br>";
								}
							}
						}
					}
				}


				/*if($('#var_industria').val()==""){
					errores+="- Completar Industria (Sí/No)<br>";
				}*/
				if($('#var_fecha_inicio').val()!="" && $('#var_fecha_fin').val()!=""){
					if(isDateValidFull($('#var_fecha_inicio').val(), "/") && isDateValidFull($('#var_fecha_fin').val(), "/")){
						varFechaInicio=new Date($('#var_fecha_inicio').val());
						varFechaFin=new Date($('#var_fecha_fin').val());
						if(varFechaInicio>=varFechaFin){
							errores+="- La fecha de finalización tiene que ser mayor a la fecha de inicio<br>";
						}
					} else {
						errores+="- Las fechas tienen formato inválido. Debe ser dd/mm/aaaa<br>";	
					}
				} else {
					if($('#var_fecha_inicio').val()==""){
						errores+="- Completar la fecha de inicio<br>";
					}
				}
				if($('#proyecto_investigador_princ').val()==""){
					errores+="- Investigador principal<br>";
				}
				if($('#var_contactos').val()==""){
					errores+="- Completar el campo Contactos<br>";
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
							document.location=varDest;
						});
					}
					$("#alerta-formulario").find("#alerta-titulo").text("Faltan completar datos.");
					$("#alerta-formulario").find('#alerta-cuerpo').html(errores.replace(/\n/g, "<br />"));
					$('#alerta-formulario').modal('show');
				}
			} else {
				if(varDest==""){
					varDest="protocolos.php";
					document.datos.dest.value=varDest;
					document.datos.menu.value=varMenu;
					document.datos.errorVar.value=varError;
					document.datos.accion.value="GUARDAR";
					document.datos.v.value=1;
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
	function eliminarPro(){
		if(confirm("Está a punto de eliminar el protocolo.\nNo podrá ser recuperado\n¿Está seguro?")){
			document.datos.accion.value="ELIMINAR";
			document.datos.submit();
		}
	}
	<?php }?>
	
	function verVisita(varVisId){
		if(varVisId!=''){
			document.datos.id_visita.value=varVisId;
		} else {
			document.datos.id_visita.value="";
		}
		document.datos.action="formulario_visita.php";
		document.datos.submit();
	}
	$(document).ready(function() {
		$('#var_target').autoNumeric('init');
		$('#var_fecha_inicio').datepicker({ dateFormat: 'dd/mm/yy' });
		$('#var_fecha_fin').datepicker({ dateFormat: 'dd/mm/yy' });
		$("#var_titulo").MaxLength(
		{
			MaxLength: 2000,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_caracteres_titulo')
		});
		$("#var_contactos").MaxLength(
		{
			MaxLength: 1000,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_caracteres_contactos')
		});
		$.fn.select2.defaults.set("theme", "bootstrap");
		$('#proyecto_patrocinador_fin').select2({
			width: null,
			tags:true
		});
		$('#proyecto_patrocinador_spo').select2({
			width: null,
			tags:true
		});
		$('#proyecto_patrocinador_cro').select2({
			width: null,
			tags:true
		});


		$('select[name=var_tex_id]').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?=TIPO_CON_DROGAS?>:
					$("#capa_drogas").show();
				break;
				case <?=TIPO_SIN_DROGAS?>:
					$("#capa_drogas").hide();
					$("#var_placebo").val("");
					$("#var_fase_id").val("");
				break;
			}
		});

		switch(parseInt($('select[name=var_tex_id]').val(),10)){
			case <?=TIPO_CON_DROGAS?>:
				$("#capa_drogas").show();
				<?=($permisoGuardar ? '$("#var_fase_id").removeAttr("disabled");':'')?>
			break;
			case <?=TIPO_SIN_DROGAS?>:
				$("#capa_drogas").hide();
				$("#var_fase_id").val("");

			break;
			default:
				$("#capa_drogas").hide();
				$("#var_fase_id").val("");
			break;
		}


		$('select[name=var_financiamiento]').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?=TIPO_FINANCIADO?>:
					$("#capa_entidad_financiador").show();
					//$("#capa_financiador_datos").show();
				break;
				case <?=TIPO_NO_FINANCIADO?>:
					$("#capa_entidad_financiador").hide();
					//$("#capa_financiador_datos").hide();
					$("#proyecto_patrocinador_fin").val("");
					$("#razon_social_financiador_nuevo").val("");
				break;
				default:
					$("#capa_entidad_financiador").hide();
					//$("#capa_financiador_datos").hide();
					$("#proyecto_patrocinador_fin").val("");
					$("#razon_social_financiador_nuevo").val("");
				break;
			}
		});

		switch(parseInt($('select[name=var_financiamiento]').val(),10)){
			case <?=TIPO_FINANCIADO?>:
				$("#capa_entidad_financiador").show();
				//$("#capa_financiador_datos").show();
			break;
			case <?=TIPO_NO_FINANCIADO?>:
				$("#capa_entidad_financiador").hide();
				//$("#capa_financiador_datos").hide();
			break;
			default:
				$("#capa_entidad_financiador").hide();
				//$("#capa_financiador_datos").hide();
				$("#proyecto_patrocinador_fin").val("");
			break;
		}
		
		$('select[name=proyecto_patrocinador_fin]').change(function() {
			switch(parseInt($(this).val(),10)){
				case -1:
					$("#capa_financiador_datos").show();
					$("#razon_social_financiador_nuevo").removeAttr("disabled");
				break;
				default:
					$("#capa_financiador_datos").hide();
					$("#razon_social_financiador_nuevo").attr("disabled","disabled");
				break;
			}
		});
		switch(parseInt($('select[name=proyecto_patrocinador_fin]').val(),10)){
			case -1:
				$("#capa_financiador_datos").show();
				$("#razon_social_financiador_nuevo").removeAttr("disabled");
			break;
			default:
				$("#capa_financiador_datos").hide();
				$("#razon_social_financiador_nuevo").attr("disabled","disabled");
			break;
		}
		
		
		/*$('select[name=var_sponsor]').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?//=TIPO_SPONSOR?>:
					$("#capa_entidad_sponsor").show();
					$("#capa_sponsor_datos").show();
				break;
				case <?//=TIPO_NO_SPONSOR?>:
					$("#capa_entidad_sponsor").hide();
					$("#capa_sponsor_datos").hide();
					$("#proyecto_patrocinador_spo").val("");
					$("#razon_social_sponsor_nuevo").val("");
				break;
				default:
					$("#capa_entidad_sponsor").hide();
					$("#capa_sponsor_datos").hide();
					$("#proyecto_patrocinador_spo").val("");
					$("#razon_social_sponsor_nuevo").val("");
				break;
			}
		});*/

		/*switch(parseInt($('select[name=var_sponsor]').val(),10)){
			case <?//=TIPO_SPONSOR?>:
				$("#capa_entidad_sponsor").show();
				$("#capa_sponsor_datos").show();
			break;
			case <?//=TIPO_NO_SPONSOR?>:
				$("#capa_entidad_sponsor").hide();
				$("#capa_sponsor_datos").hide();
			break;
			default:
				$("#capa_entidad_sponsor").hide();
				$("#capa_sponsor_datos").hide();
				$("#proyecto_patrocinador_spo").val("");
			break;
		}*/
		
		$('select[name=proyecto_patrocinador_spo]').change(function() {
			switch(parseInt($(this).val(),10)){
				case -1:
					$("#razon_social_sponsor_nuevo").removeAttr("disabled");
					$("#capa_sponsor_datos").show();
				break;
				default:
					$("#capa_sponsor_datos").hide();
					$("#razon_social_sponsor_nuevo").attr("disabled","disabled");
				break;
			}
		});
		switch(parseInt($('select[name=proyecto_patrocinador_spo]').val(),10)){
			case -1:
				$("#razon_social_sponsor_nuevo").removeAttr("disabled");
				$("#capa_sponsor_datos").show();
			break;
			default:
				$("#capa_sponsor_datos").hide();
				$("#razon_social_sponsor_nuevo").attr("disabled","disabled");
			break;
		}
		
		$('select[name=var_cro]').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?=TIPO_CRO?>:
					$("#capa_entidad_cro").show();
					//$("#capa_cro_datos").show();
				break;
				case <?=TIPO_NO_CRO?>:
					$("#capa_entidad_cro").hide();
					//$("#capa_cro_datos").hide();		
					$("#proyecto_patrocinador_cro").val("");
					$("#razon_social_cro_nuevo").val("");			
				break;
				default:
					$("#capa_entidad_cro").hide();
					//$("#capa_cro_datos").hide();
					$("#proyecto_patrocinador_cro").val("");
					$("#razon_social_cro_nuevo").val("");
				break;
			}
		});

		switch(parseInt($('select[name=var_cro]').val(),10)){
			case <?=TIPO_CRO?>:
				$("#capa_entidad_cro").show();
				//$("#capa_cro_datos").show();
			break;
			case <?=TIPO_NO_CRO?>:
				$("#capa_entidad_cro").hide();
				//$("#capa_cro_datos").hide();
			break;
			default:
				$("#capa_entidad_cro").hide();
				//$("#capa_cro_datos").hide();
				$("#proyecto_patrocinador_cro").val("");
			break;
		}
		
		$('select[name=proyecto_patrocinador_cro]').change(function() {
			switch(parseInt($(this).val(),10)){
				case -1:
					$("#capa_cro_datos").show();
					$("#razon_social_cro_nuevo").removeAttr("disabled");
				break;
				default:
					$("#capa_cro_datos").hide();
					$("#razon_social_cro_nuevo").attr("disabled","disabled");
				break;
			}
		});
		switch(parseInt($('select[name=proyecto_patrocinador_cro]').val(),10)){
			case -1:
				$("#capa_cro_datos").show();
				$("#razon_social_cro_nuevo").removeAttr("disabled");
			break;
			default:
				$("#capa_cro_datos").hide();
				$("#razon_social_cro_nuevo").attr("disabled","disabled");
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
        <input type="hidden" name="id_visita" value="" />
        <input type="hidden" name="id_cont" value="<?=$pro_ast_id?>" />
		<? include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Protocolos de investigación</h2>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 right mt-20">
	                <a href="javascript:validarFormulario('protocolos.php','')" class="white back-bread"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Volver</a>
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
                        	<?php if(!empty($id)){?>
								<p id="submenu">
									<?=($permisoVerCronograma ? '[<a href="formulario_protocolo.php#visitas">Cronograma visitas</a>] ' : '')?><?=(!empty($id) ? '&nbsp;[<a href="formulario_protocolo.php#log">Historial</a>] ' : '')?>
								</p>
							<?php }?>
                        <? if($permisoBorrar){?>
                        <div class="row">
                          <div class="form-group col-md-12">
						  	<button type="button" class="btn boton-generico btn-primary" onClick="eliminarPro()"><i class="fa fa-trash fa-2x"></i>&nbsp;&nbsp;Eliminar Protocolo</button>
                          </div>
                        </div>
                        <? }?>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Nombre Referencia</label>
                            <input type="text" name="var_codigo_estudio" id="var_codigo_estudio" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pro_codigo_estudio?>" />
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Protocolo / Título breve</label>
                            <input type="text" name="var_titulo_breve" id="var_titulo_breve" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pro_titulo_breve?>" />
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Descripción del estudio</label>&nbsp;
                            <textarea style="resize:none" name="var_titulo" id="var_titulo" class="form-control" <?=$estadoRO?>><?=$pro_titulo?></textarea>
                            <label>
                                <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_titulo" class="letra_help" style="float:left"></div>
                            </label>
                          </div>
						</div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Estado</label>
                            <? armarCombo(cProtocolo::obtenerComboStatus(), "var_sp_id", "form-control", $estadoDis, $pro_sp_id, "[Elegir]");?>
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Tipo estudio</label>
                            <? armarCombo(cTipoEstudio::obtenerCombo(array(ST_ACTIVO)), "var_tes_id", "form-control", $estadoDis, $pro_tes_id, "[Elegir]");?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Uso de drogas</label>
                            <? armarCombo(cTipoInvestigacionExp::obtenerCombo(), "var_tex_id", "form-control", $estadoDis, $pro_tex_id, "[Elegir]");?>
                          </div>
                          <div class="form-group col-md-4" id="capa_drogas">
                            <label>*Fase de investigación</label>
                            <? armarCombo(cFase::obtenerCombo(), "var_fase_id", "form-control", " id=\"var_fase_id\" ".$estadoDis, $pro_fase_id, "[Elegir fase de investigación]");?>       
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Target</label>
                            <input type="text" name="var_target" id="var_target" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pro_target?>"  data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="0" data-v-max="999"/>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <!--<label>*Tiene Sponsor</label>
                            <select name="var_sponsor" id="var_sponsor" class="form-control" <?=$estadoDis?>>
                            	<option value=""  <?//=($pro_sponsor==="" || is_null($pro_sponsor) ? "selected" : "")?>>[Elegir]</option>
                                <option value="1" <?//=($pro_sponsor==TIPO_SPONSOR ? "selected" : "")?>>Sí</option>
                                <option value="0" <?//=($pro_sponsor===TIPO_NO_SPONSOR && !is_null($pro_sponsor) ? "selected" : "")?>>No</option>
                            </select>-->
                          	<div id="capa_entidad_sponsor">
                                <label>*Sponsor</label>&nbsp;
                                <div class="ayuda">
                                    <img src="images/ayuda.png">
                                  <span class="tooltiptext">
                                    Buscar por razón social o palabras clave.
                                  </span>
                                </div>
                                &nbsp;Buscar por Razón Social:
                                <? 	armarComboOtro(cEntidad::obtenerComboPatrocinador("",""), "proyecto_patrocinador_spo", "form-control", " id=\"proyecto_patrocinador_spo\" ".$estadoDis, $empresa_sponsor, "[Razón Social]");?>
                                <div id="capa_sponsor_datos">
                                    <label>*Razón social Sponsor</label>
                                    <input type="text" class="form-control" name="razon_social_sponsor_nuevo" id="razon_social_sponsor_nuevo" placeholder="Ingrese nuevo sponsor" maxlength="255">
                                </div>
                          	</div>

                          </div>
                          <div class="form-group col-md-4">
                            <label>*Tiene CRO</label>
                            <select name="var_cro" id="var_cro" class="form-control" <?=$estadoDis?>>
                            	<option value=""  <?=($pro_cro==="" || is_null($pro_cro) ? "selected" : "")?>>[Elegir]</option>
                                <option value="1" <?=($pro_cro==TIPO_CRO ? "selected" : "")?>>Sí</option>
                                <option value="0" <?=($pro_cro===TIPO_NO_CRO && !is_null($pro_cro) ? "selected" : "")?>>No</option>
                            </select>
                          	<div id="capa_entidad_cro">
                                <label>*CRO</label>&nbsp;
                                <div class="ayuda">
                                    <img src="images/ayuda.png">
                                  <span class="tooltiptext">
                                    Buscar por razón social o palabras clave.
                                  </span>
                                </div>
                                &nbsp;Buscar por Razón Social:
                                <? 	armarComboOtro(cEntidad::obtenerComboPatrocinador("",""), "proyecto_patrocinador_cro", "form-control", " id=\"proyecto_patrocinador_cro\" ".$estadoDis, $empresa_cro, "[Razón Social]");?>
                                <div id="capa_cro_datos">
                                    <label>*Razón social CRO</label>
                                    <input type="text" class="form-control" name="razon_social_cro_nuevo" id="razon_social_cro_nuevo" placeholder="Ingrese nueva CRO" maxlength="255">
                                </div>
 	                        </div>

                          </div>

                          <div class="form-group col-md-4">
                            <label>*Tiene Financiador</label>
                            <select name="var_financiamiento" id="var_financiamiento" class="form-control" <?=$estadoDis?>>
                            	<option value=""  <?=($pro_financiamiento==="" || is_null($pro_financiamiento) ? "selected" : "")?>>[Elegir]</option>
                                <option value="1" <?=($pro_financiamiento==TIPO_FINANCIADO ? "selected" : "")?>>Sí</option>
                                <option value="0" <?=($pro_financiamiento===TIPO_NO_FINANCIADO && !is_null($pro_financiamiento) ? "selected" : "")?>>No</option>
                            </select>
                          	<div id="capa_entidad_financiador">
                                <label>*Financiador</label>&nbsp;
                                <div class="ayuda">
                                    <img src="images/ayuda.png">
                                  <span class="tooltiptext">
                                    Buscar por razón social o palabras clave.
                                  </span>
                                </div>
                                &nbsp;Buscar por Razón Social:
                                <? 	armarComboOtro(cEntidad::obtenerComboPatrocinador("",""), "proyecto_patrocinador_fin", "form-control", " id=\"proyecto_patrocinador_fin\" ".$estadoDis, $empresa_financiador, "[Razón Social]");?>
                                <div id="capa_financiador_datos">
                                    <label>*Razón social Financiador</label>
                                    <input type="text" class="form-control" name="razon_social_financiador_nuevo" id="razon_social_financiador_nuevo" placeholder="Ingrese nuevo financiador" maxlength="255">
                                </div>
                            </div>
                          </div>
                        </div>
						<hr>
                        <div class="row">
                          <!--<div class="form-group col-md-4">
                            <label>*Industria</label>
                            <select name="var_industria" id="var_industria" class="form-control" <?//=$estadoDis?>>
                            	<option value=""  <?//=($pro_industria==="" || is_null($pro_industria) ? "selected" : "")?>>[Elegir]</option>
                                <option value="1" <?//=($pro_industria==TIPO_INDUSTRIA ? "selected" : "")?>>Sí</option>
                                <option value="0" <?//=($pro_industria===TIPO_NO_INDUSTRIA && !is_null($pro_industria) ? "selected" : "")?>>No</option>
                            </select>
                          </div>-->
                          <div class="form-inline col-md-4">
                            <label>*Fecha inicio</label><br>
                            <input type="text" size="20" id="var_fecha_inicio" placeholder="dd/mm/aaaa" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="var_fecha_inicio" class="form-control" value="<?=convertirFechaCalendar($pro_fecha_inicio,'d/m/Y')?>">&nbsp;<? if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.var_fecha_inicio.value = '';"><? }?>
                          </div>
                          <div class="form-inline col-md-4">
                            <label>Fecha fin</label><br>
                            <input type="text" size="20" id="var_fecha_fin" placeholder="dd/mm/aaaa" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="var_fecha_fin" class="form-control" value="<?=convertirFechaCalendar($pro_fecha_fin,'d/m/Y')?>">&nbsp;<? if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.var_fecha_fin.value = '';"><? }?>
						   </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-4">
                                <label>*Investigador principal</label>&nbsp;
                                <?php armarCombo(cEntidad::obtenerComboInvestigador(1), "proyecto_investigador_princ", "form-control", " id=\"proyecto_investigador_princ\" ".$estadoDis, $proinv_inv_id_princ, "[Elegir]");?>
                          </div>
                          <div class="form-group col-md-4">
                                <label>Subinvestigador Responsable</label>&nbsp;
                                <?php armarCombo(cEntidad::obtenerComboInvestigador(2), "proyecto_investigador_sub1", "form-control", " id=\"proyecto_investigador_sub1\" ".$estadoDis, $proinv_inv_id_sub1, "[Elegir]");?>
                          </div>
                          <div class="form-group col-md-4">
                                <label>Subinvestigador Responsable 2</label>&nbsp;
                                <?php armarCombo(cEntidad::obtenerComboInvestigador(2), "proyecto_investigador_sub2", "form-control", " id=\"proyecto_investigador_sub2\" ".$estadoDis, $proinv_inv_id_sub2, "[Elegir]");?>
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Contactos</label>&nbsp;
                            <textarea style="resize:none" name="var_contactos" id="var_contactos" class="form-control" <?=$estadoRO?>><?=$pro_contactos?></textarea>
                            <label>
                                <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_contactos" class="letra_help" style="float:left"></div>
                            </label>
                          </div>
                        </div>
                        <div class="row">
                        <? if($permisoGuardar){?>
						  	<button type="button" class="btn boton-generico btn-primary" onClick="validarFormulario('','')">Guardar</button>
                        <? }?>
                        </div>
                            <?php //if($permisoVerLogProyecto){?>
									<a name="log"></a>
                            		<div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                         <h4>Historial del protocolo</h4>
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
                                                $rProLog=cProtocolo::getProyectoLog($pro_id);
                                                if($rProLog->cantidad()>0 && ($pro_status!=ST_BORRADOR)){
                                                    for($i=0;$i<$rProLog->cantidad();$i++){?>
                                                      <tr>
                                                        <td><p class="texto-publicacion letra-gris-oscuro"><?=convertirFechaHora($rProLog->campo('plog_fecha_hora',$i))?></p></td>
                                                        <td><p class="texto-publicacion letra-gris-oscuro"><?=$rProLog->campo('sp_descripcion',$i)?></p></td>
                                                        <td><p class="texto-publicacion letra-gris-oscuro"><?=$rProLog->campo('plog_comentario',$i)?></p></td>
                                                      </tr>
                                                 <? }//end for
                                               } else {?>
                                                      <tr>
                                                        <td colspan="3">No se encontraron registros</td>
                                                      </tr>
                                                <? }//end if?>
                                            </tbody>
                                          </table>
                                          </div>
                                        </div>
                                        </div>
							<?php //}?>
                            
							<? if($permisoVerCronograma && !empty($id)){
							$rVisitas=cProtocolo::obtenerCronograma("", "", $cantResultados, $cantPaginas, "cron_dias_basal", "ASC", $id);?>
							<a name="visitas"></a>
                           <div class="row"><div class="col-md-12 col-lg-12 col-xs-12 col-md-12 col-sm-12 linea_gris"></div></div>
                           <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h3 class="subtitulo_generico">Cronograma visitas&nbsp;-&nbsp;<?=$pro_titulo_breve?></h3>
                                </div>
                           </div>
                                    <div class="row">
										<?php if($rVisitas->cantidad()==0){?>
                                           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">No hay visitas programadas</div>
                                        <?php } else {?>
											<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                              <div class="table-responsive">          
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Visita</th>
                                                    <th>Días Basal</th>
                                                    <th>Ventana Máx.</th>
                                                    <th>Ventana Mín.</th>
                                                    <th>Obs.</th>
                                                    <th>Tipo</th>
                                                    <th>Labo.</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <? for($i=0;$i<$rVisitas->cantidad();$i++){?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita('<?=$rVisitas->campo('cron_id',$i)?>')"><?=$rVisitas->campo('nombre_visita',$i)?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('cron_dias_basal',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('cron_ventana_max',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('cron_ventana_min',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('cron_observaciones',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('tiv_descripcion',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=($rVisitas->campo('cron_laboratorio',$i)==1 ? "Sí":"No" )?></p></td>
                                                  </tr>
                                                  <? }?>
                                                </tbody>
                                              </table>                                              
                                              </div>
                                              </div>
										<?php }//$rVisitas->cantidad()?>
                                    </div>
                                    <?php if($permisoCargarCronograma){?>
			                        <div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 right"><button type="button" class="btn boton-generico btn-primary" onClick="verVisita('')">Nueva visita</button></div>
                                    </div>
                                    <?php }
									}//$permisoVerCronograma?>
                                    
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
