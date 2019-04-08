ALTER TABLE app.PreguntaGeneradora
ADD Required INT NULL;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('09.sql', GETDATE ( ), 1, 9);
