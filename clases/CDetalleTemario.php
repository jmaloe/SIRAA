<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('CTemario.php');

class CDetalleTemario extends CTemario{
 var $id_det_tema, 
 	$modulo, 
 	$temas_subtemas, 
 	$proposito, 
 	$estrategias_did, 
 	$materiales_did, 
 	$hrs_teoricas, 
 	$hrs_practicas;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }
/*setters*/
 function setIdDetTema($id){
 	$this->id_det_tema = $id;
 }

 function setModulo($mod){
 	$this->modulo = $this->scapeString($mod);
 }

 function setTemasSubtemas($ts){
 	$this->temas_subtemas = $this->scapeString($ts);
 }

 function setProposito($prop){
 	$this->proposito = $this->scapeString($prop);
 }

 function setEstrategiasDid($es){
 	$this->estrategias_did = $this->scapeString($es);
 }

 function setMaterialesDid($ma){
 	$this->materiales_did = $this->scapeString($ma);
 }

 function setHorasTeoricas($ht){
 	$this->hrs_teoricas = $ht;
 }

 function setHorasPracticas($hp){
 	$this->hrs_practicas = $hp;
 }
/*getters*/
function getIdDetTema(){
 	return $this->id_det_tema;
 }

 function getModulo(){
 	return $this->modulo;
 }

 function getTemasSubtemas(){
 	return $this->temas_subtemas;
 }

 function getProposito(){
 	return $this->proposito;
 }

 function getEstrategiasDid(){
 	return $this->estrategias_did;
 }

 function getMaterialesDid(){
 	return $this->materiales_did;
 }

 function getHorasTeoricas(){
 	return $this->hrs_teoricas;
 }

 function getHorasPracticas(){
 	return $this->hrs_practicas;
 }

 function registrarDetalleTemario(){
 	$sql="INSERT INTO detalle_temas(id_temario,nombreModulo,subtemas,proposito,estrategias_did,materiales_did,Hrs_teoricas,Hrs_practicas) VALUES(".$this->getIdTemario().",'".$this->modulo."','".$this->temas_subtemas."','".$this->proposito."','".$this->estrategias_did."','".$this->materiales_did."',".$this->hrs_teoricas.",".$this->hrs_practicas.");";
    $this->query($sql);
    $this->setIdDetTema($this->getInsertId());
 }


}