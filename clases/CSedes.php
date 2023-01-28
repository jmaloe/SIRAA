<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('CFacultad.php');

class CSedes extends CFacultad{

	var $id_sede=0,$nombreSede;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setIdSede($id_s){
		$this->id_sede = $id_s;
	}

	function setNombreSede($n_sede){
		$this->nombreSede = $n_sede;
 	}

 	function getIdSede(){
		return $this->id_sede;
	}

	function getNombreSede(){
		return $this->nombreSede;
 	}

	function getSedes(){
	   $sql="SELECT id_sede,ubicacion from sede ORDER BY ubicacion;";
         $resultado = $this->query($sql);
         $data = $this->getDataListItems($resultado);
       
       return $data;
	}

	function getSedeByName($nombre){
	 $sql="SELECT s.id_sede, s.id_facultad, s.ubicacion from sede s, facultad f WHERE s.id_facultad=f.id_facultad AND ubicacion like '%".$nombre."%';";
     $resultado = $this->query($sql);
     if($dato = $resultado->fetch_assoc())
     {
      $this->setIdSede($dato['id_sede']);
      $this->setNombreSede($dato['ubicacion']);
      $this->setIdFacultad($dato['id_facultad']);
     }
     
	}

	function registrarSede(){
		$this->nombreSede = $this->scapeString($this->nombreSede);
		if($this->nombreSede!="")
		{
			$sql="INSERT INTO sede(id_facultad,ubicacion) VALUES(".$this->id_facultad.",'".$this->nombreSede."');";		
	        $this->query($sql);        
	       $this->setIdSede($this->getInsertId());
	       if($this->id_sede>0)
	       	return true;
   		}
       return false;
	}

	function actualizarSede(){
		$this->nombreSede = $this->scapeString($this->nombreSede);
        $sql="UPDATE sede SET id_facultad=".$this->id_facultad.",ubicacion='".$this->nombreSede."' WHERE id_sede=".$this->id_sede.";";
        $this->update($sql);    
        $resultado = $this->getAffectedRows(); /*id*/    
       
       return $resultado;
	}
}
?>