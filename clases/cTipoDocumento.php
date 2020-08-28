<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cTipoDocumento
{
	static function obtenerCombo($vecStatus){
		$sql="SELECT tid_id, tid_descripcion FROM tipo_documento WHERE tid_status IN (".implode(",",$vecStatus).") ORDER BY tid_descripcion";
		return cComando::consultar($sql);
	}
}
?>