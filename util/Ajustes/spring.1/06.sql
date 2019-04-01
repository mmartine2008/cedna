SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1207, 6, 7, 6, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1208, 31, 1, 6, '', 'index', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1209, 31, 7, 6, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1210, 45, 1, 6, '', 'formulario', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1211, 45, 7, 6, '', 'logout', 11, '');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('06.sql', GETDATE ( ), 1, 6);