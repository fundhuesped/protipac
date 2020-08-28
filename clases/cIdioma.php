<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cIdioma
{
	static function obtenerCombo()
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM language ORDER BY lng_language_name";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	static function obtenerPorId($id_idioma)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT lng_language_name, lng_short FROM language WHERE lng_id=$id_idioma";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function getIdiomaDestino($id_idioma_mostrar, $id_idioma){
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT lng_name FROM language_name WHERE lng_id=$id_idioma AND lng_id_show=$id_idioma_mostrar";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
}

?>