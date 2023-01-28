<?php
require_once('CCiudad.php');

class CDependencias extends CCiudad{
 var $id_dependencia=0, $nombreDependencia, $direccion;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdDependencia($id_d){
 		$this->id_dependencia = $id_d;
 	}

	function setNombreDependencia($nombre){
		$this->nombreDependencia = $nombre;
	}

	function setDireccion($dir){
		$this->direccion = $dir;
	}

	function getIdDependencia(){
		return $this->id_dependencia;
	}

	function getNombreDependencia(){
		return $this->nombreDependencia;
	}

	function getDireccion(){
		return $this->direccion;
	}

	function getDependenciaByName($nombre){
	 $nombre = $this->scapeString($nombre);
	 $sql="SELECT id_dependencia, id_ciudad, nombreDependencia, direccion FROM dependencia WHERE nombreDependencia like '%".$nombre."%';";
     $resultado = $this->query($sql);
     if($dato = $resultado->fetch_assoc())
     {
        $this->setIdCiudad($dato['id_ciudad']);        
        $this->searchEstadoAndPais();
      $this->setIdDependencia($dato['id_dependencia']);
      $this->setNombreDependencia($dato['nombreDependencia']);
      $this->setDireccion($dato['direccion']);
     }
	}

	function getDependencias(){
	   $sql="SELECT id_dependencia,nombreDependencia FROM dependencia ORDER BY nombreDependencia;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);       
       return $data;
	}

	function registrarDependencia(){
		$this->nombreDependencia = $this->scapeString($this->nombreDependencia);
		$this->direccion = $this->scapeString($this->direccion);
		$sql="INSERT INTO dependencia(id_ciudad,nombreDependencia,direccion) VALUES(".$this->id_ciudad.",'".$this->nombreDependencia."','".$this->direccion."');";
        $this->query($sql);        
        $this->setIdDependencia($this->getInsertId());
        if($this->id_dependencia>0)
        	return true;
       return false;
	}

	function actualizarDependencia(){		
		$this->nombreDependencia = $this->scapeString($this->nombreDependencia);
		$this->direccion = $this->scapeString($this->direccion);
		$sql="UPDATE dependencia SET id_ciudad........,nombreDependencia,direccion) VALUES(".$this->id_ciudad.",'".$this->nombreDependencia."','".$this->direccion."');";		
        $this->query($sql);
        $resultado = $this->getInsertId(); /*id*/       
       return $resultado;	
	}
}
?>