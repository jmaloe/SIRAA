<?php
/*support: dic.malo@gmail.com*/
require_once('CTipoActividad.php');

class CActividad extends CTipoActividad{

  var $id_actividad, $nombreActividad, $definicion;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 function setIdActividad($id){
  $this->id_actividad = $id;
 }

 function setNombreActividad($nombre){
  $this->nombreActividad = $nombre;
 }

 function setDefinicion($def){
  $this->definicion = $def;
 }

 function getIdActividad(){
  return $this->id_actividad;
 }

 function getNombreActividad(){
  return $this->nombreActividad;
 }

 function getDefinicion(){
  return $this->definicion;
 }

	function getActividades(){
		$sql="SELECT ta.id_tipoactividad,ta.descripcion,aa.id_actividadAcademica,aa.nombreActividad from tipo_actividad ta, actividad_academica aa WHERE ta.id_tipoactividad=aa.id_tipoactividad ORDER BY ta.id_tipoactividad, aa.id_actividadAcademica;";
        $resultado = $this->query($sql);
        return $this->getOptionGroupsItems($resultado);       
	}

  function getActividadByIdCatalogo($id){
    $sql="SELECT aa.id_actividadAcademica, aa.nombreActividad from actividad_academica aa, catalogo_actividades ca WHERE aa.id_actividadAcademica=ca.id_actividadAcademica AND ca.id_catalogoactividades=".$id;
    $resultado = $this->query($sql);
    $datos = mysqli_fetch_row($resultado);
    return $datos;
  }

  function getActividadByCnsRegActividad($cns_regActividades){
    $sql="SELECT aa.id_actividadAcademica, aa.nombreActividad from actividad_academica aa, catalogo_actividades ca, Registro_Actividades ra WHERE aa.id_actividadAcademica=ca.id_actividadAcademica AND ca.id_catalogoactividades=ra.id_catalogoactividades AND ra.cns_regActividades=".$cns_regActividades;
    $resultado = $this->query($sql);
    $datos = mysqli_fetch_row($resultado);
    return $datos;
  }

}
?>