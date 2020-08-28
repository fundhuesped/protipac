<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cSexo
{
	static function obtenerCombo(){
		$sql="SELECT sex_id, sex_descripcion FROM sexo ORDER BY sex_descripcion";
		return cComando::consultar($sql);
	}
}
?>