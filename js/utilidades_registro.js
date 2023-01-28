$(".btn_guardar_actividad").on("click",function(){
	$(this).addClass("disabled");
});
//si la actividad es Curso Autogestivo desactivar el bloque de duración
if($("#id_tipo_actividad").val()==16){
	$("#duracion").val("0");
	var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    if(dd<10)
        dd='0'+dd    
    if(mm<10)
        mm='0'+mm    
	$("#f_apertura").val(dd+'/'+mm+'/'+yyyy);
	$("#f_cierre").val(dd+'/'+mm+'/'+yyyy);
	$("#duracion_evento").hide();	
}

/*Evento para controlar los tabs*/
$(".goTab").click(function(event) {
	if($("#RegistroActividades").valid()){
	    event.preventDefault();
	    $('.tabs-menu li.current').removeClass('current');
	    $("#tab"+$(this).attr("value")).addClass("current");    
	    var tab = $(this).attr("href");
	    $(".tab-content").not(tab).css("display", "none");
	    $(tab).fadeIn();
   }
});

/*AGREGAR sesion*/
$("#addSession").click(function(){
  agregarSesion();
});

$("#det_coordinador").on('click','.quitarElemento',function(){
	contCoords--;
});

$(".caja-elementos").on('click','.quitarTema',function(){
	$(this).parent().parent().remove();
});

/*borrar contenido del input en formadores, coordinaroes, responsablesCDC*/
$(".btn-success").click(function(){
	setTimeout(function(){$(".inputlist").val("")},200);
});

/*AGREGAR formador*/
$("#nuevoFormador").click(function(){
	if($("#formador").val()!="" & getDataListIdValue("#formador","#formadores")>0){
		showFormador({id_:getDataListIdValue("#formador","#formadores"), nombre:$("#formador").val(), tipo:getDataListValue("#formador","#formadores","t_p"), isFormador:1, numDoc:getDataListValue("#formador","#formadores","doc")});		    		
	}
});

$("#nuevoCoordinador").click(function(){
	if($("#coordinador").val()!="" & getDataListIdValue("#coordinador","#coordinadores")>0){
		showCoordinador({id_:getDataListIdValue("#coordinador","#coordinadores"), nombre:$("#coordinador").val(), isCoordinador:1, telefono:getDataListValue("#coordinador","#coordinadores","telefono"), celular:getDataListValue("#coordinador","#coordinadores","celular"), email:getDataListValue("#coordinador","#coordinadores","email")});
	}
});
/*AGREGAR responsableCDC*/
$("#nuevoResponsableCDC").click(function(){	
	if($("#responsableCDC").val()!=""){
		showResponsableCDC({id_:$("#responsableCDCX_id").val(), nombre:$("#responsableCDC").val(), isResponsable:1,numDoc:getDataListValue("#responsableCDC","#responsablesCDC","doc")});
	}
});

/*Agrega nuevos elementos en la estructura de los temas*/
$("#nuevoTema").click(function(){
	showNewTheme(null);
});

/*comprobamos el tamaño de los archivos que se envíen*/
$("#RegistroActividades").on('change','input[type=file]',function() {
  if(this.files[0].size>16777215){
    alert("Archivo demasiado grande:"+Math.round(((this.files[0].size/1024)/1024))+"MB, máximo 16MB");
    $(this).val("");
  }
});

/*Al cambiar el valor del input con la clase modulo se cambia el valor de h3 para identificarlo mejor*/
$("#temario").on('change','.modulo',function(){
	$("#tema"+$(this).attr("numtema")+" h3").text($(this).val());
	$("#tema"+$(this).attr("numtema")+" h3").append(getRemoveButton());
});

$("#agregarCoordinador").click(function(){
	$("#addCoordinador").show();		    	
});

$("#agregarFormador").click(function(){
	$("#addFormador").show();		    	
});

$("#agregarResponsableCDC").click(function(){
	$("#addResponsableCDC").show();		    	
});

$("#agregarDependencia").click(function(){
	$("#addDependencia").show();
});

$("#agregarPersona").click(function(){
	$("#addPersona").show();
});

$("#agregarPrograma").click(function(){
	$("#addPrograma").show();
});

$("#agregarSede").click(function(){
	$("#addSede").show();
});

/*Evaluamos si el evento pertenece a algun programa educativo*/
$("#tieneProgEduc").click(function(){
  if($("#tieneProgEduc").val()==1)
	$("#programa_educativo").show();		    	
  else
    $("#programa_educativo").hide();
});

