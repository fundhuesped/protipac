<?php
include_once 'includes/config.php';
//error_reporting(E_ALL);
//ini_set("display_errors","On");
include_once 'clases/cProtocolo.php';
include_once 'clases/cPaciente.php';
include_once 'clases/cSexo.php';
include_once 'clases/cGenero.php';
include_once 'clases/cHospital.php';
include_once 'clases/cTipoDocumento.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
$permisoCargarPaciente=seguridadFuncion("CARGARPACIENTES");
$permisoVerVisitasPacientes=seguridadFuncion("VERVISITASPACIENTES");


if(!$permisoCargarPaciente){
	cDB::cerrar($conexion);
	header("Location:login.php");
	exit();
}
	$_SESSION['pagina_volver']="formulario_paciente.php";
	$formulario="pacientes";
	$accion=filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$id=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	$var_nro_documento=filter_var($_POST['var_nro_documento'], FILTER_SANITIZE_NUMBER_INT);
	$dest=filter_var($_POST['dest'], FILTER_SANITIZE_STRING);
	$doc_valido=filter_var($_POST['doc_valido'], FILTER_SANITIZE_NUMBER_INT);
	if($doc_valido==1){
		$doc_valido=true;
	} else {
		if(strlen($id)>0){
			$doc_valido=true;
		} else {
			$doc_valido=false;
		}
	}
	$buscar_fecha_desde=filter_var($_POST['buscar_fecha_desde'], FILTER_SANITIZE_STRING);
	$buscar_fecha_hasta=filter_var($_POST['buscar_fecha_hasta'], FILTER_SANITIZE_STRING);
	$buscar_protocolo=filter_var($_POST['buscar_protocolo'], FILTER_SANITIZE_NUMBER_INT);
	$buscar_laboratorio=filter_var($_POST['buscar_laboratorio'], FILTER_SANITIZE_NUMBER_INT);

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
	}


