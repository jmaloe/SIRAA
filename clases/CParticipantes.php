<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('../db/ConexionDB.php');

class CParticipantes extends ConexionDB{
 var $reg_participantes, $id_participante, $cns_regActividades;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }

 function setRegActividades($reg){
   $this->cns_regActividades = $reg;
 }

 function setRegParticipantes($id){
 	$this->reg_participantes = $id;
 }

 function setIdParticipante($id){
 	$this->id_participante = $id;
 }

 function getRegParticipantes(){
 	return $this->reg_participantes;
 }

 function getIdParticipante(){
 	return $this->id_participante;
 }

 function addParticipantes($tag){
   $sql = "INSERT INTO participantes(cns_regActividades,tag) VALUES(".$this->cns_regActividades.",'".$tag."');";
   $this->query($sql);
   $this->reg_participantes = $this->getInsertId();
 }

 function setOrganizador(){
   $sql="INSERT INTO regOrganizadores(id_organizador,id_participantes) VALUES(".$this->getIdParticipante().",".$this->getRegParticipantes().");";
   if(!$this->query($sql)){
      echo $this->getError();
   }
   return $this->getInsertId(); /*id*/
 }

 function setCoordinador(){
   $sql="INSERT INTO regCoordinadores(id_coordinador,id_participantes) VALUES(".$this->getIdParticipante().",".$this->getRegParticipantes().");";
   if(!$this->query($sql)){
      echo $this->getError();
   }
   return $this->getInsertId(); /*id*/
 }

 function setResponsableCDC(){
   $sql="INSERT INTO regResponsablesCDC(id_responsable_cdc,id_participantes) VALUES(".$this->getIdParticipante().",".$this->getRegParticipantes().");";
   if(!$this->query($sql)){
      echo $this->getError();
   }
   return $this->getInsertId(); /*id*/
 }

 function setFormador(){
   $sql="INSERT INTO regFormadores(id_formador,id_participantes) VALUES(".$this->getIdParticipante().",".$this->getRegParticipantes().");";
   if(!$this->query($sql)){
      echo $this->getError();
   }
   return $this->getInsertId(); /*id*/
 }

 function buscarRegParticipantes($cnsRegAct){
   $sql="SELECT id_participantes FROM participantes WHERE cns_regActividades=".$cnsRegAct;
   $resultado = $this->query($sql);
   if($dato =  mysqli_fetch_assoc($resultado)){
      $this->setRegParticipantes($dato['id_participantes']);
      return true;
   }
   return false;
 }

 function getOrganizador(){
  $sql="SELECT per.id_persona,nombre, apellido_paterno, apellido_materno, telefono, telCelular, email FROM participantes p, regOrganizadores ro, organizador o, persona per WHERE p.id_participantes=ro.id_participantes AND ro.id_organizador=o.id_organizador AND o.id_persona=per.id_persona AND p.id_participantes=".$this->getRegParticipantes();
   $resultado = $this->query($sql);
   if($resultado)
   if($dato =  mysqli_fetch_assoc($resultado)){
      return array('id_responsable'=>$dato['id_persona'],'persona'=>$dato['nombre']." ".$dato['apellido_paterno']." ".$dato['apellido_materno'],'_telefono'=>$dato['telefono'],'_celular'=>$dato['telCelular'],'_correo'=>$dato['email']);
   }
   return false;
 }

 function getCoordinador(){
   $sql="SELECT per.id_persona,nombre, apellido_paterno, apellido_materno, telefono, telCelular, email FROM participantes p, regCoordinadores rc, coordinador c, persona per WHERE p.id_participantes=rc.id_participantes AND rc.id_coordinador=c.id_coordinador AND c.id_persona=per.id_persona AND p.id_participantes=".$this->getRegParticipantes();
   $resultado = $this->query($sql);
   $elementos = array();
   if($resultado)
   {
      while($dato = mysqli_fetch_assoc($resultado)){
         array_push($elementos,array('id_'=>$dato['id_persona'],'nombre'=>$dato['nombre']." ".$dato['apellido_paterno']." ".$dato['apellido_materno'], 'telefono'=>$dato['telefono'],'celular'=>$dato['telCelular'],'email'=>$dato['email']));
      }
      return $elementos;
   }
   return false;
 }

 function getRCDC(){
   $sql="SELECT per.id_persona,nombre, apellido_paterno, apellido_materno, (SELECT cns_documento FROM detalle_documentos WHERE id_carpeta=respcdc.id_carpeta AND cns_documento=(select max(cns_documento) from detalle_documentos where id_carpeta=respcdc.id_carpeta and id_tipoDocumento=1)) AS CV FROM participantes p, regResponsablesCDC rcdc, responsableCDC respcdc, persona per WHERE p.id_participantes=rcdc.id_participantes AND rcdc.id_responsable_cdc=respcdc.id_responsable_cdc AND respcdc.id_persona=per.id_persona AND p.id_participantes=".$this->getRegParticipantes();
   $resultado = $this->query($sql);
   $elementos = array();
   if($resultado)
   while($dato = mysqli_fetch_assoc($resultado)){
      array_push($elementos,array('id_'=>$dato['id_persona'],'nombre'=>$dato['nombre']." ".$dato['apellido_paterno']." ".$dato['apellido_materno'], 'numDoc'=>$dato['CV']));
   }
   return $elementos;
 }

 function getFormadores(){
   $sql="SELECT per.id_persona,forms.id_tipoParticipante,tp.descripcion as tipopart, nombre, apellido_paterno, apellido_materno, (SELECT cns_documento FROM detalle_documentos WHERE id_carpeta=forms.id_carpeta AND cns_documento=(select max(cns_documento) from detalle_documentos where id_carpeta=forms.id_carpeta and id_tipoDocumento=1)) AS CV FROM participantes p, regFormadores rf, formador forms, tipo_participante tp, persona per WHERE p.id_participantes=rf.id_participantes AND rf.id_formador=forms.id_formador AND forms.id_persona=per.id_persona AND tp.id_tipoParticipante=forms.id_tipoParticipante AND p.id_participantes=".$this->getRegParticipantes();
   $resultado = $this->query($sql);
   $elementos = array();
   if($resultado)
   while($dato = mysqli_fetch_assoc($resultado)){
      array_push($elementos,array('id_'=>$dato['id_persona'],'tipo'=>$dato['id_tipoParticipante'],'nombre'=>$dato['nombre']." ".$dato['apellido_paterno']." ".$dato['apellido_materno'], 'numDoc'=>$dato['CV'], 'tipo_participante'=>$dato['tipopart']));
   }
   return $elementos;
 }

 function eliminarParticipantes(){   
   $sql = 'DELETE FROM participantes WHERE cns_regActividades='.$this->cns_regActividades;
   if(!$this->update($sql)){
         echo $this->getError();
   }   
 }

}
 ?>