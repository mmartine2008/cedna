ALTER TABLE cedna.dbo.Planificaciones ADD CONSTRAINT FK_Planificacion_Relevamiento FOREIGN KEY (IdRelevamiento) REFERENCES cedna.dbo.Relevamientos(IdRelevamiento) ;

DROP TABLE cedna.dbo.RiesgosAdicionalesAltura;

DROP TABLE cedna.dbo.RiesgosAdicionalesFrio;

EXEC cedna.sys.sp_rename 'cedna.dbo.RiesgosAdicionalesCalor' , 'RiesgosAdicionales', 'OBJECT' ;

INSERT INTO cedna.dbo.NotificacionesXPerfil (IdTipoEvento,IdPerfil)
VALUES (7,3) ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('23.sql', GETDATE ( ), 1, 23);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('24.sql', GETDATE ( ), 1, 24);
