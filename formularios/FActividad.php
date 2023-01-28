<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
session_start();
 if(!isset($_SESSION['USER']))
 	header("Location:../");

 header('Content-type: text/html; charset=utf-8');
 require_once('../clases/CActividad.php');
 require_once("../db/AccessDB.php");
 require_once("Utilidades.php"); 
 if(!$db->connect())
 	echo "Error de conexión a la base de datos";
  $actividades = new CActividad($db);
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Educación Continua: Sistema de Registro de Actividades Académicas</title>
		<meta charset="utf-8" />
		<meta name="description" content="Formulario principal">
		<meta name="author" content="Jesús Malo Escobar">
		<link href="../imagenes/favicon.ico" rel="icon" type="image/x-icon">
		<?php  getStyles(); /*para darle estilos al formulario*/ ?>
	</head>
	<body class="todo-contenido">
		<div class="container">		
		<?php
		 require_once("header.php");	
		 $permiso_recurso = $permiso->getPermisos('FRegistroActividad');
		 if($permiso_recurso['w'])
		 {
		?>
		<section id="selecion_actividad">
			<form action="FRegistroActividad.php" method="POST" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
			<fieldset>
		  		<legend>SISTEMA DE REGISTRO DE ACTIVIDADES Y EVENTOS ACADEMICOS <a href="../manual/" target="_blank"><img src="../imagenes/manual_usuario.png" width="30" height="30" title="Manual de usuario"></a></legend>
				<div>¡Bienvenido <?php echo $_SESSION['USERNAME']; ?>!</div>
				<p>¡Juntos lograremos formar cada vez a más personas!</p>
				
				<div id="actividad_academica">
					<p>Seleccione una actividad académica:</p>
				  <select id="actividad" name="actividad" class="form-control cuatro">
				  	<?php 
				  	 echo $actividades->getActividades(); 
				  	 $db->close_conn();
				  	?>
				  </select>
				</div>				
				<label for="enviar" class="btn btn-success">
					<div class="imgbutton go_icon"></div>
					<input type="submit" id="enviar" name="enviar" value="Comenzar" class="btnsinfondo" />					
				</label>
			</fieldset>
			</form>
		</section>
		<?php 
		}
		$permiso_recurso = $permiso->getPermisos('FAdministracion');
		$permiso_buscar_asistentes = $permiso->getPermisos('BuscarAsistentes');
		if($permiso_recurso['r'])
		{
		?>
		<section id="administracion">
			<fieldset>
		  		<legend>Administración de actividades y eventos</legend>
				<form action="FAdministracion.php" method="POST" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
				<label class="btn btn-info">
					<div class="imgbutton admin_icon"></div>
					<button type="submit" id="accion1" name="accionFA" value="actividades_eventos" class="btnsinfondo" />Actividades/Eventos</button>
				</label>
				<?php
				if($permiso_buscar_asistentes['r'])
					echo '<label class="btn btn-warning">
					<div class="imgbutton admin_asistentes_icon"></div>
					<button type="submit" id="accion2" name="accionFA" value="consulta_asistentes" class="btnsinfondo" />Lista de asistentes</button>
				</label>';
				?>
				</form>				
			</fieldset>
		</section>
		<?php
		}
		$permiso_recurso = $permiso->getPermisos('FAdminUsuarios');
		if($permiso_recurso['w'])
		{
		?>
		<section id="administracion_usuarios">			
			<fieldset>
		  		<legend>Administración de usuarios y permisos</legend>
		  		<form action="FAdminUsuarios.php" method="POST" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>		  		
				<label for="admin_users" class="btn btn-default">
					<div class="imgbutton admin_users"></div>
					<input type="submit" id="admin_users" name="admin_users" value="Usuarios" class="btnsinfondo" />
				</label>
				</form>
				<form action="FAdminPermisos.php" method="POST">
					<label for="permisos_users" class="btn btn-default">
						<div class="imgbutton permisos_users"></div>
						<input type="submit" id="permisos_users" name="permisos_users" value="Permisos" class="btnsinfondo" />
					</label>
				</form>
				<form action="FAdminRoles.php" method="POST">
					<label for="roles_users" class="btn btn-default">
						<div class="imgbutton roles_users"></div>
						<input type="submit" id="roles_users" name="roles_users" value="Roles y recursos" class="btnsinfondo" />
					</label>
				</form>
			</fieldset>
			</form>
		</section>
		<?php
		}
		$permiso_recurso = $permiso->getPermisos('FReportes');
		if($permiso_recurso['w'])
		{
		?>
        <section id="reportes">
			<fieldset>
		  		<legend>Informes</legend>		  		
		  		<form action="FReportes.php" method="POST" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" novalidate>
				<label for="informe" class="btn btn-warning">
					<div class="imgbutton informes_icon"></div>
					<input type="submit" id="informe" name="informe" value="ver reporte" class="btnsinfondo" />
				</label>
				</form>
			</fieldset>			
		</section>
		<?php
		}
		?>
		<footer>Universidad Virtual UNACH 2015 - By: jesus.malo@unach.mx</footer>
		</div>		
	</body>
</html>
<?php
	getScripts(); 
?>