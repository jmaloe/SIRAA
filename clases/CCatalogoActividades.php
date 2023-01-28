<?php
require_once('CActividad.php');

class CCatalogoActividades extends CActividad{

	var $id_cat_acts, $descripcion;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 function setIdActCat($id){
 	$this->id_cat_acts = $id;
 }

 function setDescripcionActividad($desc){
 	$this->descripcion = $this->scapeString($desc);
 }

 function getIdActCat(){
 	return $this->id_cat_acts;
 }

 function getDescripcionActividad(){
 	return $this->descripcion;
 }

	function getCatalogoActs(){
	   $sql="SELECT id_catalogoactividades, descripcion FROM catalogo_actividades WHERE id_actividadAcademica=".$this->id_cat_acts." ORDER by descripcion;";       
         $resultado = $this->query($sql);
         return $this->getDataListItems($resultado);       
	}

	function registrarActividadEnCatalogo(){
		$sql = "SELECT id_catalogoactividades,id_actividadAcademica,descripcion FROM catalogo_actividades WHERE descripcion='".$this->descripcion."' AND id_actividadAcademica=".$this->getIdActividad();
		$resultado = $this->query($sql);
		if($fila = mysqli_fetch_assoc($resultado)){
			$this->setIdActCat($fila['id_catalogoactividades']);
			return true;
		}
		$sql="INSERT INTO catalogo_actividades(id_actividadAcademica, descripcion) values(".$this->getIdActividad().",'".$this->descripcion."');";       
        $this->query($sql);
        $this->setIdActCat($this->getInsertId());
	}
}
?>