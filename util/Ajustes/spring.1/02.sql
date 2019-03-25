CREATE TABLE dbo.Inducciones(
	IdInduccion INT IDENTITY(1,1),
	Fecha DATE NOT NULL,
	Descripcion VARCHAR(250) NOT NULL,

	CONSTRAINT PK_Inducciones PRIMARY KEY (IdInduccion),
);

CREATE TABLE dbo.InduccionXOperario(
    IdInduccionXOperario INT IDENTITY(1,1),
    IdOperario INT NOT NULL,
    IdInduccion INT NOT NULL,

    CONSTRAINT PK_InduccionXOperario PRIMARY KEY (IdInduccionXOperario),
    CONSTRAINT FK_InduccionXOperario_Operarios FOREIGN KEY (IdOperario) REFERENCES Operarios (IdOperario),
    CONSTRAINT FK_InduccionXOperario_Inducciones FOREIGN KEY (IdInduccion) REFERENCES Inducciones (IdInduccion)
);

SET IDENTITY_INSERT cedna.dbo.Operacion ON;

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(55, 'inducciones', 'Inducciones', 'inducciones zoom', 6, 6, 'inducciones');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(56, 'inducciones - alta', 'Nueva Inducción', '', 55, 0, 'inducciones/alta');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(57, 'inducciones - edicion', 'Editar Inducción', '', 55, 0, 'inducciones/editar');

SET IDENTITY_INSERT cedna.dbo.Operacion OFF;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(191, 55, 1, 2, '', 'index', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(192, 55, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(193, 55, 4, 2, '', 'inducciones/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(194, 55, 6, 2, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(195, 55, 5, 2, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(196, 56, 1, 2, '', 'inducciones', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(197, 56, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(198, 56, 2, 2, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(199, 57, 1, 2, '', 'inducciones', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(200, 57, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(201, 57, 2, 2, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil OFF;

ALTER TABLE Operarios
ADD IdContratista INT NULL;

ALTER TABLE Operarios
ADD CONSTRAINT FK_Operarios_Contratista FOREIGN KEY (IdContratista) REFERENCES Usuarios (IdUsuario)

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('02.sql', GETDATE ( ), 1, 2);