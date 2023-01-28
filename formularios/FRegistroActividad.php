<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
session_start();
 if(!isset($_SESSION['USER']))
 	header("Location:../");

 require_once("../clases/CDependencias.php");
 require_once("../clases/CCatalogoActividades.php");
 require_once("../clases/CModalidad.php");
 require_once("../clases/CSedes.php");
 require_once("../clases/CAreaConocimiento.php");
 require_once("../clases/CValidacion.php");
 require_once("../clases/CTipoPublico.php");
 require_once("../clases/COrganizador.php");
 require_once("../clases/CFormador.php");
 require_once("../clases/CCoordinador.php");
 require_once("../clases/CTipoParticipante.php");
 require_once("../clases/CResponsableCDC.php");
 require_once("../clases/CRequisito.php");
 require_once("Utilidades.php");
 require_once("../clases/CActividad.php");
 require_once("../clases/CTipoActividad.php");
 require_once("../db/AccessDB.php");

//id_actividad hace referencia al elemento del catalogoactividades
 $recovering_data=false;
 $iscns_regActividad=false;
 $obj_actividad = new CActividad($db);
 
 if(isset($_POST['id_catalogoactividades'])){
 	//cuando el usuario intenta clonar la actividad
 	$busq_actividad = $obj_actividad->getActividadByIdCatalogo($_POST['id_catalogoactividades']);
 	$recovering_data=true;
 	$actividad[0]=$busq_actividad[0]; //ID
 	$actividad[1]=$busq_actividad[1]; //DESCRIPCION
 	$actividad[2]=$_POST['id_catalogoactividades']; //ID_CATALOGOACTIVIDAD
 }
 else if(isset($_POST["actividad"]))
 {
 	//cuando viene del formulario principal FActividad.php	
  	$actividad = explode("::",$_POST["actividad"],2);
 }
 else if(isset($_POST['id_e'])){
 	/*id_e proveniente de FAdministracion.php al ejecutar Modificar y corresponde al cns_regActividades*/ 	
 	$iscns_regActividad=true;
 	$recovering_data=true;
 	$busq_actividad = $obj_actividad->getActividadByCnsRegActividad($_POST['id_e']);
 	$actividad[0]=$busq_actividad[0]; //ID
 	$actividad[1]=$busq_actividad[1]; //DESCRIPCION
 	$actividad[2]=$_POST['id_e']; //cns_regActividades 	
 }
 else
  header("location:../");
 /*$db es el objeto creado en AccessDB*/
 $dependencias = new CDependencias($db);
 $formacion = new CCatalogoActividades($db);
 $modalidad = new CModalidad($db);
 $sedes = new CSedes($db); 
 $areasconocimiento = new CAreaConocimiento($db);
 $validaciones = new CValidacion($db);
 $publico = new CTipoPublico($db);
 $organizador = new COrganizador($db);
 $formador = new CFormador($db);
 $tipoparticipante = new CTipoParticipante($db);
 $coordinador = new CCoordinador($db);
 $responsablesCDC = new CResponsableCDC($db); /*Comisión de Diseño Curricular*/
 $requisitos = new CRequisito($db);
 $tipoa = new CTipoActividad($db);
 $tipoa->buscarTipoActividadByActividadAcademica($actividad[0]); 
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Educación Continua: Sistema de Registro</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Registro Actividades Académicas">		
		<?php 
			getStyles();
		?>
	</head>
	<body class="todo-contenido">
	<div class="container">
	<?php require_once("header.php"); ?>	
	<form name="registroactividades" id="RegistroActividades" action="Procesador.php" method="POST" enctype="multipart/form-data">
	<div class="panel panel-primary">
    <div class="panel-heading">
    	<?php 
    		if($recovering_data)
    		{
    			 //implementacion en actualizacion_datos.js    			
    			echo '<input type="hidden" id="id_catalogoactividades" value="'.(!$iscns_regActividad ? $actividad[2] : 0).'">';
    			echo '<input type="hidden" id="cnsregactividad" name="cnsregactividad" value="'.($iscns_regActividad ? $actividad[2] : 0).'">';
    			if($iscns_regActividad)
    				echo 'Modificando actividad: '.$actividad[1];
    			else
    				echo "Replicando actividad: ".$actividad[1];    			
    		}
    		else 
    			echo "Nuevo registro: ".$actividad[1]; 
    	?>
    </div>
    <input type="hidden" name="id_tipo_actividad" id="id_tipo_actividad" value="<?php echo $actividad[0]; ?>">
	 <div class="panel-body">	 	
		<ul class="tabs-menu">
			<li id="tab1" class="current">
				<a href="#tab-1" class="goTab" value="1">Requisitos Estructurales</a>
			</li>
			<?php
				if($tipoa->getIdTipo()==1)
				{
				echo '<li id="tab2">
					<a href="#tab-2" class="goTab" value="2">Perfiles</a>
				</li>';
				}
			?>
			<li id="tab3">
				<a href="#tab-3" class="goTab" value="3">Estructura</a>
			</li>
		</ul>
		
	    <div id="tab-1" class="tab-content">
		<div id="datosResponsable">
			<div class="form-group">
				<input type="hidden" name="id_dependencia" id="id_dependencia" value="0">
				<label for="dependencia" class="tres">Nombre de la dependencia:</label>
				<div class="nueve">
				<input list="dependencias" id="dependencia" name="dependencia" autocomplete="off" class="form-control">
				  <datalist id="dependencias">
					<?php echo $dependencias->getDependencias(); ?>
				  </datalist>
				  <a href="#addDependencia" class="boton">
				  	<?php echo getPlusButton("agregarDependencia"); ?>				   
				  </a>
				</div>
			</div>			
				<div id="addDependencia" class="modalDialog">
	  			 <div>
	  			  <a href="#close" title="Cerrar" class="cerrar">X</a>
	  			  <div id="formDependencia">
	  			  	<iframe src="FDependencia.php" id="iframe_dependencia"></iframe>
	  			  </div>
	  			 </div>
	  			</div>
			<div class="form-group">				
				<label for="nombreactividad" class="tres">
					<?php 					
						if($tipoa->getIdTipo()==1)
							echo "Nombre de la actividad académica:";
						else
							echo "Nombre del evento académico:";
					?>
			 	</label>				
				<div class="nueve">
				<input type="hidden" name="id_actividad" id="id_actividad" value="0">	
				<input list="catalogoactividades" name="nombreactividad" id="nombreactividad" autocomplete="off" class="form-control">
				  <datalist id="catalogoactividades">
				   <?php
					    $formacion->setIdActCat($actividad[0]);
					   	echo $formacion->getCatalogoActs();
				   ?>
				  </datalist>
				</div>
			</div>
			<div class="form-group">
				<label class="tres">Modalidad:</label>
				<div class="nueve">
				 <select name="modalidadCurso" id="modalidadCurso" class="form-control">
					<?php echo $modalidad->getModalidades(1);?>
				 </select>
				</div>
			</div>
			<div class="form-group" id="sede_curso">
				<label for="sede" class="tres">Sede del curso:</label>
				<div class="nueve">
			 	 <input type="hidden" name="id_sede" id="id_sede" value="0">
				 <input list="sedes" name="sede" id="sede" autocomplete="off" class="form-control">
				 <datalist id="sedes">
					<?php echo $sedes->getSedes(); ?>
				 </datalist>				
				 
				  <a href="#addSede">
				  	<?php echo getPlusButton("agregarSede"); ?>
				  </a>
				 
				</div>				
				
				<div id="addSede" class="modalDialog">				 
			  	 <div>
				  <a href="#close" title="Cerrar" class="cerrar">X</a>
				  <div id="formSede">
				  	<iframe src="FSede.php" id="iframe_sede"></iframe>
				   <!--Aquí el formulario de alta de sedes-->
				  </div>
				 </div>
				</div>
			</div>			
		</div>
		<p class="titulo">Datos del responsable operativo</p>
		<div id="datosResponsable">
			<div class="form-group">
				<label class="tres">Nombre del Responsable:</label>
				<div class="nueve">
				  <input type="hidden" name="id_responsable" id="id_responsable">				  
				  <input list="organizadores" name="persona" id="persona" autocomplete="off" class="form-control">
				 	<datalist id="organizadores">
						<?php 
						  echo $organizador->getOrganizadores();						  
						?>
				 	</datalist>
				  <a href="#addPersona" class="boton">
				   <?php echo getPlusButton("agregarPersona"); ?>
				  </a>
				</div>
				<div id="addPersona" class="modalDialog">
	  			 <div>
	  			  <a href="#close" title="Cerrar" class="cerrar">X</a>
	  			  <div id="formPersona">
	  			  	<iframe src="FPersona.php?tipo=Organizador" id="iframe_persona"></iframe>	  			 	
	  			  </div>
	  			 </div>
	  			</div>
			</div>
			<div class="form-group">
				<label class="tres">Teléfono:</label>
				<div class="nueve">
					<input maxlength="10" type="tel" id="_telefono" name="telefono" disabled class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="tres">Celular:</label>
				<div class="nueve">				
					<input maxlength="10" type="tel" id="_celular" name="celular" disabled class="form-control">
				</div>
			</div>
			<div class="form-group">
				<label class="tres">Correo Electrónico</label>
				<div class="nueve">								
					<input type="email" id="_correo" name="correo" disabled class="form-control">
				</div>
			</div>
		</div>		
		<p class="titulo">Datos de la actividad/evento</p>
		<div id="datosCurso">
		  <div id="duracion_evento">
			<div class="form-group">
				<label for="duracion" class="tres">Duración:</label>
				<div class="nueve">
					<input type="text" size="5" maxlenght="3" pattern="[0-9]{1,3}" name="duracion" id="duracion" class="form-control uno">
				</div>
			</div>
			<div class="form-group">
				<label for="f_apertura" class="tres">Fecha de inicio:</label>
				<div class="nueve">				
					<input type="text" class="datepicker form-control tres" name="f_apertura" id="f_apertura" placeholder="dd/mm/aaaa" pattern="(0[1-9]|[12][0-9]|3[01])[/-](0[1-9]|1[012])[/-](19|20)\d\d">
				</div>
			</div>
			<div class="form-group">
				<label for="f_cierre" class="tres">Fecha de termino:</label>
				<div class="nueve" id="fecha_cierre">
					<input type="text" class="datepicker form-control tres" name="f_cierre" id="f_cierre" placeholder="dd/mm/aaaa" pattern="(0[1-9]|[12][0-9]|3[01])[/-](0[1-9]|1[012])[/-](19|20)\d\d">
				</div>
			</div>
			<div class="form-group">
				<label class="tres">Horarios:</label>
				<div class="nueve">
					<?php echo getPlusButton("addSession"); ?>					
				</div>
				<div id="det_sesion" class="caja-elementos">
					<div class="doce">
						<div class="separador cuatro"><label>Fecha:</label></div>
						<div class="separador cuatro"><label>Hora de inicio:</label></div>
						<div class="separador cuatro"><label>Hora de término:</label></div>											
				   </div>
				   <!--Aqui se especifican las fechas y horarios de las sesiones-->
				</div>
			</div>
		  </div>
						
			<div class="form-group">
				<label class="tres">¿Pertenece a algún programa educativo?</label>
				<div class="nueve">
					<select name="tieneProgEduc" id="tieneProgEduc" class="form-control dos">
						<option value="0">No</option>
						<option value="1">Si</option>
					</select> 
				</div>
			</div>
			<div id="addPrograma" class="modalDialog">
				<div>
					<a href="#close" title="Cerrar" class="cerrar">X</a>
					<div id="formPrograma">
						<iframe src="FProgramaEducativo.php" id="iframe_progeduc"></iframe>
					</div>
				</div>
			</div>
			<div style="display:none" id="programa_educativo" class="form-group">
				<label class="tres">Nombre del programa:</label>
				<div class="nueve">
				 <input type="hidden" name="id_programa" id="id_programa" value="0">
				 <input type="text" name="programaeducativo" id="programaEducativo" readonly placeholder="Agregue el programa con [+]" class="form-control">
					<a href="#addPrograma" class="boton">
						<?php echo getPlusButton("agregarPrograma"); ?>						
					</a>
				</div>
			</div>
		
			<div class="form-group">
				<label class="tres">Área de conocimiento:</label>
				<div class="nueve">
			 	 	<input type="hidden" name="id_areaconocimiento" id="id_areaconocimiento" value="0">
				 	<input list="areasconocimiento" name="areaconocimiento" id="areaconocimiento" autocomplete="off" class="form-control">
				 	<datalist id="areasconocimiento">
						<?php echo $areasconocimiento->getAllAreas(); ?>
				 	</datalist>
				 </div>
			</div>
			<div class="form-group">
				<label class="tres">Finalidad de validación:</label>
				<div class="nueve">
			 	 	<input type="hidden" name="id_validacion" id="id_validacion" value="0">
				 	<input list="validaciones" name="validacion" id="validacion" autocomplete="off" class="form-control">
				 	<datalist id="validaciones">
						<?php echo $validaciones->getAllValidaciones(); ?>
				 	</datalist>
				 </div>
			</div>
			<div class="form-group">
				<label class="tres">Público al que va dirigido:</label>
				<div class="nueve">
			 	 	<input type="hidden" name="id_tipopublico" id="id_tipopublico" value="0">
				 	<input list="tipospublico" name="publico" id="publico" autocomplete="off" class="form-control">
				 	<datalist id="tipospublico">
						<?php echo $publico->getAllTipoPublico(); ?>
				 	</datalist>
				 </div>
			</div>
		</div>		

		<p class="titulo">Datos del Coordinador de la actividad</p>
		<div id="datos_coordinador">
			<div class="form-group">
				<label class="tres">Nombre:</label>
				<div class="nueve">
					<input type="hidden" id="coordinador_id" value="0">
				 	<input list="coordinadores" id="coordinador" autocomplete="off" class="form-control inputlist">
				 	<datalist id="coordinadores">
						<?php 
						  echo $coordinador->getCoordinadores();						  
						?>
				 	</datalist>
				 	<input type="button" id="nuevoCoordinador" value="&#10003;" class="btn btn-success"/>
				 	<a href="#addCoordinador" class="boton">
				 		<?php echo getPlusButton("agregarCoordinador"); ?>						
					</a>
				 </div>				 
			</div>
			<div id="det_coordinador" class="form-group caja-elementos">
				    <div class="doce">
						<div class="cuatro"><label>Coordinador:</label></div>						
						<div class="dos"><label>Teléfono:</label></div>
						<div class="dos"><label>Celular:</label></div>
						<div class="tres"><label>Email:</label></div>
				   </div>
				 	<!--Aqui la lista de Coordinadores-->
		    </div>
			<div id="addCoordinador" class="modalDialog">
	  			 <div>
	  			  <a href="#close" title="Cerrar" class="cerrar">X</a>
	  			  <div id="formCoordinador">
	  			  	<iframe src="FPersona.php?tipo=Coordinador" id="iframe_coordinador"></iframe>	  			 	
	  			  </div>
	  			 </div>
	  		</div>
		</div>

		<?php 
		 if($tipoa->getIdTipo()==1)		
			echo '<p class="titulo">Responsables de la Comisión de Diseño Curricular</p>';
		 else if($tipoa->getIdTipo()==2)
		 	echo '<p class="titulo">Responsables del Comité Organizador</p>';
		?>
		<div id="datos_responsables_diseno_curricular">
			<div class="form-group">
				<label class="tres">Nombre:</label>
				<div class="nueve">
					<input type="hidden" id="responsableCDCX_id" value="0">
				 	<input list="responsablesCDC" id="responsableCDC" autocomplete="off" class="form-control inputlist">
				 	<datalist id="responsablesCDC">
						<?php 
						  echo $responsablesCDC->getResponsablesCDC();						  
						?>
				 	</datalist>				 	
				 	<input type="button" id="nuevoResponsableCDC" value="&#10003;" class="btn btn-success"/>
				 	<a href="#addResponsableCDC" class="boton">
				 		<?php echo getPlusButton("agregarResponsableCDC"); ?>						
					</a>
				 </div>				 
			</div>
			<div id="det_responsablesCDC" class="form-group caja-elementos">
				    <div class="doce">
						<div class="separador seis"><label>Responsable:</label></div>						
						<div class="separador seis"><label>Currículum:</label></div>
				   </div>
				 	<!--Aqui la lista de responsablesCDC-->
		    </div>
			<div id="addResponsableCDC" class="modalDialog">
	  			 <div>
	  			  <a href="#close" title="Cerrar" class="cerrar">X</a>
	  			  <div id="formResponsableDC">
	  			  	<iframe src="FPersona.php?tipo=ResponsableCDC" id="iframe_responsableCDC"></iframe>	  			 	
	  			  </div>
	  			 </div>
	  		</div>
		</div>
		<?php 
		 if($tipoa->getIdTipo()==1)		
			echo '<p class="titulo">Datos de los formadores</p>';
		 else
		 	echo '<p class="titulo">Datos de los Ponentes</p>';
		?>		
		<div id="datos_formadores">
			<div class="form-group">
				<label class="tres">Nombre:</label>
				<div class="nueve">					
				 	<input list="formadores" id="formador" autocomplete="off" class="form-control inputlist">
				 	<datalist id="formadores">
						<?php 
						  echo $formador->getFormadores();						  
						?>
				 	</datalist>
				 	<select id="tipo_formador" class="opthidden">
				 		<option value="0" disabled selected>ELIGE</option>
				 		<?php 
				 		  echo $tipoparticipante->getAllTipoParticipante();				 		  
				 		?>
				 	</select>
				 	<input type="button" id="nuevoFormador" value="&#10003;" class="btn btn-success"/>
				 	<a href="#addFormador" class="boton">
				 		<?php echo getPlusButton("agregarFormador"); ?>						
					</a>
				 </div>
				 
			</div>
			<div id="det_formadores" class="form-group caja-elementos">
				    <div class="doce">
						<div class="separador cuatro"><label><?php if($tipoa->getIdTipo()==1){ echo "Formador:"; }else{ echo "Ponente:"; }?></label></div>
						<div class="separador cuatro"><label>Tipo:</label></div>
						<div class="separador cuatro"><label>Currículum:</label></div>											
				   </div>
				 	<!--Aqui la lista de Formadores-->
		    </div>
			<div id="addFormador" class="modalDialog">
	  			 <div>
	  			  <a href="#close" title="Cerrar" class="cerrar">X</a>
	  			  <div id="formFormador">
	  			  	<iframe src="FPersona.php?tipo=Formador" id="iframe_formador"></iframe>	  			 	
	  			  </div>
	  			 </div>
	  		</div>
		</div>

		<p class="titulo">Fecha de difusión y captación(incluyendo 10 días hábiles del proceso de revisión y autorización)</p>
		<div class="form-group">
				<label for="f_inicio" class="tres">Fecha de inicio:</label>
				<div class="nueve">				
					<input type="text" class="datepicker form-control tres" name="f_inicio" id="f_inicio" placeholder="dd/mm/aaaa" pattern="(0[1-9]|[12][0-9]|3[01])[/-](0[1-9]|1[012])[/-](19|20)\d\d">
				</div>
		</div>
		<div class="form-group">
				<label for="f_termino" class="tres">Fecha de termino:</label>
				<div class="nueve" id="fecha_termino">
					<input type="text" class="datepicker form-control tres" name="f_termino" id="f_termino" placeholder="dd/mm/aaaa" pattern="(0[1-9]|[12][0-9]|3[01])[/-](0[1-9]|1[012])[/-](19|20)\d\d">
				</div>
		</div>
		<p class="titulo">Cupo</p>
		<div class="form-group">
				<label for="cupo_minimo" class="tres">Minimo:</label>
				<div class="nueve">				
					<input type="text" class="form-control tres" name="cupo_minimo" id="cupo_minimo" pattern="[0-9]{1,4}">
				</div>
		</div>
		<div class="form-group">
				<label for="cupo_maximo" class="tres">Máximo:</label>
				<div class="nueve">
					<input type="text" class="form-control tres" name="cupo_maximo" id="cupo_maximo" pattern="[0-9]{1,4}">
				</div>
		</div>

		<p class="titulo">Cuota de inscripción</p>
		<div class="form-group">
				<label for="cuota_unach" class="tres">UNACH:</label>
				<div class="nueve">				
					<input type="text" class="form-control tres" name="cuota_unach" id="cuota_unach" pattern="^\d+(\.|\,)\d{2}$">
				</div>
		</div>
		<div class="form-group">
				<label for="cuota_externos" class="tres">Externos:</label>
				<div class="nueve">
					<input type="text" class="form-control tres" name="cuota_externos" id="cuota_externos" pattern="^\d+(\.|\,)\d{2}$">
				</div>
		</div>

		<a href=<?php if($tipoa->getIdTipo()==1) echo '"#tab-2" value="2"'; else echo '"#tab-3" value="3"'; ?> class="btn btn-info goTab">Siguiente <i class="fa fa-arrow-right"></i></a>
		</div>
		<?php 
		if($tipoa->getIdTipo()==1)
		{
		?>	
			<div id="tab-2" class="tab-content">
				<?php echo $requisitos->getAllTipoRequisito(); ?>
			 <a href="#tab-1" class="btn btn-info goTab" value="1"><i class="fa fa-arrow-left"></i> Anterior</a>
			 <a href="#tab-3" class="btn btn-info goTab" value="3">Siguiente <i class="fa fa-arrow-right"></i></a>
			</div>
		<?php
		}
		?>

		<div id="tab-3" class="tab-content">
		<?php 
			if($tipoa->getIdTipo()==2)
			{
			 echo $requisitos->getRequisitosByCategoria(3); /*3=categoria de requisitos*/
			}
			else
			{
		?>
				<p class="titulo">Estructura de <?php echo strtolower($actividad[1]); ?></p>
				<button type="button" value="Agregar" id="nuevoTema" class="btn btn-default"/><i class="fa fa-plus-circle"></i> Agregar</button>
				<div class="tema caja-elementos" id="acordeon">
					<ul id="temario">
						<!--Aqui los elementos-->
					</ul>
				</div>
		<?php
			} 
		?>	
			<p class="titulo">Material didáctico</p>
			<div class="form-group doce" id="anexar_ejemplar">
				<label class="cuatro">Anexar ejemplar impreso del material didáctico a utilizar:</label>
				<div class="ocho caja-elementos mate_recu">
					<input type="file" name="material_didactico" id="material_didactico" class="form-control">					
				</div>
			</div>			
			<div class="form-group" <?php if($tipoa->getIdTipo()==2) echo ' style="display:none"'; ?>>
				<label class="cuatro">Criterios de Evaluación y Acreditación para Participantes</label>
				<div class="ocho">
				 	<textarea name="criterios_evaluacion" id="criterios_evaluacion" class="form-control" placeholder="Criterios de evaluación" <?php if($tipoa->getIdTipo()==2) echo ' value="NE"'; ?>></textarea>
				 </div>
			</div>
			<div class="form-group">
				<label class="cuatro">Bibliografía utilizada:</label>
				<div class="ocho">
				 	<textarea name="bibliografia" id="bibliografia" class="form-control richtext" placeholder="Bibliografía"></textarea>
				</div>				
			</div>
			<hr/>
			<div class="form-group">
				<label class="cuatro">Para esta oferta académica ¿Aplico el detector de necesidades de capacitación?</label>
				<select name="aplico_dnc" id="aplico_dnc" class="form-control dos">
				 	<option value="0" selected>No</option>
				 	<option value="1">Si</option>
				 </select>
			</div>
			<hr/>
		 <a href=<?php if($tipoa->getIdTipo()==1) echo '"#tab-2" value="2"'; else echo '"#tab-1" value="1"'; ?> class="btn btn-info goTab"><i class="fa fa-arrow-left"></i> Anterior</a>
		 <?php
		 	$action_value="GUARDAR";
		 	if($iscns_regActividad)
		 		$action_value="ACTUALIZAR";
		 	echo '<button type="submit" class="btn btn-success btn_guardar_actividad" name="accion" value="'.$action_value.'"><i class="fa fa-check"></i> '.ucfirst(strtolower($action_value)).'</button>';		 	
		 ?>		 
		</div>
		</div>
	  </div>
	</form>
	<?php echo getHomeButton(); ?>
	<footer>Universidad Virtual UNACH 2015 - By: jesus.malo@unach.mx</footer>
	</div>
	</body>
</html>
<?php
 getScripts(); /*scripts y estilos comunes utilizados en los demas modulos del sistema*/ 
 
 //si se esta intentando recuperar datos ejecutamos el script en actualizacion_datos
 if($recovering_data){
	echo '<script src="../js/actualizacion_datos.js"></script>';
 }
 $db->close_conn();
?>
<script src="../js/validaciones_registro.js"></script>
<script src="../js/utilidades_registro.js"></script>