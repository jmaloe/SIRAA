<?php
require_once('../db/ConexionDB.php');

class CCategoriaRequisito extends ConexionDB{

	var $id_categoria;
	var $nombre;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setIdCategoria($id_c){
		$this->id_categoria = $id_c;
	}

	function setNombreCategoria($nom){
		$this->nombre = $nom;
	}

	function getIdCategoria(){
		return $this->id_categoria;
	}

	function getNombreCategoria(){
		return $this->nombre;
	}	

	function getCategorias($defaultselect){
	   /*$sql="SELECT * from pais ORDER BY nombrePais;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$defaultselect);       
       return $data;*/
	}

	function registrarCategoria(){
		/*$this->nombrePais = $this->scapeString($this->nombrePais);
		$sql="INSERT INTO pais(nombrePais) VALUES('".$this->nombrePais."');";		
        $this->query($sql);
        $resultado = $this->getInsertId(); //id
       return $resultado;*/
	}

	function actualizarCategoria(){

	}
}
?>