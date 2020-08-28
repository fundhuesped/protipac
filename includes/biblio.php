<?
	function escape_eol($cadena){
		return addslashes(preg_replace('/[\r\n]+/', "", $cadena));
	}

	
	function completarNumeroIzq($cadena, $cant)
	{
		if(strlen($cadena)<$cant){
			$falta=$cant-strlen($cadena);
			for($i=0;$i<$falta;$i++){
				$cadena="0".$cadena;
			}
		}
		return($cadena);
	}
	
	function cadenaND($cadena){
		echo((strlen($cadena)>0 ? $cadena : "--"));
	}
	
	function showPersona($nombrePersona, $apellidoPersona){
		echo(strtoupper($apellidoPersona).', '.$nombrePersona);
	}
	
	function ape($apellidoPersona){
		return fullUpper($apellidoPersona);
	}
	function nom($nombrePersona){
		return ucwords(mb_strtolower($nombrePersona,'ISO-8859-1'));
	}
	
	function verificarCodigoTabla($tabla, $campo, $valor, $campoIgual, $valorIgual, $campoDistinto, $valorDistinto){
		$sql="SELECT ".addslashes($tabla).".".addslashes($campo)." FROM ".addslashes($tabla)." WHERE ".addslashes($tabla).".".addslashes($campo)."='".addslashes($valor)."'";
		if(!empty($campoIgual) && !empty($valorIgual)){
			$sql.=" AND ".$campoIgual."=".$valorIgual;
		}
		if(!empty($campoDistinto) && !empty($valorDistinto)){
			$sql.=" AND ".$campoDistinto."<>".$valorDistinto;
		}
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			return "1";
		} else {
			return "-1";
		}
	}
	
	function verificarFeriado($fecha){
		$sql="SELECT fer_id FROM feriado WHERE (fer_fecha_desde<='$fecha' AND fer_fecha_hasta>='$fecha')";
		$rDatos=cComando::consultar($sql);
		if($rDatos->cantidad()>0){
			return "1";
		} else {
			return "-1";
		}
	}
	
	
	function ajustarTexto($cadena, $longitud){
		if(strlen($cadena)>$longitud && strlen($cadena)>0){
			return substr($cadena, 0, $longitud)."...";
		} else {
			return $cadena;
		}	
	}


	function ShowPager($cantPaginas, $paginaActual)
	{
		echo '<ul class="pagination">';
		$totalMostrar=TAMANIO_MOSTRAR_PAGINADOR;
        if($paginaActual > 1){
			echo '<li><a href="javascript:ir(1)">&lt;&lt;</a></li><li><a href="javascript:ir('.($paginaActual-1).')">&lt;</a></li>';
			if($paginaActual-1>=$totalMostrar){
				echo '<span class="paginador-mas">...</span>';
			}
		} else {	
			echo '';
		}

		if($paginaActual-$totalMostrar>=1){
			$inicioPag=$paginaActual-round($totalMostrar/2,0);
		} else {
			$inicioPag=1;
		}
		
		
		for($i=$inicioPag; ($i <= $cantPaginas && $i<$inicioPag+$totalMostrar); $i++)
			if ($i==$paginaActual){			
				echo '<li class="active"><a>'.$i.'</a></li>';
			} else {
				echo '<li><a href="javascript:ir('.$i.')">'.$i.'</a></li>';
			}
        if($paginaActual < $cantPaginas){
			if($cantPaginas>$totalMostrar){
				echo '<span class="paginador-mas">...</span>';
			}
			echo '<li><a href="javascript:ir('.($paginaActual+1).')">&gt;</a></li><li><a href="javascript:ir('.$cantPaginas.')">&gt;&gt;</a></li>';
		} else {
			echo '';
		}
		echo '</ul>';
	}
	
	function ShowPagerAdmin($cantPaginas, $paginaActual)
	{
		echo '<ul class="pagination">';
		$totalMostrar=TAMANIO_MOSTRAR_PAGINADOR;
        if($paginaActual > 1){
			echo '<li><a href="javascript:ir(1)" class="page">&lt;&lt;</a></li><li><a href="javascript:ir('.($paginaActual-1).')" class="page">&lt;</a></li>';
			if($paginaActual-1>=$totalMostrar){
				echo '<span class="paginador-mas">...</span>';
			}
		} else {	
			echo '';
		}

		if($paginaActual-$totalMostrar>=1){
			$inicioPag=$paginaActual-round($totalMostrar/2,0);
		} else {
			$inicioPag=1;
		}
		
		
		for($i=$inicioPag; ($i <= $cantPaginas && $i<$inicioPag+$totalMostrar); $i++)
			if ($i==$paginaActual){			
				echo '<li><a class="page active">'.$i.'</a></li>';
			} else {
				echo '<li><a class="page" href="javascript:ir('.$i.')">'.$i.'</a></li>';
			}
        if($paginaActual < $cantPaginas){
			if($cantPaginas>$totalMostrar){
				echo '<span class="paginador-mas">...</span>';
			}
			echo '<li><a href="javascript:ir('.($paginaActual+1).')" class="page">&gt;</a></li><li><a href="javascript:ir('.$cantPaginas.')" class="page">&gt;&gt;</a></li>';
		} else {
			echo '';
		}
		echo '</ul>';
	}

	
	function GetReferer()
	{
		$p = strpos($_SERVER['HTTP_REFERER'], "?");
		if($p)
			return substring($_SERVER['HTTP_REFERER'], strrpos($_SERVER['HTTP_REFERER'], "/") + 1, $p);
		else
			return substr($_SERVER['HTTP_REFERER'], strrpos($_SERVER['HTTP_REFERER'], "/") + 1);
	}

	function substring($str, $start, $end)
	{
		return substr($str, $start, ($end-$start));
	}

	function debug($var) 
	{
		echo "<pre>";
		print_r($var);
		exit;
	}

	function in_resultado($rDatos, $clave, $valor)
	{
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if($rDatos->campo($clave, $i) == $valor)
			{
				return true;
			}
		}
		return false;
	}

	function seguridadAdmin($permiso)
	{
		if($_SESSION['id_usu']=="")
		{
			header("Location:index.php");
			exit();

		} else {
			if(!cUsuario::tienePermisoActivo($_SESSION['id_usu'], $permiso)){
				header("Location:/index.php");
				die();
			}
		}
	}
	
	function seguridadSitio($permiso)
	{
		if($_SESSION['id_usu']=="")
		{
			header("Location:index.php");
			exit();
		} else {
			if(!cUsuario::tienePermisoActivo($_SESSION['id_usu'], $permiso)){
				header("Location:index.php");
			}
		}
	}
	
	function seguridadFuncion($permiso)
	{
		return cUsuario::tienePermisoActivo($_SESSION['id_usu'], $permiso);
	}
	
	function seguridadPerfil($perfil)
	{
		return cUsuario::tienePerfilActivo($_SESSION['id_usu'], $perfil);
	}

	function armarCombo($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	function armarComboSinId($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre'  ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	function armarComboMultiple($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if(in_array($rDatos->campoPorPosicion(0, $i),$seleccionado))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	
	function armarComboOtro($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida .= "<option value='-1' ".($seleccionado==-1 ? "selected":"").">Otro</option>";
		$salida = $salida . "</select>";
		echo $salida;
	}

	function armarComboOtroNinguno($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida .= "<option value='-1' ".($seleccionado==-1 ? "selected":"").">Otro</option>";
		$salida .= "<option value='-1' ".($seleccionado==-1 ? "selected":"").">Ninguno</option>";
		$salida = $salida . "</select>";
		echo $salida;
	}
	function armarComboNinguno($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
			
		$salida .= "<option value='-1' ".($seleccionado==-1 ? "selected":"").">Ninguno</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".(strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i))."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	
	function armarComboFullText($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value=''>". $textoNinguno . "</option>";
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected title='".$rDatos->campoPorPosicion(1, $i)."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>100 ? substr($rDatos->campoPorPosicion(1, $i),0,100):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' title='".$rDatos->campoPorPosicion(1, $i)."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>100 ? substr($rDatos->campoPorPosicion(1, $i),0,100):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	
	function armarComboNull($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="", $textoNull="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value='' ".(strlen($seleccionado)==0 ? "selected" : "").">". $textoNinguno . "</option>";

		if(strlen($textoNull))
			$salida .= "<option value='0' ".(strcmp($seleccionado, "0")==0 ? "selected" : "").">". $textoNull . "</option>";
			
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."'>" . (strlen($rDatos->campoPorPosicion(1, $i))>255 ? substr($rDatos->campoPorPosicion(1, $i),0,255):$rDatos->campoPorPosicion(1, $i)) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	
	function armarComboUnicoRegistro($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' id='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if($rDatos->cantidad()>1 || $seleccionado==""){
			if(strlen($textoNinguno))
				$salida .= "<option value='0'>". $textoNinguno . "</option>";
		}
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i))
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected>" . $rDatos->campoPorPosicion(1, $i). "</option>";
			else
				$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."'>" . $rDatos->campoPorPosicion(1, $i) . "</option>";
		}
		$salida = $salida . "</select>";
		echo $salida;
	}
	
	function armarComboMarcaFinal($rDatos, $nombre, $clase="", $eventos = "", $seleccionado="", $textoNinguno="")
	{
		$salida = "<select name='$nombre' ". 
					(strlen($clase) > 0 ? " class='$clase'" : "class='combo' ") .
					(strlen($eventos) > 0 ? " $eventos " : '' ) .
					 ">";
		if(strlen($textoNinguno))
			$salida .= "<option value='0'>". $textoNinguno . "</option>";
			
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			$elegible="";
			if($rDatos->campoPorPosicion(2, $i)!='S')
			{
				$elegible="disabled";
				$salida.="<optgroup label=\"".$rDatos->campoPorPosicion(1, $i)."\" ></optgroup>";
			} else {
				if('x'. $seleccionado == 'x'. $rDatos->campoPorPosicion(0, $i)){
					$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ."' selected ".$elegible.">" . $rDatos->campoPorPosicion(1, $i) . "</option>";
				} else {
					$salida .= "<option value='". $rDatos->campoPorPosicion(0, $i) ." ".$elegible."'>" . $rDatos->campoPorPosicion(1, $i) . "</option>";
				}
			}
		}
		$salida = $salida . "</select>";


		$cadena="";
		$cadena_ant="";
		$longitud_ant=0;
		for($i=0; $i < $rDatos->cantidad(); $i++)
		{
			if($cadena==""){
				$nueva_cadena=explode(">", $cadena_ant);
				$cadena_ant="";
				for($j=0; $j<count($nueva_cadena)-$longitud_ant;$j++){
					$cadena_ant.=$nueva_cadena[$j].">";
				}
				$longitud_ant=(strlen($rDatos->campoPorPosicion(3, $i))-$longitud_ant)/4;
				$cadena.=$cadena_ant.$rDatos->campoPorPosicion(4, $i);
				$cadena_ant.=$rDatos->campoPorPosicion(4, $i);
			} else {
				$cadena.=">".$rDatos->campoPorPosicion(4, $i);
				$cadena_ant.=">".$rDatos->campoPorPosicion(4, $i);
			}
			if($rDatos->campoPorPosicion(2, $i)=='S')
			{
				$salida.='<input type="hidden" name"area_'.$rDatos->campoPorPosicion(0, $i).'" value="'.substr($cadena,1).'">';
				$cadena="";
			}

		}
		echo $salida;
	}
	
	function convertirFechaCalendar($fecha,$formato)
	{
		if(is_null($fecha)) 
			return "";
		return date($formato,strtotime($fecha));
	}

	function convertirFecha($fecha)
	{
		if($fecha == "0000-00-00 00:00:00") 
			return "-";
		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 5, 2);
		$dia  = substr($fecha, 8, 2);
		return $dia . " / " . $mes . " / " . $anio;
	}
	function convertirFechaComprimido($fecha)
	{
		if($fecha == "0000-00-00 00:00:00") 
			return "-";
		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 5, 2);
		$dia  = substr($fecha, 8, 2);
		return $dia . "/" . $mes . "/" . $anio;
	}
	function convertirFechaHora($fecha)
	{
		if($fecha == "0000-00-00 00:00:00") 
			return "-";

		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 5, 2);
		$dia  = substr($fecha, 8, 2);
		if(strlen($fecha) >10)
		{
			$hora = substr($fecha, 11, 2);
			$minuto = substr($fecha, 14, 2);
			return $dia . "/" . $mes . "/" . $anio . ' ' . $hora . ':' . $minuto;
		}
		return $dia . " / " . $mes . " / " . $anio;
	}
	function convertirFechaEntero($fecha)
	{
		$anio = substr($fecha, 0, 4);
		$mes  = substr($fecha, 4, 2);
		$dia  = substr($fecha, 6, 2);
		return $dia . " / " . $mes . " / " . $anio;
	}

	function guardarFecha($fecha)
	{
		$dia = substr($fecha, 0, 2);
		$mes  = substr($fecha, 3, 2);
		$anio  = substr($fecha, 6, 4);
		if(strlen($fecha) >10)
		{
			$hora = substr($fecha, 11, 2);
			$minuto = substr($fecha, 14, 2);
			return $dia . "/" . $mes . "/" . $anio . ' ' . $hora . ':' . $minuto;
		}
		return $anio. "-" . $mes . "-" . $dia ;
	}
	
	function convertirCuil($cuil)
	{
		return (substr($cuil, 0, 2).'-'.substr($cuil, 2, 8).'-'.substr($cuil, 10,2));
	}

	function leerArchivo($archivo)
	{	
		$fd = fopen($archivo, 'r');
		$contenido = fread($fd, filesize($archivo));
		fclose($fd);
		return $contenido;
	}

	function crearArchivo($archivo, $contenido)
	{
		$fd = fopen($archivo, 'w');
		fwrite($fd, $contenido);
		fclose($fd);
		return;
	}


	function enviarMail($remitente, $mailRemitente, $destinatario, $mailDestinatario, $subject, $contenido, $extraHeaders="", $adjunto, $html, $copia)
	{
		incluir('clases/class.phpmailer.php', $_SERVER['SCRIPT_NAME']);
		$mail = new phpmailer();

		$mail->Host       = MAILER; // SMTP server
		//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
		$mail->SMTPAuth   = _MAIL_AUTH;                  // enable SMTP authentication
		$mail->Port       = _MAIL_PORT;                    // set the SMTP port for the GMAIL server
		$mail->IsSMTP();
		$mail->Encoding = "base64";
		$mail->CharSet = 'ISO-8859-1';
		//$mail->SMTPSecure = _MAIL_SECURE;
		if($html==1){
			$mail->IsHTML(true);
		} else {
			$mail->IsHTML(false);
		}
		if(!empty($adjunto)){
			$mail->AddAttachment($adjunto);
		}
		$mail->Username = _MAIL_USER;
		$mail->Password = _MAIL_PASS;
		//$mail->AddReplyTo($var_email, $var_razon_social);
		$mail->AddAddress($mailDestinatario, $mailDestinatario);
		if(!empty($copia)){
			$mail->AddCC($copia, $copia);
		}
		
		if(empty($remitente)){
			$mail->SetFrom(_MAIL_FROM, utf8_decode(NOMBRE_WEBMASTER));
		} else {
			$mail->SetFrom($mailRemitente, utf8_decode($remitente));
		}
		$mail->Subject    = utf8_decode($subject);
		$mail->Body    = str_replace("?","",utf8_decode($contenido));
		$respuesta=$mail->Send();
		$mail->ClearAddresses();
		return($respuesta);
	}


	function rmdirr($path) 
	{
		$dir = opendir($path) ;
		while ( $entry = readdir($dir) ) {
		if ( is_file( $path . BARRA . $entry ) ) {
		unlink( $path.BARRA.$entry ) ;
		} elseif ( is_dir( $path . BARRA . $entry ) && $entry!='.' && $entry!='..' ) {
		rmdirr( $path . BARRA . $entry ) ;
		}
		}
		closedir($dir) ;
		return rmdir($path) ;
	}

	function datediff($interval, $end_date, $start_date)
	{
		$aStartDate = explode('-', $start_date);
		$aEndDate = explode('-', $end_date);

		$data1 = mktime (0, 0, 0, $aStartDate[1], $aStartDate[2], $aStartDate[0]);
		$data2 = mktime (0, 0, 0, $aEndDate[1], $aEndDate[2], $aEndDate[0]);
		return ($data2 - $data1 ) / 86400;
	}

