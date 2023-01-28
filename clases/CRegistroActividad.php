<meta charset="utf-8" />
<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
 require_once('../db/ConexionDB.php');
 require_once("../db/AccessDB.php");
 require_once("CPersona.php");
 require_once("CParticipantes.php");
 require_once("CTemario.php");
 require_once("CDetalleTemario.php");
 require_once("CDocumento.php");
 require_once("CSesiones.php");
 require_once("CRequisito.php");
 
 $obj_temario = new CTemario($db);
 $obj_det_temario = new CDetalleTemario($db);
 $participantes = new CParticipantes($db);
 $objDocumento = new CDocumento($db);
 $objSesion = new CSesiones($db);
 $objRequisitos = new CRequisito($db);

 session_start();

 class RegistroActividad extends ConexionDB{

  function __construct()
  {
  	global $db;
 	parent::__construct($db);
  }

 var $is_update=false,
 	 $id_tipo_actividad,
 	 $id_catalogoactividades,
 	 $id_dependencia,
 	 $cns_regActividades,
	 $clave_actividad,
 	 $id_temario, 	 
 	 $id_reg_requisito,
 	 $nombre_actividad,
 	 $modalidad_curso,
 	 $id_sede, 	 
 	 $duracion,
 	 $f_apertura,
 	 $f_cierre,
 	 $tiempoP_IIP,
 	 $tiempoP_PDDAA,
 	 $id_programa,
 	 $id_areaconocimiento,
 	 $id_validacion,
 	 $id_tipopublico,
 	 $f_inicio,
 	 $f_termino,
 	 $cupo_minimo,
 	 $cupo_maximo,
 	 $cuota_unach,
 	 $cuota_externos,
 	 $objetivo_temario,
 	 $criterios,
 	 $bibliografia,
 	 $aplico_dnc;

 	 function setIsUpdate($iu){
 	 	$this->is_update = $iu;
 	 }

 	 function setIdTipoActividad($t_a){
 	 	$this->id_tipo_actividad = $t_a;
 	 	$sql = "SELECT nombreActividad FROM actividad_academica WHERE id_actividadAcademica=".$t_a;
 	 	$resultado = $this->query($sql);
 	 	if($dato = mysqli_fetch_assoc($resultado))
 	 		echo "<b>Tipo de Actividad: </b>".$dato['nombreActividad']."<br>";
 	 }

 	 function setIDRegistroActividad($id){
 	 	$this->cns_regActividades = $id;
 	 }

 	 function setActividad($id, $nombre){
 	 	$this->nombre_actividad = $nombre;
 	 	if($id > 0)
 	 	{
			$this->id_catalogoactividades = $id;
 	 	}
 	 	else
 	 	{
 	 		require_once("CCatalogoActividades.php"); 	 		
 	 		global $db;
 	 		$catalogo = new CCatalogoActividades($db);
 	 		$catalogo->setIdActividad($this->id_tipo_actividad);
 	 		$catalogo->setDescripcionActividad($nombre);
 	 		$catalogo->registrarActividadEnCatalogo();
 	 		$this->id_catalogoactividades = $catalogo->getIdActCat();
 	 	}

 	 	echo "<b>Nombre de la actividad: </b>".$nombre."<br>"; 	 	
 	 }

 	 function setIdDependencia($id_dep, $nombre){
 	 	$this->id_dependencia = $id_dep;
 	 	echo "<b>Dependencia: </b>".$nombre."<br>";
 	 }

 	 function setModalidadCurso($modalidad){
 	 	$this->modalidad_curso = $modalidad;
 	 	$desc = "";
 	 	if($modalidad==1)
 	 		$desc = "Presencial";
 	 	else if($modalidad==2)
 	 		$desc = "Virtual";
 	 	else
 	 		$desc = "Mixto";
 	 	echo "<b>Modalidad Curso: </b>".$desc."<br>";
 	 }

 	 function setIdSede($sede, $nombre){
 	 	$this->id_sede = $sede;
 	 	echo "<b>Id Sede: </b>".$nombre."<br>";
 	 } 	 

 	 function setDuracion($d){
 	 	$this->duracion = $d;
 	 	echo "<b>Duración: </b>".$this->duracion."<br>";
 	 }

 	 function setFechaAperturaCierre($f_a, $f_c){
 	 	$this->f_apertura = $f_a;
 	 	$this->f_cierre = $f_c;
 	 	echo "<b>Fecha de apertura: </b>".$this->f_apertura."<br>";
 	 	echo "<b>Fecha de cierre: </b>".$this->f_cierre."<br>";
 	 }

 	 function setTiempoP_IIP($tiempo){
 	 	$this->tiempoP_IIP = $this->scapeString($tiempo);
 	 	echo "<br><b>Tiempo promedio de interación de los instructores con los participantes: </b>".$this->tiempoP_IIP."<br>";
 	 }

 	 function setTiempoP_PDDAA($tiempo){
 	 	$this->tiempoP_PDDAA = $this->scapeString($tiempo);
 	 	echo "<b>Tiempo promedio que el participante deberá dedicar a las actividades de aprendizaje: </b>".$this->tiempoP_PDDAA."<br>"; 	 
 	 }

 	 function setProgramaEducativo($id_p, $nombre){
 	 	$this->id_programa = $id_p;
 	 	if($id_p==0)
 	 		$nombre="No especificado";
 	 	echo "<b>Programa educativo: </b>".$nombre."<br>"; 	 
 	 }

 	 function setAreaConocimiento($id_ac, $nombre)
 	 {
 	 	if($id_ac > 0)
 	 	{
 	 		$this->id_areaconocimiento = $id_ac; /*guardamos el id si es mayor a 0*/
 	 	}
 	 	else
 	 	{
 	 		require_once("CAreaConocimiento.php");
 	 		global $db;
 	 		$area = new CAreaConocimiento($db);
 	 		$area->setNombreArea($nombre);
 	 		$area->registrarArea();
 	 		$this->id_areaconocimiento = $area->getIdArea(); /*guardamos el nombre cuando id sea 0*/
 	 	}
 	 	echo "<b>Área de conocimiento: </b>".$nombre."<br>"; 	 
 	 }

 	 function setValidacion($id_v, $nombre)
 	 {
 	 	if($id_v > 0)
 	 	{
 	 		$this->id_validacion = $id_v;
 	 	}
 	 	else
 	 	{
 	 		require_once("CValidacion.php");
 	 		global $db;
 	 		$validacion =  new CValidacion($db);
 	 		$validacion->setNombreValidacion($nombre);
 	 		$validacion->registrarValidacion();
 	 		$this->id_validacion = $validacion->getIdValidacion();
 	 	}
 	 	echo "<b>Validación: </b>".$nombre."<br>";
 	 }

 	 function setTipoPublico($id_tp, $nombre)
 	 {
 	 	if($id_tp > 0)
 	 	{
 	 		$this->id_tipopublico = $id_tp;
 	 	}
 	 	else
 	 	{
 	 		require_once("CTipoPublico.php");
 	 		global $db;
 	 		$publico = new CTipoPublico($db);
 	 		$publico->setDescripcionTipo($nombre);
 	 		$publico->registrarTipoPublico();
 	 		$this->id_tipopublico = $publico->getIdTipoPublico();
 	 	}
 	 	echo "<b>Tipo de público: </b>".$nombre."<br>";
 	 }

 	 function setFechaInicioTermino($f_i, $f_t){
 	 	$this->f_inicio = $f_i;
 	 	$this->f_termino = $f_t;
 	 	echo "<br><b>Fecha de inicio: </b>".$this->f_inicio."<br>";
 	 	echo "<b>Fecha de término: </b>".$this->f_termino."<br>";
 	 }

 	 function setCupo($min, $max){
 	 	$this->cupo_minimo = $min;
 	 	$this->cupo_maximo = $max;
 	 	echo "<b>Cupo mínimo: </b>".$this->cupo_minimo."<br>";
 	 	echo "<b>Cupo máximo: </b>".$this->cupo_maximo."<br>";
 	 }

 	 function setCuotas($unach, $externos){
 	 	$this->cuota_unach = $unach;
 	 	$this->cuota_externos = $externos;
 	 	echo "<b>Cuota unach: </b>".$this->cuota_unach."<br>";
 	 	echo "<b>Cuota externos: </b>".$this->cuota_externos."<br>"; 	 
 	 }

 	 function setMaterialDidactico($material){
 	 	global $obj_temario, $objDocumento;

 	 	echo "<br><b>MATERIAL DIDACTICO</b><br>";
 	 	if($material['name']!="")
 	 		echo $material['name']."<br>";
 	 	else
 	 		echo "No se adjuntó material didáctico";
 	 	//echo $material['type']." - ";
 	 	//echo $material['tmp_name']." - ";
 	 	//echo $material['size']."<br>";

		$objDocumento->setIdTipoDoc(2); //temario
		$objDocumento->setIdCarpeta($obj_temario->getIdCarpeta());
		echo $objDocumento->guardarDocumento($material, 'TEMARIO/');
 	 }

 	 function setObjetivoTemario($obj){
 	 	$this->objetivo_temario = $obj;
 	 }

 	 function setCriteriosEvaluacion($criterios){
 	 	$this->criterios = $criterios; 	 	
 	 }

 	 function setBibliografia($bibliografia){
 	 	$this->bibliografia = $bibliografia; 	 	
 	 }

 	 function setAplicoDNC($tof){
 	 	$this->aplico_dnc = $tof; 	 	
 	 }

 	 function getCriterios(){
 	 	echo "<br><b>Criterios: </b>".$this->criterios."<br>";
 	 }

 	 function getBibliografia(){
 	 	echo "<b>Bibliografia: </b>".$this->bibliografia."<br>";
 	 }

 	 function getAplicoDNC(){
 	 	if($this->aplico_dnc==1)
 	 		echo "<b>Aplicó DNC: </b>Si<br>";
 	 	else
 	 		echo "<b>Aplicó DNC: </b>No<br>"; 	 	
 	 }

 	 function registrarTemario(){
 	 	global $obj_temario, $obj_det_temario;
 	 	$obj_temario->setNombreTemario($this->nombre_actividad);
 	 	//$obj_temario->setObjetivo($this->objetivo_temario);
 	 	$obj_temario->setCriteriosEvaluacion($this->criterios);
 	 	$obj_temario->setBibliografia($this->bibliografia);
 	 	$obj_temario->nuevoTemario();
 	 	$this->id_temario = $obj_temario->getIdTemario();
 	 	$obj_det_temario->setIdTemario($this->id_temario);
 	 }

 	 function registrarTema($obj){
 	 	global $obj_det_temario;
 	 	$obj_det_temario->setModulo($obj["modulo"]);
 	 	$obj_det_temario->setTemasSubtemas($obj["temas_subtemas"]);
 	 	$obj_det_temario->setProposito($obj["proposito"]);
 	 	$obj_det_temario->setEstrategiasDid($obj["estrategias"]);
 	 	$obj_det_temario->setMaterialesDid($obj["materiales_didacticos"]);
 	 	$obj_det_temario->setHorasTeoricas($obj["horas_teoricas"]);
 	 	$obj_det_temario->setHorasPracticas($obj["horas_practicas"]);
 	 	$obj_det_temario->registrarDetalleTemario();
 	 }

 	 function registrarActividad(){
 	 	if($this->is_update){
 	 		$sql = "UPDATE Registro_Actividades SET id_catalogoactividades=".$this->id_catalogoactividades.",".
 	 											"id_programaEducativo=".$this->id_programa.",".
 	 											"id_areaConocimiento=".$this->id_areaconocimiento.",".
 	 											"id_temario=".$this->id_temario.",".
 	 											"id_tipoValidacion=".$this->id_validacion.",".
 	 											"id_tipoPublico=".$this->id_tipopublico.",".
 	 											"id_sede=".$this->id_sede.",".
 	 											"id_dependencia=".$this->id_dependencia.",".
 	 											"id_modalidad=".$this->modalidad_curso.",".
 	 											"duracion='".$this->duracion."',". 	 											
 	 											"fecha_inicio='".$this->scapeString($this->getFechaToMysql($this->f_inicio))."',".
 	 											"fecha_termino='".$this->scapeString($this->getFechaToMysql($this->f_termino))."',".
 	 											"cupoMinimo=".$this->cupo_minimo.",".
 	 											"cupoMaximo=".$this->cupo_maximo.",".
 	 											"costoUnach=".$this->cuota_unach.",".
 	 											"costoExternos=".$this->cuota_externos.",".
 	 											"aplico_dnc=".$this->aplico_dnc.												
												" WHERE cns_regActividades=".$this->cns_regActividades;			
			if(!$this->update($sql))
				echo $this->getError();
 	 	}
 	 	else{
 	 		$sql = "INSERT INTO Registro_Actividades(id_catalogoactividades,".
 	 											"id_programaEducativo,".
 	 											"id_areaConocimiento,".
 	 											"id_temario,".
 	 											"id_tipoValidacion,".
 	 											"id_tipoPublico,".
 	 											"id_sede,".
 	 											"id_dependencia,".
 	 											"id_modalidad,".
 	 											"duracion,". 	 											
 	 											"fecha_inicio,".
 	 											"fecha_termino,".
 	 											"cupoMinimo,".
 	 											"cupoMaximo,".
 	 											"costoUnach,".												
 	 											"costoExternos,".
 	 											"aplico_dnc,".
												"usr_elaboro)".
							" VALUES(".$this->id_catalogoactividades.
									",".$this->id_programa.
									",".$this->id_areaconocimiento.
									",".$this->id_temario.
									",".$this->id_validacion.
									",".$this->id_tipopublico.
									",".$this->id_sede.
									",".$this->id_dependencia.
									",".$this->modalidad_curso.
									",'".$this->duracion."'".									
									",'".$this->scapeString($this->getFechaToMysql($this->f_inicio))."'".
									",'".$this->scapeString($this->getFechaToMysql($this->f_termino))."'".
									",".$this->cupo_minimo.
									",".$this->cupo_maximo.
									",".$this->cuota_unach.
									",".$this->cuota_externos.
									",".$this->aplico_dnc.
									",".$_SESSION["ID_USER"].");";
			$this->query($sql);
    		$this->cns_regActividades = $this->getInsertId();
    		if($this->getError()!="")
    	 		echo $this->getError();
 	 	}    	
 	 }

 	 function printInfoActividad(){
 	 	if($this->is_update){
 	 		echo "<br><p><b>Actividad actualizada: ".$this->cns_regActividades."</b></p>";
 	 		return;
 	 	}
 	 	echo "<br><p><b>Actividad registrada con número: ".$this->cns_regActividades."</b></p>";
 	 	echo '<p>"Gracias por registrar su curso, en 3 días hábiles se les enviará la clave de registro".</p>';
 	 	echo '<p><i>"Por la conciencia de la necesidad de servir"</i></p>';
 	 }

 	 function agregarSesion(){
		global $objSesion;
		$objSesion->setRegActividades($this->cns_regActividades);
		if($this->is_update)			
			$objSesion->eliminarSesion();
 	 	$objSesion->setFechaApertura($this->f_apertura);
 	 	$objSesion->setFechaCierre($this->f_cierre);
 	 	$objSesion->agregarSesion(); 	 	
 	 }

 	 function agregarDetalleSesion($sesion){
		 global $objSesion;
 	 	$objSesion->agregarDetalleSesion($sesion); 	 	
 	 }

 	 function setParticipantes(){
 	 	global $participantes; 	 	
 	 	$tag = "[EVT:".$this->id_tipo_actividad." ACT:".$this->cns_regActividades."]";
 	 	$participantes->setRegActividades($this->cns_regActividades);
 	 	if($this->is_update)
 	 		$participantes->eliminarParticipantes(); //eliminamos datos anteriores
 	 	$participantes->addParticipantes($tag); //nuevo registro de participantes
 	 }

 	 /*eliminar participantes cuando sea una actualizacion de la actividad*/
 	 function eliminarParticipantes(){
 	 	global $participantes;
 	 	$participantes->setRegActividades($this->cns_regActividades);
 	 	$participantes->eliminarParticipantes();
 	 }

 	 function addOrganizador($persona){
 	 	require_once("COrganizador.php");
 	 	global $db, $participantes;
 	 	$organizador = new COrganizador($db);
 	 	$organizador->setIdPersona($persona['id_responsable']);
 	 	$organizador->getOrganizadorById();
 	 	if($organizador->getIdOrganizador()==0)
 	 		$organizador->registrarOrganizador();
 	 	
 	 	$participantes->setIdParticipante($organizador->getIdOrganizador());
 	 	//$participantes->setRegParticipantes($this->id_participantes);
 	 	$participantes->setOrganizador();
 	 	//$organizador->getPersonaById(); //obtenemos todos los datos de la persona
 	 	echo "[".$organizador->getIdOrganizador()."] ".$persona['nombre'];
 	 }

 	 function addCoordinador($persona, $curriculum){
 	 	require_once("CCoordinador.php");
 	 	global $db, $participantes, $objDocumento;
 	 	$coordinador = new CCoordinador($db);
 	 	$coordinador->setIdPersona($persona['id']);
 	 	$coordinador->getCoordinadorById();
 	 	if($coordinador->getIdCoordinador()==0)
 	 		$coordinador->registrarCoordinador();
 	 	
 	 	$participantes->setIdParticipante($coordinador->getIdCoordinador());
 	 	//$participantes->setRegParticipantes($this->id_participantes);
 	 	$participantes->setCoordinador();
 	 	if($curriculum!=""){
 	 		$objDocumento->setIdTipoDoc(1);
    		$objDocumento->setIdCarpeta($coordinador->getIdCarpeta());
    		echo $objDocumento->guardarDocumento($curriculum, 'CV/');
    	}
 	 	/*consultamos los datos de la persona para mostrarlos en el resumen*/
 	 	$coordinador->getPersonaById();
 	 	echo "[".$coordinador->getIdCoordinador()."] ".$coordinador->getNombre()." ".$coordinador->getApellidoPaterno()." ".$coordinador->getApellidoMaterno();
 	 }

 	 function addResponsableCDC($persona, $curriculum){
 	 	require_once("CResponsableCDC.php");
 	 	global $db, $participantes, $objDocumento;
 	 	$responsable_cdc = new CResponsableCDC($db);
 	 	$responsable_cdc->setIdPersona($persona['id']);
 	 	$responsable_cdc->getResponsableCDCById();
 	 	if($responsable_cdc->getIdResponsableCDC()==0)
 	 		$responsable_cdc->registrarResponsableCDC();
 	 	
 	 	$participantes->setIdParticipante($responsable_cdc->getIdResponsableCDC());
 	 	//$participantes->setRegParticipantes($this->id_participantes);
 	 	$participantes->setResponsableCDC();
 	 	if($curriculum!=""){
 	 		$objDocumento->setIdTipoDoc(1);
    		$objDocumento->setIdCarpeta($responsable_cdc->getIdCarpeta());
	    	echo $objDocumento->guardarDocumento($curriculum, 'CV/');
    	}
 	 	/*consultamos los datos de la persona para mostrarlos en el resumen*/
 	 	$responsable_cdc->getPersonaById();
 	 	echo "[".$responsable_cdc->getIdResponsableCDC()."] ".$responsable_cdc->getNombre()." ".$responsable_cdc->getApellidoPaterno()." ".$responsable_cdc->getApellidoMaterno()."<br>";
 	 }

 	 function addFormador($persona, $curriculum){
 	 	require_once("CFormador.php"); 	 	
 	 	global $db, $participantes, $objDocumento;
 	 	$formador = new CFormador($db); 	 	
 	 	$formador->setIdPersona($persona['id']);
 	 	$formador->getFormadorById();
 	 	$formador->setTipoFormador($persona['tipo']);
 	 	if($formador->getIdFormador()==0)
 	 		$formador->registrarFormador();
 	 	else
 	 		$formador->actualizarFormador();
 	 	
 	 	$participantes->setIdParticipante($formador->getIdFormador());
 	 	//$participantes->setRegParticipantes($this->id_participantes);
 	 	$participantes->setFormador();
 	 	if($curriculum!=""){
 	 		$objDocumento->setIdTipoDoc(1);
    		$objDocumento->setIdCarpeta($formador->getIdCarpeta());
	    	echo $objDocumento->guardarDocumento($curriculum, 'CV/');
    	}
 	 	/*consultamos los datos de la persona para mostrarlos en el resumen*/
 	 	$formador->getPersonaById();
 	 	echo "[".$formador->getIdFormador()."] ".$formador->getNombre()." ".$formador->getApellidoPaterno()." ".$formador->getApellidoMaterno()."<br>";
 	 }

 	 function addRegistroRequisitos(){
 	 	global $objRequisitos;
 	 	$objRequisitos->setRegActividades($this->cns_regActividades);
 	 	if($this->is_update)
 	 		$objRequisitos->eliminarRequisitos(); //borramos datos anteriores para reemplazar por los modificados
 	 	$objRequisitos->addRegistroRequisitos(); 	 	
 	 }
 	 
 	 function addDetalleRegRequisitos($requisito, $valor){
 	 	global $objRequisitos;
 	 	echo $objRequisitos->addDetalleRegRequisitos($requisito, $valor);
 	 }

 	 /*asignar primero el cns_regActividades y luego invocar esta funcion*/
 	 function generarClave(){
 	 	/*buscamos a que tipo de actividad pertenece el registro*/
 	 	$this->getIdTipoActividadPorRegistro();
 	 	//revisamos que no haya clave
 	 	$checkclave = "SELECT clave from Registro_Actividades where cns_regActividades=".$this->cns_regActividades;
 	 	$res = $this->query($checkclave);
 	 	if($dato = mysqli_fetch_assoc($res)){
 	 		if($dato['clave']!=null)
 	 			return true;
 	 	}
 	 	/*generamos la clave*/
 	 	$sql = "SELECT CONCAT(aa.prefijo,'-',YEAR(CURDATE()),'-',count(ra.cns_regActividades)+1) FROM actividad_academica aa, catalogo_actividades ca, Registro_Actividades ra WHERE aa.id_actividadAcademica=ca.id_actividadAcademica AND ra.id_catalogoactividades=ca.id_catalogoactividades AND ra.clave IS NOT NULL AND aa.id_actividadAcademica=".$this->id_tipo_actividad.";";
 	 	$resultado = $this->query($sql);
 	 	if($fila = mysqli_fetch_row($resultado)){
 	 		$clave = $fila[0];
 	 		$sql = "UPDATE Registro_Actividades SET clave='".$clave."', fechaAprobacion=CURDATE(), usr_aprobo=".$_SESSION["ID_USER"]." WHERE cns_regActividades=".$this->cns_regActividades.";";
 	 		if($this->update($sql)){
 	 			return $clave;
 	 		}
 	 	}
 	 }

 	 function cancelarRegistro(){
 	 	$sql = "UPDATE Registro_Actividades SET fechaCancelacion=CURDATE(), usr_cancelo=".$_SESSION["ID_USER"]." WHERE cns_regActividades=".$this->cns_regActividades;
 	 	if($this->update($sql)){
 	 		return true;
 	 	}
 	 }

 	 function getIdTipoActividadPorRegistro(){
 	 	$sql = "SELECT ca.id_actividadAcademica FROM catalogo_actividades ca, Registro_Actividades ra WHERE ca.id_catalogoactividades=ra.id_catalogoactividades AND ra.cns_regActividades=".$this->cns_regActividades;
 	 	$resultado = $this->query($sql);
 	 	if($fila = mysqli_fetch_row($resultado)){
 	 		$this->id_tipo_actividad = $fila[0];
 	 	}
 	 }

 	 function getActividadById(){
 	 	$sql = "SELECT * FROM Registro_Actividades where cns_regActividades=".$this->cns_regActividades;
 	 	$resultado = $this->query($sql);
 	 	if($fila = mysqli_fetch_assoc($resultado))
 	 		return $fila;
 	 	return null;
 	 }
 }
?>