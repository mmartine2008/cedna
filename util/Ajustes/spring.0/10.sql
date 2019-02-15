ALTER TABLE OperacionAccionPerfil
DROP COLUMN controllerName;

ALTER TABLE OperacionAccionPerfil
DROP COLUMN controllerAction;

ALTER TABLE OperacionAccionPerfil
ADD ordenUbicacion INT NOT NULL DEFAULT 1;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('10.sql', GETDATE ( ), 0, 10);