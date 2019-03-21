UPDATE cedna.dbo.TipoPregunta
SET Descripcion='file_image'
WHERE Descripcion='image' ;
UPDATE cedna.dbo.TipoPregunta
SET Descripcion='file_file'
WHERE Descripcion='file' ;

ALTER TABLE Respuesta
ADD NombreArchivo varchar(300) NULL;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('43.sql', GETDATE ( ), 0, 43);