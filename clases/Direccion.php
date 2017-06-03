<?php
/**
 * Clase Direccion
 * 
 * Esta clase hace referencia a la entidad direccion de la base de datos
 * @author aocampo
 * @version 1.0
 * @since 2017-06-02 21:51:36
 */
Class Direccion
{
	//Atributos de la clase
	private $conexion;
	private $auditoria_tabla;
	private $dir_id;
	private $dir_id_tipo;
	private $dir_nombres;
	private $dir_nombres_tipo;
	private $dir_apellidos;
	private $dir_apellidos_tipo;
	private $dir_correo;
	private $dir_correo_tipo;
	private $dir_telefono;
	private $dir_telefono_tipo;
	private $dir_celular;
	private $dir_celular_tipo;
	private $dir_direccion;
	private $dir_direccion_tipo;
	private $dir_ciudad;
	private $dir_ciudad_tipo;
	private $dir_departamento;
	private $dir_departamento_tipo;


	/** 
	 * Constructor de la clase
	 */
	public function __construct()
	{
	}			

	public function crear()
	{
		return new Direccion();
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
	 * Metodo para hacer consultas a la entidad direccion
	 * @param string $where condicion para obtener los resultados
	 * @param integer $cantidad cantidad de registros deseados
	 * @param integer $inicio inicio de los registros deseados
	 * @param string $sql sql personalizado
	 * @return Direccion $objetos arreglo de objetos 
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
			$sql="SELECT principal.* FROM direccion AS principal ";
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
				$direccion=$this -> crear();
				$direccion -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_id", $row))
					$direccion -> setDirId($row["dir_id"]);
				else
					$direccion -> setDirId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_nombres", $row))
					$direccion -> setDirNombres($row["dir_nombres"]);
				else
					$direccion -> setDirNombres(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_apellidos", $row))
					$direccion -> setDirApellidos($row["dir_apellidos"]);
				else
					$direccion -> setDirApellidos(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_correo", $row))
					$direccion -> setDirCorreo($row["dir_correo"]);
				else
					$direccion -> setDirCorreo(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_telefono", $row))
					$direccion -> setDirTelefono($row["dir_telefono"]);
				else
					$direccion -> setDirTelefono(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_celular", $row))
					$direccion -> setDirCelular($row["dir_celular"]);
				else
					$direccion -> setDirCelular(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_direccion", $row))
					$direccion -> setDirDireccion($row["dir_direccion"]);
				else
					$direccion -> setDirDireccion(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_ciudad", $row))
					$direccion -> setDirCiudad($row["dir_ciudad"]);
				else
					$direccion -> setDirCiudad(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_departamento", $row))
					$direccion -> setDirDepartamento($row["dir_departamento"]);
				else
					$direccion -> setDirDepartamento(null);


				//Asigno una posicion con el objeto asignado
				$objetos[]=$direccion;
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
	 * Metodo para hacer consultas a la entidad direccion por codigo de la llave primaria
	 * @param integer $id codigo de la llave primaria
	 * @return boolean bandera de ejecucion
	 */
	public function consultarId($id)
	{
		$direccion=false;
		$sql="SELECT principal.* FROM direccion AS principal WHERE dir_id = ".$id;
		$rs = $this -> getConexion() -> Execute($sql);

		if($rs)
		{
			while ($row = $rs->FetchRow())
			{
				$direccion=$this -> crear();
				$direccion -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_id", $row))
					$direccion -> setDirId($row["dir_id"]);
				else
					$direccion -> setDirId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_nombres", $row))
					$direccion -> setDirNombres($row["dir_nombres"]);
				else
					$direccion -> setDirNombres(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_apellidos", $row))
					$direccion -> setDirApellidos($row["dir_apellidos"]);
				else
					$direccion -> setDirApellidos(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_correo", $row))
					$direccion -> setDirCorreo($row["dir_correo"]);
				else
					$direccion -> setDirCorreo(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_telefono", $row))
					$direccion -> setDirTelefono($row["dir_telefono"]);
				else
					$direccion -> setDirTelefono(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_celular", $row))
					$direccion -> setDirCelular($row["dir_celular"]);
				else
					$direccion -> setDirCelular(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_direccion", $row))
					$direccion -> setDirDireccion($row["dir_direccion"]);
				else
					$direccion -> setDirDireccion(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_ciudad", $row))
					$direccion -> setDirCiudad($row["dir_ciudad"]);
				else
					$direccion -> setDirCiudad(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("dir_departamento", $row))
					$direccion -> setDirDepartamento($row["dir_departamento"]);
				else
					$direccion -> setDirDepartamento(null);


			}

			$rs -> Close();
			return $direccion;
		}
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
		
		return false;
	}

	/**
	 * Metodo para hacer inserciones a la entidad direccion. 
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
		if(isset($this -> dir_nombres) and !is_null($this -> dir_nombres))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_nombres";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_nombres_tipo) and !empty($this -> dir_nombres_tipo))
			{
				switch($this -> dir_nombres_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_nombres;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_nombres."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_apellidos) and !is_null($this -> dir_apellidos))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_apellidos";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_apellidos_tipo) and !empty($this -> dir_apellidos_tipo))
			{
				switch($this -> dir_apellidos_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_apellidos;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_apellidos."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_correo) and !is_null($this -> dir_correo))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_correo";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_correo_tipo) and !empty($this -> dir_correo_tipo))
			{
				switch($this -> dir_correo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_correo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_correo."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_telefono) and !is_null($this -> dir_telefono))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_telefono";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_telefono_tipo) and !empty($this -> dir_telefono_tipo))
			{
				switch($this -> dir_telefono_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_telefono;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_telefono."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_celular) and !is_null($this -> dir_celular))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_celular";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_celular_tipo) and !empty($this -> dir_celular_tipo))
			{
				switch($this -> dir_celular_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_celular;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_celular."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_direccion) and !is_null($this -> dir_direccion))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_direccion";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_direccion_tipo) and !empty($this -> dir_direccion_tipo))
			{
				switch($this -> dir_direccion_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_direccion;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_direccion."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_ciudad) and !is_null($this -> dir_ciudad))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_ciudad";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_ciudad_tipo) and !empty($this -> dir_ciudad_tipo))
			{
				switch($this -> dir_ciudad_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_ciudad;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_ciudad."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_departamento) and !is_null($this -> dir_departamento))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="dir_departamento";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> dir_departamento_tipo) and !empty($this -> dir_departamento_tipo))
			{
				switch($this -> dir_departamento_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> dir_departamento;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> dir_departamento."'";
				
		}



		//Si el arreglo de campos tiene posiciones
		if(sizeof($sql_campos_insert))
		{
			//Armo el SQL para ejecutar el Insert
			$sql="INSERT INTO direccion(".implode($sql_campos_insert, ", ").")
							VALUES(".implode($sql_valores_insert, ", ").")";
		
			//Si la ejecucion es exitosa entonces devuelvo el codigo del registro insertado
			if($this -> getConexion() -> Execute($sql))
			{
				//Esto NO funciona para postgreSQL
				$ultimo_id=$this -> getConexion() -> Insert_ID();
				$this -> setDirId($ultimo_id);
				
				//Si se encuentra habilitado el log entonces registro la auditoria
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $ultimo_id)
				{
					//Consulto la informacion que se inserto
					$direccion = $this -> consultarId($ultimo_id);
					$descripcion[]="dir_id = ".$direccion -> getDirId();
					$descripcion[]="dir_nombres = ".$direccion -> getDirNombres();
					$descripcion[]="dir_apellidos = ".$direccion -> getDirApellidos();
					$descripcion[]="dir_correo = ".$direccion -> getDirCorreo();
					$descripcion[]="dir_telefono = ".$direccion -> getDirTelefono();
					$descripcion[]="dir_celular = ".$direccion -> getDirCelular();
					$descripcion[]="dir_direccion = ".$direccion -> getDirDireccion();
					$descripcion[]="dir_ciudad = ".$direccion -> getDirCiudad();
					$descripcion[]="dir_departamento = ".$direccion -> getDirDepartamento();
					
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("direccion");
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
				$sql="SELECT MAX(dir_id) AS insert_id FROM direccion";
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
	 * Metodo para hacer actualizaciones a la entidad direccion. 
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
		if(isset($this -> dir_id) and !is_null($this -> dir_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_id_tipo) and !empty($this -> dir_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_id = ".$this -> dir_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_id = '".$this -> dir_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_nombres) and !is_null($this -> dir_nombres))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_nombres_tipo) and !empty($this -> dir_nombres_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_nombres_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_nombres = ".$this -> dir_nombres;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_nombres = '".$this -> dir_nombres."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_apellidos) and !is_null($this -> dir_apellidos))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_apellidos_tipo) and !empty($this -> dir_apellidos_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_apellidos_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_apellidos = ".$this -> dir_apellidos;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_apellidos = '".$this -> dir_apellidos."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_correo) and !is_null($this -> dir_correo))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_correo_tipo) and !empty($this -> dir_correo_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_correo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_correo = ".$this -> dir_correo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_correo = '".$this -> dir_correo."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_telefono) and !is_null($this -> dir_telefono))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_telefono_tipo) and !empty($this -> dir_telefono_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_telefono_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_telefono = ".$this -> dir_telefono;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_telefono = '".$this -> dir_telefono."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_celular) and !is_null($this -> dir_celular))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_celular_tipo) and !empty($this -> dir_celular_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_celular_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_celular = ".$this -> dir_celular;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_celular = '".$this -> dir_celular."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_direccion) and !is_null($this -> dir_direccion))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_direccion_tipo) and !empty($this -> dir_direccion_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_direccion_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_direccion = ".$this -> dir_direccion;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_direccion = '".$this -> dir_direccion."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_ciudad) and !is_null($this -> dir_ciudad))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_ciudad_tipo) and !empty($this -> dir_ciudad_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_ciudad_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_ciudad = ".$this -> dir_ciudad;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_ciudad = '".$this -> dir_ciudad."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> dir_departamento) and !is_null($this -> dir_departamento))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> dir_departamento_tipo) and !empty($this -> dir_departamento_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> dir_departamento_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="dir_departamento = ".$this -> dir_departamento;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="dir_departamento = '".$this -> dir_departamento."'";
				
		}



		//Si el arreglo tiene posiciones
		if(sizeof($sql_update))
		{
			//Si se encuentra habilitado el log entonces registro la auditoria
			if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
			{
				//Consulto la informacion actual antes de la actualizacion
				$direccion = $this -> consultarId($this -> getDirId());
					$descripcion[]="dir_id = ".$direccion -> getDirId();
					$descripcion[]="dir_nombres = ".$direccion -> getDirNombres();
					$descripcion[]="dir_apellidos = ".$direccion -> getDirApellidos();
					$descripcion[]="dir_correo = ".$direccion -> getDirCorreo();
					$descripcion[]="dir_telefono = ".$direccion -> getDirTelefono();
					$descripcion[]="dir_celular = ".$direccion -> getDirCelular();
					$descripcion[]="dir_direccion = ".$direccion -> getDirDireccion();
					$descripcion[]="dir_ciudad = ".$direccion -> getDirCiudad();
					$descripcion[]="dir_departamento = ".$direccion -> getDirDepartamento();
				$descripcion_antigua = implode(", ", $descripcion);
			}
			
			//Armo el SQL para actualizar
			$sql="UPDATE direccion SET  ".implode($sql_update, ", ")."  WHERE dir_id = ".$this -> getDirId();
	
			//Si la ejecucion es exitosa entonces devuelvo el numero de registros afectados
			if($this -> getConexion() -> Execute($sql))
			{
				$registros_afectados=$this -> getConexion() -> Affected_Rows();
				
				//Si se actualizaron registros de la tabla
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $registros_afectados)
				{
					//Consulto la informacion que se registro luego de la actualizacion
					$descripcion=array();
					$direccion = $this -> consultarId($this -> getDirId());
						$descripcion[]="dir_id = ".$direccion -> getDirId();
					$descripcion[]="dir_nombres = ".$direccion -> getDirNombres();
					$descripcion[]="dir_apellidos = ".$direccion -> getDirApellidos();
					$descripcion[]="dir_correo = ".$direccion -> getDirCorreo();
					$descripcion[]="dir_telefono = ".$direccion -> getDirTelefono();
					$descripcion[]="dir_celular = ".$direccion -> getDirCelular();
					$descripcion[]="dir_direccion = ".$direccion -> getDirDireccion();
					$descripcion[]="dir_ciudad = ".$direccion -> getDirCiudad();
					$descripcion[]="dir_departamento = ".$direccion -> getDirDepartamento();
					$descripcion_nueva = implode(", ", $descripcion);
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("direccion");
					$objAuditoriaTabla->setAutTablaId($this -> getDirId());
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
	 * Metodo para hacer eliminaciones a la entidad direccion. 
	 * @return integer registros borrados
	 */
	public function eliminar()
	{
		$descripcion=array(); //array para almacenar la informacion de la entidad
		//Concateno el where para eliminar los registros de la entidad
		$sql="DELETE FROM direccion  WHERE dir_id = ".$this -> getDirId();

		if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
		{
			//Consulto la informacion que se registro luego de la actualizacion
			$direccion = $this -> consultarId($this -> getDirId());
					$descripcion[]="dir_id = ".$direccion -> getDirId();
					$descripcion[]="dir_nombres = ".$direccion -> getDirNombres();
					$descripcion[]="dir_apellidos = ".$direccion -> getDirApellidos();
					$descripcion[]="dir_correo = ".$direccion -> getDirCorreo();
					$descripcion[]="dir_telefono = ".$direccion -> getDirTelefono();
					$descripcion[]="dir_celular = ".$direccion -> getDirCelular();
					$descripcion[]="dir_direccion = ".$direccion -> getDirDireccion();
					$descripcion[]="dir_ciudad = ".$direccion -> getDirCiudad();
					$descripcion[]="dir_departamento = ".$direccion -> getDirDepartamento();
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
				$objAuditoriaTabla->setAutTabla("direccion");
				$objAuditoriaTabla->setAutTablaId($this -> getDirId());
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
	 * Metodo para asignar el valor al atributo dir_id. 
	 * @param string $valor valor para el atributo dir_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirId($valor, $tipo = "")
	{
		$this -> dir_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_id. 
	 * @return valor
	 */
	public function getDirId()
	{
		return $this -> dir_id;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_nombres. 
	 * @param string $valor valor para el atributo dir_nombres
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirNombres($valor, $tipo = "")
	{
		$this -> dir_nombres = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_nombres_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_nombres. 
	 * @return valor
	 */
	public function getDirNombres()
	{
		return $this -> dir_nombres;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_apellidos. 
	 * @param string $valor valor para el atributo dir_apellidos
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirApellidos($valor, $tipo = "")
	{
		$this -> dir_apellidos = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_apellidos_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_apellidos. 
	 * @return valor
	 */
	public function getDirApellidos()
	{
		return $this -> dir_apellidos;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_correo. 
	 * @param string $valor valor para el atributo dir_correo
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirCorreo($valor, $tipo = "")
	{
		$this -> dir_correo = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_correo_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_correo. 
	 * @return valor
	 */
	public function getDirCorreo()
	{
		return $this -> dir_correo;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_telefono. 
	 * @param string $valor valor para el atributo dir_telefono
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirTelefono($valor, $tipo = "")
	{
		$this -> dir_telefono = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_telefono_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_telefono. 
	 * @return valor
	 */
	public function getDirTelefono()
	{
		return $this -> dir_telefono;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_celular. 
	 * @param string $valor valor para el atributo dir_celular
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirCelular($valor, $tipo = "")
	{
		$this -> dir_celular = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_celular_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_celular. 
	 * @return valor
	 */
	public function getDirCelular()
	{
		return $this -> dir_celular;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_direccion. 
	 * @param string $valor valor para el atributo dir_direccion
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirDireccion($valor, $tipo = "")
	{
		$this -> dir_direccion = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_direccion_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_direccion. 
	 * @return valor
	 */
	public function getDirDireccion()
	{
		return $this -> dir_direccion;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_ciudad. 
	 * @param string $valor valor para el atributo dir_ciudad
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirCiudad($valor, $tipo = "")
	{
		$this -> dir_ciudad = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_ciudad_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_ciudad. 
	 * @return valor
	 */
	public function getDirCiudad()
	{
		return $this -> dir_ciudad;
	}

	/**
	 * Metodo para asignar el valor al atributo dir_departamento. 
	 * @param string $valor valor para el atributo dir_departamento
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setDirDepartamento($valor, $tipo = "")
	{
		$this -> dir_departamento = $valor;
		
		if(!empty($tipo))
		{
			$this -> dir_departamento_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo dir_departamento. 
	 * @return valor
	 */
	public function getDirDepartamento()
	{
		return $this -> dir_departamento;
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