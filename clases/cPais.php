<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cPais
{

	static function obtenerCombo()
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM pais ORDER BY nombre_pais";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	
	static function obtenerComboLocalidad($tabla, $id_tabla, $con, $valor)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT ".$id_tabla.", nombre_".$tabla." FROM ".$tabla." WHERE ".$con."=".$valor." ORDER BY nombre_".$tabla;
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}

	static function obtenerPorId($id_pais)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM pais WHERE id_pais = $id_pais";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function obtenerProvinciaPorId($id_provincia)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM provincia WHERE id_provincia = $id_provincia";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	
	static function obtenerLocalidadPorId($id_localidad)
	{
		//cDB::conectar( HOSTNAME, USER, PASS, DB);
		$sql = "SELECT * FROM localidad WHERE id_localidad = $id_localidad";
		$rDatos = cComando::consultar($sql);
		//cDB::cerrar();
		return $rDatos;
	}
	static function obtenerPorProducto($emp_id, $epr_prod_id){
		$sql="SELECT IFNULL(eprpai_pai_id, eprpai_otro) id, IFNULL(nombre_pais, eprpai_otro) descripcion FROM empresa_producto_pais LEFT JOIN pais ON (eprpai_pai_id=id_pais) WHERE eprpai_emp_id='$emp_id' AND eprpai_epr_prod_id='$epr_prod_id' ORDER BY eprpai_nro";
		return cComando::consultar($sql);
	}
	static function obtenerProvinciaPorDescripcion($nombre_provincia){
		$sql = "SELECT id_provincia, id_pais, nombre_provincia FROM provincia WHERE nombre_provincia LIKE '%".$nombre_provincia."%'";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
	static function obtenerLocalidadPorDescripcion($nombre_localidad,$id_provincia){
		$sql = "SELECT id_localidad, id_provincia, nombre_localidad FROM localidad WHERE nombre_localidad LIKE '%".$nombre_localidad."%' AND id_provincia='$id_provincia'";
		$rDatos = cComando::consultar($sql);
		return $rDatos;
	}
}

?>