
SET IDENTITY_INSERT cedna.dbo.Operacion ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(38, 'formularios - asignacion', 'Asignación de Formularios a Planificaciones', 'tareas zoom', 31, 2, 'formulario/asignacion');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(39, 'formularios - asignar', 'Asignar un Formulario a la Planificación', '', 38, 1, 'formulario/asignar');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(40, 'formularios - para cargar', 'Formularios para cargar', 'permisos', 31, 1, 'formulario/para-cargar');

SET IDENTITY_INSERT cedna.dbo.Operacion Off;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(121, 38, 1, 2, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(122, 38, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(123, 38, 6, 2, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(124, 39, 1, 2, '', 'formulario/asignacion', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(125, 39, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(126, 39, 2, 2, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(127, 31, 1, 2, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(128, 31, 7, 2, '', 'logout', 11, '');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil Off;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('31.sql', GETDATE ( ), 0, 31);