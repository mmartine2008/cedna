SET IDENTITY_INSERT cedna.dbo.Operacion ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(33, 'ordenes de compra', 'Ordenes de Compra', 'permisos', 6, 6, 'ordenes-de-compra');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(34, 'ordenes de compra - alta', 'Alta de Ordenes de Compra', '', 33, 1, 'ordenes-de-compra/alta');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(35, 'ordenes de compra - edicion', 'Editar Ordenes de Compra', '', 33, 2, 'ordenes-de-compra/editar');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(36, 'planificacion de tareas', 'Planificación de Tareas', 'botonEditar zoom', 6, 3, 'planificacion');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(37, 'planificacion - asignar', 'Asignar Planificación de Tarea', '', 36, 0, 'planificacion/asignar');

SET IDENTITY_INSERT cedna.dbo.Operacion Off;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(101, 36, 1, 2, '', 'index', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(102, 36, 7, 2, '', '', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(103, 6, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(105, 37, 1, 2, '', 'planificacion', 2, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(106, 37, 7, 2, '', 'logout', 11, '');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(107, 37, 2, 2, 'preSubmit()', '', 9, 'botonGuardar');

INSERT INTO cedna.dbo.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(108, 36, 6, 2, 'preEditar()', '', 6, 'botonEditar');


SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil Off;

-- Agrego la nueva columna
ALTER TABLE Planificaciones
ADD IdRelevamiento INT NULL;

ALTER TABLE Planificaciones
ADD CONSTRAINT FK_Planificaciones_Relevamientos FOREIGN KEY (IdRelevamiento)  REFERENCES Relevamientos (IdRelevamiento);

-- ALTER TABLE Tareas
-- DROP CONSTRAINT FK_Tareas_Relevamientos;

-- ALTER TABLE Tareas
-- DROP COLUMN IdRelevamiento;

ALTER TABLE Tareas
ADD IdTipoPlanificacion INT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_TipoPlanificacion FOREIGN KEY (IdTipoPlanificacion)  REFERENCES TipoPlanificacion (IdTipoPlanificacion);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('29.sql', GETDATE ( ), 0, 29);