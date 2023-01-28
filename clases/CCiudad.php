<?php
require_once('CEstado.php');

class CCiudad extends CEstado{

	var $id_ciudad;
	var $nombreCiudad;
 
	function __construct($db)
	{
	   parent::__construct($db); /*invocar el constructor de la clase padre*/
	}

	function setIdCiudad($id_c){
		$this->id_ciudad = $id_c;
	}

	function setNombreCiudad($nom){
		$this->nombreCiudad = $nom;
	}

	function getIdCiudad(){
		return $this->id_ciudad;
	}

	function getNombreCiudad(){
		return $this->nombreCiudad;
	}
	/*buscamos el estado y el pais al que pertenece determinada ciudad*/
	function searchEstadoAndPais(){
		$sql = "SELECT * FROM ciudad c, estado e, pais p where c.id_ciudad=".$this->id_ciudad." and c.id_estado=e.id_estado and e.id_pais=p.id_pais;";
        $resultado = $this->query($sql);
        if($dato = $resultado->fetch_assoc())
        {
        	$this->setIdEstado($dato['id_estado']);
        	$this->setNombreEstado($dato['nombreEstado']);
        	$this->setIdPais($dato['id_pais']);
        	$this->setNombrePais($dato['nombrePais']);
        }
	}
	/*recuperamos todas las ciudades de un estado en específico mediante el ID del estado*/
	function getCiudadesByEstado($id_estado,$defaultselect){
		$sql="SELECT c.id_ciudad,c.nombreCiudad FROM ciudad c, estado e WHERE c.id_estado=e.id_estado AND e.id_estado=".$id_estado." ORDER BY nombreCiudad;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$defaultselect);       
       return $data;
	}
	/*recuperamos todas la ciudades PENDIENTE*/
	function getAllCiudades($defaultselect){
	   $sql="SELECT id_ciudad,nombreCiudad from ciudad ORDER BY nombreCiudad;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$defaultselect);       
       return $data;
	}
	/*guardamos una nueva ciudad en la base de datos*/
	function registrarCiudad(){
		$this->nombreCiudad = mysqli_real_escape_string($this->_db,$this->nombreCiudad);
		$sql="INSERT INTO ciudad(id_estado, nombreCiudad) VALUES(".$this->getIdEstado().",'".$this->nombreCiudad."');";
        $this->query($sql);
        $resultado = $this->getInsertId(); /*id*/       
       return $resultado;
	}
	/*actualizar el nombre de la ciudad*/
	function actualizarCiudad(){
		
	}
}
?>