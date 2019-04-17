SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1256,17,1,1,NULL,'index',2,NULL);
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1257,17,7,1,NULL,'logout',11,NULL);

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

UPDATE cedna.app.OperacionAccionPerfil
SET IdPerfil=1
WHERE Id=212 ;
UPDATE cedna.app.OperacionAccionPerfil
SET IdPerfil=1
WHERE Id=213 ;
UPDATE cedna.app.OperacionAccionPerfil
SET IdPerfil=1
WHERE Id=214 ;


UPDATE cedna.app.OperacionAccionPerfil
SET IdPerfil=1
WHERE Id=203 ;
UPDATE cedna.app.OperacionAccionPerfil
SET IdPerfil=1
WHERE Id=204 ;
UPDATE cedna.app.OperacionAccionPerfil
SET IdPerfil=1
WHERE Id=205;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('15.sql', GETDATE ( ), 1, 15);