DELETE FROM cedna.app.OperacionAccionPerfil
WHERE IdOperacion IN (4, 8, 9);

DELETE FROM cedna.app.Operacion
WHERE Id IN (4, 8, 9);

UPDATE cedna.app.Operacion
SET nombre='tipo pregunta',titulo='Tipo Pregunta',grupoId=NULL
WHERE Id=1 

UPDATE cedna.app.Operacion
SET nombre='tipo pregunta - alta',titulo='Tipo Pregunta - Alta'
WHERE Id=2 

UPDATE cedna.app.Operacion
SET nombre='tipo pregunta - edicion',titulo='Tipo Pregunta - Edición'
WHERE Id=3 


INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('04.sql', GETDATE ( ), 1, 4);