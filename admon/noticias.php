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
require_once(ROOT_DIR_CLASES . "Noticia.php");
require_once(ROOT_DIR_CLASES . "NoticiaSeccion.php");
require_once(ROOT_DIR_CLASES . "Usuario.php");

//Instancio las clases requeridas
$Noticia = new Noticia();
$NoticiaSeccion = new NoticiaSeccion();
$Usuario = new Usuario();

//Inicializo la conexion a la base de datos correspondientes
$Noticia -> crearBD("ehealth");
$NoticiaSeccion -> crearBD("ehealth");
$Usuario -> crearBD("ehealth");

$mensaje_error = "";

//Consulto las secciones de las noticias porque me seran utiles en todas las pantallas
$NoticiaSecciones = $NoticiaSeccion -> consultar();

foreach ($NoticiaSecciones as $ObjNoticiaSeccion)
	$secciones[$ObjNoticiaSeccion -> getNtsId()] = $ObjNoticiaSeccion -> getNtsNombre();


//Si la opcion no existe
if(!isset($_REQUEST["opcion"]))
	$_REQUEST["opcion"] = "";


//Realizo las acciones correspondientes de acuerdo con la opcion
switch($_REQUEST["opcion"])
{
	//Si la opcion esta vacia
	case "":
		//Opcion para listar los registros
		//Consulto las noticias activas
		$Noticias = $Noticia -> consultar("ORDER BY not_fecha DESC");
	break;
	
	//Si la opcion es crear
	case "crear":
	break;
	
	//Si la opcion es confirmar_creacion
	case "confirmar_creacion":
		$Noticia -> setNotFecha($_REQUEST["fecha"]);
		$Noticia -> setNotTitulo($_REQUEST["titulo"]);
		$Noticia -> setNotLead($_REQUEST["lead"]);
		$Noticia -> setNotTexto($_REQUEST["texto"]);
		$Noticia -> setNotNtsId($_REQUEST["nts_id"]);
		$Noticia -> setNotActivo(!isset($_REQUEST["activo"]) ? 0 : 1);
		$Noticia -> setNotUsuId($_SESSION["usu_id"]);
		$id = $Noticia -> insertar();
		
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
		//Si viene el ID de la noticia entonces continuo
		if(isset($_REQUEST["id"]) and is_numeric($_REQUEST["id"]))
		{
			//Consulto las noticias por ID
			$Noticia = $Noticia -> consultarId($_REQUEST["id"]);
		}
		else
		{
			header("Location: ".$PHP_SELF);
			exit();
		}
	break;
	
	//Si la opcion es confirmar
	case "confirmar_actualizacion":
		//Si viene el ID de la noticia entonces continuo
		if(isset($_POST["id"]) and is_numeric($_POST["id"]))
		{
			//Consulto la noticia por ID
			$Noticia = $Noticia -> consultarId($_REQUEST["id"]);
			$Noticia -> setNotFecha($_REQUEST["fecha"]);
			$Noticia -> setNotTitulo($_REQUEST["titulo"]);
			$Noticia -> setNotLead($_REQUEST["lead"]);
			$Noticia -> setNotTexto($_REQUEST["texto"]);
			$Noticia -> setNotNtsId($_REQUEST["nts_id"]);
			$Noticia -> setNotActivo(!isset($_REQUEST["activo"]) ? 0 : 1);
			$Noticia -> setNotUsuId($_SESSION["usu_id"]);
			$registros_actulizados = $Noticia -> actualizar();
			
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
		//Si viene el ID de la noticia entonces continuo
		if(isset($_REQUEST["id"]) and is_numeric($_REQUEST["id"]))
		{
			//Consulto la noticia por ID
			$Noticia = $Noticia -> consultarId($_REQUEST["id"]);
			$registros_eliminados = $Noticia -> eliminar();
			
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
        Noticias
      </header>
      <p>
        Administre las noticias que se encuentran en el sitio web.
      </p>
	  <p>
		<a href="<?=$PHP_SELF?>?opcion=crear">Nueva noticia</a>
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
			if(sizeof($Noticias))
			{
?>
      		<tr>
      			<th>Fecha</th>
				<th>T&iacute;tulo</th>
				<th>Lead</th>
				<th>Texto</th>
				<th>Secci&oacute;n</th>
				<th>Activo</th>
				<th colspan="2">Acciones</th>
      		</tr>
<?php
				foreach ($Noticias as $ObjNoticia)
				{
?>
			<tr>
      			<td align="right" nowrap><?=$ObjNoticia -> getNotFecha()?></td>
				<td><?=$ObjNoticia -> getNotTitulo()?></td>
				<td><?=$ObjNoticia -> getNotLead()?></td>
				<td><?=$ObjNoticia -> getNotTexto()?></td>
				<td align="center"><?=$secciones[$ObjNoticia -> getNotNtsId()]?></td>
				<td align="center"><?=$ObjNoticia -> getNotActivo() ? "S&iacute;" : "No"?></td>
				<td align="center"><a href="<?=$PHP_SELF."?opcion=editar&id=".$ObjNoticia -> getNotId()?>">U</a></td>
				<td align="center"><a href="<?=$PHP_SELF."?opcion=eliminar&id=".$ObjNoticia -> getNotId()?>" onClick="javascript:return confirm('Esta seguro de eliminar el registro?');">E</a></td>
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
      				<label>Fecha:</label>
      			</td>
      			<td>
            		<input type="text" name="fecha" value="<?=$Noticia -> getNotFecha()?>" placeholder="Ingrese la fecha" required />
            	</td>
      		</tr>
      		<tr>
      			<td>
      				<label>T&iacute;tulo:</label>
      			</td>
      			<td>
            		<input type="text" name="titulo" value="<?=$Noticia -> getNotTitulo()?>" placeholder="Ingrese el titulo" required size="100" />
            	</td>
      		</tr>
      		<tr>
      			<td>
      				<label>Lead:</label>
      			</td>
      			<td>
            		<textarea name="lead" placeholder="Ingrese el lead" cols="100" rows="3" required><?=$Noticia -> getNotLead()?></textarea>
            	</td>
      		</tr>
      		<tr>
      			<td>
      				<label>Texto:</label>
      			</td>
      			<td>
            		<textarea name="texto" placeholder="Ingrese el texto" cols="100" rows="10" required><?=$Noticia -> getNotTexto()?></textarea>
            	</td>
      		</tr>
			<tr>
      			<td>
      				<label>Secci&oacute;n:</label>
      			</td>
      			<td>
            		<select name="nts_id" required>
					<?php
					foreach($secciones as $id => $nombre)
					{
					?>
						<option value="<?=$id?>" <?=$id == $Noticia -> getNotNtsId() ? "selected" : ""?>><?=$nombre?></option>
					<?php
					}
					?>
					</select>
            	</td>
      		</tr>
			<tr>
      			<td>
      				<label>Activo:</label>
      			</td>
      			<td>
            		<input type="checkbox" name="activo" value="1" <?=$Noticia -> getNotActivo() ? "checked" : ""?> />
            	</td>
      		</tr>
      		<tr>
      			<td colspan="2" align="center">
      				<input type="hidden" value="<?=$_REQUEST["opcion"] == "crear" ? "confirmar_creacion" : "confirmar_actualizacion"?>" name="opcion" />
					<input type="hidden" value="<?=$Noticia -> getNotId()?>" name="id" />
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