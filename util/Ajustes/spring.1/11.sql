ALTER TABLE app.TipoPregunta
ADD Informacion varchar(1000) NULL;


-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.app.TipoPregunta
SET Informacion='Simple selector'
WHERE IdTipoPregunta=1 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Multiple selector with 1 destination'
WHERE IdTipoPregunta=2 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Multiple selector with 2 destinations'
WHERE IdTipoPregunta=3 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Text'
WHERE IdTipoPregunta=4 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Date'
WHERE IdTipoPregunta=5 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Image '
WHERE IdTipoPregunta=6 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Pdf'
WHERE IdTipoPregunta=7 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Textarea'
WHERE IdTipoPregunta=8 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Number'
WHERE IdTipoPregunta=9 ;
UPDATE cedna.app.TipoPregunta
SET Informacion='Time'
WHERE IdTipoPregunta=10 ;

SET IDENTITY_INSERT cedna.app.Operacion ON;
INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden,url)
VALUES (1064,'formulario','Configuración de formularios','permisos zoom',5,0,'configuracion/formularios'); 

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden,url)
VALUES (1065,'formularios - alta','Alta de Formulario',NULL,1064,0,'configuracion/formularios/alta-formulario'); 

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden)
VALUES (1066,'formularios - edicion','Edición de Formulario',NULL,1064,0); 

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden)
VALUES (1067,'secciones - alta','Alta de Sección',NULL,1066,0); 

INSERT INTO cedna.app.Operacion (Id,nombre,titulo,icono,grupoId,orden)
VALUES (1068,'secciones - edicion','Editar Sección',NULL,1066,0); 

SET IDENTITY_INSERT cedna.app.Operacion OFF;

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1225,1064,4,1,NULL,'configuracion/formularios/alta-formulario',9,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1226,1064,6,1,'preEditar()',NULL,6,'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1227,1064,5,1,'preBorrar()',NULL,7,'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1228,1065,1,1,NULL,'configuracion/formularios',2,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1229,1065,7,1,NULL,'logout',11,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1230,1065,2,1,'preSubmit()',NULL,9,'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1231,1066,1,1,NULL,'configuracion/formularios',2,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1232,1066,7,1,NULL,'logout',11,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1233,1066,4,1,'preAltaSeccion()',NULL,8,'botonAltaSeccion');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1234,1067,1,1,'preVolver()',NULL,2,'botonVolver');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1235,1067,2,1,'preSubmit()',NULL,9,'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1236,1067,7,1,NULL,'logout',11,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1237,1066,6,1,'preEditarSeccion()',NULL,5,'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1238,1066,5,1,'preBorrarSeccion()',NULL,6,'botonBorrar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1239,1068,1,1,'preVolver()',NULL,2,'botonVolver');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1240,1068,7,1,NULL,'logout',11,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1241,1068,4,1,NULL,'configuracion/formularios/alta-pregunta',8,NULL);

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1242,1066,2,1,'preSubmit()',NULL,9,'botonGuardar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id,IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement)
VALUES (1243,1068,2,1,'preSubmit()',NULL,9,'botonGuardar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('11.sql', GETDATE ( ), 1, 11);