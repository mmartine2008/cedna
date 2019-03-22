ALTER TABLE Operacion
ADD url varchar(100) null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('14.sql', GETDATE ( ), 0, 14);