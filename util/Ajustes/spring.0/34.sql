SET IDENTITY_INSERT cedna.dbo.TiposEvento ON;

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(1, 'Alta de Operarios');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(2, 'Editar Operario');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(3, 'Alta de Tareas');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(4, 'Editar Tarea');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(5, 'Alta de Ordenes de Compra');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(6, 'Editar Ordenes de Compra');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(7, 'Asignar Planificación de Tarea');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(8, 'Asignar un Formulario a la Planificación');

SET IDENTITY_INSERT cedna.dbo.TiposEvento OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('34.sql', GETDATE ( ), 0, 34);