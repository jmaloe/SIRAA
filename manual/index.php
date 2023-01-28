<?php
session_start();
 if(!isset($_SESSION['USER']))
 	header("Location:../acceso/login.php");
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
	<link rel="stylesheet" href="../css/font-awesome.min.css">
	<link href="../imagenes/favicon.ico" rel="icon" type="image/x-icon">
	<script src="js/modernizr.js"></script> <!-- Modernizr -->
	<script src="js/jquery-2.1.1.js"></script>	
	<script>
	    $( function()
	    {
	        $('img').on("click",function(){
	        	$("<img/>").attr("src", $(this).attr("src"))
						    .load(function() {
						        pic_real_width = this.width;   // Note: $(this).width() will not
						        pic_real_height = this.height; // work for in memory images.
						        if(pic_real_width > $(document).width())
						        	pic_real_width = $(document).width();
						        if(pic_real_height > $(window).height())
						        	pic_real_height = $(window).height();
						        $("#the_image").css("width",pic_real_width);
	        					$("#the_image").css("height",pic_real_height);
	        					$("#the_image").css("margin-top",($(window).height()-pic_real_height)/2);
						    });	        	
	        	$("#the_image").html('<img src="'+$(this).attr("src")+'">');
	        	$("#image_container").fadeIn();
	        });	        
	        $("#image_container").click(function(){
	        	$("#image_container").fadeOut();
	        });
	    });
	</script>
	<title>Manual SIRAA</title>
</head>
<body>
<div id="image_container">
	<div id="the_image">
		<!-- mostrar aqui la imagen -->	
	</div>	
</div>
<header>
	<?php
		$manual = "ManualSIRAA";
		if($_SESSION['rol_usuario']<3)
			$manual = "ManualSIRAAAdm";
		echo '<h1>Manual de usuario <a href="'.$manual.'.pdf" target="_blank"><span style="color:white" title="Descargar"><i class="fa fa-download"></i></span></a></h1>';
	?>
	
