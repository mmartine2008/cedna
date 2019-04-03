UPDATE cedna.app.Pregunta
SET Required=1
WHERE Required=null ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('07.sql', GETDATE ( ), 1, 7);