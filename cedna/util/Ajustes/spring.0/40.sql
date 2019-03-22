SET IDENTITY_INSERT cedna.dbo.Operacion ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(45, 'formularios - para firmar', 'Formularios para Firmar', 'botonEditar zoom', 31, 0, 'formulario/formularios-para-firmar');

SET IDENTITY_INSERT cedna.dbo.Operacion OFF;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(145, 45, 1, 2, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(146, 45, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(147, 45, 1, 3, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(148, 45, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(149, 45, 1, 4, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(150, 45, 7, 4, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(151, 45, 1, 5, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(152, 45, 7, 5, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(153, 31, 1, 4, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(154, 31, 7, 4, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(155, 31, 1, 5, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(156, 31, 7, 5, '', 'logout', 11, '');


SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil OFF;

ALTER TABLE NodosFirmantesRelevamiento
ADD FechaFirma DATE NULL;

DELETE FROM OperacionAccionPerfil WHERE IdOperacion IN (43, 44);

DELETE FROM Operacion WHERE Id IN (43, 44);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('40.sql', GETDATE ( ), 0, 40);