$("#modalidadCurso").click(function(){
	//verificamos si ha seleccionado virtual
	if($("#modalidadCurso").val()==2)
		$("#sede_curso").hide();
	else
		$("#sede_curso").show();
});

$("#dependencia").on('change',function(){
	var id = getDataListIdValue("#dependencia","#dependencias");
	if(id > 0)
		$("#id_dependencia").val(id);
	else
		$("#dependencia").val("");
});

$("#sede").on('change',function(){
	var id = getDataListIdValue("#sede","#sedes");
	if(id > 0)
		$("#id_sede").val(id);
	else
		$("#sede").val("");
});

//por cada keypressed revisa si es actividad del catalogo
$("#nombreactividad").bind('input',function(){	
	var id = getDataListIdValue("#nombreactividad","#catalogoactividades");
	$("#id_actividad").val(id);	
	if($("#id_actividad").val()>0)
	{
		if(confirm("¿Desea clonar esta actividad/evento?"))
		{
			var form=$("<form/>").attr({
			    method: "post",
			    action: "FRegistroActividad.php"
			});
				form.append($("<input/>").attr({name:"accion",value:'Buscar'}));
				form.append($("<input/>").attr({name:"id_catalogoactividades",value:$("#id_actividad").val()}));		
				form.submit();
		}
	}
});

$("#areaconocimiento").bind('input',function(){
	$("#id_areaconocimiento").val(getDataListIdValue("#areaconocimiento","#areasconocimiento"));
});

$("#validacion").bind('input',function(){
	$("#id_validacion").val(getDataListIdValue("#validacion","#validaciones"));
});

$("#publico").bind('input',function(){
	$("#id_tipopublico").val(getDataListIdValue("#publico","#tipospublico"));
});

$("#responsableCDC").on('change',function(){
	var id = getDataListIdValue("#responsableCDC","#responsablesCDC");
	if(id > 0)
		$("#responsableCDCX_id").val(id);
	else
		$("#responsableCDC").val("");
});

$("#persona").on('change',function(){
	if(getDataListIdValue("#persona","#organizadores")>0)
		showOrganizador({telefono:getDataListValue("#persona","#organizadores","tel"),celular:getDataListValue("#persona","#organizadores","cel"),email:getDataListValue("#persona","#organizadores","email"),id_:getDataListIdValue("#persona","#organizadores")});
	else{
		showOrganizador({telefono:"",celular:"",email:"",id_:0});
		$("#persona").val("");
	}
});

$("#persona").bind('input',function(){
	if(getDataListIdValue("#persona","#organizadores")>0)
		showOrganizador({telefono:getDataListValue("#persona","#organizadores","tel"),celular:getDataListValue("#persona","#organizadores","cel"),email:getDataListValue("#persona","#organizadores","email"),id_:getDataListIdValue("#persona","#organizadores")});
});

$("#modalidadCurso").on('change',function(){
	if($(this).val()==2){
		$("#anexar_ejemplar").hide();
	}
	else
		$("#anexar_ejemplar").show();
});

var fecha_apertura=0, fecha_cierre=0, fecha_inicio=0;
try
{
	/*Asignamos datepicker al campo con la fecha de apertura*/
	$( "#f_apertura" ).datepicker();	
	$( "#f_inicio" ).datepicker();
}
catch(err){
  //console.log(err);
}
	/*Calculamos la fecha de apertura para que apartir de eso el minDate en f_cierre sea a partir de esta*/
	$("#f_apertura").change(function(){
		fecha_apertura = $(this).val();
	});

	$("#f_inicio").change(function(){
		fecha_inicio = $(this).val();		
	});	

	/*Calculamos la fecha de cierre para restringir minDate y maxDate en las sesiones*/
	$("#f_cierre").change(function(){		
		fecha_cierre = $(this).val();		
	});	

	/*Asignamos datepicker a la fecha de cierre y pasamos el minDate a partir de la f_apertura*/
	$("#fecha_cierre").on('focus', '.datepicker', function(e){
		try
		{
		 	e.preventDefault();
			var element = e.currentTarget;
			$(element).datepicker('destroy');
			$(element).datepicker({minDate:fecha_apertura});
		}
		catch(err)
		{

		}
	});

	$("#fecha_termino").on('focus', '.datepicker', function(e){
		try
		{
		 	e.preventDefault();
			var element = e.currentTarget;
			$(element).datepicker('destroy');
			$(element).datepicker({minDate:fecha_inicio});
		}catch(err){}
	});

	/*A los elementos del div det_sesion con la clase .datepicker le asignamos el datepicker dinámicamente*/
	$("#det_sesion").on('focus', '.datepicker', function(e){
		try
		{
		 	e.preventDefault();
			var element = e.currentTarget;
			$(element).datepicker('destroy');
			$(element).datepicker({minDate:fecha_apertura, maxDate:fecha_cierre});  						
		}
		catch(err)
		{

		}
	});

	/*A los elementos del div det_sesion con la clase .timepicker le asignamos el timepicker para elegir horario*/
	$("#det_sesion").on('focus', '.timepicker', function(e){
		e.preventDefault();
		var element = e.currentTarget;
		$(element).timepicker({showPeriod: true, showLeadingZero: false });
	});	

   var contTemas=-1;
