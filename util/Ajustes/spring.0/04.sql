CREATE TABLE dbo.ajustes (
	id int IDENTITY(1,1) NOT NULL,
	script varchar(255) NULL,
	diahora datetime NULL,
	spring int NULL,
	fix int NULL,
	CONSTRAINT PK_Ajustes PRIMARY KEY (id)
) ;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('01.sql', GETDATE ( ), 0, 1);
INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('01.sql', GETDATE ( ), 0, 2);
INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('01.sql', GETDATE ( ), 0, 3);
INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('01.sql', GETDATE ( ), 0, 4);