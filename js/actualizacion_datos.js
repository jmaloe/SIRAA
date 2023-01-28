$(document).ready(function(){	
	$.get(
		'../formularios/RegUpdater.php',
		{"id_catalogoactividades":$("#id_catalogoactividades").val(), "cnsregactividad":$("#cnsregactividad").val()},
		function(data){
			cargarDatos(data);
		},
		'json'
	);

	function cargarDatos(json_data)
	{			
		if(json_data)
		{
			$.each(json_data,function(k,data){
				if(k=="material_didactico"){
					$.each(data,function(k, v){
						if(k=="numDoc")
						{							
							$(".mate_recu").append(getTagDocumento(v));							
						}else
							$("#"+k).val(v);
					});
				}
				else if(k=="estructura_curso"){
					$.each(data,function(clave, valor){
						var arreglo = [];
						$.each(valor, function(kk,vv){
							arreglo[kk] = vv;
							//ultimo campo y guardamos							
							if(kk=="hrsp")
							{	
								showNewTheme(arreglo);
							}
						});
					});
				}
				else if(k=="requisitos"){
					$.each(data,function(clave, valor){
						$.each(valor,function(k,v){
							$(".requisito").each(function(){						
								if(k===$(this).attr("name")){
									$(this).val(v);
								}
							});	
						});				
					});
				}
				else if(k=="detalle_sesion"){				
					$.each(data,function(clave, valor){					
						var conta=0;
							$.each(valor, function(kk,vv){							
								if(conta==0)
								{
									agregarSesion();
									conta++;
								}
								if(conta==2)
									conta=0;
								$("#"+kk).val(vv);
							});
					});
				}
				else if(k=="coordinador"){
					$.each(data,function(clave, valor){
						var arreglo = [];
						$.each(valor, function(kk,vv){
							arreglo[kk] = vv;
							//ultimo campo y guardamos
							if(kk=="email")
							{	
								showCoordinador(arreglo);
							}
						});
					});
				}
				else if(k=="responsablesCDC"){
					$.each(data,function(clave, valor){
						var arreglo = [];
						$.each(valor, function(kk,vv){
							arreglo[kk] = vv;
							if(kk=="numDoc")
								showResponsableCDC(arreglo);
						});
					});
				}
				else if(k=="formadores"){
					$.each(data,function(clave, valor){
						var arreglo = [];
						$.each(valor, function(kk,vv){
							arreglo[kk] = vv;
							if(kk=="numDoc")
								showFormador(arreglo);
						});
					});
				}
				else
				{
					$.each(data, function(k, v){
						if(k=='tieneProgEduc')
						{
							if(v==1)
								$("#programa_educativo").show();
						}
						/*si el valor es una fecha cambiamos el formato para mostrarlo*/
						if(v!=null)
							if(v.length==10)
								if(Date.parse(v))
								{
									v = $.datepicker.formatDate('dd/mm/yy', new Date(v));
								}
						$("#"+k).val(v);
					});	
				}		
			});
		}
	}
});