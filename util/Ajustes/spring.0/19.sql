CREATE TABLE EstadoTarea (
    IdEstadoTarea INT IDENTITY(1,1),
    Descripcion VARCHAR(50) NOT NULL,

    CONSTRAINT PK_EstadoTarea PRIMARY KEY (IdEstadoTarea),  
);

INSERT INTO cedna.dbo.EstadoTarea (Descripcion) VALUES  ('Nueva'), ('Solicitada'), 
('Aprobada'), ('En ejecución'), ('Terminada'), ('Cancelada');

CREATE TABLE Tareas(
	IdTarea INT IDENTITY(1,1),
	IdSolicitante INT NOT NULL,
	IdNodo INT NOT NULL, 
	IdEstadoTarea INT NOT NULL,
    FechaSolicitud DATE NOT NULL,
    Descripcion VARCHAR(1000) NOT NULL,
	Resumen VARCHAR(125) NOT NULL,

	CONSTRAINT PK_Tareas PRIMARY KEY (IdTarea),  
	CONSTRAINT FK_Tareas_Usuarios FOREIGN KEY (IdSolicitante) REFERENCES Usuarios (IdUsuario), 
	CONSTRAINT FK_Tareas_Nodos FOREIGN KEY (IdNodo) REFERENCES Nodos (IdNodo), 
	CONSTRAINT FK_Tareas_PregGenerada FOREIGN KEY (IdEstadoTarea) REFERENCES EstadoTarea (IdEstadoTarea), 
);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('19.sql', GETDATE ( ), 0, 19);