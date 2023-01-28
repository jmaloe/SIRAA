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

 $tipoactividad=1;
if(isset($_POST['accion'])){
	require_once("../clases/CParticipantes.php");
	require_once("../clases/CSesiones.php");
	require_once("../clases/CRequisito.php");
	require_once("../clases/CTemario.php");
	$participantes = new CParticipantes($db);
	$objSesion = new CSesiones($db);
	$requisitos = new CRequisito($db);
	$temario = new CTemario($db);

	echo '<div class="ancho_pagina" id="contenedor">';
	if($_POST['accion']=="Eliminar")
	{		
		$conex = new ConexionDB($db);
				
		$sql = 'DELETE FROM Registro_Actividades WHERE cns_regActividades='.$_POST['id_e'];
		
		if(!$conex->update($sql))
		  echo $conex->getError();
		else
		  echo '<p>ACTIVIDAD ELIMINADA: '.$_POST['id_e'].'</p>';
		echo '<a href="#" onclick="javascript:window.close(); return false;" class="btn btn-success">Cerrar</a>';
	}
	else
	{
		$conex = new ConexionDB($db);
		
		$sql1 = 'SELECT ta.id_tipoactividad From Registro_Actividades ra, catalogo_actividades ca, actividad_academica aa, tipo_actividad ta Where ra.id_catalogoactividades=ca.id_catalogoactividades And ca.id_actividadAcademica=aa.id_actividadAcademica And aa.id_tipoactividad=ta.id_tipoactividad And ra.cns_regActividades='.$_POST['id_e'].';';
		$res = $conex->query($sql1);
		$data = mysqli_fetch_row($res);
		$tipoactividad = $data[0];

	    $sql2 = "SELECT ra.cns_regActividades, ra.clave, ca.descripcion as actividad, aa.nombreActividad, pe.id_programaEducativo, pe.nombrePrograma, ac.descripcion as areaconocimiento, ra.id_temario, va.descripcion as validacion, tp.descripcion as publico, sd.ubicacion as sede, d.nombreDependencia, mo.descripcion as modalidad, ra.duracion, ra.fecha_inicio, ra.fecha_termino, ra.cupoMinimo, ra.cupoMaximo, ra.costoUnach, ra.costoExternos, ra.fechaCaptura,ra.aplico_dnc FROM Registro_Actividades ra, actividad_academica aa, catalogo_actividades ca, programa_educativo pe, area_conocimiento ac, validacion_actividad va, tipo_publico tp, sede sd, dependencia d, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_programaEducativo=pe.id_programaEducativo AND ra.id_areaConocimiento=ac.id_areaConocimiento AND ra.id_tipoValidacion=va.id_tipoValidacion AND ra.id_tipoPublico=tp.id_tipoPublico AND ra.id_sede=sd.id_sede AND ra.id_dependencia=d.id_dependencia AND ra.id_modalidad=mo.id_modalidad AND ra.cns_regActividades=".$_POST['id_e'].";";
		$resultado = $conex->query($sql2);
		$datos=mysqli_fetch_assoc($resultado);
		$participantes->buscarRegParticipantes($datos["cns_regActividades"]);		
				
	if($_POST['accion']=="Ver"){
		?>		
			<p><?php echo $datos["clave"]." : ".$datos['actividad']." : ".$datos['fechaCaptura']; ?> <a href="#" class="btn_imprimir"><img src="../imagenes/imprimir.png" height="35" width="35"></a></p>
			<p class="titulo"><b>REQUISITOS ESTRUCTURALES</b></p>
			<div class="form-group">
				<label for="dependencia" class="tres">Dependencia:</label>
				<div class="nueve">
					<?php echo $datos["nombreDependencia"]; ?>
				</div>
				<label for="nombreactividad" class="tres">Nombre de la formación:</label>				
				<div class="nueve">					
					<?php echo $datos["actividad"]; ?>
				</div>
				<label class="tres">Tipo de formación:</label>
				<div class="nueve">
					<?php echo ucfirst(strtolower($datos["nombreActividad"])); ?>
				</div>
				<label class="tres">Modalidad:</label>
				<div class="nueve">
					<?php echo ucfirst(strtolower($datos["modalidad"])); ?>
				</div>

				<label for="sede" class="tres">Sede del curso:</label>
				<div class="nueve">
					<?php echo $datos["sede"]; ?>
				</div>				
				<label class="tres">Nombre del Responsable:</label>
				<div class="nueve">
				 <?php 
				 	$organizador = $participantes->getOrganizador(); 
				 	echo $organizador['persona'];
				 ?>
				</div>
				
				<label class="tres">Teléfono:</label>
				<div class="nueve">
					<?php echo $organizador['_telefono']; ?>
				</div>
			
				<label class="tres">Celular:</label>
				<div class="nueve">				
					<?php echo $organizador['_celular']; ?>
				</div>
			
				<label class="tres">Correo Electrónico</label>
				<div class="nueve">								
					<?php echo $organizador['_correo']; ?>
				</div>
				<label for="duracion" class="tres">Duración de la actividad:</label>
				<div class="nueve">
					<?php echo $datos["duracion"]; ?>
				</div>
				<?php
					$objSesion->setRegActividades($datos["cns_regActividades"]); 
					$objSesion->getSesionByIdRegAct();
				if($objSesion->getFechaApertura()!="")
				{
				echo '<label for="f_apertura" class="tres">Fecha de inicio:</label>';
				echo '<div class="nueve">';					
					echo $objSesion->getFechaApertura();					
				echo '</div>';
				}
				if($objSesion->getFechaCierre()!="")
				{				
				echo '<label for="f_cierre" class="tres">Fecha de termino:</label>';
				echo '<div class="nueve" id="fecha_cierre">';
					echo $objSesion->getFechaCierre();
				echo '</div>';
				}
				$elementos = $objSesion->getDetalleSesion();
				if($elementos)
				{
				echo '<label class="tres">Horarios:</label>';
				echo '<div class="caja-elementos">';
						foreach ($elementos as $fila){
							echo '<div class="doce">';
							foreach ($fila as $value){
								echo '<div class="tres">'.$value.'</div>';
							}
							echo '</div>';
						}					
				echo '</div>';
				}
				?>
				
				<label class="tres">¿Pertenece a algún programa educativo?</label>
				<div class="nueve">
					<?php if($datos['id_programaEducativo']!=0) echo $datos['nombrePrograma']; else echo "No"; ?>
				</div>				
				<label class="tres">Área de conocimiento:</label>
				<div class="nueve">			 	 	
				 	<?php echo $datos["areaconocimiento"]; ?>
				</div>
				<label class="tres">Finalidad de validación:</label>
				<div class="nueve">			 	 	
				 	<?php echo $datos["validacion"]; ?>
				</div>
				<label class="tres">Público al que va dirigido:</label>
				<div class="nueve">			 	 	
				 	<?php echo $datos["publico"]; ?>
				</div>
				<label class="tres">Datos del coordinador:</label>
				<div class="caja-elementos">
					<?php
						$coordinador = $participantes->getCoordinador();
						foreach ($coordinador as $fila){
							echo '<div class="doce">';
							foreach ($fila as $key=>$value){
								if($key!="id_")
								{
									echo '<div class="tres">'.$value.'</div>';
								}
							}
							echo '</div>';
						}
					?>
				</div>
				<?php
				 if($tipoactividad==1)
				 	echo '<label class="seis">Responsables de la Comisión de Diseño Curricular:</label>';
				 else
				 	echo '<label class="seis">Responsables del Comité Organizador:</label>';
				?>				
				<div class="caja-elementos">
					<?php
						$responsablescdc = $participantes->getRCDC();
						foreach ($responsablescdc as $fila){
							echo '<div class="doce">';
							foreach ($fila as $key=>$value){
								if($key=='numDoc')
								{
									if($value>0)
									{
										echo '<span class="view_doc" doc='.$value.'></span>';
									}
								}
								else if($key!="id_")
									echo '<div class="tres">'.$value.'</div>';
							}
							echo '</div>';
						}
					?>
				</div>
				<?php
				 if($tipoactividad==1)
				 	echo '<label class="tres">Formadores:</label>';
				 else
				 	echo '<label class="seis">Ponentes:</label>';
				?>				
				<div class="caja-elementos">
					<?php
						$formadores = $participantes->getFormadores();						
						foreach ($formadores as $fila){
							echo '<div class="doce">';
							foreach ($fila as $key=>$value){
								if($key=='numDoc')
								{
									if($value>0)
									{
										echo '<span class="view_doc" doc='.$value.'></span>';
									}
								}
								else if($key!="id_" & $key!="tipo")
									echo '<div class="tres">'.$value.'</div>';
							}
							echo '</div>';
						}
					?>
				</div>
				<label>Fecha de difusión y captación:</label>
				<div class="caja-elementos">
					<label for="f_inicio" class="tres">Fecha de inicio:</label>
					<div class="nueve">
						<?php echo $conex->getFechaFromMysql($datos["fecha_inicio"]); ?>
					</div>
					<label for="f_termino" class="tres">Fecha de termino:</label>
					<div class="nueve" id="fecha_termino">
						<?php echo $conex->getFechaFromMysql($datos["fecha_termino"]); ?>
					</div>
				</div>

				<label>Cupos:</label>
				<div class="caja-elementos">
					<label for="cupo_minimo" class="tres">Minimo:</label>
					<div class="nueve">				
						<?php echo $datos["cupoMinimo"]; ?>
					</div>
					<label for="cupo_maximo" class="tres">Mámixo:</label>
					<div class="nueve">
						<?php echo $datos["cupoMaximo"]; ?>
					</div>
				</div>

				<label>Cuota de inscripción</label>
				<div class="caja-elementos">
					<label for="cuota_unach" class="tres">UNACH:</label>
					<div class="nueve">				
						<?php echo $datos["costoUnach"]; ?>
					</div>
					<label for="cuota_externos" class="tres">Externos:</label>
					<div class="nueve">
						<?php echo $datos["costoExternos"]; ?>
					</div>
				</div>
			</div>	
			<?php
			if($tipoactividad==1)
			{
				echo '<p class="titulo"><b>PERFILES</b></p>';				
			}
			else
			{
				echo '<p class="titulo"><b>ESTRUCTURA</b></p>';
			}
			echo '<div class="form-group">';
					$resultado = $requisitos->getRequisitosByIdRegActs($datos["cns_regActividades"],false);
					foreach ($resultado as $fila){
						echo '<div class="caja-elementos">';
						foreach ($fila as $key => $value) {
							if($key==0)
								echo '<label class="doce">'.$value.'</label>';
							else
								echo '<div class="doce">'.$value.'</div>';
						}
						echo '</div>';
					}
				echo '</div>';
			if($tipoactividad==1){
				echo '<p class="titulo"><b>ESTRUCTURA</b></p>';
			}				
			?>
			<div class="form-group">
				<?php 
					$temario->setIdTemario($datos['id_temario']);
					$resultado = $temario->getTemarioById();
					$detalle=false;
					if($tipoactividad==1)
						$detalle = $temario->getDetalleTemario();

					if($detalle){
						foreach ($detalle as $value) {
							echo '<div class="caja-elementos">';
							echo '<label class="tres">Módulo:</label>';
							echo '<div class="nueve">'.$value['modulo'].'</div><hr/>';
							echo '<label class="tres">Subtemas:</label>';
							echo '<div class="nueve">'.str_replace(chr(13).chr(10), "<br>", $value['subtema']).'</div><hr/>';
							echo '<label class="tres">Propósito:</label>';
							echo '<div class="nueve">'.str_replace(chr(13).chr(10), "<br>", $value['proposito']).'</div><hr/>';
							echo '<label class="tres">Estrategias didácticas:</label>';
							echo '<div class="nueve">'.str_replace(chr(13).chr(10), "<br>", $value['estrategias']).'</div><hr/>';
							echo '<label class="tres">Materiales didácticos:</label>';
							echo '<div class="nueve">'.str_replace(chr(13).chr(10), "<br>", $value['materiales']).'</div><hr/>';
							echo '<label class="tres">Horas teóricas:</label>';
							echo '<div class="nueve">'.$value['hrst'].'</div><hr/>';
							echo '<label class="tres">Horas prácticas:</label>';
							echo '<div class="nueve">'.$value['hrsp'].'</div><hr/>';
							echo '</div>';
						}
					}

					if($resultado){
						echo '<div class="doce"><label class="tres">Ejemplar del material didáctico utilizado:</label>';
						if($resultado['numDoc']>0)
							echo '<div class="caja-elementos nueve"><span class="view_doc" doc='.$resultado['numDoc'].'></span></div>';
						echo '</div>';
						if($tipoactividad==1)
						{
						echo '<div class="doce"><label class="tres">Criterios de evaluación:</label>';
						echo '<div class="nueve">'.$resultado['criterios_evaluacion'].'</div></div>';
						}
						echo '<div class="doce"><label class="tres">Bibliografia:</label>';
						echo '<div class="nueve bibliografia">'.str_replace(chr(13).chr(10), "<br>", $resultado['bibliografia']).'</div></div>';
						echo '<label class="tres">Para esta oferta académica ¿Aplico el detector de necesidades de capacitación?</label>';
						$aplico_dnc="No";
						if($datos['aplico_dnc']==1)
							$aplico_dnc="Si";
						echo '<div class="tres">'.$aplico_dnc.'</div>';
					}
				?>
			</div>		
		<?php
	}
	else if($_POST['accion']=="VerFichaActividad"){
		?>
		<p><?php echo $datos["clave"].": ".$datos['actividad']." - ".$datos['fechaCaptura']; ?> <a href="#" class="btn_imprimir"><img src="../imagenes/imprimir.png" height="35" width="35"></a></p>
			<p class="titulo"><b>FICHA DE ACTIVIDADES Y EVENTOS ACADÉMICOS</b></p>
			<div class="form-group">
				<label class="tres"><b>ENTIDAD ACADÉMICA:</b></label>
				<div class="nueve">
					Dirección de Educación Contínua
				</div>
				<label class="tres"><b>NOMBRE DE LA FORMACIÓN:</b></label>				
				<div class="nueve">					
					<?php echo $datos["actividad"]; ?>
				</div>
				<label class="tres"><b>TIPO DE FORMACIÓN:</b></label>
				<div class="nueve">
					<?php echo $datos["nombreActividad"]; ?>
				</div>
				<label class="tres"><b>MODALIDAD:</b></label>
				<div class="nueve">
					<?php echo $datos["modalidad"]; ?>
				</div>
				<label class="tres"><b>ÁREA DE CONOCIMIENTO:</b></label>
				<div class="nueve">			 	 	
				 	<?php echo $datos["areaconocimiento"]; ?>
				</div>
				<label class="tres"><b>DURACIÓN:</b></label>
				<div class="nueve">
					<?php echo $datos["duracion"]; ?>
				</div>
				<label class="tres"><b>PÚBLICO AL QUE VA DIRIGIDO:</b></label>
				<div class="nueve">
				 	<?php echo $datos["publico"]; ?>
				</div>
				<label class="tres"><b>REQUISITOS DE INGRESO:</b></label>
				<div class="nueve">
					<?php
						echo $requisitos->getRequisitoByIdInput("req[requisito_ingreso]",$datos["cns_regActividades"]);						
					?>
				</div>
				<label class="tres">OBJETIVO GENERAL:</label>
				<div class="nueve">
					<?php echo $requisitos->getRequisitoByIdInput("req[objetivo_general]",$datos["cns_regActividades"]); ?>
				</div>
				<label class="tres"><b>CUPO</b> (Mínimo y máximo):</label>
				<div class="nueve">					
						<?php echo $datos["cupoMinimo"]." - ".$datos["cupoMaximo"]; ?>					
				</div>
				<label class="tres"><b>COSTOS DE INSCRIPCIÓN</b> (UNACH y externos):</label>
				<div class="nueve">				
					<?php echo "UNACH:".$datos["costoUnach"]." Externos:".$datos["costoExternos"]; ?>
				</div>
				<label class="tres"><b>PERFIL DE EGRESO:</b></label>
				<div class="nueve">
					<?php
						echo $requisitos->getRequisitoByIdInput("req[perfil_egreso]",$datos["cns_regActividades"]);						
					?>
				</div>
				<?php
	}
   }
}
echo '</div>';
 $db->close_conn();
?>
<script src="../js/jquery-1.11.2.min.js"></script>
<script src="../js/utilidades.js"></script>
<script src="../js/loading.js"></script>