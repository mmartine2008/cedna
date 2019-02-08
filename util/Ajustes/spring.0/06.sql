DROP TABLE PreguntaOpcion;
DROP TABLE SeccionPregunta;
DROP TABLE Respuesta;
DROP TABLE Opcion;
DROP TABLE Pregunta;
DROP TABLE TipoPregunta;
DROP TABLE Seccion;
DROP TABLE TipoSeccion;
DROP TABLE Formulario;
DROP TABLE Permiso;

CREATE TABLE Permiso (
	IdPermiso INT IDENTITY(1,1),
	Descripcion varchar(1000) null, 

	CONSTRAINT PK_Permiso PRIMARY KEY (IdPermiso),   
);

CREATE TABLE Formulario(
	IdFormulario INT IDENTITY(1,1),
	IdPermiso int null,
	Descripcion varchar(1000) null, 

	CONSTRAINT PK_Formulario PRIMARY KEY (IdFormulario),  
	CONSTRAINT FK_Formulario_Permiso FOREIGN KEY (IdPermiso) REFERENCES Permiso (IdPermiso), 
);

CREATE TABLE TipoSeccion (
	IdTipoSeccion INT IDENTITY(1,1),
	Descripcion int not null,

	CONSTRAINT PK_TipoSeccion PRIMARY KEY (IdTipoSeccion),
);  

CREATE TABLE Seccion (
	IdSeccion INT IDENTITY(1,1),
	IdFormulario int null,
	IdTipoSeccion int null,

	CONSTRAINT PK_Seccion PRIMARY KEY (IdSeccion),
	CONSTRAINT FK_Seleccion_Formulario FOREIGN KEY (IdFormulario) REFERENCES Formulario (IdFormulario),  
	CONSTRAINT FK_Seleccion_TipoSeccion FOREIGN KEY (IdTipoSeccion) REFERENCES TipoSeccion (IdTipoSeccion), 
);

CREATE TABLE TipoPregunta (
	IdTipoPregunta INT IDENTITY(1,1),
	Descripcion varChar(1000) not null

	CONSTRAINT PK_TipoPregunta PRIMARY KEY (IdTipoPregunta),
);

CREATE TABLE Pregunta (
	IdPregunta INT IDENTITY(1,1),
	Descripcion varChar(1000) not null,
	IdTipoPregunta int not null,
	Opciones int not null,

	CONSTRAINT PK_Pregunta PRIMARY KEY (IdPregunta),
	CONSTRAINT FK_Pregunta_TipoPregunta FOREIGN KEY (IdTipoPregunta) REFERENCES TipoPregunta (IdTipoPregunta)
);

CREATE TABLE Opcion (
	IdOpcion INT IDENTITY(1,1),
	Descripcion varchar(1000) not null

	CONSTRAINT PK_Opcion PRIMARY KEY (IdOpcion),
);

CREATE TABLE Respuesta (
	IdRespuesta INT IDENTITY(1,1),
	Descripcion varchar(2000) null,
	IdPregunta int null,
	IdOpcion int null,
	IdPermiso int null,

	CONSTRAINT PK_Respuesta PRIMARY KEY (IdRespuesta),
	CONSTRAINT FK_Respuesta_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_Respuesta_Opcion FOREIGN KEY (IdOpcion) REFERENCES Opcion (IdOpcion), 
	CONSTRAINT FK_Respuesta_Permiso FOREIGN KEY (IdPermiso) REFERENCES Permiso (IdPermiso),
);

CREATE TABLE SeccionPregunta (
	IdSeccionPregunta INT IDENTITY(1,1),
	IdSeccion int not null,
	IdPregunta int not null,

	CONSTRAINT PK_SeccionPregunta PRIMARY KEY (IdSeccionPregunta),
	CONSTRAINT FK_SeccionPregunta_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_SeccionPregunta_Seccion FOREIGN KEY (IdSeccion) REFERENCES Seccion (IdSeccion), 
	CONSTRAINT AK_Seccion_Pregunta UNIQUE(IdSeccion, IdPregunta)  
);

CREATE TABLE PreguntaOpcion (	
	IdPreguntaOpcion INT IDENTITY(1,1),
	IdOpcion int not null,
	IdPregunta int not null,

	CONSTRAINT PK_PreguntaOpcion PRIMARY KEY (IdPreguntaOpcion),
	CONSTRAINT FK_PreguntaOpcion_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta)
);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('06.sql', GETDATE ( ), 0, 6);