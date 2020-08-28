<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cTipoVisita
{
	static function obtenerCombo($tiv_id){
		$sql="SELECT tiv_id, tiv_descripcion FROM tipo_visita";
		if(count($tiv_id)>0){
			$sql.=" WHERE tiv_id IN (".implode(",",$tiv_id).")";
		}
		return cComando::consultar($sql);
	}
}
?>