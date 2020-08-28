<?

incluir('clases/cDB.php', $_SERVER['SCRIPT_NAME']);

class cTipoInvestigacionExp
{
	static function obtenerCombo(){
		$sql="SELECT tex_id, tex_descripcion FROM tipo_investigacion_experimental ORDER BY tex_descripcion";
		return cComando::consultar($sql);
	}
}
?>