<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

class CTipoParticipante extends ConexionDB{
 var $nombreTipo, $id_tipo=0;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 	function setIdTipoParticipante($id_t){
 		$this->id_tipo = $id_t;
 	}

	function setDescripcionTipo($nombre){
		$this->nombreTipo = $nombre;
	}

	function getIdTipoParticipante(){
		return $this->id_tipo;
	}

	function getDescripcionTipo(){
		return $this->nombreTipo;
	}

	function getTipoByName(){
	   $sql="SELECT id_tipoParticipante FROM tipo_participante WHERE descripcion='".$this->nombreTipo."';";
         $resultado = $this->query($sql);
        if($fila = mysqli_fetch_assoc($resultado)){
        	$this->setIdTipoParticipante($fila['id_tipoParticipante']);
        }
	}

	function getAllTipoParticipante(){
	   $sql="SELECT id_tipoParticipante, descripcion FROM tipo_participante ORDER BY id_tipoParticipante;";
         $resultado = $this->query($sql);
         $data = $this->getSelectItems($resultado,0);       
       return $data;
	}
	
}
?>