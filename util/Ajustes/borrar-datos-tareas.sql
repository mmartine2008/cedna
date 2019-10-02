-- Script que borra todos los datos que se generan a partir
-- de la creacion de una nueva tarea/orden de compra

DELETE FROM NodosFirmantesRelevamiento;
DBCC CHECKIDENT ('NodosFirmantesRelevamiento', RESEED, 0);
DELETE FROM Planificaciones;
DBCC CHECKIDENT ('Planificaciones', RESEED, 0);
DELETE FROM Respuesta;
DBCC CHECKIDENT ('Respuesta', RESEED, 0);
DELETE FROM RelevamientosxSecciones;
DBCC CHECKIDENT ('RelevamientosxSecciones', RESEED, 0);
DELETE FROM Relevamientos;
DBCC CHECKIDENT ('Relevamientos', RESEED, 0);
DELETE FROM Tareas;
DBCC CHECKIDENT ('Tareas', RESEED, 0);
DELETE FROM OrdenesDeCompra;
DBCC CHECKIDENT ('OrdenesDeCompra', RESEED, 0);