function showNewTheme(data){
	contTemas++;
	$("#acordeon ul ul").slideUp(); /*ocultamos todos los elementos del acordeon*/
	var nombre_tema = "Parte "+(contTemas+1);
	if(data)
		nombre_tema = data.modulo;
	$("#temario").append('<li class="active" id="tema'+contTemas+'"><h3>'+nombre_tema+getRemoveButton()+'</h3>'+
			'<ul class="form-group"><li><textarea name="tema[][modulo]" id="tema_'+contTemas+'" numTema="'+contTemas+'" class="form-control item-tema modulo" placeholder="Módulo" rows="1" required title="Módulo"></textarea></li>'+
			'<li><textarea name="tema[][temas_subtemas]" id="subtema_'+contTemas+'" class="form-control item-tema" placeholder="temas y subtemas" rows="5" required title="Temas y subtemas"></textarea></li>'+
			'<li><textarea name="tema[][proposito]" id="proposito_'+contTemas+'" class="form-control item-tema" placeholder="objetivo/propósito" required title="Objetivo/propósito"></textarea></li>'+
			'<li><textarea name="tema[][estrategias]" id="estrategias_'+contTemas+'" class="form-control item-tema" placeholder="estrategias" required title="Estrategias"></textarea></li>'+
			'<li><textarea name="tema[][materiales_didacticos]" id="matsdids_'+contTemas+'" class="form-control item-tema" placeholder="materiales" required title="Materiales"></textarea></li>'+
			'<li><input type="text" name="tema[][horas_teoricas]" id="hrst_'+contTemas+'" class="form-control item-tema" placeholder="horas teóricas" required title="Horas teóricas"/></li>'+
			'<li><input type="text" name="tema[][horas_practicas]" id="hrsp_'+contTemas+'" class="form-control item-tema" placeholder="horas prácticas" required title="Horas prácticas"/></li>'+
			'</ul>'+
			'</li>');
	//si hay datos asignamos los valores a los inputs
	if(data){
		$("#tema_"+contTemas).val(data.modulo);
		$("#subtema_"+contTemas).val(data.subtema);
		$("#proposito_"+contTemas).val(data.proposito);
		$("#estrategias_"+contTemas).val(data.estrategias);
		$("#matsdids_"+contTemas).val(data.materiales);
		$("#hrst_"+contTemas).val(data.hrst);
		$("#hrsp_"+contTemas).val(data.hrsp);
	}
}

/*Muestra la dependencia seleccionada desde el iframe FDependencia en el formulario principal*/
function showDependencia(data){
	$("#id_dependencia").val(data.id_);
	$("#dependencia").val(data.nombre);
}

/*Muestra los datos del organizador en el formulario principal*/
function showOrganizador(data){
	if(data.nombre)
	$("#persona").val(data.nombre);
	$("#_telefono").val(data.telefono);
	$("#_celular").val(data.celular);
	$("#_correo").val(data.email);
	$("#id_responsable").val(data.id_);
}

