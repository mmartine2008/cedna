ALTER TABLE Tareas
ADD IdFormulario INT NOT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Formulario FOREIGN KEY (IdFormulario)  REFERENCES Formulario (IdFormulario);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('20.sql', GETDATE ( ), 0, 20);