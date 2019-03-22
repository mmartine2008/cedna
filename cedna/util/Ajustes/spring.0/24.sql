ALTER TABLE Respuesta 
DROP CONSTRAINT FK_Respuesta_Formulario;

ALTER TABLE Respuesta
DROP COLUMN IdFormulario;

ALTER TABLE Respuesta
ADD IdRelevamiento INT NULL;

ALTER TABLE Respuesta
ADD CONSTRAINT FK_Respuesta_Relevamiento FOREIGN KEY (IdRelevamiento)  REFERENCES Relevamientos (IdRelevamiento);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('24.sql', GETDATE ( ), 0, 24);