</header>
<section class="cd-faq">
	<ul class="cd-faq-categories">
		<li><a class="selected" href="#login"><i class="fa fa-sign-in"></i> Login</a></li>
		<li><a href="#main"><i class="fa fa-home"></i> Principal</a></li>
		<li><a href="#item1"><i class="fa fa-pencil-square-o"></i> Registro de actividad/evento</a></li>
		<li><a href="#item2"><i class="fa fa-cogs"></i> Administración de actividades</a></li>
		<?php
		 if($_SESSION['rol_usuario']<3)
		 {
		?>
		<li><a href="#itema"><i class="fa fa-check-square"></i> Aprobaciones</a></li>
		<li><a href="#item3"><i class="fa fa-users"></i> Usuarios</a></li>
		<li><a href="#item4"><i class="fa fa-lock"></i> Permisos</a></li>
		<li><a href="#item5"><i class="fa fa-shield"></i> Roles y recursos</a></li>
		<li><a href="#item6"><i class="fa fa-bar-chart"></i> Reportes</a></li>
		<?php
		 }
		?>
	</ul> <!-- cd-faq-categories -->

	<div class="cd-faq-items">
		<ul id="login" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Login</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">¿Cómo iniciar sesión en el sistema?</a>
				<div class="cd-faq-content">
					<p>El acceso al sistema es sencillo, únicamente ingrese su nombre de usuario y contraseña los cuales fueron proporcionados previamente por el administrador del sistema y posteriormente dé click en "Entrar". Por su seguridad se recomienda realizar el cambio de contraseña cuando acceda por primera vez. Ingrese como se muestra a continuación.</p>
					<img src="./imagenes/01_login.png" id="imagelightbox"/>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">¿Cómo recuperar la contraseña?</a>
				<div class="cd-faq-content">
					<p>Contacte por email al administrador del sistema.</p>
				</div> <!-- cd-faq-content -->
			</li>			
		</ul> <!-- cd-faq-group -->

		<ul id="main" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Página principal</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Elementos del formulario</a>
				<div class="cd-faq-content">
					<p>Los elementos del sistema con los cuales el usuario puede interactuar se indican a continuación. Es necesario conocer cada uno de los elementos para poder explotar en su totalidad los procesos que el sistema provee.</p>
					<img src="./imagenes/02_main.png"/>
					<blockquote>
						<ul>
							<li><p>(1). <b>Rol del usuario</b>: cambie de rol en dado caso que el administrador le asigne más de un rol. Para cambiar basta seleccionar el rol de la lista desplegable.</p></li>
							<li><p>(2). <b>Ajustar</b>: Realice cambios en sus datos de perfil de usuario tales como el nombre, contraseña, email; así como también ejecute acciones como búsqueda, actualización o eliminación (en caso de tener los permisos necesarios).</p></li>
							<li><p>(3). <b>Salir</b>: le permite cerrar la sesión activa.</p></li>
							<li><p>(4). <b>Actividad/evento académico</b>: seleccione la actividad a registrar de la lista desplegable.</p></li>
							<li><p>(5). <b>Administración actividades</b>: administre las actividades/eventos que registre en el sistema y guarde la lista de asistencia de los participantes del evento.</p></li>
							<li><p>(6). <b>Administración de usuarios y permisos</b>: registre nuevos usuarios en el sistema, asigne roles y gestione el acceso a los recursos (páginas) del sistema.</p></li>
							<li><p>(7). <b>Informes</b>: genere un reporte de los datos que se encuentran en el sistema y visualice la información en forma de gráficas.</p></li>
						</ul>
					</blockquote>
				</div> <!-- cd-faq-content -->
			</li>			
		</ul> <!-- cd-faq-group -->

		<ul id="item1" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Registro de actividades/eventos académicos</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Selección de la actividad/evento</a>
				<div class="cd-faq-content">
					<p>Para iniciar el registro de la actividad/evento seleccione un elemento de la lista desplegable y a continuación dé click en <b>"Comenzar"</b>.</p>
					<img src="./imagenes/03_seleccionactividad.png"/>					
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">Formulario de registro</a>
				<div class="cd-faq-content">
					<p>El formulario de registro de la actividad/evento es de los más importantes del sistema debido a que en base a éste funcionan y operan los demás procesos. Es necesario que al momento de efectuar el llenado se tengan en consideración todos los datos que se solicitan para evitar errores. Lea detenidamente la forma de llenado y los elementos que el sistema provee.</p>
					<img src="./imagenes/04_formularioregistro.png"/>
					<p>Para efecto de aprendizaje se ha dividido en 3 secciones el proceso de llenado del formato, los cuales están disponibles a continuación.</p>
				</div> <!-- cd-faq-content -->
			</li>

			<li>
				<a class="cd-faq-trigger" href="#0">Sección 1: Requisitos estructurales</a>
				<div class="cd-faq-content">			
					<p>Las cajas de texto del formulario que poseen el botón <b>[+]</b> cuentan con un sistema de listas de autocompletado, es decir, al momento de ingresar un texto en estos campos se desplegarán opciones con coincidencias a partir de lo ingresado, para aceptar alguna de las opciones puede realizarlo presionando la tecla de dirección hacia abajo y tabulador o dando click izquierdo sobre alguna opción. Si al escribir y al pasar a otro elemento la caja queda nuevamente vacía será necesario dar click en el botón <b>[+]</b> para agregar un nuevo elemento dependiendo de lo que se esté ingresando.</p>
					<p><b>Dependencia:</b></p>
					<img src="./imagenes/05_seccion1_01.png"/>
					<blockquote>
						<p><b>Nueva dependencia:</b> escriba nombre y dirección en los campos solicitados. En seguida click en <b>"Guardar"</b></p>
					</blockquote>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_02.png"/></p>
					<blockquote>
						<p>Una vez registrada la dependencia el sistema le indica el número de registro, dé click en <b>"Aceptar"</b> para agregar la dependencia al formulario de registro.</p>
					</blockquote>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_03.png"/></p>
					<p><b>Nombre de la actividad:</b> escriba el nombre de la actividad/evento académico</p>
					<img src="./imagenes/05_seccion1_04.png"/>
					<p><b>Modalidad:</b> seleccione una modalidad de la lista desplegable</p>
					<img src="./imagenes/05_seccion1_05.png"/>
					<p><b>Sede:</b> escriba la sede y seleccione de la lista desplegable, o click en [+] para una nueva sede.</p>
					<img src="./imagenes/05_seccion1_06.png"/>
					<blockquote>
						<p><b>Nueva sede:</b> al presionar en el botón [+] se abre el siguiente formulario donde tendrá que ingresar los campos requeridos. Para guardar la sede dé click en <b>"Guardar"</b>.</p>
					</blockquote>					
					<p style="text-align:center"><img src="./imagenes/05_seccion1_07.png"/></p>
					<blockquote>
						<p><b>"Aceptar"</b> para agregar la sede al formulario principal</p>
					</blockquote>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_08.png"/></p>
					<blockquote>
						<p>Si necesita agregar una facultad para especificar la sede, dé click en el botón <b>[+]</b> y realice la acción como se demuestra a continuación.</p>
					</blockquote>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_08a.png"/></p>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_08b.png"/></p>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_08c.png"/></p>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_08d.png"/></p>
					<!-- <p><b>Servicio de salas:</b> si ha seleccionado modalidad presencial o mixto el sistema le muestra esta opción, seleccione una opción de la lista desplegable.</p>
					<img src="./imagenes/05_seccion1_09.png"/> -->
					<p><b>Datos del responsable:</b> si hay registros, se desplegará una lista con el criterio de búsqueda ingresado, click o tabulador para agregar al responsable. En caso de no estar disponible el que se busca debe procederse a dar de alta a la persona en el botón <b>[+]</b>.</p>
					<img src="./imagenes/05_seccion1_10.png"/>
					<blockquote>
						<p><b>Alta de persona:</b> Al dar de alta a una persona en el sistema sus datos estarán disponibles en cualquier parte donde se requiera (formadores, organizadores, coordinadores, etc.).</p>
					</blockquote>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_11.png"/></p>
					<blockquote>
						<p><b>"Aceptar"</b> para agregar la persona como responsable.</p>
					</blockquote>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_12.png"/></p>
					<img src="./imagenes/05_seccion1_13.png"/>
					<p><b>Datos de la actividad/evento:</b> ingrese los datos requeridos <i>(duración, fechas de inicio y término, horarios, programa educativo)</i>. Los campos <i>área de conocimiento, finalidad de validación y público al que va dirigido</i> también tienen opciones de autocompletado, puede seleccionar de la lista o ingresar un concepto nuevo. Los horarios se agregan dando click en el botón [+].</p>
					<img src="./imagenes/05_seccion1_14.png"/>
					<p>Para su comodidad el sistema le provee un elemento de calendario para seleccionar de manera gráfica las fechas de inicio y término de la actividad.</p>
					<img src="./imagenes/05_seccion1_15.png"/>
					<p>En caso de pertenecer la actividad/evento a un programa educativo seleccione SI de la lista desplegable. Posteriormente dé click en <b>[+]</b>.</p>
					<img src="./imagenes/05_seccion1_16.png"/>
					<p>El programa educativo puede agregarlo al formulario principal de 2 maneras, la primera es seleccionando la <i>clasificación</i> del programa y posteriormente seleccionarlo de la lista desplegable como se muestra a continuación. Una vez seleccionado dé click en <b>"Aceptar"</b>.</p>			
					<p style="text-align:center"><img src="./imagenes/05_seccion1_17.png"/></p>
					<p><b>Nota:</b> si los programas son demasiados, puede escribir en la caja de texto para que el sistema filtre la búsqueda y localice eficientemente el programa.</p>
					<p>La otra forma de agregar el programa es dando de alta uno nuevo, luego click en <b>"Guardar"</b> y en seguida click en <b>"Aceptar"</b>.</p>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_18a.png"/></p>
					<p style="text-align:center"><img src="./imagenes/05_seccion1_18b.png"/></p>
					<img src="./imagenes/05_seccion1_19.png"/>
					<p>En seguida corresponde dar de alta a las personas que intervienen en la realización de la actividad/evento, para ello el sistema carga en listas a los coordinadores, responsables de diseño curricular, formadores, etc.</p>
					<img src="./imagenes/05_seccion1_20.png"/>
					<p>Puede ingresar un criterio de búsqueda en cada una de las cajas de texto para filtrar los elementos y posteriormente dar click en alguno de los elementos de la lista, para finalizar basta dar click en el botón de agregar localizado a un costado de la caja de texto en color verde.</p>
					<img src="./imagenes/05_seccion1_21.png"/>					
					<p>Para anexar documentos en cada una de las personas agregadas dé click en "Seleccionar archivo" y en seguida localizar el documento en su computadora, luego click en "Abrir" para adjuntarlo. Para el caso de formadores es necesario seleccionar el tipo (Unach, Ext. nacional, Ext. internacional) y adjuntar el currículum.</p>
					<img src="./imagenes/05_seccion1_22.png"/>
					<p>Ahora finalice el llenado de este primer apartado ingresando las fechas de inicio y termino de difución y captación, así como el cupo y la cuota de inscripción. En seguida dé click en "Siguiente".</p>
					<img src="./imagenes/05_seccion1_23.png"/>
					<p>Continúe con la sección 2.</p>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Sección 2: Perfiles</a>
				<div class="cd-faq-content">
					<p>En el llenado de la sección "Perfiles" debe ingresar el contenido en los campos de texto que el sistema le proporciona, vea la imagen a continuación.</p>
					<img src="./imagenes/05_seccion2_01.png"/>
					<p>Una vez ingresado todos los requisitos en esta sección dé click en "Siguiente" para ir a la 3a. sección correspondiente a "Estructura" o click en "Anterior" para regresar a la 1a. sección.</p>
					<p>Continúe con la sección 3 para finalizar el llenado.</p>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Sección 3: Estructura</a>
				<div class="cd-faq-content">
					<p>Para finalizar con el registro, falta llenar la estructura de la actividad o evento seleccionado y especificar los elementos del material didáctico utilizado. Es necesario adjuntar un archivo en el ejemplar impreso para poder finalizar.</p>
					<img src="./imagenes/05_seccion3_01.png"/>
					<p>Para el llenado de la estructura dé click en <b>"Agregar"</b> y en automático se agregan los elementos de la estructura. Únicamente se solicita redactar el contenido en las cajas de texto como se demuestra a continuación. El número de elementos a agregar es ilimitado.</p>
					<img src="./imagenes/05_seccion3_02.png"/>
					<p>Una vez que se tiene toda la información plasmada en el formulario, continúe dando click en "Enviar", el sistema procederá a registrar su información en la base de datos y posteriormente le mostrará el resumen del registro así como también la clave con la que quedan registrados sus datos.</p>
					<img src="./imagenes/05_seccion3_03a.png"/>
					<img src="./imagenes/05_seccion3_03b.png"/>
					<p>Revise el resumen y compruebe los datos registrados, dé click en "Continuar" para regresar al formulario principal.</p>
				</div> <!-- cd-faq-content -->
			</li>
		</ul> <!-- cd-faq-group -->

		<ul id="item2" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Administración de actividades/eventos académicos y lista de participantes</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Criterios de búsqueda</a>
				<div class="cd-faq-content">
					<p>Para recuperar los registros el sistema provee 3 mecanismos de búsqueda; mediante "clave" la cual fue proporcionada al finalizar el registro, "Nombre o indicio" la cual es una palabra clave y puede ser cualquier texto, "Tipo" nos retornará todos los registros en la categoría seleccionada, "Todos los tipos" devuelve como resultado todos los registros de todos los tipos de actividad/evento dados de alta en el sistema. Para estos dos últimos se tiene que especificar una fecha inicial y final en la que fueron capturados los registros.</p>
					<p><b>Nota:</b> se recomienda dejar holgura en las fechas de mínimo 1 dia, tanto en la inicial como en la final.</p>
					<p>Una vez especificado el criterio dé click en "Buscar".</p>
					<img src="./imagenes/06_criteriodebusqueda1.png"/>
					<p>Resultados de la búsqueda</p>
					<img src="./imagenes/06_resultadobusqueda.png"/>
					<p>Puede dar click en el icono de búsqueda para expandir el elemento e intentar más búsquedas.</p>
					<img src="./imagenes/06_expandible.png"/>

				</div> <!-- cd-faq-content -->
			</li>			
			<li>
				<a class="cd-faq-trigger" href="#0">Acciones a realizar sobre las actividades/eventos</a>
				<div class="cd-faq-content">
					<p>Las acciones que se pueden realizar sobre cualquier actividad son: ver detalle <img src="./imagenes/06_accionverdetalle.png" width="29" height="26">, editar <img src="./imagenes/06_accioneditar.png" width="29" height="25">, eliminar <img src="./imagenes/06_accioneliminar.png" width="27" height="25">, mostrar ficha de actividad <img src="./imagenes/06_accionverficha.png" width="30" height="25"> o agregar la lista de participantes de cada evento <img src="./imagenes/06_accionagregarparticipantes.png" width="33" height="25">. Para mostrar las acciones <b><i>pase el cursor</i></b> sobre el nombre de las actividades.</p>					
					<p><b>Ver detalle:</b> muestra toda la información referente a la actividad.</p>
					<hr/>
					<img src="./imagenes/06_detalleregistro_01.png"/>
					<p>En seguida se muestra el detalle de la actividad.</p>
					<img src="./imagenes/06_detalleregistro_02.png"/>
					<img src="./imagenes/06_detalleregistro_03.png"/>
					<img src="./imagenes/06_detalleregistro_04.png"/>
					<p><b>Modificar:</b> esta acción redirecciona al formulario de registro y carga los datos del evento para su modificación.</p>
					<hr/>
					<img src="./imagenes/06_editarregistro_01.png"/>
					<p>Modificando la actividad.</p>
					<img src="./imagenes/06_editarregistro_02.png"/>
					<p>Al terminar de aplicar los cambios basta con dar click en el botón "Actualizar" y los cambios quedarán aplicados en el sistema. En este proceso debe tenerse la mayor precaución debido a que no hay mecanismo de recuperación de la información.</p>
					<p><i><b>Nota:</b> al no adjuntarse material didáctico el sistema elimina archivos previos.</i></p>
					<img src="./imagenes/06_editarregistro_03.png"/>					
					<p><b>Eliminar:</b> borra del sistema la información completa. Esta opción se encuentra disponible únicamente mientras la actividad no haya sido aprobada.</p>
					<hr/>
					<img src="./imagenes/06_eliminarregistro.png"/>
					<p><b>Ver ficha de actividad:</b> muestra el resumen de la actividad/evento.</p>
					<hr/>
					<img src="./imagenes/06_fichaactividad_01.png"/>
					<p>Resumen.</p>
					<img src="./imagenes/06_fichaactividad_02.png"/>
					<p><b>Agregar participantes del evento:</b> envía al formulario donde se dan de alta los participantes.</p>
					<hr/>
					<img src="./imagenes/06_agregarparticipantes.png"/>
					<p>Para agregar participantes del evento dé click en el botón [+] <i>n</i> veces dependiendo de la cantidad que vaya a registrar en cada uno de los tipos de participantes, posteriormente rellene los campos con la información que se requiere (Nombre, clasificación, tipo, observaciones). Si cuenta con la documentación requerida puede enviarla dando click en "Seleccionar archivo" del apartado "Adjuntar documentación" y en seguida dé click en "Subir". Una vez llenado los campos dé click en el botón "Registrar lista". Vea el ejemplo a continuación.</p>
					<img src="./imagenes/06_agregarparticipante_2.png"/>
					<p>Una vez enviada la lista el sistema muestra los participantes enlistados y en espera de la validación, en la cual se le proporciona al participante una clave o folio. Este proceso de validación lo podrán realizar aquellos usuarios que cuenten con los permisos correspondientes.</p>
					<img src="./imagenes/06_agregarparticipante_3.png"/>
					<p>Si el usuario tiene permisos para validar, la pantalla que verá es como se muestra en seguida.</p>
					<img src="./imagenes/06_agregarparticipante_4.png"/>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Consultar lista de asistentes</a>
				<div class="cd-faq-content">
					<p>Para consultar la lista de asistencia, ingrese al apartado "Administración de actividades y eventos" y dé click en "Lista de asistentes".</p>
					<img src="./imagenes/asistentes.png"/>
					<p>En seguida ingrese cualquier criterio de búsqueda para obtener la lista de asistentes y dé click en "Buscar".</p>
					<img src="./imagenes/asistentes_01.png"/>
					<p>Posteriormente podrá ver los resultados de la búsqueda.</p>
					<img src="./imagenes/asistentes_02.png"/>
					<p>Si desea guardar los resultados de la búsqueda en un documento de Excel dé click en el botón "Exportar a excel".</p>
					<img src="./imagenes/asistentes_03.png"/>
				</div> <!-- cd-faq-content -->
			</li>
		</ul> <!-- cd-faq-group -->
		<?php
			if($_SESSION['rol_usuario']<3)
			{			
		?>
		<ul id="itema" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Aprobación de actividades/eventos y participantes</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Aprobar actividades</a>
				<div class="cd-faq-content">
					<p>Para aprobar una actividad, ingrese al apartado "Administración de actividades y eventos" y dé click en "Actividades/Eventos".</p>
					<img src="./imagenes/aprobacion_01.png"/>
					<p>En seguida ingrese cualquiera de los criterios de búsqueda y dé click en "Buscar".</p>
					<img src="./imagenes/06_criteriodebusqueda1.png"/>
					<img src="./imagenes/aprobacion_02.png"/>
					<p>Identifique la actividad y dé click en "Aprobar"</p>
					<img src="./imagenes/aprobacion_03.png"/>
					<p>O en su defecto, si desea cancelar un registro con clave existente, dé click en "Cancelar".</p>
					<img src="./imagenes/aprobacion_04.png"/>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Aprobar participantes</a>
				<div class="cd-faq-content">
					<p>Para aprobar la lista de asistencia, ingrese al apartado "Administración de actividades y eventos" y dé click en "Actividades/Eventos".</p>
					<img src="./imagenes/aprobacion_01.png"/>
					<p>En seguida ingrese cualquiera de los criterios de búsqueda y dé click en "Buscar".</p>
					<img src="./imagenes/06_criteriodebusqueda1.png"/>
					<img src="./imagenes/aprobacion_02.png"/>
					<p>Identifique la actividad y dé click en "Agregar asistentes"</p>
					<img src="./imagenes/06_agregarparticipantes.png"/>
					<p>A continuación identifique los participantes pendientes de aprobación y dé click en "Aprobar".</p>
					<img src="./imagenes/aprobacion_05.png"/>
					<p>En seguida el sistema genera un folio para el participante asistente del evento.</p>
					<img src="./imagenes/aprobacion_06.png"/>
				</div> <!-- cd-faq-content -->
			</li>			
		</ul> <!-- cd-faq-group -->

		<ul id="item3" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Administración de usuarios</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">¿Cómo agregar nuevo usuario?</a>
				<div class="cd-faq-content">
					<p>Localice el apartado "Administración de usuarios y permisos" y dé click en "Usuarios".</p>
					<img src="./imagenes/usuario_administracion.png"/>
					<p>En seguida ingrese todos los datos requeridos en el formulario, en el campo "adscripción" le aparecerán opciones de la cual puede elegir o por lo contrario redactar manualmente, si éste campo se envía vacío el usuario quedará sin adscripción lo cual tambien se considera como válido. Una vez llenado con los datos correctamente dé click en <b>"Guardar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_alta.png"/></div>
					<div style="width:60%"><img src="./imagenes/usuario_alta2.png"/></div>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Modificación de los datos</a>
				<div class="cd-faq-content">
					<p>Para modificar los datos de un usuario puede realizarlo mediante 3 mecanismos de búsqueda, los cuales se describen a continuación.</p>
					<p><i>1a forma: búsqueda por usuario</i> ingrese únicamente el usuario en "Usuario" y dé click en <b>"Buscar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_busqueda01.png"/></div>
					<p><i>2a forma: búsqueda por nombre</i> escriba un indicio o el nombre del usuario en "Nombre" y dé click en <b>"Buscar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_busqueda02.png"/></div>
					<p><i>3a forma: búsqueda mediante email</i> especifique el email del usuario en "Email" y dé click en <b>"Buscar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_busqueda03.png"/></div>
					<p>En la imagen siguiente se muestra el resultado de la búsqueda mediante cualquiera de los 3 mecanismos de consulta. Los datos que pueden ser modificados son: contraseña, nombre de usuario, correo electrónico (email), adscripción y estatus del usuario (activo). Una vez modificado los datos dé click en "Actualizar".</p>
					<div style="width:60%"><img src="./imagenes/usuario_busqueda04.png"/></div>					
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Eliminación de un usuario</a>
				<div class="cd-faq-content">					
					<p>Mediante un criterio de búsqueda localice el usuario a eliminar, en seguida dé click en "Eliminar". Debe tener total precaución con esta acción debido a que no hay mecanismo de recuperación porque los usuarios se eliminan completamente del sistema.</p>
					<div style="width:60%"><img src="./imagenes/usuario_eliminacion.png"/></div>
				</div> <!-- cd-faq-content -->
			</li>			
		</ul> <!-- cd-faq-group -->

		<ul id="item4" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Permisos de acceso</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Asignar roles a los usuarios</a>
				<div class="cd-faq-content">
					<p>En el sistema pueden haber <i>n</i> número de roles los cuales pueden ser asignados a los usuarios. El acceso a los recursos (páginas) dependerá de los permisos que el rol tenga asignados (lectura, escritura). Al momento de crear un usuario éste no tiene asignado ningún rol, por tal motivo es importante asignarle el rol para que tenga acceso al sistema.</p>
					<p>Localice el apartado "Administración de usuarios y permisos" y dé click en "Permisos".</p>
					<img src="./imagenes/usuario_administracion.png"/>
					<p>En seguida ingrese el dato en cualquiera de los 3 mecanismos de búsqueda (usuario, nomber o email) y dé click en <b>"Buscar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_01.png"/></div>
					<p>Si el usuario existe, el sistema devuelve las opciones para asignación de roles. De los "Roles sin asignar" seleccione de la lista desplegable el que desee asignar al usuario, en seguida dé click en <b>"Asignar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_02.png"/></div>
					<p>Si hubiesen más roles disponibles el sistema le sigue mostrando la lista desplegable, de lo contrario únicamente muestra los "Roles asignados".</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_03.png"/></div>
				</div> <!-- cd-faq-content -->
			</li>			
			<li>
				<a class="cd-faq-trigger" href="#0">Quitar roles a los usuarios</a>
				<div class="cd-faq-content">					
					<p>Una vez encontrado el usuario al que se le desea remover los roles, vaya al apartado "Roles asignados" y de la lista desplegable en "Rol" seleccione el que desea quitar al usuario. En seguida dé click en "Eliminar".</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_04.png"/></div>
					<p>En seguida verá como el rol recién eliminado aparece nuevamente en "Roles sin asignar".</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_05.png"/></div>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Ver permisos del usuario de acuerdo a un rol específico</a>
				<div class="cd-faq-content">					
					<p>Realice la búsqueda del usuario en el formulario, luego seleccione el "Rol" en "Roles asignados" y dé click en "Mostrar".</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_06.png"/></div>
					<p>Los permisos deben aparecen como se demuestra a continuación</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesypermisos_07.png"/></div>
				</div> <!-- cd-faq-content -->
			</li>
		</ul> <!-- cd-faq-group -->

		<ul id="item5" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Roles y recursos</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">Nuevo recurso</a>
				<div class="cd-faq-content">					
					<p>Para efecto de creación de "nuevos recursos" contacte con el área de soporte debido a que se necesitará la programación a nivel de sistema del nuevo recurso. Lea la siguiente sección para la administración de roles.</p>
				</div> <!-- cd-faq-content -->
			</li>
			<li>
				<a class="cd-faq-trigger" href="#0">Nuevo rol</a>
				<div class="cd-faq-content">
					<p>En el formulario de "Roles y recursos" puede agregar nuevos roles, recursos y asignar los permisos del recurso en determinado rol.</p>
					<p>Localice el apartado "Administración de usuarios y permisos" y dé click en "Roles y recursos".</p>
					<img src="./imagenes/usuario_administracion.png"/>
					<p>Para agregar el rol escriba en "Nuevo rol" el nombre del rol que desea crear para los usuarios del sistema. En seguida dé click en <b>"Guardar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesyrecursos_01.png"/></div>
					<p>En seguida ubique el apartado "Permisos" y dé click en la lista desplegable del "Rol", verá que el rol se ha creado correctamente y está casi listo para ser asignado a los usuarios.</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesyrecursos_02.png"/></div>
					<p>Para que el rol sea funcional, ahora proceda a la asignación de los permisos a los recursos. Para ello dé click en "Mostrar permisos" en el rol que haya seleccionado. Se desplegará la lista de recursos como se muestra a continuación.</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesyrecursos_03.png"/></div>
					<p>Como puede ver, los recursos aún no tienen permisos asignados, para asignarlos dé click en cada permisos que le corresponde a los recursos de la ficha. Es decir, si desea que el rol "Invitado" tenga permisos para visualizar el formulario de "Registro de actividades/eventos académicos" dé click en la columna "Leer" y "Escribir". Una vez asignados todos los permisos dé click en <b>"Asignar"</b>.</p>
					<div style="width:60%"><img src="./imagenes/usuario_rolesyrecursos_04.png"/></div>
				</div> <!-- cd-faq-content -->
			</li>			
		</ul> <!-- cd-faq-group -->

		<ul id="item6" class="cd-faq-group">
			<li class="cd-faq-title"><h2>Reportes</h2></li>
			<li>
				<a class="cd-faq-trigger" href="#0">¿Cómo generar los reportes?</a>
				<div class="cd-faq-content">					
					<p>Localice el apartado "Informes" de la página principal y dé click en "ver reporte".</p>
					<img src="./imagenes/informes_administracion.png"/>
					<p>Ahora indique las fecha inicial y final para la obtención del reporte, se sugiere dejar un día de holgura en ambas fechas para un resultado completo, luego dé click en <b>"Generar"</b>.</p>
					<img src="./imagenes/informes_consulta.png"/>
					<p>En seguida el sistema le estará generando 5 tipos de graficas a partir de los datos de la consulta, vea la demostración a continuación.</p>
					<p><i>Gráfica lineal</i></p>
					<img src="./imagenes/informes_grafica1.png"/>
					<p><i>Gráfica de barras</i></p>
					<img src="./imagenes/informes_grafica2.png"/>
					<p><i>Gráfica de radar</i></p>
					<img src="./imagenes/informes_grafica3.png"/>
					<p><i>Gráfica de área polar</i></p>
					<img src="./imagenes/informes_grafica4.png"/>
					<p><i>Gráfica de pastel o circular</i></p>
					<img src="./imagenes/informes_grafica5.png"/>
				</div> <!-- cd-faq-content -->
			</li>
		</ul> <!-- cd-faq-group -->
		<?php
		} //fin comprobación del rol
		?>
	</div> <!-- cd-faq-items -->
	<a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->
<script src="js/jquery-2.1.1.js"></script>
<script src="js/jquery.mobile.custom.min.js"></script>
<script src="js/main.js"></script> <!-- Resource jQuery -->
</body>
</html>