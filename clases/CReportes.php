<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com 13-08-2015*/
date_default_timezone_set('America/Mexico_City');
require_once('../db/ConexionDB.php');

class CReportes extends ConexionDB{
	
 var $f_inicial, $f_final, $labels, $values;	
 
 function __construct($db)
 {
    parent::__construct($db); /*invocar el constructor de la clase padre*/
 }
 
 function setFechaInicial($fi){
	 $this->f_inicial = $fi;
 }
 
 function setFechaFinal($ff){
	 $this->f_final = $ff;
 }
 
 function getFechaInicial(){
	 return $this->f_inicial;
 }
 
 function getFechaFinal(){
	 return $this->f_final;
 }

 function getGraficas(){
 	if($this->getReporte())
 	{
 		echo $this->getLineChart();
 		echo $this->getBarChart();
 		echo $this->getRadarChart();
 		echo $this->getPolarAreaChart("dataG4");
 		echo $this->getPieChart("dataG5");
 		return true;
 	}
 	return false;
 }

 function getReporte(){
 	$sql = 'select count(ra.cns_regActividades) as total from Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa where ra.id_catalogoactividades=ca.id_catalogoactividades and ca.id_actividadAcademica=aa.id_actividadAcademica and ra.fechaCaptura between \''.$this->scapeString($this->getFechaToMysql($this->f_inicial)).'\' and \''.$this->scapeString($this->getFechaToMysql($this->f_final)).'\';';
 	
    $resultado = $this->query($sql);
 	$cont=0;
 	$granTotal=0;
 	while($fila=mysqli_fetch_row($resultado)){
 		$granTotal+=$fila[0];
 	}
 	$sql = 'select aa.nombreActividad, count(ra.cns_regActividades) as total from Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa where ra.id_catalogoactividades=ca.id_catalogoactividades and ca.id_actividadAcademica=aa.id_actividadAcademica and ra.fechaCaptura between \''.$this->scapeString($this->getFechaToMysql($this->f_inicial)).'\' and \''.$this->scapeString($this->getFechaToMysql($this->f_final)).'\' group by aa.id_actividadacademica order by aa.id_actividadacademica;';    

 	$resultado = $this->query($sql);
 	while($fila=mysqli_fetch_row($resultado)){
 		if($cont==0)
 		{
 			$cont=1;
 		}
 		else
 		{
 			$this->labels.=",";
 			$this->values.=",";
 		}
 		$this->labels.='"'.$fila[0].': '.number_format((float)($fila[1]*100/($granTotal)), 1, '.', '').'%"'; 		
 		$this->values.=$fila[1]; 		
 	}
 	if($cont==1)
 		return true;
 	return false;
 }

 function getLineChart(){
 	return chr(13).'var dataG1 = {
    labels: ['.$this->labels.'],
    datasets: [
        {
            label: "Grafia de lineas",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: ['.$this->values.']
        }
    ]
	};';
 }

 function getBarChart(){
 	return chr(13).'var dataG2 = {
    labels: ['.$this->labels.'],
    datasets: [
        {
            label: "Grafica de barras",
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: ['.$this->values.']
        }
    ]
	};';
 }

 function getRadarChart(){
 	return chr(13).'var dataG3 = {
    labels: ['.$this->labels.'],
    datasets: [
        {
            label: "Grafica tipo radar",
            fillColor: "rgba(220,220,220,0.2)",
            strokeColor: "rgba(220,220,220,1)",
            pointColor: "rgba(220,220,220,1)",
            pointStrokeColor: "#fff",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: ['.$this->values.']
        }
    ]
	};';
 }

 function getPolarAreaChart($varName){
 	$etiquetas = explode(',',$this->labels);
 	$valores = explode(',',$this->values);
 	$data = chr(13).'var '.$varName.'=[';
 	for($i=0; $i<count($etiquetas); $i++){
 		if($i>0)
 			$data.=','.chr(13);
 		$data.='{';
 		$data.='label:'.$etiquetas[$i].',';
 		$data.='value:'.$valores[$i].',';
 		$data.='color:"#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT).'",';
 		$data.='highlight:"#1c76c5"';
 		$data.='}';
 	}
 	$data.="];".chr(13);
 	return $data;
 }

 function getPieChart($varName){
 	return $this->getPolarAreaChart($varName);
 }
}
?>