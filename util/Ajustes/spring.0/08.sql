ALTER TABLE Seccion 
ADD Nombre varchar(100) null;

ALTER TABLE Formulario 
ADD Nombre varchar(100) null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('08.sql', GETDATE ( ), 0, 8);