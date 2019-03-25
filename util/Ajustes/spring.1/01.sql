SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(46, 'abm acciones', 'ABM de Acciones', '', NULL, 1, 'abm/accion');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(47, 'abm acciones - alta', 'Alta de Acción', '', 46, 0, 'abm/accion/alta');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(48, 'abm acciones - editar', 'Edición de Acción', '', 46, 0, 'abm/accion/editar');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(49, 'abm operaciones', 'ABM de Operaciones', '', NULL, 1, 'abm/operacion');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(50, 'abm operaciones - alta', 'Alta de Operación', '', 49, 0, 'abm/operacion/alta');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(51, 'abm operaciones - editar', 'Edición de Operación', '', 49, 0, 'abm/operacion/editar');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(52, 'abm operacionAccionPerfil', 'ABM de Operación - Acción  - Perfil', '', NULL, 0, 'abm/operacionAccionPerfil');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(53, 'abm operacionAccionPerfil - alta', 'Alta de Operación - Acción - Perfil', '', 52, 0, 'abm/operacionAccionPerfil/alta');

INSERT INTO cedna.app.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(54, 'abm operacionAccionPerfil - editar', 'Editar de Operación - Acción - Perfil', '', 52, 0, 'abm/operacionAccionPerfil/editar');

SET IDENTITY_INSERT cedna.app.Operacion OFF;

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(157, 46, 1, 1, '', 'abm', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(159, 46, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(160, 46, 4, 1, '', 'abm/accion/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(161, 46, 6, 1, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(162, 46, 5, 1, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(163, 47, 1, 1, '', 'abm/accion', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(164, 47, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(165, 47, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(166, 48, 1, 1, '', 'abm/accion', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(167, 48, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(168, 48, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(169, 49, 1, 1, '', 'abm', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(170, 49, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(171, 49, 4, 1, '', 'abm/operacion/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(172, 49, 6, 1, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(173, 49, 5, 1, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(174, 50, 1, 1, '', 'abm/operacion', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(175, 50, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(176, 50, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(177, 51, 1, 1, '', 'abm/operacion', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(178, 51, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(179, 51, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(180, 52, 1, 1, '', 'abm', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(181, 52, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(182, 52, 4, 1, '', 'abm/operacionAccionPerfil/alta', 9, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(183, 52, 6, 1, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(184, 52, 5, 1, 'preBorrar()', '', 7, 'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(185, 53, 1, 1, '', 'abm/operacionAccionPerfil', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(186, 53, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(187, 53, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(188, 54, 1, 1, '', 'abm/operacionAccionPerfil', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(189, 54, 7, 1, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(190, 54, 2, 1, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('01.sql', GETDATE ( ), 1, 1);