ALTER TABLE Pregunta
ADD Funcion varchar(100) null;

ALTER TABLE Respuesta
ADD IdFormulario int null;

ALTER TABLE Respuesta
ADD Destino varchar(100) null;

ALTER TABLE Respuesta
ADD CONSTRAINT FK_Respuesta_Seccion FOREIGN KEY (idSeccion) REFERENCES Seccion (IdSeccion);

ALTER TABLE Respuesta
ADD CONSTRAINT FK_Respuesta_Formulario FOREIGN KEY (idFormulario) REFERENCES Formulario (IdFormulario);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('13.sql', GETDATE ( ), 0, 13);