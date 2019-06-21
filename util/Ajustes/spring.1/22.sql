DELETE FROM cedna.dbo.RelevamientosxSecciones
WHERE IdSeccion=2 ;

DELETE FROM cedna.app.Seccion
WHERE IdSeccion=2 ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('22.sql', GETDATE ( ), 1, 22);
