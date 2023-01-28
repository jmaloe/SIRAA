<?php
require_once('CCampus.php');

class CFacultad extends CCampus{
 
 var $id_facultad=-1,
 	 $nombreFacultad, 
 	 $direccion;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdFacultad($id_f){
 		$this->id_facultad = $id_f;
 	}

	function setNombreFacultad($facultad){
		$this->nombreFacultad = $this->scapeString($facultad);
	}

	function setDireccion($dir){
		$this->direccion = $this->scapeString($dir);
	}

	function getIdFacultad(){
		return $this->id_facultad;
	}

	function getNombreFacultad(){
		return $this->nombreFacultad;
	}

	function getDireccion(){
		return $this->direccion;
	}

	function getFacultadById(){
	 $sql="SELECT f.id_facultad, f.id_campus, f.nombreFacultad, f.direccion from facultad f, campus c WHERE f.id_campus=c.id_campus AND id_facultad=".$this->id_facultad.";";
     $resultado = $this->query($sql);
     if($dato = mysqli_fetch_assoc($resultado))
     {
      //$this->setIdFacultad($dato['id_facultad']);
      $this->setIdCampus($dato['id_campus']);
      $this->setNombreFacultad($dato['nombreFacultad']);
      $this->setDireccion($dato['direccion']);      
     }
	}

	function getFacultadByName($nombre){
	 if($this->id_campus!=-1)
	   	$sql="SELECT f.id_facultad, f.id_campus, f.nombreFacultad, f.direccion from facultad f, campus c WHERE f.id_campus=c.id_campus AND f.id_campus=".$this->id_campus." AND nombreFacultad like '%".$nombre."%';";
	 else
	 	$sql="SELECT f.id_facultad, f.id_campus, f.nombreFacultad, f.direccion from facultad f, campus c WHERE f.id_campus=c.id_campus AND nombreFacultad like '%".$nombre."%';";
     $resultado = $this->query($sql);
     if($dato = mysqli_fetch_assoc($resultado))
     {
      $this->setIdFacultad($dato['id_facultad']);
      $this->setIdCampus($dato['id_campus']);
      $this->setNombreFacultad($dato['nombreFacultad']);
      $this->setDireccion($dato['direccion']);      
     }
	}

	function getFacultades($defaulselected)
	{
	   $sql="SELECT f.id_facultad, concat(f.nombreFacultad,' ',c.nombreCampus,' ',ci.nombreCiudad) FROM facultad f, campus c, ciudad ci WHERE c.id_ciudad=ci.id_ciudad and c.id_campus=f.id_campus order by f.nombreFacultad;";
         $resultado = $this->query($sql);
         return $this->getSelectItems($resultado,$defaulselected);       
	}

	function registrarFacultad(){
		$sql = "INSERT INTO facultad(id_campus,nombreFacultad,direccion) VALUES(".$this->getIdCampus().",'".$this->nombreFacultad."','".$this->direccion."')";
		if($this->update($sql)){
			$this->id_facultad=$this->getInsertId();
			return true;
		}
		return false;
	}

	function actualizarFacultad(){
		$sql = "UPDATE facultad SET id_campus=".$this->getIdCampus().", nombreFacultad='".$this->nombreFacultad."',direccion='".$this->direccion."' WHERE id_facultad=".$this->id_facultad;
		if($this->update($sql))
			return true;
		return false;
	}
}
?>