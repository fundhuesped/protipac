<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cMedico
{
	static function obtenerCombo(){
		$sql="SELECT med_id, CONCAT(med_apellido,', ',med_nombre) FROM medico ORDER BY med_apellido, med_nombre";
		return cComando::consultar($sql);
	}
}
?>