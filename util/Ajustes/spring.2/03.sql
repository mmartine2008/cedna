UPDATE app.Pregunta
SET Funcion='getRiesgosAdicionales' WHERE IdPregunta=10;

UPDATE app.Pregunta
SET Funcion='getRiesgosAdicionales' WHERE IdPregunta=15;

UPDATE app.Operacion
SET icono='herramientas-planificacion zoom'
WHERE Id=1076;

UPDATE app.Operacion
SET icono='operarios-planificacion zoom'
WHERE Id=1078;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('03.sql', GETDATE ( ), 2, 03);