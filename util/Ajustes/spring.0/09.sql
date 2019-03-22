CREATE TABLE UsuariosxPerfiles (
	IdUsuarioxPerfil INT IDENTITY(1,1),
	IdUsuario int not null,
	IdPerfil int not null,

	CONSTRAINT PK_UsuariosxPerfiles PRIMARY KEY (IdUsuarioxPerfil),
	CONSTRAINT FK_UsuariosxPerfiles_Usuarios FOREIGN KEY (IdUsuario) REFERENCES Usuarios (IdUsuario), 
	CONSTRAINT FK_UsuariosxPerfiles_Perfiles FOREIGN KEY (IdPerfil) REFERENCES Perfiles (IdPerfil), 
	CONSTRAINT UK_Usuarios_Perfiles UNIQUE(IdUsuario, IdPerfil)  
);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('09.sql', GETDATE ( ), 0, 9);