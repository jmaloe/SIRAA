<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
 session_start();

 if(!isset($_SESSION['USER']))
 	header("Location:../");
 
 require_once("../db/AccessDB.php");

 require_once("../acceso/CPermisos.php");

 $msj = "";

 function notificar($obj_ra){
   require_once("../PHPMailer/Mailer.php");
   require_once("../acceso/CUsuario.php");
   global $db;
   //verificamos quien esta validando la actividad
   $usuario = new CUsuario($db);
   $usuario->setIdUsuario($_SESSION["ID_USER"]);
   $usuario->buscarById();

   //direccion del emisor o remitente
   $direcciones = Array(
      array('email' => $usuario->getEmail(), 'nombre_completo' => $usuario->getNombre())
   );

   $detalle_actividad = $obj_ra->getActividadById();

   $correo = new Correo();
   $correo->setAsunto("SIRAA: Aprobación de actividad");

   $correo->setRemitente($usuario->getEmail(), $usuario->getNombre());
   
   $contenido = '<p>El Sistema de Registro de Actividades Académicas(SIRAA) informa:</p>'.
               '<p>EL REGISTRO DE SU EVENTO O ACTIVIDAD ACADÉMICA CON NÚMERO <b>'.$detalle_actividad['cns_regActividades'].'</b> HA SIDO APROBADO, INGRESE AL SISTEMA PARA VISUALIZAR EL FOLIO.</p>'.
   				'<p><i>"Por la conciencia de la necesidad de servir"</i></p>';
    //echo "CONTENIDO:".$contenido->toString();
   $correo->setContenido($contenido); //false para no retornar los controles o botones: display_event.php

   $usuario->setIdUsuario( $detalle_actividad['usr_elaboro'] );
   $usuario->buscarById();

   //direccion del destinatario
   array_push($direcciones, array('email' => $usuario->getEmail(), 'nombre_completo' => $usuario->getNombre()));   

   $correo->setDirecciones($direcciones);
   
   $correo->enviar();   
 }

 if(isset($_POST['accion']))
 {
 	require_once('../clases/CRegistroActividad.php');
 	$obj_registro = new RegistroActividad($db);
 	$obj_registro->setIDRegistroActividad($_POST['id_e']);

 	if($_POST['accion']=="Aprobar")
 	{
 		$aprobacion = $permiso->getPermisos("AprobacionActs");
 		/*si el usuario puede grabar la aprobacion*/
 		if($aprobacion['w']){
 			$obj_registro->generarClave();
 			notificar($obj_registro);
 		}
 	}
 	else if($_POST['accion']=="CancelarAprobacion")
 	{
 		$cancelacion = $permiso->getPermisos("CancelacionActs");
 		/*si el usuario puede grabar la cancelacion*/
 		if($cancelacion['w']){
 			$obj_registro->cancelarRegistro();
 		}
 	}
 }
	$db->close_conn();
?>