/*Agrega un nuevo formador*/
var contFormadores=-1;
function showFormador(data){
	if($("#det_formadores > div > label:contains('"+data.nombre+"')").length > 0)
	{
		alert("Este formador ya se encuentra en la lista: "+data.nombre);
		return;
	}
	
	contFormadores++;
	var documento = getTagDocumento(data.numDoc);
	var required="required";
	if(documento)
		required="";
	id_tipo = data.tipo!=0 ? data.tipo : "";	
	var tipo_formador = $("#tipo_formador").clone(false);
	if(id_tipo!="")
		$(tipo_formador).find('option[value='+id_tipo+']').attr('selected','selected');

	$("#det_formadores").append('<div id="cns_formador_'+contFormadores+'" class="separadorFila">'+		
		'<input type="hidden" name="formador[][id]" value="'+data.id_+'"/>'+
		'<label class="tres">'+data.nombre+'</label>'+
		'<div class="separador tres">'+
			'<select name="formador[][tipo]" class="form-control" required>'+$(tipo_formador).html()+'</select>'+
		'</div>'+
		'<div class="separador cinco">'+
			documento+'<input type="file" accept=".pdf, .doc, .docx, .zip, .rar" name="formador[]" class="form-control" '+required+'/>'+
		'</div>'+
			getRemoveButton()+
		'</div>');
}

var contCoords=-1;
function showCoordinador(data){
	if(contCoords==0){
		alert("Ya se agregó el coordinador");
	 return;
	}
	contCoords++;	
	var documento = getTagDocumento(data.numDoc);
	
	$("#det_coordinador").append('<div id="cns_coordinador_'+contCoords+'" class="separadorFila">'+		
									'<input type="hidden" name="coordinador[][id]" value="'+data.id_+'"/>'+
									'<label class="cuatro">'+data.nombre+'</label>'+									
									'<label class="dos">'+data.telefono+'</label>'+
									'<label class="dos">'+data.celular+'</label>'+
									'<label class="tres">'+data.email+'</label>'+
										getRemoveButton()+
								'</div>');
}

/*Agrega un nuevo responsable de la CDC*/
var contRespDC=-1;
function showResponsableCDC(data){
	if($("#det_responsablesCDC > div > label:contains('"+data.nombre+"')").length > 0)
	{
		alert("Este responsable CDC ya se encuentra en la lista: "+data.nombre);
		return;
	}
	contRespDC++;
	var documento = getTagDocumento(data.numDoc);
	var required="required";
	if(documento)
		required="";

	$("#det_responsablesCDC").append('<div id="cns_responsableCDC_'+contRespDC+'" class="separadorFila">'+
		'<input type="hidden" name="responsableCDC[][id]" value="'+data.id_+'"/>'+
			'<label class="seis">'+data.nombre+'</label>'+
		'<div class="separador"></div>'+
		'<div class="separador cinco">'+
			documento+'<input type="file" accept=".pdf, .doc, .docx, .zip, .rar" name="responsableCDC[]" class="form-control" '+required+'/>'+
		'</div>'+
			getRemoveButton()+
		'</div>');
}

function showPrograma(data){
	$("#programaEducativo").val(data.programa);
	$("#id_programa").val(data.id_);		    	
}

function showSede(data){
	$("#id_sede").val(data.id_sede);
	$("#sede").val(data.nombreSede);
}

var contSesiones=-1;
function agregarSesion(){
 try
 {
    if($("#f_apertura").val()=="" | $("#f_cierre").val()=="")
	{
	  alert("¡Es necesario agregar las fechas de inicio y termino del evento!");
	    return;
	}
	contSesiones++;
	$("#det_sesion").append('<div id="cns_sesion_'+contSesiones+'" class="doce separadorFila">'+
		'<div class="separador cuatro">'+
			'<input type="text" class="datepicker form-control" name="sesion['+contSesiones+'][fecha]" id="dateses_'+contSesiones+'" placeholder="dd-mm-aaaa" required>'+
		'</div>'+
		'<div class="separador cuatro">'+
			'<input type="text" class="timepicker form-control" size="10" name="sesion['+contSesiones+'][hi]" id="timeses_hi_'+contSesiones+'" placeholder="hh:mm" required>'+
		'</div>'+
		'<div class="separador cuatro">'+
			'<input type="text" class="timepicker form-control" size="10" name="sesion['+contSesiones+'][hf]" id="timeses_hf_'+contSesiones+'" placeholder="hh:mm" required>'+
		'</div>'+
			getRemoveButton()+
		'</div>');
	$("#dateses_"+contSesiones).val(sumaFecha(contSesiones,$("#f_apertura").val()));
	//console.log(sumaFecha(contSesiones,$("#f_apertura").val()));
 }catch(err){console.log(err)}
}