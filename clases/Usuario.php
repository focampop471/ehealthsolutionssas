<?php
/**
 * Clase Usuario
 * 
 * Esta clase hace referencia a la entidad usuario de la base de datos
 * @author aocampo
 * @version 1.0
 * @since 2017-05-29 08:16:58
 */
Class Usuario
{
	//Atributos de la clase
	private $conexion;
	private $auditoria_tabla;
	private $usu_id;
	private $usu_id_tipo;
	private $usu_usuario;
	private $usu_usuario_tipo;
	private $usu_nombres;
	private $usu_nombres_tipo;
	private $usu_apellidos;
	private $usu_apellidos_tipo;
	private $usu_contrasena;
	private $usu_contrasena_tipo;
	private $usu_activo;
	private $usu_activo_tipo;


	/** 
	 * Constructor de la clase
	 */
	public function __construct()
	{
	}			

	public function crear()
	{
		return new Usuario();
	}
	
	/**
	 * Metodo para validar un usuario. 
	 * @param string $usuario Nombre del usuario
	 * @param string $contrasena Contraseña del usuario
	 * @return $login 
	 */
	public function login($usuario, $contrasena) {
		$login = false;
		
		//Consulto los usuarios activos
		$Usuarios = $this -> consultar("WHERE usu_usuario = '".$usuario."' 
											AND usu_contrasena = '".$contrasena."'
											AND usu_activo = 1");
		
		//Si el usuario es valido es porque existen registros
		if(sizeof($Usuarios))
		{
			$login = true;
			$ObjUsuario = $Usuarios[0];
			
			$_SESSION["usu_id"] = $ObjUsuario -> getUsuId();
			$_SESSION["usu_nombres"] = $ObjUsuario -> getUsuNombres() . " " . $ObjUsuario -> getUsuApellidos();
		}
		
		return $login;
	}

	/**
	 * Metodo para obtener una conexion a la base de datos desde la clase Factory. 
	 * @param string $opcion_bd nombre del tipo de la conexion deseada
	 * @return $conexion 
	 */
	public function crearBD($opcion_bd)
	{
		//Instanciamos la clase Factory
		$factory=new FactoryBaseDatos();
		//Obtenemos la conexion del tipo recibido
		$this -> conexion = $factory -> crearBD($opcion_bd);
		//retornamos la conexion
		return $this -> conexion;
	}
	
	/**
	 * Metodo para hacer consultas a la entidad usuario
	 * @param string $where condicion para obtener los resultados
	 * @param integer $cantidad cantidad de registros deseados
	 * @param integer $inicio inicio de los registros deseados
	 * @param string $sql sql personalizado
	 * @return Usuario $objetos arreglo de objetos 
	 */
	public function consultar($where = '', $cantidad = 0, $inicio = 0, $sql = '')
	{
		//Definimos el arreglo que vamos a devolver
		$objetos=array();
		//Evaluamos si la cadena SQL viene vacia
		$sql=trim($sql);
		
		//Si la cadena SQL esta vacia entonces definimos el SQL predeterminado
		if(empty($sql))
		{
			$sql="SELECT principal.* FROM usuario AS principal ";
			//Si el where no esta vacio entonces lo concatenamos al SQL
			$sql.=(!empty($where)) ? $where : "";
		}
		
		//Si viene una cantidad definida y un inicio definido entonces ejecuto un metodo del ADOdb
		if($cantidad and $inicio)
			$rs = $this -> getConexion() -> SelectLimit($sql, $cantidad, $inicio);
		else
			//Si solo viene la cantidad
			if($cantidad)
				$rs = $this -> getConexion() -> SelectLimit($sql, $cantidad);
			//Sino ejecuto el metodo predeterminado
			else
				$rs = $this -> getConexion() -> Execute($sql);
		
		//Si es un result set valido entonces hago la asignacion correspondiente
		if($rs)
		{
			//Recorro el result set
			while ($row = $rs->FetchRow())
			{
				$usuario=$this -> crear();
				$usuario -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_id", $row))
					$usuario -> setUsuId($row["usu_id"]);
				else
					$usuario -> setUsuId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_usuario", $row))
					$usuario -> setUsuUsuario($row["usu_usuario"]);
				else
					$usuario -> setUsuUsuario(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_nombres", $row))
					$usuario -> setUsuNombres($row["usu_nombres"]);
				else
					$usuario -> setUsuNombres(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_apellidos", $row))
					$usuario -> setUsuApellidos($row["usu_apellidos"]);
				else
					$usuario -> setUsuApellidos(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_contrasena", $row))
					$usuario -> setUsuContrasena($row["usu_contrasena"]);
				else
					$usuario -> setUsuContrasena(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_activo", $row))
					$usuario -> setUsuActivo($row["usu_activo"]);
				else
					$usuario -> setUsuActivo(null);


				//Asigno una posicion con el objeto asignado
				$objetos[]=$usuario;
			}
			
			//Cierro la conexion
			$rs -> Close();
		}
		//Si se genero un error entonces lo imprimo 
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
		
		return $objetos;
	}

	/**
	 * Metodo para hacer consultas a la entidad usuario por codigo de la llave primaria
	 * @param integer $id codigo de la llave primaria
	 * @return boolean bandera de ejecucion
	 */
	public function consultarId($id)
	{
		$usuario=false;
		$sql="SELECT principal.* FROM usuario AS principal WHERE usu_id = ".$id;
		$rs = $this -> getConexion() -> Execute($sql);

		if($rs)
		{
			while ($row = $rs->FetchRow())
			{
				$usuario=$this -> crear();
				$usuario -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_id", $row))
					$usuario -> setUsuId($row["usu_id"]);
				else
					$usuario -> setUsuId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_usuario", $row))
					$usuario -> setUsuUsuario($row["usu_usuario"]);
				else
					$usuario -> setUsuUsuario(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_nombres", $row))
					$usuario -> setUsuNombres($row["usu_nombres"]);
				else
					$usuario -> setUsuNombres(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_apellidos", $row))
					$usuario -> setUsuApellidos($row["usu_apellidos"]);
				else
					$usuario -> setUsuApellidos(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_contrasena", $row))
					$usuario -> setUsuContrasena($row["usu_contrasena"]);
				else
					$usuario -> setUsuContrasena(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("usu_activo", $row))
					$usuario -> setUsuActivo($row["usu_activo"]);
				else
					$usuario -> setUsuActivo(null);


			}

			$rs -> Close();
			return $usuario;
		}
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
		
		return false;
	}

	/**
	 * Metodo para hacer inserciones a la entidad usuario. 
	 * Esto depende de los valores de los atributos del objeto
	 *
	 * @return integer $insert_id registro ingresado
	 */
	public function insertar()
	{
		$ultimo_id = 0;
		//Defino el arreglo de campos a insertar
		$sql_campos_insert=array();
		//Defino el arreglo de valores a insertar
		$sql_valores_insert=array();
		//Descripcion para la auditoria
		$descripcion=array();
		
		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_usuario) and !is_null($this -> usu_usuario))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="usu_usuario";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> usu_usuario_tipo) and !empty($this -> usu_usuario_tipo))
			{
				switch($this -> usu_usuario_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> usu_usuario;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> usu_usuario."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_nombres) and !is_null($this -> usu_nombres))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="usu_nombres";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> usu_nombres_tipo) and !empty($this -> usu_nombres_tipo))
			{
				switch($this -> usu_nombres_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> usu_nombres;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> usu_nombres."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_apellidos) and !is_null($this -> usu_apellidos))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="usu_apellidos";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> usu_apellidos_tipo) and !empty($this -> usu_apellidos_tipo))
			{
				switch($this -> usu_apellidos_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> usu_apellidos;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> usu_apellidos."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_contrasena) and !is_null($this -> usu_contrasena))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="usu_contrasena";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> usu_contrasena_tipo) and !empty($this -> usu_contrasena_tipo))
			{
				switch($this -> usu_contrasena_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> usu_contrasena;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> usu_contrasena."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_activo) and !is_null($this -> usu_activo))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="usu_activo";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> usu_activo_tipo) and !empty($this -> usu_activo_tipo))
			{
				switch($this -> usu_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> usu_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> usu_activo."'";
				
		}



		//Si el arreglo de campos tiene posiciones
		if(sizeof($sql_campos_insert))
		{
			//Armo el SQL para ejecutar el Insert
			$sql="INSERT INTO usuario(".implode($sql_campos_insert, ", ").")
							VALUES(".implode($sql_valores_insert, ", ").")";
		
			//Si la ejecucion es exitosa entonces devuelvo el codigo del registro insertado
			if($this -> getConexion() -> Execute($sql))
			{
				//Esto NO funciona para postgreSQL
				$ultimo_id=$this -> getConexion() -> Insert_ID();
				$this -> setUsuId($ultimo_id);
				
				//Si se encuentra habilitado el log entonces registro la auditoria
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $ultimo_id)
				{
					//Consulto la informacion que se inserto
					$usuario = $this -> consultarId($ultimo_id);
					$descripcion[]="usu_id = ".$usuario -> getUsuId();
					$descripcion[]="usu_usuario = ".$usuario -> getUsuUsuario();
					$descripcion[]="usu_nombres = ".$usuario -> getUsuNombres();
					$descripcion[]="usu_apellidos = ".$usuario -> getUsuApellidos();
					$descripcion[]="usu_contrasena = ".$usuario -> getUsuContrasena();
					$descripcion[]="usu_activo = ".$usuario -> getUsuActivo();
					
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("usuario");
					$objAuditoriaTabla->setAutTablaId($ultimo_id);
					$objAuditoriaTabla->setAutUsuId($objAuditoriaTabla -> obtenerUsuarioActual());
					$objAuditoriaTabla->setAutFecha("NOW()", "sql");
					$objAuditoriaTabla->setAutTransaccion("INSERTAR");
					$objAuditoriaTabla->setAutDescripcionNueva(implode(", ", $descripcion));
					$aut_id=$objAuditoriaTabla->insertar();
					
					if(!$aut_id)
					{
						echo "<b>Error al almacenar informacion en la tabla de auditoria_tabla</b><br/>";
					}
				}
				
				//return $ultimo_id;
				/*
				$sql="SELECT MAX(usu_id) AS insert_id FROM usuario";
				$rs = $this -> getConexion() -> Execute($sql);
				$row = $rs->FetchRow();
				//return $row["insert_id"];
				*/
			}
			//Sino imprimo el error generado
			else
			{
				echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
				$ultimo_id = false;
			}
		}
		
		return $ultimo_id;
	}
	
	/**
	 * Metodo para hacer actualizaciones a la entidad usuario. 
	 * @return integer registros afectados
	 */
	public function actualizar()
	{
		$registros_afectados = 0;
		//Defino el arreglo de los valores a actualizar
		$sql_update=array();
		//Descripcion para la auditoria
		$descripcion=array();
		$descripcion_antigua="";//Descripcion antigua
		$descripcion_nueva="";//Descripcion nueva
		
		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_id) and !is_null($this -> usu_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> usu_id_tipo) and !empty($this -> usu_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> usu_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="usu_id = ".$this -> usu_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="usu_id = '".$this -> usu_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_usuario) and !is_null($this -> usu_usuario))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> usu_usuario_tipo) and !empty($this -> usu_usuario_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> usu_usuario_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="usu_usuario = ".$this -> usu_usuario;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="usu_usuario = '".$this -> usu_usuario."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_nombres) and !is_null($this -> usu_nombres))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> usu_nombres_tipo) and !empty($this -> usu_nombres_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> usu_nombres_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="usu_nombres = ".$this -> usu_nombres;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="usu_nombres = '".$this -> usu_nombres."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_apellidos) and !is_null($this -> usu_apellidos))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> usu_apellidos_tipo) and !empty($this -> usu_apellidos_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> usu_apellidos_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="usu_apellidos = ".$this -> usu_apellidos;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="usu_apellidos = '".$this -> usu_apellidos."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_contrasena) and !is_null($this -> usu_contrasena))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> usu_contrasena_tipo) and !empty($this -> usu_contrasena_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> usu_contrasena_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="usu_contrasena = ".$this -> usu_contrasena;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="usu_contrasena = '".$this -> usu_contrasena."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> usu_activo) and !is_null($this -> usu_activo))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> usu_activo_tipo) and !empty($this -> usu_activo_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> usu_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="usu_activo = ".$this -> usu_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="usu_activo = '".$this -> usu_activo."'";
				
		}



		//Si el arreglo tiene posiciones
		if(sizeof($sql_update))
		{
			//Si se encuentra habilitado el log entonces registro la auditoria
			if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
			{
				//Consulto la informacion actual antes de la actualizacion
				$usuario = $this -> consultarId($this -> getUsuId());
					$descripcion[]="usu_id = ".$usuario -> getUsuId();
					$descripcion[]="usu_usuario = ".$usuario -> getUsuUsuario();
					$descripcion[]="usu_nombres = ".$usuario -> getUsuNombres();
					$descripcion[]="usu_apellidos = ".$usuario -> getUsuApellidos();
					$descripcion[]="usu_contrasena = ".$usuario -> getUsuContrasena();
					$descripcion[]="usu_activo = ".$usuario -> getUsuActivo();
				$descripcion_antigua = implode(", ", $descripcion);
			}
			
			//Armo el SQL para actualizar
			$sql="UPDATE usuario SET  ".implode($sql_update, ", ")."  WHERE usu_id = ".$this -> getUsuId();
	
			//Si la ejecucion es exitosa entonces devuelvo el numero de registros afectados
			if($this -> getConexion() -> Execute($sql))
			{
				$registros_afectados=$this -> getConexion() -> Affected_Rows();
				
				//Si se actualizaron registros de la tabla
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $registros_afectados)
				{
					//Consulto la informacion que se registro luego de la actualizacion
					$descripcion=array();
					$usuario = $this -> consultarId($this -> getUsuId());
						$descripcion[]="usu_id = ".$usuario -> getUsuId();
					$descripcion[]="usu_usuario = ".$usuario -> getUsuUsuario();
					$descripcion[]="usu_nombres = ".$usuario -> getUsuNombres();
					$descripcion[]="usu_apellidos = ".$usuario -> getUsuApellidos();
					$descripcion[]="usu_contrasena = ".$usuario -> getUsuContrasena();
					$descripcion[]="usu_activo = ".$usuario -> getUsuActivo();
					$descripcion_nueva = implode(", ", $descripcion);
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("usuario");
					$objAuditoriaTabla->setAutTablaId($this -> getUsuId());
					$objAuditoriaTabla->setAutUsuId($objAuditoriaTabla -> obtenerUsuarioActual());
					$objAuditoriaTabla->setAutFecha("NOW()", "sql");
					$objAuditoriaTabla->setAutDescripcionAntigua($descripcion_antigua);
					$objAuditoriaTabla->setAutDescripcionNueva($descripcion_nueva);
					$objAuditoriaTabla->setAutTransaccion("ACTUALIZAR");
					$aut_id=$objAuditoriaTabla->insertar();
					
					if(!$aut_id)
					{
						echo "<b>Error al almacenar informacion en la tabla de auditoria_tabla</b><br/>";
					}
				}
				
				//return $registros_afectados;
			}
			//Sino imprimo el mensaje de error
			else
			{
				echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
				$registros_afectados = false;
			}
		}
		
		return $registros_afectados;
	}

	/**
	 * Metodo para hacer eliminaciones a la entidad usuario. 
	 * @return integer registros borrados
	 */
	public function eliminar()
	{
		$descripcion=array(); //array para almacenar la informacion de la entidad
		//Concateno el where para eliminar los registros de la entidad
		$sql="DELETE FROM usuario  WHERE usu_id = ".$this -> getUsuId();

		if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
		{
			//Consulto la informacion que se registro luego de la actualizacion
			$usuario = $this -> consultarId($this -> getUsuId());
					$descripcion[]="usu_id = ".$usuario -> getUsuId();
					$descripcion[]="usu_usuario = ".$usuario -> getUsuUsuario();
					$descripcion[]="usu_nombres = ".$usuario -> getUsuNombres();
					$descripcion[]="usu_apellidos = ".$usuario -> getUsuApellidos();
					$descripcion[]="usu_contrasena = ".$usuario -> getUsuContrasena();
					$descripcion[]="usu_activo = ".$usuario -> getUsuActivo();
			$descripcion_antigua = implode(", ", $descripcion);
		}
		
		//Si la ejecucion es exitosa entonces devuelvo el numero de registros borrados
		if($this -> getConexion() -> Execute($sql))
		{
			$registros_eliminados=$this -> getConexion() -> Affected_Rows();
			
			//Si se pudo eliminar el registro entonces registro la auditoria sobre la tabla
			if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $registros_eliminados)
			{
				/**
				 * instanciacion de la clase auditoria_tabla para la eliminacion de un registro
				 */
				$objAuditoriaTabla = new AuditoriaTabla();
				$objAuditoriaTabla->crearBD("sisgot_adodb");
				$objAuditoriaTabla->setAutTabla("usuario");
				$objAuditoriaTabla->setAutTablaId($this -> getUsuId());
				$objAuditoriaTabla->setAutUsuId($objAuditoriaTabla -> obtenerUsuarioActual());
				$objAuditoriaTabla->setAutFecha("NOW()", "sql");
				$objAuditoriaTabla->setAutDescripcionAntigua($descripcion_antigua);
				$objAuditoriaTabla->setAutDescripcionNueva("");
				$objAuditoriaTabla->setAutTransaccion("ELIMINAR");
				$aut_id=$objAuditoriaTabla->insertar();
				
				if(!$aut_id)
				{
					echo "<b>Error al almacenar informacion en la tabla de auditoria_tabla</b><br/>";
				}
			}
			
			return $registros_eliminados;
		}
		//Sino imprimo el mensaje de error
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";

		return 0;
	}


	/**
	 * Metodo para asignar el valor al atributo usu_id. 
	 * @param string $valor valor para el atributo usu_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setUsuId($valor, $tipo = "")
	{
		$this -> usu_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> usu_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo usu_id. 
	 * @return valor
	 */
	public function getUsuId()
	{
		return $this -> usu_id;
	}

	/**
	 * Metodo para asignar el valor al atributo usu_usuario. 
	 * @param string $valor valor para el atributo usu_usuario
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setUsuUsuario($valor, $tipo = "")
	{
		$this -> usu_usuario = $valor;
		
		if(!empty($tipo))
		{
			$this -> usu_usuario_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo usu_usuario. 
	 * @return valor
	 */
	public function getUsuUsuario()
	{
		return $this -> usu_usuario;
	}

	/**
	 * Metodo para asignar el valor al atributo usu_nombres. 
	 * @param string $valor valor para el atributo usu_nombres
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setUsuNombres($valor, $tipo = "")
	{
		$this -> usu_nombres = $valor;
		
		if(!empty($tipo))
		{
			$this -> usu_nombres_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo usu_nombres. 
	 * @return valor
	 */
	public function getUsuNombres()
	{
		return $this -> usu_nombres;
	}

	/**
	 * Metodo para asignar el valor al atributo usu_apellidos. 
	 * @param string $valor valor para el atributo usu_apellidos
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setUsuApellidos($valor, $tipo = "")
	{
		$this -> usu_apellidos = $valor;
		
		if(!empty($tipo))
		{
			$this -> usu_apellidos_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo usu_apellidos. 
	 * @return valor
	 */
	public function getUsuApellidos()
	{
		return $this -> usu_apellidos;
	}

	/**
	 * Metodo para asignar el valor al atributo usu_contrasena. 
	 * @param string $valor valor para el atributo usu_contrasena
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setUsuContrasena($valor, $tipo = "")
	{
		$this -> usu_contrasena = $valor;
		
		if(!empty($tipo))
		{
			$this -> usu_contrasena_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo usu_contrasena. 
	 * @return valor
	 */
	public function getUsuContrasena()
	{
		return $this -> usu_contrasena;
	}

	/**
	 * Metodo para asignar el valor al atributo usu_activo. 
	 * @param string $valor valor para el atributo usu_activo
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setUsuActivo($valor, $tipo = "")
	{
		$this -> usu_activo = $valor;
		
		if(!empty($tipo))
		{
			$this -> usu_activo_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo usu_activo. 
	 * @return valor
	 */
	public function getUsuActivo()
	{
		return $this -> usu_activo;
	}



	/**
	 * Metodo para asignar el valor al atributo auditoria_tabla. 
	 * @param bool $valor valor para el atributo auditoria_tabla
	 */
	public function setAuditoriaTabla($valor)
	{
		$this -> auditoria_tabla = $valor;
	}
	
	/**
	 * Metodo para obtener el valor del atributo auditoria_tabla. 
	 * @return valor
	 */
	public function getAuditoriaTabla()
	{
		return $this -> auditoria_tabla;
	}

	/**
	 * Metodo para asignar el valor al atributo conexion. 
	 * @param string $valor valor para el atributo conexion
	 */
	public function setConexion($valor)
	{
		$this -> conexion = $valor;
	}

	/**
	 * Metodo para obtener el valor del atributo conexion. 
	 * @return valor
	 */
	public function getConexion()
	{
		return $this -> conexion;
	}
}
?>