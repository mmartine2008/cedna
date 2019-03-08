CREATE TABLE TipoPlanificacion(
	IdTipoPlanificacion INT IDENTITY(1,1),
	Descripcion VARCHAR(100) NOT NULL,

	CONSTRAINT PK_TipoPlanificacion PRIMARY KEY (IdTipoPlanificacion),   
);

CREATE TABLE Planificaciones(
	IdPlanificacion INT IDENTITY(1,1),
    IdTarea INT NOT NULL,
    FechaInicio DATE NOT NULL,
    FechaFin DATE NOT NULL,
    HoraInicio VARCHAR(5) NOT NULL,
    HoraFin VARCHAR(5) NOT NULL,
    Titulo VARCHAR(150) NULL,
	Observaciones VARCHAR(1000) NOT NULL,

	CONSTRAINT PK_Planificaciones PRIMARY KEY (IdPlanificacion),  
	CONSTRAINT FK_Planificaciones_Tareas FOREIGN KEY (IdTarea) REFERENCES Tareas (IdTarea), 
);

SET IDENTITY_INSERT cedna.dbo.TipoPlanificacion ON;

INSERT INTO cedna.dbo.TipoPlanificacion (IdTipoPlanificacion, Descripcion)
VALUES(1, 'Diaria');

INSERT INTO cedna.dbo.TipoPlanificacion (IdTipoPlanificacion, Descripcion)
VALUES(2, 'Por Etapa');

SET IDENTITY_INSERT cedna.dbo.TipoPlanificacion Off;

ALTER TABLE Tareas
ADD IdOrdenDeCompra INT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_OrdenesDeCompra FOREIGN KEY (IdOrdenDeCompra) REFERENCES OrdenesDeCompra (IdOrdenDeCompra);

ALTER TABLE OrdenesDeCompra
DROP CONSTRAINT FK_OrdenesDeCompra_Nodos;

ALTER TABLE OrdenesDeCompra
DROP COLUMN IdNodo;

ALTER TABLE OrdenesDeCompra
DROP CONSTRAINT FK_OrdenesDeCompra_Usuarios_Solicitante;

ALTER TABLE OrdenesDeCompra
DROP COLUMN IdSolicitante;

ALTER TABLE OrdenesDeCompra
DROP CONSTRAINT FK_OrdenesDeCompra_Usuarios_Ejecutor;

ALTER TABLE OrdenesDeCompra
DROP COLUMN IdEjecutor;

ALTER TABLE OrdenesDeCompra
DROP CONSTRAINT FK_OrdenesDeCompra_Usuarios_Responsable;

ALTER TABLE OrdenesDeCompra
DROP COLUMN IdResponsable;

ALTER TABLE OrdenesDeCompra
DROP CONSTRAINT FK_OrdenesDeCompra_Usuarios_PlanificaTarea;

ALTER TABLE OrdenesDeCompra
DROP COLUMN IdPlanificaTarea;

ALTER TABLE Tareas
DROP COLUMN Resumen;

ALTER TABLE Tareas
ADD Resumen VARCHAR(125) NULL;

ALTER TABLE Tareas
ADD IdEjecutor INT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Usuarios_Ejecutor FOREIGN KEY (IdEjecutor) REFERENCES Usuarios (IdUsuario);

ALTER TABLE Tareas
ADD IdResponsable INT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Usuarios_Responsable FOREIGN KEY (IdResponsable) REFERENCES Usuarios (IdUsuario);

ALTER TABLE Tareas
ADD IdPlanificaTarea INT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Usuarios_PlanificaTarea FOREIGN KEY (IdPlanificaTarea) REFERENCES Usuarios (IdUsuario);

ALTER TABLE Tareas
DROP CONSTRAINT FK_Tareas_Relevamientos;

ALTER TABLE Tareas
DROP COLUMN IdRelevamiento;

ALTER TABLE Tareas
ADD IdRelevamiento INT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Relevamientos FOREIGN KEY (IdRelevamiento)  REFERENCES Relevamientos (IdRelevamiento);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('28.sql', GETDATE ( ), 0, 28);