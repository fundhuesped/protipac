<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cFase
{
	static function obtenerCombo(){
		$sql="SELECT fase_id, fase_descripcion FROM fase_investigacion ORDER BY fase_descripcion";
		return cComando::consultar($sql);
	}
}
?>