<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

 class CBusquedaActividades extends ConexionDB{

  function __construct($db)
  {
 	  parent::__construct($db);
    require_once("../acceso/CPermisos.php");
    global $permiso;
    $permiso_buscarTodasActs = $permiso->getPermisos("BuscarTodasActs");
    if(!$permiso_buscarTodasActs['r']){
      $this->clausulaBusqueda = "AND usr_elaboro=".$_SESSION['ID_USER'];
    }
  }

  var $obj_criteriosbusqueda=null;
  var $clausulaBusqueda="";

  function setCriteriosBusqueda($obj){
    $this->obj_criteriosbusqueda = $obj;
  }

  function generarConsulta(){
    if($this->obj_criteriosbusqueda)
      return $this->obj_criteriosbusqueda->generarReporte($this);
    return null;
  }  

  //búsqueda por numero de registro =  cns_regActividades
  function getByNoRegistro(){    
  	$sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." AND ra.cns_regActividades=".$this->obj_criteriosbusqueda->getNoRegistro().";";
  	return $this->buscar($sql);
  }

  //búsqueda por clave del evento
  function getByClave(){
    $sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." AND ra.clave='".$this->obj_criteriosbusqueda->getClave()."';";
    return $this->buscar($sql);
  }

  //búsqueda por nombre del evento
  function getByName(){
    $sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." AND ca.descripcion like '%".$this->obj_criteriosbusqueda->getNombre()."%';";
    return $this->buscar($sql);
  }

  //búsqueda por tipo de evento, incluye fecha inicial y final
  function getByType(){
    if($this->obj_criteriosbusqueda->getTipo()=="*")
    {
      if($this->obj_criteriosbusqueda->getFechaInicial()!=null)
        $sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." AND ra.fechaCaptura BETWEEN '".$this->obj_criteriosbusqueda->getFechaInicial()."' AND '".$this->obj_criteriosbusqueda->getFechaFinal()."' ORDER BY ra.cns_regActividades DESC;";      
      else
        $sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." ORDER BY ra.cns_regActividades DESC;";      
    }
    else
    {
      if($this->obj_criteriosbusqueda->getFechaInicial()!=null)
        $sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." AND aa.id_actividadAcademica=".$this->obj_criteriosbusqueda->getTipo()." AND ra.fechaCaptura BETWEEN '".$this->obj_criteriosbusqueda->getFechaInicial()."' AND '".$this->obj_criteriosbusqueda->getFechaFinal()."' ORDER BY ra.cns_regActividades DESC;";      
      else
        $sql = "SELECT ra.cns_regActividades,ra.clave,aa.nombreActividad, ca.descripcion, mo.descripcion, ra.duracion,ra.fecha_inicio,ra.fecha_termino,ra.cupoMinimo,ra.fechaCaptura,ra.usr_cancelo FROM Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_modalidad=mo.id_modalidad ".$this->clausulaBusqueda." AND aa.id_actividadAcademica=".$this->obj_criteriosbusqueda->getTipo()." ORDER BY ra.cns_regActividades DESC;";
    }
    return $this->buscar($sql);
  }

  function buscar($sql){
    $resultado = $this->query($sql);
    require_once("../acceso/CPermisos.php");
    global $permiso;
    $permiso_aprobar = $permiso->getPermisos("AprobacionActs");
    $permiso_cancelar = $permiso->getPermisos("CancelacionActs");
    $datos="";
    $id=0;
    $clave="";
    $quiencancelo=false;
    while($fila = mysqli_fetch_row($resultado)){
      $datos.="<tr>";       
      foreach ($fila as $key => $value){
        if($key==0)
        {
          $id=$value;
          $datos.='<td align="center">'.$id.'</td>';
        }
        else if($key<10)
        {
        if($key==2)
          $datos.='<td align="center"><div class="icono '.str_replace(" ", "", $value).'" title="'.$value.'"></div></td>';
        else if($key==3)
        {
          /*0=pendiente, 1=aprobado, 2=cancelado*/
          if(!empty($clave) & $fila[10]==0)
            $datos.='<td class="actividad_evento" id="'.$fila[0].'" estatus="1">'.$value.'</td>';
          else if($fila[10]==1)
            $datos.='<td class="actividad_evento" id="'.$fila[0].'" estatus="2">'.$value.'</td>';
          else
            $datos.='<td class="actividad_evento" id="'.$fila[0].'" estatus="0">'.$value.'</td>';
        }
        else if($key==4)
          $datos.='<td align="center"><div class="icono '.str_replace(" ", "", $value).'" title="'.$value.'"></div></td>';          
        else
          $datos.="<td>".$value."</td>";
        }
        if($key==1)
          $clave=$value;
        if($key==10)
          $quiencancelo = $value;
      }
      if($permiso_aprobar['w'])
      {
        if(empty($clave))
          $datos.='<td align="center"><span class="btn btn-success aprobar" id="'.$id.'">Aprobar</span></td>';        
      }
      else
      {
        if(empty($clave))
          $datos.='<td align="center"><span style="color:blue"><b>Pendiente</b></span></td>';
      }
      if($permiso_cancelar['w'])
      {
        if(!empty($clave) & $quiencancelo==0)
          $datos.='<td align="center"><span class="btn btn-danger cancelar_aprobacion" id="'.$id.'">Cancelar</span></td>';
      }
      else
      {
        if(!empty($clave) & $quiencancelo==0)
        $datos.='<td align="center"><span style="color:green"><b>Aprobado</b></span></td>';
      }
      if($quiencancelo>0)
        $datos.='<td align="center"><span style="color:red"><b>Cancelado</b></span></td>';
        
      $id=0;
      $datos.="</tr>";
      $clave="";
    }
    return $datos;    
  }

  function getTotalFilas(){
    return $this->getNumRows();
  }

 }
?>