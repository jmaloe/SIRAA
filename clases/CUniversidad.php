<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

class CUniversidad extends ConexionDB{
 
 var $id_universidad, $nombreUniversidad, $slogan;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdUniversidad($id_u){
 		$this->id_universidad = $id_u;
 	}

	function setNombreUniversidad($nombre_u){
		$this->nombreUniversidad = $nombre_u;
	}

	function setSlogan($s){
		$this->slogan = $s;
	}

	function getIdUniversidad(){
 		return $this->id_universidad;
 	}

	function getNombreUniversidad(){
		return $this->nombreUniversidad;
	}

	function getSlogan(){
		return $this->slogan;
	}

	function getUniversidadByName($nombre){
	 $sql="SELECT id_universidad, nombreUniversidad, slogan FROM universidad WHERE nombreUniversidad like '%".$nombre."%';";
     $resultado = $this->query($sql);
     if($dato = $resultado->fetch_assoc())
     {
      $this->setIdUniversidad($dato['id_universidad']);      
      $this->setNombreUniversidad($dato['nombreUniversidad']);
      $this->setSlogan($dato['slogan']);
     }
	}

	function getUniversidades()
	{
	   $sql="SELECT id_universidad, nombreUniversidad, slogan FROM universidad ORDER BY nombreUniversidad;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);       
       return $data;
	}
}
?>