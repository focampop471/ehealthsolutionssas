<?php
/**
 * Clase Producto
 * 
 * Esta clase hace referencia a la entidad producto de la base de datos
 * @author aocampo
 * @version 1.0
 * @since 2017-05-29 10:34:17
 */
Class Producto
{
	//Atributos de la clase
	private $conexion;
	private $auditoria_tabla;
	private $prd_id;
	private $prd_id_tipo;
	private $prd_nombre;
	private $prd_nombre_tipo;
	private $prd_descripcion;
	private $prd_descripcion_tipo;
	private $prd_texto;
	private $prd_texto_tipo;
	private $prd_imagen;
	private $prd_imagen_tipo;
	private $prd_activo;
	private $prd_activo_tipo;


	/** 
	 * Constructor de la clase
	 */
	public function __construct()
	{
	}			

	public function crear()
	{
		return new Producto();
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
	 * Metodo para hacer consultas a la entidad producto
	 * @param string $where condicion para obtener los resultados
	 * @param integer $cantidad cantidad de registros deseados
	 * @param integer $inicio inicio de los registros deseados
	 * @param string $sql sql personalizado
	 * @return Producto $objetos arreglo de objetos 
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
			$sql="SELECT principal.* FROM producto AS principal ";
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
				$producto=$this -> crear();
				$producto -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_id", $row))
					$producto -> setPrdId($row["prd_id"]);
				else
					$producto -> setPrdId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_nombre", $row))
					$producto -> setPrdNombre($row["prd_nombre"]);
				else
					$producto -> setPrdNombre(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_descripcion", $row))
					$producto -> setPrdDescripcion($row["prd_descripcion"]);
				else
					$producto -> setPrdDescripcion(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_texto", $row))
					$producto -> setPrdTexto($row["prd_texto"]);
				else
					$producto -> setPrdTexto(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_imagen", $row))
					$producto -> setPrdImagen($row["prd_imagen"]);
				else
					$producto -> setPrdImagen(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_activo", $row))
					$producto -> setPrdActivo($row["prd_activo"]);
				else
					$producto -> setPrdActivo(null);


				//Asigno una posicion con el objeto asignado
				$objetos[]=$producto;
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
	 * Metodo para hacer consultas a la entidad producto por codigo de la llave primaria
	 * @param integer $id codigo de la llave primaria
	 * @return boolean bandera de ejecucion
	 */
	public function consultarId($id)
	{
		$producto=false;
		$sql="SELECT principal.* FROM producto AS principal WHERE prd_id = ".$id;
		$rs = $this -> getConexion() -> Execute($sql);

		if($rs)
		{
			while ($row = $rs->FetchRow())
			{
				$producto=$this -> crear();
				$producto -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_id", $row))
					$producto -> setPrdId($row["prd_id"]);
				else
					$producto -> setPrdId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_nombre", $row))
					$producto -> setPrdNombre($row["prd_nombre"]);
				else
					$producto -> setPrdNombre(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_descripcion", $row))
					$producto -> setPrdDescripcion($row["prd_descripcion"]);
				else
					$producto -> setPrdDescripcion(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_texto", $row))
					$producto -> setPrdTexto($row["prd_texto"]);
				else
					$producto -> setPrdTexto(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_imagen", $row))
					$producto -> setPrdImagen($row["prd_imagen"]);
				else
					$producto -> setPrdImagen(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("prd_activo", $row))
					$producto -> setPrdActivo($row["prd_activo"]);
				else
					$producto -> setPrdActivo(null);


			}

			$rs -> Close();
			return $producto;
		}
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
		
		return false;
	}

	/**
	 * Metodo para hacer inserciones a la entidad producto. 
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
		if(isset($this -> prd_nombre) and !is_null($this -> prd_nombre))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="prd_nombre";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> prd_nombre_tipo) and !empty($this -> prd_nombre_tipo))
			{
				switch($this -> prd_nombre_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> prd_nombre;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> prd_nombre."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_descripcion) and !is_null($this -> prd_descripcion))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="prd_descripcion";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> prd_descripcion_tipo) and !empty($this -> prd_descripcion_tipo))
			{
				switch($this -> prd_descripcion_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> prd_descripcion;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> prd_descripcion."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_texto) and !is_null($this -> prd_texto))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="prd_texto";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> prd_texto_tipo) and !empty($this -> prd_texto_tipo))
			{
				switch($this -> prd_texto_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> prd_texto;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> prd_texto."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_imagen) and !is_null($this -> prd_imagen))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="prd_imagen";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> prd_imagen_tipo) and !empty($this -> prd_imagen_tipo))
			{
				switch($this -> prd_imagen_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> prd_imagen;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> prd_imagen."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_activo) and !is_null($this -> prd_activo))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="prd_activo";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> prd_activo_tipo) and !empty($this -> prd_activo_tipo))
			{
				switch($this -> prd_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> prd_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> prd_activo."'";
				
		}



		//Si el arreglo de campos tiene posiciones
		if(sizeof($sql_campos_insert))
		{
			//Armo el SQL para ejecutar el Insert
			$sql="INSERT INTO producto(".implode($sql_campos_insert, ", ").")
							VALUES(".implode($sql_valores_insert, ", ").")";
		
			//Si la ejecucion es exitosa entonces devuelvo el codigo del registro insertado
			if($this -> getConexion() -> Execute($sql))
			{
				//Esto NO funciona para postgreSQL
				$ultimo_id=$this -> getConexion() -> Insert_ID();
				$this -> setPrdId($ultimo_id);
				
				//Si se encuentra habilitado el log entonces registro la auditoria
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $ultimo_id)
				{
					//Consulto la informacion que se inserto
					$producto = $this -> consultarId($ultimo_id);
					$descripcion[]="prd_id = ".$producto -> getPrdId();
					$descripcion[]="prd_nombre = ".$producto -> getPrdNombre();
					$descripcion[]="prd_descripcion = ".$producto -> getPrdDescripcion();
					$descripcion[]="prd_texto = ".$producto -> getPrdTexto();
					$descripcion[]="prd_imagen = ".$producto -> getPrdImagen();
					$descripcion[]="prd_activo = ".$producto -> getPrdActivo();
					
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("producto");
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
				$sql="SELECT MAX(prd_id) AS insert_id FROM producto";
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
	 * Metodo para hacer actualizaciones a la entidad producto. 
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
		if(isset($this -> prd_id) and !is_null($this -> prd_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> prd_id_tipo) and !empty($this -> prd_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> prd_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="prd_id = ".$this -> prd_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="prd_id = '".$this -> prd_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_nombre) and !is_null($this -> prd_nombre))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> prd_nombre_tipo) and !empty($this -> prd_nombre_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> prd_nombre_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="prd_nombre = ".$this -> prd_nombre;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="prd_nombre = '".$this -> prd_nombre."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_descripcion) and !is_null($this -> prd_descripcion))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> prd_descripcion_tipo) and !empty($this -> prd_descripcion_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> prd_descripcion_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="prd_descripcion = ".$this -> prd_descripcion;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="prd_descripcion = '".$this -> prd_descripcion."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_texto) and !is_null($this -> prd_texto))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> prd_texto_tipo) and !empty($this -> prd_texto_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> prd_texto_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="prd_texto = ".$this -> prd_texto;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="prd_texto = '".$this -> prd_texto."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_imagen) and !is_null($this -> prd_imagen))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> prd_imagen_tipo) and !empty($this -> prd_imagen_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> prd_imagen_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="prd_imagen = ".$this -> prd_imagen;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="prd_imagen = '".$this -> prd_imagen."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> prd_activo) and !is_null($this -> prd_activo))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> prd_activo_tipo) and !empty($this -> prd_activo_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> prd_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="prd_activo = ".$this -> prd_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="prd_activo = '".$this -> prd_activo."'";
				
		}



		//Si el arreglo tiene posiciones
		if(sizeof($sql_update))
		{
			//Si se encuentra habilitado el log entonces registro la auditoria
			if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
			{
				//Consulto la informacion actual antes de la actualizacion
				$producto = $this -> consultarId($this -> getPrdId());
					$descripcion[]="prd_id = ".$producto -> getPrdId();
					$descripcion[]="prd_nombre = ".$producto -> getPrdNombre();
					$descripcion[]="prd_descripcion = ".$producto -> getPrdDescripcion();
					$descripcion[]="prd_texto = ".$producto -> getPrdTexto();
					$descripcion[]="prd_imagen = ".$producto -> getPrdImagen();
					$descripcion[]="prd_activo = ".$producto -> getPrdActivo();
				$descripcion_antigua = implode(", ", $descripcion);
			}
			
			//Armo el SQL para actualizar
			$sql="UPDATE producto SET  ".implode($sql_update, ", ")."  WHERE prd_id = ".$this -> getPrdId();
	
			//Si la ejecucion es exitosa entonces devuelvo el numero de registros afectados
			if($this -> getConexion() -> Execute($sql))
			{
				$registros_afectados=$this -> getConexion() -> Affected_Rows();
				
				//Si se actualizaron registros de la tabla
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $registros_afectados)
				{
					//Consulto la informacion que se registro luego de la actualizacion
					$descripcion=array();
					$producto = $this -> consultarId($this -> getPrdId());
						$descripcion[]="prd_id = ".$producto -> getPrdId();
					$descripcion[]="prd_nombre = ".$producto -> getPrdNombre();
					$descripcion[]="prd_descripcion = ".$producto -> getPrdDescripcion();
					$descripcion[]="prd_texto = ".$producto -> getPrdTexto();
					$descripcion[]="prd_imagen = ".$producto -> getPrdImagen();
					$descripcion[]="prd_activo = ".$producto -> getPrdActivo();
					$descripcion_nueva = implode(", ", $descripcion);
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("producto");
					$objAuditoriaTabla->setAutTablaId($this -> getPrdId());
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
	 * Metodo para hacer eliminaciones a la entidad producto. 
	 * @return integer registros borrados
	 */
	public function eliminar()
	{
		$descripcion=array(); //array para almacenar la informacion de la entidad
		//Concateno el where para eliminar los registros de la entidad
		$sql="DELETE FROM producto  WHERE prd_id = ".$this -> getPrdId();

		if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
		{
			//Consulto la informacion que se registro luego de la actualizacion
			$producto = $this -> consultarId($this -> getPrdId());
					$descripcion[]="prd_id = ".$producto -> getPrdId();
					$descripcion[]="prd_nombre = ".$producto -> getPrdNombre();
					$descripcion[]="prd_descripcion = ".$producto -> getPrdDescripcion();
					$descripcion[]="prd_texto = ".$producto -> getPrdTexto();
					$descripcion[]="prd_imagen = ".$producto -> getPrdImagen();
					$descripcion[]="prd_activo = ".$producto -> getPrdActivo();
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
				$objAuditoriaTabla->setAutTabla("producto");
				$objAuditoriaTabla->setAutTablaId($this -> getPrdId());
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
	 * Metodo para asignar el valor al atributo prd_id. 
	 * @param string $valor valor para el atributo prd_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setPrdId($valor, $tipo = "")
	{
		$this -> prd_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> prd_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo prd_id. 
	 * @return valor
	 */
	public function getPrdId()
	{
		return $this -> prd_id;
	}

	/**
	 * Metodo para asignar el valor al atributo prd_nombre. 
	 * @param string $valor valor para el atributo prd_nombre
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setPrdNombre($valor, $tipo = "")
	{
		$this -> prd_nombre = $valor;
		
		if(!empty($tipo))
		{
			$this -> prd_nombre_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo prd_nombre. 
	 * @return valor
	 */
	public function getPrdNombre()
	{
		return $this -> prd_nombre;
	}

	/**
	 * Metodo para asignar el valor al atributo prd_descripcion. 
	 * @param string $valor valor para el atributo prd_descripcion
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setPrdDescripcion($valor, $tipo = "")
	{
		$this -> prd_descripcion = $valor;
		
		if(!empty($tipo))
		{
			$this -> prd_descripcion_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo prd_descripcion. 
	 * @return valor
	 */
	public function getPrdDescripcion()
	{
		return $this -> prd_descripcion;
	}

	/**
	 * Metodo para asignar el valor al atributo prd_texto. 
	 * @param string $valor valor para el atributo prd_texto
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setPrdTexto($valor, $tipo = "")
	{
		$this -> prd_texto = $valor;
		
		if(!empty($tipo))
		{
			$this -> prd_texto_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo prd_texto. 
	 * @return valor
	 */
	public function getPrdTexto()
	{
		return $this -> prd_texto;
	}

	/**
	 * Metodo para asignar el valor al atributo prd_imagen. 
	 * @param string $valor valor para el atributo prd_imagen
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setPrdImagen($valor, $tipo = "")
	{
		$this -> prd_imagen = $valor;
		
		if(!empty($tipo))
		{
			$this -> prd_imagen_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo prd_imagen. 
	 * @return valor
	 */
	public function getPrdImagen()
	{
		return $this -> prd_imagen;
	}

	/**
	 * Metodo para asignar el valor al atributo prd_activo. 
	 * @param string $valor valor para el atributo prd_activo
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setPrdActivo($valor, $tipo = "")
	{
		$this -> prd_activo = $valor;
		
		if(!empty($tipo))
		{
			$this -> prd_activo_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo prd_activo. 
	 * @return valor
	 */
	public function getPrdActivo()
	{
		return $this -> prd_activo;
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