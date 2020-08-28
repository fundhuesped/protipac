<?php
include_once 'includes/config.php';
//error_reporting(E_ALL);
//ini_set("display_errors","On");
include_once 'clases/cEstadoVisita.php';
include_once 'clases/cVisitaNombre.php';
include_once 'clases/cMedico.php';
include_once 'clases/cTipoVisita.php';
include_once 'clases/cProtocolo.php';
include_once 'clases/cPaciente.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
$permisoCargarVisitasPacientes=seguridadFuncion("CARGARVISITASPACIENTES");
$permisoVerVisitasPacientes=seguridadFuncion("VERVISITASPACIENTES");

if(!$permisoVerVisitasPacientes){
	cDB::cerrar($conexion);
	header("Location:login.php");
	exit();
}
	$formulario="pacientes";
	$accion=filter_var($_POST['accion'], FILTER_SANITIZE_STRING);
	$id_pac=filter_var($_REQUEST['id'], FILTER_SANITIZE_NUMBER_INT);
	$id_visita=filter_var($_REQUEST['id_visita'], FILTER_SANITIZE_NUMBER_INT);
	$id_proto=filter_var($_REQUEST['id_proto'], FILTER_SANITIZE_NUMBER_INT);
	$dest=filter_var($_POST['dest'], FILTER_SANITIZE_STRING);

	if($permisoCargarVisitasPacientes){
		$permisoGuardar=true;
	} else {
		if((strlen($id_proto)==0 && strlen($id_visita)>0) || strlen($id_pac)==0 || (strlen($id_proto)>0 && strlen($id_visita)==0)){
			cDB::cerrar($conexion);
			header("Location:login.php");
			exit();
		}
		$permisoGuardar=false;
	}
	if(strlen($id_proto)>0){
		$rPro=cProtocolo::obtenerProtocolo($id_proto,$id_pac);
		if($rPro->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		} else {
			foreach(array_keys($rPro->CAMPOS) as $campo){
				${$campo}=$rPro->campo($campo,0);
			}
		}
	}
	$estadoEdit="";
	if(!empty($id_visita)){
		$estadoEdit="disabled";
		$rVis=cPaciente::obtenerVisitaPaciente($id_visita,$id_proto);
		if($rVis->cantidad()==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		}
		foreach(array_keys($rVis->CAMPOS) as $campo){
			${$campo}=$rVis->campo($campo,0);
		}
	} else {
		$rPac=cPaciente::obtenerPaciente($id_pac);
		if($rPac->cantidad()>0){
			$pac_apellido=$rPac->campo('pac_apellido',0);
			$pac_nombre=$rPac->campo('pac_nombre',0);
			$nombre_visita="Espontánea";
		} else {
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		}
	}

