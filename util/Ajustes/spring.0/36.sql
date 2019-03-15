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

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('36.sql', GETDATE ( ), 0, 36);