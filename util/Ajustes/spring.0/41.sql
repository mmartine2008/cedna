ALTER TABLE cedna.dbo.NodosFirmantesRelevamiento ALTER COLUMN FechaFirma datetime NULL

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('41.sql', GETDATE ( ), 0, 41);