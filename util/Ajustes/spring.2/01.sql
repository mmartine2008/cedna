CREATE TABLE EmpresasContratistas (
	IdEmpresaContratista INT IDENTITY(1,1),
	RazonSocial varchar(200) NOT NULL, 
	Direccion varchar(200) NULL,
	Telefono varchar(20) NULL,
	CONSTRAINT PK_EmpresasContratistas PRIMARY KEY (IdEmpresaContratista),
	CONSTRAINT UQ_EmpresasContratistas UNIQUE (RazonSocial)
);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('01.sql', GETDATE ( ), 2, 1);