CREATE TABLE TiposEvento(
	IdTipoEvento INT IDENTITY(1,1),
	Descripcion varchar(50) NOT NULL,

	CONSTRAINT PK_TiposEvento PRIMARY KEY (IdTipoEvento),
    CONSTRAINT UC_TiposEvento_Descripcion UNIQUE (Descripcion)
);

CREATE TABLE Eventos(
	IdEvento INT IDENTITY(1,1),
	IdTipoEvento INT NOT NULL,
    IdUsuario INT NOT NULL,
    Fecha DATE NOT NULL,

	CONSTRAINT PK_Eventos PRIMARY KEY (IdEvento),  
	CONSTRAINT FK_Eventos_TiposEvento FOREIGN KEY (IdTipoEvento) REFERENCES TiposEvento (IdTipoEvento),
    CONSTRAINT FK_Eventos_Usuarios FOREIGN KEY (IdUsuario) REFERENCES Usuarios (IdUsuario)
);

CREATE TABLE NotificacionesXPerfil(
	IdNotificacionXPerfil INT IDENTITY(1,1),
	IdTipoEvento INT NOT NULL,
    IdPerfil INT NOT NULL,

	CONSTRAINT PK_NotificacionesXPerfil PRIMARY KEY (IdNotificacionXPerfil),  
	CONSTRAINT FK_NotificacionesXPerfil_TiposEvento FOREIGN KEY (IdTipoEvento) REFERENCES TiposEvento (IdTipoEvento),
    CONSTRAINT FK_NotificacionesXPerfil_Perfiles FOREIGN KEY (IdPerfil) REFERENCES Perfiles (IdPerfil)
);

UPDATE cedna.dbo.Operacion
SET nombre='formularios - cargar', titulo='Cargar formulario', icono='tareas zoom', grupoId=31, orden=1, url='formulario/cargar'
WHERE Id=32;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.Operacion (Id, nombre, titulo, icono, grupoId, orden, url)
VALUES(41, 'configuracion - notificaciones x perfil', 'Configuración de Notificaciones por Perfil', 'notificaciones-por-perfil zoom', 5, 4, 'configuracion/notificaciones-por-perfil');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil OFF;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('33.sql', GETDATE ( ), 0, 33);