function str_replace_once($needle, $replace, $haystack) {
   $pos = strpos($haystack, $needle);
   if ($pos === false) {
       return $haystack;
   }
   return substr_replace($haystack, $replace, $pos, strlen($needle));
} 

function returnSubstrings($text, $openingMarker, $closingMarker) {
	$openingMarkerLength = strlen($openingMarker);
	$closingMarkerLength = strlen($closingMarker);
	$result = array();
	$position = 0;
	while (($position = strpos($text, $openingMarker, $position)) !== false) {
		$position += $openingMarkerLength;
		if (($closingMarkerPosition = strpos($text, $closingMarker, $position)) !== false) {
			$result[] = substr($text, $position, $closingMarkerPosition - $position);
			$position = $closingMarkerPosition + $closingMarkerLength;
		}
	}
	return $result;
}

function limpiar_acentos($s)
{
$s = str_replace("~","-",$s);
$s = str_replace("&","-",$s);
$s = str_replace("\"","",$s);
$s = str_replace(")","",$s);
$s = str_replace("(","",$s);
$s = str_replace("?","",$s);
$s = str_replace("¿","",$s);
$s = str_replace("!","",$s);
$s = str_replace("¡","",$s);
$s = str_replace(":","",$s);
$s = str_replace("%","",$s);
$s = str_replace("”","",$s);
$s = str_replace("“","",$s);
$s = str_replace("$","",$s);
$s = str_replace("#","",$s);
$s = str_replace("°","",$s);
$s = str_replace("|","",$s);
$s = str_replace("¬","",$s);
$s = str_replace("}","",$s);
$s = str_replace("{","",$s);
$s = str_replace("^","",$s);
$s = str_replace("]","",$s);
$s = str_replace("[","",$s);


$s=strtolower($s);
return $s;
} 

