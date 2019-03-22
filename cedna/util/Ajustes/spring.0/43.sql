
SET IDENTITY_INSERT cedna.dbo.TiposEvento ON;

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(9, 'Permiso de trabajo disponible para editar');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(10, 'Permiso de trabajo disponible para firmar');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(11, 'Permiso de trabajo completamente firmado');

INSERT INTO cedna.dbo.TiposEvento (IdTipoEvento, Descripcion)
VALUES(12, 'Firma de Permiso de trabajo delegada');

SET IDENTITY_INSERT cedna.dbo.TiposEvento OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('43.sql', GETDATE ( ), 0, 43);