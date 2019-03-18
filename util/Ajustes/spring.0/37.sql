CREATE TABLE FirmanFormulario(
	IdFirmaFormulario INT IDENTITY(1,1),
	IdPerfil INT NOT NULL,
	IdFormulario INT NOT NULL,

	CONSTRAINT PK_FirmanFormulario PRIMARY KEY (IdFirmaFormulario),
	CONSTRAINT FK_FirmanFormulario_Perfiles FOREIGN KEY (IdPerfil) REFERENCES Perfiles (IdPerfil),
	CONSTRAINT FK_FirmanFormulario_Formulario FOREIGN KEY (IdFormulario) REFERENCES Formulario (IdFormulario)
);

SET IDENTITY_INSERT cedna.dbo.Operacion ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(43, 'formularios - perfiles firmantes', 'Perfiles Firmantes de Formularios', 'perfiles zoom', 31, 4, 'formulario/perfiles-firmantes');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(44, 'formularios - cargar perfiles firmantes', 'Cargar Perfiles Firmantes de Formulario', '', 43, 1, 'formulario/cargar-perfiles-firmantes');

SET IDENTITY_INSERT cedna.dbo.Operacion OFF;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(129, 41, 1, 1, '', 'configuracion', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(130, 41, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(131, 41, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(137, 43, 1, 1, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(138, 43, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(139, 43, 6, 1, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(140, 44, 1, 1, '', 'formulario/perfiles-firmantes', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(141, 44, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(142, 44, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(143, 31, 1, 1, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(144, 31, 7, 1, '', 'logout', 11, '');


SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('37.sql', GETDATE ( ), 0, 37);