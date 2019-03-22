ALTER TABLE Pregunta
ADD Required int NULL;

-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.dbo.Pregunta
SET Required=1
WHERE Required is NULL ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('32.sql', GETDATE ( ), 0, 32);