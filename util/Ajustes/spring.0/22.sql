-- Insersiones y modificaciones de datos

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(31, 'formularios', 'Formularios', 'permisos zoom', 6, 1, 'formulario');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(32, 'formularios - cargar', 'Cargar formulario', '', 31, 1, 'formulario/cargar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(82, 31, 1, 3, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(83, 31, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(84, 31, 6, 3, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(85, 32, 1, 3, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(86, 32, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(87, 32, 2, 3, 'preSubmit()', '', 9, 'botonGuardar');

UPDATE cedna.dbo.Perfiles
SET Descripcion='Puede ser cualquier usuario', Nombre='Comitente'
WHERE IdPerfil=5;

-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=71;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=72;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=73;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=74;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=75;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=76;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=77;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=78;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=79;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=80;
UPDATE cedna.dbo.OperacionAccionPerfil
SET IdPerfil=5
WHERE Id=81;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(88, 6, 7, 5, '', 'logout', 11, '');


INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('22.sql', GETDATE ( ), 0, 22);