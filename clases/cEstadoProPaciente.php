<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cEstadoProPaciente
{
	static function obtenerCombo($status){
		$sql="SELECT spp_id, spp_descripcion, spp_status, spp_texto_comentario,spp_estilo FROM status_protocolo_paciente WHERE spp_status=".$status." ORDER BY spp_orden";
		return cComando::consultar($sql);
	}
}
?>