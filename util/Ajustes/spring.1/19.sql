CREATE TABLE dbo.HerramientasxRelevamiento (
    Id int IDENTITY(1,1) NOT NULL,
    IdHerramienta int not null,
    IdRelevamiento int not null,

    CONSTRAINT PK_HerramientasxRelevamiento PRIMARY KEY (Id),
     CONSTRAINT FK_PK_HerramientasxRelevamiento_Relevamientos FOREIGN KEY (IdRelevamiento) REFERENCES dbo.Relevamientos (IdRelevamiento),
    CONSTRAINT FK_PK_HerramientasxRelevamiento_Herramienta FOREIGN KEY (IdHerramienta) REFERENCES dbo.HerramientasDeTrabajo (Id),
    CONSTRAINT AK_Relevamientos_Herramienta UNIQUE(IdRelevamiento, IdHerramienta)  
); 

CREATE TABLE dbo.OperariosxRelevamiento (
    Id int IDENTITY(1,1) NOT NULL,
    IdOperario int not null,
    IdRelevamiento int not null,

    CONSTRAINT PK_OperariosxRelevamiento PRIMARY KEY (Id),
     CONSTRAINT FK_PK_OperariosxRelevamiento_Relevamientos FOREIGN KEY (IdRelevamiento) REFERENCES dbo.Relevamientos (IdRelevamiento),
    CONSTRAINT FK_PK_OperariosxRelevamiento_Operario FOREIGN KEY (IdOperario) REFERENCES dbo.Operarios (IdOperario),
    CONSTRAINT AK_Relevamientos_Operario UNIQUE(IdRelevamiento, IdOperario)  
); 

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('19.sql', GETDATE ( ), 1, 19);