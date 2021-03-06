<?php
ob_start();
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
$mensaje_error = "";

//Si la opcion no existe o es login
if(!isset($_REQUEST["opcion"]))
{
	//Si la session existe entonces permito que continue con la misma
	if (isset($_SESSION["usu_id"]) and is_numeric($_SESSION["usu_id"]))
		$_REQUEST["opcion"] = "bienvenida";
	else
		$_REQUEST["opcion"] = "";
	
}
else
{
	switch($_REQUEST["opcion"])
	{
		//Si la opcion es salir
		case "salir":
			//Destruyo la session
			session_destroy();
			header("Location:  index.php");
			exit();
		break;
		
		case "bienvenida":
			//Si la sesion no existe entonces lo direcciono al login
			if (!isset($_SESSION["usu_id"]) or !is_numeric($_SESSION["usu_id"]))
			{
				header("Location:  index.php");
				exit();
			}
		break;
		
		default:
			$_REQUEST["opcion"] = "";
		break;
	}
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="description" content="eHealth Solutions S.A.S.">
	<meta charset="ISO-8859-1">
	<meta name="viewport" content="width=device-width">
	<title>eHealth Solutions S.A.S.</title>
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
	<link rel="SHORTCUT ICON" href="<?=HTTP_DIRECTORY_IMG?>favicon.ico">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
  <header>
  	<section id="encabezado">
  	  <img src="../img/logo.png" id="logo" alt="eHealth Solutions S.A.S." />
  	  <nav>
<?php
	if ($_REQUEST["opcion"] != "")
	{
?>
  	  	<ul>
  	  	  <li><a href="index.php">Inicio</a></li>
		  <li><a href="noticias.php">Noticias</a></li>
		  <li><a href="productos.php">Productos</a></li>
		  <li><a href="libreta.php">Libreta</a></li>
  	  	  <li><a href="index.php?opcion=salir">Salir</a></li>
  	  	</ul>
<?php
	}
?>
  	  </nav>
  	</section>
  </header>
  <section id="principal">
    <article>
      <header>
        <?=$_REQUEST["opcion"] == "" ? "Ingreso" : "Bienvenid@, ".$_SESSION["usu_nombres"]."!"?>
      </header>
<?php
	if ($_REQUEST["opcion"] == "")
	{
?>
	  <p>
        Ingrese sus datos en el formulario que se encuentra a continuaci&oacute;n:
      </p>
      <form method="post" autocomplete="off"  id="login-button" action="javascript:void(0)">
      	<table class="tablalogin" width="100%">
      		<tr>
      			<td colspan="2" align="center">
					<div id="error">&nbsp;<?=$mensaje_error?></div>
      			</td>
      		</tr>
			<tr>
      			<td width="50%" align="right">
      				<label>Usuario:</label>
      			</td>
      			<td>
            		<input type="text" name="usuario" placeholder="Ingrese su usuario" required id="user" />
            	</td>
      		</tr>
      		<tr>
      			<td width="50%" align="right">
      				<label>Contrase&ntilde;a:</label>
      			</td>
      			<td>
            		<input type="password" name="contrasena" placeholder="Ingrese su contrase&ntilde;a" required id="password"/>
            	</td>
      		</tr>
      		<tr>
      			<td colspan="2" align="center">
					<input type="hidden" name="opcion" value="login" />
      				<br/><input type="submit" value="Ingresar" />
      			</td>
      		</tr>	
      	</table>
      </form>
<?php
	}
	else
	{
?>
	  <p>
        <br/><br/>Este es el m&oacute;dulo de administraci&oacute;n de la eHealth Solutions S.A.S.<br/><br/><br/>
      </p>
<?php
	}
?>
    </article>
  </section>
  <section id="pie">
  	&copy; eHealth Solutions S.A.S. 2017.
  </section>
</body>
<script>
	$(document).ready(function(){
		$("#login-button").submit(function(event){
			event.preventDefault();
			$.ajax({
				url:"login.php",
				method:"post",
				data:{
					usuario		: $("#user").val(),
					contrasena	: $("#password").val(),
				},
				success:function(response){
					if(response == '1')
						location.href='index.php?opcion=bienvenida';
					else
						$('#error').html('Error');
					
				}
			});
		});
	});
</script>
</html>