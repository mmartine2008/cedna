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

INSERT Opcion(idOpcion, Descripcion) VALUES ('Primaria');
INSERT Opcion(idOpcion, Descripcion) VALUES ('Secundaria');
INSERT Opcion(idOpcion, Descripcion) VALUES ('Universitario');
INSERT Opcion(idOpcion, Descripcion) VALUES ('Terciario');

INSERT Pregunta(Descripcion, idTipoPregunta, Opciones) VALUES ('Estudios', 2, 1);

INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 3);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 4);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 5);
INSERT PreguntaOpcion(IdPregunta, idOpcion) VALUES (3, 6);

INSERT SeccionPregunta(idSeccion, idPregunta) VALUES (1,3);