
SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(1078, 'formulario - asignacionOperarios', 'Asignar Operarios a Planificaciones', 'tareas zoom', 31, 2, 'formulario/asignacion-operarios');

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(32, 'formulario - asignarOperarios', 'Asignar Operarios a la Planificación', '', 1078, 1, 'formulario/asignar-operarios');

SET IDENTITY_INSERT cedna.app.Operacion OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('20.sql', GETDATE ( ), 1, 20);