DELETE FROM Respuesta;
DELETE FROM PreguntaOpcion;
DELETE FROM Opcion;
DELETE FROM SeccionPregunta;
DELETE FROM Pregunta;
DELETE FROM TipoPregunta;
DELETE FROM Respuesta;
DELETE FROM Seccion;
DELETE FROM PreguntaGeneradora;

DBCC CHECKIDENT ('Opcion', RESEED, 0);
DBCC CHECKIDENT ('Seccion', RESEED, 0);
DBCC CHECKIDENT ('TipoPregunta', RESEED, 0);
DBCC CHECKIDENT ('SeccionPregunta', RESEED, 0);
DBCC CHECKIDENT ('Pregunta', RESEED, 0);
DBCC CHECKIDENT ('Respuesta', RESEED, 0);
DBCC CHECKIDENT ('PreguntaOpcion', RESEED, 0);
DBCC CHECKIDENT ('PreguntaGeneradora', RESEED, 0);

INSERT 	TipoPregunta(Descripcion) VALUES ('simple');
INSERT 	TipoPregunta(Descripcion, NroDestinos) VALUES ('multiple',1);
INSERT 	TipoPregunta(Descripcion, NroDestinos) VALUES ('multiple', 2);
INSERT 	TipoPregunta(Descripcion) VALUES ('text');
INSERT 	TipoPregunta(Descripcion) VALUES ('date');
INSERT 	TipoPregunta(Descripcion) VALUES ('image');
INSERT 	TipoPregunta(Descripcion) VALUES ('file');
INSERT 	TipoPregunta(Descripcion) VALUES ('textarea');
INSERT  TipoPregunta(Descripcion) VALUES ('number');
INSERT  TipoPregunta(Descripcion) VALUES ('time');

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'General', 'Datos generales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Required) VALUES ('Fecha', 5, 0, 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Required) VALUES ('', 1, 1, 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('Empresa', 1, 1, 'getEmpresas', 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Imagen del lugar', 7, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('Planta o lugar', 1, 1, 'getLugarObra', 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('Etapa de obra', 1, 1, 'getEtapasObra', 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('Actividad', 1, 1, 'getActividadesObra', 1);

INSERT Opcion(Descripcion) VALUES ('Interno');
INSERT Opcion(Descripcion) VALUES ('Externo');

INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (2, 1); 
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (2, 2); 

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,1); 
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,2);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,3);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,4);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,5);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,6);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,7);

INSERT Formulario(Descripcion, Nombre) VALUES('Protección', 'Protección');

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Protección', 'Equipos y elementos de protección');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('', 3, 1, 'getElementosProteccionPersonal', 0);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,8);

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Ambientales', 'Riesgos Ambientales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('', 2, 1, 'getRiesgosAmbientales', 1);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,9); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Adicionales', 'Riesgos Adicionales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('', 2, 1, 'getRiesgosAdicionales', 1);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (4,10); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Gases', 'Prueba de Gases');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Required) VALUES ('Fecha de prueba', 5, 0, 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Required) VALUES ('Hora de prueba', 10, 0, 1); 
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Required) VALUES ('Tiempo de validez', 9, 0, 1); 
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('', 2, 1, 'getPruebaDeGases', 1);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,11); 
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,12);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,13);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,14);

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Firmas', 'Firmas del Permiso');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion, Required) VALUES ('', 2, 1, 'getFirmasPermiso', 1);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (6,15); 

DELETE FROM cedna.dbo.Operacion
WHERE Id=6;

INSERT INTO cedna.dbo.Relevamientos (IdFormulario,IdEstadoRelevamiento)
VALUES (2,1);

UPDATE cedna.dbo.Planificaciones
SET IdRelevamiento=2
WHERE IdPlanificacion=6;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('38.sql', GETDATE ( ), 0, 38);

