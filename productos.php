<?php
require_once("constantes.inc.php");

//Incluyo las clases a utilizar
require_once(ROOT_DIR_CLASES . "FactoryBaseDatos.php");
require_once(ROOT_DIR_CLASES . "Producto.php");

//Instancio las clases requeridas
$Producto 	= new Producto();

//Inicializo la conexion a la base de datos correspondientes
$Producto	-> crearBD("ehealth");

//Consulto los productos activos
$Productos = $Producto -> consultar("WHERE prd_activo = 1", 2);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="description" content="Página web propia">
	<meta charset="ISO-8859-1">
	<meta name="viewport" content="width=device-width">
	<title>eHealth Solutions S.A.S.</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
	<link rel="SHORTCUT ICON" href="img/favicon.ico">
	<script src="js/jquery-1.12.4.js"></script>
  	<script src="js/jquery-ui.js"></script>
  	<script type="text/javascript">
		//Inicio el llamado de las funcionalidades de jquery
		$(document).ready(function () {
			//Inicializo el plugin de accordion
			$( "#pestanas" ).tabs(); 
		});
	</script>
</head>
<body>
  <header>
  	<section id="encabezado">
  	  <img src="img/logo.png" id="logo"/>
  	  <nav>
  	  	<ul>
  	  	  <li><a href="index.php">Inicio</a></li>
		  <li><a href="quienes_somos.html">Qui&eacute;nes somos</a></li>
		  <li><a href="productos.php">Productos</a></li>
  	  	  <li><a href="contacto.html">Contacto</a></li>
  	  	</ul>
  	  </nav>
  	</section>
  </header>
  <section id="principal">
    <article>
      <header>
      	Nuestros productos
      </header>
      <div id="pestanas">
      	<div id="menu">
      		<ul>
<?php
	//Si existen productos
	if(sizeof($Productos))
	{
		$iteracion = 1;
		//Recorro los productos 
		foreach ($Productos as $ObjProducto)
		{
?>
      			<li><a href="#pestana-<?=$iteracion?>"><?=$ObjProducto -> getPrdNombre()?></a></li>
<?php
			$iteracion++;
		}
	}
?>

      		</ul>
      	</div>
<?php
	//Si existen productos
	if(sizeof($Productos))
	{
		$iteracion = 1;
		//Recorro los productos 
		foreach ($Productos as $ObjProducto)
		{
?>
      	<div id="pestana-<?=$iteracion?>">
      		<div id="imagen">
      			<img src="<?=HTTP_DIRECTORY_IMG?><?=$ObjProducto -> getPrdImagen()?>" height="100" />
      		</div>
      		<div id="texto">
	      		<p><?=nl2br($ObjProducto -> getPrdTexto())?></p>
			</div>
      	</div>
<?php
			$iteracion++;
		}
	}
?>
      </div>
    </article>
  </section>
  <section id="pie">
  	&copy; eHealth Solutions S.A.S. 2017.
  </section>
</body>
</html>