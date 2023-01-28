<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
session_start();
 if(!isset($_SESSION['USER']))
  header("Location:../");
  
 require_once("../clases/CSedes.php");
 require_once("../db/AccessDB.php");
 require_once("Utilidades.php");

 global $db;

 $encontrado=false; 
 $esnuevo=false;
 $mensaje="";
 $sedes = new CSedes($db);

if(isset($_POST['accion']))
{
 if($_POST['accion']=="BUSCAR")
 {
 	$sedes->getSedeByName($_POST['nombresede']);
 	if($sedes->getIdSede()>0){
 		$encontrado=true;
 		$mensaje = "Sede encontrada: ".$sedes->getIdSede();
 	}
 	else
 		$mensaje = 'No se encontraron coincidencias para "'.$_POST['nombresede'].'"'; 	 	
 }
 else
 {
  $sedes->setNombreSede($_POST['nombresede']);
  $sedes->setIdFacultad($_POST['facultad']);
   if($_POST['accion']=="GUARDAR")
   {
    if($sedes->registrarSede()){
      $mensaje = "Nueva sede agregada: ".$sedes->getIdSede();
      $esnuevo=true;
      $encontrado=true;
    }
    else
       $mensaje = "Error: ".$sedes->getError();
   }
   else if($_POST['accion']=="ACTUALIZAR"){
   	$sedes->setIdSede($_POST['id_sede']);
   	$rowsAffected = $sedes->actualizarSede();
   	if($rowsAffected==-1)
   	  $mensaje = "Error: ".$sedes->getError();
   	else
   	  $mensaje = $rowsAffected." registro actualizado";
   }
 }
}
 getStyles(); //css 
?>

<form action="FSede.php" method="POST" id="form_sede">
<?php 
  /*resguardamos el id de la persona en un hidden*/
   echo '<input type="hidden" name="id_sede" id="id_sede" value="'.$sedes->getIdSede().'">';
 ?>
<div class="panel panel-primary">
  <div class="panel-heading">Sedes</div>
  <?php
  if($mensaje!=""){
    echo '<div id="mensajes">'.$mensaje.'</div>';
  }
  ?>
  <div class="panel-body">
    <div class="form-group">
  	  	<label for="facultad" class="tres">Facultad:</label>
        <div class="nueve">
      		<select id="facultad" name="facultad" class="form-control" required>
      		 	<?php
      		 	 if(isset($_POST['facultad']) & !$encontrado)
      		 	 {
      		 	  echo "<option value=''>ELIGE</option>";
      		 	  echo $sedes->getFacultades($_POST['facultad']);
      		 	 }
      		 	 else
      		 	 {
      		 	  echo "<option value=''>ELIGE</option>";
      		 	  $facultaddefault = $encontrado ? $sedes->getIdFacultad() : 0;
      		 	  echo $sedes->getFacultades($facultaddefault); /*no hay seleccion por default*/
      		 	 }
      		 	?>
      		</select>      
          <a href="#addFacultad" class="boton">
            <input type="button" id="agregarFacultad" value="+" class="btn btn-default"/>
          </a>
        </div>
  	</div>
    <div id="addFacultad" class="modalDialog">
        <div>
          <a href="#close" title="Cerrar" class="cerrar">X</a>
          <div id="formFacultad">
            <iframe src="FFacultad.php" id="iframe_facultad"></iframe>
          </div>
        </div>
    </div>
    <div class="form-group">
      <label for="nombresede" class="tres">Sede/lugar:</label>
       <div class="nueve">
        <input type="text" id="nombresede" maxlength="255" class="form-control" name="nombresede" placeholder="Escribe aquí" autocomplete="off" <?php if($encontrado & !$esnuevo) echo ' value="'.$sedes->getNombreSede().'"'; else if($esnuevo) echo ' placeholder="'.$sedes->getNombreSede().'"'; ?> required>
       </div>
    </div>
    <div class="form-group">
      <?php 
        require_once("../acceso/CPermisos.php");
        $acceso = $permiso->getPermisos("FSede");
        getAcciones($encontrado, $encontrado, $acceso); /*isAdd, isUpdate, acceso -> en Utilidades.php*/
        $db->close_conn();
      ?>
    </div>
  </div>
</div>
</form>
<?php
 getScripts(); /*js necesarios para funcionalidad*/
?>

<script>
  ajustarAltoIframe("iframe_sede",$(document).height());

  $(".aceptar").click(function(data){
    if($("#id_sede").val()<=0){
      alert("No ha seleccionado una sede");
      return;
    }
  	var sede={
  				id_sede:$("#id_sede").val(),
  				nombreSede:<?php echo '"'.$sedes->getNombreSede().'"'; ?>
  			  };
  	window.parent.showSede(sede);
    $('#addSede', window.parent.document).hide();
    $(this).closest('form').validate().cancelSubmit = true;
  });

  function showFacultad(data){
    $("#facultad").append('<option value="'+data.id_+'" selected>'+data.facultad+'</option>');
  }

  function resize(height){
    ajustarAltoIframe("iframe_sede",height);
  }
</script>