function fullUpper($str){
   // convert to entities
  /* $subject = htmlentities($str,ENT_QUOTES);
   $pattern = '/&([a-z])(uml|acute|circ';
   $pattern.= '|tilde|ring|elig|grave|slash|horn|cedil|th);/e';
   $replace = "'&'.strtoupper('\\1').'\\2'.';'";
   $result = preg_replace($pattern, $replace, $subject);
   // convert from entities back to characters
   $htmltable = get_html_translation_table(HTML_ENTITIES);
   foreach($htmltable as $key => $value) {
      $result = preg_replace(addslashes($value),$key,$result);
   }
   return(strtoupper($result));*/
   return strtoupper($str);
}
function add_date($givendate,$day=0,$mth=0,$yr=0) {

      $cd = strtotime($givendate);

      $newdate = date('Y-m-d h:i:s', mktime(date('h',$cd),

    date('i',$cd), date('s',$cd), date('m',$cd)+$mth,

    date('d',$cd)+$day, date('Y',$cd)+$yr));

      return $newdate;

}
function mostrarCUIT($cuit){
	return substr($cuit,0,2).'-'.substr($cuit,2,8).'-'.substr($cuit,10,1);
}
function validarCUIT($cuit) {
	$cadena = str_split($cuit);
	
	if(strlen($cuit)!=11){
		return false;
	}
	
	$result = $cadena[0]*5;
	$result += $cadena[1]*4;
	$result += $cadena[2]*3;
	$result += $cadena[3]*2;
	$result += $cadena[4]*7;
	$result += $cadena[5]*6;
	$result += $cadena[6]*5;
	$result += $cadena[7]*4;
	$result += $cadena[8]*3;
	$result += $cadena[9]*2;
	
	$div = intval($result/11);
	$resto = $result - ($div*11);
	
	if($resto==0){
		if($resto==$cadena[10]){
			return true;
		}else{
			return false;
		}
	}elseif($resto==1){
		if($cadena[10]==9 AND $cadena[0]==2 AND $cadena[1]==3){
			return true;
		}elseif($cadena[10]==4 AND $cadena[0]==2 AND $cadena[1]==3){
			return true;
		}
	}elseif($cadena[10]==(11-$resto)){
		return true;
	}else{
		return false;
	}
}

function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
    return $d && $d->format($format) === $date;
}
?>