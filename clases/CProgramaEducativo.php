<?php
require_once('CClasifProgsEducs.php');

class CProgramaEducativo extends CClasificacionProgs{

	var $id_programa;
	var $nombrePrograma;
	var $progstotales=0;
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

	function setIdPrograma($id_p){
		$this->id_programa = $id_p;
	}

	function setNombrePrograma($nom){
		$this->nombrePrograma = $nom;
	}

	function getIdPrograma(){
		return $this->id_programa;
	}

	function getNombrePrograma(){
		return $this->nombrePrograma;
	}	

	function getProgsTotales(){
		return $this->progstotales;
	}	

	function getProgramasEducativos($tipo){
	   $sql="SELECT id_programaEducativo, nombrePrograma FROM programa_educativo WHERE id_clasifprogseducs=".$tipo." AND id_programaEducativo>0 ORDER BY id_programaEducativo;";
         $resultado = $this->query($sql);       
         $data = $this->getDataListItems($resultado);
         $this->progstotales = $this->getNumRows();       
       return $data;
	}

	function getProgramaByName($consulta){
	   $sql="SELECT pe.id_clasifprogseducs, pe.id_programaEducativo, pe.nombrePrograma FROM programa_educativo pe, clasificacion_programas_educativos cpe WHERE pe.id_clasifprogseducs=cpe.id_clasifprogseducs AND pe.id_programaEducativo>0 AND pe.nombrePrograma like '%".$consulta."%';";
         $resultado = $this->query($sql);
     if($dato = mysqli_fetch_assoc($resultado))
     {
      $this->setIdPrograma($dato['id_programaEducativo']);
      $this->setIdClasificacion($dato['id_clasifprogseducs']);
      $this->setNombrePrograma($dato['nombrePrograma']);
     }
     
	}

	function registrarPrograma(){		
		$this->nombrePrograma = $this->scapeString($this->nombrePrograma);
		$sql="INSERT INTO programa_educativo(id_clasifprogseducs,nombrePrograma) VALUES(".$this->id_clasificacion.",'".$this->nombrePrograma."');";		
        $this->query($sql);
        $resultado = $this->getInsertId(); //id
      
       return $resultado;
	}

	function actualizarPrograma(){		
    	$sql="UPDATE programa_educativo SET id_clasifprogseducs=".$this->id_clasificacion.",nombrePrograma='".$this->nombrePrograma."' WHERE id_programaEducativo=".$this->id_programa.";";
        $this->update($sql);    
        $resultado = $this->getUpdateId(); /*id*/    
       
       return $resultado;
	}
}
?>