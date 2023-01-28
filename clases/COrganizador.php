<?php
require_once('CPersona.php');

class COrganizador extends CPersona{
 	
 	var $id_organizador=0;

 	function __construct($db)
 	{
    	parent::__construct($db); /*invocar el constructor de la clase padre*/
	}

	function setIdOrganizador($id_org){
		$this->id_organizador = $id_org;
 	}

 	function getIdOrganizador(){
 		return $this->id_organizador;
 	}

 	function getOrganizadorById(){
 		$sql="SELECT id_organizador FROM organizador where id_persona=".$this->getIdPersona().";";
         $resultado = $this->query($sql);
         if($fila = mysqli_fetch_assoc($resultado))
         	$this->setIdOrganizador($fila['id_organizador']);
 	}

	function getOrganizadores(){
		$sql="SELECT o.id_persona as id, concat(p.nombre,' ',p.apellido_paterno, ' ',p.apellido_materno) as value, p.telefono as tel, p.telCelular as cel, p.email FROM organizador o, persona p where o.id_persona = p.id_persona ORDER BY p.nombre;";		
         $resultado = $this->query($sql);
         return $this->getCustomDataListItems($resultado);
	}

	function registrarOrganizador(){
		$sql="INSERT INTO organizador(id_persona) VALUES(".$this->getIdPersona().");";
        if(!$this->query($sql)){
        	echo $this->getError();
        }
        $this->setIdOrganizador( $this->getInsertId() );        
	}	
}
?>