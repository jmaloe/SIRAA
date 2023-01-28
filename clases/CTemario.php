<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once('CCarpetaDocumentos.php');

class CTemario extends CCarpetaDocumentos{
 var $id_temario, 
 	 $nombre_temario, 
 	 $objetivo, 
 	 $criterios_evaluacion, 
 	 $bibliografia;

 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }
 /*setters*/
 function setIdTemario($id){
 	$this->id_temario = $id;
 }

 function setNombreTemario($nombre){
 	$this->nombre_temario = $this->scapeString($nombre);
 }

 function setObjetivo($obj){
 	$this->objetivo = $this->scapeString($obj);
 }

 function setCriteriosEvaluacion($criterios){
 	$this->criterios_evaluacion = $this->scapeString($criterios);
 }

 function setBibliografia($biblio){
 	$this->bibliografia = $biblio;
 }
 /*getters*/
 function getIdTemario(){
 	return $this->id_temario;
 }

 function getNombreTemario(){
 	return $this->nombre_temario;
 }

 function getObjetivo(){
 	return $this->objetivo;
 }

 function getCriteriosEvaluacion(){
 	return $this->criterios_evaluacion;
 }

 function getBibliografia(){
 	return $this->bibliografia;
 }

 function nuevoTemario(){
 	$this->setTag("NEW_C"); //tag para la carpeta
 	$this->nuevaCarpeta(); //crear carpeta
 	$sql="INSERT INTO temario(id_carpeta,nombreTemario,criteriosEvaluacion,bibliografia) VALUES(".$this->getIdCarpeta().",'".$this->nombre_temario."','".$this->criterios_evaluacion."','".$this->bibliografia."');";
    $this->query($sql);
    $this->setIdTemario($this->getInsertId());
    $this->setTag("TEMARIO:".$this->id_temario);
    $this->updateCarpeta(); //actualizamos el nombre de la carpeta
 }

 function getTemarioById(){
 	$sql="SELECT criteriosEvaluacion, bibliografia, dd.cns_documento FROM temario t JOIN (carpeta c JOIN detalle_documentos dd ON dd.id_carpeta=c.id_carpeta) ON c.id_carpeta=t.id_carpeta WHERE id_temario=".$this->id_temario;
    $resultado = $this->query($sql);
    if($resultado){        
    	if($datos = mysqli_fetch_assoc($resultado))
        {
            //si hay documento la consulta retorna valores            
    	   return array('criterios_evaluacion'=>$datos['criteriosEvaluacion'], 'bibliografia'=>$datos['bibliografia'], 'numDoc'=>$datos['cns_documento']);
        }
        else
        {
            //si no hay documento adjunto se retorna solo los datos de la tabla temario
            $sql="SELECT criteriosEvaluacion, bibliografia FROM temario t WHERE id_temario=".$this->id_temario;
            if($resultado = $this->query($sql)){
                $datos = mysqli_fetch_assoc($resultado);
                return array('criterios_evaluacion'=>$datos['criteriosEvaluacion'], 'bibliografia'=>$datos['bibliografia'], 'numDoc'=>0);
            }
        }
    }
    return NULL;
 }

 function getDetalleTemario(){
 	$sql = 'SELECT nombreModulo, subtemas, proposito, estrategias_did, materiales_did, Hrs_teoricas, Hrs_practicas FROM detalle_temas WHERE id_temario='.$this->id_temario.' ORDER BY cns_detalleTemas;';
 	$resultado = $this->query($sql);
 	$elementos = array();
 	if($resultado){
 		while($datos = mysqli_fetch_assoc($resultado))
 		{
 			array_push($elementos,array('modulo'=>$datos['nombreModulo'], 'subtema'=>$datos['subtemas'], 'proposito'=>$datos['proposito'], 'estrategias'=>$datos['estrategias_did'], 'materiales'=>$datos['materiales_did'], 'hrst'=>$datos['Hrs_teoricas'], 'hrsp'=>$datos['Hrs_practicas']));
 		}
 		return $elementos;
 	}
 	return NULL;
 }
}
?>