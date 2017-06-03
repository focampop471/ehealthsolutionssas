<?php
// Inicio la sesion
session_start();

require_once("../constantes.inc.php");

//Incluyo las clases a utilizar
require_once(ROOT_DIR_CLASES . "FactoryBaseDatos.php");
require_once(ROOT_DIR_CLASES . "Usuario.php");

//Instancio las clases requeridas
$Usuario = new Usuario();

//Inicializo la conexion a la base de datos correspondientes
$Usuario -> crearBD("ehealth");
$mensaje_error = 0;

//Si las variables existen entonces realizo la validacion
if(array_key_exists("usuario", $_POST) and array_key_exists("contrasena", $_POST))
{
	//Invoco el metodo de login
	if($Usuario -> login($_POST["usuario"], $_POST["contrasena"]))
	{
		$mensaje_error = 1;
	}
}

echo json_encode($mensaje_error);

?>