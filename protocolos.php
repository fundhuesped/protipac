<?php
include_once 'includes/config.php';
//ini_set("display_errors","On");
//error_reporting(E_ALL);
include_once 'clases/cProtocolo.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);

$permisoListarProtocolos=seguridadFuncion("LISTPROTOCOLOS");
if(!$permisoListarProtocolos){
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
$formulario="protocolos";
if($perfilInvestigador){
	$completo=cFormulario::getEstadoFormulario($_SESSION['usr_ent_id'],$_SESSION['usr_ent_type']);
	$permisoEnviar=true;
} else {
	$completo=true;
}
if($perfilEmpresa && !$perfilInvestigador){
	$permisoEnviar=false;
}


$accion=$_POST['accion'];
$buscar_protocolo=$_POST['buscar_protocolo'];
$buscar_ref=$_POST['buscar_ref'];
$estado_protocolo=array(ST_PRO_ABIERTO,ST_PRO_ENROLANDO,ST_PRO_FUTURO,ST_PRO_FINALIZADO,ST_PRO_SIN_ASIGNAR,ST_PRO_SUSPENDIDO);
$titulo_pagina="Listado de protocolos de investigación";
$buscar_inv=$_POST['buscar_inv'];
$buscar_emp=$_POST['buscar_emp'];
$buscar_id=$_POST['buscar_id'];
$buscar_estado=$_POST['buscar_estado'];
$v=filter_var($_REQUEST['v'], FILTER_SANITIZE_NUMBER_INT);
$_SESSION['pagina_volver']="protocolos.php";
$pagina=filter_var($_REQUEST['pagina'], FILTER_SANITIZE_NUMBER_INT);
if($v!=1){
	/*guardar parametros búsqueda*/
	$_SESSION['buscar_protocolo']=$buscar_protocolo;
	$_SESSION['buscar_inv']=$buscar_inv;
	$_SESSION['buscar_emp']=$buscar_emp;
	$_SESSION['buscar_ref']=$buscar_ref;
	$_SESSION['buscar_estado']=$buscar_estado;
	$_SESSION['buscar_id']=$buscar_id;
	$_SESSION['pagina_protocolo']=$pagina;
	/*guardar parametros búsqueda*/
} else {
	/*setear parametros búsqueda*/
	$buscar_protocolo=$_SESSION['buscar_protocolo'];
	$buscar_inv=$_SESSION['buscar_inv'];
	$buscar_emp=$_SESSION['buscar_emp'];
	$buscar_ref=$_SESSION['buscar_ref'];
	$buscar_estado=$_SESSION['buscar_estado'];
	$buscar_id=$_SESSION['buscar_id'];
	$pagina=$_SESSION['pagina_protocolo'];
	/*setear parametros búsqueda*/
}

//se hace paginado
if(empty($pagina)) $pagina = 1;
if(empty($tamanioPagina)) $tamanioPagina = TAMANIO_PAGINA_FRONT;
$inicio = ($pagina - 1) * $tamanioPagina;

$vecEstado=array();
if(!empty($buscar_estado)){
	if(!is_array($buscar_estado)){
		array_push($vecEstado,$buscar_estado);
	} else {
		for($i=0;$i<count($buscar_estado);$i++){
			if(in_array($buscar_estado[$i],$estado_protocolo)){
				array_push($vecEstado,$buscar_estado[$i]);
			}
		}
	}
} else {
	$vecEstado=$estado_protocolo;
}





$estado_asset=array(ST_ACTIVO);

/*if($accion=="ENVIAR" && ($perfilInvestigador || $perfilEmpresa)){
	if(!empty($id)){
		cProtocolo::cambiarEstadoProyecto($_SESSION['id_usu'],date("Y-m-d H:i:s"),$id,ST_ENVIADO,"");
	}
}
if($accion=="ELIMINAR" && !empty($id_pro_borrar)){
	$rPro=cProtocolo::obtenerProtocolo($id_pro_borrar,"");
	if($rPro->cantidad()>0){
		if($rPro->campo('pro_status',0)==ST_BORRADOR && $rPro->campo('proinv_inv_id',0)==$investigador_id){
			//solo borrar si está en estado borrador y el investigador es quien está solicitandolo
			cProtocolo::eliminarProyecto($id_pro_borrar);
		}
	}
}
*/

$rPro=cProtocolo::obtener($inicio, $tamanioPagina, $buscar_protocolo, $vecEstado,  $cantResultados, $cantPaginas, $buscar_inv, $buscar_emp, "pro_id", "DESC", $buscar_ref,$buscar_id,$estado_asset);


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
	
	function verPro(varProId){
		document.datos.action="formulario_protocolo.php";
		document.datos.dest.value="protocolos.php";
		document.datos.id.value=varProId;
		document.datos.submit();
	}


	$(document).ready(function() {
		$.fn.select2.defaults.set("theme", "bootstrap");
		$('#buscar_emp').select2();
		$('#buscar_inv').select2();
		$('#buscar_com').select2();
		$('#buscar_cen').select2();
		$('#buscar_est').select2({width:350});
		
		<? if(!$perfilEmpresa){?>
		$('select[name=buscar_fin]').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?=TIPO_FINANCIADO?>:
					$("#capa_entidad_financiador").show();
					$("#capa_tipo_financiador").show();
				break;
				case <?=TIPO_NO_FINANCIADO?>:
					$("#capa_entidad_financiador").hide();
					$("#capa_tipo_financiador").hide();
					$("#buscar_emp").val("");
					$("#buscar_temp").val("");
				break;
				default:
					$("#capa_entidad_financiador").hide();
					$("#capa_tipo_financiador").hide();
					$("#buscar_emp").val("");
					$("#buscar_temp").val("");
				break;
			}
		});
		switch(parseInt($('select[name=buscar_fin]').val(),10)){
			case <?=TIPO_FINANCIADO?>:
				$("#capa_entidad_financiador").show();
				$("#capa_tipo_financiador").show();
			break;
			case <?=TIPO_NO_FINANCIADO?>:
				$("#capa_entidad_financiador").hide();
				$("#capa_tipo_financiador").hide();
				$("#buscar_emp").val("");
				$("#buscar_temp").val("");
			break;
			default:
				$("#capa_entidad_financiador").hide();
				$("#capa_tipo_financiador").hide();
				$("#buscar_emp").val("");
				$("#buscar_temp").val("");
			break;
		}
		<? }?>
		$('select[name=buscar_tex]').change(function() {
			switch(parseInt($(this).val(),10)){
				case <?=TIPO_CON_DROGAS?>:
					$("#capa_fase").show();
					$("#capa_placebo").show();
				break;
				case <?=TIPO_SIN_DROGAS?>:
					$("#capa_fase").hide();
					$("#capa_placebo").hide();
					$("#buscar_pla").val("");
					$("#buscar_fase").val("");
				break;
				default:
					$("#capa_fase").hide();
					$("#capa_placebo").hide();
					$("#buscar_pla").val("");
					$("#buscar_fase").val("");
				break;

			}
		});

		switch(parseInt($('select[name=buscar_tex]').val(),10)){
			case <?=TIPO_CON_DROGAS?>:
				$("#capa_fase").show();
				$("#capa_placebo").show();
			break;
			case <?=TIPO_SIN_DROGAS?>:
				$("#capa_fase").hide();
				$("#capa_placebo").hide();
				$("#buscar_pla").val("");
				$("#buscar_fase").val("");

			break;
			default:
				$("#capa_fase").hide();
				$("#capa_placebo").hide();
				$("#buscar_pla").val("");
				$("#buscar_fase").val("");
			break;
		}

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
        <input type="hidden" name="pagina" />
		<? include_once("indexh.php");?>
        <section class="breadcrumb-sky">
            <div class="container">
                <div class="header-section col-md-10 col-lg-10 col-sm-6 col-xs-6">
                    <h2>Protocolos de investigación</h2>
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
                                        <label>Nombre Ref.</label>
                                        <input type="text" name="buscar_ref" id="buscar_ref" class="form-control" value="<?=$buscar_ref?>" placeholder="Ref.">
                                      </div>
                                      <div class="form-group mr-15">
                                        <label>Protocolo</label>
                                        <input type="text" name="buscar_protocolo" id="buscar_protocolo" class="form-control" value="<?=$buscar_protocolo?>" placeholder="Título breve">
                                      </div>
                                    <div class="form-group mr-15">
                                       <label>Estado</label>
			                            <? armarCombo(cProtocolo::obtenerComboStatus(), "buscar_estado", "form-control", " id=\"estado_protocolo\"", $buscar_estado, "[Todos]");?>
                                    </div>

                                    <button type="button" class="btn boton-generico-left btn-primary" onClick="buscar()">Buscar</button>&nbsp;<button type="button" class="btn boton-generico-left btn-primary" onClick="document.location='protocolos.php'">Limpiar</button>
                                </div>
                                <div class="row">
                                	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<? /*if($rPro->cantidad()>0){
                                            ShowPager($cantPaginas, $pagina);
                                        }*/?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                      <div class="table-responsive">          
                                      <table class="table table-hover">
                                        <thead>
                                          <tr>
                                            <th>Nombre Ref.</th>
                                            <th>Protocolo</th>
                                            <th>Investigador</th>   
                                            <th>Tipo</th>
                                            <th>Financiador</th>
                                            <th>Estado</th>
                                            <!--<th>
                                            	Ver
                                            </th>
                                            <th>
                                            	Borrar
                                            </th>-->
                                          </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($rPro->cantidad()>0){
                                                for($i=0;$i<$rPro->cantidad();$i++){
												?>
                                                  <tr>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verPro('<?=$rPro->campo('pro_id',$i)?>')"><?=$rPro->campo('pro_codigo_estudio',$i)?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verPro('<?=$rPro->campo('pro_id',$i)?>')"><?=$rPro->campo('pro_titulo_breve',$i)?></a></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=strtoupper($rPro->campo('inv_apellido',$i)).', '.ucfirst($rPro->campo('inv_nombre',$i))?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=$rPro->campo('tes_descripcion',$i)?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro"><?=(is_null($rPro->campo('emp_id',$i)) ? "--" : $rPro->campo('emp_razon_social',$i))?></p></td>
                                                    <td><p class="texto-publicacion letra-gris-oscuro">
                                                    <span class="label <?=$rPro->campo('sp_estilo',$i)?>"><?=$rPro->campo('sp_descripcion',$i)?></span></p></td>

                                                  </tr>
                                             <? }//end for
                                            } else {?>
                                                  <tr>
                                                    <td colspan="11">No se encontraron protocolos</td>
                                                  </tr>
                                            <? }//end if */?>
                                        </tbody>
                                      </table>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
										<? if($rPro->cantidad()>0){
                                            ShowPager($cantPaginas, $pagina);
                                        }?>
                                    </div>
                                </div>
								<? //if($perfilEmpresa || $perfilInvestigador){?>
                                <div class="row">
                                	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <button type="button" class="btn boton-generico btn-primary" title="Nuevo Protocolo" data-toggle="tooltip" onClick="document.location='formulario_protocolo.php'">Nuevo Protocolo</button>
                                    </div>
                                </div>
                                <? //}?>
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
