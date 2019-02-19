-- @id_transicion int, @id_tramitetarea int, @id_resultado int, @es_valido bit output
SET @es_valido = 0
DECLARE 
		@CodigoTipoManifiesto int
		,@idManifiesto int 
		,@cod_tarea_actual int

SELECT 
	@idManifiesto = m.IdManifiesto ,
	@CodigoTipoManifiesto = tm.codigo,
	@cod_tarea_actual = tar.cod_tarea
FROM 
	ENG_Tramites_Tareas_Manifiesto tt_man
	INNER JOIN ENG_Tramites_Tareas tt ON tt_man.id_tramitetarea = tt.id_tramitetarea
	INNER JOIN ENG_Tareas tar ON tt.id_tarea = tar.id_tarea
	INNER JOIN Manifiestos m ON tt_man.IdManifiesto = m.IdManifiesto
	INNER JOIN TipoManifiestos tm ON m.IdTipoManifiesto = tm.IdTipoManifiesto
WHERE 
	tt_man.id_tramitetarea = @id_tramitetarea
	
IF @CodigoTipoManifiesto  <> 1
BEGIN
	DECLARE @tmpTareas TABLE(id_tramitetarea int,cod_tarea int )

	INSERT INTO @tmpTareas(id_tramitetarea, cod_tarea)
	SELECT 
		tt.id_tramitetarea,
		tar.cod_tarea
	FROM
		ENG_Tramites_Tareas tt
		INNER JOIN ENG_Tramites_Tareas_Manifiesto tt_man ON tt.id_tramitetarea = tt_man.id_tramitetarea
		INNER JOIN ENG_Tareas tar ON tt.id_tarea = tar.id_tarea
	WHERE
		tt_man.IdManifiesto = @idManifiesto
		AND tar.cod_tarea = 2
		AND tt_man.id_tramitetarea <> @id_tramitetarea	-- que no sea la tarea en que estoy parado
        AND tt.FechaInicio_tramitetarea >= ALL(SELECT tt2.FechaInicio_tramitetarea FROM ENG_Tramites_Tareas tt2
                WHERE tt2.IdUsuarioAsignado_tramitetarea = tt.IdUsuarioAsignado_tramitetarea)

	INSERT INTO @tmpTareas(id_tramitetarea, cod_tarea)
	SELECT TOP 1
		tt.id_tramitetarea,
		tar.cod_tarea
	FROM
		ENG_Tramites_Tareas tt
		INNER JOIN ENG_Tramites_Tareas_Manifiesto tt_man ON tt.id_tramitetarea = tt_man.id_tramitetarea
		INNER JOIN ENG_Tareas tar ON tt.id_tarea = tar.id_tarea
	WHERE
		tt_man.IdManifiesto = @idManifiesto
		AND tar.cod_tarea = 3
		AND tar.cod_tarea <> @cod_tarea_actual	-- que no sea la tarea en que estoy parado
	ORDER BY tt.FechaInicio_tramitetarea DESC

	INSERT INTO @tmpTareas(id_tramitetarea, cod_tarea)
	SELECT TOP 1
		tt.id_tramitetarea,
		tar.cod_tarea
	FROM
		ENG_Tramites_Tareas tt
		INNER JOIN ENG_Tramites_Tareas_Manifiesto tt_man ON tt.id_tramitetarea = tt_man.id_tramitetarea
		INNER JOIN ENG_Tareas tar ON tt.id_tarea = tar.id_tarea
	WHERE
		tt_man.IdManifiesto = @idManifiesto
		AND tar.cod_tarea = 4
		AND tar.cod_tarea <> @cod_tarea_actual	-- que no sea la tarea en que estoy parado
	ORDER BY tt.FechaInicio_tramitetarea DESC

    INSERT INTO @tmpTareas(id_tramitetarea, cod_tarea)
	SELECT TOP 1
		tt.id_tramitetarea,
		tar.cod_tarea
	FROM
		ENG_Tramites_Tareas tt
		INNER JOIN ENG_Tramites_Tareas_Manifiesto tt_man ON tt.id_tramitetarea = tt_man.id_tramitetarea
		INNER JOIN ENG_Tareas tar ON tt.id_tarea = tar.id_tarea
	WHERE
		tt_man.IdManifiesto = @idManifiesto
		AND tar.cod_tarea = 5
		AND tar.cod_tarea <> @cod_tarea_actual	-- que no sea la tarea en que estoy parado
	ORDER BY tt.FechaInicio_tramitetarea DESC

	IF NOT EXISTS(
	SELECT 1 
	FROM 
		@tmpTareas tmp
		INNER JOIN ENG_Tramites_Tareas tt ON tmp.id_tramitetarea = tt.id_tramitetarea
	WHERE
		(tt.FechaCierre_tramitetarea IS NULL OR tt.id_resultado <> 2)
	)
	BEGIN
		IF NOT EXISTS(
			SELECT 1 
			FROM 
			TransportesManifiesto tm
			INNER JOIN DetalleTransportista dt ON tm.IdDetalleTransportista = dt.IdDetalleTransportista
		WHERE 
			dt.IdManifiesto = @idManifiesto
            AND dt.IdChofer IS NOT NULL
		)
		BEGIN
			SET @es_valido = 1
		END
	END		
END