<meta charset="utf-8" />
<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
date_default_timezone_set('America/Mexico_City');
session_start();
 if(!isset($_SESSION['USER']))
 	header("Location:../");
 require_once("../db/AccessDB.php");
 require_once("../db/ConexionDB.php");
 require_once("Utilidades.php");

 getStyles();
 $msjs=null;

if(isset($_POST['accion']))
{
	require_once("../clases/CListaAsistencia.php");	

		/*en la accion concatenamos el tipo de accion y el id del elemento*/	
		$asistentes = new CListaAsistencia($db);
		echo "<script> var categorias = ".json_encode($asistentes->getClasificacion())."</script>";
		$dato = explode(":?:", $_POST['accion']);
		if($dato[0]!='AgregarAsistentes')
		{
			$asistentes->setIdEvento($_POST['id_e']);
			$asistentes->setClaveEvento($_POST['clave']);			
		}
		if($_POST['accion']=="adjuntar_doc"){
			if(isset($_FILES['documentacion']))
			{
				$asistentes->initLista(); //cargamos no_lista e id_carpeta
				if($asistentes->uploadDocumentacion($_FILES['documentacion']))
					$msjs = "Archivo subido con éxito";
				else
					$msjs = "Error al subir documento:".$asistentes->getError();
			}
			else
				$msjs = "No se ha adjuntado ningun archivo";
		}		
		/*accion eliminar*/
		if($dato[0]=="e")
		{
			$asistentes->setNoRegistro($dato[1]);			
			if($asistentes->eliminarAsistente())
				$msjs = "Se eliminó correctamente el asistente";
		}
		else if($dato[0]=="a")
		{
			$asistentes->setNoRegistro($dato[1]);
			/*accion aprobar*/
			$asistentes->setIdEvento($_POST['id_e']);
			if(!$asistentes->generarFolio())
				$msjs = "Error:".$asistentes->getError();
		}
		$conex = new ConexionDB($db);
		
	    $sql = "SELECT ra.cns_regActividades, ra.clave, ca.descripcion as actividad, aa.nombreActividad, ra.duracion FROM Registro_Actividades ra, actividad_academica aa, catalogo_actividades ca WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.cns_regActividades=".$_POST['id_e'].";";
		$resultado = $conex->query($sql);
		$datos=mysqli_fetch_assoc($resultado);		
		?>	
	<div class="panel panel-primary ancho_pagina" id="contenedor">
    <div class="panel-heading">Registro de Asistentes</div>
	<div class="panel-body">
		<?php 
			if($msjs)
				echo '<div id="mensajes">'.$msjs."</div>";
		?>
		<label class="doce">Clave: <?php echo $datos["clave"]; ?></label>
		<label class="doce">Actividad: <?php echo $datos["actividad"]; ?></label>
		<label class="doce">Duración: <?php echo $datos["duracion"]; ?></label>
		<p>Para poder expedir documentos con validación curricular, deberá adjuntar los siguientes archivos comprimidos en .zip o .rar:</p>
		<ul>
			<li>Lista de asistencia firmada por participantes y ponente/instructor</li>
			<li>Lista de Comité Organizador firmada por Director/a o Coordinador/a de la DES/DAC</li>
			<li>Convocatoria emitida</li>
		</ul>
		<form method="POST" action="FAsistentes.php" id="formulario_asistentes" enctype="multipart/form-data">
			<div class="doce">
				<label class="separador">Adjuntar documentación:</label>					
				<input type="file" name="documentacion" id="documentacion" class="separador"/>
				<button type="submit" name="accion" value="adjuntar_doc" class="btn btn-success"><i class="fa fa-upload"></i> Subir</button>
			</div>
			<?php
				$asistentes->setIdEvento($_POST['id_e']);
				$asistentes->initLista();
				$id = $asistentes->getLastDoc();
				if($id>0)
					echo '<div class="caja-elementos sinborde">Documento actual:<div class="view_doc" doc="'.$id.'"></div></div>';
			?>
			<p class="titulo"><b>Asistentes</b></p>
			<div class="nueve">
				<?php echo getPlusButton("addAsistente"); ?>					
			</div>
			<br><br>
			<div id="det_asistentes" class="caja-elementos">
				<div class="doce">
					<div class="separador dos"><label>#:</label></div>
					<div class="separador tres"><label>Nombre:</label></div>
					<div class="separador tres"><label>Clasificación:</label></div>
					<div class="separador tres"><label>Observaciones:</label></div>
			   </div>
			   <!--Aqui se agrega los asistentes-->
			</div>				

			<p class="titulo"><b>Ponentes/Instructores</b></p>
			<div class="nueve">
				<?php echo getPlusButton("addPonente"); ?>
			</div>
			<br><br>
			<div id="det_ponentes" class="caja-elementos">
				<div class="doce">
					<div class="separador dos"><label>#:</label></div>
					<div class="separador tres"><label>Nombre:</label></div>
					<div class="separador tres"><label>Clasificación:</label></div>
					<div class="separador uno"><label>Tipo:</label></div>
					<div class="separador tres"><label>Observaciones:</label></div>
			   </div>
				<!--Aqui se agrega los ponentes/instructores-->
			</div>				

			<p class="titulo"><b>Comité organizador</b></p>
			<div class="nueve">
				<?php echo getPlusButton("addComiteOrganizador"); ?>
			</div>
			<br><br>
			<div id="det_comite" class="caja-elementos">
				<div class="doce">
					<div class="separador dos"><label>#:</label></div>
					<div class="separador tres"><label>Nombre:</label></div>
					<div class="separador tres"><label>Clasificación:</label></div>
					<div class="separador tres"><label>Observaciones:</label></div>
			   </div>
				<!--Aqui se agrega el comité organizador-->
			</div>
			<br>
			<button type="submit" name="accion" value="accion_agregar_lista" class="btn btn-success"><i class="fa fa-floppy-o"></i> Registrar lista</button>

			<p class="titulo">Lista de asistencia:</p>
			<div class="form-group caja-elementos" id="asistentes_enlistados">
				<?php
					echo '<input type="hidden" name="id_e" id="id_e" value="'.$_POST['id_e'].'">';
					echo '<input type="hidden" name="clave" id="clave" value="'.$datos['clave'].'">';						
					$asistentes->setIdEvento($datos['cns_regActividades']);
					$asistentes->setClaveEvento($datos['clave']);
					$asistentes->setDuracion($datos['duracion']);
					$total = 0;
					function readAndSave($data){
						global $total;
						foreach($data as $key=>$value)
						{
							$total++;
						  	foreach ($value as $clave => $valor){
						  		addAsistente($clave, $valor);
						  	}
							saveAsistente();
					 	}
					}

					function addAsistente($clave, $valor){
						global $asistentes;
						if($clave=="nombre")
				  			$asistentes->setNombreAsistente($valor);
				  		else if($clave=="categoria")
				  			$asistentes->setIdCategoria($valor);
				  		else if($clave=="observaciones")
				  			$asistentes->setObservaciones($valor);
				  		else if($clave=="poi") /*¿ponente o instructor?*/
				  			$asistentes->setIdTipoAsistente($valor);
					}

					function saveAsistente(){
						global $asistentes;
						if(!$asistentes->guardarAsistente())
							echo $asistentes->getError();
					}

					if($_POST['accion']=="accion_agregar_lista")
					{							
						$asistentes->initLista(); //cargamos el no_lista donde guardaremos los participantes
						if(isset($_POST['asistente']))
					 	{
					 	  $asistentes->setIdTipoAsistente(1); //asistente en DB
					 	  readAndSave($_POST['asistente']);							  
					 	}
					 	if(isset($_POST['ponente']))
					 	{						 	  
						  readAndSave($_POST['ponente']);
					 	}
					 	if(isset($_POST['co']))
					 	{
					 	  $asistentes->setIdTipoAsistente(4); //comite organizador en DB
						  readAndSave($_POST['co']);
					 	}

						if($total>0)
							echo '<div class="mensajes">'.$total." asistente(s) nuevos registrado(s)</div>";							
					}
					echo $asistentes->getAsistentes();						
				?>
			</div>			
		</form>
		<p>Solicitar Referencia Bancaria para el pago del número de documentos que requiere validación, comunicarse al teléfono 61 78000 ext. 1355, en donde se le pedirá el número de folio o nombre de la actividad académica, así como la cantidad de Diplomas/ Reconocimientos/ Constancias emitidas para su correcto registro. En un lapso de 24 hrs. recibirá vía correo electrónico la ficha referenciada, con una vigencia de 72 hrs. para el pago correspondiente.</p>
		<p>Posterior a ello, deberá acudir a las oficinas de Educación Continua con oficio de entrega de Diplomas/ Reconocimientos/ Constancias impresas correctamente requisitadas y firmadas, así como con el talón del depósito bancario.</p>
		<div class="doce">Ejemplo de documentos para validación: <a href="../Documentos/DemoTextoParaDocumentosDeValidacion.pdf" target="_blank"><div class="view_doc"></div></a></div>

		<?php echo getHomeButton(); ?>
	</div>
	</div>	
<?php   
}
else
	echo "Ninguna acción por realizar.";
 getScripts();
 $db->close_conn();
?>
 <script src="../js/utilidades_actividades.js"></script>
 <script>
  $(".caja-elementos").css("max-height","500px");
 </script>