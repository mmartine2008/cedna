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

DROP TABLE dbo.FirmanFormulario;

DROP TABLE dbo.Formulario;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('17.sql', GETDATE ( ), 1, 17);
