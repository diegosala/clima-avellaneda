DROP PROCEDURE IF EXISTS;
CREATE PROCEDURE `sp_archive`(IN `p_current_date_period` BIGINT)
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
DECLARE ARCHIVE_YEAR BIGINT;
DECLARE ARCHIVE_MONTH BIGINT;
DECLARE ARCHIVE_DAY BIGINT;

DECLARE finished INTEGER DEFAULT 0;
DECLARE prev_dt DATETIME DEFAULT '2000-01-01 00:00:00';
DECLARE dt DATETIME DEFAULT '2001-01-01 00:00:00';
DECLARE avg_t DECIMAL (5,2);
DECLARE max_t DECIMAL (5,2);
DECLARE min_t DECIMAL (5,2);
DECLARE avg_h DECIMAL (3,1);
DECLARE avg_ws DECIMAL (3,1);
DECLARE max_wg INTEGER;
DECLARE wd SMALLINT (5);
DECLARE wd_count SMALLINT;
DECLARE sum_r DECIMAL (3,1);

DECLARE crsr_live CURSOR FOR 
	SELECT date_period, avg(temperature), max(temperature), min(temperature), avg(humidity), avg(wind_speed), max(wind_gust), sum(rain)
	FROM live 
	WHERE date_period < date_period(FROM_UNIXTIME(p_current_date_period)) AND archived = 0
	GROUP BY date_period
	ORDER BY 1 ASC;	
	
DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

OPEN crsr_live;

get_live: LOOP
	-- Cargar datos del cursor
	FETCH crsr_live INTO dt, avg_t, max_t, min_t, avg_h, avg_ws, max_wg, sum_r;
	IF finished = 1 THEN 
		LEAVE get_live;
	END IF;
	
	-- Determinar direccion dominante para el juego de datos agrupados en esta fila del cursor
	SELECT count(*), wind_direction
	INTO wd_count, wd
	FROM live
	WHERE date_period = dt
	ORDER BY count(*) DESC
	LIMIT 1;	
	
	-- Si cambio la fecha
	IF date(prev_dt) != date(dt) THEN
		-- y archive_day esta seteado (segundo o posterior dia procesado)
		IF archive_day IS NOT NULL THEN
			-- actualizar sumario del dia
			CALL sp_day_update(archive_day);	
		END IF;
		
		-- y archive_month esta seteado (segundo o posterior mes procesado)
		IF month(prev_dt) != month(dt) THEN
			IF archive_month IS NOT NULL THEN
				-- actualizar sumario del mes
				CALL sp_month_update(archive_month);
			END IF;
		END IF;

		-- y archive_year esta seteado (segundo o posterior año procesado)		
		IF year(prev_dt) != year(dt) THEN
			IF archive_year IS NOT NULL THEN
				-- actualizar sumario del año
				CALL sp_year_update(archive_year);
			END IF;
		END IF;
	
		-- Cargar identificadores de año, mes y dia
		SET archive_year = (SELECT id FROM years y WHERE y.id = year(dt));
		SET archive_month = (SELECT id FROM months m WHERE archive_year IS NOT NULL AND m.month = month(dt) and m.year_id = archive_year);
		SET archive_day = (SELECT id FROM days d WHERE archive_month IS NOT NULL AND d.month_id = archive_month and d.date = date(dt));
	END IF;
	
	SET prev_dt = dt;
	
	-- Si el año no existe
	IF archive_year IS NULL THEN
		-- Insertar (relleno con datos ficticios)
		INSERT INTO years (id, max_temperature, max_temperaure_date, min_temperature, min_temperaure_date, avg_temperature, avg_humidity, max_windgust, max_windgust_date, avg_windspeed, sum_rain)
		VALUES (year(dt), max_t, date(dt), min_t, date(dt), avg_t, avg_h, max_wg, date(dt), avg_ws, sum_r);
		
		SET archive_year = year(dt);
	END IF;
	
	-- Si el mes no existe
	IF archive_month IS NULL THEN
		-- Insertar (relleno con datos ficticios)
		INSERT INTO months(year_id, month, max_temperature, max_temperaure_date, min_temperature, min_temperaure_date, avg_temperature, avg_humidity, max_windgust, max_windgust_date, avg_windspeed, sum_rain)
		VALUES (year(dt), month(dt), -100, date(now()), 100, date(now()), 0, 0, 0, date(now()), 0, 0);
		
		SET archive_month = LAST_INSERT_ID();
	END IF;
	
	-- Si el dia no existe
	IF archive_day IS NULL THEN
		-- Insertar (relleno con datos ficticios)
		INSERT INTO days(date, month_id, max_temperature, max_temperaure_time, min_temperature, min_temperaure_time, avg_temperature, avg_humidity, max_windgust, max_windgust_time, avg_windspeed, sum_rain)
		VALUES (date(dt), archive_month, -100, time(now()), 100, time(now()), 0, 0, 0, time(now()), 0, 0);
		
		SET archive_day = LAST_INSERT_ID();
	END IF;
	
	-- Archivar datos tomados en el cursor
	INSERT INTO archive(day_id, time, temperature, humidity, wind_gust, wind_speed, wind_direction, rain)
	VALUES (archive_day, time(dt), avg_t, avg_h, max_wg, avg_ws, wd, sum_r);
END LOOP get_live;
CLOSE crsr_live;

-- Actualizar ultimo día, mes y año leido del cursor
CALL sp_day_update(archive_day);
CALL sp_month_update(archive_month);
CALL sp_year_update(archive_year);

UPDATE live SET archived = 1 WHERE date_period < date_period(FROM_UNIXTIME(p_current_date_period));

END