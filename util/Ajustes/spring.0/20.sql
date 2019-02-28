ALTER TABLE Tareas
ADD IdFormulario INT NOT NULL;

ALTER TABLE Tareas
ADD CONSTRAINT FK_Tareas_Formulario FOREIGN KEY (IdFormulario)  REFERENCES Formulario (IdFormulario);

UPDATE cedna.dbo.Accion
SET icono='botonVolver zoom'
WHERE Id=1;
UPDATE cedna.dbo.Accion
SET icono='botonGuardar zoom'
WHERE Id=2;
UPDATE cedna.dbo.Accion
SET icono='fas fa-plus zoom'
WHERE Id=3;
UPDATE cedna.dbo.Accion
SET icono='botonNuevo zoom'
WHERE Id=4;
UPDATE cedna.dbo.Accion
SET icono='botonEliminar zoom'
WHERE Id=5;
UPDATE cedna.dbo.Accion
SET icono='botonEditar zoom'
WHERE Id=6;
UPDATE cedna.dbo.Accion
SET icono='botonSalir zoom'
WHERE Id=7;

-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.dbo.Operacion
SET icono='configuracion zoom'
WHERE Id=5;
UPDATE cedna.dbo.Operacion
SET icono='ordenesCompras zoom'
WHERE Id=7;
UPDATE cedna.dbo.Operacion
SET icono='permisos zoom'
WHERE Id=8;
UPDATE cedna.dbo.Operacion
SET icono='personal zoom'
WHERE Id=9;
UPDATE cedna.dbo.Operacion
SET icono='usuarios zoom'
WHERE Id=10;
UPDATE cedna.dbo.Operacion
SET icono='perfiles zoom'
WHERE Id=11;
UPDATE cedna.dbo.Operacion
SET icono='personal zoom'
WHERE Id=17;
UPDATE cedna.dbo.Operacion
SET icono='organigrama zoom'
WHERE Id=20;
UPDATE cedna.dbo.Operacion
SET icono='nodos zoom'
WHERE Id=23;
UPDATE cedna.dbo.Operacion
SET icono='perfiles zoom'
WHERE Id=24;
UPDATE cedna.dbo.Operacion
SET icono='tareas zoom'
WHERE Id=28;

INSERT INTO ajustes(script, diahora, spring, fix) VALUES ('20.sql', GETDATE ( ), 0, 20);