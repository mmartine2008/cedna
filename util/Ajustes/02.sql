ALTER TABLE PreguntaOpcion
DROP CONSTRAINT FK_PreguntaOpcion_PreguntaCerrada;

ALTER TABLE PreguntaOpcion
DROP CONSTRAINT AK_Opcion_Pregunta;

ALTER TABLE PreguntaOpcion 
DROP COLUMN IdPreguntaCerrada;

ALTER TABLE PreguntaOpcion 
ADD IdPregunta int not null;

ALTER TABLE PreguntaOpcion 
ADD CONSTRAINT FK_PreguntaOpcion_Pregunta FOREIGN KEY (IdPregunta) REFERENCES Pregunta (IdPregunta);

DROP TABLE PreguntaCerrada;

DROP TABLE PreguntaAbierta;

ALTER TABLE Pregunta 
ADD IdTipoPregunta int not null;

ALTER TABLE Pregunta 
ADD CONSTRAINT FK_Pregunta_TipoPregunta FOREIGN KEY (IdTipoPregunta) REFERENCES TipoPregunta (IdTipoPregunta);