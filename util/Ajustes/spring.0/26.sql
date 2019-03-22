ALTER TABLE Respuesta 
DROP CONSTRAINT FK_Respuesta_Opcion;

ALTER TABLE Respuesta 
DROP COLUMN IdOpcion;

ALTER TABLE Respuesta 
ADD IdOpcion int null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('26.sql', GETDATE ( ), 0, 26);