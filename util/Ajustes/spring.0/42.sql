ALTER TABLE SeccionPregunta
ADD Required int NULL;

UPDATE cedna.dbo.SeccionPregunta
SET Required=1
WHERE Required is NULL ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('42.sql', GETDATE ( ), 0, 42);