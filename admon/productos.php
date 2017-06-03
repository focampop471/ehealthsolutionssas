<?php
ob_start();
// Inicio la sesion
session_start();

//Si la sesion no existe entonces lo direcciono al login
if (!isset($_SESSION["usu_id"]) or !is_numeric($_SESSION["usu_id"]))
{
	header("Location: index.php");
	exit();
}

require_once("../constantes.inc.php");

//Incluyo las clases a utilizar
require_once(ROOT_DIR_CLASES . "FactoryBaseDatos.php");
require_once(ROOT_DIR_CLASES . "Producto.php");
require_once(ROOT_DIR_CLASES . "Usuario.php");

//Instancio las clases requeridas
$Producto = new Producto();
$Usuario = new Usuario();

//Inicializo la conexion a la base de datos correspondientes
$Producto -> crearBD("ehealth");
$Usuario -> crearBD("ehealth");

$mensaje_error = "";

//Si la opcion no existe
if(!isset($_REQUEST["opcion"]))
	$_REQUEST["opcion"] = "";


//Realizo las acciones correspondientes de acuerdo con la opcion
switch($_REQUEST["opcion"])
{
	//Si la opcion esta vacia
	case "":
		//Opcion para listar los registros
		//Consulto las productos activas
		$Productos = $Producto -> consultar();
	break;
	
	//Si la opcion es crear
	case "crear":
	break;
	
	//Si la opcion es confirmar_creacion
	case "confirmar_creacion":
		$Producto -> setNombre($_REQUEST["nombre"]);
		$Producto -> setDescripcion($_REQUEST["descripcion"]);
		$Producto -> setNotTexto($_REQUEST["texto"]);
		$Producto -> setPrdImagen($_REQUEST["imagen"]);
		$Producto -> setPrdActivo(!isset($_REQUEST["activo"]) ? 0 : 1);
		$id = $Producto -> insertar();
		
		//Si el registro se actualizo entonces direcciono a la opcion de listar
		if(is_numeric($id) and $id > 0)
		{
			header("Location: ".$PHP_SELF);
			exit();
		}
		else
			$mensaje_error = "Ocurri&oacute; un error al realizar la operaci&oacute;n";
		
	break;
	
	//Si la opcion es editar
	case "editar":
		//Si viene el ID de la producto entonces continuo
		if(isset($_REQUEST["id"]) and is_numeric($_REQUEST["id"]))
		{
			//Consulto las productos por ID
			$Producto = $Producto -> consultarId($_REQUEST["id"]);
		}
		else
		{
			header("Location: ".$PHP_SELF);
			exit();
		}
	break;
	
	//Si la opcion es confirmar
	case "confirmar_actualizacion":
		//Si viene el ID de la producto entonces continuo
		if(isset($_POST["id"]) and is_numeric($_POST["id"]))
		{
			//Consulto la producto por ID
			$Producto = $Producto -> consultarId($_REQUEST["id"]);
			$Producto -> setPrdNombre($_REQUEST["nombre"]);
			$Producto -> setPrdDescripcion($_REQUEST["descripcion"]);
			$Producto -> setPrdTexto($_REQUEST["texto"]);
			$Producto -> setPrdImagen($_REQUEST["imagen"]);
			$Producto -> setNotUsuId($_SESSION["usu_id"]);
			$registros_actulizados = $Producto -> actualizar();
			
			//Si el registro se actualizo entonces direcciono a la opcion de listar
			if(is_numeric($registros_actulizados))
			{
				header("Location: ".$PHP_SELF);
				exit();
			}
			else
				$mensaje_error = "Ocurri&oacute; un error al realizar la operaci&oacute;n";
			
		}
		else
		{
			header("Location: ".$PHP_SELF);
			exit();
		}
	break;
	
	//Si la opcion es eliminar
	case "eliminar":
		//Si viene el ID de la producto entonces continuo
		if(isset($_REQUEST["id"]) and is_numeric($_REQUEST["id"]))
		{
			//Consulto la producto por ID
			$Producto = $Producto -> consultarId($_REQUEST["id"]);
			$registros_eliminados = $Producto -> eliminar();
			
			//Si el registro se elimino entonces direcciono a la opcion de listar
			if(is_numeric($registros_eliminados))
			{
				header("Location: ".$PHP_SELF);
				exit();
			}
			else
				$mensaje_error = "Ocurri&oacute; un error al realizar la operaci&oacute;n";
			
		}
		else
		{
			header("Location: ".$PHP_SELF);
			exit();
		}
	break;
	
	default:
		$_REQUEST["opcion"] = "";
	break;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="description" content="eHealth Solutions S.A.S.">
	<meta charset="ISO-8859-1">
	<meta name="viewport" content="width=device-width">
	<title>eHealth Solutions S.A.S.</title>
	<link rel="stylesheet" type="text/css" href="<?=HTTP_DIRECTORY?>css/estilos.css">
	<link rel="SHORTCUT ICON" href="<?=HTTP_DIRECTORY_IMG?>favicon.ico">
</head>
<body>
  <header>
  	<section id="encabezado">
  	  <img src="<?=HTTP_DIRECTORY_IMG?>logo.png" id="logo"/>
  	  <nav>
  	  	<ul>
  	  	  <li><a href="index.php">Inicio</a></li>
		  <li><a href="noticias.php">Noticias</a></li>
		  <li><a href="productos.php">Productos</a></li>
		  <li><a href="libreta.php">Libreta</a></li>
  	  	  <li><a href="index.php?opcion=salir">Salir</a></li>
  	  	</ul>
  	  </nav>
  	</section>
  </header>
  <section id="contacto">
    <article>
      <header>
        Productos
      </header>
      <p>
        Administre las productos que se encuentran en el sitio web.
      </p>
	  <p>
		<a href="<?=$PHP_SELF?>?opcion=crear">Nueva producto</a>
	  </p>
      <form method="post" autocomplete="off" action="<?=$PHP_SELF?>">
      	<table width="100%">
			<tr>
      			<td colspan="2" align="center">
					<h3><?=$mensaje_error?></h3>
      			</td>
      		</tr>
<?php
	switch($_REQUEST["opcion"])
	{
		case "":
			if(sizeof($Productos))
			{
?>
      		<tr>
      			<th>Nombre</th>
				<th>Descripci&oacute;n</th>
				<th>Texto</th>
				<th>Im&aacute;gen</th>
				<th>Activo</th>
				<th colspan="2">Acciones</th>
      		</tr>
<?php
				foreach ($Productos as $ObjProducto)
				{
?>
			<tr>
      			<td align="right" nowrap><?=$ObjProducto -> getPrdNombre()?></td>
				<td><?=$ObjProducto -> getPrdDescripcion()?></td>
				<td><?=$ObjProducto -> getPrdTexto()?></td>
				<td><?=$ObjProducto -> getPrdImagen()?></td>
				<td align="center"><?=$ObjProducto -> getPrdActivo() ? "S&iacute;" : "No"?></td>
				<td align="center"><a href="<?=$PHP_SELF."?opcion=editar&id=".$ObjProducto -> getPrdId()?>">U</a></td>
				<td align="center"><a href="<?=$PHP_SELF."?opcion=eliminar&id=".$ObjProducto -> getPrdId()?>" onClick="javascript:return confirm('Esta seguro de eliminar el registro?');">E</a></td>
      		</tr>
<?php
				}
			}
		break;
		
		case "editar":
		case "crear":			
?>
			<tr>
      			<td>
      				<label>Nombre:</label>
      			</td>
      			<td>
            		<input type="text" name="nombre" value="<?=$Producto -> getPrdNombre()?>" placeholder="Ingrese el nombre" required />
            	</td>
      		</tr>
      		<tr>
      			<td>
      				<label>Descripci&oacute;n:</label>
      			</td>
      			<td>
            		<input type="text" name="descripcion" value="<?=$Producto -> getPrdDescripcion()?>" placeholder="Ingrese la descripci&oacute;n" required size="100" />
            	</td>
      		</tr>
      		<tr>
      			<td>
      				<label>Texto:</label>
      			</td>
      			<td>
            		<textarea name="lead" placeholder="Ingrese el texto" cols="100" rows="3" required><?=$Producto -> getPrdTexto()?></textarea>
            	</td>
      		</tr>
      		<tr>
      			<td>
      				<label>Imagen:</label>
      			</td>
      			<td>
            		<textarea name="texto" placeholder="Ingrese el texto" cols="100" rows="10" required><?=$Producto -> getPrdImagen()?></textarea>
            	</td>
      		</tr>
			<tr>
      			<td>
      				<label>Activo:</label>
      			</td>
      			<td>
            		<input type="checkbox" name="activo" value="1" <?=$Producto -> getPrdActivo() ? "checked" : ""?> />
            	</td>
      		</tr>
      		<tr>
      			<td colspan="2" align="center">
      				<input type="hidden" value="<?=$_REQUEST["opcion"] == "crear" ? "confirmar_creacion" : "confirmar_actualizacion"?>" name="opcion" />
					<input type="hidden" value="<?=$Producto -> getPrdId()?>" name="id" />
					<br/><input type="submit" value="Enviar los datos" />
      			</td>
      		</tr>	
<?php
		break;
	}
?>
      	</table>
      </form>
    </article>
  </section>
  <section id="pie">
  	&copy; eHealth Solutions S.A.S. 2017.
  </section>
</body>
</html>