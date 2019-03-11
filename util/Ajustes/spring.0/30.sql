-- Asigna permisos a la operacion Analisis de tareas al perfil Contratista
SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(109, 36, 1, 5, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(110, 36, 7, 5, '', '', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(111, 37, 1, 5, '', 'planificacion', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(112, 37, 7, 5, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(113, 37, 2, 5, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(114, 36, 6, 5, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(115, 36, 1, 3, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(116, 36, 7, 3, '', '', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(117, 37, 1, 3, '', 'planificacion', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(118, 37, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(119, 37, 2, 3, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(120, 36, 6, 3, 'preEditar()', '', 6, 'botonEditar');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil Off;

ALTER TABLE Tareas
DROP CONSTRAINT FK_Tareas_Relevamientos;

ALTER TABLE Tareas
DROP COLUMN IdRelevamiento;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('30.sql', GETDATE ( ), 0, 30);