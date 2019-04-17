SET IDENTITY_INSERT cedna.app.Operacion ON;

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden,url)
VALUES (1071,'pregunta','Configuración de preguntas','permisos zoom',5,0,'configuracion/preguntas');   

SET IDENTITY_INSERT cedna.app.Operacion OFF;

UPDATE cedna.app.Operacion
SET grupoId=1071
WHERE Id=1070;

UPDATE cedna.app.Operacion
SET grupoId=1071
WHERE Id=1069;


UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/pregunta'
WHERE Id=1244;

SET IDENTITY_INSERT cedna.app.Accion ON;

INSERT INTO cedna.app.Accion (Id,nombre,titulo,icono)
VALUES (8,'clonar','Clonar','botonEditar zoom') ;

SET IDENTITY_INSERT cedna.app.Accion OFF;


SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1247,1071,1,1,NULL,'configuracion',2,NULL);
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1248,1071,7,1,NULL,'logout',11,NULL);
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1249,1071,4,1,NULL,'configuracion/preguntas/alta-pregunta',9,NULL);
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1250,1071,6,1,'preEditar()',NULL,6,'botonEditar');
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1251,1071,5,1,'preBorrar()',NULL,5,'botonBorrar');
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1252,1070,1,1,NULL,'configuracion/preguntas',2,NULL);
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1253,1070,7,1,NULL,'logout',11,NULL);
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1254,1070,2,1,'preSubmit()',NULL,9,'botonGuardar');
INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1255,1064,8,1,'preClonar()',NULL,4,'botonClonar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

UPDATE app.OperacionAccionPerfil
SET urlDestino = 'formulario/para-cargar'
WHERE IdOperacion = 32 AND IdAccion = 1;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('13.sql', GETDATE ( ), 1, 13);
