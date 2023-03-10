<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
 header('Content-type: text/html; charset=utf-8');
 session_start();

 if(!isset($_SESSION['USER']))
 	header("Location:../");
 
 require_once("../db/AccessDB.php");
 require_once("../acceso/CPermisos.php");
 require_once("../clases/CAdscripcion.php");
 require_once("Utilidades.php");

 $acceso = $permiso->getPermisos("FAdminUsuarios");
 $msj = "";
 $encontrado=false;

 if(isset($_POST['accion']))
 {

 	require_once("../acceso/CUsuario.php");
 	
 	$usuario = new CUsuario($db);
 	if(isset($_POST['usuario']))
 	 $usuario->setUsuario($_POST['usuario']);
 	if(isset($_POST['password']))
 	  $usuario->setPassword($_POST['password']);
 	if(isset($_POST['nombre']))
 	  $usuario->setNombre($_POST['nombre']);
 	if(isset($_POST['correo']))
 	  $usuario->setEmail($_POST['correo']);
 	//objeto para busqueda de adscripcion del usuario
 	$adscripcion = new CAdscripcion($db);
 	$adscripcion->setIdAdscripcion(isset($_POST['id_adscripcion'])?$_POST['id_adscripcion']:0);
 	$usuario->setAdscripcion($adscripcion);

 	if($_POST['accion']=="GUARDAR"){
 		checkAdscripcion(); 		
 		require_once("../acceso/CRoles.php");
		$roles = new CRoles($db);		
 		if($usuario->guardar()){
 			$msj = "Usuario registrado correctamente";
 			$roles->setIdUsuario($usuario->getIdUsuario());
 			$roles->setIdRol($_POST['rol_usuario']);
 			$roles->setRolToUser();
 		}
 		else{
 			$msj = "Error: ".$usuario->getError();
 		}
 	}
 	else if($_POST['accion']=="BUSCAR" | $_POST['accion']=="Ajustar"){
 		if($_POST['usuario']!="")
 		{
 			$encontrado = $usuario->buscarByUser(); 			
 		}
 		else if($_POST['nombre']!="")
 		{
 			$encontrado = $usuario->buscarByNombre(); 			
 		}
 		else if($_POST['correo']!="")
 		{
 			$encontrado = $usuario->buscarByEmail(); 			
 		}
 	}
 	else if($_POST['accion']=="ELIMINAR"){
 		if($usuario->eliminar()){
 			$msj = "Se eliminĂ³ correctamente el usuario ".$usuario->getUsuario();
 		}
 	}
 	else if($_POST['accion']=="ACTUALIZAR"){
 		checkAdscripcion();
 		if($acceso['w'])
 		{
 			if(isset($_POST['activo']))
 				$usuario->setActivo(1);
 			else
 				$usuario->setActivo(0);
 		}
 		if(!$usuario->actualizar())
 			$msj = $usuario->getError();
 		else
 			$msj = "Usuario actualizado: ".$usuario->getUsuario();
 	}
 }

 function checkAdscripcion(){
 	global $adscripcion, $usuario;
 	if(isset($_POST['id_adscripcion'])){
	 		if(isset($_POST['adscripcion'])){
	 			if($_POST['id_adscripcion']>0){
	 				$adscripcion->setIdAdscripcion($_POST['id_adscripcion']);
	 			}
	 			else{
	 				$adscripcion->setNombreAdscripcion($_POST['adscripcion']);
	 				$adscripcion->guardar();
	 			}
	 		}
	 		else
	 			$adscripcion->setIdAdscripcion(0);
	 		$usuario->setAdscripcion($adscripcion);
	 	}
 }
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>AdministraciĂ³n de usuarios</title>
		<meta charset="utf-8" />
		<meta name="description" content="Login">
		<meta name="author" content="JesĂºs Malo Escobar">
		<?php getStyles(); ?>		
	</head>
	<body class="formularioLogin" style="width:30%; margin:0 auto;">
		<section id="Admin">
			<form id="form_users" action="FAdminUsuarios.php" method="POST" accept-charset="UTF-8"
