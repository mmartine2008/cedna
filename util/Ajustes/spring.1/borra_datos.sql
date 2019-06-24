BEGIN TRANSACTION;

DELETE FROM HerramientasxRelevamiento;
DELETE FROM OperariosxRelevamiento;
DELETE FROM Planificaciones;
DELETE FROM Tareas;
DELETE FROM OrdenesDeCompra;
DELETE FROM RelevamientosxSecciones;
DELETE FROM Respuesta;
DELETE FROM NodosFirmantesRelevamiento;
DELETE FROM Relevamientos;


COMMIT TRANSACTION;
