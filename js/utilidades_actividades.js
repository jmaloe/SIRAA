$(function(){
 /*omitimos las validaciones al hacer submit*/
 $("#buscar").on('click', function(evt)
 {
        $(this).closest('form').data("validator").cancelSubmit = true;
        $(this).closest('form').submit();
        return false;
 });

 $("#todas_acts_evts").click(function(){
 	if($("#todas_acts_evts:checkbox:checked").length > 0)
 		$("#tipo_actividad").hide();
 	else
 		$("#tipo_actividad").show();
 });

$('td.actividad_evento').on('mouseenter',function(){
	var offset = $(this).offset();
	/*guardamos el id del evento en el atributo id_e del div de acciones*/	
	$("#accion").attr("id_e",$(this).attr("id"));
	
	if($(this).attr("estatus")==0)
	{
		/*actividad pendiente de aprobacion*/
		$("#agregar_asistentes").hide();
		$("#eliminar").show();
		$("#modificar").show();
	}	
	else if($(this).attr("estatus")==2)
	{
		/*actividad cancelada*/
		$("#agregar_asistentes").hide();
		$("#eliminar").hide();
	}
	else
	{
		/*actividad aprobada, estatus=1*/
		$("#agregar_asistentes").show();
		$("#eliminar").hide();
		$("#modificar").hide();
	}

	$("#accion").css({width:$(this).width(), height:$(this).height()});
	$("#accion").offset({ top: offset.top, left: offset.left });
	$('#accion').fadeIn();
	$("#accion").css({"z-index":10});
 });

 $("#accion").on('mouseleave',function(){
 	$("#accion").css({"z-index":-9999}); 	
 });

 $("#ver").click(function(){
 	$("#accion").css({"z-index":-9999});
 	doAccion("Ver","AActividad.php");
 });

 $("#modificar").click(function(){
 	$("#accion").css({"z-index":-9999});
 	doAccion("MODIFICAR","FRegistroActividad.php");
 });

 $("#eliminar").click(function(){
  if(confirm("¿Realmente desea eliminar esta actividad?"))
  {
 	$("#accion").css({"z-index":-9999});
 	doAccion("Eliminar","AActividad.php");
 	$("#"+$("#accion").attr("id_e")).parent().remove();
  }
 });

  $("#asistentes_enlistados").on('click','.eliminar',function(e){
  	  e.preventDefault();
	  if(confirm("¿Realmente desea eliminar este asistente?"))
	  {	  	
	  	//p.e. a:?:12 o e:?:14 aprobacion y eliminación	  	
	    var form=$("<form/>").attr({
		    method: "post",
		    action: "FAsistentes.php",
		    target: "_self"
		});		
		form.append($("<input/>").attr({name:"accion",value:$(this).val()}));
		form.append($("<input/>").attr({name:"id_e",value:$("#id_e").val()}));		
		form.append($("<input/>").attr({name:"clave",value:$("#clave").val()}));
		form.submit();
	  }	  
 });

 $("#ficha_actividad").click(function(){
 	$("#accion").css({"z-index":-9999}); 	
 	doAccion("VerFichaActividad","AActividad.php");
 });

  $("#agregar_asistentes").click(function(){
 	$("#accion").css({"z-index":-9999}); 	
 	doAccion("AgregarAsistentes","FAsistentes.php");
 });

  $(".actividades").on('click','.aprobar',function(){
  	$.ajax({
		  type: "POST",
		  url: "FAprobacionActs.php",
		  data: {"id_e":$(this).attr("id"), "accion":"Aprobar"},
		  success: function(result){		  				
		  				location.reload();		  				
		  			},
		  dataType: "html"
	});
  });

  $(".actividades").on('click','.cancelar_aprobacion',function(){
  	if(confirm("¿Está seguro de cancelar esta clave?"))
  	{
	  	$.ajax({
			  type: "POST",
			  url: "FAprobacionActs.php",
			  data: {"id_e":$(this).attr("id"), "accion":"CancelarAprobacion"},
			  success: function(result){		  				
			  				location.reload();
			  			},
			  dataType: "html"
		});
  	}
  });

 function doAccion(laaccion , elformulario){
 	if($("#accion").attr("id_e")!=undefined){
		var form=$("<form/>").attr({
		    method: "post",
		    action: elformulario,
		    target: "_blank"
		});
		form.append($("<input/>").attr({name:"id_e",value:$("#accion").attr("id_e")}));
		form.append($("<input/>").attr({name:"accion",value:laaccion}));		
		form.submit();
	 }
 }

 /*comprobar en FAsistentes el tamaño del documento a adjuntar*/
$("#formulario_asistentes").on('change','input[type=file]',function() {	
  if(this.files[0].size>10485759){
    alert("Archivo demasiado grande:"+Math.round(((this.files[0].size/1024)/1024))+"MB, máximo 10MB");
    $(this).val("");
  }
});

var cont_asistente=0;
   $("#addAsistente").click(function(){

 	try
 	{
 		cont_asistente++;
		$("#det_asistentes").append('<div id="cns_asistente_'+cont_asistente+'" class="doce separadorFila">'+
			'<div class="dos separador">'+
				'<label>'+cont_asistente+'</label>'+
			'</div>'+
			'<div class="tres separador">'+
				'<input type="text" class="form-control" maxlength="60" name="asistente['+cont_asistente+'][nombre]" placeholder="Nombre" required>'+				
			'</div>'+
			'<div class="tres separador">'+
				'<select name="asistente['+cont_asistente+'][categoria]" class="form-control" required>'+
					'<option value="" selected="" disabled="">-- Selecciona --</option>'+
					getCategoriaListaAsistencia()+
				'</select>'+
			'</div>'+			
			'<div class="tres separador">'+
				'<input type="text" class="form-control" maxlength="255" name="asistente['+cont_asistente+'][observaciones]" placeholder="Observaciones">'+
			'</div>'+
				getRemoveButton()+
			'</div>');
	}catch(err){}
  });

   var cont_ponente=0;
   $("#addPonente").click(function(){
 	try
 	{
 		cont_ponente++;
		$("#det_ponentes").append('<div id="cns_ponente_'+cont_ponente+'" class="doce separadorFila">'+
			'<div class="dos separador">'+
				'<label>'+cont_ponente+'</label>'+
			'</div>'+
			'<div class="tres separador">'+
				'<input type="text" class="form-control" maxlength="60" name="ponente['+cont_ponente+'][nombre]" placeholder="Nombre" required>'+
			'</div>'+
			'<div class="tres separador">'+
				'<select name="ponente['+cont_ponente+'][categoria]" class="form-control" required>'+
					'<option value="" selected="" disabled="">-- Selecciona --</option>'+
					getCategoriaListaAsistencia()+
				'</select>'+
			'</div>'+
			'<div class="uno separador form-control">'+
				'<input type="radio" name="ponente['+cont_ponente+'][poi]" value="2" checked> <span title="Ponente" class="separador"> P </span> <input type="radio" name="ponente['+cont_ponente+'][poi]" value="3"> <span title="Instructor"> I </span>'+
			'</div>'+
			'<div class="tres separador">'+
				'<input type="text" class="form-control" maxlength="255" name="ponente['+cont_ponente+'][observaciones]" placeholder="Observaciones">'+
			'</div>'+
				getRemoveButton()+
			'</div>');
	}catch(err){}
	});

   var cont_co=0;
   $("#addComiteOrganizador").click(function(){
 	try
 	{
 		cont_co++;
		$("#det_comite").append('<div id="cns_co_'+cont_co+'" class="doce separadorFila">'+
			'<div class="dos separador">'+
				'<label>'+cont_co+'</label>'+
			'</div>'+
			'<div class="tres separador">'+
				'<input type="text" class="form-control" maxlength="60" name="co['+cont_co+'][nombre]" placeholder="Nombre" required>'+
			'</div>'+
			'<div class="tres separador">'+
				'<select name="co['+cont_co+'][categoria]" class="form-control" required>'+
					'<option value="" selected="" disabled="">-- Selecciona --</option>'+
						getCategoriaListaAsistencia()+
					'</select>'+
			'</div>'+
			'<div class="tres separador">'+
				'<input type="text" class="form-control" maxlength="255" name="co['+cont_co+'][observaciones]" placeholder="Observaciones">'+
			'</div>'+
				getRemoveButton()+
			'</div>');
	}catch(err){}
	});

});