enctype="application/x-www-form-urlencoded" autocomplete="off" id="form_users">
			<div class="panel panel-primary">
			    <div class="panel-heading">Administrador</div>
				 <div class="panel-body">
				 	<?php
				 	 if($msj!="")
				 	 {
				 	 	echo '<div class="form-group"><label style="color:gray">'.$msj.'</label></div>';
				 	 }
				 	?>

				 	<div class="form-group">
				 		<fieldset>
				 		<legend>AdministraciĂ³n de usuarios</legend>
				 		<div class="doce form-group">
					 		<label class="tres">Usuario:</label>
					 		<div class="nueve">
					 			<input type="text" name="usuario" id="usuario" class="form-control" maxlength="255" placeholder="usuario" 
					 			 <?php if($encontrado) echo 'value="'.$usuario->getUsuario().'" readonly'; ?>
					 			>
					 		</div>
					 	</div>
					 	<div class="doce form-group">
					 		<label class="tres">ContraseĂ±a:</label>
					 		<div class="nueve">
					 			<input type="password" name="password" id="password" class="form-control" maxlength="255" placeholder="password" <?php if($encontrado) echo 'value="******"'; ?>>
					 		</div>
					 	</div>
					 	<div class="doce form-group">
					 		<label class="tres">Confirmar contraseĂ±a:</label>
					 		<div class="nueve">
					 			<input type="password" name="password2" id="password2" class="form-control" maxlength="255" placeholder="confirma password" <?php if($encontrado) echo 'value="******"'; ?>>
					 		</div>
					 	</div>
					 	<div class="doce form-group">
					 		<label class="tres">Nombre:</label>
					 		<div class="nueve">
					 			<input type="text" name="nombre" id="nombre" class="form-control" maxlength="255" placeholder="nombre completo" <?php if($encontrado) echo 'value="'.$usuario->getNombre().'"'; ?>>
					 		</div>
					 	</div>
					 	<div class="doce form-group">
					 		<label class="tres">Email:</label>
					 		<div class="nueve">
					 			<input type="email" name="correo" id="correo" class="form-control" maxlength="255" placeholder="correo@unach.mx" <?php if($encontrado) echo 'value="'.$usuario->getEmail().'"'; ?>>
					 		</div>
					 	</div>
					 	<div class="doce form-group">
					 		<label class="tres">AdscripciĂ³n:</label>
					 		<input type="hidden" id="id_adscripcion" name="id_adscripcion" <?php if($encontrado) echo 'value="'.$usuario->getAdscripcion()->getIdAdscripcion().'"'; else echo 'value="0"'; ?>>
					 		<div class="nueve">
					 			<input list="adscripciones" name="adscripcion" id="adscripcion" autocomplete="off" class="form-control inputlist" maxlength="255" <?php if($encontrado) echo 'value="'.$usuario->getAdscripcion()->getNombreAdscripcion().'"'; ?>>
					 			<datalist id="adscripciones">
									<?php
										$adscripcion = new CAdscripcion($db);
									  	echo $adscripcion->getAdscripciones($adscripcion->getIdAdscripcion()>0?$adscripcion->getIdAdscripcion():0);
									?>
					 			</datalist>
					 		</div>
					 	</div>
					 	<?php 
					 		if(!$encontrado)
					 		{
					 	?>
							 	<div class="doce" id="rol" style="margin-bottom:10px;">
									<label class="tres">Rol:</label>
									<div id="lista_roles" class="nueve">
									  <select id="rol_usuario" name="rol_usuario" class="form-control"  <?php if($_SESSION['rol_usuario']>1) echo "readonly"; ?>>
									  	<?php
									  	require_once("../acceso/CRoles.php");
									  	$roles = new CRoles($db);
									  	echo $roles->getRoles(3);							  	
									  	?>
									  </select>
									</div>
								</div>
					 	<?php
					 		}
					 	if($encontrado)
					 	{
					 		if($acceso['w'])
					 		{					 		
					 		$checked = "";
					 		if($usuario->isActivo())
					 			$checked = "checked";
					 		echo '<div class="doce form-group">
					 		<label class="tres">Activo:</label>
					 			<div class="nueve">
					 			<input type="checkbox" name="activo" id="activo" class="uno" '.$checked.'>
					 			</div>
					 		</div>';
					 	 	}
					 	}
					 	?>

					 	<div class="form-group">
					 		<?php	
					 		 getAcciones(false, $encontrado, $acceso);					 		
					 		?>
					 		<button type="submit" id="btn_listausuarios" name="mostrar_lista" value="VERLISTAUSUARIOS" class="btn btn-warning">Ver usuarios</button>
					 	</div>
				 		</fieldset>
				 	</div>
				 </div>
			</div>
			</form>
			<?php			
			if(isset($_POST['mostrar_lista']))
			{				
			require_once("../acceso/CUsuario.php");
 			$usuario = new CUsuario($db); 			
			echo '<div id="tabla_exportar" class="table-responsive lista_usuarios">
				<table class="actividades">
					<thead>
						<th>ID</th>
						<th>AdscripciĂ³n</th>
						<th>Usuario</th>						
						<th>Nombre</th>
						<th>Email</th>
						<th>Vigente</th>
						<th>Rol</th>
						<th>Fecha de captura</th>						
					</thead>
					<tbody>';
					echo $usuario->getListaUsuariosConRol();
					echo $usuario->getListaUsuariosSinRol();
			echo	'</tbody>
				</table>
				</div>';
				echo getExportarExcelButton(); //Utilidades.php
			}
			?>	
			</div>
		</section>
		<?php 
			echo getHomeButton();
			$db->close_conn();
			getScripts();
			getExcelExportScripts();
		?>
		<script src="../js/admin_users_validaciones.js"></script>				
	</body>
</html>