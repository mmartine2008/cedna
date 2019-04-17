-- Elimina la posibilidad de dar de alta nuevos perfiles al Administrador del sistema
DELETE FROM app.OperacionAccionPerfil WHERE IdOperacion = 12;

-- Elimina preguntas que ya no se utilizan
DELETE FROM app.SeccionPregunta WHERE IdPregunta IN (2, 5, 6);
DELETE FROM app.Pregunta WHERE IdPregunta IN (2, 5, 6);

-- Firmar Formularios por parte del Administrador
SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
--VALUES(145, 45, 1, 1, '', 'formulario', 2, ''); CAMBIAR Id

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
--VALUES(146, 45, 7, 1, '', 'logout', 11, ''); CAMBIAR Id

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;
INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('13.sql', GETDATE ( ), 1, 13);
