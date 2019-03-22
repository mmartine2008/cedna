CREATE TABLE Permiso (
	IdPermiso int not null,
	Descripcion varchar(1000) null, 

	CONSTRAINT PK_Permiso PRIMARY KEY (IdPermiso),   
);

CREATE TABLE Formulario(
	IdFormulario int not null,
	IdPermiso int null,
	Descripcion varchar(1000) null, 

	CONSTRAINT PK_Formulario PRIMARY KEY (IdFormulario),  
	CONSTRAINT FK_Formulario_Permiso FOREIGN KEY (IdPermiso) REFERENCES Permiso (IdPermiso), 
);

CREATE TABLE TipoSeccion (
	IdTipoSeccion int not null,
	Descripcion int not null,

	CONSTRAINT PK_TipoSeccion PRIMARY KEY (IdTipoSeccion),
);  

CREATE TABLE Seccion (
	IdSeccion int not null,
	IdFormulario int null,
	IdTipoSeccion int null,

	CONSTRAINT PK_Seccion PRIMARY KEY (IdSeccion),
	CONSTRAINT FK_Seleccion_Formulario FOREIGN KEY (IdFormulario) REFERENCES Formulario (IdFormulario),  
	CONSTRAINT FK_Seleccion_TipoSeccion FOREIGN KEY (IdTipoSeccion) REFERENCES TipoSeccion (IdTipoSeccion), 
);

CREATE TABLE Pregunta (
	IdPregunta int not null,
	Descripcion varChar(1000) not null,

	CONSTRAINT PK_Pregunta PRIMARY KEY (IdPregunta),
);

CREATE TABLE Opcion (
	IdOpcion int not null,
	Descripcion varchar(1000) not null

	CONSTRAINT PK_Opcion PRIMARY KEY (IdOpcion),
);

CREATE TABLE Respuesta (
	IdRespuesta int not null,
	Descripcion varchar(2000) null,
	IdPregunta int null,
	IdOpcion int null,
	IdPermiso int null,

	CONSTRAINT PK_Respuesta PRIMARY KEY (IdRespuesta),
	CONSTRAINT FK_Respuesta_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_Respuesta_Opcion FOREIGN KEY (IdOpcion) REFERENCES Opcion (IdOpcion), 
	CONSTRAINT FK_Respuesta_Permiso FOREIGN KEY (IdPermiso) REFERENCES Permiso (IdPermiso),
);

CREATE TABLE TipoPregunta (
	IdTipoPregunta int not null,
	Descripcion varChar(1000) not null

	CONSTRAINT PK_TipoPregunta PRIMARY KEY (IdTipoPregunta),
);

CREATE TABLE SeccionPregunta (
	IdSeccionPregunta int not null,
	IdSeccion int not null,
	IdPregunta int not null,

	CONSTRAINT PK_SeccionPregunta PRIMARY KEY (IdSeccion, IdPregunta),
	CONSTRAINT FK_SeccionPregunta_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_SeccionPregunta_Seccion FOREIGN KEY (IdSeccion) REFERENCES Seccion (IdSeccion), 
	CONSTRAINT AK_Seccion_Pregunta UNIQUE(IdSeccion, IdPregunta)  
);

CREATE TABLE PreguntaAbierta (
	IdPreguntaAbierta int not null,
	IdPregunta int not null,
	IdTipoPregunta int null,

	CONSTRAINT PK_PreguntaAbierta PRIMARY KEY (idPreguntaAbierta),
	CONSTRAINT FK_PreguntaAbierta_Pregunta FOREIGN KEY (IdPregunta)  REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_PreguntaAbierta_TipoPregunta FOREIGN KEY (IdTipoPregunta)  REFERENCES TipoPregunta (IdTipoPregunta), 
);

CREATE TABLE PreguntaCerrada (
	IdPreguntaCerrada int not null,
	IdPregunta int not null,
	IdTipoPregunta int null,

	CONSTRAINT PK_PreguntaCerrada PRIMARY KEY (idPreguntaCerrada),
	CONSTRAINT FK_PreguntaCerrada_Pregunta FOREIGN KEY (IdPregunta)  REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_PreguntaCerrada_TipoPregunta FOREIGN KEY (IdTipoPregunta)  REFERENCES TipoPregunta (IdTipoPregunta), 
);

CREATE TABLE PreguntaOpcion (	
	IdPreguntaOpcion int not null,
	IdOpcion int not null,
	IdPreguntaCerrada int not null, 

	CONSTRAINT PK_PreguntaOpcion PRIMARY KEY (idPreguntaOpcion),
	CONSTRAINT AK_Opcion_Pregunta UNIQUE(IdOpcion, IdPreguntaCerrada),
	CONSTRAINT FK_PreguntaOpcion_PreguntaCerrada FOREIGN KEY (IdPreguntaCerrada)  REFERENCES PreguntaCerrada (IdPreguntaCerrada), 
);