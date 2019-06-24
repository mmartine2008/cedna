CREATE VIEW vw_usuarios_perfil AS 
SELECT U.NombreUsuario , P.Nombre AS NombrePerfil
FROM dbo.Usuarios U 
INNER JOIN dbo.UsuariosxPerfiles UP ON (U.IdUsuario = UP.IdUsuario)
INNER JOIN app.Perfiles P ON (UP.IdPerfil = P.IdPerfil);

