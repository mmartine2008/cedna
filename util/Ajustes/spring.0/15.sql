CREATE TABLE Operarios(
	IdOperario INT IDENTITY(1,1),
	Nombre varchar(100) NOT NULL,
    Apellido varchar(100) NOT NULL,
    CUIT varchar(100) NOT NULL,
    Telefono int NULL,
    Email varchar(100) NULL,

	CONSTRAINT PK_Operarios PRIMARY KEY (IdOperario),  
);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('15.sql', GETDATE ( ), 0, 15);