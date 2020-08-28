<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cEstadoVisita
{
	static function obtenerCombo($sv_id){
		$sql="SELECT sv_id, sv_descripcion FROM status_visita";
		if(count($sv_id)>0){
			$sql.=" WHERE sv_id IN (".implode(",",$sv_id).")";
		}
		$sql.=" ORDER BY sv_descripcion";
		return cComando::consultar($sql);
	}
}
?>