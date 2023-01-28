<?php
require_once('../db/ConexionDB.php');

class CValidacion extends ConexionDB{
 var $nombreValidacion, $id_validacion;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdValidacion($id_v){
 		$this->id_validacion = $id_v;
 	}

	function setNombreValidacion($nombre){
		$this->nombreValidacion = $this->scapeString($nombre);
	}

	function getIdValidacion(){
		return $this->id_validacion;
	}

	function getNombreValidacion(){
		return $this->nombreValidacion;
	}

	function registrarValidacion(){
		$sql="INSERT INTO validacion_actividad(descripcion) VALUES('".$this->getNombreValidacion()."');";
        $this->query($sql);
        $this->setIdValidacion( $this->getInsertId() ); /*id*/
	}	

	function getAllValidaciones(){
	   $sql="SELECT id_tipoValidacion, descripcion FROM validacion_actividad ORDER BY descripcion;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);       
       return $data;
	}
	
}
?>