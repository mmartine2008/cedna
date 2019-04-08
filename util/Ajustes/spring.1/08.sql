CREATE TABLE dbo.Parametros (
    Id int IDENTITY(1,1) NOT NULL,
    Parametro varchar(80) not null,
    Valor varchar(20) not null,
    Descripcion varchar(255) not null,

    CONSTRAINT PK_Parametros PRIMARY KEY (Id),
); 