if($accion=="GUARDAR" && $permisoGuardar){
	$errorVar=$_POST['errorVar'];
	$res=cPaciente::modificarPaciente($_POST, $errorVar, $id);
	cDB::cerrar($conexion);
	header("Location:".$dest);
	exit();
}
$vecEmpresaStatus=array(ST_ACTIVO);
if(!empty($id)){
	if($permisoGuardar){
		$titulo_pagina="Editar paciente HC ".$pac_id;
	} else {
		$titulo_pagina="Ver paciente HC ".$pac_id;
	}
} else {
	$titulo_pagina="Cargar nuevo paciente";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>

<?php include_once("includes/head.php");?>
<script language="javascript" charset="utf-8">
	function validarFormulario(varDest, varMenu){
		<?php if($permisoGuardar){?>
			varError=0;
			var errores="";
			var fechaValida=0;
			with(document.datos){
				if($('#var_tid_id').val()==""){
					errores+="- Tipo de documento<br>";
				}
				
				if($('#var_nro_documento').val()==""){
					errores+="- Número de documento<br>";
				} else {
					var nuevo_doc=$('#var_nro_documento').val();
					if(isNaN(nuevo_doc)){
						errores+="- El Número de documento debe ser un número, no puede contener puntos, ni guiones.\n";
					} else {
						//if(nuevo_doc.length!=11){
						//	errores+="- El CUIT de empresa debe ser un número de 11 dígitos, sin puntos ni guiones.\n";
						//} else {
							params="tabla=paciente&campo=pac_nro_documento&valor="+$('#var_nro_documento').val();
							<? if($id>0){?>
								params+="&campoDistinto=pac_id&valorDistinto=<?=$id?>";
							<? } else {?>
								params+="&usuario_nuevo=1";
							<? }?>
							var resultado=$.ajax({
									beforeSend: function(){},
									complete: function(){ },
									success: function(html){ },
									async:false,
									method: "post",url: "verificar_codigo.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
							}).responseText;
							if(resultado=="1"){
								errores+="- El Número de documento ingresado corresponde a otra persona que ya ha sido cargada en el sistema\n";
							}
							if(resultado=="2"){
								errores+="- El Número de documento es incorrecto\n";
							}
						//}
					}
				}

				/*if($('#var_nro_documento').val()==""){
					errores+="- Número de documento<br>";
				}*/
				<?php if($doc_valido){?>
				if($('#var_fecha_ingreso').val()=="" || $('#var_fecha_ingreso').val()=="//"){
					errores+="- Fecha de ingreso<br>";
				} else {
					if(isDateValidFull($('#var_fecha_ingreso').val(), "/")){
						varFechaIngreso=new Date($('#var_fecha_ingreso').val());
						varFechaHoy=new Date();
						if(varFechaIngreso>varFechaHoy){
							errores+="- La fecha de ingreso no puede ser posterior al día actual<br>";
						} else {
							fechaIngresoValida=1;
						}
					} else {
						errores+="- Fecha de ingreso tiene un formato inválido. Debe ser dd/mm/aaaa<br>";
					}
				}
				<?php }?>
				if($('#var_iniciales').val()==""){
					errores+="- Iniciales<br>";
				}
				if($('#var_nombre').val()==""){
					errores+="- Nombre<br>";
				}
				/*if($('#var_segundo_nombre').val()==""){
					errores+="- Segundo nombre<br>";
				}*/
				if($('#var_apellido').val()==""){
					errores+="- Apellido<br>";
				}
				/*if($('#var_segundo_apellido').val()==""){
					errores+="- Segundo Apellido<br>";
				}*/
				/*if($('#var_alias').val()==""){
					errores+="- Nombre autopercibido<br>";
				}*/
				if($('#var_sex_id').val()==""){
					errores+="- Sexo<br>";
				}
				if($('#var_gen_id').val()==""){
					errores+="- Género<br>";
				}
				<?php if($doc_valido){?>
				if($('#var_fecha_nacimiento').val()=="" || $('#var_fecha_nacimiento').val()=="//"){
					errores+="- Fecha de nacimiento<br>";
				} else {
					if(isDateValidFull($('#var_fecha_nacimiento').val(), "/")){
						varFechaNacimiento=new Date($('#var_fecha_nacimiento').val());
						varFechaHoy=new Date();
						if(varFechaNacimiento>varFechaHoy){
							errores+="- La fecha de nacimiento no puede ser posterior al día actual<br>";
						} else {
							if(fechaIngresoValida==1){
								if(varFechaIngreso<varFechaNacimiento){
									errores+="- La fecha de nacimiento no puede ser posterior a la fecha de ingreso<br>";
								}
							}
						}
					} else {
						errores+="- Fecha de nacimiento tiene un formato inválido. Debe ser dd/mm/aaaa<br>";
					}
				}
				<?php }?>
				/*if($('#var_docmicilio_calle').val()==""){
					errores+="- Domicilio Calle<br>";
				}
				if($('#var_docmicilio_numero').val()==""){
					errores+="- Domicilio Número<br>";
				}
				if($('#var_docmicilio_id_provincia').val()==""){
					errores+="- Domicilio Provincia<br>";
				}
				if($('#var_docmicilio_id_partido').val()==""){
					errores+="- Domicilio Partido<br>";
				}
				if($('#var_docmicilio_id_localidad').val()==""){
					errores+="- Domicilio Localidad<br>";
				}
				if($('#var_docmicilio_cod_pos').val()==""){
					errores+="- Domicilio Código Postal<br>";
				}*/
				if($('#var_obra_social').val()==""){
					errores+="- Cobertura de salud<br>";
				}
				/*if($('#var_ocupacion').val()==""){
					errores+="- Ocupación<br>";
				}*/
				if($('#var_medico_deriva').val()==""){
					errores+="- Médico que deriva<br>";
				}
				if($("#pac_reh_id").val()==""){
					errores+="- Hospital de procedencia<br>";
				} else {
					if($("#pac_reh_id").val()=="-1"){
						if($("#otro_hospital").val()==""){
							errores+="- Completar el hospital de procedencia<br>";
						}
					}
				}
				/*if($('#telefono_celular').val()=="" && $('#telefono_casa').val()=="" && $('#telefono_contacto').val()=="" && $('#email_contacto').val()=="" && $('#redes_sociales').val()==""){
					errores+="- Debe completar al menos un dato de contacto<br>";
				} else {
					if($('#email_contacto').val()!=""){
						if($('#var_recibir_email').val()==""){
							errores+="- ¿Desea recibir emails de FH?<br>";
						}
					}
				}*/
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
					<?php if($permisoGuardar){?>
					$("#alerta-formulario").find("#alerta-titulo").text("Faltan completar datos.");
					$("#alerta-formulario").find('#alerta-cuerpo').html(errores.replace(/\n/g, "<br />"));
					$('#alerta-formulario').modal('show');
					<?php } else {?>
							document.location=varDest;
					<?php }?>
				}
			} else {
				if(varDest==""){
					varDest="pacientes.php";
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
		<?php } else {?>
			document.datos.v.value=1;
			document.datos.target="_self";
			document.datos.accion.value="";			
			document.datos.action=varDest;
			document.datos.submit();
		<?php }//end if $permisoGuardar?>
	}
	function validarDoc(){
		var errores="";
		if($('#var_nro_documento').val()==""){
			errores+="- Debe completar el Número de documento<br>";
		} else {
			var nuevo_doc=$('#var_nro_documento').val();
			if(isNaN(nuevo_doc)){
				errores+="- El Número de documento debe ser un número, no puede contener puntos, ni guiones.\n";
			} else {
				//if(nuevo_doc.length!=11){
				//	errores+="- El CUIT de empresa debe ser un número de 11 dígitos, sin puntos ni guiones.\n";
				//} else {
					params="tabla=paciente&campo=pac_nro_documento&valor="+$('#var_nro_documento').val();
					<? if($id>0){?>
						params+="&campoDistinto=pac_id&valorDistinto=<?=$id?>";
					<? } else {?>
						params+="&usuario_nuevo=1";
					<? }?>
					var resultado=$.ajax({
							beforeSend: function(){},
							complete: function(){ },
							success: function(html){ },
							async:false,
							method: "post",url: "verificar_codigo.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
					}).responseText;
					if(resultado=="1"){
						errores+="- El Número de documento ingresado corresponde a otra persona que ya ha sido cargada en el sistema\nPuede buscarlo en el listado de pacientes para verificar si es un error de carga o bien el paciente ya fue cargado previamente.";
					}
					if(resultado=="2"){
						errores+="- El Número de documento es incorrecto\n";
					}
				//}
			}
		}
		if(errores!=""){
			$("#alerta").find("#alerta-titulo").text("Errores");
			$("#alerta").find('#alerta-cuerpo').html(errores.replace(/\n/g, "<br />"));
			$('#alerta').modal('show');
		} else {
			document.datos.doc_valido.value=1;
			document.datos.action="";
			document.datos.target="_self";
			document.datos.submit();			
		}

	}
	function verVisita(varIdVisita,varIdProto){
		document.datos.id_visita.value=varIdVisita;
		document.datos.id_proto.value=varIdProto;
		document.datos.action="formulario_visita_paciente.php";
		document.datos.submit();
	}
	function verProtocolo(varPro){
		document.datos.id_proto.value=varPro;
		document.datos.action="formulario_protocolo_paciente.php";
		document.datos.submit();
	}

	$(document).ready(function() {
		$('#domicilio_numero').autoNumeric('init');
		$('#var_nro_documento').autoNumeric('init');
		$('#buscar_fecha_desde').datepicker({ dateFormat: 'dd/mm/yy' });
		$('#buscar_fecha_hasta').datepicker({ dateFormat: 'dd/mm/yy' });
		$('#var_fecha_ingreso').datepicker({ dateFormat: 'dd/mm/yy' });
		$('#var_fecha_nacimiento').datepicker({ 
			dateFormat: 'dd/mm/yy',
			changeYear: true,
			changeMonth:true,
			yearRange: "1900:<?=date("Y")?>",
			maxDate:"<?=date("Y-m-d")?>"});

		$('select[name=pac_reh_id]').change(function() {
			switch(parseInt($(this).val(),10)){
				case -1:
					$("#otro_hospital").removeAttr("disabled");
					$("#capa_otro_hospital").show();
				break;
				default:
					$("#otro_hospital").attr("disabled","disabled");
					$("#capa_otro_hospital").hide();
				break;
			}
		});
		switch(parseInt($('select[name=pac_reh_id]').val(),10)){
			case -1:
				$("#otro_hospital").removeAttr("disabled");
				$("#capa_otro_hospital").show();
			break;
			default:
				$("#otro_hospital").attr("disabled","disabled");
				$("#capa_otro_hospital").hide();
			break;
		}	
		$("#var_observaciones").MaxLength(
		{
			MaxLength: 2000,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_caracteres_observaciones')
		});
		$("#obs_celular").MaxLength(
		{
			MaxLength: 500,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_obs_celular')
		});
		$("#obs_casa").MaxLength(
		{
			MaxLength: 500,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_obs_casa')
		});
		$("#obs_contacto").MaxLength(
		{
			MaxLength: 500,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_obs_contacto')
		});
		$("#obs_email").MaxLength(
		{
			MaxLength: 500,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_obs_email')
		});
		$("#obs_redes").MaxLength(
		{
			MaxLength: 500,
			//DisplayCharacterCount: false,			
			CharacterCountControl: $('#max_obs_redes')
		});
		$.fn.select2.defaults.set("theme", "bootstrap");
		$('#pac_reh_id').select2({
			width: null,
			tags:true
		});		
	});
</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <body>
		<iframe name="frm" id="frm" class="hidden" width="0" height="0"></iframe>
		<?php include_once("modal.php");?>
		<?php include_once("modal_formulario.php");?>
	    <form name="datos" method="post" enctype="multipart/form-data">
        <input type="hidden" name="accion" />
        <input type="hidden" name="v" />
        <input type="hidden" name="errorVar" />
        <input type="hidden" name="dest" />
        <input type="hidden" name="menu" />
        <input type="hidden" name="id" value="<?=$id?>" />
        <input type="hidden" name="id_pac" value="<?=$id?>" />
        <input type="hidden" name="id_proto" value="" />
        <input type="hidden" name="id_visita" value="" />
        <input type="hidden" name="doc_valido" value="" />
		<?php include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Paciente</h2>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 right mt-20">
	                <a href="javascript:validarFormulario('pacientes.php','')" class="white back-bread"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Volver</a>
                </div>
            </div>
        </section>
        <section class="main-content generico-container">
            <div class="container">
				<?php include_once("indexl_fichas.php");?>
                <div class="col-md-10 col-sm-10 col-xs-12 container-right fondo_home">
                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 fondo_blanco">
	                	<h3 class="subtitulo_generico"><?=$titulo_pagina?></h3>
						<div class="linea_sky"></div>
                        	<?php if(!empty($id)){?>
								<p id="submenu">
									<?=($permisoVerVisitasPacientes ? '[<a href="formulario_paciente.php#visitas">Visitas</a>] ' : '')?><?=($permisoCargarPaciente ? '&nbsp;[<a href="formulario_paciente.php#protocolos">Protocolos</a>] ' : '')?>
								</p>
							<?php }?>
                        <div class="row">
                          <div class="form-group col-md-3">
                            <label>*Nro. documento</label>
                            <input type="text" name="var_nro_documento" id="var_nro_documento" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=(strlen($id)==0 ? $var_nro_documento : $pac_nro_documento)?>" data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="0" data-v-max="999999999" />
                            <?php if(!$doc_valido && strlen($id)==0){?>
                                <button type="button" class="btn boton-generico-left btn-primary" onClick="validarDoc('','')">Validar Documento</button>
                            <? }?>
                          </div>
                          <?php if($doc_valido || strlen($id)>0){?>
                              <div class="form-group col-md-3 col-xs-12">
                                    <label>*Tipo documento</label>
                                    <?php armarCombo(cTipoDocumento::obtenerCombo(array(ST_ACTIVO)), "var_tid_id", "form-control", "id=\"var_tid_id\"".$estadoRO, $pac_tid_id, "[Elegir tipo de documento]");?>
                              </div>
                              <div class="form-inline col-md-3">
                                <label>*Fecha ingreso</label><br>
                                <input type="text" readonly="readonly" size="20" id="var_fecha_ingreso" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="var_fecha_ingreso" class="form-control" value="<?=convertirFechaComprimido($pac_fecha_ingreso)?>">&nbsp;<?php if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.var_fecha_ingreso.value = '';"><?php }?>
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Iniciales</label>
                                <input type="text" name="var_iniciales" id="var_iniciales" maxlength="8" class="form-control" value="<?=$pac_iniciales?>"  />
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-3">
                                <label>*Nombre</label>
                                <input type="text" name="var_nombre" id="var_nombre" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_nombre?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>Segundo nombre</label>
                                <input type="text" name="var_segundo_nombre" id="var_segundo_nombre" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_segundo_nombre?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Apellido</label>
                                <input type="text" name="var_apellido" id="var_apellido" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_apellido?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>Segundo apellido</label>
                                <input type="text" name="var_segundo_apellido" id="var_segundo_apellido" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_segundo_apellido?>" />
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-3">
                                <label>Nombre autopercibido</label>
                                <input type="text" name="var_alias" id="var_alias" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_alias?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Sexo</label>
                                <?php armarCombo(cSexo::obtenerCombo(), "var_sex_id", "form-control", $estadoDis, $pac_sex_id, "[Elegir]");?>
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Género</label>
                                <?php armarCombo(cGenero::obtenerCombo(), "var_gen_id", "form-control", $estadoDis, $pac_gen_id, "[Elegir]");?>
                              </div>
                              <div class="form-inline col-md-3">
                                <label>*Fecha nacimiento</label><br>
                                <input type="text" readonly="readonly" size="20" id="var_fecha_nacimiento" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="var_fecha_nacimiento" class="form-control" value="<?=convertirFechaComprimido($pac_fecha_nacimiento)?>">&nbsp;<?php if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.var_fecha_nacimiento.value = '';"><?php }?>
                              </div>
                            </div>
                           <!-- <div class="row">
                              <div class="form-group col-md-3">
                                <label>*Calle</label>
                                <input type="text" name="domicilio_calle" id="domicilio_calle" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$ent_domicilio_calle?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Número</label>
                                <input type="text" name="domicilio_numero" id="domicilio_numero" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$ent_domicilio_numero?>"  data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="0" data-v-max="999999"/>
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Piso</label>
                                <input type="text" name="domicilio_piso" id="domicilio_piso" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$ent_domicilio_piso?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Departamento</label>
                                <input type="text" name="domicilio_departamento" id="domicilio_departamento" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$ent_domicilio_departamento?>" />
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-3">
                                <label>*Otros datos domicilio</label>
                                <input type="text" name="domicilio_otros_datos" id="domicilio_otros_datos" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$ent_domicilio_otros_datos?>" />
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Provincia</label>
                                <select name="domicilio_id_provincia" class="form-control">
                                    <option value="">[Elegir]</option>
                                </select>
                                <?php //armarCombo(cProvincia::obtenerCombo(), "var_fase_id", "form-control", " id=\"var_fase_id\" ".$estadoDis, $pro_fase_id, "[Elegir fase de investigación]");?>       
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Partido</label>
                                <select name="domicilio_id_partido" class="form-control">
                                    <option value="">[Elegir]</option>
                                </select>
                                <?php //armarCombo(cProvincia::obtenerCombo(), "var_fase_id", "form-control", " id=\"var_fase_id\" ".$estadoDis, $pro_fase_id, "[Elegir fase de investigación]");?>       
                              </div>
                              <div class="form-group col-md-3">
                                <label>*Localidad</label>
                                <select name="domicilio_id_localidad" class="form-control">
                                    <option value="">[Elegir]</option>
                                </select>
                                <?php //armarCombo(cProvincia::obtenerCombo(), "var_fase_id", "form-control", " id=\"var_fase_id\" ".$estadoDis, $pro_fase_id, "[Elegir fase de investigación]");?>       
                              </div>
    
                            </div>-->
                            <div class="row">
                              <!--<div class="form-group col-md-3">
                                <label>Cod. Pos.</label>
                                <input type="text" name="domicilio_cod_pos" id="domicilio_cod_pos" maxlength="255" class="form-control" <//?=$estadoRO?> value="<?//=$ent_domicilio_cod_pos?>" />
                              </div>-->
                              <div class="form-group col-md-3">
                                <label>*Cobertura de salud</label>
                                <input type="text" name="var_obra_social" id="var_obra_social" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_obra_social?>" />
                              </div>
                              <!--<div class="form-group col-md-3">
                                <label>*Ocupación</label>
                                <input type="text" name="var_ocupacion" id="var_ocupacion" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_ocupacion?>" />
                              </div>-->
                              <div class="form-group col-md-3">
                                <label>*Médico que deriva</label>
                                <input type="text" name="var_medico_deriva" id="var_medico_deriva" maxlength="255" class="form-control" <?=$estadoRO?> value="<?=$pac_medico_deriva?>" />
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-3">
                                <label>*Hospital procedencia</label>&nbsp;
                                <div class="ayuda">
                                    <img src="images/ayuda.png">
                                  <span class="tooltiptext">
                                    Buscar hospital de procedencia, si no se encuentra, elegir opción OTRO y completar el nombre.
                                  </span>
                                </div>
                                &nbsp;Elegir hospital:
                                <?php 	armarComboOtro(cHospital::obtenerCombo(), "pac_reh_id", "form-control", " id=\"pac_reh_id\" ".$estadoDis, $pac_reh_id, "[Elegir Hospital]");?>
                                <div id="capa_otro_hospital">
                                    <label>*Otro hospital</label>
                                    <input type="text" class="form-control" name="otro_hospital" id="otro_hospital" placeholder="Ingrese hospital" maxlength="255">
                                </div>
                              </div>
                              <div class="form-group col-md-9">
                                <label>Observaciones</label>&nbsp;
                                <textarea  name="var_observaciones" rows="5" id="var_observaciones" class="form-control" <?=$estadoRO?>><?=$pac_observaciones?></textarea>
                                <label>
                                    <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_observaciones" class="letra_help" style="float:left"></div>
                                </label>
                              </div>
                            </div>
                           <!--<div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h3 class="subtitulo_generico">Contactos</h3>
                                </div>
                           </div>
                           <div class="row">
                              <div class="form-group col-md-3">
                                <label>Teléfono Celular</label>
                                <input type="text" name="telefono_celular" id="telefono_celular" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$telefono_celular?>" />
                                <label>Observaciones</label>
                                <textarea  name="obs_celular" style="resize:none" rows="3" id="obs_celular" class="form-control" <?//=$estadoRO?>><?//=$obs_celular?></textarea>
                                <label>
                                    <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_obs_celular" class="letra_help" style="float:left"></div>
                                </label>
                              </div>
                              <div class="form-group col-md-3">
                                <label>Teléfono Casa</label>
                                <input type="text" name="telefono_casa" id="telefono_casa" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$telefono_casa?>" />
                                <label>Observaciones</label>
                                <textarea  name="obs_casa" style="resize:none" rows="3" id="obs_casa" class="form-control" <?//=$estadoRO?>><?//=$obs_casa?></textarea>
                                <label>
                                    <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_obs_casa" class="letra_help" style="float:left"></div>
                                </label>
                              </div>
                              <div class="form-group col-md-2">
                                <label>Otro teléfono</label>
                                <input type="text" name="telefono_contacto" id="telefono_contacto" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$telefono_contacto?>" />
                                <label>Observaciones</label>
                                <textarea  name="obs_contacto" style="resize:none" rows="3" id="obs_contacto" class="form-control" <?//=$estadoRO?>><?//=$obs_contacto?></textarea>
                                <label>
                                    <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_obs_contacto" class="letra_help" style="float:left"></div>
                                </label>
                              </div>
                              <div class="form-group col-md-2">
                                <label>Email</label>
                                <input type="text" name="email_contacto" id="email_contacto" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$email_contacto?>" />
                                <label>Observaciones</label>
                                <textarea  name="obs_email" style="resize:none" rows="3" id="obs_email" class="form-control" <?//=$estadoRO?>><?//=$obs_email?></textarea>
                                <label>
                                    <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_obs_email" class="letra_help" style="float:left"></div>
                                </label>
                                <div class="form-inline"><label>¿Desea recibir e-mails de FH?</label>&nbsp;
                                <select name="var_recibir_email" id="var_recibir_email" class="form-control" <?//=$estadoDis?>>
                                    <option value=""  <?//=($pac_recibir_email==="" || is_null($pac_recibir_email) ? "selected" : "")?>>[Elegir]</option>
                                    <option value="1" <?//=($pac_recibir_email==1 ? "selected" : "")?>>Sí</option>
                                    <option value="0" <?//=($pac_recibir_email===0 && !is_null($pac_recibir_email) ? "selected" : "")?>>No</option>
                                </select>
                                </div>
                              </div>
                              <div class="form-group col-md-2">
                                <label>Redes sociales</label>
                                <input type="text" name="redes_sociales" id="redes_sociales" maxlength="255" class="form-control" <?//=$estadoRO?> value="<?//=$redes_sociales?>" />
                                <label>Observaciones</label>
                                <textarea  name="obs_redes" style="resize:none" rows="3" id="obs_redes" class="form-control" <?//=$estadoRO?>><?//=$obs_redes?></textarea>
                                <label>
                                    <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_obs_redes" class="letra_help" style="float:left"></div>
                                </label>
                              </div>
                           </div>-->
                            <div class="row">
                            <?php if($permisoGuardar){?>
                                <button type="button" class="btn boton-generico btn-primary" onClick="validarFormulario('','')">Guardar</button>
                            <?php }?>
                            </div>
                          <?php }//end if $doc_valido?>
                            
							<?php if($permisoVerVisitasPacientes && !empty($id)){?>
							<a name="visitas"></a>
                           <div class="row"><div class="col-md-12 col-lg-12 col-xs-12 col-md-12 col-sm-12 linea_gris"></div></div>
                           <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h3 class="subtitulo_generico">Visitas para el paciente HC <?=$id.' - '.strtoupper($pac_apellido).', '.ucfirst($pac_nombre)?></h3>
                                </div>
                           </div>
                                    <div class="row">
										<?php 
										$rVisitas=cPaciente::obtenerVisitasProgramadasPacienteProtocolo("", "", $cantResultados, $cantPaginas, "cron_dias_basal", "ASC", "",$id,$buscar_laboratorio, $buscar_protocolo,$buscar_fecha_desde,$buscar_fecha_hasta);
										if($rVisitas->cantidad()==0){?>
                                           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">No hay visitas</div>
                                        <?php } else {?>
								<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="form-inline">
                                      <div class="form-group mr-15">
                                        <label>Protocolo</label>
			                            <?php armarCombo(cProtocolo::obtenerComboPaciente($id), "buscar_protocolo", "form-control", " id=\"buscar_protocolo\"", $buscar_protocolo, "[Todos]");?>
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>*Laboratorio</label>
                                        <select name="buscar_laboratorio" id="buscar_laboratorio" class="form-control" <?=$estadoDis?>>
                                            <option value=""  <?=($buscar_laboratorio=="" && strlen($buscar_laboratorio)==0 ? "selected" : "")?>>[Elegir]</option>
                                            <option value="1" <?=($buscar_laboratorio==1 ? "selected" : "")?>>Sí</option>
                                            <option value="0" <?=($buscar_laboratorio==0 && strlen($buscar_laboratorio)>0 ? "selected" : "")?>>No</option>
                                        </select>
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>*Fecha desde</label>
                                        <input type="text" readonly="readonly" size="20" id="buscar_fecha_desde" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="buscar_fecha_desde" class="form-control" value="<?=$buscar_fecha_desde?>">&nbsp;<input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.buscar_fecha_desde.value = '';">
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>Fecha hasta</label>
                                        <input type="text" readonly="readonly" size="20" id="buscar_fecha_hasta" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="buscar_fecha_hasta" class="form-control" value="<?=$buscar_fecha_hasta?>">&nbsp;<input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.buscar_fecha_hasta.value = '';">
                                       </div>
                                    <button type="button" class="btn boton-generico-left btn-primary" onClick="buscarDestino('visitas')">Buscar</button>
                                    </div>






                                </div>

											<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                              <div class="table-responsive">          
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Fecha</th>
                                                    <th>Visita</th>
                                                    <th>Estado</th>
                                                    <th>Protocolo</th>
                                                    <th>Labo</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php for($i=0;$i<$rVisitas->cantidad();$i++){?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita(<?=$rVisitas->campo('provis_id',$i)?>,<?=$rVisitas->campo('provis_pro_id',$i)?>)">
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
													?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita(<?=$rVisitas->campo('provis_id',$i)?>,<?=$rVisitas->campo('provis_pro_id',$i)?>)"><?=$rVisitas->campo('nombre_visita',$i)?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><span class="label <?=$rVisitas->campo('sv_estilo',$i)?>"><?=$rVisitas->campo('sv_descripcion',$i)?></span></p></td>


                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVisitas->campo('pro_titulo_breve',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=((is_null($rVisitas->campo('cron_laboratorio',$i)) || $rVisitas->campo('cron_laboratorio',$i)==0) && (is_null($rVisitas->campo('provis_laboratorio',$i)) || $rVisitas->campo('provis_laboratorio',$i)==0)  ? "No":"Sí")?></p></td>
                                                  </tr>
                                                  <?php }?>
                                                </tbody>
                                              </table>
                                              
                                              </div>
                                              </div>

										<?php }//$rVisitas->cantidad()?>

                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 right"><button type="button" class="btn boton-generico btn-primary" onClick="verVisita()">Nueva visita</button></div>
                                    </div>
                                    <?php }//end if($permisoVerVisitasPacientes && !empty($id))?>

                                 
                                 
							<?php if($permisoCargarPaciente && !empty($id)){?>
							<a name="protocolos"></a>
                           <div class="row"><div class="col-md-12 col-lg-12 col-xs-12 col-md-12 col-sm-12 linea_gris"></div></div>
                           <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h3 class="subtitulo_generico">Protocolos para el paciente HC <?=$id.' - '.strtoupper($pac_apellido).', '.ucfirst($pac_nombre)?></h3>
                                </div>
                           </div>
                                    <div class="row">
										<?php 
										$rPro=cPaciente::obtenerProtocolos("", "", $cantResultadosPro, $cantPaginasPro, "pro_titulo_breve", "ASC", $id);?>
                                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                              <div class="table-responsive">          
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Nombre Ref.</th>
                                                    <th>Protocolo</th>
                                                    <th>Estado</th>
                                                    <th>Screening</th>
                                                    <th>Basal</th>
                                                    <th>Fallo</th>
                                                    <th>Médico</th>
                                                    <th>Obs.</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if($rPro->cantidad()>0){
                                                        for($i=0;$i<$rPro->cantidad();$i++){
                                                        ?>
                                                          <tr>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verProtocolo('<?=$rPro->campo('pro_id',$i)?>')"><?=$rPro->campo('pro_codigo_estudio',$i)?></p></a></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verProtocolo('<?=$rPro->campo('pro_id',$i)?>')"><?=$rPro->campo('pro_titulo_breve',$i)?></p></a></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><span class="label <?=$rPro->campo('spp_estilo',$i)?>"><?=$rPro->campo('spp_descripcion',$i)?></span></p></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><?=convertirFechaComprimido($rPro->campo('fecha_screening',$i))?></p></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><?=convertirFechaComprimido($rPro->campo('fecha_basal',$i))?></p></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro">--</p></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><?=strtoupper($rPro->campo('med_apellido',$i)).', '.ucfirst($rPro->campo('med_nombre',$i))?></p></td>
                                                            <td><p class="texto-publicacion letra-gris-oscuro"><?=$rPro->campo('propac_observaciones',$i)?></p></td>
                                                          </tr>
                                                     <?php  }//end for
                                                    } else {?>
                                                          <tr>
                                                            <td colspan="11">El paciente no está ingresado en ningún protocolo</td>
                                                          </tr>
                                                    <?php }//end if?>
                                                </tbody>
                                              </table>
                                              </div>
                                            </div>
									<?php if($permisoCargarPaciente && !empty($id)){?>
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 right"><button type="button" class="btn boton-generico btn-primary" onClick="verProtocolo()">Agregar paciente a un protocolo</button></div>
                                    <?php }
									}//end if?>
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
