SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(89, 6, 7, 4, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(90, 33, 1, 4, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(91, 33, 7, 4, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(92, 33, 4, 4, '', 'ordenes-de-compra/alta', 9, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(93, 33, 6, 4, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(94, 33, 5, 4, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(95, 34, 1, 4, '', 'ordenes-de-compra', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(96, 34, 7, 4, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(97, 34, 2, 4, 'preSubmit()', '', 9, 'botonGuardar');
INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(98, 35, 1, 4, '', 'ordenes-de-compra', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(99, 35, 7, 4, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(100, 35, 2, 4, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil OFF;

CREATE TABLE NodosFirmantesRelevamiento(
	IdNodoFirmanteRelevamiento INT IDENTITY(1,1),
	IdNodo INT NOT NULL,
	IdUsuarioFirmante INT NOT NULL,
	IdRelevamiento INT NOT NULL,

	CONSTRAINT PK_NodosFirmantesRelevamiento PRIMARY KEY (IdNodoFirmanteRelevamiento),
	CONSTRAINT FK_NodosFirmantesRelevamiento_Nodos FOREIGN KEY (IdNodo) REFERENCES Nodos (IdNodo),
	CONSTRAINT FK_NodosFirmantesRelevamiento_Usuarios FOREIGN KEY (IdUsuarioFirmante) REFERENCES Usuarios (IdUsuario),
	CONSTRAINT FK_NodosFirmantesRelevamiento_Relevamientos FOREIGN KEY (IdRelevamiento) REFERENCES Relevamientos (IdRelevamiento)
);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('39.sql', GETDATE ( ), 0, 39);