UPDATE cedna.app.Operacion
SET icono='ordenesCompras zoom'
WHERE Id=33;

UPDATE cedna.app.Operacion
SET icono='planificacion zoom'
WHERE Id=36;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('16.sql', GETDATE ( ), 1, 16);