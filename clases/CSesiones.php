<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
 require_once("../db/ConexionDB.php");

 class CSesiones extends ConexionDB{
 	var $cns_regActividades,
 		$fecha_apertura,
 		$fecha_cierre,
 		$id_sesion;

 	function __construct($db)
	{
    	parent::__construct($db); /*invocar el constructor de la clase padre*/
 	}

 	//setters
 	function setRegActividades($reg){
 		$this->cns_regActividades = $reg;
 	}

 	function setIdSesion($id){
 		$this->id_sesion = $id;
 	}

 	function setFechaApertura($fa){
 		$this->fecha_apertura = $this->scapeString($this->getFechaToMysql($fa));
 	}

 	function setFechaCierre($fc){
 		$this->fecha_cierre = $this->scapeString($this->getFechaToMysql($fc));
 	}

 	//getters
 	function getRegActividades(){
 		return $this->cns_regActividades;
 	}

 	function getIdSesion(){
 		return $this->id_sesion;
 	}

 	function getFechaApertura(){
 		return $this->fecha_apertura;
 	}

 	function getFechaCierre(){
 		return $this->fecha_cierre;
 	}

 	function agregarSesion(){
 	 	$sql = "INSERT INTO sesiones(cns_regActividades,fechaApertura,fechaCierre) VALUES(".$this->cns_regActividades.",'".$this->fecha_apertura."','".$this->fecha_cierre."');";
 	 	$this->query($sql);
 	 	$this->id_sesion = $this->getInsertId();
 	}

 	function agregarDetalleSesion($sesion){
 	 	$sql = "INSERT INTO detalle_sesiones(id_sesion,fechaSesion,horaInicial,horaFinal) VALUES(".$this->id_sesion.",'".$this->scapeString($this->getFechaToMysql($sesion['fecha']))."','".$this->getTimeToMysql($sesion['hi'])."','".$this->getTimeToMysql($sesion['hf'])."');";
 	 	if(!$this->query($sql)){
 	 		echo $this->getError();
 	 	}
 	}

 	function getSesionByIdRegAct(){
 		$sql = "SELECT id_sesion, fechaApertura, fechaCierre FROM sesiones WHERE cns_regActividades=".$this->cns_regActividades;
 	 	$resultado = $this->query($sql);
 	 	if($resultado)
 	 	if($dato = mysqli_fetch_assoc($resultado))
 	 	{
 	 		$this->setIdSesion($dato['id_sesion']);
 	 		$this->setFechaApertura($this->getFechaFromMysql($dato['fechaApertura']));
 	 		$this->setFechaCierre($this->getFechaFromMysql($dato['fechaCierre']));
 	 	}
 	 	else
 	 	{
 	 		echo $this->getError();
 	 	}
 	}

 	function getDetalleSesion(){
 		$sql = "SELECT fechaSesion, horaInicial, horaFinal FROM detalle_sesiones WHERE id_sesion=".$this->id_sesion;
 	 	$resultado = $this->query($sql);
 	 	$elementos = array();
 	 	$cont=0;
 	 	if($resultado)
 	 	  while($dato = mysqli_fetch_assoc($resultado)){
 	 		array_push($elementos,array('dateses_'.$cont=>$dato['fechaSesion'], 'timeses_hi_'.$cont=>$dato['horaInicial'], 'timeses_hf_'.$cont=>$dato['horaFinal']));
 	 		$cont++;
 	 	  }
 	 	return $elementos;
 	}

 	function eliminarSesion(){
 		$sql ='DELETE s, ds FROM sesiones s JOIN detalle_sesiones ds ON ds.id_sesion=s.id_sesion WHERE s.cns_regActividades='.$this->cns_regActividades;
 		if(!$this->update($sql)){
 			echo $this->getError();
 		}
 	}
 }
?>