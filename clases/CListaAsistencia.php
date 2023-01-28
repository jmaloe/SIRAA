<?php
require_once('../db/ConexionDB.php');
require_once("../acceso/CPermisos.php");
require_once("CDocumento.php");

class CListaAsistencia extends ConexionDB{
 
  var $no_lista,
      $cns_regActividades,
 	    $no_registro,
      $id_tipoasistente,/*Asistente, Ponente, Instructor, Comite organizador*/
      $id_categoria,/*UNACH, EXTERNO*/
 	    $folio,
 	    $nombre_asistente, 
 	    $observaciones="", 
 	    $clave_evento, 
 	    $duracion;

  var $carpeta;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
    $this->carpeta = new CDocumento($db);
    global $permiso;
    $permiso_buscarTodosAsistentes = $permiso->getPermisos("BuscarTodosAsistentes");
    if(!$permiso_buscarTodosAsistentes['r']){
      $this->clausulaBusqueda = "AND la.usr_elaboro=".$_SESSION['ID_USER'];      
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

  function setNoLista($nl){
    $this->no_lista = $nl;
  }

 	function setIdEvento($id){
 		$this->cns_regActividades = $id;
 	}

 	function setNoRegistro($nr){
 		$this->no_registro = $nr;
 	}

  function setIdTipoAsistente($idta){
    $this->id_tipoasistente = $idta;
  }

  function setIdCategoria($cat){
    $this->id_categoria = $cat;
  }

 	function setFolio($ida){
 		$this->folio = $ida;
 	}

 	function setClaveEvento($clave){
 		$this->clave_evento = $clave;
 	}

 	function setNombreAsistente($nom){
 		$this->nombre_asistente = $this->scapeString($nom);
 	}

 	function setObservaciones($obs){
 		$this->observaciones = $this->scapeString($obs);
 	}

 	function setDuracion($hrs){
 		$this->duracion = $hrs;
 	}

 	function getFolio(){
 		return $this->folio;
 	}

  function uploadDocumentacion($file){
    $this->carpeta->setIdTipoDoc(3); //Lista de asistencia
    if($this->carpeta->guardarDocumento($file, "LA/"))
      return true;
    return false;
  }

  function getClasificacion(){
    $sql = "SELECT id_categoria, descripcion FROM categoria_asistente order by id_categoria";
    $res = $this->query($sql);
    $datos = array();
    while($dato = mysqli_fetch_assoc($res))
      $datos[$dato['id_categoria']] = $dato['descripcion'];
    return $datos;
  }

  function getLastDoc(){
    $sql = "SELECT cns_documento FROM detalle_documentos WHERE id_carpeta=".$this->carpeta->getIdCarpeta()." order by cns_documento DESC";
    $res = $this->query($sql);
    if($dato = mysqli_fetch_assoc($res))
      return $dato['cns_documento'];
    return 0;
  }

  function initLista(){
    $sql = "SELECT no_lista, id_carpeta FROM lista_asistencia WHERE cns_regActividades=".$this->cns_regActividades;
    $res = $this->query($sql);
    if($dato = mysqli_fetch_assoc($res))
    {
      $this->no_lista = $dato['no_lista'];
      $this->carpeta->setIdCarpeta($dato['id_carpeta']);
      return true;
    }
    else{      
      $this->carpeta->nuevaCarpeta();
      $sql = "INSERT INTO lista_asistencia(cns_regActividades,id_carpeta) VALUES(".$this->cns_regActividades.",".$this->carpeta->getIdCarpeta().");";
      if($this->query($sql))
      {
        $this->setNoLista($this->getInsertId());
        $this->carpeta->setTag("[LA:".$this->no_lista."]");
        $this->carpeta->updateCarpeta();
        return true;
      }
    }
    return false;
  }

	function guardarAsistente(){
		$sql = "INSERT INTO detalle_lista_asistencia(no_lista, id_tipoasistente, id_categoria, nombre_asistente, observaciones,usr_elaboro) VALUES(".$this->no_lista.",".$this->id_tipoasistente.",".$this->id_categoria.",'".$this->nombre_asistente."','".$this->observaciones."',".$_SESSION['ID_USER'].")";
		if($this->update($sql))
			return true;
		return false;
	}

	function eliminarAsistente(){
		$sql = "DELETE FROM detalle_lista_asistencia WHERE no_registro=".$this->no_registro;		
		if(!$this->update($sql))
		{			
			return false;
		}
		return true;
	}

	function generarFolio(){
    /*generamos el folio*/
    $sql = "SELECT CONCAT(ta.tag,COUNT(dla.no_registro)+1) FROM lista_asistencia la, detalle_lista_asistencia dla, tipo_asistente ta WHERE dla.no_lista=la.no_lista AND ta.id_tipoasistente=dla.id_tipoasistente AND dla.id_tipoasistente=(SELECT id_tipoasistente FROM detalle_lista_asistencia WHERE no_registro=".$this->no_registro.") AND la.cns_regActividades=".$this->cns_regActividades." AND dla.folio IS NOT NULL";
    $result = $this->query($sql);
    $folio="";
    if($fila = mysqli_fetch_row($result))
      $folio = $this->clave_evento.$fila[0];    
    /*revisamos que el participante no tenga folio*/
    $checkfolio = "SELECT folio from detalle_lista_asistencia where no_registro=".$this->no_registro;
    $resultado = $this->query($checkfolio);
    if($dato = mysqli_fetch_assoc($resultado)){
      if($dato['folio']!=null)
        return true;
    }
    /*asignamos el folio al participante*/
		$sql = "UPDATE detalle_lista_asistencia SET folio='".$folio."', usr_valido=".$_SESSION['ID_USER'].", fechaValidacion=CURDATE() WHERE no_registro=".$this->no_registro;
		if(!$this->update($sql)){
			return false;
		}
		else{
			return $folio;
		}
	}

	function getAsistentes(){
		//require_once("../acceso/CPermisos.php");
    global $permiso;
    	$permiso_aprobar = $permiso->getPermisos("AprobacionAsistentes");

	   	$sql="SELECT dla.no_registro, dla.folio, dla.nombre_asistente, dla.observaciones, dla.fechaCaptura, ca.descripcion as categoria, ta.descripcion as tipoasistente FROM lista_asistencia la, detalle_lista_asistencia dla, tipo_asistente ta, categoria_asistente ca WHERE dla.no_lista=la.no_lista AND ta.id_tipoasistente=dla.id_tipoasistente AND dla.id_categoria=ca.id_categoria AND la.cns_regActividades=".$this->cns_regActividades." order by ISNULL(dla.folio), dla.folio ASC;";	   
         $resultado = $this->query($sql);
         if($resultado)
         {
	         $data = "";
           $cont=1;
           $data.='<div class="doce separadorFila">
              <div class="separador">#</div>
              <div class="dos separador">
                <label>Folio</label>
              </div>
              <div class="separador tres">
                <label>Nombre</label>
              </div>
              <div class="dos separador">
                <label>Categoria</label>
              </div>
              <div class="dos separador">
                <label>Tipo</label>
              </div>
              <div class="tres separador">
                <label>Observaciones</label>
              </div>
              <div class="dos separador">
                <label>Fecha de registro</label>
              </div>
              </div>';
	         while($fila = mysqli_fetch_assoc($resultado)){
	         	$data.='<div class="doce separadorFila">
              <div class="separador">'.($cont++).'</div>
							<div class="dos separador">
								<label>'.$fila['folio'].'</label>
							</div>
							<div class="tres separador">
								<label>'.$fila['nombre_asistente'].'</label>
							</div>
              <div class="dos separador">
                <label>'.$fila['categoria'].'</label>
              </div>
              <div class="dos separador">
                <label>'.$fila['tipoasistente'].'</label>
              </div>
							<div class="uno separador">
								<label>'.$fila['observaciones'].'</label>
							</div>
              <div class="dos separador">
                <label>'.$fila['fechaCaptura'].'</label>
              </div>';

      				if($fila['folio']==NULL)
      				{
      					/*si tiene permisos para validar entonces genera el folio*/
      					if($permiso_aprobar['w'])
      					{
      						$data.='<button type="submit" name="accion" class="btn btn-success separador aprobar" value="a:?:'.$fila['no_registro'].'">Aprobar</button>';
      					}
      					else
      					{
      						$data.='<span style="color:orange"><b>Esperando folio</b></span>';
      					}
      					/*si no tiene folio se puede eliminar el registro*/
      					$data.='<button type="submit" name="accion" class="btn btn-danger eliminar" value="e:?:'.$fila['no_registro'].'">Eliminar</button>';
      				}
      				else{
      					$data.='<span style="color:green" class="separador"><b>Validado</b></span>';
      				}
      					$data.='</div>';
	         }
	       return $data;
   		 }
   		return null;
	}

	//búsqueda por numero de registro =  cns_regActividades
  function getByNoRegistro(){
  	$sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra WHERE ra.cns_regActividades=la.cns_regActividades AND dla.no_lista=la.no_lista AND la.cns_regActividades=".$this->obj_criteriosbusqueda->getNoRegistro()." ".$this->clausulaBusqueda.";";   
  	return $this->buscar($sql);
  }

  //búsqueda por clave del evento
  function getByClave(){
    $sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra WHERE ra.cns_regActividades=la.cns_regActividades AND dla.no_lista=la.no_lista AND ra.clave='".$this->obj_criteriosbusqueda->getClave()."' ".$this->clausulaBusqueda.";";
    return $this->buscar($sql);
  }

  //búsqueda por nombre del evento
  function getByName(){
    $sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra, catalogo_actividades ca WHERE ra.cns_regActividades=la.cns_regActividades AND dla.no_lista=la.no_lista AND ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.descripcion LIKE '%".$this->obj_criteriosbusqueda->getNombre()."%' ORDER BY ra.clave,dla.folio;";
    return $this->buscar($sql);
  }

  //búsqueda por tipo de evento, incluye fecha inicial y final
  function getByType(){
    if($this->obj_criteriosbusqueda->getTipo()=="*")
    {
      if($this->obj_criteriosbusqueda->getFechaInicial()!=null)
        $sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND dla.no_lista=la.no_lista AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.cns_regActividades=la.cns_regActividades ".$this->clausulaBusqueda." AND ra.fechaCaptura BETWEEN '".$this->obj_criteriosbusqueda->getFechaInicial()."' AND '".$this->obj_criteriosbusqueda->getFechaFinal()."' ORDER BY ra.clave;";
      else
        $sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND dla.no_lista=la.no_lista AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.cns_regActividades=la.cns_regActividades ".$this->clausulaBusqueda." ORDER BY ra.clave;";
    }
    else
    {
      if($this->obj_criteriosbusqueda->getFechaInicial()!=null)
        $sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND dla.no_lista=la.no_lista AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.cns_regActividades=la.cns_regActividades AND aa.id_actividadAcademica=".$this->obj_criteriosbusqueda->getTipo()." ".$this->clausulaBusqueda." AND ra.fechaCaptura BETWEEN '".$this->obj_criteriosbusqueda->getFechaInicial()."' AND '".$this->obj_criteriosbusqueda->getFechaFinal()."' ORDER BY ra.clave;";
      else
        $sql = "SELECT la.cns_regActividades, ra.clave, dla.folio, dla.nombre_asistente, dla.observaciones, IF(dla.usr_valido>0,'<span style=\"color:green\">Validado</span>','<span style=\"color:red\">Sin validar</span>') AS estatus FROM lista_asistencia la, detalle_lista_asistencia dla, Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND dla.no_lista=la.no_lista AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.cns_regActividades=la.cns_regActividades AND aa.id_actividadAcademica=".$this->obj_criteriosbusqueda->getTipo()." ".$this->clausulaBusqueda." ORDER BY ra.clave;";
    }
    return $this->buscar($sql);
  }

  function buscar($sql){
    $resultado = $this->query($sql);
    return $this->getRowsTableItems($resultado);    
  }

  function getTotalFilas(){
    return $this->getNumRows();
  }
	
}
?>