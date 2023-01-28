<?php
require_once('../db/ConexionDB.php');

class CAreaConocimiento extends ConexionDB{
 var $nombreArea, $id_area;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdArea($id_a){
 		$this->id_area = $id_a;
 	}

	function setNombreArea($nombre){
		$this->nombreArea = $this->scapeString($nombre);
	}

	function getIdArea(){
		return $this->id_area;
	}

	function getNombreArea(){
		return $this->nombreArea;
	}

	function registrarArea(){
		$sql="INSERT INTO area_conocimiento(descripcion) VALUES('".$this->getNombreArea()."');";
        $this->query($sql);
        $this->setIdArea( $this->getInsertId() ); /*id*/        
	}	

	function getAllAreas(){
	   $sql="SELECT id_areaConocimiento, descripcion FROM area_conocimiento ORDER BY descripcion;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);       
       return $data;
	}
	
}
?>