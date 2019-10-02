SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1080, 'empresas contratistas', 'ABM de Empresas Contratistas', 'empresas zoom', 5, 1, 'empresa-contratista');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1081, 'empresas contratistas - alta', 'Alta de Empresa Contratista', '', 1080, 0, 'empresa-contratista/alta');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1082, 'empresas contratistas - edicion', 'Edición de Empresas Contratistas', '', 1080, 0, 'empresa-contratista/editar');

SET IDENTITY_INSERT cedna.app.Operacion OFF;


SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1296, 1080, 1, 1, '', 'index', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1297, 1080, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1298, 1080, 4, 1, '', 'empresa-contratista/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1299, 1081, 1, 1, '', 'empresa-contratista', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1300, 1080, 6, 1, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1301, 1080, 5, 1, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1302, 1081, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1303, 1081, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1304, 1082, 1, 1, '', 'empresa-contratista', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1305, 1082, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1306, 1082, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('02.sql', GETDATE ( ), 2, 02);