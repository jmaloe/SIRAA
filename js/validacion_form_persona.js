$(function(){ 

 $("#FormPersona").validate({
 	lang: 'es',
	rules: {
		nombrePersona: {required:true, maxlength:30},
		apepat: {required:true, maxlength:30},
		apemat:{required:true, maxlength:30},
		telefono:{required:true, maxlength:30},
		celular: {required: true, number:true, maxlength:10},
		email: {required: true, maxlength:40}
	},
	messages: {		
		nombrePersona: {required:"Ingrese el nombre", maxlength:"Máximo 30 caracteres"},
		apepat: {required:"Ingrese el apellido paterno", maxlength:"Máximo 30 caracteres"},
		apemat:{required:"Ingrese el apellido materno", maxlength:"Máximo 30 caracteres"},
		telefono:{required:"Dato requerido", maxlength:"Máximo 30 caracteres"},
		celular: {required:"Dato requerido", number:"Sólo números", maxlength:"Máximo 10 caracteres"},
		email: {required:"Dato requerido", maxlength:"Máximo 255 caracteres"}
	},
	tooltip_options:{
		nombrePersona: {trigger:'focus'}
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