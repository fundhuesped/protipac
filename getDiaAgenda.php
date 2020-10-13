<?php
include_once 'includes/config.php';
//ini_set("display_errors","On");
//error_reporting(E_ALL);
include_once 'clases/cPaciente.php';
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);

$permisoListarAgenda=seguridadFuncion("LISTAGENDA");
if(!$permisoListarAgenda){
	cDB::cerrar($conexion);
	echo("<tr><td colspan=\"5\">No tiene permiso</td></tr>");
	exit();
}

$formulario="agenda";


$accion=$_POST['accion'];
$fecha_buscar=$_POST['fecha_buscar'];
$buscar_medico=filter_var($_POST['buscar_medico'], FILTER_SANITIZE_NUMBER_INT);
$buscar_protocolo=filter_var($_POST['buscar_protocolo'], FILTER_SANITIZE_NUMBER_INT);
$dia_buscar=filter_var($_POST['dia_buscar'], FILTER_SANITIZE_NUMBER_INT);
if(!validateDate($fecha_buscar, 'Y-m-d')){
	cDB::cerrar($conexion);
	echo("<tr><td colspan=\"5\">Fecha inválida</td></tr>");
	exit();
}
$_SESSION['fecha_buscar']=$fecha_buscar;

if($dia_buscar==2){
	//calcular día 2
	$fecha_buscar2 = date('Y-m-d', strtotime($fecha_buscar . " + 1 day"));
	$fecha_test = strtotime($fecha_buscar2);
	$fecha_buscar=$fecha_buscar2;
	if(date('w', $fecha_test)==6) {
		//es Sábado
		$fecha_buscar = date('Y-m-d', strtotime($fecha_buscar2 . " + 2 day"));
	}
	if(date('w', $fecha_test)==0) {
		//es Domingo
		$fecha_buscar = date('Y-m-d', strtotime($fecha_buscar2 . " + 1 day"));
	}
}
if($dia_buscar==3){
	//calcular primero día 2
	$fecha_buscar2 = date('Y-m-d', strtotime($fecha_buscar . " + 1 day"));
	$fecha_test = strtotime($fecha_buscar2);
	$fecha_buscar=$fecha_buscar2;
	if(date('w', $fecha_test)==6) {
		//es Sábado
		$fecha_buscar = date('Y-m-d', strtotime($fecha_buscar2 . " + 2 day"));
	}
	if(date('w', $fecha_test)==0) {
		//es Domingo
		$fecha_buscar = date('Y-m-d', strtotime($fecha_buscar2 . " + 1 day"));
	}
	//calcular primero día 2

	//calcular día 3
	$fecha_buscar2 = date('Y-m-d', strtotime($fecha_buscar . " + 1 day"));
	$fecha_buscar=$fecha_buscar2;
	$fecha_test = strtotime($fecha_buscar2);
	if(date('w', $fecha_test)==6) {
		//es Sábado
		$fecha_buscar = date('Y-m-d', strtotime($fecha_buscar2 . " + 2 day"));
	}
	if(date('w', $fecha_test)==0) {
		//es Domingo
		$fecha_buscar = date('Y-m-d', strtotime($fecha_buscar2 . " + 1 day"));
	}	
}
   $fecha_mostrar=$fecha_buscar;
   $fecha_mostrar = strtotime($fecha_mostrar);
   $ano = date('Y',$fecha_mostrar);
   $mes = date('n',$fecha_mostrar);
   $dia = date('d',$fecha_mostrar);
   $diasemana = date('w',$fecha_mostrar);
   $fecha_mostrar=$vecDias[$diasemana+1].", $dia de ". $vecMes[$mes] ." de $ano";

$strContent='
<table class="">
  <tr>
	<td colspan="5"><em>'.$fecha_mostrar.'</em></td>
  </tr>
</table>
<table class="table table-hover">
<thead>
  <tr>
	<th>Inicio</th>
	<th>HC</th>
	<th>Iniciales</th>   
	<th>Médico</th>
	<th>Protocolo</th>
  </tr>
</thead>
<tbody>';
$rVis=cPaciente::obtenerVisitasPacienteCalendario("provis_hora_agenda", "ASC",$buscar_protocolo,$buscar_medico,$fecha_buscar,$fecha_buscar, "");

if($rVis->cantidad()>0){
	for($i=0;$i<$rVis->cantidad();$i++){
	  $strContent.='<tr>
		<td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita(\''.$rVis->campo('provis_id',$i).'\',\''.$rVis->campo('provis_pro_id',$i).'\')">'.(is_null($rVis->campo('provis_hora_agenda',$i)) ? "A programar" : substr($rVis->campo('provis_hora_agenda',$i),0,5)).'</a></p></td>
		<td><p class="texto-publicacion letra-gris-oscuro"><a href="javascript:verVisita(\''.$rVis->campo('provis_id',$i).'\',\''.$rVis->campo('provis_pro_id',$i).'\')">'.$rVis->campo('provis_pac_id',$i).'</a></p></td>
		<td><p class="texto-publicacion letra-gris-oscuro">'.addslashes($rVis->campo('pac_iniciales',$i)).'</p></td>
		<td><p class="texto-publicacion letra-gris-oscuro">'.addslashes(strtoupper($rVis->campo('med_apellido',$i)).', '.ucfirst($rVis->campo('med_nombre',$i))).'</p></td>
		<td><p class="texto-publicacion letra-gris-oscuro">'.addslashes($rVis->campo('pro_codigo_estudio',$i)).'</p></td>
	  </tr>';
	}//end for
} else {
	  $strContent.='<tr>
		<td colspan="5">No hay visitas
	  </tr>';
}//end if
$strContent.='
</tbody>
</table>';
echo($strContent);
cDB::cerrar($conexion);
?>
