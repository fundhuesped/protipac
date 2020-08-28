<?
error_reporting(E_ALL);
ini_set("display_errors","off");
header('Content-Type: text/html; charset=utf-8'); 
ini_set("pcre.backtrack_limit", 300000); //se cambia para permitir convertir PDF más largo 

$zona="Etc/GMT+3";//zona horaria buenos aires
date_default_timezone_set($zona);

define('APIGOOGLEMAPS', '');
define("_RAIZ_ID", "1");
define("_RAIZ", "0001");
define("MAX_JERARQUIAS", 20);
define("URL_REWRITING", 0);
define("CAPTCHA","6LeGWCQTAAAAAIUNLahbmXfnuYMWRQUMDvtQxCGI");
define("CAPTCHA_PRIVADO","6LeGWCQTAAAAAJid6WYDVus9KZlGRHFs7hAPD4fG");

//estados
define("ST_ACTIVO", "1");
define("ST_BLOQUEADO", "2");
define("ST_PENDIENTE", "3");
define("ST_MODIFICADO", "4");
define("ST_DERIVADO", "18");
define("ST_DIAGNOSTICADO", "19");
define("ST_NO_APLICA", "20");
define("ST_VISTO", "21");
define("ST_BLOQUEADO_EDICION", "5");
define("ST_CANCELADO_USUARIO", "6");
define("ST_NO_CONFIRMADO", "7");
define("ST_AST_CHILD", "8");
define("ST_CERRADO", "9");
define("ST_SUPERVISADO", "10");
define("ST_IMPRESO", "11");
define("ST_HISTORICO", "12");
define("ST_ELIMINAR", "14");
define("ST_ANULADO", "15");
define("ST_INCOMPLETO", "16");
define("ST_SOL_INICIADO", "1");
define("ST_SOL_RESUELTO", "4");
define("ST_SOL_REABIERTO", "5");


//estados proyectos
define("ST_ENVIADO", "1");
define("ST_RECHAZADO", "2");
define("ST_BORRADOR", "3");
define("ST_PROCESO", "4");
define("ST_APROBADO", "5");
define("ST_REABIERTO", "6");


//perfil por defecto
define("PERFIL_DEFECTO", "2");
define("PERFIL_SAME", "2");
define("PERFIL_CAPS", "3");
define("PERFIL_UPA", "4");
define("PERFIL_PUEBLO", "5");
define("PERFIL_HEC", "6");
define("PERFIL_ADMIN", "1");

//Efectores
define("EFE_SAME","14");
define("EFE_HEC","2");
define("EFE_UPA","3");
define("EFE_PUEBLO","1");




//estado por defecto para usuarios
define("ST_DEFECTO", "7");

//los usuarios pendientes pueden loguearse 1=si 0=no
define("BLOQUEAR_LOGIN_PENDIENTES", 1);

//los usuarios pendientes pueden leer 1=si 0=no
define("BLOQUEAR_PENDIENTES_LEER", 0);

//los usuarios pendientes pueden escribir 1=si 0=no
define("BLOQUEAR_PENDIENTES_ESCRIBIR", 0);

//contenidos pendientes no pueden leerse 1=si se leen, 0=no se leen (solo podrán leerlos los administradores)
define("PUBLICAR_CONT_PEND", 1);

//tipos permisos (fnc_type)
define("READ", 1);
define("WRITE", 2);


//cantidad máxima de adjuntos a colocar por producto
define("MAX_ADJ", 1);

//cantidad máxima de adjuntos a colocar en backend
define("MAX_ADJ_BACK", 5);

//cantidad máxima de imágenes a colocar
define("MAX_IMG", 10);

//cantidad máxima de links a colocar
define("MAX_LNK", 10);


//tipos documento coincidentes con la base de datos (tipo_link)
define("IMGDOC", 1);
define("ATTACHDOC", 2);
define("LINKDOC", 3);

//tipos adjuntos (tipo_adjunto)
define("ADJ_OTRO", 14);


//Tipos de Asset
define('USUARIO', '1');
define('COMENTARIO', '3');
//define('ADJUNTO', '4');
define('ENTIDAD', '9');

//Tipos de Investigación en cuanto a drogas
define('TIPO_CON_DROGAS', '1');
define('TIPO_SIN_DROGAS', '2');

//Tipos proyecto segun financiamiento
define('TIPO_FINANCIADO', '1');
define('TIPO_NO_FINANCIADO', '0');

define('TIPO_SPONSOR', '1');
define('TIPO_NO_SPONSOR', '0');

define('TIPO_CRO', '1');
define('TIPO_NO_CRO', '0');

define('TIPO_INDUSTRIA', '1');
define('TIPO_NO_INDUSTRIA', '0');

define('RUTA_BASE','');
//RUTA_BASE, colocar '' si se instala en directorio virtual por ejemplo http://localhost/huesped o '/' si se instala con dominio

//valores preferencias
define('PRE_TOPIC_MAIL_DIGEST_WEEKLY', '1');
define('PRE_TOPIC_MAIL_DIGEST_DAILY', '3');
define('PRE_TOPIC_MAIL_SINGLE', '2');



