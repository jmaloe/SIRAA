/*Autor: Jesus Malo Escobar
 email: dic.malo@gmail.com
 Cel. 9621332427
*/

CREATE DATABASE registroactividades CHARACTER SET utf8 COLLATE utf8_general_ci;
USE registroactividades;

CREATE TABLE adscripcion(
	id_adscripcion INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	descripcion TINYTEXT
)ENGINE=INNODB;

insert into adscripcion(descripcion) values(""); /*para usuarios sin adscripcion*/
update adscripcion set id_adscripcion=0 where id_adscripcion=1;

/*CREACION DE TABLAS PARA EL ACCESO A USUARIOS*/
CREATE TABLE usuarios(
	idUser SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_adscripcion INTEGER UNSIGNED DEFAULT 0,
	user varchar(25) NOT NULL,
	password TINYTEXT NOT NULL,
	email TINYTEXT NOT NULL,
	nombre TINYTEXT NOT NULL,	
	vigente TINYINT(1) DEFAULT 1,
	creado_por SMALLINT UNSIGNED,
	fechaCaptura TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (id_adscripcion) REFERENCES adscripcion(id_adscripcion) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into usuarios(user,password,email,nombre,vigente) values('jesus.malo','c9acd907f21fa81033a64809fd73e991','dic.malo@gmail.com','Jesús Malo Escobar',1);

CREATE TABLE roles(
	idRol SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreRol VARCHAR(25) NOT NULL
)ENGINE=INNODB;

insert into roles(nombreRol) values('Superusuario'),('Administrador'),('Gestor');

CREATE TABLE recursos(
	idRecurso SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreRecurso TINYTEXT NOT NULL	
)ENGINE=INNODB;

insert into recursos(nombreRecurso) values('FRegistroActividad'),('FActividad'),('FDependencia'),('AActividad'),('FAdministracion'),
										  ('FAdminPermisos'),('FAdminRoles'),('FAdminUsuarios'),('FPersona'),('FProgramaEducativo'),
										  ('FReportes'),('FSede'),('FAdminRecursos'),('FFacultad'),('AprobacionActs'),('CancelacionActs'),
										  ('BuscarTodasActs'),('AprobacionAsistentes'),('BuscarAsistentes'),('BuscarTodosAsistentes');

CREATE TABLE permisos_rol(
	idPermiso SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	idRol SMALLINT UNSIGNED NOT NULL,
	idRecurso SMALLINT UNSIGNED NOT NULL,
	lectura TINYINT(1) NOT NULL,
	escritura TINYINT(1) NOT NULL,
	actualizacion TINYINT(1) NOT NULL,
	eliminacion TINYINT(1) NOT NULL,
	FOREIGN KEY (idRol) REFERENCES roles(idRol) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (idRecurso) REFERENCES recursos(idRecurso) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into permisos_rol(idRol,idRecurso,lectura,escritura,actualizacion,eliminacion) values(1,1,1,1,1,1),(1,2,1,1,1,1),(1,3,1,1,1,1),(1,4,1,1,1,1),(1,5,1,1,1,1),
																							(1,6,1,1,1,1),(1,7,1,1,1,1),(1,8,1,1,1,1),(1,9,1,1,1,1),(1,10,1,1,1,1),
																							(1,11,1,1,1,1),(1,12,1,1,1,1),(1,13,1,1,1,1),(1,14,1,1,1,1),(1,15,1,1,1,1),
																							(1,16,1,1,1,1),(1,17,1,1,1,1),(1,18,1,1,1,1),(1,19,1,1,1,1),(1,20,1,1,1,1);

CREATE TABLE rol_del_usuario(
	cns_rol_usuario SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	idRol SMALLINT UNSIGNED,
	idUser SMALLINT UNSIGNED,
	FOREIGN KEY (idRol) REFERENCES roles(idRol) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (idUser) REFERENCES usuarios(idUser) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into rol_del_usuario(idRol,idUser) values(1,1);

CREATE TABLE permisos_globales(
	idPermisoGlobal SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	idRecurso SMALLINT UNSIGNED,
	idUser SMALLINT UNSIGNED,
	lectura TINYINT(1) NOT NULL,
	escritura TINYINT(1) NOT NULL,
	actualizacion TINYINT(1) NOT NULL,
	eliminacion TINYINT(1) NOT NULL,
	FOREIGN KEY (idRecurso) REFERENCES recursos(idRecurso) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (idUser) REFERENCES usuarios(idUser) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

/*TABLAS PARA EL REGISTRO DE ACTIVIDADES*/
CREATE TABLE pais(
	id_pais TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombrePais TINYTEXT
)ENGINE=INNODB;

insert into pais(nombrePais) values("México");

CREATE TABLE estado(
	id_estado SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_pais TINYINT UNSIGNED,
	nombreEstado TINYTEXT,
	FOREIGN KEY (id_pais) REFERENCES pais(id_pais) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into estado(id_pais,nombreEstado) values(1,"Chiapas");

CREATE TABLE ciudad(
	id_ciudad SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_estado SMALLINT UNSIGNED,
	nombreCiudad TINYTEXT,
	FOREIGN KEY (id_estado) REFERENCES estado(id_estado) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into ciudad(id_estado,nombreCiudad) values(1,"Acacoyagua"),
(1,"Acala"),
(1,"Acapetahua"),
(1,"Altamirano"),
(1,"Amatán"),
(1,"Amatenango de la Frontera"),
(1,"Amatenango del Valle"),
(1,"Ángel Albino Corzo"),
(1,"Arriaga"),
(1,"Bejucal de Ocampo"),
(1,"Bella Vista"),
(1,"Berriozábal"),
(1,"Bochil"),
(1,"El Bosque"),
(1,"Cacahoatán"),
(1,"Catazajá"),
(1,"Cintalapa"),
(1,"Coapilla"),
(1,"Comitán de Domínguez"),
(1,"La Concordia"),
(1,"Copainalá"),
(1,"Chalchihuitán"),
(1,"Chamula"),
(1,"Chanal"),
(1,"Chapultenango"),
(1,"Chenalhó"),
(1,"Chiapa de Corzo"),
(1,"Chiapilla"),
(1,"Chicoasén"),
(1,"Chicomuselo"),
(1,"Chilón"),
(1,"Escuintla"),
(1,"Francisco León"),
(1,"Frontera Comalapa"),
(1,"Frontera Hidalgo"),
(1,"La Grandeza"),
(1,"Huehuetán"),
(1,"Huixtán"),
(1,"Huitiupán"),
(1,"Huixtla"),
(1,"La Independencia"),
(1,"Ixhuatán"),
(1,"Ixtacomitán"),
(1,"Ixtapa"),
(1,"Ixtapangajoya"),
(1,"Jiquipilas"),
(1,"Jitotol"),
(1,"Juárez"),
(1,"Larráinzar"),
(1,"La Libertad"),
(1,"Mapastepec"),
(1,"Las Margaritas"),
(1,"Mazapa de Madero"),
(1,"Mazatán"),
(1,"Metapa"),
(1,"Mitontic"),
(1,"Motozintla"),
(1,"Nicolás Ruíz"),
(1,"Ocosingo"),
(1,"Ocotepec"),
(1,"Ocozocoautla de Espinosa"),
(1,"Ostuacán"),
(1,"Osumacinta"),
(1,"Oxchuc"),
(1,"Palenque"),
(1,"Pantelhó"),
(1,"Pantepec"),
(1,"Pichucalco"),
(1,"Pijijiapan"),
(1,"El Porvenir"),
(1,"Villa Comaltitlán"),
(1,"Pueblo Nuevo Solistahuacán"),
(1,"Rayón"),
(1,"Reforma"),
(1,"Las Rosas"),
(1,"Sabanilla"),
(1,"Salto de Agua"),
(1,"San Cristóbal de las Casas"),
(1,"San Fernando"),
(1,"Siltepec"),
(1,"Simojovel"),
(1,"Sitalá"),
(1,"Socoltenango"),
(1,"Solosuchiapa"),
(1,"Soyaló"),
(1,"Suchiapa"),
(1,"Suchiate"),
(1,"Sunuapa"),
(1,"Tapachula"),
(1,"Tapalapa"),
(1,"Tapilula"),
(1,"Tecpatán"),
(1,"Tenejapa"),
(1,"Teopisca"),
(1,"Tila"),
(1,"Tonalá"),
(1,"Totolapa"),
(1,"La Trinitaria"),
(1,"Tumbalá"),
(1,"Tuxtla Gutiérrez"),
(1,"Tuxtla Chico"),
(1,"Tuzantán"),
(1,"Tzimol"),
(1,"Unión Juárez"),
(1,"Venustiano Carranza"),
(1,"Villa Corzo"),
(1,"Villaflores"),
(1,"Yajalón"),
(1,"San Lucas"),
(1,"Zinacantán"),
(1,"San Juan Cancuc"),
(1,"Aldama"),
(1,"Benemérito de las Américas"),
(1,"Maravilla Tenejapa"),
(1,"Marqués de Comillas"),
(1,"Montecristo de Guerrero"),
(1,"San Andrés Duraznal"),
(1,"Santiago el Pinar"),
(1,"Belisario Domínguez"),
(1,"Emiliano Zapata"),
(1,"El Parral"),
(1,"Mezcalapa");

CREATE TABLE universidad(
	id_universidad TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nombreUniversidad TINYTEXT,
	slogan TINYTEXT
)ENGINE=INNODB;

insert into universidad(nombreUniversidad,slogan) values("Universidad Autónoma de Chiapas","Por la Conciencia de la Necesidad de Servir");

CREATE TABLE campus(
	id_campus TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_universidad TINYINT UNSIGNED,
	id_ciudad SMALLINT UNSIGNED,
	nombreCampus VARCHAR(30),
	FOREIGN KEY(id_universidad) REFERENCES universidad(id_universidad) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_ciudad) REFERENCES ciudad(id_ciudad) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into campus(id_universidad,id_ciudad,nombreCAmpus) values
(1,100,"C-I"),
(1,100,"C-II"),
(1,78,"C-III"),
(1,89,"C-IV"),
(1,107,"C-V"),
(1,100,"C-VI"),
(1,68,"C-VII"),
(1,19,"C-VIII"),
(1,96,"C-IX"),
(1,9,"C-IX");

CREATE TABLE facultad(
	id_facultad SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	id_campus TINYINT UNSIGNED,
	nombreFacultad TINYTEXT,
	direccion TINYTEXT,
	FOREIGN KEY(id_campus) REFERENCES campus(id_campus) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into facultad(id_campus,nombreFacultad,direccion) values
(1,"FACULTAD DE CONTADURÍA Y ADMINISTRACIÓN","BOULEVARD BELISARIO DOMINGUEZ KM. 1081, COLINA UNIVERSITARIA S/N C.P. 29050"),
(1,"FACULTAD DE INGENIERIA","BOULEVARD BELISARIO DOMÍNGUEZ, KILÓMETRO 1081, SIN NÚMERO, TERÁN."),
(2,"FACULTAD DE MEDICINA VETERINARIA Y ZOOTECNIA","KM. 8, CARRETERA TERAN, EJIDO EMILIANO ZAPATA C.P. 0"),
(2,"FACULTAD DE MEDICINA HUMANA","CALLE CENTRAL ESQUINA 11ª. SUR S/N, APDO. 575"),
(3,"FACULTAD DE DERECHO","AV. MIGUEL HIDALGO # 8 COLONIA CENTRO C.P. 29200"),
(3,"FACULTAD DE CIENCIAS SOCIALES","CALLE PRESIDENTE OBREGÓN, S/N COLONIA REVOLUCION MEXICANA C.P. 0"),
(4,"FACULTAD DE CONTADURÍA PÚBLICA","CARRETERA A PUERTO MADERO KM. 1.5 COLONIA CENTRO C.P. 30700"),
(4,"FACULTAD DE CIENCIAS DE LA ADMINISTRACION","CARRETERA A PUERTO MADERO KM. 1.5 COLONIA CENTRO C.P. 30700"),
(5,"FACULTAD DE CIENCIAS AGRONÓMICAS","CARRETERA OCOZOCUAUTLA-VILLAFLORES KM. 84.5 C.P. 0"),
(6,"FACULTAD DE HUMANIDADES C-VI","CALLE CANARIOS S/N COLONIA BUENOS AIRES C.P. 29050"),
(7,"ESCUELA DE CONTADURÍA Y ADMINISTRACIÓN","Boulevard Universitario, Libramiento de la Ciudad, Col. Napana, Sin Número"),
(8,"FACULTAD DE CIENCIAS ADMINISTRATIVAS COMITÁN","36 CALLE SUR PONIENTE #50 COLONIA CENTRO C.P. 0"),
(9,"ESCUELA DE CIENCIAS ADMINISTRATIVAS ISTMO-COSTA TONALÁ","CARRETERA TONALÁ PAREDÓN KM. 4+200"),
(10,"ESCUELA DE CIENCIAS ADMINISTRATIVAS ISTMO-COSTA ARRIAGA","CARRETERA ARRIAGA-TAPANATEPEC KM. 1");


CREATE TABLE sede(
	id_sede SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	id_facultad SMALLINT UNSIGNED,
	ubicacion TINYTEXT,
	FOREIGN KEY(id_facultad) REFERENCES facultad(id_facultad) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into sede values(0,1,"NE");

CREATE TABLE dependencia(
	id_dependencia SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_ciudad SMALLINT UNSIGNED,
	nombreDependencia TINYTEXT,
	direccion TINYTEXT,
	FOREIGN KEY(id_ciudad) REFERENCES ciudad(id_ciudad) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE carpeta(
	id_carpeta INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	tag VARCHAR(15) NOT NULL,
	fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP
)ENGINE=INNODB;

insert into carpeta(id_carpeta,tag) values(0,"SIN EXPEDIENTE");

CREATE TABLE tipo_documento(
	id_tipoDocumento SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion TINYTEXT NOT NULL
)ENGINE=INNODB;

insert into tipo_documento(descripcion) values("Currículum Vitae"),("Temario"),("Lista de asistencia");

CREATE TABLE detalle_documentos(
	cns_documento INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_tipoDocumento SMALLINT UNSIGNED NOT NULL,
	id_carpeta INTEGER UNSIGNED,
	  name TINYTEXT NOT NULL,
	  mime VARCHAR(50),
	  size BIGINT UNSIGNED NOT NULL DEFAULT 0,
	  data MEDIUMBLOB NOT NULL,	
	fechaCreacion TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_tipoDocumento) REFERENCES tipo_documento(id_tipoDocumento) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE modalidad(
	id_modalidad TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(20)
)ENGINE=INNODB;

insert into modalidad(descripcion) values("PRESENCIAL"),("VIRTUAL"),("MIXTO");

CREATE TABLE tipo_actividad(
	id_tipoactividad TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(20)
)ENGINE=INNODB;

insert into tipo_actividad(descripcion) values("ACTIVIDAD ACADEMICA"),("EVENTO ACADEMICO");

CREATE TABLE actividad_academica(
	id_actividadAcademica TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_tipoactividad TINYINT UNSIGNED,
	nombreActividad VARCHAR(20),
	descripcion TINYTEXT,
    prefijo VARCHAR(3),
	FOREIGN KEY(id_tipoactividad) REFERENCES tipo_actividad(id_tipoactividad) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into actividad_academica(id_tipoactividad,nombreActividad,descripcion,prefijo) values
(1,"CURSO","Asignatura o disciplina académica que se imparte durante un curso escolar o una parte de él (habitualmente, un trimestre o un semestre).","CU"),
(1,"DIPLOMADO","Son programas de educación no formal o cursos de estudio no conducente a la obtención de títulos ni grados académicos, que tienen como objetivo profundizar y/o actualizar en temas específicos del área de conocimiento.","DIP"),
(1,"TALLER","Es una modalidad de enseñanza-aprendizaje que conjunta la teoría y la práctica, en donde el instructor expone los fundamentos teóricos y procedimentales, que sirven de base para que los alumnos realicen un conjunto de actividades diseñadas previamente.","TA"),
(1,"SEMINARIO","Del latín seminarĭus, es una clase o encuentro didáctico donde un especialista interactúa con los asistentes en trabajos en común para difundir conocimientos o desarrollar investigaciones.","SEM"),
(1,"CERTIFICACION","La certificación es el procedimiento mediante el cual un organismo da una garantía por escrito, de que un producto, un proceso o un servicio está conforme a los requisitos especificados.","CER"),
(1,"CURSO AUTOGESTIVO","Curso","CAG"),
(2,"COLOQUIO","Reunión organizada en que un número limitado de personas debaten y discuten sobre un tema elegido previamente.","COL"),
(2,"CONFERENCIA","Del latín conferentĭa, una conferencia es una disertación en público sobre algún tema concreto.","CNF"),
(2,"CONGRESO","Es una reunión o conferencia, generalmente periódica, donde los miembros de un cuerpo u organismo se reúnen para debatir cuestiones de diversa índole, aunque generalmente con fines políticos.","CNG"),
(2,"CONVENCION","Es un evento de vocación privada, generalmente organizado por una sola empresa. Las convenciones están orientadas a la generación de negocio y lo habitual es que tan solo asistan miembros de la empresa o empresas organizadoras.","CNV"),
(2,"DEBATE","Es un acto de comunicación, el que será más completo y complejo a medida que los argumentos expuestos vayan aumentando en cantidad y en solidez de motivos.","DEB"),
(2,"FORO","Es un lugar físico o virtual que se emplea para reunirse e intercambiar ideas y experiencias sobre diversos temas.","FOR"),
(2,"JORNADA","Se refiere a un periodo de tiempo. Se utiliza como sinónimo de la palabra día. Sin embargo, propiamente dicho jornada se aplica a la actividad laboral.","JOR"),
(2,"PANEL","Es una reunión entre varias personas que hablan sobre un tema específico. Los miembros del panel, que suelen recibir el nombre de «panelistas», exponen su opinión y punto de vista sobre el tema a tratar.","PAN"),
(2,"SIMPOSIO","Es una reunión de expertos en la que se expone y desarrolla un tema en forma completa y detallada, enfocándolo desde diversos ángulos a través de intervenciones individuales, breves, sintéticas y de sucesión continuada.","SIM"),
(2,"VIDEOCONFERENCIA","Es la comunicación simultánea bidireccional de audio y vídeo, que permite mantener reuniones con grupos de personas situadas en lugares alejados entre sí.","VCF"),
(2,"OTRO","Otro","EVE");


CREATE TABLE catalogo_actividades(
	id_catalogoactividades SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_actividadAcademica TINYINT UNSIGNED,
	descripcion TINYTEXT,
	tiene_banner varchar(10) default NULL,
	fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_actividadAcademica) REFERENCES actividad_academica(id_actividadAcademica) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE clasificacion_programas_educativos(
	id_clasifprogseducs TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(30) NOT NULL	
)ENGINE=INNODB;

insert into clasificacion_programas_educativos(descripcion) values("Programa Existente"),("Programa Nuevo"),("Internacional");

CREATE TABLE programa_educativo(
	id_programaEducativo SMALLINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_clasifprogseducs TINYINT UNSIGNED,
	nombrePrograma TINYTEXT NOT NULL,
	FOREIGN KEY(id_clasifprogseducs) REFERENCES clasificacion_programas_educativos(id_clasifprogseducs) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into programa_educativo(id_programaEducativo, id_clasifprogseducs, nombrePrograma) values(0,1,"No especificado");
update programa_educativo set id_programaEducativo=0 where id_programaEducativo=1;

CREATE TABLE area_conocimiento(
	id_areaConocimiento TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion TINYTEXT NOT NULL
)ENGINE=INNODB;

CREATE TABLE validacion_actividad(
	id_tipoValidacion TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(30) NOT NULL
)ENGINE=INNODB;

CREATE TABLE tipo_publico(
	id_tipoPublico TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(30) NOT NULL
)ENGINE=INNODB;

CREATE TABLE temario(
	id_temario INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_carpeta INTEGER UNSIGNED,
	nombreTemario TINYTEXT NOT NULL,	
	criteriosEvaluacion TEXT NOT NULL,
	bibliografia TEXT NOT NULL,
	fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE detalle_temas(
	cns_detalleTemas INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_temario INTEGER UNSIGNED,
	nombreModulo TINYTEXT NOT NULL,
	subtemas TEXT NOT NULL,
	proposito TEXT NOT NULL,
	estrategias_did TEXT NOT NULL,
	materiales_did TEXT NOT NULL,
	Hrs_teoricas TINYINT UNSIGNED NOT NULL,
	Hrs_practicas TINYINT UNSIGNED NOT NULL,
	FOREIGN KEY (id_temario) REFERENCES temario(id_temario) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE Registro_Actividades(
	cns_regActividades INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_catalogoactividades SMALLINT UNSIGNED NOT NULL,
	id_programaEducativo SMALLINT UNSIGNED DEFAULT 0,
	id_areaConocimiento TINYINT UNSIGNED,
	id_temario INTEGER UNSIGNED,
	id_tipoValidacion TINYINT UNSIGNED,
	id_tipoPublico TINYINT UNSIGNED,
	id_sede SMALLINT UNSIGNED,
	id_dependencia SMALLINT UNSIGNED,
	id_modalidad TINYINT UNSIGNED,
	 duracion VARCHAR(10) NOT NULL,	 
	 fecha_inicio DATE NOT NULL,
	 fecha_termino DATE NOT NULL,
	 cupoMinimo SMALLINT UNSIGNED,
	 cupoMaximo SMALLINT UNSIGNED,
	 costoUnach DECIMAL(6,2),
	 costoExternos DECIMAL(6,2),
	 aplico_dnc BOOLEAN NOT NULL,
     clave VARCHAR(15),
	   fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP,
	   fechaAprobacion DATE,
	   fechaCancelacion DATE,
	   usr_elaboro INTEGER UNSIGNED,
	   usr_aprobo INTEGER UNSIGNED DEFAULT 0,
	   usr_cencelo INTEGER UNSIGNED DEFAULT 0,
	FOREIGN KEY(id_catalogoactividades) REFERENCES catalogo_actividades(id_catalogoactividades) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_programaEducativo) REFERENCES programa_educativo(id_programaEducativo) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_areaConocimiento) REFERENCES area_conocimiento(id_areaConocimiento) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_temario) REFERENCES temario(id_temario) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_tipoValidacion) REFERENCES validacion_actividad(id_tipoValidacion) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_tipoPublico) REFERENCES tipo_publico(id_tipoPublico) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_sede) REFERENCES sede(id_sede) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_dependencia) REFERENCES dependencia(id_dependencia) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_modalidad) REFERENCES modalidad(id_modalidad) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE sesiones(
	id_sesion INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	cns_regActividades INTEGER UNSIGNED,
	fechaApertura DATE NOT NULL,
	fechaCierre DATE NOT NULL,
	fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(cns_regActividades) REFERENCES Registro_Actividades(cns_regActividades) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE detalle_sesiones(
	cns_detSesion INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_sesion INTEGER UNSIGNED,
	fechaSesion DATE NOT NULL,
	horaInicial TIME NOT NULL,
	horaFinal TIME NOT NULL,
	FOREIGN KEY(id_sesion) REFERENCES sesiones(id_sesion) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE categoria_requisito(
	id_cat_req INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion TINYTEXT NOT NULL
)ENGINE=INNODB;

insert into categoria_requisito(descripcion) values("Perfiles curriculares"),("Requisitos curriculares"),("Requisitos");

CREATE TABLE tipo_requisito(
	id_tipreq INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_cat_req INTEGER UNSIGNED,
	label TINYTEXT NOT NULL,
	l_class TINYTEXT NOT NULL,
	input TINYTEXT NOT NULL,
	id_input TINYTEXT NOT NULL,
	id_input_class TINYTEXT NOT NULL,
	id_input_placeholder TINYTEXT NOT NULL,
	FOREIGN KEY(id_cat_req) REFERENCES categoria_requisito(id_cat_req) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

insert into tipo_requisito(id_cat_req, label, l_class, input, id_input, id_input_class, id_input_placeholder) values
(1,"Perfil del aspirante:","tres","text","req[perfil_aspirante]","nueve","Escribe aquí"),
(1,"Perfil de egreso:","tres","text","req[perfil_egreso]","nueve","Escribe aquí"),
(1,"Perfil del docente:","tres","text","req[perfil_docente]","nueve","Escribe aquí"),
(2,"Justificación (Indicar por qué se creo):","cuatro","textarea","req[justificacion]","ocho","Redacta la justificación aquí"),
(2,"Objetivo general de la actividad/evento:","cuatro","textarea","req[objetivo_general]","ocho","Redacta el objetivo aquí"),
(2,"Fundamentación, antecedentes, pertinencia y necesidades a las que responde:","cuatro","textarea","req[fundamentacion]","ocho","Redacta la fundamentación aquí"),
(3,"Requisitos de ingreso:","cuatro","textarea","req[requisito_ingreso]","ocho","Escribe aquí"),
(3,"Requisitos de permanencia:","cuatro","textarea","req[requisito_permanencia]","ocho","Escribe aquí"),
(3,"Requisitos para la obtención del diploma:","cuatro","textarea","req[requisito_obt_diploma]","ocho","Escribe aquí");

CREATE TABLE registro_requisitos(
	id_regRequisito INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	cns_regActividades INTEGER UNSIGNED,
	FOREIGN KEY(cns_regActividades) REFERENCES Registro_Actividades(cns_regActividades) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE detalle_registro_requisitos(
	cns_reg_requisitos INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_regRequisito INTEGER UNSIGNED,
	id_tipreq INTEGER UNSIGNED,
	valor TEXT NOT NULL,
	FOREIGN KEY(id_regRequisito) REFERENCES registro_requisitos(id_regRequisito) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_tipreq) REFERENCES tipo_requisito(id_tipreq) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE persona(
	id_persona INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_ciudad SMALLINT UNSIGNED,
	id_carpeta INTEGER UNSIGNED DEFAULT 0,
	nombre VARCHAR(30) NOT NULL,
	apellido_paterno VARCHAR(30) NOT NULL,
	apellido_materno VARCHAR(30) NOT NULL,
	fechaNacimiento DATE,
	direccion TINYTEXT,
	telefono NUMERIC(10,0),
	telCelular NUMERIC(10,0),
	email VARCHAR(40),	
	fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_ciudad) REFERENCES ciudad(id_ciudad) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE tipo_participante(
	id_tipoParticipante TINYINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(25) NOT NULL
)ENGINE=INNODB;

insert into tipo_participante(descripcion) values("UNACH"),("EXT. NACIONAL"),("EXT. INTERNACIONAL");

CREATE TABLE organizador(
	id_organizador INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_persona INTEGER UNSIGNED,
	fechaDeAlta TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_persona) REFERENCES persona(id_persona) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE formador(
	id_formador INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_persona INTEGER UNSIGNED,
	id_carpeta INTEGER UNSIGNED DEFAULT 0,
	id_tipoParticipante TINYINT UNSIGNED,	
	fechaDeAlta TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_persona) REFERENCES persona(id_persona) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_tipoParticipante) REFERENCES tipo_participante(id_tipoParticipante) ON UPDATE CASCADE ON DELETE CASCADE	
)ENGINE=INNODB;

CREATE TABLE coordinador(
	id_coordinador INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_persona INTEGER UNSIGNED,
	id_carpeta INTEGER UNSIGNED DEFAULT 0,
	fechaDeAlta TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_persona) REFERENCES persona(id_persona) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE responsableCDC(
	id_responsable_cdc INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_persona INTEGER UNSIGNED,
	id_carpeta INTEGER UNSIGNED DEFAULT 0,
	fechaDeAlta TIMESTAMP default CURRENT_TIMESTAMP,
	FOREIGN KEY(id_persona) REFERENCES persona(id_persona) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE participantes(
	id_participantes INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	cns_regActividades INTEGER UNSIGNED,
	tag VARCHAR(25),
	FOREIGN KEY(cns_regActividades) REFERENCES Registro_Actividades(cns_regActividades) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE regOrganizadores(
	cns_orgsz INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_organizador INTEGER UNSIGNED,
	id_participantes INTEGER UNSIGNED,
	FOREIGN KEY(id_organizador) REFERENCES organizador(id_organizador) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_participantes) REFERENCES participantes(id_participantes) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE regFormadores(
	cns_formds INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_formador INTEGER UNSIGNED,
	id_participantes INTEGER UNSIGNED,
	FOREIGN KEY(id_formador) REFERENCES formador(id_formador),
	FOREIGN KEY(id_participantes) REFERENCES participantes(id_participantes) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE regCoordinadores(
	cns_coords INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_coordinador INTEGER UNSIGNED,
	id_participantes INTEGER UNSIGNED,
	FOREIGN KEY(id_coordinador) REFERENCES coordinador(id_coordinador) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_participantes) REFERENCES participantes(id_participantes) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE regResponsablesCDC(
	cns_respscdc INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_responsable_cdc INTEGER UNSIGNED,
	id_participantes INTEGER UNSIGNED,
	FOREIGN KEY(id_responsable_cdc) REFERENCES responsableCDC(id_responsable_cdc) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_participantes) REFERENCES participantes(id_participantes) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE tipo_asistente(
	id_tipoasistente TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(50),
	tag VARCHAR(5)
)ENGINE=INNODB;

insert into tipo_asistente(descripcion,tag) values("Asistente","/A"),("Ponente","/P"),("Instructor","/I"),("Comite organizador","/CO");

CREATE TABLE categoria_asistente(
	id_categoria TINYINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	descripcion VARCHAR(50)
)ENGINE=INNODB;

insert into categoria_asistente(descripcion) values("UNACH"),("EXTERNO");

CREATE TABLE lista_asistencia(
	no_lista INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	cns_regActividades INTEGER UNSIGNED,
	id_carpeta INTEGER UNSIGNED,
	FOREIGN KEY(cns_regActividades) REFERENCES Registro_Actividades(cns_regActividades) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_carpeta) REFERENCES carpeta(id_carpeta) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE detalle_lista_asistencia(
	no_registro INTEGER UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
	no_lista INTEGER UNSIGNED,
	id_tipoasistente TINYINT UNSIGNED,
	id_categoria TINYINT UNSIGNED,
	folio VARCHAR(20),
	nombre_asistente VARCHAR(60) NOT NULL,
	observaciones TINYTEXT,
	usr_elaboro INTEGER UNSIGNED,
	fechaCaptura TIMESTAMP default CURRENT_TIMESTAMP,
	usr_valido INTEGER UNSIGNED DEFAULT 0,
	fechaValidacion DATE,	
	FOREIGN KEY(id_tipoasistente) REFERENCES tipo_asistente(id_tipoasistente) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(id_categoria) REFERENCES categoria_asistente(id_categoria) ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY(no_lista) REFERENCES lista_asistencia(no_lista) ON UPDATE CASCADE ON DELETE CASCADE
)ENGINE=INNODB;
