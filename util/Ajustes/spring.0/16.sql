
ALTER TABLE Operarios 
DROP COLUMN Telefono;

ALTER TABLE Operarios 
ADD Telefono varchar(25) NULL;

CREATE TABLE TipoNodo (
    IdTipoNodo INT IDENTITY(1,1),
    Descripcion VARCHAR(50) NOT NULL,

    CONSTRAINT PK_TipoNodo PRIMARY KEY (IdTipoNodo),  
);

CREATE TABLE Nodos (
	IdNodo INT IDENTITY(1,1),
    IdTipoNodo INT NOT NULL,
    IdNodoSuperior INT NULL,
    Nombre VARCHAR(100) NOT NULL,

	CONSTRAINT PK_Nodos PRIMARY KEY (IdNodo),
    CONSTRAINT FK_Nodos_TipoNodo FOREIGN KEY (IdTipoNodo)  REFERENCES TipoNodo (IdTipoNodo), 
);

CREATE TABLE esJefeDe (
	IdEsJefeDe INT IDENTITY(1,1),
    IdNodo INT NOT NULL,
    IdUsuario INT NOT NULL,
    Orden INT NOT NULL,

	CONSTRAINT PK_esJefeDe PRIMARY KEY (IdEsJefeDe),
    CONSTRAINT FK_esJefeDe_Nodos FOREIGN KEY (IdNodo)  REFERENCES Nodos (IdNodo), 
    CONSTRAINT FK_esJefeDe_Usuarios FOREIGN KEY (IdUsuario)  REFERENCES Usuarios (IdUsuario), 
);

INSERT INTO cedna.dbo.TipoNodo (Descripcion) VALUES  ('Area') ,('Departamento') ,('Sección');

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('16.sql', GETDATE ( ), 0, 16);