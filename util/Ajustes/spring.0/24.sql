ALTER TABLE Respuesta 
DROP CONSTRAINT FK_Respuesta_Formulario;

ALTER TABLE Respuesta
DROP COLUMN IdFormulario;

-- Agrego la nueva columna
ALTER TABLE Respuesta
ADD IdTarea INT NOT NULL;

ALTER TABLE Respuesta
ADD CONSTRAINT FK_Respuesta_Tarea FOREIGN KEY (IdTarea)  REFERENCES Tareas (IdTarea);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('24.sql', GETDATE ( ), 0, 24);