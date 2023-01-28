<?php
require_once('../db/ConexionDB.php');

class CModalidad extends ConexionDB{
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setNuevaModalidad($nombre){

	}

	function getModalidadByName($id){

	}

	function getModalidades($default){
	   $sql="SELECT id_modalidad, descripcion from modalidad order by id_modalidad;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$default);       
       return $data;
	}
	
}
?>