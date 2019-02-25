ALTER TABLE Operacion
ADD url varchar(100) null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('13.sql', GETDATE ( ), 0, 13);