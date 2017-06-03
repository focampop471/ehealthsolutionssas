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
  <section id="principal">
    <article>
      <header>
        Libreta de direcciones
      </header>
	  <p>
        Ingrese los datos en el formulario que se encuentra a continuaci&oacute;n:
      </p>
      <form method="post" autocomplete="off"  id="libreta-button" action="javascript:void(0)">
      	<table class="tablaFormulario" width="100%">
      		<tr>
      			<td colspan="2" align="center">
					<h3><?=$mensaje_error?></h3>
      			</td>
      		</tr>
			<tr>
      			<td width="50%" align="right">
      				<label>Nombres:</label>
      			</td>
      			<td>
            		<input type="text" name="nombre" placeholder="Ingrese su nombre" required id="nombre" />
            	</td>
      		</tr>
      		<tr>
      			<td width="50%" align="right">
      				<label>Apellidos:</label>
      			</td>
      			<td>
            		<input type="text" name="apellidos" placeholder="Ingrese su apellido" required id="apellido"/>
            	</td>
      		</tr>
			
			<tr>
      			<td width="50%" align="right">
      				<label>Correo:</label>
      			</td>
      			<td>
            		<input type="text" name="correo" placeholder="Ingrese su correo" required id="correo"/>
            	</td>
      		</tr>
			
			<tr>
      			<td width="50%" align="right">
      				<label>Telefono:</label>
      			</td>
      			<td>
            		<input type="text" name="telefono" placeholder="Ingrese su telefono" required id="telefono"/>
            	</td>
      		</tr>
			
			<tr>
      			<td width="50%" align="right">
      				<label>Celular:</label>
      			</td>
      			<td>
            		<input type="text" name="celular" placeholder="Ingrese su celular" required id="celular"/>
            	</td>
      		</tr>
			
			<tr>
      			<td width="50%" align="right">
					<label>Direccion:</label>
      			</td>
      			<td>
            		<input type="text" name="direccion" placeholder="Ingrese su direccion" required id="direccion"/>
            	</td>
      		</tr>
			
			<tr>
      			<td width="50%" align="right">
					<label>Ciudad:</label>
      			</td>
      			<td>
            		<input type="text" name="ciudad" placeholder="Ingrese su ciudad" required id="ciudad"/>
            	</td>
      		</tr>
			
			<tr>
      			<td width="50%" align="right">
					<label>Departamento:</label>
      			</td>
      			<td>
            		<input type="text" name="departamento" placeholder="Ingrese su departamento" required id="departamento"/>
            	</td>
      		</tr>
			
      		<tr>
      			<td colspan="2" align="center">
					<input type="hidden" name="opcion" value="guardar_libreta" />
      				<br/><input type="submit" value="Guardar" />
      			</td>
      		</tr>	
      	</table>
      </form>
    </article>
  </section>
  <section id="pie">
  	&copy; eHealth Solutions S.A.S. 2017.
  </section>
</body>
<script>
$(document).ready(function(){
		$("#libreta-button").submit(function(event){
			event.preventDefault();
			$.ajax({
				url:"libreta_funciones.php",
				method:"post",
				data:{
					nombre: $("#nombre").val(),
					apellido: $("#apellido").val(),
					correo: $("#correo").val(),
					telefono: $("#telefono").val(),
					celular: $("#celular").val(),
					direccion: $("#direccion").val(),
					ciudad: $("#ciudad").val(),
					departamento: $("#departamento").val(),
				},
				success:function(response){
					if(response == '1')
					{
						alert("Registro creado!");
						
						$("#nombre").val("")
						console.log(response);
						
						$("#apellido").val("")
						console.log(response);
						
						$("#correo").val("")
						console.log(response);
						
						$("#telefono").val("")
						console.log(response);
						
						$("#celular").val("")
						console.log(response);
						
						$("#direccion").val("")
						console.log(response);
						
						$("#ciudad").val("")
						console.log(response);
						
						$("#departamento").val("")
						console.log(response);
					}
					else
						alert("Se presento un error en la operacion!");
					
				},
				error:function(response){
					console.log(response);
				}
			});
		});
	});
</script>
</html>