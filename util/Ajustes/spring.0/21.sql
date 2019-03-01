-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.dbo.Pregunta
SET Funcion='getEmpresas'
WHERE IdPregunta=3 GO
UPDATE cedna.dbo.Pregunta
SET Funcion='getLugarObra'
WHERE IdPregunta=5 GO
UPDATE cedna.dbo.Pregunta
SET Funcion='getEtapasObra'
WHERE IdPregunta=6 GO
UPDATE cedna.dbo.Pregunta
SET Funcion='getActividadesObra'
WHERE IdPregunta=7 GO
UPDATE cedna.dbo.Pregunta
SET Funcion='getElementosProteccionPersonal'
WHERE IdPregunta=8;
UPDATE cedna.dbo.Pregunta
SET Funcion='getRiesgosAmbientales'
WHERE IdPregunta=9;
UPDATE cedna.dbo.Pregunta
SET Funcion='getRiesgosAdicionales'
WHERE IdPregunta=10;
UPDATE cedna.dbo.Pregunta
SET Funcion='getPruebaDeGases'
WHERE IdPregunta=14;
UPDATE cedna.dbo.Pregunta
SET Funcion='getFirmasPermiso'
WHERE IdPregunta=15;


INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('21.sql', GETDATE ( ), 0, 21);