<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

class CCarpetaDocumentos extends ConexionDB{
 var $id_carpeta=0, 
 	 $tag="NE", 
 	 $fecha_captura;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 function setIdCarpeta($id){
 	$this->id_carpeta = $id;
 }

 function setTag($tag){
 	$this->tag = $tag;
 }

 function setFechaCaptura($fc){
 	$this->fecha_captura = $fc;
 }

 function getIdCarpeta(){
 	return $this->id_carpeta;
 }

 function getTag(){
 	return $this->tag;
 }

 function getFechaCaptura(){
 	return $this->fecha_captura;
 }

 function nuevaCarpeta(){
	$sql="INSERT INTO carpeta(tag) VALUES('".$this->scapeString($this->tag)."');";
        $this->query($sql);
    	$this->setIdCarpeta($this->getInsertId());
 }

 function updateCarpeta(){
 	$sql="UPDATE carpeta SET tag='".$this->scapeString($this->tag)."' WHERE id_carpeta=".$this->id_carpeta;
    $this->update($sql);
    return $this->getAffectedRows(); /*filas afectadas*/
 }
}
?>