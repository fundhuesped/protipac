<?
	
	incluir('clases/cComando.php', $_SERVER['SCRIPT_NAME']);
	class cDB
	{
		static function conectar( $hostname, $username, $password, $db )
		{
			$connId = @mysqli_connect($hostname, $username, $password) or die( "Estamos realizando tareas de mantenimiento.<br>Por favor intente más tarde" );
			mysqli_set_charset($connId, "utf8");
			@mysqli_select_db($connId,$db) or die( "Estamos realizando tareas de mantenimiento.<br>Por favor intente más tarde" );
			return $connId;
		}

		static function cerrar($connId)
		{
			@mysqli_close($connId);
			return;
		}

	}
?>