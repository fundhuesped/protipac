<? include_once "includes/config.php";
incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);
$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);


$tabla = $_REQUEST['tabla'];
$campo = $_REQUEST['campo'];
$valor = $_REQUEST['valor'];
$valorIgual = $_REQUEST['valorIgual'];
$campoIgual = $_REQUEST['campoIgual'];
$valorDistinto = $_REQUEST['valorDistinto'];
$campoDistinto = $_REQUEST['campoDistinto'];
$usuario_nuevo = $_REQUEST['usuario_nuevo'];

echo(verificarCodigoTabla($tabla, $campo, $valor, $campoIgual, $valorIgual, $campoDistinto, $valorDistinto));
cDB::cerrar($conexion);?>