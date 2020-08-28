<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cHospital
{
	static function obtenerCombo(){
		$sql="SELECT reh_id, reh_descripcion FROM hospital_referente ORDER BY reh_descripcion";
		return cComando::consultar($sql);
	}

	static function insertarHospital($descripcion, $estado_hospital)
	{
		$sql = "SELECT reh_id FROM hospital_referente WHERE reh_descripcion = '$descripcion'";
		$rDatos = cComando::consultar($sql);
		if($rDatos->cantidad() > 0){
			return $rDatos->campo('reh_id',0);
		}
		
		$sql="INSERT INTO hospital_referente (reh_descripcion,reh_status) VALUES ('".addslashes($descripcion)."', '".addslashes($estado_hospital)."')";
		$status = cComando::ejecutar($sql, INSERT, $id_reh);
		if($status==FALSE){
			return -1;
		}
		return $id_reh;
	}
}
?>