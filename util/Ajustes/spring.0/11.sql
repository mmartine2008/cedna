ALTER TABLE OperacionAccionPerfil
DROP COLUMN controllerName;

ALTER TABLE OperacionAccionPerfil
DROP COLUMN controllerAction;

ALTER TABLE OperacionAccionPerfil
ADD ordenUbicacion INT NOT NULL DEFAULT 1;

ALTER TABLE OperacionAccionPerfil
ADD idHTMLElement varchar(25);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('11.sql', GETDATE ( ), 0, 11);