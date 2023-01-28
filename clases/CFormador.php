<?php
require_once('CPersona.php');

class CFormador extends CPersona{
 	
 	var $id_formador=0, $tipo_formador=0;

 	function __construct($db)
 	{
    	parent::__construct($db); /*invocar el constructor de la clase padre*/
	}

	function setIdFormador($id_f){
		$this->id_formador = $id_f;
 	}

	function setTipoFormador($tf){
		$this->tipo_formador = $tf;
	}

	function getTipoFormador(){
		return $this->tipo_formador;
	}

	function getIdFormador(){
		return $this->id_formador;
	}

	function getFormadorById(){
		$sql = "SELECT f.id_formador,f.id_carpeta,f.id_tipoParticipante FROM formador f, tipo_participante tp where f.id_tipoParticipante=tp.id_tipoParticipante and f.id_persona=".$this->id_persona.";";
		$resultado = $this->query($sql);
		if($dato = mysqli_fetch_assoc($resultado)){
			$this->setIdFormador($dato['id_formador']);
			$this->setTipoFormador($dato['id_tipoParticipante']);
			$this->setIdCarpeta($dato['id_carpeta']);			
		}
		else
		 $this->setTipoFormador(0);
	}

	function getFormadores(){
		$sql="SELECT f.id_persona as id, concat(p.nombre,' ', p.apellido_paterno,' ', p.apellido_materno) as value, (select max(cns_documento) from detalle_documentos where id_carpeta=f.id_carpeta) as doc, f.id_tipoParticipante as t_p FROM formador f, persona p, carpeta c, tipo_participante tp WHERE f.id_persona=p.id_persona AND f.id_carpeta=c.id_carpeta AND f.id_tipoParticipante=tp.id_tipoParticipante ORDER BY p.nombre;";
         $resultado = $this->query($sql);
         return $this->getCustomDataListItems($resultado);       
	}

	function registrarFormador(){
		$this->crearCarpeta("NEW_F");		
		$sql="INSERT INTO formador(id_persona,id_carpeta,id_tipoParticipante) VALUES(".$this->getIdPersona().",".$this->getIdCarpeta().",".$this->tipo_formador.");";
        if(!$this->query($sql)){
        	echo $this->getError();
        }
        $this->setIdFormador( $this->getInsertId() );
        $this->actualizarCarpeta("FORM:".$this->id_formador);
	}

	function actualizarFormador(){
		$sql="UPDATE formador SET id_tipoParticipante=".$this->tipo_formador." WHERE id_formador=".$this->getIdFormador().";";
        if(!$this->update($sql)){
        	echo $this->getError();
        }
	}
}
?>