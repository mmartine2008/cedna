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
WHERE descripcion = 'texto'

UPDATE TipoPregunta
SET descripcion = 'date'
WHERE descripcion = 'fecha'

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