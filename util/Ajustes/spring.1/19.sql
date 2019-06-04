UPDATE cedna.app.Operacion
SET url='configuracion/secciones'
WHERE Id=1064 ;

UPDATE cedna.app.OperacionAccionPerfil
SET IdOperacion=1064
WHERE Id=1236 ;

UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/secciones/alta-seccion',IdOperacion=1067
WHERE Id=1225 ;

UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/secciones',IdOperacion=1067
WHERE Id=1228 ;

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1266,1064,1,1,NULL,'configuracion',2,'botonVolver');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.app.OperacionAccionPerfil
SET IdOperacion=1064, jsFunction='', ordenUbicacion=9,  urlDestino='configuracion/secciones/alta-seccion'
WHERE Id=1233 ;

DELETE FROM cedna.app.OperacionAccionPerfil
WHERE Id=1225 ;

DELETE FROM cedna.app.Operacion
WHERE Id=1065 ;

UPDATE cedna.app.Operacion
SET grupoId=1064
WHERE Id=1067 ;
UPDATE cedna.app.Operacion
SET grupoId=1064
WHERE Id=1068 ;

UPDATE cedna.app.OperacionAccionPerfil
SET jsFunction='',urlDestino='configuracion/secciones'
WHERE Id=1230 ;

DELETE FROM cedna.app.OperacionAccionPerfil
WHERE Id=1234;

DELETE FROM cedna.app.Operacion
WHERE Id=1066 ;

DELETE FROM cedna.app.OperacionAccionPerfil
WHERE Id=1239 ;

DELETE FROM cedna.app.OperacionAccionPerfil
WHERE Id=1241 ;

DELETE FROM cedna.app.Operacion
WHERE Id=1066;

UPDATE cedna.app.OperacionAccionPerfil
SET ordenUbicacion=11,idHTMLElement=''
WHERE Id=1245;


