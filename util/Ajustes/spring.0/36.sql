CREATE TABLE EstadosRelevamiento(
	IdEstadoRelevamiento INT IDENTITY(1,1),
	Descripcion VARCHAR(100) NOT NULL,

	CONSTRAINT PK_EstadosRelevamiento PRIMARY KEY (IdEstadoRelevamiento)
);

SET IDENTITY_INSERT cedna.dbo.EstadosRelevamiento ON;

INSERT INTO cedna.dbo.EstadosRelevamiento (IdEstadoRelevamiento, Descripcion)
VALUES(1, 'Para Editar');

INSERT INTO cedna.dbo.EstadosRelevamiento (IdEstadoRelevamiento, Descripcion)
VALUES(2, 'Editado');

INSERT INTO cedna.dbo.EstadosRelevamiento (IdEstadoRelevamiento, Descripcion)
VALUES(3, 'Completo');

INSERT INTO cedna.dbo.EstadosRelevamiento (IdEstadoRelevamiento, Descripcion)
VALUES(4, 'Finalizado');

SET IDENTITY_INSERT cedna.dbo.EstadosRelevamiento OFF;

ALTER TABLE Relevamientos
ADD IdEstadoRelevamiento INT NULL;

ALTER TABLE Relevamientos
ADD CONSTRAINT FK_Relevamientos_EstadosRelevamientos FOREIGN KEY (IdEstadoRelevamiento) REFERENCES EstadosRelevamiento (IdEstadoRelevamiento);

UPDATE Relevamientos
SET IdEstadoRelevamiento = 1;

SET IDENTITY_INSERT cedna.dbo.Nodos ON;

--INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
--VALUES(1, 2, 'Planta Principal FEMSA', NULL);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(4, 2, 'Administración', 1);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(5, 2, 'Producción', 1);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(6, 3, 'Logística', 1);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(7, 2, 'Recursos Humanos', 1);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(8, 2, 'Contabilidad', 4);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(9, 3, 'Personal', 4);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(10, 2, 'Ventas', 5);

INSERT INTO cedna.dbo.Nodos (IdNodo, IdTipoNodo, Nombre, IdNodoSuperior)
VALUES(11, 3, 'Distribución', 5);

SET IDENTITY_INSERT cedna.dbo.Nodos OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('36.sql', GETDATE ( ), 0, 36);