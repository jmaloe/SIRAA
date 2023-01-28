<?php
require_once('CPais.php');

class CEstado extends CPais{

	var $id_estado;
	var $nombreEstado;
 
	function __construct($db)
	{
	   parent::__construct($db); /*invocar el constructor de la clase padre*/
	}

	function setIdEstado($id_e){
		$this->id_estado = $id_e;
	}

	function setNombreEstado($nom){
		$this->nombreEstado = $nom;
	}

	function getIdEstado(){
		return $this->id_estado;
	}

	function getNombreEstado(){
		return $this->nombreEstado;
	}
	
	function getEstadosByPais($id_pais,$defaultselect){		
		$sql="SELECT e.id_estado,e.nombreEstado FROM estado e, pais p WHERE p.id_pais=e.id_pais AND p.id_pais=".$id_pais.";";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,$defaultselect);       
       return $data;
	}

	function getAllEstados(){
	   $sql="SELECT id_estado,nombreEstado from estados ORDER BY nombreEstado;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,0);       
       return $data;
	}

	function registrarEstado(){
		$this->nombreEstado = mysqli_real_escape_string($this->_db,$this->nombreEstado);
		$sql="INSERT INTO estado(id_pais, nombreEstado) VALUES(".$this->getIdPais().",'".$this->nombrePais."');";		
        $this->query($sql);
        $resultado = $this->getInsertId(); /*id*/       
       return $resultado;
	}

	function actualizarEstado(){

	}
}
?>