<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
	require_once("../db/AccessDB.php");
	require_once("../db/ConexionDB.php");
	require_once("../clases/CParticipantes.php");
	require_once("../clases/CSesiones.php");
	require_once("../clases/CRequisito.php");
	require_once("../clases/CTemario.php");
	
 	$conex = new ConexionDB($db);
 	//si viene como parametro cns_regActividades significa que se esta intentando modificar desde FAdmistracion.php al ejecutar "Modificar", sino se esta clonando una actividad
 	$registro_max=0;
 	if($_GET['cnsregactividad']>0)
 		$registro_max = $_GET['cnsregactividad'];
 	else
 		$registro_max = "SELECT max(cns_regActividades) FROM Registro_Actividades WHERE id_catalogoactividades=".$_GET['id_catalogoactividades'];
 	
 	//conuslta para recuperar toda la informacion del registro de la actividad
 	$sql_dg = "SELECT ra.cns_regActividades, ra.clave, ca.id_catalogoactividades as id_actividad, ca.id_actividadAcademica, ca.descripcion as nombreactividad, aa.nombreActividad as tipo_actividad, IF(pe.id_programaEducativo>0,1,0) as tieneProgEduc,pe.id_programaEducativo as id_programa, pe.nombrePrograma as programaEducativo, ac.id_areaConocimiento as id_areaconocimiento, ac.descripcion as areaconocimiento, ra.id_temario, va.id_tipoValidacion as id_validacion, va.descripcion as validacion,tp.id_tipoPublico as id_tipopublico, tp.descripcion as publico,sd.id_sede, sd.ubicacion as sede, d.id_dependencia,d.nombreDependencia as dependencia, mo.id_modalidad as modalidadCurso, ra.duracion, ra.fecha_inicio as f_inicio, ra.fecha_termino as f_termino, ra.cupoMinimo as cupo_minimo, ra.cupoMaximo as cupo_maximo, ra.costoUnach as cuota_unach, ra.costoExternos as cuota_externos, ra.fechaCaptura,ra.aplico_dnc FROM Registro_Actividades ra, actividad_academica aa, catalogo_actividades ca, programa_educativo pe, area_conocimiento ac, validacion_actividad va, tipo_publico tp, sede sd, dependencia d, modalidad mo WHERE ra.id_catalogoactividades=ca.id_catalogoactividades AND ca.id_actividadAcademica=aa.id_actividadAcademica AND ra.id_programaEducativo=pe.id_programaEducativo AND ra.id_areaConocimiento=ac.id_areaConocimiento AND ra.id_tipoValidacion=va.id_tipoValidacion AND ra.id_tipoPublico=tp.id_tipoPublico AND ra.id_sede=sd.id_sede AND ra.id_dependencia=d.id_dependencia AND ra.id_modalidad=mo.id_modalidad AND ra.cns_regActividades=(".$registro_max.");";
	
	$resultado = $conex->query($sql_dg);
	$datos_generales=mysqli_fetch_assoc($resultado);
	
	//creacion de objeto de tipo "participantes" para la recuperacion de organizador, coordinador, responsablesCDC y formadores del evento
	$participantes = new CParticipantes($db);
	$id_reg_participantes = 0;

	//primero se busca el registro de participantes en relacion al Id de la actividad	
	if($participantes->buscarRegParticipantes($datos_generales["cns_regActividades"])){
		$id_reg_participantes = $participantes->getRegParticipantes();
	}
	
	//obtenemos al organizador
	$organizador = "";
	$organizador = $participantes->getOrganizador();
	
	//recuperamos los datos del coordinador
	$coordinador = $participantes->getCoordinador();	

	$responsablesCDC = $participantes->getRCDC();	

	$formadores = $participantes->getFormadores();

	$sesion = new CSesiones($db);
	$sesion->setRegActividades($datos_generales["cns_regActividades"]);
	$sesion->getSesionByIdRegAct();
	$lasesion['f_apertura'] = $sesion->getFechaApertura();
	$lasesion['f_cierre'] = $sesion->getFechaCierre();
	$detalle_sesion = $sesion->getDetalleSesion();

	$requisitos = new CRequisito($db);
	$losrequisitos = $requisitos->getRequisitosByIdRegActs($datos_generales["cns_regActividades"],true);

	$temario = new CTemario($db);
	$temario->setIdTemario($datos_generales['id_temario']);
	$eltemario = $temario->getTemarioById();
	$detalle_temario = $temario->getDetalleTemario();

	$recovered_data = '{
							"datos_generales":'.json_encode($datos_generales).',
							"organizador":'.json_encode($organizador).',
							"coordinador":'.json_encode($coordinador).',
							"responsablesCDC":'.json_encode($responsablesCDC).',
							"formadores":'.json_encode($formadores).',
							"sesion":'.json_encode($lasesion).',
							"detalle_sesion":'.json_encode($detalle_sesion).',
							"requisitos":'.json_encode($losrequisitos).',
							"material_didactico":'.json_encode($eltemario).',
							"estructura_curso":'.json_encode($detalle_temario).'
						}';
	echo $recovered_data;
?>