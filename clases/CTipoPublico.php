<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

class CTipoPublico extends ConexionDB{
 var $nombreTipo, $id_tipo;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdTipoPublico($id_t){
 		$this->id_tipo = $id_t;
 	}

	function setDescripcionTipo($nombre){
		$this->nombreTipo = $this->scapeString($nombre);
	}

	function getIdTipoPublico(){
		return $this->id_tipo;
	}

	function getDescripcionTipo(){
		return $this->nombreTipo;
	}

	function registrarTipoPublico(){
		$sql="INSERT INTO tipo_publico(descripcion) VALUES('".$this->getDescripcionTipo()."');";
        $this->query($sql);
        $this->setIdTipoPublico( $this->getInsertId() ); /*id*/
	}

	function getAllTipoPublico(){
	   $sql="SELECT id_tipoPublico, descripcion FROM tipo_publico ORDER BY descripcion;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);       
       return $data;
	}
	
}
?>