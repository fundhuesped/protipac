<?php
include_once 'includes/config.php';
//ini_set("display_errors","On");
//error_reporting(E_ALL);
include_once 'clases/cProtocolo.php';
include_once 'clases/cPaciente.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);

$permisoListarPacientes=seguridadFuncion("LISTPACIENTES");
$permisoCargarPacientes=seguridadFuncion("CARGARPACIENTES");
if(!$permisoListarPacientes){
	cDB::cerrar($conexion);
	header("Location:index.php");
	exit();
}
$id=filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);;
/*if($permisoListEmpresas && $_SESSION['usr_emp_id']!=$empresa_id && !empty($empresa_id)){
	$permisoGuardar=false;
	$impersonar=true;
} else {
	$impersonar=false;
	$empresa_id=$_SESSION['usr_emp_id'];
	$permisoGuardar=true;
}*/
$formulario="pacientes";



$accion=$_POST['accion'];
$titulo_pagina="Listado de pacientes";
$buscar_paciente=$_POST['buscar_paciente'];
$buscar_hc=$_POST['buscar_hc'];
$buscar_iniciales=$_POST['buscar_iniciales'];
$buscar_protocolo=$_POST['buscar_protocolo'];
$buscar_fecha_desde=$_POST['buscar_fecha_desde'];
$buscar_fecha_hasta=$_POST['buscar_fecha_hasta'];
$id_pac_borrar=filter_var($_REQUEST['id_pac_borrar'], FILTER_SANITIZE_NUMBER_INT);
$v=filter_var($_REQUEST['v'], FILTER_SANITIZE_NUMBER_INT);
$_SESSION['pagina_volver']="protocolos.php";
$pagina=filter_var($_REQUEST['pagina'], FILTER_SANITIZE_NUMBER_INT);
if($v!=1){
	/*guardar parametros búsqueda*/
	$_SESSION['buscar_protocolo']=$buscar_protocolo;
	$_SESSION['buscar_hc']=$buscar_hc;
	$_SESSION['buscar_paciente']=$buscar_paciente;
	$_SESSION['buscar_iniciales']=$buscar_iniciales;
	$_SESSION['buscar_fecha_desde']=$buscar_fecha_desde;
	$_SESSION['buscar_fecha_hasta']=$buscar_fecha_hasta;
	/*guardar parametros búsqueda*/
} else {
	/*setear parametros búsqueda*/
	$buscar_protocolo=$_SESSION['buscar_protocolo'];
	$buscar_hc=$_SESSION['buscar_hc'];
	$buscar_paciente=$_SESSION['buscar_paciente'];
	$buscar_iniciales=$_SESSION['buscar_iniciales'];
	$buscar_fecha_desde=$_SESSION['buscar_fecha_desde'];
	$buscar_fecha_hasta=$_SESSION['buscar_fecha_hasta'];
	$pagina=$_SESSION['pagina_protocolo'];
	/*setear parametros búsqueda*/
}

//se hace paginado
if(empty($pagina)) $pagina = 1;
if(empty($tamanioPagina)) $tamanioPagina = TAMANIO_PAGINA_FRONT;
$inicio = ($pagina - 1) * $tamanioPagina;

$rPac=cPaciente::obtener($inicio, $tamanioPagina, $buscar_paciente, $buscar_protocolo, $buscar_hc, $buscar_iniciales, $buscar_fecha_desde,$buscar_fecha_hasta, $cantResultados, $cantPaginas, "pac_id", "DESC","");

?>
<!DOCTYPE html>
<html lang="en">
    <head>

<?php include_once("includes/head.php");?>
<script language="javascript" charset="utf-8">
	function validarFormulario(varDest, varMenu){
		varError=0;
		document.datos.dest.value=varDest;
		document.datos.menu.value=varMenu;
		document.datos.errorVar.value=varError;
		document.datos.action=varDest;
		document.datos.submit();
	}
	
	function verPaciente(varPacId){
		document.datos.action="formulario_paciente.php";
		document.datos.dest.value="pacientes.php";
		document.datos.id.value=varPacId;
		document.datos.submit();
	}
	
	function eliminarPac(varPacId){
		if(confirm("Está a punto de eliminar el paciente.\nNo podrá ser recuperado\n¿Está seguro?")){
			document.datos.id_pac_borrar.value=varPacId;
			document.datos.accion.value="ELIMINAR";
			document.datos.submit();
		}
	}
	$(document).ready(function() {
		$('#buscar_fecha_desde').datepicker({ dateFormat: 'yy-mm-dd' });
		$('#buscar_fecha_hasta').datepicker({ dateFormat: 'yy-mm-dd' });
	});
