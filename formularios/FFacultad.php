<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
session_start();
 if(!isset($_SESSION['USER']))
  header("Location:../");
  
 require_once("Utilidades.php"); 
 require_once("../clases/CFacultad.php");
 require_once("../db/AccessDB.php");

 global $db;

 $obj_facultad = new CFacultad($db);
 $mensaje = "";
 $encontrado = false;

if(isset($_POST['id_campus']))
{
  $obj_facultad->setIdCampus($_POST['id_campus']);
  if($obj_facultad->getNumRows()>0)
    $encontrado=true;
}
if(isset($_POST['accion']))
{
 if($_POST['accion']=="BUSCAR")
 {  
 	$obj_facultad->getFacultadByName($_POST['facultad']);
 	if($obj_facultad->getIdFacultad()>0){
 		$encontrado=true;
 		$mensaje = "Facultad encontrada, ID: ".$obj_facultad->getIdFacultad(); 		
 	}
 	else
 		$mensaje = 'No se encontraron coincidencias para "'.$_POST['facultad'].'"';
 }
 else
 {
  $obj_facultad->setIdCampus($_POST['id_campus']);  
  $obj_facultad->setNombreFacultad($_POST['facultad']);
  $obj_facultad->setDireccion($_POST['direccion']);

  if($_POST['accion']=="GUARDAR")
  {
  	if($obj_facultad->registrarFacultad())
 	    $mensaje = "Nueva facultad registrada, ID: ".$obj_facultad->getIdFacultad();
    else
      $mensaje = "Error:".$obj_facultad->getError();
    $encontrado=true;
  }
  else if($_POST['accion']=="ACTUALIZAR"){
  	$obj_facultad->setIdFacultad($_POST['id_facultad']);
  	$id_f = $obj_facultad->actualizarFacultad();
  	$mensaje = "Facultad actualizada, ID: ".$id_f;
    $encontrado=true;
  }
 }
} 
 getStyles();
?>

<form action="FFacultad.php" method="POST">
<?php
/*resguardamos el id del campus en un hidden*/
if($encontrado)
 echo "<input type=\"hidden\" name=\"id_facultad\" id=\"id_facultad\" value=\"".$obj_facultad->getIdFacultad()."\">";	
?>
<div id="formulario_facultad" class="panel panel-primary">
	<div class="panel-heading">Facultades</div>
  <?php
  if(isset($mensaje)){
    echo '<div id="mensajes">'.$mensaje.'</div>';
  }
  ?>
  <div class="panel-body">
	<div id="clasificacion" class="form-group">
	  	<label for="id_campus" class="tres">Campus:</label>
      <div class="nueve">
		 <select id="id_campus" class="form-control" name="id_campus" <?php if(!$encontrado) echo 'onchange="this.form.submit();"'?> required>
		 	<?php
		 	 if(isset($_POST['id_campus']) & !$encontrado)
		 	 {
		 	  echo $obj_facultad->getCampusToSelect($_POST['id_campus']);
		 	 }
		 	 else
		 	 {
		 	  $id_campus = $encontrado ? $obj_facultad->getIdCampus() : 0;			 	  
		 	  echo "<option value=''>ELIGE</option>";
		 	  echo $obj_facultad->getCampusToSelect($id_campus); /*no hay seleccion por default*/
		 	 }
		 	?>
		 </select>
    </div>
	</div>
	<div class="form-group">
    <label for="facultad" class="tres">Facultad:</label>
    <div class="nueve">
		  <input type="text" id="facultad" class="form-control" maxlength="255" name="facultad" autocomplete="off" <?php if($encontrado) echo 'value="'.$obj_facultad->getNombreFacultad().'"'; else echo "required"; ?>>		 
    </div>
	</div>
  <div class="form-group">
    <label for="direccion" class="tres">Dirección:</label>
    <div class="nueve">
      <input type="text" id="direccion" class="form-control" maxlength="255" name="direccion" autocomplete="off" <?php if($encontrado) echo 'value="'.$obj_facultad->getDireccion().'"'; else echo "required"; ?>>
    </div>
  </div>
	<div class="form-group">
    <?php
    require_once("../acceso/CPermisos.php");
    $acceso = $permiso->getPermisos("FProgramaEducativo");
     getAcciones($encontrado, $encontrado, $acceso); /*botones necesarios para las acciones*/
     $db->close_conn();
    ?>		
	</div>
</div>
</div>
</form>
<?php
  getScripts(); /*js y css necesarios para estilo y funcionalidad*/
?>
<script>
 ajustarAltoIframe("iframe_facultad",$(this).height());
 window.parent.resize($(this).height()+10); 
 $(this).attr("z-index","9999");
  $(".aceptar").click(function(data)
  {
  	if($("#id_campus option:selected")){
  	  var facultad = { 
  		 facultad: $("#facultad").val(),
  		 id_: $("#id_facultad").val()
  	  }
  	  window.parent.showFacultad(facultad); /*definir showPrograma en el formulario padre*/	      
      $('#addFacultad', window.parent.document).hide();
  	}
  });
</script>