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

INSERT Formulario(Descripcion, Nombre) VALUES('Nuevo Permiso de Trabajo en Frio', 'Nuevo Permiso de Trabajo en Frio');

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'General', 'Datos generales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Fecha', 5, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('', 1, 1);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Empresa', 1, 1, 'getEmpresas');
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Imagen del lugar', 7, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Planta o lugar', 1, 1, 'getLugarObra');
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Etapa de obra', 1, 1, 'getEtapasObra');
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('Actividad', 1, 1, 'getActividadesObra');

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

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Protección', 'Equipos y elementos de protección');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 3, 1, 'getElementosProteccionPersonal');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (2,8); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Ambientales', 'Riesgos Ambientales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getRiesgosAmbientales');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (3,9); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Adicionales', 'Riesgos Adicionales');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getRiesgosAdicionales');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (4,10); 

INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Gases', 'Prueba de Gases');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Fecha de prueba', 5, 0);
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Hora de prueba', 10, 0); 
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Tiempo de validez', 9, 0); 
INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getPruebaDeGases');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,11); 
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,12);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,13);
INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (5,14);


INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (1, 'Firmas', 'Firmas del Permiso');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones, Funcion) VALUES ('', 2, 1, 'getFirmasPermiso');

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (6,15); 

-- INSERT Seccion(IdFormulario, Nombre, Descripcion) VALUES (2, 'Informacion', 'Informacion');

-- INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Se encuentra casado?', 1, 1);

-- INSERT Opcion(Descripcion) VALUES ('Si');
-- INSERT Opcion(Descripcion) VALUES ('No');

-- INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Nombre de pareja', 4, 0);

-- INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (24, 9); 
-- INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (24, 10); 

-- INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (9,24); 

-- INSERT PreguntaGeneradora(IdPregunta, idOpcion, IdPreguntaGenerada) VALUES (24, 9, 25);