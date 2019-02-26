ALTER TABLE Operarios 
DROP COLUMN Telefono;

ALTER TABLE Operarios 
ADD Telefono varchar(25) NULL;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('16.sql', GETDATE ( ), 0, 16);