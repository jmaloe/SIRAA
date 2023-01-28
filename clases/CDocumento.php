<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('CCarpetaDocumentos.php');

class CDocumento extends CCarpetaDocumentos{
 var $id_documento=-1,
 	 $id_tipodoc=1 /*CV por default*/,
 	 $nombre,
 	 $tmp_name, 
 	 $mime, 
 	 $size, 
 	 $data, 
 	 $fecha_c;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 //setters
 function setIdDocumento($id){
 	$this->id_documento = $id;
 }

 function setName($nombre){
 	$this->nombre = $this->scapeString($nombre);
 }

 function setTmpName($nombre){
 	$this->tmp_name = $this->scapeString($nombre);
 }

 function setMime($m){
 	$this->mime = $m;
 }

 function setSize($tam){
 	$this->size = $tam;
 }

 function setData($d){
 	$this->data = $this->scapeString($d);
 }

 function setFechaCaptura($f){
 	$this->fecha_c = $f;
 }

 function setIdTipoDoc($id){
 	$this->id_tipodoc = $id;
 }

 //getters
 function getIdDocumento(){
 	return $this->id_documento;
 }

 function getName(){
 	return $this->nombre;
 }

 function getTmpName(){
 	return $this->tmp_name;
 }

 function getMime(){
 	return $this->mime;
 }

 function getSize(){
 	return $this->size;
 }

 function getData(){
 	return $this->data;
 }

 function getFechaCaptura(){
 	return $this->fecha_c;
 }

 function getIdTipoDoc(){
 	return $this->id_tipodoc;
 }

 function getNextId(){
 	$this->id_documento+=1;
 	return $this->id_documento;
 }

 function guardarDocumento($uploaded, $subfolder){
 try
 {	 
   if($uploaded['name']!=NULL)
   {
 	$this->setName($uploaded['name']);
 	$this->setTmpName($uploaded['tmp_name']);
 	$this->setMime($uploaded['type']);
 	$this->setSize($uploaded['size']);

	$info = pathinfo($uploaded['name']);
	$ext = $info['extension']; //obtenemos la extensión del archivo
	if($this->getIdDocumento()==-1){
		$this->getLastId();
	}
	$target = "../Documentos/".$subfolder.$this->getNextId().".".$ext;
	$this->setData($target);
	if(!move_uploaded_file( $this->getTmpName(), $target)){
		echo "Error al guardar el archivo:".$this->getName();
	}
	else
	{
		//chmod($target, 0755);
		if($this->saveIntoDB())
		{
			return '<a href="'.$target.'" target="_blank"><img src="../imagenes/doc.png" height="35" width="35"></a>';			
		}
	}
  }
 }
 catch(Exception $e)
 {
	 echo $e->getMessage();
 }
  return false;
 }

 function saveIntoDB(){
 	$sql = "INSERT INTO detalle_documentos(id_tipoDocumento,id_carpeta,name,mime,size,data) VALUES(".$this->getIdTipoDoc().",".$this->getIdCarpeta().",'".$this->getName()."','".$this->getMime()."',".$this->getSize().",'".$this->getData()."');";
	if(!$this->query($sql)){
		echo "Error al guardar el documento:".$this->getError();
	  return false;
	}
	$this->setIdDocumento($this->getInsertId());
	return true;
 }

 function getLastId(){
 	$sql = "SELECT MAX(cns_documento) as id FROM detalle_documentos;";
 	$resultado = $this->query($sql);
 	if($dato = mysqli_fetch_assoc($resultado))
 		$this->setIdDocumento($dato['id']);
 	else
 		return 0;
 }

}