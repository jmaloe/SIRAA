<meta charset="utf-8" />
<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
session_start();
 if(!isset($_SESSION['USER']))
 	header("Location:../");
 	
 require_once("Utilidades.php"); 
 require_once("../clases/CDependencias.php");
 require_once("../db/AccessDB.php");
 global $db;
 $mensaje = "";
 $encontrado = false;
 $objeto = new CDependencias($db);
 $esnuevo=false;
 $pais=1; /*isset($_POST['pais'])?$_POST['pais']:1;*/
 $estado=1; /*isset($_POST['estado'])?$_POST['estado']:1;*/
 $ciudad=100; /*Tuxtla Gtz*/
 
 if(isset($_POST['accion']))
{
 if($_POST['accion']=="BUSCAR")
 { 	
 	$objeto->getDependenciaByName($_POST['nombreDependencia']);
 	if($objeto->getIdDependencia()>0){ 		
 		$encontrado=true;
 		$mensaje = "Dependencia encontrada ID: ".$objeto->getIdDependencia();
 	}
 	else
 		$mensaje = 'No se encontraron coincidencias para "'.$_POST['nombreDependencia'].'"';
 	 	
 }
 else
 {
  $objeto->setIdCiudad($_POST['ciudad']);  
  $objeto->setNombreDependencia($_POST['nombreDependencia']);
  $objeto->setDireccion($_POST['direccion']);

   if($_POST['accion']=="GUARDAR")
   {
 	if($objeto->registrarDependencia()){
 	 $mensaje = "Nueva dependencia agregada ID: ".$objeto->getIdDependencia(); 	 
 	 $encontrado=true;
 	 $esnuevo=true;
 	 /*AGREGAR UN HIDDEN PARA PRESERVAR EL NOMBRE Y MOSTRARLO EN EL FORMULARIO PRINCIPAL*/
 	}
 	else
 	  $mensaje = "Error: ".$objeto->getError();	
   }
   else if($_POST['accion']=="ACTUALIZAR"){
   	$objeto->setIdDependencia($_POST['id_dependencia']); /*id_ciudad*/
   	$rowsAffected = $objeto->actualizarDependencia();
   	if($rowsAffected==-1){
   	  $mensaje = "Error: ".$objeto->getError();
   	}else{
   	  $mensaje = $rowsAffected." registro actualizado";
   	  $encontrado=true;
   	  $esnuevo=true;
   	}
   }
 }
}
 getStyles();
?>
<form action="FDependencia.php" method="POST">
<?php 
  /*resguardamos el id de la persona en un hidden*/
  
   echo '<input type="hidden" name="id_dependencia" id="id_dependencia" value="'.$objeto->getIdDependencia().'">';   
  
 ?>		
<div id="formulario_dependencias" class="panel panel-primary">
	<div class="panel-heading">Dependencias</div>
	<?php
	 if($mensaje!=""){
  		echo '<div id="mensajes">'.$mensaje.'</div>';
	 }
	?>
	<div class="panel-body">
	<div class="form-group">
	  	<label class="tres">Pais:</label>
	  	<div class="nueve">
		 <select id="pais" class="form-control" name="pais" <?php if(!$encontrado) echo 'onchange="this.form.submit();"';?>>
		 	<?php
		 	 if(isset($pais))
		 	 {
		 	  echo "<option value='0'>ELIGE</option>";
		 	  echo $objeto->getPaises($pais);
		 	 }
		 	 else
		 	 {
		 	  echo "<option value='0'>ELIGE</option>";
		 	  $paisdefault = $encontrado ? $objeto->getIdPais() : 1;
		 	  echo $objeto->getPaises($paisdefault); /*no hay seleccion por default*/
		 	 }
		 	?>
		 </select>
	   </div>
	</div>   
	<div class="form-group">
		<label class="tres">Estado:</label>
	  	<div class="nueve">
		 <select id="estado" class="form-control" name="estado" <?php if(!$encontrado) echo 'onchange="this.form.submit();"';?>>
		 	<?php
		 	 if(isset($pais))
		 	 {
		 	 	if(isset($ciudad))
		 	 	{
		 	 		echo "<option value='0'>ELIGE</option>";
					echo $objeto->getEstadosByPais($pais,$estado); 
		 	 	}
		 	 	else
		 	 	{
		 	 		echo "<option value='0'>ELIGE</option>";
		 	 		$estadodefault = $encontrado ? $objeto->getIdEstado() : 0;		 	 		
		 	 		$elpais = $pais ? $pais : $objeto->getIdPais();
		 	 		echo $objeto->getEstadosByPais($elpais,$estadodefault);
		 	 	}
		 	 }
		 	?>
		 </select>
	  </div>
	</div>
	<div class="form-group"> 
		<label class="tres">Ciudad:</label>
	  	<div class="nueve">
		 <select id="ciudad" class="form-control" name="ciudad">
		 	<?php 
		 	 if(isset($estado) | $encontrado)
		 	 {
		 	 	$elestado = $estado ? $estado : $objeto->getIdEstado(); 
		 	 	echo $objeto->getCiudadesByEstado($elestado,$encontrado ? $objeto->getIdCiudad() : $ciudad);
		 	 }
		 	?>
		 </select>
		</div>
	</div>
	<div class="form-group"> 
		<label class="tres">Nombre de la dependencia:</label>
	  	<div class="nueve">
			<input type="text" id="nombreDependencia" name="nombreDependencia" maxlength="255" autocomplete="off" required class="form-control" <?php if($encontrado & !$esnuevo) echo 'value="'.$objeto->getNombreDependencia().'"'; ?>>
		</div>
	</div>	
	<div class="form-group">
		<label class="tres">Direccion:</label>
	  	<div class="nueve">
			<input type="text" id="direccion" name="direccion" autocomplete="off" maxlength="255" required class="form-control" <?php if($encontrado & !$esnuevo) echo 'value="'.$objeto->getDireccion().'"'; ?>>
		</div>
	</div>
	<div class="form-group">
		<?php 
		require_once("../acceso/CPermisos.php");
		$acceso = $permiso->getPermisos("FDependencia");
		  getAcciones($encontrado,$encontrado, $acceso);
		  $db->close_conn();
		?>
	</div>
   </div>
</div>
</form>
<?php
 getScripts(); /*imprime los js necesarios*/
?>
<script>
  /*definir en parent el iframe con id iframe_dependencia*/
  ajustarAltoIframe("iframe_dependencia",$(document).height());
  
  $(".aceptar").click(function(data)
  {
  	if($("#id_dependencia").val()<=0){
  	  alert("No ha seleccionado una dependencia");
  	  return;
  	}
  	var dependencia = {
  		nombre:<?php echo '"'.$objeto->getNombreDependencia().'"'; ?>,
  		id_: $("#id_dependencia").val()};
  	window.parent.showDependencia(dependencia);  	
  	$('#addDependencia', window.parent.document).hide();
  });
</script>