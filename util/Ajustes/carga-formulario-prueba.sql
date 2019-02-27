DELETE FROM PreguntaOpcion;
DELETE FROM Opcion;
DELETE FROM SeccionPregunta;
DELETE FROM Pregunta;
DELETE FROM TipoPregunta;
DELETE FROM Respuesta;
delete from Seccion;
DELETE FROM Formulario;
DELETE FROM PreguntaGeneradora;

DBCC CHECKIDENT ('Opcion', RESEED, 0);
DBCC CHECKIDENT ('Seccion', RESEED, 0);
DBCC CHECKIDENT ('TipoPregunta', RESEED, 0);
DBCC CHECKIDENT ('SeccionPregunta', RESEED, 0);
DBCC CHECKIDENT ('Formulario', RESEED, 0);
DBCC CHECKIDENT ('Pregunta', RESEED, 0);
DBCC CHECKIDENT ('Respuesta', RESEED, 0);
DBCC CHECKIDENT ('PreguntaOpcion', RESEED, 0);
DBCC CHECKIDENT ('PreguntaGeneradora', RESEED, 0);



INSERT Formulario(Descripcion) VALUES('Datos Personales');

INSERT Seccion(IdFormulario) VALUES (1);

INSERT Opcion(Descripcion) VALUES ('femenino');
INSERT Opcion(Descripcion) VALUES ('masculino');

INSERT 	TipoPregunta(Descripcion) VALUES ('simple');
INSERT 	TipoPregunta(Descripcion, NroDestinos) VALUES ('multiple',1);
INSERT 	TipoPregunta(Descripcion, NroDestinos) VALUES ('multiple', 2);
INSERT 	TipoPregunta(Descripcion) VALUES ('texto');
INSERT 	TipoPregunta(Descripcion) VALUES ('fecha');


INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Nombre', 3, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Sexo', 1, 1);

INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (2, 1);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (2, 2);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,1);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,2);

INSERT Opcion(Descripcion) VALUES ('Primaria');
INSERT Opcion(Descripcion) VALUES ('Secundaria');
INSERT Opcion(Descripcion) VALUES ('Universitario');
INSERT Opcion(Descripcion) VALUES ('Terciario');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Estudios', 2, 1);

INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 3);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 4);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 5);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 6);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,3);
--  /////////////////////////////////////////////////////////////
UPDATE TipoPregunta
SET descripcion = 'text'
WHERE descripcion = 'texto';

UPDATE TipoPregunta
SET descripcion = 'date'
WHERE descripcion = 'fecha';

INSERT 	TipoPregunta(Descripcion) VALUES ('image');
INSERT 	TipoPregunta(Descripcion) VALUES ('file');
INSERT 	TipoPregunta(Descripcion) VALUES ('textarea');

INSERT Seccion(IdFormulario, Nombre) VALUES (1, 'Archivos');

UPDATE Seccion
SET Nombre = 'Datos'
WHERE IdSeccion = 1;

UPDATE Formulario
SET Nombre = 'Datos Personales'
WHERE IdFormulario = 1;

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Comentario', 8, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Ingresar Archivo', 7, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Ingresar Foto', 7, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Imagen', 6, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Fecha de Nacimiento', 5, 0);


INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,4); 
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,5);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,6);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,7);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,8);

--/////////////////////////////////////////////////////////
INSERT Formulario(Descripcion, Nombre) VALUES('Nuevo Permiso de Trabajo en Frio', 'Nuevo Permiso de Trabajo en Frio');

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'General', 'Datos generales');


INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Fecha', 5, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('', 1, 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Empresa', 1, 1, 'getNombresEmpresas');
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Imagen del lugar', 7, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Planta o lugar', 1, 1, 'getNombresPlantaLugar');
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Etapa de obra', 1, 1, 'getEtapasObra');
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Actividad', 1, 1, 'getEtapasObra');

INSERT Opcion(Descripcion) VALUES ('Interno');
INSERT Opcion(Descripcion) VALUES ('Externo');

INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (10, 7); 
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (10, 8); 

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,9); 
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,10);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,11);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,12);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,13);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,14);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,15);

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Protección', 'Equipos y elementos de protección');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 3, 1, 'getEquiposElementosProteccion');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (4,16); 

INSERT TipoPregunta(Descripcion) VALUES ('number');

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Ambientales', 'Riesgos Ambientales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getRiesgosAmbientales');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,17); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Adicionales', 'Riesgos Adicionales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getRiesgosAdicionales');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (6,18); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Gases', 'Prueba de Gases');

INSERT TipoPregunta(Descripcion) VALUES ('time');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Fecha de prueba', 5, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Hora de prueba', 10, 0); 
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Tiempo de validez', 9, 0); 
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getPruebasGases');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (7,19); 
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (7,20);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (7,21);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (7,22);


INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Firmas', 'Firmas del Permiso');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getFirmasPermiso');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (8,23); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Informacion', 'Informacion');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Se encuentra casado?', 1, 1);

INSERT Opcion(Descripcion) VALUES ('Si');
INSERT Opcion(Descripcion) VALUES ('No');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Nombre de pareja', 4, 0);

INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (24, 9); 
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (24, 10); 

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (9,24); 

INSERT PreguntaGeneradora(IdPregunta, idOpcion, IdPreguntaGenerada) VALUES (24, 9, 25);