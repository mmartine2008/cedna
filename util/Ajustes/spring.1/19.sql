UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/secciones/alta-seccion',IdOperacion=1067
WHERE Id=1225 ;

UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/secciones',IdOperacion=1067
WHERE Id=1228 ;


-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/secciones',IdOperacion=1068
WHERE Id=1231 ;

-- Actual parameter values may differ, what you see is a default string representation of values
UPDATE cedna.app.OperacionAccionPerfil
SET urlDestino='configuracion/secciones/alta-pregunta'
WHERE Id=1241 ;


DELETE FROM cedna.app.Operacion
WHERE Id=1064 ;
DELETE FROM cedna.app.Operacion
WHERE Id=1065 ;
DELETE FROM cedna.app.Operacion
WHERE Id=1066 ;
