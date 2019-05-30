ALTER TABLE dbo.Nodos
    ADD CONSTRAINTS FK_Nodos_NodoSuperior FOREIGN KEY (IdNodoSuperior) REFERENCES Nodos (IdNodo);

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('18.sql', GETDATE ( ), 1, 18);