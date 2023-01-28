<?php
/*support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

class CTipoActividad extends ConexionDB{

 var $id_tipo, $descripcion_tipo;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 function setIdTipo($id){
 	$this->id_tipo =  $id;
 }

 function setDescripcionTipo($desc){
 	$this->descripcion_tipo = $this->scapeString($desc);
 }

 function getIdTipo(){
 	return $this->id_tipo;
 }

 function getDescripcionTipo(){
 	return $this->descripcion_tipo;
 }

 function registrarTipoActividad(){
 	$sql = "INSERT INTO tipo_actividad(descripcion) VALUES('".$this->descripcion_tipo."');";
	$this->query($sql);
	$this->setIdTipo($this->getInsertId());	 
 }

 function getTiposActividades(){
 	$sql = "SELECT * from tipo_actividad ORDER BY id_tipoactividad";
  	$resultado = $this->query($sql);
  	$tiposActs = mysqli_fetch_array($resultado,MYSQLI_ASSOC);
   	return $tiposActs;
 }

 function buscarTipoActividadByActividadAcademica($id_actividad){
 	$sql = "SELECT ta.id_tipoactividad, ta.descripcion from actividad_academica aa, tipo_actividad ta where aa.id_tipoactividad=ta.id_tipoactividad and aa.id_actividadAcademica=".$id_actividad;
 	$resultado = $this->query($sql);
 	if($dato = mysqli_fetch_row($resultado)){
 		$this->setIdTipo($dato[0]);
 		$this->setDescripcionTipo($dato[1]);
 	}
 }

}
?>