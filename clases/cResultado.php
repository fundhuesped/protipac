<?php

	class cResultado 
	{

		var $CAMPOS = "";
		var $DATOS  = "";
		var $CANTIDAD  = "";

		function cResultado($campos=Array(), $datos=Array()) 
		{
			$this->CAMPOS = $campos;
			$this->DATOS = $datos;		
		}

		function cantidad() {
			return count($this->DATOS);
		}
		
		function cantidadCampos() {
			return count($this->CAMPOS);
		}


		function campo($campo, $fila)
		{
			$valor = $this->DATOS[$fila][$this->CAMPOS[$campo]];
			return $valor;
		}

		function campoPorPosicion($campo, $fila)
		{
			$valor = $this->DATOS[$fila][$campo];
			return $valor;
		}

		function setCampo($campo, $fila, $valor)
		{
			$this->DATOS[$fila][$this->CAMPOS[$campo]] = $valor;
		}

		function eliminarPosicion($posicion)
		{
			if($posicion < $this->cantidad())
			{
				array_splice($this->DATOS, $posicion, 1);
			}
		}

		function agregarRegistro($registro, $primeraPosicion="")
		{
			if (strlen($primeraPosicion) > 0)
				$this->DATOS = array_merge(array(0=>$registro), $this->DATOS);
			else
				$this->DATOS[] = $registro;
		}
		
		function imprimir() {
			echo '<table border="1"><tr>';
			$aCampos = array_keys($this->CAMPOS);
			for ($i=0;$i<count($aCampos);$i++) {
				echo '<td>' . $aCampos[$i] . '</td>';
			}
			echo '</tr>';
			for($i=0; $i<$this->cantidad(); $i++ ) {
				echo '<tr>';
				for($j=0; $j< count($this->CAMPOS); $j++)
					echo '<td>' . $this->campoPorPosicion($j, $i) . '</td>';
				echo '</tr>';
			}
			echo '</table>';
		}

		function campoNombrePorPosicion($campoCol)
		{
			$aCampos = array_keys($this->CAMPOS);
			return $aCampos[$campoCol];
		}
		
	}
?>