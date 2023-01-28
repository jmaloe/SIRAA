<?php
require_once('../db/ConexionDB.php');

class CPais extends ConexionDB{

	var $id_pais;
	var $nombrePais;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setIdPais($id_p){
		$this->id_pais = $id_p;
	}

	function setNombrePais($nom){
		$this->nombrePais = $nom;
	}

	function getIdPais(){
		return $this->id_pais;
	}

	function getNombrePais(){
		return $this->nombrePais;
	}	

	function getPaises($defaultselect){
	   $sql="SELECT * from pais ORDER BY nombrePais;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$defaultselect);       
       return $data;
	}

	function registrarPais(){
		$this->nombrePais = $this->scapeString($this->nombrePais);
		$sql="INSERT INTO pais(nombrePais) VALUES('".$this->nombrePais."');";		
        $this->query($sql);
        $resultado = $this->getInsertId(); /*id*/       
       return $resultado;
	}

	function actualizarPais(){

	}
}
?>