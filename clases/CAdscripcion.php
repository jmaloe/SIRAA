<?php
require_once('../db/ConexionDB.php');

class CAdscripcion extends ConexionDB{

	var $id_adscripcion=0;
	var $descripcion;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setIdAdscripcion($id_a){
		$this->id_adscripcion = $id_a;
	}

	function setNombreAdscripcion($nom){
		$this->descripcion = $nom;
	}

	function getIdAdscripcion(){
		return $this->id_adscripcion;
	}

	function getNombreAdscripcion(){
		return $this->descripcion;
	}	

	function getAdscripciones($defaultselect){
	   $sql="SELECT * from adscripcion WHERE id_adscripcion>0 ORDER BY descripcion;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);
       return $data;
	}

	function buscarById($id){
		$sql="SELECT id_adscripcion,descripcion from adscripcion WHERE id_adscripcion=".$id.";";
         $resultado = $this->query($sql);
         if($data = mysqli_fetch_assoc($resultado)){
         	$this->setIdAdscripcion($data['id_adscripcion']);
         	$this->setNombreAdscripcion($data['descripcion']);
         	return true;
         }
       return false;
	}

	function guardar(){
		$this->descripcion = $this->scapeString($this->descripcion);
		$sql="INSERT INTO adscripcion(descripcion) VALUES('".$this->descripcion."');";		
        if($this->query($sql)){
        	$this->setIdAdscripcion($this->getInsertId()); /*id*/
        	return true;
    	}
       return false;
	}

	function actualizar(){

	}
}
?>