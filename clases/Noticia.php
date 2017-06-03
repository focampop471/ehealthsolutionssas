<?php
/**
 * Clase Noticia
 * 
 * Esta clase hace referencia a la entidad noticia de la base de datos
 * @author aocampo
 * @version 1.0
 * @since 2017-05-29 09:43:08
 */
Class Noticia
{
	//Atributos de la clase
	private $conexion;
	private $auditoria_tabla;
	private $not_id;
	private $not_id_tipo;
	private $not_fecha;
	private $not_fecha_tipo;
	private $not_titulo;
	private $not_titulo_tipo;
	private $not_lead;
	private $not_lead_tipo;
	private $not_texto;
	private $not_texto_tipo;
	private $not_activo;
	private $not_activo_tipo;
	private $not_nts_id;
	private $not_nts_id_tipo;
	private $not_usu_id;
	private $not_usu_id_tipo;


	/** 
	 * Constructor de la clase
	 */
	public function __construct()
	{
	}			

	public function crear()
	{
		return new Noticia();
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
	 * Metodo para hacer consultas a la entidad noticia
	 * @param string $where condicion para obtener los resultados
	 * @param integer $cantidad cantidad de registros deseados
	 * @param integer $inicio inicio de los registros deseados
	 * @param string $sql sql personalizado
	 * @return Noticia $objetos arreglo de objetos 
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
			$sql="SELECT principal.* FROM noticia AS principal ";
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
				$noticia=$this -> crear();
				$noticia -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_id", $row))
					$noticia -> setNotId($row["not_id"]);
				else
					$noticia -> setNotId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_fecha", $row))
					$noticia -> setNotFecha($row["not_fecha"]);
				else
					$noticia -> setNotFecha(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_titulo", $row))
					$noticia -> setNotTitulo($row["not_titulo"]);
				else
					$noticia -> setNotTitulo(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_lead", $row))
					$noticia -> setNotLead($row["not_lead"]);
				else
					$noticia -> setNotLead(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_texto", $row))
					$noticia -> setNotTexto($row["not_texto"]);
				else
					$noticia -> setNotTexto(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_activo", $row))
					$noticia -> setNotActivo($row["not_activo"]);
				else
					$noticia -> setNotActivo(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_nts_id", $row))
					$noticia -> setNotNtsId($row["not_nts_id"]);
				else
					$noticia -> setNotNtsId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_usu_id", $row))
					$noticia -> setNotUsuId($row["not_usu_id"]);
				else
					$noticia -> setNotUsuId(null);


				//Asigno una posicion con el objeto asignado
				$objetos[]=$noticia;
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
	 * Metodo para hacer consultas a la entidad noticia por codigo de la llave primaria
	 * @param integer $id codigo de la llave primaria
	 * @return boolean bandera de ejecucion
	 */
	public function consultarId($id)
	{
		$noticia=false;
		$sql="SELECT principal.* FROM noticia AS principal WHERE not_id = ".$id;
		$rs = $this -> getConexion() -> Execute($sql);

		if($rs)
		{
			while ($row = $rs->FetchRow())
			{
				$noticia=$this -> crear();
				$noticia -> setConexion($this -> getConexion());
								//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_id", $row))
					$noticia -> setNotId($row["not_id"]);
				else
					$noticia -> setNotId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_fecha", $row))
					$noticia -> setNotFecha($row["not_fecha"]);
				else
					$noticia -> setNotFecha(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_titulo", $row))
					$noticia -> setNotTitulo($row["not_titulo"]);
				else
					$noticia -> setNotTitulo(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_lead", $row))
					$noticia -> setNotLead($row["not_lead"]);
				else
					$noticia -> setNotLead(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_texto", $row))
					$noticia -> setNotTexto($row["not_texto"]);
				else
					$noticia -> setNotTexto(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_activo", $row))
					$noticia -> setNotActivo($row["not_activo"]);
				else
					$noticia -> setNotActivo(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_nts_id", $row))
					$noticia -> setNotNtsId($row["not_nts_id"]);
				else
					$noticia -> setNotNtsId(null);

				//Si el campo viene el recurso entonces lo asigno con el valor. De lo contrario le asigno un null
				if(array_key_exists("not_usu_id", $row))
					$noticia -> setNotUsuId($row["not_usu_id"]);
				else
					$noticia -> setNotUsuId(null);


			}

			$rs -> Close();
			return $noticia;
		}
		else
			echo $this -> getConexion() -> ErrorMsg()." <strong>SQL: ".$sql."<br/>En la linea ".__LINE__."<br/></strong>";
		
		return false;
	}

	/**
	 * Metodo para hacer inserciones a la entidad noticia. 
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
		if(isset($this -> not_fecha) and !is_null($this -> not_fecha))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_fecha";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_fecha_tipo) and !empty($this -> not_fecha_tipo))
			{
				switch($this -> not_fecha_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_fecha;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_fecha."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_titulo) and !is_null($this -> not_titulo))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_titulo";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_titulo_tipo) and !empty($this -> not_titulo_tipo))
			{
				switch($this -> not_titulo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_titulo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_titulo."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_lead) and !is_null($this -> not_lead))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_lead";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_lead_tipo) and !empty($this -> not_lead_tipo))
			{
				switch($this -> not_lead_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_lead;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_lead."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_texto) and !is_null($this -> not_texto))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_texto";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_texto_tipo) and !empty($this -> not_texto_tipo))
			{
				switch($this -> not_texto_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_texto;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_texto."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_activo) and !is_null($this -> not_activo))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_activo";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_activo_tipo) and !empty($this -> not_activo_tipo))
			{
				switch($this -> not_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_activo."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_nts_id) and !is_null($this -> not_nts_id))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_nts_id";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_nts_id_tipo) and !empty($this -> not_nts_id_tipo))
			{
				switch($this -> not_nts_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_nts_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_nts_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_usu_id) and !is_null($this -> not_usu_id))
		{
			//Lo agrego a los campos a insertar
			$sql_campos_insert[]="not_usu_id";
			
			//Si el tipo del campo ha sido definido evaluo su tipo
			if(isset($this -> not_usu_id_tipo) and !empty($this -> not_usu_id_tipo))
			{
				switch($this -> not_usu_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_valores_insert[]= $this -> not_usu_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el insert sea efectivo
			else
				$sql_valores_insert[]= "'".$this -> not_usu_id."'";
				
		}



		//Si el arreglo de campos tiene posiciones
		if(sizeof($sql_campos_insert))
		{
			//Armo el SQL para ejecutar el Insert
			$sql="INSERT INTO noticia(".implode($sql_campos_insert, ", ").")
							VALUES(".implode($sql_valores_insert, ", ").")";
		
			//Si la ejecucion es exitosa entonces devuelvo el codigo del registro insertado
			if($this -> getConexion() -> Execute($sql))
			{
				//Esto NO funciona para postgreSQL
				$ultimo_id=$this -> getConexion() -> Insert_ID();
				$this -> setNotId($ultimo_id);
				
				//Si se encuentra habilitado el log entonces registro la auditoria
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $ultimo_id)
				{
					//Consulto la informacion que se inserto
					$noticia = $this -> consultarId($ultimo_id);
					$descripcion[]="not_id = ".$noticia -> getNotId();
					$descripcion[]="not_fecha = ".$noticia -> getNotFecha();
					$descripcion[]="not_titulo = ".$noticia -> getNotTitulo();
					$descripcion[]="not_lead = ".$noticia -> getNotLead();
					$descripcion[]="not_texto = ".$noticia -> getNotTexto();
					$descripcion[]="not_activo = ".$noticia -> getNotActivo();
					$descripcion[]="not_nts_id = ".$noticia -> getNotNtsId();
					$descripcion[]="not_usu_id = ".$noticia -> getNotUsuId();
					
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("noticia");
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
				$sql="SELECT MAX(not_id) AS insert_id FROM noticia";
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
	 * Metodo para hacer actualizaciones a la entidad noticia. 
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
		if(isset($this -> not_id) and !is_null($this -> not_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_id_tipo) and !empty($this -> not_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_id = ".$this -> not_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_id = '".$this -> not_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_fecha) and !is_null($this -> not_fecha))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_fecha_tipo) and !empty($this -> not_fecha_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_fecha_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_fecha = ".$this -> not_fecha;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_fecha = '".$this -> not_fecha."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_titulo) and !is_null($this -> not_titulo))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_titulo_tipo) and !empty($this -> not_titulo_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_titulo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_titulo = ".$this -> not_titulo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_titulo = '".$this -> not_titulo."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_lead) and !is_null($this -> not_lead))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_lead_tipo) and !empty($this -> not_lead_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_lead_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_lead = ".$this -> not_lead;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_lead = '".$this -> not_lead."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_texto) and !is_null($this -> not_texto))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_texto_tipo) and !empty($this -> not_texto_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_texto_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_texto = ".$this -> not_texto;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_texto = '".$this -> not_texto."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_activo) and !is_null($this -> not_activo))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_activo_tipo) and !empty($this -> not_activo_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_activo_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_activo = ".$this -> not_activo;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_activo = '".$this -> not_activo."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_nts_id) and !is_null($this -> not_nts_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_nts_id_tipo) and !empty($this -> not_nts_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_nts_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_nts_id = ".$this -> not_nts_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_nts_id = '".$this -> not_nts_id."'";
				
		}

		//Si el campo ha sido asignado y es diferente a null entonces lo agrego al SQL 
		if(isset($this -> not_usu_id) and !is_null($this -> not_usu_id))
		{
			//Lo agrego a los campos a actualizar
			if(isset($this -> not_usu_id_tipo) and !empty($this -> not_usu_id_tipo))
			{
				//Si el tipo del campo ha sido definido evaluo su tipo
				switch($this -> not_usu_id_tipo)
				{
					//Si es de tipo SQL lo agrego tal cual viene porque es una instruccion SQL
					case "sql":
						$sql_update[]="not_usu_id = ".$this -> not_usu_id;
					break;
				}
			}
			//Sino ha sido definido le agrego comillas para que el update sea efectivo
			else
				$sql_update[]="not_usu_id = '".$this -> not_usu_id."'";
				
		}



		//Si el arreglo tiene posiciones
		if(sizeof($sql_update))
		{
			//Si se encuentra habilitado el log entonces registro la auditoria
			if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
			{
				//Consulto la informacion actual antes de la actualizacion
				$noticia = $this -> consultarId($this -> getNotId());
					$descripcion[]="not_id = ".$noticia -> getNotId();
					$descripcion[]="not_fecha = ".$noticia -> getNotFecha();
					$descripcion[]="not_titulo = ".$noticia -> getNotTitulo();
					$descripcion[]="not_lead = ".$noticia -> getNotLead();
					$descripcion[]="not_texto = ".$noticia -> getNotTexto();
					$descripcion[]="not_activo = ".$noticia -> getNotActivo();
					$descripcion[]="not_nts_id = ".$noticia -> getNotNtsId();
					$descripcion[]="not_usu_id = ".$noticia -> getNotUsuId();
				$descripcion_antigua = implode(", ", $descripcion);
			}
			
			//Armo el SQL para actualizar
			$sql="UPDATE noticia SET  ".implode($sql_update, ", ")."  WHERE not_id = ".$this -> getNotId();
	
			//Si la ejecucion es exitosa entonces devuelvo el numero de registros afectados
			if($this -> getConexion() -> Execute($sql))
			{
				$registros_afectados=$this -> getConexion() -> Affected_Rows();
				
				//Si se actualizaron registros de la tabla
				if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla and $registros_afectados)
				{
					//Consulto la informacion que se registro luego de la actualizacion
					$descripcion=array();
					$noticia = $this -> consultarId($this -> getNotId());
						$descripcion[]="not_id = ".$noticia -> getNotId();
					$descripcion[]="not_fecha = ".$noticia -> getNotFecha();
					$descripcion[]="not_titulo = ".$noticia -> getNotTitulo();
					$descripcion[]="not_lead = ".$noticia -> getNotLead();
					$descripcion[]="not_texto = ".$noticia -> getNotTexto();
					$descripcion[]="not_activo = ".$noticia -> getNotActivo();
					$descripcion[]="not_nts_id = ".$noticia -> getNotNtsId();
					$descripcion[]="not_usu_id = ".$noticia -> getNotUsuId();
					$descripcion_nueva = implode(", ", $descripcion);
					/**
					 * instanciacion de la clase auditoria_tabla para la creacion de un nuevo registro
					 */
					$objAuditoriaTabla = new AuditoriaTabla();
					$objAuditoriaTabla->crearBD("sisgot_adodb");
					$objAuditoriaTabla->setAutTabla("noticia");
					$objAuditoriaTabla->setAutTablaId($this -> getNotId());
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
	 * Metodo para hacer eliminaciones a la entidad noticia. 
	 * @return integer registros borrados
	 */
	public function eliminar()
	{
		$descripcion=array(); //array para almacenar la informacion de la entidad
		//Concateno el where para eliminar los registros de la entidad
		$sql="DELETE FROM noticia  WHERE not_id = ".$this -> getNotId();

		if(isset($this -> auditoria_tabla) and $this -> auditoria_tabla)
		{
			//Consulto la informacion que se registro luego de la actualizacion
			$noticia = $this -> consultarId($this -> getNotId());
					$descripcion[]="not_id = ".$noticia -> getNotId();
					$descripcion[]="not_fecha = ".$noticia -> getNotFecha();
					$descripcion[]="not_titulo = ".$noticia -> getNotTitulo();
					$descripcion[]="not_lead = ".$noticia -> getNotLead();
					$descripcion[]="not_texto = ".$noticia -> getNotTexto();
					$descripcion[]="not_activo = ".$noticia -> getNotActivo();
					$descripcion[]="not_nts_id = ".$noticia -> getNotNtsId();
					$descripcion[]="not_usu_id = ".$noticia -> getNotUsuId();
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
				$objAuditoriaTabla->setAutTabla("noticia");
				$objAuditoriaTabla->setAutTablaId($this -> getNotId());
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
	 * Metodo para asignar el valor al atributo not_id. 
	 * @param string $valor valor para el atributo not_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotId($valor, $tipo = "")
	{
		$this -> not_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_id. 
	 * @return valor
	 */
	public function getNotId()
	{
		return $this -> not_id;
	}

	/**
	 * Metodo para asignar el valor al atributo not_fecha. 
	 * @param string $valor valor para el atributo not_fecha
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotFecha($valor, $tipo = "")
	{
		$this -> not_fecha = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_fecha_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_fecha. 
	 * @return valor
	 */
	public function getNotFecha()
	{
		return $this -> not_fecha;
	}

	/**
	 * Metodo para asignar el valor al atributo not_titulo. 
	 * @param string $valor valor para el atributo not_titulo
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotTitulo($valor, $tipo = "")
	{
		$this -> not_titulo = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_titulo_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_titulo. 
	 * @return valor
	 */
	public function getNotTitulo()
	{
		return $this -> not_titulo;
	}

	/**
	 * Metodo para asignar el valor al atributo not_lead. 
	 * @param string $valor valor para el atributo not_lead
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotLead($valor, $tipo = "")
	{
		$this -> not_lead = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_lead_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_lead. 
	 * @return valor
	 */
	public function getNotLead()
	{
		return $this -> not_lead;
	}

	/**
	 * Metodo para asignar el valor al atributo not_texto. 
	 * @param string $valor valor para el atributo not_texto
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotTexto($valor, $tipo = "")
	{
		$this -> not_texto = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_texto_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_texto. 
	 * @return valor
	 */
	public function getNotTexto()
	{
		return $this -> not_texto;
	}

	/**
	 * Metodo para asignar el valor al atributo not_activo. 
	 * @param string $valor valor para el atributo not_activo
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotActivo($valor, $tipo = "")
	{
		$this -> not_activo = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_activo_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_activo. 
	 * @return valor
	 */
	public function getNotActivo()
	{
		return $this -> not_activo;
	}

	/**
	 * Metodo para asignar el valor al atributo not_nts_id. 
	 * @param string $valor valor para el atributo not_nts_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotNtsId($valor, $tipo = "")
	{
		$this -> not_nts_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_nts_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_nts_id. 
	 * @return valor
	 */
	public function getNotNtsId()
	{
		return $this -> not_nts_id;
	}

	/**
	 * Metodo para asignar el valor al atributo not_usu_id. 
	 * @param string $valor valor para el atributo not_usu_id
	 * @param string $tipo tipo de valor que llevara el campo (sql)
	 */
	public function setNotUsuId($valor, $tipo = "")
	{
		$this -> not_usu_id = $valor;
		
		if(!empty($tipo))
		{
			$this -> not_usu_id_tipo = $tipo;
		}
	}

	/**
	 * Metodo para obtener el valor del atributo not_usu_id. 
	 * @return valor
	 */
	public function getNotUsuId()
	{
		return $this -> not_usu_id;
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