if($accion=="GUARDAR" && $permisoGuardar){
	$errorVar=$_POST['errorVar'];
	if(strlen($id_proto)==0){
		if(strlen($_POST['protocolo_id'])==0){
			cDB::cerrar($conexion);
			header("Location:index.php");
			exit();
		} else {
			$id_proto=$_POST['protocolo_id'];
		}
	}
	$res=cPaciente::modificarVisitaPacienteProtocolo($_POST, $errorVar, $id_proto, $id_pac, $id_visita);
	cDB::cerrar($conexion);
	header("Location:".$dest."?id=".$id_pac."&id_proto=".$id_proto);
	exit();
}
$porcentaje=0;
$vecEmpresaStatus=array(ST_ACTIVO);
if(!empty($id_visita)){
	if($permisoGuardar){
		$titulo_pagina="Editar visita";
	} else {
		$titulo_pagina="Ver visita";
	}
} else {
	$titulo_pagina="Visita";
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
					
                <?php if(strlen($id_proto)==0){?>
					if($('#protocolo_id').val()==""){
						errores+="- Debe elegir el protocolo<br>";
					}
				<?php }?>

				if($("#var_descripcion").val()==""){
					errores+="- Debe ingresar el nombre de la visita<br>";
				}
                <?php if($provis_tiv_id!=TIPO_VIS_ESPO && strlen($id_visita)>0){?>
					if($('#var_ventana_max').val()==""){
						errores+="- Debe ingresar la ventana máxima<br>";
					}
					if($('#var_ventana_min').val()==""){
						errores+="- Debe ingresar la ventana mínima<br>";
					}
				<?php }?>
				if($("#var_fecha_agenda").val()==""){
					errores+="- Debe ingresar la fecha programada<br>";
				}
				if($("#hora_inicio_agenda").val()=="" || $("#minutos_inicio_agenda").val()==""){
					errores+="- Debe ingresar la hora programada con minutos<br>";
				}
                <?php if(strlen($id_visita)>0){?>
				if($('#var_sv_id').val()==<?=ST_VIS_REALIZADA?>){
					if($("#var_fecha_realizada").val()==""){
						errores+="- Debe ingresar la fecha en que se realizó<br>";
					}
					if($("#hora_inicio_realizada").val()=="" || $("#minutos_inicio_realizada").val()==""){
						errores+="- Debe ingresar la hora en que se realizó con minutos<br>";
					}
				}
				<?php }?>
				if($('#var_med_id').val()==""){
					errores+="- Debe ingresar el Médico<br>";
				}
				if($('#var_sv_id').val()==""){
					errores+="- Debe ingresar el Estado<br>";
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
					varDest="<?=$_SESSION['pagina_volver']?>";
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
	
	function verLlamada(){
		document.datos.action='formulario_llamada.php';
		document.datos.submit();
	}
	$(document).ready(function() {
		//$('#var_fecha_agenda').datetimepicker({ 
		$('#var_fecha_agenda').datepicker({ 
			dateFormat: 'yy-mm-dd',
			controlType: 'select',
			oneLine: true//,timeFormat: 'HH:mm:ss'
			});
		//$('#var_fecha_realizada').datetimepicker({ 
		$('#var_fecha_realizada').datepicker({ 
			dateFormat: 'yy-mm-dd',
			//maxDate: new Date(<?//=date("Y")?>, <?//=date("m")?>, <?//=date("d")?>, <?//=date("H")?>, <?//=date("i")?>),
			maxDate: new Date(<?=date("Y")?>, <?=date("m")?>, <?=date("d")?>),
			controlType: 'select',
			oneLine: true//,timeFormat: 'HH:mm:ss'
			});


		$('#var_ventana_max').autoNumeric('init');
		$('#var_ventana_min').autoNumeric('init');
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
	                <a href="javascript:validarFormulario('<?=$_SESSION['pagina_volver']?>','')" class="white back-bread"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;Volver</a>
                </div>
            </div>
        </section>
        <section class="main-content generico-container">
            <div class="container">
				<? include_once("indexl_fichas.php");?>
                <div class="col-md-10 col-sm-10 col-xs-12 container-right fondo_home">
                <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 fondo_blanco">
	                	<h3 class="subtitulo_generico"><?=$titulo_pagina?>&nbsp;-&nbsp;<?=strtoupper($pac_apellido).', '.ucfirst($pac_nombre)?><?=(strlen($id_proto)>0 ? "&nbsp;-&nbsp;Protocolo&nbsp;".$pro_titulo_breve : "")?></h3>
						<div class="linea_sky"></div>
								<p id="submenu">

								</p>
                        <div class="row">
						  <?php if(strlen($id_visita)==0){?>
                          <div class="form-group col-md-4">
                            <label>*Protocolo</label>
                            <?php armarCombo(cProtocolo::obtenerComboPaciente($id_pac), "protocolo_id", "form-control", " id=\"protocolo_id\"", "", "[Elegir]");?>
                          </div>
                          <?php }?>
                          <div class="form-group col-md-4">
                            <label>*Visita</label>&nbsp;
                                <input type="text" class="form-control" name="var_descripcion" id="var_descripcion" placeholder="Ingrese nombre" maxlength="255" <?=$estadoEdit?> value="<?=$nombre_visita?>">
                          </div>
						  <?php if($provis_tiv_id!=TIPO_VIS_ESPO && strlen($id_visita)>0){?>
                          <div class="form-group col-md-4">
                            <label>*Ventana Máx.</label>
                            <input type="text" name="var_ventana_max" id="var_ventana_max" maxlength="255" class="form-control" <?=$estadoRO?> value="7"  data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="-999" data-v-max="999" value="<?=$provis_ventana_max?>"/>
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Ventana Mín.</label>
                            <input type="text" name="var_ventana_min" id="var_ventana_min" maxlength="255" class="form-control" <?=$estadoRO?> value="7" data-a-dec="," data-a-sep="" data-a-sign="" data-v-min="-999" data-v-max="999" value="<?=$provis_ventana_min?>"/>
                          </div>
                          <?php }?>
						</div>
                        <div class="row">
                          <div class="form-group col-md-4">
                            <label>*Médico</label>&nbsp;
                            <? 	armarCombo(cMedico::obtenerCombo(), "var_med_id", "form-control", " id=\"var_med_id\" ".$estadoDis, $provis_med_id, "[Elegir]");?>

                          </div>
                          <div class="form-inline col-md-4">
                            <label>*Fecha programada</label><br>
                            <input type="text" readonly="readonly" size="20" id="var_fecha_agenda"  style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="var_fecha_agenda" class="form-control"  value="<?=substr($provis_fecha_agenda,0,10)?>">&nbsp;<? if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.var_fecha_agenda.value = '';"><? }?>
                          </div>
                          <div class="form-group col-md-4">
                             <div class="form-inline mr-15">
                                <label>*Hora inicio programada</label><br>
                                <?php
                                $hora_inicio_agenda=explode(":",$provis_hora_agenda);
								$hora_inicio_agenda_hora=$hora_inicio_agenda[0];
								$hora_inicio_agenda_min=$hora_inicio_agenda[1];
								?>
                                <select style="max-width:100px" name="hora_inicio_agenda" id="hora_inicio_agenda" class="form-control">
                                    <option value="">[Hora]</option>
                                    <?php
                                    for($i=0;$i<=23;$i++){
                                        echo('<option value="'.$i.'" '.($hora_inicio_agenda_hora==$i && strlen($hora_inicio_agenda_hora)>0 ? "selected":"").'>'.completarNumeroIzq($i,2).'</option>');
                                    }
                                    ?>
                                </select>:
                                <select style="max-width:100px" name="minutos_inicio_agenda" id="minutos_inicio_agenda" class="form-control">
                                    <option value="">[Min.]</option>
                                    <?php
                                    for($i=0;$i<=59;$i++){
                                        echo('<option value="'.$i.'" '.($hora_inicio_agenda_min==$i && strlen($hora_inicio_agenda_min)>0 ? "selected":"").'>'.completarNumeroIzq($i,2).'</option>');
                                    }
                                    ?>
                                </select>
                              </div>
                          </div>
                       </div>
                       <?php if(strlen($id_visita)>0){?>
                       <div class="row">
                          <div class="form-group col-md-4">&nbsp;</div>
                          <div class="form-inline col-md-4">
                            <label>*Fecha realizada</label><br>
                            <input type="text" readonly="readonly" size="20" id="var_fecha_realizada" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="var_fecha_realizada" class="form-control" value="<?=substr($provis_fecha_realizada,0,10)?>">&nbsp;<? if($permisoGuardar){?><input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.var_fecha_realizada.value = '';"><? }?>
                          </div>
                          <div class="form-group col-md-4">
                             <div class="form-inline mr-15">
                                <label>*Hora inicio realizada</label><br>
                                <?php
                                $hora_inicio_realizada=explode(":",$provis_hora_realizada);
								$hora_inicio_realizada_hora=$hora_inicio_realizada[0];
								$hora_inicio_realizada_min=$hora_inicio_realizada[1];
								?>
                                <select style="max-width:100px" name="hora_inicio_realizada" id="hora_inicio_realizada" class="form-control">
                                    <option value="">[Hora]</option>
                                    <?php
                                    for($i=0;$i<=23;$i++){
                                        echo('<option value="'.$i.'" '.($hora_inicio_realizada_hora==$i && strlen($hora_inicio_realizada_hora)>0 ? "selected":"").'>'.completarNumeroIzq($i,2).'</option>');
                                    }
                                    ?>
                                </select>:
                                <select style="max-width:100px" name="minutos_inicio_realizada" id="minutos_inicio_realizada" class="form-control">
                                    <option value="">[Min.]</option>
                                    <?php
                                    for($i=0;$i<=59;$i++){
                                        echo('<option value="'.$i.'" '.($hora_inicio_realizada_min==$i && strlen($hora_inicio_realizada_min)>0 ? "selected":"").'>'.completarNumeroIzq($i,2).'</option>');
                                    }
                                    ?>
                                </select>
                              </div>
                          </div>
                       </div>
                       <?php }?>

                       <div class="row">
                          <div class="form-group col-md-4">
                            <label>Observaciones</label>&nbsp;
                            <textarea style="resize:none" name="var_observaciones" id="var_observaciones" class="form-control" <?=$estadoRO?>><?=$provis_observaciones?></textarea>
                            <label>
                                <div class="letra_help" style="float:left">Caracteres disponibles:&nbsp;</div><div id="max_caracteres_observaciones" class="letra_help" style="float:left"></div>
                            </label>
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Tipo visita</label>&nbsp;
                            <?php armarCombo(cTipoVisita::obtenerCombo((strlen($id_visita)>0 ? array() : array(TIPO_VIS_ESPO))), "var_tiv_id", "form-control", " id=\"var_tiv_id\"".$estadoEdit, $provis_tiv_id, "[Elegir]");?>
                          </div>
                          <div class="form-group col-md-4">
                            <label>*Estado</label>&nbsp;
                            <?php
							 armarCombo(cEstadoVisita::obtenerCombo((strlen($id_visita)>0 ? array(ST_VIS_REALIZADA,ST_VIS_CANCELADA,ST_VIS_PROGRAMADA) : array(ST_VIS_PROGRAMADA))), "var_sv_id", "form-control", " id=\"var_sv_id\" ".($provis_tiv_id==TIPO_VIS_SCR || $provis_tiv_id==TIPO_VIS_BASAL ? "disabled" : ""), $sv_id, "[Elegir]");?>
                          </div>
                        </div>
                        <div class="row">
                        <? if($permisoGuardar){?>
						  	<button type="button" class="btn boton-generico btn-primary" onClick="validarFormulario('','')">Guardar</button>
                        <? }?>
                        </div>

							<?php if($permisoVerVisitasPacientes && !empty($id_visita)){?>
							<a name="visitas"></a>
                           <div class="row"><div class="col-md-12 col-lg-12 col-xs-12 col-md-12 col-sm-12 linea_gris"></div></div>
                           <div class="row">
                                <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h3 class="subtitulo_generico">Llamadas</h3>
                                </div>
                           </div>
                                    <div class="row">
										<?php 
										$rObs=cPaciente::obtenerLlamadasVisitaPaciente($id_visita);
										if($rObs->cantidad()==0){?>
                                           <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">No hay observaciones</div>
                                        <?php } else {?>

											<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                              <div class="table-responsive">          
                                              <table class="table table-hover">
                                                <thead>
                                                  <tr>
                                                    <th>Fecha - Hora</th>
                                                    <th>Texto</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                  <?php for($i=0;$i<$rObs->cantidad();$i++){?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=convertirFechaHora($rObs->campo('proseg_fecha_hora',$i))?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rObs->campo('proseg_observaciones',$i)?></p></td>
                                                  </tr>
                                                  <? }?>
                                                </tbody>
                                              </table>
                                              
                                              </div>
                                              </div>
										<? }//$rObs->cantidad()?>

                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 right"><button type="button" class="btn boton-generico btn-primary" onClick="verLlamada()">Nueva Llamada</button></div>
                                    </div>
                                    <?php }//end if($permisoVerVisitasPacientes && !empty($id_visita))?>


                        
                </div>
                </div>
            </div>
        </section>
        <? include_once("indexf.php");?>
    	</form>
    </body>
</html>
<? cDB::cerrar($conexion);?>