</script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
    <body>
		<?php include_once("modal.php");?>
	    <form name="datos" method="post">
        <input type="hidden" name="accion" />
        <input type="hidden" name="id" value="" />
        <input type="hidden" name="errorVar" />
        <input type="hidden" name="dest" />
        <input type="hidden" name="id_pac_borrar" />
        <input type="hidden" name="menu" />
        <input type="hidden" name="pagina" />
		<?php include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Pacientes</h2>
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
                            	<a name="productos"></a>
                                <h3 class="subtitulo_generico"><?=$titulo_pagina?></h3>

                                <div class="linea_sky"></div>
                                <div class="form-inline">
                                      <div class="form-group mr-15">
                                        <label>Protocolo</label>
			                            <?php armarCombo(cProtocolo::obtenerCombo(), "buscar_protocolo", "form-control", " id=\"buscar_protocolo\"", $buscar_protocolo, "[Todos]");?>
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>Nro. HC</label>
                                        <input type="text" name="buscar_hc" id="buscar_hc" class="form-control" value="<?=$buscar_hc?>" placeholder="Nro. HC">
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>Nombre y / o Apellido</label>
                                        <input type="text" name="buscar_paciente" id="buscar_paciente" class="form-control" value="<?=$buscar_paciente?>" placeholder="Nombre y / o Apellido">
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>Iniciales</label>
                                        <input type="text" name="buscar_iniciales" id="buscar_iniciales" class="form-control" value="<?=$buscar_iniciales?>" placeholder="Iniciales">
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>*Fecha desde</label>
                                        <input type="text" readonly="readonly" size="20" id="buscar_fecha_desde" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="buscar_fecha_desde" class="form-control" value="<?=$buscar_fecha_desde?>">&nbsp;<input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.buscar_fecha_desde.value = '';">
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>Fecha hasta</label>
                                        <input type="text" readonly="readonly" size="20" id="buscar_fecha_hasta" style="z-index:100;position:relative;max-width:99%;background-color:#FFFFFF" name="buscar_fecha_hasta" class="form-control" value="<?=$buscar_fecha_hasta?>">&nbsp;<input type="button" class="borrar-fecha form-control" value="X" onClick="this.form.buscar_fecha_hasta.value = '';">
                                       </div>
                                    <button type="button" class="btn boton-generico-left btn-primary" onClick="buscar()">Buscar</button>&nbsp;<button type="button" class="btn boton-generico-left btn-primary" onClick="document.location='pacientes.php'">Limpiar</button>
                                </div>
                                <div class="row">
                                	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<?php if($rPac->cantidad()>0){
                                            ShowPager($cantPaginas, $pagina);
                                        }?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                      <div class="table-responsive">          
                                      <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th>HC.</th>
                                            <th>Paciente</th>
                                            <th>Iniciales</th>
                                            <th>Fecha Ingreso</th>   
                                            <th>Protocolos</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($rPac->cantidad()>0){
                                                for($i=0;$i<$rPac->cantidad();$i++){
												?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verPaciente('<?=$rPac->campo('pac_id',$i)?>')"><?=$rPac->campo('pac_id',$i)?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verPaciente('<?=$rPac->campo('pac_id',$i)?>')"><?=strtoupper($rPac->campo('pac_apellido',$i).(strlen($rPac->campo('pac_segundo_apellido',$i))>0 ? ' '.$rPac->campo('pac_segundo_apellido',$i) : "")).', '.ucfirst($rPac->campo('pac_nombre',$i))?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rPac->campo('pac_iniciales',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=convertirFechaHora($rPac->campo('pac_fecha_ingreso',$i))?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rPac->campo('protocolos',$i)?></p></td>
                                                  </tr>
                                             <?php }//end for
                                            } else {?>
                                                  <tr>
                                                    <td colspan="11">No se encontraron pacientes</td>
                                                  </tr>
                                            <?php }//end if?>
                                        </tbody>
                                      </table>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<?php if($rPac->cantidad()>0){
                                            ShowPager($cantPaginas, $pagina);
                                        }?>
                                    </div>
                                </div>
								<? if($permisoCargarPacientes){?>
                                <div class="row">
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button type="button" class="btn boton-generico btn-primary" title="Nuevo Paciente" data-toggle="tooltip" onClick="document.location='formulario_paciente.php'">Nuevo Paciente</button>
                                    </div>
                                </div>
                                <? }?>
                            </div>
                    	</div>
                        </div>

                    </div>
                    </div>
            </div>
        </section>
        <?php include_once("indexf.php");?>
    	</form>
    </body>
</html>
<?php cDB::cerrar($conexion);?>
