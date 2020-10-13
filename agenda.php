<?php
include_once 'includes/config.php';
//ini_set("display_errors","On");
//error_reporting(E_ALL);
include_once 'clases/cProtocolo.php';
include_once 'clases/cMedico.php';
include_once 'clases/cPaciente.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);

$permisoListarAgenda=seguridadFuncion("LISTAGENDA");
if(!$permisoListarAgenda){
	cDB::cerrar($conexion);
	header("Location:index.php");
	exit();
}

$formulario="agenda";


$accion=$_POST['accion'];
$buscar_medico=filter_var($_POST['buscar_medico'], FILTER_SANITIZE_NUMBER_INT);
$buscar_protocolo=filter_var($_POST['buscar_protocolo'], FILTER_SANITIZE_NUMBER_INT);
$fecha_buscar=$_POST['fecha_buscar'];
if(strlen($fecha_buscar)==0){
	$fecha_buscar=date("Y-m-d");
}
$v=filter_var($_REQUEST['v'], FILTER_SANITIZE_NUMBER_INT);
$_SESSION['pagina_volver']="agenda.php";
if($v!=1){
	/*guardar parametros búsqueda*/
	$_SESSION['buscar_protocolo']=$buscar_protocolo;
	$_SESSION['buscar_medico']=$buscar_medico;
	$_SESSION['fecha_buscar']=$fecha_buscar;
	/*guardar parametros búsqueda*/
} else {
	/*setear parametros búsqueda*/
	$buscar_protocolo=$_SESSION['buscar_protocolo'];
	$buscar_medico=$_SESSION['buscar_medico'];
	$fecha_buscar=$_SESSION['fecha_buscar'];
	/*setear parametros búsqueda*/
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>

<? include_once("includes/head.php");?>
<script language="javascript" charset="utf-8">
	function validarFormulario(varDest, varMenu){
		varError=0;
		document.datos.dest.value=varDest;
		document.datos.menu.value=varMenu;
		document.datos.errorVar.value=varError;
		document.datos.action=varDest;
		document.datos.submit();
	}
	

	function verVisita(varIdVisita,varIdProto){
		document.datos.id_visita.value=varIdVisita;
		document.datos.id_proto.value=varIdProto;
		document.datos.action="formulario_visita_paciente.php";
		document.datos.submit();
	}

	$(document).ready(function() {
		$('#fecha_buscar').datepicker({
			onSelect: function(date) {
				params="fecha_buscar="+date+"&dia_buscar=1&buscar_medico=<?=$buscar_medico?>&buscar_protocolo=<?=$buscar_protocolo?>";
				document.datos.fecha_buscar.value=date;
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia1").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});
				
				params="fecha_buscar="+date+"&dia_buscar=2&buscar_medico=<?=$buscar_medico?>&buscar_protocolo=<?=$buscar_protocolo?>";
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia2").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});

				params="fecha_buscar="+date+"&dia_buscar=3&buscar_medico=<?=$buscar_medico?>&buscar_protocolo=<?=$buscar_protocolo?>";
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia3").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});
			},
			dateFormat: 'yy-mm-dd',
			changeYear: true,
			changeMonth: true
			 <?php if(validateDate($fecha_buscar, 'Y-m-d')){
				echo (",defaultDate: '".$fecha_buscar."'");
			}?>
		 });
		 
		 <?php if(validateDate($fecha_buscar, 'Y-m-d')){?>
				params="fecha_buscar=<?=$fecha_buscar?>&dia_buscar=1&buscar_medico=<?=$buscar_medico?>&buscar_protocolo=<?=$buscar_protocolo?>";
				document.datos.fecha_buscar.value='<?=$fecha_buscar?>';
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia1").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});
				
				params="fecha_buscar=<?=$fecha_buscar?>&dia_buscar=2&buscar_medico=<?=$buscar_medico?>&buscar_protocolo=<?=$buscar_protocolo?>";
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia2").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});

				params="fecha_buscar=<?=$fecha_buscar?>&dia_buscar=3&buscar_medico=<?=$buscar_medico?>&buscar_protocolo=<?=$buscar_protocolo?>";
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia3").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});
		 <?php }?>
		 
		$('select[name=buscar_medico]').change(function() {
				params="fecha_buscar="+document.datos.fecha_buscar.value+"&dia_buscar=1&buscar_medico="+parseInt($(this).val(),10);
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia1").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});
				
				params="fecha_buscar="+document.datos.fecha_buscar.value+"&dia_buscar=2&buscar_medico="+parseInt($(this).val(),10);
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia2").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});

				params="fecha_buscar="+date+"&dia_buscar=3&buscar_medico="+parseInt($(this).val(),10);
				$.ajax({
					beforeSend: function(){},
					complete: function(){ },
					success: function(html){
						$("#tabla_dia3").html(html);
					},
					method: "post",url: "getDiaAgenda.php",data: params, contentType : "application/x-www-form-urlencoded; charset=iso-8859-1"
				});
		});


		//$.fn.select2.defaults.set("theme", "bootstrap");
		//$('#buscar_protocolo').select2();
		//$('#buscar_medico').select2();
	});
</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <body>
		<? include_once("modal.php");?>
	    <form name="datos" method="post">
        <input type="hidden" name="accion" />
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="errorVar" />
        <input type="hidden" name="dest" />
        <input type="hidden" name="menu" />
        <input type="hidden" name="id_visita" />
        <input type="hidden" name="id_proto" />
        <input type="hidden" name="fecha_buscar" value="<?=$fecha_buscar?>"/>
        <input type="hidden" name="pagina" />
		<? include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Agenda de visitas</h2>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 right">
                </div>
            </div>
        </section>
        <section class="main-content generico-container">
            <div class="container">
				<?php
					include_once("indexl_fichas.php");?>
                    <div class="col-md-10 col-sm-10 col-xs-12 container-right fondo_home">
    	            <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12 fondo_blanco">
                    	<div class="row">
		                    <div class="col-md-12">
                                <div class="linea_sky"></div>
                                <div class="row">
                                    <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
                                      <table class="">
                                          <tr>
                                            <td colspan="5"><em>Calendario</em></td>
                                          </tr>
                                      </table>

                                      <table class="table">
                                      	<thead>
                                        	<tr>
                                            	<th>
                                                	Elegir fecha
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<tr>
                                            	<td>
                                                	<div id="fecha_buscar"></div>
                                                </td>
                                            </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                    <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
                                      <div class="table-responsive" style="max-height:266px;height:266px">          
                                      <table class="">
                                          <tr>
                                            <td colspan="5"><em>Avisos - Vencidas</em></td>
                                          </tr>
                                      </table>
                                      <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th>Fecha</th>
                                            <th>HC</th>
                                            <th>Iniciales</th>
                                            <th>Estado</th>
                                          </tr>
                                        </thead>
                                        <?php $rVen=cPaciente::obtenerVisitasPacienteCalendario("provis_fecha_agenda", "ASC","","","",date('Y-m-d', strtotime(date("Y-m-d") . " - 1 day")), ST_VIS_PROGRAMADA);?>
                                        <tbody id="tabla_vencidas">
                                            <?php
                                            if($rVen->cantidad()>0){
                                                for($i=0;$i<$rVen->cantidad();$i++){
												?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita('<?=$rVen->campo('provis_id',$i)?>','<?=$rVen->campo('provis_pro_id',$i)?>')"><?=convertirFechaComprimido($rVen->campo('provis_fecha_agenda',$i))?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita('<?=$rVen->campo('provis_id',$i)?>','<?=$rVen->campo('provis_pro_id',$i)?>')"><?=$rVen->campo('provis_pac_id',$i)?></a></p></td>
													<td><p class="texto-publicacion letra-gris-oscuro"><?=$rVen->campo('pac_iniciales',$i)?></p></td>
	
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rVen->campo('sv_descripcion',$i)?></p></td>
                                                  </tr>
                                             <? }//end for
                                            } else {?>
                                                  <tr>
                                                    <td colspan="5">No hay visitas vencidas
                                                  </tr>
                                            <? }//end if ?>
                                        </tbody>
                                      </table>
                                      </div>

                                    </div>
                                    <div class="col-md-5 col-lg-5 col-sm-5 col-xs-12">
                                      <!--<div class="table-responsive">          
                                      <table class="">
                                          <tr>
                                            <td colspan="5"><em>Avisos - Reprogramar</em></td>
                                          </tr>
                                      </table>
                                      <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th>Fecha</th>
                                            <th>HC</th>
                                            <th>Nombre</th>
                                            <th>Motivo</th>
                                          </tr>
                                        </thead>
                                        <tbody id="tabla_reprogramar">
                                            <?php
                                            /*if($rPro->cantidad()>0){
                                                for($i=0;$i<$rPro->cantidad();$i++){*/
												?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verPro('<?//=$rPro->campo('pro_id',$i)?>')"><?//=$rPro->campo('pro_codigo_estudio',$i)?>02/10/2020</a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verPro('<?//=$rPro->campo('pro_id',$i)?>')"><?//=$rPro->campo('pro_titulo_breve',$i)?></a>5454</p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?//=strtoupper($rPro->campo('inv_apellido',$i)).', '.ucfirst($rPro->campo('inv_nombre',$i))?>Programada</p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?//=strtoupper($rPro->campo('inv_apellido',$i)).', '.ucfirst($rPro->campo('inv_nombre',$i))?>Programada</p></td>
                                                  </tr>
                                             <? //}//end for
                                            //} else {?>
                                                  <tr>
                                                    <td colspan="5">No hay visitas
                                                  </tr>
                                            <? //}//end if */?>
                                        </tbody>
                                      </table>
                                      </div>-->

                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-12">
                                        <div class="form-inline">
                                              <div class="form-group mr-15">
                                                <label>*Médico</label>&nbsp;
                                                <? 	armarCombo(cMedico::obtenerCombo(), "buscar_medico", "form-control", " id=\"buscar_medico\" ".$estadoDis, $buscar_medico, "[Todos]");?>
                                              </div>
                                              <!--<div class="form-group mr-15">
                                                <label>Protocolo</label>
                                                <?php //armarCombo(cProtocolo::obtenerCombo(), "buscar_protocolo", "form-control", " id=\"buscar_protocolo\"", $buscar_protocolo, "[Elegir]");?>
                                              </div>
                                            <button type="button" class="btn boton-generico-left btn-primary" onClick="buscar()">Buscar</button>&nbsp;<button type="button" class="btn boton-generico-left btn-primary" onClick="document.location='agenda.php'">Limpiar</button>-->
                                        </div>
                                	</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12" id="caja_dia1">
                                      <div class="table-responsive" id="tabla_dia1">
                                      </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12" id="caja_dia2">
                                      <div class="table-responsive" id="tabla_dia2">
                                      </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12" id="caja_dia3">
                                      <div class="table-responsive" id="tabla_dia3">
                                      </div>
                                    </div>
                                    
                                </div>
                            </div>
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
