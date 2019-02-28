CREATE TABLE TipoJefe (
    IdTipoJefe INT IDENTITY(1,1),
    Descripcion VARCHAR(50) NOT NULL,

    CONSTRAINT PK_TipoJefe PRIMARY KEY (IdTipoJefe),  
);

ALTER TABLE esJefeDe 
ADD IdTipoJefe INT NOT NULL;

ALTER TABLE esJefeDe
ADD CONSTRAINT FK_esJefeDe_TipoJefe FOREIGN KEY (IdTipoJefe)  REFERENCES TipoJefe (IdTipoJefe);

INSERT INTO cedna.dbo.TipoJefe (Descripcion) VALUES  ('Jefe'), ('Supervisor'), ('Coordinador'), ('Responsable');

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('18.sql', GETDATE ( ), 0, 18);