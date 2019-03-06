CREATE TABLE OrdenesDeCompra(
	IdOrdenDeCompra INT IDENTITY(1,1),
    FechaLiberacion DATE NOT NULL,
    IdSolicitante INT NOT NULL,
    IdEjecutor INT NOT NULL,
	IdNodo INT NOT NULL,
    IdResponsable INT NOT NULL,
    IdPlanificaTarea INT NOT NULL,
	Descripcion VARCHAR(1000) NOT NULL,

	CONSTRAINT PK_OrdenesDeCompra PRIMARY KEY (IdOrdenDeCompra),  
	CONSTRAINT FK_OrdenesDeCompra_Usuarios_Solicitante FOREIGN KEY (IdSolicitante) REFERENCES Usuarios (IdUsuario), 
    CONSTRAINT FK_OrdenesDeCompra_Usuarios_Ejecutor FOREIGN KEY (IdEjecutor) REFERENCES Usuarios (IdUsuario), 
    CONSTRAINT FK_OrdenesDeCompra_Usuarios_Responsable FOREIGN KEY (IdResponsable) REFERENCES Usuarios (IdUsuario), 
    CONSTRAINT FK_OrdenesDeCompra_Usuarios_PlanificaTarea FOREIGN KEY (IdPlanificaTarea) REFERENCES Usuarios (IdUsuario), 
	CONSTRAINT FK_OrdenesDeCompra_Nodos FOREIGN KEY (IdNodo) REFERENCES Nodos (IdNodo), 
);

DELETE FROM OperacionAccionPerfil
WHERE IdOperacion = 7;

DELETE FROM Operacion
WHERE IdOperacion = 7;

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil ON;

INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(89, 6, 7, 4, '', 'logout', 11, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(90, 33, 1, 4, '', 'index', 2, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(91, 33, 7, 4, '', 'logout', 11, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(92, 33, 4, 4, '', 'ordenes-de-compra/alta', 9, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(93, 33, 6, 4, 'preEditar()', '', 6, 'botonEditar');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(94, 33, 5, 4, 'preBorrar()', '', 7, 'botonBorrar');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(95, 34, 1, 4, '', 'ordenes-de-compra', 2, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(96, 34, 7, 4, '', 'logout', 11, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(97, 34, 2, 4, 'preSubmit()', '', 9, 'botonGuardar');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(98, 35, 1, 4, '', 'ordenes-de-compra', 2, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(99, 35, 7, 4, '', 'logout', 11, '');
INSERT INTO cedna.dbo.OperacionAccionPerfil
(Id, IdOperacion, IdAccion, IdPerfil, jsFunction, urlDestino, ordenUbicacion, idHTMLElement)
VALUES(100, 35, 2, 4, 'preSubmit()', '', 9, 'botonGuardar');

SET IDENTITY_INSERT cedna.dbo.OperacionAccionPerfil Off;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('27.sql', GETDATE ( ), 0, 27);