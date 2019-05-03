CREATE TABLE dbo.RelevamientosxSecciones(
    IdRelevamientoxSeccion INT IDENTITY(1,1),
    IdRelevamiento INT NOT NULL,
    IdSeccion INT NOT NULL,

    CONSTRAINT PK_RelevamientosxSecciones PRIMARY KEY (IdRelevamientoxSeccion),
    CONSTRAINT FK_RelevamientosxSecciones_Relevamientos FOREIGN KEY (IdRelevamiento) REFERENCES dbo.Relevamientos (IdRelevamiento),
    CONSTRAINT FK_RelevamientosxSecciones_Seccion FOREIGN KEY (IdSeccion) REFERENCES app.Seccion (IdSeccion),
    CONSTRAINT AK_Relevamientos_Seccion UNIQUE(IdRelevamiento, IdSeccion)  
);

ALTER TABLE dbo.Relevamientos
DROP CONSTRAINT FK_Relevamientos_Formulario;

ALTER TABLE dbo.Relevamientos
DROP COLUMN IdFormulario;

ALTER TABLE app.Seccion
DROP CONSTRAINT FK_Seleccion_Formulario;

ALTER TABLE app.Seccion
DROP COLUMN IdFormulario;

ALTER TABLE dbo.Respuesta
DROP CONSTRAINT FK_Respuesta_Relevamiento;

ALTER TABLE dbo.Respuesta
DROP COLUMN IdRelevamiento;

ALTER TABLE dbo.Respuesta
DROP CONSTRAINT FK_Respuesta_Seccion;

ALTER TABLE dbo.Respuesta
DROP COLUMN IdSeccion;

ALTER TABLE dbo.Respuesta
ADD IdRelevamientoxSeccion INT NULL;

ALTER TABLE dbo.Respuesta
ADD CONSTRAINT FK_Respuesta_RelevamientoxSeccion
FOREIGN KEY (IdRelevamientoxSeccion) REFERENCES RelevamientosxSecciones(IdRelevamientoxSeccion);

DROP TABLE dbo.FirmanFormulario;

DROP TABLE dbo.Formulario;


-- Actual parameter values may differ, what you see is a default string representation of values
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=1 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=3 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=4 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=7 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=9 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=10 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=13 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=15 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=16 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=19 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=20 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=21 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=22 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=23 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=24 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=25 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=26 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=27 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=28 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=31 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=32 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=33 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=34 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=35 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=36 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=37 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=38 ;
DELETE FROM cedna_dev.app.SeccionPregunta
WHERE IdSeccionPregunta=39 ;


-- Actual parameter values may differ, what you see is a default string representation of values
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=2 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=3 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=4 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=5 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=7 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=8 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=10 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=11 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=13 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=14 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=17 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=18 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=1 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=6 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=9 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=12 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=15 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=16 ;
DELETE FROM cedna_dev.app.Seccion
WHERE IdSeccion=19 ;

SET IDENTITY_INSERT app.Seccion ON;

INSERT app.Seccion(idSeccion, Nombre, Descripcion) VALUES (1, 'General', 'Datos generales');
INSERT app.Seccion(idSeccion, Nombre, Descripcion) VALUES (2, 'Protección', 'Equipos y elementos de protección');
INSERT app.Seccion(idSeccion, Nombre, Descripcion) VALUES (3, 'Ambientales', 'Riesgos Ambientales');
INSERT app.Seccion(idSeccion, Nombre, Descripcion) VALUES (4, 'Adicionales', 'Riesgos Adicionales');
INSERT app.Seccion(idSeccion, Nombre, Descripcion) VALUES (5, 'Gases', 'Prueba de Gases');

SET IDENTITY_INSERT app.Seccion OFF;

INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (1,1); 
INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (1,3);
INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (1,4);

INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (2,7);

INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (3,9); 

INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (4,10); 

INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (5,11); 
INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (5,12);
INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (5,13);
INSERT app.SeccionPregunta(idSeccion, idPregunta) VALUES (5,14);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('17.sql', GETDATE ( ), 1, 17);