//idiomas
define('ENG', 1);
define('SPA', 2);
if($_REQUEST['accion']=="LOGIN"){
	ini_set("session.gc_maxlifetime", "315360000");
	ini_set("session.cookie_lifetime", "31536000");

}

	session_start();
	switch(	$_SERVER["HTTP_HOST"] )
	{

			case "localhost":
					define('HOSTNAME', 'localhost');
					define('URL', 'http://localhost/huesped');
					define('USER', 'root');
					define('PASS', '');
					define('DB', 'protipac_db');
					define('_PATH_ROOT_DIR_CANT_BARRAS', 1);
					break;

			case "protipac.kcinteractiva.com":
					define('HOSTNAME', 'localhost');
					define('URL', 'http://protipac.kcinteractiva.com');
					define('USER', 'protipac_db');
					define('PASS', '');
					define('DB', 'protipac_db');
					define('_PATH_ROOT_DIR_CANT_BARRAS', 0);
					break;						
		default:
			die("Host no definido");
	}

	define('ID_IDIOMA', '2');
	$_SESSION['lang'] = "spa";



			
	//path para imágenes temporales
	define('imagenestemp', 'adjuntosUsuariosTemp');
	
	//path para imágenes definitivas
	define('imagenesUser', 'adjuntosUsuarios');

	//path para adjuntos proyectos
	define('imagenesProyecto', 'adjuntosProyectos');

	//path para documentos
	define('DOCCOMENTARIOS', 'adjuntosBack');	

	//Dirección WEB completa
	define('WEB', 'http://protipac.kcinteractiva.com/');
	
	//path sitio
	define('PATH', 'd:\\xampp\\htdocs\\huesped\\');
	
	//peso máximo imágen
	define('SIZEIMAGEN', 5242880);	

	//ancho máximo imágen grande
	define('ANCHOIMG', 1024);
	
	//alto máximo imágen grande
	define('ALTOIMG', 1024);

	//ancho máximo imágen thumbnail
	define('ANCHOTHUMB', 250);

	//alto máximo imágen thumbnail
	define('ALTOTHUMB', 250);

	//Limites Defecto
	define('LIMITE_FAVORITOS', 60);

	//Mailer
	define('MAILER', 'localhost');
	define('_MAIL_PORT', 25);
	//define('_MAIL_SECURE','');
	define('_MAIL_FROM', 'no-responder@protipac');
	define('_MAIL_AUTH', true);
	define('_MAIL_USER', 'no-responder@protipac');
	define('_MAIL_PASS', 'elpass');
	define('DEBUG_SQL', false);
	define('INSERT', 0);
	define('UPDATE', 1);
	define('DELETE', 2);
	define('CREATE', 3);
	define('DROP', 4);

	
	//Nombre Sitio
	define('SITIO', 'Protipac v2');
	define('TITULO', 'Protipac v2');
	define('TITULO_PRIVADO', 'Protipac v2');


	define('NOMBRE_WEBMASTER', 'Protipac v2');
	define('LINK_ACTIVACION', URL."activate.php");
	define('HEADER_DEFECTO', URL."indexh.htm");
	define('LINK_LOGIN', URL.'/index.php');


	define('BARRA', '/');
	define('TAMANIO_PAGINA', 25);
	define('TAMANIO_PAGINA_FRONT', 25);
	define('TAMANIO_MOSTRAR_PAGINADOR', 10);
	#Emails
	define('_REMITENTE','Protipac');
	define('_EMAIL_REMITENTE','webmaster@protipac');


	if(!function_exists("incluir"))
	{
		function incluir($archivo, $ruta="")
		{
			if (strlen($ruta))
			{
				$cantBarras = substr_count($ruta, '/');
				$path = str_repeat('../', $cantBarras - 1 - _PATH_ROOT_DIR_CANT_BARRAS);
				include_once($path.$archivo);
			}
			else{
				include_once($archivo);
			}
		}
	}
	
	incluir('clases/cUsuario.php', $_SERVER['SCRIPT_NAME']);
	incluir('includes/biblio.php', $_SERVER['SCRIPT_NAME']);
	incluir('includes/lang/' . $_SESSION['lang'] . '.php', $_SERVER['SCRIPT_NAME']);
	incluir('includes/lang/url_' . $_SESSION['lang'] . '.php', $_SERVER['SCRIPT_NAME']);
//$conexion=cDB::conectar( HOSTNAME, USER, PASS, DB);
	if(empty($_SESSION['id_usu']) || strlen($_SESSION['id_usu'])<=0){
		//seteo usuario anónimo
		$_SESSION['id_usu']=-1;
		$_SESSION['usr_emp_id']=-1;
		$_SESSION['usr_ent_id']=-1;
		$_SESSION['usr_inv_id']=-1;
	}

$arrFechaEng = array('January','February','March','April','May','June','July','August','September','October','November','December','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
$arrFechaEsp = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');
$vecMes = array('', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
$vecDias=array('', 'Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');
?>