<?php
require_once(ROOT_DIR_CLASES."BaseDatos.php");

Class FactoryBaseDatos
{
	private $bd;
	
	public function __construct()
	{
	}

	public function crearBD($nombre_conexion)
	{
		switch($nombre_conexion)
		{			
			case "ehealth":
				$ehealth_bd = new ADODB();
				$this -> bd = $ehealth_bd -> getConexion();
				return $this -> bd;
			break;
		}
	}
}
?>