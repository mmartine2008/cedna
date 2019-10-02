DELETE FROM OperacionAccionPerfil;
DBCC CHECKIDENT ('OperacionAccionPerfil', RESEED, 0);
DELETE FROM Accion;
DBCC CHECKIDENT ('Accion', RESEED, 0);
DELETE FROM Perfiles;
DBCC CHECKIDENT ('Perfiles', RESEED, 0);
DELETE FROM Operacion
WHERE grupoId IS NOT NULL;
DELETE FROM Operacion;
DBCC CHECKIDENT ('Operacion', RESEED, 0);

INSERT INTO cedna.dbo.Accion (nombre,titulo,icono) VALUES 
('volver','Volver','fas fa-arrow-circle-left')
,('guardar','Guardar','far fa-save')
,('agregar','Agregar','fas fa-plus')
,('nueva','Nueva','fas fa-plus')
,('borrar','Borrar','fas fa-trash-alt')
,('editar','Editar','fas fa-pencil-alt')
;

INSERT INTO cedna.dbo.Operacion (nombre,titulo,icono,grupoId,orden) VALUES 
('Configuracion Tipo Pregunta','Configuración Tipo Pregunta','',NULL,1)
,('Configuracion Tipo Pregunta - Alta','Configuración Tipo Pregunta - Alta','fas fa-plus',1,1)
,('Configuracion Tipo Pregunta - Edicion','Configuración Tipo Pregunta - Edición','fas fa-pencil-alt',1,2)
,('Configuracion Tipo Pregunta - Borrar','Configuración Tipo Pregunta - Borrar','fas fa-trash-alt',1,3)
;

INSERT INTO cedna.dbo.Perfiles (Descripcion,Nombre) VALUES 
('Es el administrador del sistema','Administrador')
,('Ingeniero en Seguridad e Higiene','Ingeniero S&H')
,('Encargado de pedir los permisos','Contratista')
,('Contador de la empresa','Contador')
,('Puede ser cualquier usuario','Solicitante')
;

DELETE FROM UsuariosxPerfiles;
DBCC CHECKIDENT ('UsuariosxPerfiles', RESEED, 0);
DELETE FROM Usuarios;
DBCC CHECKIDENT ('Usuarios', RESEED, 0);

INSERT INTO cedna.dbo.OperacionAccionPerfil (IdOperacion,IdAccion,IdPerfil,jsFunction,urlDestino,ordenUbicacion,idHTMLElement) VALUES 
(1,1,1,'','configuracion',1,'')
,(1,4,1,'','configuracion/tipo-pregunta/alta',9,'')
,(1,6,1,'preEditar()','',6,'botonEditar')
,(1,5,1,'preBorrar()','',7,'botonBorrar')
,(2,1,1,'','configuracion/tipo-pregunta',1,'')
,(2,2,1,'preSubmit()','',9,'botonGuardar')
,(3,1,1,'','configuracion/tipo-pregunta',1,'')
,(3,2,1,'preSubmit()','',9,'botonGuardar')
;

INSERT INTO cedna.dbo.Usuarios (NombreUsuario,Clave,FechaAlta,Email,Nombre,Apellido,AceptaTerminosUso,Bloqueado) 
VALUES ('admin','$2y$10$VuNdI4sPa8liiovK3JUPJuK3D4HO2Pc/tdmDpZ6xu4Fb6oxECFOJa','2019-02-19','juanom.07@gmail.com','Juan Ignacio','Martel',NULL,NULL);

INSERT INTO cedna.dbo.UsuariosxPerfiles (IdUsuario,IdPerfil) 
VALUES (1,1);