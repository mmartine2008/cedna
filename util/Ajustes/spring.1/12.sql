SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden,url)
VALUES (1069,'preguntas - alta','Alta de Pregunta',NULL,1068,0,NULL);

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden,url)
VALUES (1070,'preguntas - edicion',NULL,NULL,1068,0,NULL);

SET IDENTITY_INSERT cedna.app.Operacion OFF;

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1244,1069,1,1,'preVolver()',NULL,2,'botonVolver');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1245,1069,7,1,NULL,'logout',NULL,11);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1246,1069,2,1,'preSubmit()',NULL,9,'botonGuardar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

UPDATE cedna.app.OperacionAccionPerfil
SET jsFunction='preAltaPregunta()'
WHERE Id=1241;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('12.sql', GETDATE ( ), 1, 12);
