<?
incluir('clases/cResultado.php', $_SERVER['SCRIPT_NAME']);


class cComando
{
	static function ejecutar($sql, $tipoSentencia, &$id)
	{
		global $conexion;
		if(DEBUG_SQL)
			echo $sql."<br>";
		mysqli_set_charset($conexion, "utf8");
		$result = mysqli_query($conexion, $sql);
		if($tipoSentencia==INSERT)
			$id = @mysqli_insert_id($conexion);
		return $result;
	}

	static function ejecutarForo($sql, $tipoSentencia, &$id)
	{
		if(DEBUG_SQL)
			echo $sql."<br>";
			$result = mysql_query($sql);
		if($tipoSentencia==INSERT)
			$id = @mysql_insert_id();
		return $result;
	}

	static function consultar($sql)
	{
		global $conexion;

		if(DEBUG_SQL)
			echo $sql."<br>";

		mysqli_set_charset($conexion, "utf8");
		$rs =  mysqli_query($conexion,$sql) or die(mysqli_error($conexion) . "-" . $sql);
		if(mysqli_num_rows($rs) >0)
		{	
		 	$fieldinfo=mysqli_fetch_fields($rs);
			$i=0;
			foreach ($fieldinfo as $val)
			{
				$campos[$val->name] = $i;
				$i++;
			}
			while ($row = mysqli_fetch_row($rs))
				$vec[] = $row;

			mysqli_free_result($rs);
			return new cResultado($campos, $vec);
		}
		return new cResultado();
	}
	
	static function consultarTransactional($sql)
		{
			global $conexion;
			$rs =  mysql_query($sql, $conexion);
			if(mysql_error()){
				return mysql_error();
			} else {
				if(mysql_num_rows($rs) >0)
				{
					for($i=0; $i< mysql_num_fields($rs); $i++)
						$campos[mysql_field_name($rs, $i)] = $i;
		
					while ($row = mysql_fetch_row($rs))
						$vec[] = $row;
		
					mysql_free_result($rs);
					return new cResultado($campos, $vec);
				}
				return new cResultado();
			}
		}


	static function begin() {
	  global $conexion;
	  mysql_query("BEGIN", $conexion);
	}
	
	static function rollback() {
	   global $conexion;
	   mysqli_rollback($conexion);
	}
	
	static function commit() {
	  global $conexion;
	  return mysqli_commit($conexion);
	  
	}
	static function autocommit($valor) {
	  global $conexion;
	  return mysqli_autocommit($conexion,$valor);
	}
}

?>