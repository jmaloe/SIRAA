<?php
require_once('CPersona.php');

class CCoordinador extends CPersona{
 	
 	var $id_coordinador=0;

 	function __construct($db)
 	{
    	parent::__construct($db); /*invocar el constructor de la clase padre*/
	}

	function setIdCoordinador($id_c){
		$this->id_coordinador = $id_c;
 	}

 	function getIdCoordinador(){
 		return $this->id_coordinador;
 	}

 	function getCoordinadorById(){
		$sql = "SELECT id_coordinador,id_carpeta FROM coordinador WHERE id_persona=".$this->id_persona.";";
		$resultado = $this->query($sql);
		if($dato = mysqli_fetch_assoc($resultado)){			
			$this->setIdCoordinador($dato['id_coordinador']);
			$this->setIdCarpeta($dato['id_carpeta']);
		}		
	}

	function getCoordinadores(){
		//$sql="SELECT co.id_persona as id, concat(p.nombre,' ', p.apellido_paterno,' ', p.apellido_materno) as value, (select max(cns_documento) from detalle_documentos where id_carpeta=c.id_carpeta) as doc FROM coordinador co, persona p, carpeta c WHERE co.id_persona=p.id_persona AND co.id_carpeta=c.id_carpeta ORDER BY p.nombre;";
		$sql="SELECT co.id_persona as id, concat(p.nombre,' ', p.apellido_paterno,' ', p.apellido_materno) as value, telefono, telCelular as celular, email FROM coordinador co, persona p WHERE co.id_persona=p.id_persona ORDER BY p.nombre;";
         $resultado = $this->query($sql);
         return $this->getCustomDataListItems($resultado);
	}

	function registrarCoordinador(){
		$this->crearCarpeta("NEW_C");
		$sql="INSERT INTO coordinador(id_persona,id_carpeta) VALUES(".$this->getIdPersona().",".$this->getIdCarpeta().");";
        if(!$this->query($sql)){
        	echo $this->getError();
        }
        $this->setIdCoordinador( $this->getInsertId() );
        $this->actualizarCarpeta("COOR:".$this->id_coordinador);
	}
}
?>