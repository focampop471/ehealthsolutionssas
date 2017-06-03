<?php
require_once(ROOT_DIR_ADODB."adodb.inc.php"); 

Class BaseDatos
{
	var $motor;
	var $conexion;
	var $host;
	var $bd;
	var $usuario;
	var $clave;

	public function __construct()
	{
	}

	//Metodo static para retorno de la conexion a la base de datos
	public static function crearBD($motor, $host, $bd, $usuario, $clave)
	{
	}
	
	public function setConexion($conexion)
	{
		$this -> conexion = $conexion;
	}
	
	public function getConexion()
	{
		return $this -> conexion;
	}
}


Class ADODB extends BaseDatos
{
	public function __construct()
	{
		//Habilito las transacciones para este tipo de conexion
		$this -> motor = "mysqlt";
		$this -> host = DB_HOST;
		$this -> bd = DB_NAME;
		$this -> usuario = DB_USER;
		$this -> clave = DB_PASS;
		$this -> conexion = self::crearBD($this -> motor, $this -> host, $this -> bd, $this -> usuario, $this -> clave);
	}
	
	//Sobreescribo el metodo estatico de la clase padre
	public static function crearBD($motor, $host, $bd, $usuario, $clave)
	{
		static $recurso;
		
		if ( $recurso == null or !$recurso -> IsConnected())
		{
			// conexion a la base de datos
			$recurso = &ADONewConnection($motor);
			$recurso -> Connect($host, $usuario, $clave, $bd);

			if(!$recurso -> IsConnected())
				die("ERROR: No se pudo establecer la conexion a la base de datos");
			
		}
		
		return $recurso;
	}
	
	public function __destruct()
	{
	}
}
?>