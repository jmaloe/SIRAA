<?php
require_once('../db/ConexionDB.php');

class CClasificacionProgs extends ConexionDB{

	var $id_clasificacion;
	var $nombreClasificacion;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setIdClasificacion($id_c){
		$this->id_clasificacion = $id_c;
	}

	function setNombreClasificacion($nom){
		$this->nombreClasificacion = $nom;
	}

	function getIdClasificacion(){
		return $this->id_clasificacion;
	}

	function getNombreClasificacion(){
		return $this->nombreClasificacion;
	}

	function getClasificacionProgramas($defaultselect){		
		$sql="SELECT * FROM clasificacion_programas_educativos ORDER BY descripcion;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$defaultselect);       
       return $data;
	}

	function registrarClasificacion(){
		/*$this->nombrePrograma = mysqli_real_escape_string($this->_db,$this->nombrePrograma);
		$sql="INSERT INTO pais(nombrePais) VALUES('".$this->nombrePrograma."');";		
        $this->query($sql);
        $resultado = $this->getInsertId(); //id       
       return $resultado;*/
	}

	function actualizarClasificacion(){

	}
}
?>