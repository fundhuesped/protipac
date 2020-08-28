<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cTipoEstudio
{
	static function obtenerCombo($vecStatus){
		$sql="SELECT tes_id, tes_descripcion FROM tipo_estudio WHERE tes_status IN (".implode(",",$vecStatus).") ORDER BY tes_descripcion";
		return cComando::consultar($sql);
	}
}
?>