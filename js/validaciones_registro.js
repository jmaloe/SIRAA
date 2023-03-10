$(function(){ 

  jQuery.validator.addMethod(
 	"customFormat", 
 	function(value, element){
        return value.match(/^(0?[1-9]|[12][0-9]|3[0-1])[/., -](0?[1-9]|1[0-2])[/., -](19|20)?\d{2}$/);
    },
    "Ingresa la fecha en formato dd/mm/yyyy"
 );

 $("#RegistroActividades").validate({
 	lang: 'es',
	rules: {
		dependencia: {required: true},
		nombreactividad: {required: true, maxlength:255},
		modalidadCurso: {required:true},
		sede:{required:true},
		persona:{required:true},
		duracion:{required:true, maxlength:10},
		f_apertura:{required:true, maxlength:10, customFormat:true},
		f_cierre:{required:true, maxlength:10, customFormat:true},
		tiempoP_IIP:{required:true,maxlength:10},
		tiempoP_PDDAA:{required:true,maxlength:10},
		areaconocimiento:{required:true, maxlength:255},
		validacion:{required:true, maxlength:50},
		publico:{required:true, maxlength:50},
		f_inicio:{required:true, maxlength:10, customFormat:true},
		f_termino:{required:true, maxlength:10, customFormat:true},
		cupo_minimo:{required:true, number:true, maxlength:4},
		cupo_maximo:{required:true, number:true, maxlength:4},
		cuota_unach:{required:true, number:true, maxlength:12, range:[0,999999999.99]},
		cuota_externos:{required:true, number:true, maxlength:12, range:[0,999999999.99]},
		"req[perfil_ingreso]":{required:true, maxlength:65535},
		"req[perfil_egreso]":{required:true, maxlength:65535},		
		"req[area_academica]":{required:true, maxlength:65535},
		"req[justificacion]":{required:true, maxlength:65535},
		"req[objetivos_curso]":{required:true, maxlength:65535},
		"req[fundamentacion]":{required:true, maxlength:65535},
		"req[objetivo_general]":{required:true, maxlength:65535},
		"req[requisito_ingreso]":{required:true, maxlength:65535},
		"req[requisito_permanencia]":{required:true, maxlength:65535},
		"req[requisito_obt_diploma]":{required:true, maxlength:65535},
		material_didactico:{required:false},
		criterios_evaluacion:{required:true},
		bibliografia:{required:true},
		'tema[][modulo]': {required: true, maxlength:65535},
		'tema[][temas_subtemas]': {required: true, maxlength:65535},
		'tema[][proposito]': {required: true, maxlength:65535},
		'tema[][estrategias]': {required: true, maxlength:65535},
		'tema[][materiales_didacticos]': {required: true, maxlength:65535},
		'tema[][horas_teoricas]': {required: true, number:true, maxlength:3},
		'tema[][horas_practicas]': {required: true, number:true, maxlength:3}
	},
	messages: {
		dependencia: "Selecciona una dependencia v??lida",
		nombreactividad: {required:"El nombre de la actividad es requerido", maxlength:"M??ximo 255 caracteres"},
		modalidadCurso: "Seleccione una modalidad",
		sede: "Es necesario especificar la sede",
		persona: "Selecciona un responsable para la actividad",
		duracion:{required:"Especif??ca la duraci??n", maxlength:"M??ximo 10 caracteres"},
		f_apertura: "Fecha de apertura inv??lida",
		f_cierre: "Fecha de cierre inv??lida",
		tiempoP_IIP: {required:"Campo requerido",maxlength:"M??ximo 10 caracteres"},
		tiempoP_PDDAA: {required:"Campo requerido",maxlength:"M??ximo 10 caracteres"},
		areaconocimiento: {required:"Campo requerido", maxlength:"M??ximo 255 caracteres"},
		validacion: {required:"Campo requerido", maxlength:"M??ximo 50 caracteres"},
		publico: {required:"Campo requerido", maxlength:"M??ximo 50 caracteres"},
		f_inicio: "Fecha de inicio inv??lida",
		f_termino: "Fecha de t??rmino inv??lida",
		cupo_minimo: "Especif??que el m??nimo",
		cupo_maximo: "Especif??que el m??ximo",
		cuota_unach:{required:"Campo requerido", number:"S??lo n??meros", maxlength:"M??ximo 12 caracteres incluyendo 2 decimales", range:"Rango de 0 a 999999999.99"},
		cuota_externos:{required:"Campo requerido", number:"S??lo n??meros", maxlength:"M??ximo 12 caracteres incluyendo 2 decimales", range:"Rango de 0 a 999999999.99"},
		"req[perfil_ingreso]": "Campo requerido",
		"req[perfil_egreso]": "Campo requerido",		
		"req[area_academica]": "Campo requerido",
		"req[justificacion]": "Campo requerido",
		"req[objetivos_curso]":"Campo requerido",
		"req[fundamentacion]": "Campo requerido",
		"req[objetivo_general]": "Campo requerido",
		"req[requisito_ingreso]": "Campo requerido",
		"req[requisito_permanencia]": "Campo requerido",
		"req[requisito_obt_diploma]": "Campo requerido",
		material_didactico:{required:"Campo requerido"},
		criterios_evaluacion:{required:"Criterios requeridos"},
		bibliografia:{required:"Bibliograf??a requerida"},
		'tema[][modulo]': {required: "Especif??ca un nombre al m??dulo", maxlength:"M??ximo 65535 caracteres"},
		'tema[][temas_subtemas]': {required: "Escribe los temas y subtemas", maxlength:"M??ximo 65535 caracteres"},
		'tema[][proposito]': {required: "Indica el prop??sito", maxlength:"M??ximo 65535 caracteres"},
		'tema[][estrategias]': {required: "Escribe las estrategias", maxlength:"M??ximo 65535 caracteres"},
		'tema[][materiales_didacticos]': {required: "Indica el material did??ctico", maxlength:"M??ximo 65535 caracteres"},
		'tema[][horas_teoricas]': {required: "Indica las horas te??ricas", number:"S??lo n??meros", maxlength:"M??ximo 3 caracteres"},
		'tema[][horas_practicas]': {required: "Indica las horas pr??cticas", number:"S??lo n??meros", maxlength:"M??ximo 3 caracteres"}
	},
	tooltip_options: {
		dependencia: {trigger:'focus'}
	},
	focusInvalid: false,
    invalidHandler: function(form, validator) {

        if (!validator.numberOfInvalids())
            return;

        $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
        }, 500);

    }
 });

});