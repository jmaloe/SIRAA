<?php
require_once('CPersona.php');

class CResponsableCDC extends CPersona{
 	
 	var $id_responsable=0;

 	function __construct($db)
 	{
    	parent::__construct($db); /*invocar el constructor de la clase padre*/
	}

	function setIdResponsable($id_r){
		$this->id_responsable = $id_r;
 	}

	function getIdResponsableCDC(){
		return $this->id_responsable;
	}

	function getResponsableCDCById(){
		$sql="SELECT id_responsable_cdc,id_carpeta FROM responsableCDC where id_persona=".$this->getIdPersona().";";
         $resultado = $this->query($sql);
         if($fila = mysqli_fetch_assoc($resultado))
         {
         	$this->setIdResponsable($fila['id_responsable_cdc']);
         	$this->setIdCarpeta($fila['id_carpeta']);
         }
	}

	function getResponsablesCDC(){
		$sql="SELECT r.id_persona as id, concat(p.nombre,' ', p.apellido_paterno,' ', p.apellido_materno) as value, (select max(cns_documento) from detalle_documentos where id_carpeta=c.id_carpeta) as doc FROM responsableCDC r, persona p, carpeta c WHERE r.id_persona=p.id_persona AND r.id_carpeta=c.id_carpeta ORDER BY p.nombre";		
         $resultado = $this->query($sql);
         return $this->getCustomDataListItems($resultado);       
	}

	function registrarResponsableCDC(){
		$this->crearCarpeta("NEW_RCDC");
		$sql="INSERT INTO responsableCDC(id_persona,id_carpeta) VALUES(".$this->getIdPersona().",".$this->getIdCarpeta().");";
        if(!$this->query($sql)){
        	echo $this->getError();
        }
        $this->setIdResponsable($this->getInsertId()); /*id*/
        $this->actualizarCarpeta("RCDC:".$this->id_responsable);
	}
}
?>