<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cGenero
{
	static function obtenerCombo(){
		$sql="SELECT gen_id, gen_descripcion FROM genero ORDER BY gen_descripcion";
		return cComando::consultar($sql);
	}
}
?>