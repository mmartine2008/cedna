SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(59, 'operarios - cargar induccion', 'Carga de Inducción a Operarios ', 'inducciones zoom', 60, 0, 'operarios/carga-induccion');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(60, 'operarios - inducciones', 'Inducciones a Operarios', 'inducciones zoom', 17, 0, 'operarios/inducciones');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(61, 'operarios - listar', 'Listado de Operarios', 'personal zoom', 17, 0, 'operarios/listar');

SET IDENTITY_INSERT cedna.app.Operacion OFF;

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(203, 59, 1, 3, '', 'operarios', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(204, 59, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(205, 59, 2, 3, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(206, 61, 1, 3, '', 'operarios', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(207, 61, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(208, 61, 6, 3, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(209, 61, 5, 3, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(210, 61, 4, 3, '', 'operarios/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(212, 60, 1, 3, '', 'operarios', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(213, 60, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(214, 60, 6, 3, 'preEditar()', '', 6, 'botonEditar');


SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

UPDATE cedna.app.Operacion
SET nombre='operarios - alta', titulo='Alta de Operarios', icono='', grupoId=61, orden=2, url='operarios/alta'
WHERE Id=18;

UPDATE cedna.app.Operacion
SET nombre='operarios - edicion', titulo='Editar Operario', icono='', grupoId=61, orden=4, url='operarios/editar'
WHERE Id=19;

DELETE FROM cedna.app.OperacionAccionPerfil
WHERE Id IN (42, 43, 44);


INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('03.sql', GETDATE ( ), 1, 3);