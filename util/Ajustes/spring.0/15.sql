CREATE TABLE PreguntaGeneradora(
	IdPreguntaGeneradora int IDENTITY(1,1),
	IdPregunta int null,
	IdOpcion int null, 
	IdPreguntaGenerada int null,

	CONSTRAINT PK_PreguntaGeneradora PRIMARY KEY (IdPreguntaGeneradora),  
	CONSTRAINT FK_PreguntaGeneradora_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta), 
	CONSTRAINT FK_PreguntaGeneradora_Opcion FOREIGN KEY (IdOpcion) REFERENCES Opcion (IdOpcion), 
	CONSTRAINT FK_PreguntaGeneradora_PregGenerada FOREIGN KEY (IdPreguntaGenerada) REFERENCES Pregunta (IdPregunta), 
);

ALTER TABLE Seccion
ADD Descripcion varchar(1000) null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('15.sql', GETDATE ( ), 0, 15);