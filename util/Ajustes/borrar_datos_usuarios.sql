DELETE FROM esJefeDe;
DBCC CHECKIDENT ('esJefeDe', RESEED, 0);

DELETE FROM UsuariosxPerfiles;
DBCC CHECKIDENT ('UsuariosxPerfiles', RESEED, 0);

DELETE FROM InduccionXOperario;
DBCC CHECKIDENT ('InduccionXOperario', RESEED, 0);

DELETE FROM Operarios;
DBCC CHECKIDENT ('Operarios', RESEED, 0);

DELETE FROM Usuarios;
DBCC CHECKIDENT ('Usuarios', RESEED, 0);
