UPDATE cedna.dbo.Operacion
SET nombre='formularios', titulo='Formularios', icono='permisos zoom', grupoId=6, orden=1, url='formulario'
WHERE Id=31;

UPDATE cedna.dbo.Operacion
SET nombre='formularios - para cargar', titulo='Formularios para cargar', icono='tareas zoom', grupoId=31, orden=1, url='formulario/para-cargar'
WHERE Id=40;

SET IDENTITY_INSERT cedna.dbo.Operacion ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(42, 'organigrama - dibujar', 'Visualización de organigrama', 'ver-organigrama zoom', 20, 3, 'organigrama/dibujar');

SET IDENTITY_INSERT cedna.dbo.Operacion OFF;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(132, 42, 1, 1, '', 'organigrama', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(133, 42, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(134, 40, 1, 3, '', 'formulario', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(135, 40, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(136, 40, 6, 3, 'preEditar()', '', 6, 'botonEditar');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('35.sql', GETDATE ( ), 0, 35);