ALTER TABLE OperacionAccionPerfil
ADD urlDestino varchar(100);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('05.sql', GETDATE ( ), 0, 5);