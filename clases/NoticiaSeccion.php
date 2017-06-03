<?php
/**
 * Clase NoticiaSeccion
 * 
 * Esta clase hace referencia a la entidad noticia_seccion de la base de datos
 * @author aocampo
 * @version 1.0
 * @since 2017-05-29 09:35:22
 */
Class NoticiaSeccion
{
	//Atributos de la clase
	private $conexion;
	private $auditoria_tabla;
	private $nts_id;
	private $nts_id_tipo;
	private $nts_nombre;
	private $nts_nombre_tipo;
	private $nts_activo;
	private $nts_activo_tipo;


	/** 
	 * Constructor de la clase
	 */
	public function __construct()
	{
	}			

	public function crear()
	{
		return new NoticiaSeccion();
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
	 * Metodo para hacer consultas a la entidad noticia_seccion
	 * @param string $where condicion para obtener los resultados
	 * @param integer $cantidad cantidad de registros deseados
	 * @param integer $inicio inicio de los registros deseados
	 * @param string $sql sql personalizado
	 * @return NoticiaSeccion $objetos arreglo de objetos 
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
			$sql="SELECT principal.* FROM noticia_seccion AS principal ";
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
				$noticia_seccion=$this -> crear();
				$noticia_seccion -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("nts_id", $row))
					$noticia_seccion -> setNtsId($row["nts_id"]);
				else
					$noticia_seccion -> setNtsId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("nts_nombre", $row))
					$noticia_seccion -> setNtsNombre($row["nts_nombre"]);
				else
					$noticia_seccion -> setNtsNombre(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("nts_activo", $row))
					$noticia_seccion -> setNtsActivo($row["nts_activo"]);
				else
					$noticia_seccion -> setNtsActivo(null);


				//Asigno una posicion con el objeto asignado
				$objetos[]=$noticia_seccion;
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
	 * Metodo para hacer consultas a la entidad noticia_seccion por codigo de la llave primaria
	 * @param integer $id codigo de la llave primaria
	 * @return boolean bandera de ejecucion
	 */
	public function consultarId($id)
	{
		$noticia_seccion=false;
		$sql="SELECT principal.* FROM noticia_seccion AS principal WHERE nts_id = ".$id;
		$rs = $this -> getConexion() -> Execute($sql);

		if($rs)
		{
			while ($row = $rs->FetchRow())
			{
				$noticia_seccion=$this -> crear();
				$noticia_seccion -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("nts_id", $row))
					$noticia_seccion -> setNtsId($row["nts_id"]);
				else
					$noticia_seccion -> setNtsId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("nts_nombre", $row))
					$noticia_seccion -> setNtsNombre($row["nts_nombre"]);
				else
					$noticia_seccion -> setNtsNombre(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("nts_activo", $row))
					$noticia_seccion -> setNtsActivo($row["nts_activo"]);
				else
					$noticia_seccion -> setNtsActivo(null);


			}

			$rs -> Close();
			return $noticia_seccion;
		}
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
		
		return false;
	}

	/**
	 * Metodo para hacer inserciones a la entidad noticia_seccion. 
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
		if(isset($this -> nts_nombre) and !is_null($this -> nts_nombre))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="nts_nombre";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> nts_nombre_tipo) and !empty($this -> nts_nombre_tipo))
			{
				switch($this -> nts_nombre_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> nts_nombre;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> nts_nombre."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> nts_activo) and !is_null($this -> nts_activo))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="nts_activo";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> nts_activo_tipo) and !empty($this -> nts_activo_tipo))
			{
				switch($this -> nts_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> nts_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> nts_activo."'";
				
		}



		//Si el arreglo de campos tiene posiciones
		if(sizeof($sql_campos_insert))
		{
			//Armo el SQL para ejecutar el Insert
			$sql="INSERT INTO noticia_seccion(".implode($sql_campos_insert, ", ").")
							VALUES(".implode($sql_valores_insert, ", ").")";
		
			//Si la ejecucion es exitosa entonces devuelvo el codigo del registro insertado
			if($this -> getConexion() -> Execute($sql))
			{
				//Esto NO funciona para postgreSQL
				$ultimo_id=$this -> getConexion() -> Insert_ID();
				$this -> setNtsId($ultimo_id);
				
				//Si se encuentra habilitado el log entonces registro la auditoria
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $ultimo_id)
				{
					//Consulto la informacion que se inserto
					$noticia_seccion = $this -> consultarId($ultimo_id);
					$descripcion[]="nts_id = ".$noticia_seccion -> getNtsId();
					$descripcion[]="nts_nombre = ".$noticia_seccion -> getNtsNombre();
					$descripcion[]="nts_activo = ".$noticia_seccion -> getNtsActivo();
					
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("noticia_seccion");
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
				$sql="SELECT MAX(nts_id) AS insert_id FROM noticia_seccion";
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
	 * Metodo para hacer actualizaciones a la entidad noticia_seccion. 
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
		if(isset($this -> nts_id) and !is_null($this -> nts_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> nts_id_tipo) and !empty($this -> nts_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> nts_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="nts_id = ".$this -> nts_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="nts_id = '".$this -> nts_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> nts_nombre) and !is_null($this -> nts_nombre))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> nts_nombre_tipo) and !empty($this -> nts_nombre_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> nts_nombre_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="nts_nombre = ".$this -> nts_nombre;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="nts_nombre = '".$this -> nts_nombre."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> nts_activo) and !is_null($this -> nts_activo))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> nts_activo_tipo) and !empty($this -> nts_activo_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> nts_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="nts_activo = ".$this -> nts_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="nts_activo = '".$this -> nts_activo."'";
				
		}



		//Si el arreglo tiene posiciones
		if(sizeof($sql_update))
		{
			//Si se encuentra habilitado el log entonces registro la auditoria
			if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
			{
				//Consulto la informacion actual antes de la actualizacion
				$noticia_seccion = $this -> consultarId($this -> getNtsId());
					$descripcion[]="nts_id = ".$noticia_seccion -> getNtsId();
					$descripcion[]="nts_nombre = ".$noticia_seccion -> getNtsNombre();
					$descripcion[]="nts_activo = ".$noticia_seccion -> getNtsActivo();
				$descripcion_antigua = implode(", ", $descripcion);
			}
			
			//Armo el SQL para actualizar
			$sql="UPDATE noticia_seccion SET  ".implode($sql_update, ", ")."  WHERE nts_id = ".$this -> getNtsId();
	
			//Si la ejecucion es exitosa entonces devuelvo el numero de registros afectados
			if($this -> getConexion() -> Execute($sql))
			{
				$registros_afectados=$this -> getConexion() -> Affected_Rows();
				
				//Si se actualizaron registros de la tabla
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $registros_afectados)
				{
					//Consulto la informacion que se registro luego de la actualizacion
					$descripcion=array();
					$noticia_seccion = $this -> consultarId($this -> getNtsId());
						$descripcion[]="nts_id = ".$noticia_seccion -> getNtsId();
					$descripcion[]="nts_nombre = ".$noticia_seccion -> getNtsNombre();
					$descripcion[]="nts_activo = ".$noticia_seccion -> getNtsActivo();
					$descripcion_nueva = implode(", ", $descripcion);
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("noticia_seccion");
					$objAuditoriaTabla->setAutTablaId($this -> getNtsId());
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
	 * Metodo para hacer eliminaciones a la entidad noticia_seccion. 
	 * @return integer registros borrados
	 */
	public function eliminar()
	{
		$descripcion=array(); //array para almacenar la informacion de la entidad
		//Concateno el where para eliminar los registros de la entidad
		$sql="DELETE FROM noticia_seccion  WHERE nts_id = ".$this -> getNtsId();

		if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
		{
			//Consulto la informacion que se registro luego de la actualizacion
			$noticia_seccion = $this -> consultarId($this -> getNtsId());
					$descripcion[]="nts_id = ".$noticia_seccion -> getNtsId();
					$descripcion[]="nts_nombre = ".$noticia_seccion -> getNtsNombre();
					$descripcion[]="nts_activo = ".$noticia_seccion -> getNtsActivo();
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
				$objAuditoriaTabla->setAutTabla("noticia_seccion");
				$objAuditoriaTabla->setAutTablaId($this -> getNtsId());
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
	 * Metodo para asignar el valor al atributo nts_id. 
	 * @param string $valor valor para el atributo nts_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNtsId($valor, $tipo = "")
	{
		$this -> nts_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> nts_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo nts_id. 
	 * @return valor
	 */
	public function getNtsId()
	{
		return $this -> nts_id;
	}

	/**
	 * Metodo para asignar el valor al atributo nts_nombre. 
	 * @param string $valor valor para el atributo nts_nombre
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNtsNombre($valor, $tipo = "")
	{
		$this -> nts_nombre = $valor;
		
		if(!empty($tipo))
		{
			$this -> nts_nombre_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo nts_nombre. 
	 * @return valor
	 */
	public function getNtsNombre()
	{
		return $this -> nts_nombre;
	}

	/**
	 * Metodo para asignar el valor al atributo nts_activo. 
	 * @param string $valor valor para el atributo nts_activo
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNtsActivo($valor, $tipo = "")
	{
		$this -> nts_activo = $valor;
		
		if(!empty($tipo))
		{
			$this -> nts_activo_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo nts_activo. 
	 * @return valor
	 */
	public function getNtsActivo()
	{
		return $this -> nts_activo;
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