CREATE SCHEMA app;

ALTER SCHEMA app TRANSFER dbo.Accion;
ALTER SCHEMA app TRANSFER dbo.EstadoTarea;
ALTER SCHEMA app TRANSFER dbo.EstadosRelevamiento;
ALTER SCHEMA app TRANSFER dbo.Eventos;
ALTER SCHEMA app TRANSFER dbo.Opcion;
ALTER SCHEMA app TRANSFER dbo.Operacion;
ALTER SCHEMA app TRANSFER dbo.OperacionAccionPerfil;
ALTER SCHEMA app TRANSFER dbo.Perfiles;
ALTER SCHEMA app TRANSFER dbo.Pregunta;
ALTER SCHEMA app TRANSFER dbo.PreguntaGeneradora;
ALTER SCHEMA app TRANSFER dbo.PreguntaOpcion;
ALTER SCHEMA app TRANSFER dbo.Seccion;
ALTER SCHEMA app TRANSFER dbo.SeccionPregunta;
ALTER SCHEMA app TRANSFER dbo.TipoJefe;
ALTER SCHEMA app TRANSFER dbo.TipoNodo;
ALTER SCHEMA app TRANSFER dbo.TipoPlanificacion;
ALTER SCHEMA app TRANSFER dbo.TipoPregunta;
ALTER SCHEMA app TRANSFER dbo.TipoSeccion;
ALTER SCHEMA app TRANSFER dbo.TiposEvento;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('44.sql', GETDATE ( ), 0, 44);