SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1061, 'parametros', 'Parametros', 'parametros zoom', 5, 5, 'configuracion/parametros');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1062, 'parametros - alta', 'Alta de Parametros', '', 1061, 1, 'configuracion/parametros/alta');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1063, 'parametros - edicion', 'Editar Parametro', '', 1061, 2, 'configuracion/parametros/editar');

SET IDENTITY_INSERT cedna.app.Operacion OFF;

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1212, 1061, 1, 1, '', 'configuracion', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1213, 1061, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1214, 1061, 4, 1, '', 'configuracion/parametros/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1215, 1061, 6, 1, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1216, 1061, 5, 1, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1217, 1062, 1, 1, '', 'configuracion/parametros', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1218, 1062, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1219, 1062, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1220, 1063, 1, 1, '', 'configuracion/parametros', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1221, 1063, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1222, 1063, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('09.sql', GETDATE ( ), 1, 9);