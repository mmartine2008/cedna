ALTER TABLE Respuesta
ADD Seccion int null;

ALTER TABLE PreguntaOpcion
ADD Destino varChar(100) null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('12.sql', GETDATE ( ), 0, 12);