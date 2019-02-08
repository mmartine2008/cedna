ALTER TABLE TipoPregunta 
ADD NroDestinos int null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('07.sql', GETDATE ( ), 0, 7);