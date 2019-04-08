ALTER TABLE app.PreguntaGeneradora
ADD Required INT NULL;

ALTER TABLE cedna.app.Pregunta DROP COLUMN Required;

UPDATE cedna.app.SeccionPregunta
SET Required=1
WHERE Required=null ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('10.sql', GETDATE ( ), 1, 10);