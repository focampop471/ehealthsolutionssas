<?php
require_once("constantes.inc.php");

//Incluyo las clases a utilizar
require_once(ROOT_DIR_CLASES . "FactoryBaseDatos.php");
require_once(ROOT_DIR_CLASES . "Noticia.php");
require_once(ROOT_DIR_CLASES . "NoticiaSeccion.php");
require_once(ROOT_DIR_CLASES . "Producto.php");
require_once(ROOT_DIR_CLASES . "Visita.php");

//Instancio las clases requeridas
$Noticia 			= new Noticia();
$NoticiaSeccion 	= new NoticiaSeccion();
$Producto 			= new Producto();
$Visita 			= new Visita();

//Inicializo la conexion a la base de datos correspondientes
$Noticia 			-> crearBD("ehealth");
$NoticiaSeccion 	-> crearBD("ehealth");
$Producto		 	-> crearBD("ehealth");
$Visita		 		-> crearBD("ehealth");
	
//Registro la visita
$Visita -> registrarVisita();
//Consulto las noticias activas
$Noticias = $Noticia -> consultar("WHERE not_activo = 1 ORDER BY not_nts_id ASC, not_fecha DESC");
//Consulto los productos activos
$Productos = $Producto -> consultar("WHERE prd_activo = 1", 2);
$Visitas = $Visita -> consultar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta name="description" content="Página web propia">
	<meta charset="ISO-8859-1">
	<meta name="viewport" content="width=device-width">
	<title>eHealth Solutions S.A.S.</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
	<link rel="SHORTCUT ICON" href="img/favicon.ico">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.accordion.js"></script>
	<script type="text/javascript">
		//Inicio el llamado de las funcionalidades de jquery
		$(document).ready(function () {
			//Inicializo el plugin de easyAccordion con la configuracion que deseo
			$('#noticias').easyAccordion({
				autoStart: true, //Este parametro permite que el cambio de pestana sea automatico
				slideInterval: 5000, //Milisegundos para el cambio automatico de pestanas
				slideNum:false //Para que inicie en la primera pestana por defecto
			}); 
		});
	</script>
</head>
<body>
  <header>
  	<section id="encabezado">
  	  <img src="img/logo.png" id="logo" alt="eHealth Solutions S.A.S." />
  	  <nav>
  	  	<ul>
  	  	  <li><a href="index.html">Inicio</a></li>
		  <li><a href="quienes_somos.html">Qui&eacute;nes somos</a></li>
		  <li><a href="productos.html">Productos</a></li>
  	  	  <li><a href="contacto.html">Contacto</a></li>
  	  	</ul>
  	  </nav>
  	</section>
  </header>
  <section id="principal">
    <article>
      <header>
        Lo que nos define ...
      </header>
	  <img src="img/saludocupacional.jpg" alt="Pioneros en la gestion integrada del riesgo social" title="Pioneros en la gestion integrada del riesgo social" width="100%" />
	  <div id="titulo">
		<p>
			Somos pioneros en la gesti&oacute;n integrada del riesgo social y la salud ocupacional a trav&eacute;s de la tecnolog&iacute;a, lo que nos permite ayudarle en la vigilancia, el cuidado y la prevenci&oacute;n de enfermedades y accidentes laborales en sus colaboradores.
		</p> 
	  </div>
    </article>
  </section>
  <section id="galeria">
    <article>
      <header>
        &Uacute;ltimas noticias
      </header>
	  <div id="noticias">
      	<dl>
<?php
	//Si existen noticias
	if(sizeof($Noticias))
	{
		$iteracion = 0;
		//Consulto las secciones
		$NoticiaSecciones = $NoticiaSeccion -> consultar();

		foreach ($NoticiaSecciones as $ObjNoticiaSeccion)
			$secciones[$ObjNoticiaSeccion -> getNtsId()] = $ObjNoticiaSeccion -> getNtsNombre();

		foreach ($Noticias as $ObjNoticia)
		{
?>
        	<dt <?php if(!$iteracion) echo "class='active'";?> ><?=$secciones[$ObjNoticia -> getNotNtsId()]?></dt>
            <dd>
				<h2><?=$ObjNoticia -> getNotTitulo()?></h2>
				<p><?=$ObjNoticia -> getNotTexto()?>
				</p>
			</dd>
<?php
			$iteracion++;
		}
	}
	else
	{
?>
            <dd>No se encontraron noticias</dd>
<?php
	}
?>
           </dl>
        </div>
    </article>
  </section>
  <section id="productos">
    <article>
      <header>
        Nuestros productos
      </header>
      <div id="listado">
<?php
	//Si existen productos
	if(sizeof($Productos))
	{
		//Recorro los productos 
		foreach ($Productos as $ObjProducto)
		{
?>
      	<div class="separador"></div>
      	<div class="producto">
      		<div class="imagen">
      			<img src="<?=HTTP_DIRECTORY_IMG?><?=$ObjProducto -> getPrdImagen()?>" height="100" alt="<?=$ObjProducto -> getPrdNombre()?>" />
      		</div>
      		<div class="texto">
      			<strong><?=$ObjProducto -> getPrdNombre()?>:</strong>
				<?=$ObjProducto -> getPrdDescripcion()?>
      		</div>
      	</div>
<?php
		}
?>
      	<div class="separador"></div>
<?php
	}
	else
	{
?>
            <div class="producto">No se encontraron productos</div>
<?php
	}
?>
      </div>
    </article>
  </section>
  <section id="pie">
  	&copy; eHealth Solutions S.A.S. 2017.<br/><br/>
	<strong>Visitas:</strong>
<?php
	//Si existen visitas
	if(sizeof($Visitas))
	{
		foreach ($Visitas as $ObjVisita)
		{
?>
        	<?=$ObjVisita -> getVisCantidad()?>
<?php
		}
	}
	else
	{
?>
			0
<?php
	}
?>
  </section>
</body>
</html>