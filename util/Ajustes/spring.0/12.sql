ALTER TABLE Respuesta
ADD IdSeccion int null;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('12.sql', GETDATE ( ), 0, 12);