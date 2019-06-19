SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil ON;

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1290, 1078, 1, 3, '', 'formulario', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1291, 1078, 6, 3, 'preEditar()', '', 6, 'botonEditar');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1292, 1078, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1293, 1079, 7, 3, '', 'logout', 11, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1294, 1079, 1, 3, '', 'formulario/asignacion-operarios', 2, '');

INSERT INTO cedna.app.OperacionAccionPerfil (Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(1295, 1079, 2, 3, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.app.OperacionAccionPerfil OFF;

ALTER TABLE cedna.app.Seccion 
ADD esObligatoria int NULL;  

SET IDENTITY_INSERT cedna.app.Seccion ON;

INSERT INTO cedna.app.Seccion (IdSeccion,Nombre,Descripcion,esObligatoria)
VALUES (26,'Herramientas','Herramientas de Trabajo',1) ;

INSERT INTO cedna.app.Seccion (IdSeccion,Nombre,Descripcion,esObligatoria)
VALUES (27,'Operarios','Operarios',1) ;

SET IDENTITY_INSERT cedna.app.Seccion OFF;

UPDATE cedna.app.Seccion
SET esObligatoria=0
WHERE IdSeccion=1 ;

UPDATE cedna.app.Seccion
SET esObligatoria=0
WHERE IdSeccion=2 ;

UPDATE cedna.app.Seccion
SET esObligatoria=0
WHERE IdSeccion=3 ;

UPDATE cedna.app.Seccion
SET esObligatoria=0
WHERE IdSeccion=4 ;

UPDATE cedna.app.Seccion
SET esObligatoria=0
WHERE IdSeccion=5 ;

SET IDENTITY_INSERT cedna.app.Pregunta ON;
INSERT INTO cedna.app.Pregunta (IdPregunta,Descripcion,IdTipoPregunta,Opciones,Funcion)
VALUES (40,'',3,1,'getOperariosParaTrabajo');
SET IDENTITY_INSERT cedna.app.Pregunta OFF;

SET IDENTITY_INSERT cedna.app.SeccionPregunta ON;
INSERT INTO cedna.app.SeccionPregunta (IdSeccionPregunta,IdSeccion,IdPregunta,Required)
VALUES (67,27,40,1) ;
INSERT INTO cedna.app.SeccionPregunta (IdSeccionPregunta,IdSeccion,IdPregunta,Required)
VALUES (68,26,8,1) ;
SET IDENTITY_INSERT cedna.app.SeccionPregunta OFF;

UPDATE cedna.app.SeccionPregunta
SET Required=1
WHERE Required=NULL;

DELETE FROM cedna.app.SeccionPregunta
WHERE IdSeccionPregunta=43;

DELETE FROM cedna.dbo.Respuesta
WHERE IdPregunta=7;

DELETE FROM cedna.app.Pregunta
WHERE IdPregunta=7 ;


INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('21.sql', GETDATE ( ), 1, 21);