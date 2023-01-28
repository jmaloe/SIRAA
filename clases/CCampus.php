<?php
require_once('CUniversidad.php');

class CCampus extends CUniversidad{
 var $id_campus=-1, 
 	 $nombreCampus;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdCampus($id_campus){
 		$this->id_campus = $id_campus;
 	}

 	function setNombreCampus($nombre_c){
 		$this->nombreCampus = $nombre_c;
 	}

	function getIdCampus(){
 		return $this->id_campus;
 	}

 	function getNombreCampus(){
 		return $this->nombreCampus;
 	}

	function getTodosCampus()
	{
	   $sql="SELECT id_campus, id_universidad, id_ciudad, nombreCampus FROM campus ORDER BY nombreCampus;";
         $resultado = $this->query($sql);
         return $this->getDataListItems($resultado);       
	}

	function getCampusToSelect($default_selected)
	{
	   $sql='SELECT c.id_campus,CONCAT(c.nombreCampus," ",ci.nombreCiudad) AS "campus" FROM campus c, ciudad ci WHERE c.id_ciudad=ci.id_ciudad ORDER BY c.id_campus;';
         $resultado = $this->query($sql);
         return $this->getSelectItems($resultado,$default_selected);       
	}
}
?>