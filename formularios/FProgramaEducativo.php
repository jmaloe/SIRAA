<?php
/*Autor: Jesus Malo, support: dic.malo@gmail.com*/
session_start();
 if(!isset($_SESSION['USER']))
  header("Location:../");
  
 require_once("Utilidades.php"); 
 require_once("../clases/CProgramaEducativo.php");
 require_once("../db/AccessDB.php");

 global $db;

 $programa = new CProgramaEducativo($db);
 $mensaje = "";
 $encontrado = false;
 $programas = "";
 $cancelado=false;

if(isset($_POST['tipo_programa']))
{
	//echo "Buscando programas de:".$_POST['tipo_programa'];
   	$programas = $programa->getProgramasEducativos($_POST['tipo_programa']);
   	$mensaje = $programa->getNumRows()." programa(s) en categoria (".$_POST['tipo_programa'].")";
    if($programa->getNumRows()>0)
      $encontrado=true;
}

if(isset($_POST['accion']))
{
 if($_POST['accion']=="BUSCAR")
 {
 	$programa->getProgramaByName($_POST['progeduc']);
 	if($programa->getIdPrograma()>0){
    /*asignamos el programa al datalist programas_educativos*/
    $programas='<option id="'.$programa->getIdPrograma().'" value="'.$programa->getNombrePrograma().'"></option>';
 		$encontrado=true;
 		$mensaje = "Programa encontrado ID: ".$programa->getIdPrograma();
 	}
 	else
 		$mensaje = 'No se encontraron coincidencias para "'.$_POST['progeduc'].'"';
 }
 else
 {
  $programa->setIdClasificacion	($_POST['tipo_programa']);  
  $programa->setNombrePrograma($_POST['progeduc']);

  if($_POST['accion']=="GUARDAR")
  {
  	$id_p = $programa->registrarPrograma();
 	  $mensaje = "Nuevo programa registrado: ".$id_p;
    $encontrado=true;
    $programas = $programa->getProgramasEducativos($_POST['tipo_programa']);
  }
  else if($_POST['accion']=="ACTUALIZAR"){
  	$programa->setIdPrograma($_POST['id_programa']);
  	$id_p = $programa->actualizarPrograma();
  	$mensaje = "Programa actualizado: ".$id_p;
    $encontrado=true;
    $programas = $programa->getProgramasEducativos($_POST['tipo_programa']);
  }
 }
}
 getStyles(); 
?>

<form action="FProgramaEducativo.php" method="POST">
<?php
/*resguardamos el id del programa en un hidden*/
if($encontrado)
 echo "<input type=\"hidden\" name=\"id_programa\" id=\"id_programa\" value=\"".$programa->getIdPrograma()."\">";	
?>
<div id="formulario_programas_educativos" class="panel panel-primary">
	<div class="panel-heading">Programas Educativos</div>
  <?php
  if(isset($mensaje)){
    echo '<div id="mensajes">'.$mensaje.'</div>';
  }
  ?>
  <div class="panel-body">
	<div id="clasificacion" class="form-group">
	  	<label for="tipo_programa" class="tres">Clasificación:</label>
      <div class="nueve">
		 <select id="tipo_programa" class="form-control" name="tipo_programa" required>
		 	<?php
       
		 	 if(isset($_POST['tipo_programa']))
		 	 {
        echo '<option value="" disabled selected>--Selecciona--</option>';
		 	  echo $programa->getClasificacionProgramas($_POST['tipo_programa']);
		 	 }
		 	 else
		 	 {
		 	  $id_categoria = $encontrado ? $programa->getIdClasificacion() : 0;
		 	  echo '<option value="" disabled selected>--Selecciona--</option>';
		 	  echo $programa->getClasificacionProgramas($id_categoria); /*no hay seleccion por default*/
		 	 }
		 	?>
		 </select>
    </div>
	</div>
	<div class="form-group">
    <label for="progeduc" class="tres">Programa educativo:</label>
    <div class="nueve">
		<input type="text" id="progeduc" list="programa_educativo" class="form-control" name="progeduc" maxlength="255" autocomplete="off" <?php if($encontrado) echo 'value="'.$programa->getNombrePrograma().'"'; ?> required>
		 <datalist id="programa_educativo">
		  <?php echo $programas; ?>
		 </datalist>
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
 getScripts(); /*js necesarios para funcionalidad*/
?>
<script>
 ajustarAltoIframe("iframe_progeduc",$(document).height());
  $(".aceptar").click(function(data)
  {
  	if(getDataListIdValue("#progeduc","#programa_educativo")>0){
  	  var programa = { 
  		  programa: $("#progeduc").val(),
  		  id_: getDataListIdValue("#progeduc","#programa_educativo")
  	  }
  	 window.parent.showPrograma(programa); /*definir showPrograma en el formulario padre*/	
  	}
  	else
    {
      if($("#actualizar").val()!="GUARDAR")
      {
  		  alert("Elige un programa");
        return;
      }
    }
    if($("#actualizar").val()!="GUARDAR")
      $('#addPrograma', window.parent.document).hide();
  });
  $("#progeduc").bind('input', function () {
    if(getDataListIdValue("#progeduc","#programa_educativo")>0)
    {
      $("#actualizar").show();
      $("#actualizar").val("ACTUALIZAR");
      $("#actualizar").html("Actualizar");
      $("#btn_aceptar").show();
      $("#id_programa").val(getDataListIdValue("#progeduc","#programa_educativo")); //asignamos el id del programa que se va a actualizar
    }
    else
    {
      $("#actualizar").val("GUARDAR");
      $("#actualizar").html("Guardar");
      $("#btn_aceptar").hide();      
    }
  });

  $("#tipo_programa").on('change',function(){
    if($("#progeduc").val()=="")
      $(this).closest('form').submit();
  });
</script>