<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
require_once("../clases/CRegistroActividad.php");
require_once("Utilidades.php");

getStyles(); //estilos css

$registro = new RegistroActividad();

if(isset($_POST['id_tipo_actividad']))
{
echo '<div style="margin:0 auto; width:50%" id="contenedor">';
	echo '<p class="titulo"><b>RESUMEN DEL REGISTRO</b> <a href="#" class="btn_imprimir"><img src="../imagenes/imprimir.png" height="35" width="35"></a></p>';
	if($_POST['accion']=="ACTUALIZAR")
	{
		$registro->setIsUpdate(true);		
		$registro->setIDRegistroActividad($_POST['cnsregactividad']);
		$registro->eliminarParticipantes();
	}
	$registro->setIdTipoActividad($_POST['id_tipo_actividad']);
	$registro->setActividad($_POST['id_actividad'], $_POST['nombreactividad']);
	$registro->setIdDependencia($_POST['id_dependencia'],$_POST['dependencia']);
	$registro->setModalidadCurso($_POST['modalidadCurso']);
	$registro->setIdSede($_POST['id_sede'], $_POST['sede']);
	//$registro->setServicioSala($_POST['servicio_sala']);	
	$registro->setDuracion($_POST['duracion']);
	$registro->setFechaAperturaCierre($_POST['f_apertura'], $_POST['f_cierre']);
	//$registro->setTiempoP_IIP($_POST['tiempoP_IIP']);
	//$registro->setTiempoP_PDDAA($_POST['tiempoP_PDDAA']);
	$registro->setProgramaEducativo($_POST['id_programa'], $_POST['programaeducativo']);
	$registro->setAreaConocimiento($_POST['id_areaconocimiento'] , $_POST['areaconocimiento']);
	$registro->setValidacion($_POST['id_validacion'], $_POST['validacion']);
	$registro->setTipoPublico($_POST['id_tipopublico'], $_POST['publico']); 	 
 	$registro->setFechaInicioTermino($_POST['f_inicio'], $_POST['f_termino']);
	$registro->setCupo($_POST['cupo_minimo'], $_POST['cupo_maximo']);
	$registro->setCuotas($_POST['cuota_unach'], $_POST['cuota_externos']);
	//$registro->setObjetivoTemario($_POST['objetivo_temario']); se solicito eliminación
 	$registro->setCriteriosEvaluacion($_POST['criterios_evaluacion']);
 	$registro->setBibliografia($_POST['bibliografia']);
 	$registro->setAplicoDNC($_POST['aplico_dnc']);
 	/*Antes de registrar la actividad, registramos el temario completo*/
 	$registro->registrarTemario();
 	echo '<p class="titulo"><b>TEMARIO:</b></p>';
 	if(isset($_POST['tema']))
 	{
	 $length = count($_POST['tema']);
	 for ($i = 0; $i < $length; )
	 {
	 	$tema = array("modulo"=>$_POST['tema'][$i]['modulo'],
	 				  "temas_subtemas"=>$_POST['tema'][$i+1]['temas_subtemas'],
	 				  "proposito"=>$_POST['tema'][$i+2]['proposito'],
	 				  "estrategias"=>$_POST['tema'][$i+3]['estrategias'],
	 				  "materiales_didacticos"=>$_POST['tema'][$i+4]['materiales_didacticos'],
	 				  "horas_teoricas"=>$_POST['tema'][$i+5]['horas_teoricas'],
	 				  "horas_practicas"=>$_POST['tema'][$i+6]['horas_practicas']);

    		echo $tema['modulo']." <br> ";
    		echo $tema['temas_subtemas']." <br> ";
    		echo $tema['proposito']." <br> ";
    		echo $tema['estrategias']." <br> ";
    		echo $tema['materiales_didacticos']." <br> ";
    		echo $tema['horas_teoricas']." <br> ";
    		echo $tema['horas_practicas']."<br>";
    		$registro->registrarTema($tema);
    	$i = $i+7;
 	 }
 	}

 	if(isset($_FILES['material_didactico']))
 	{
 	 $uploaded_file = array("name"=>$_FILES['material_didactico']['name'],
	 							   "tmp_name"=>$_FILES['material_didactico']['tmp_name'],
	 							   "type"=>$_FILES['material_didactico']['type'],
	 							   "size"=>$_FILES['material_didactico']['size']);
 	 $registro->setMaterialDidactico($uploaded_file);
 	}else
 	 echo "<b>Nota:</b> no se adjuntó material didáctico<br>";
 	/*mostrar los criterios*/
 	$registro->getCriterios();
 	/*mostrar la bibliografia*/
 	$registro->getBibliografia();
 	/*mostrar si aplico DNC*/
 	$registro->getAplicoDNC();
 	/*SE PROCEDE A REGISTRAR LA ACTIVIDAD*/
 	$registro->registrarActividad();
 	/*despues de registrar la actividad, registramos las sesiones*/
 	echo '<p class="titulo"><b>SESIONES</b></p>';
 	$sestot=0;
 	$datos;
 	$registro->agregarSesion();
 	if(isset($_POST['sesion']))
 	{ 		
	 	foreach($_POST['sesion'] as $key=>$value)
		{
			$cont=0;
			foreach($value as $dato => $valor)
			{
				$datos[$cont] = $valor;
				$cont++;
			}
			$sesion = array("fecha"=>$datos[0],
	 						"hi"=>$datos[1],
	 						"hf"=>$datos[2]);
    	echo $sesion['fecha']." : ";
    	echo $sesion['hi']." - ";
    	echo $sesion['hf']."<br>";

    		$registro->agregarDetalleSesion($sesion);			
		}
	}

 	 /*registramos a los involucrados en el evento*/
 	 $registro->setParticipantes();
 	 try
 	 {
 	 //Registramos al organizador
 	 echo '<p class="titulo"><b>ORGANIZADOR:</b></p>';
 	 $registro->addOrganizador(array("id_responsable"=>$_POST['id_responsable'], "nombre"=>$_POST['persona']));
 	 //Registrams al coordinador
 	 echo '<p class="titulo"><b>COORDINADOR:</b></p>';
 	 /*print "<pre>";
 	 print_r($_FILES['coordinador']);
 	 print "</pre>";*/
 	 if(isset($_POST['coordinador'])){ 	 	
		 $length = count($_POST['coordinador']);
		 for ($i = 0; $i < $length;$i++)
		 {
		 	$uploaded_file="";
		 	if(isset($_FILES['coordinador']['name'][$i])){
		 		$uploaded_file = array("name"=>$_FILES['coordinador']['name'][$i],
		 							   "tmp_name"=>$_FILES['coordinador']['tmp_name'][$i],
		 							   "type"=>$_FILES['coordinador']['type'][$i],
		 							   "size"=>$_FILES['coordinador']['size'][$i]);	 		
		 	}
		 	$coordinador = array("id"=>$_POST['coordinador'][$i]['id']);
		 	$registro->addCoordinador($coordinador,$uploaded_file);	 	
	 	 }
 	 }
 	 //Registramos a los responsables de la comision de diseño curricular
 	 echo '<p class="titulo"><b>RESPONSABLES DE LA COMISION DE DISEÑO CURRICULAR:</b></p>';
 	 /*print "<pre>";
 	 print_r($_FILES['responsableCDC']);
 	 print "</pre>";*/
 	 if(isset($_POST['responsableCDC'])){ 	 	
		 $length = count($_POST['responsableCDC']);
		 for ($i = 0; $i < $length;$i++)
		 {
		 	$uploaded_file="";
		 	if(isset($_FILES['responsableCDC']['name'][$i])){
		 		$uploaded_file = array("name"=>$_FILES['responsableCDC']['name'][$i],
		 							   "tmp_name"=>$_FILES['responsableCDC']['tmp_name'][$i],
		 							   "type"=>$_FILES['responsableCDC']['type'][$i],
		 							   "size"=>$_FILES['responsableCDC']['size'][$i]);	 		
		 	}
		 	$responsable = array("id"=>$_POST['responsableCDC'][$i]['id']);
		 	$registro->addResponsableCDC($responsable, $uploaded_file);
	 	 }
 	 }
 	 //Registramos los formadores
 	 echo '<p class="titulo"><b>FORMADORES:</b></p>';
 	 /*print "<pre>";
 	 print_r($_POST['formador']);
 	 print "</pre>";*/
 	 if(isset($_POST['formador']))
 	 { 	 	
		 $length = count($_POST['formador']);
		 $cont=0;
		 for ($i = 0; $i < $length;)
		 {
		 	$uploaded_file="";
		 	if(isset($_FILES['formador']['name'][$cont])){
		 		$uploaded_file = array("name"=>$_FILES['formador']['name'][$cont],
		 							   "tmp_name"=>$_FILES['formador']['tmp_name'][$cont],
		 							   "type"=>$_FILES['formador']['type'][$cont],
		 							   "size"=>$_FILES['formador']['size'][$cont]);
		 	}	 	
		 	$formador = array("id"=>$_POST['formador'][$i]['id'],"tipo"=>$_POST['formador'][$i+1]['tipo']);
	    	$registro->addFormador($formador, $uploaded_file);
	    	$i+=2;
	    	$cont++;
	 	 }
 	 }
 	}catch(Exception $e){ echo "ERROR:";}
 	 //Se registran los requisitos curriculares
 	 echo '<p class="titulo"><b>REQUISITOS CURRICULARES:</b></p>';
	 $hay_registro=false;
	 foreach($_POST['req'] as $key => $value)
	 {
	 	if(!$hay_registro){
	 		$registro->addRegistroRequisitos();
	 		$hay_registro=true;
	 	}
  		//echo $key.": ".$value."<br>";
  		$registro->addDetalleRegRequisitos("req[".$key."]", $value);
	 }

	 $registro->printInfoActividad();
 	 
 	echo '<p><a href="../" class="btn btn-success">Continuar</a></p>';
 echo "</div>";

}
else
	header("location:../");
?>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/utilidades.js"></script>