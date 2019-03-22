-- Creo nueva tabla de relevamiento
CREATE TABLE Relevamientos(
	IdRelevamiento INT IDENTITY(1,1),
	IdFormulario INT NOT NULL,

	CONSTRAINT PK_Relevamientos PRIMARY KEY (IdRelevamiento),  
	CONSTRAINT FK_Relevamientos_Formulario FOREIGN KEY (IdFormulario) REFERENCES Formulario (IdFormulario)
);

-- Elimino columna y restriccion a formulario
ALTER TABLE Tareas
DROP CONSTRAINT FK_Tareas_Formulario;

ALTER TABLE Tareas
DROP COLUMN IdFormulario;

-- Vacio la tabla para que no haya conflictos
DELETE FROM Tareas;

-- Agrego la nueva columna
ALTER TABLE Tareas
ADD IdRelevamiento INT NOT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Relevamientos FOREIGN KEY (IdRelevamiento)  REFERENCES Relevamientos (IdRelevamiento);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('23.sql', GETDATE ( ), 0, 23);