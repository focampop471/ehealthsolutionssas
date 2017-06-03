<?php
require_once("../constantes.inc.php");

//Incluyo las clases a utilizar
require_once(ROOT_DIR_CLASES . "FactoryBaseDatos.php");
require_once(ROOT_DIR_CLASES . "Direccion.php");

//Instancio las clases requeridas
$Direccion = new Direccion();

//Inicializo la conexion a la base de datos correspondientes
$Direccion -> crearBD("ehealth");
$mensaje_error = 0;

//Si las variables existen entonces realizo la validacion
if(array_key_exists("nombre", $_POST) 
	and array_key_exists("apellido", $_POST) 
	and array_key_exists("correo", $_POST) 
	and array_key_exists("telefono", $_POST)
	and array_key_exists("celular", $_POST)
	and array_key_exists("direccion", $_POST)
	and array_key_exists("ciudad", $_POST)
	and array_key_exists("departamento", $_POST))
{
	$Direccion -> setDirNombres($_POST["nombre"]);
	$Direccion -> setDirApellidos($_POST["apellido"]);
	$Direccion -> setDirCorreo($_POST["correo"]);
	$Direccion -> setDirTelefono($_POST["telefono"]);
	$Direccion -> setDirCelular($_POST["celular"]);
	$Direccion -> setDirDireccion($_POST["direccion"]);
	$Direccion -> setDirCiudad($_POST["ciudad"]);
	$Direccion -> setDirDepartamento($_POST["departamento"]);
	$id = $Direccion -> insertar();

	//Si el registro se actualizo entonces direcciono a la opcion de listar
	if(is_numeric($id) and $id > 0)
		$mensaje_error = 1;
	
}

echo json_encode($mensaje_error);
?>