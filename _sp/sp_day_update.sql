DROP PROCEDURE IF EXISTS sp_day_update;
CREATE PROCEDURE `sp_day_update`(IN `p_day_id` bigINT)
	LANGUAGE SQL
	NOT DETERMINISTIC
	CONTAINS SQL
	SQL SECURITY DEFINER
	COMMENT ''
BEGIN
DECLARE v_max_t DECIMAL (5,2);
DECLARE dt_max_t TIME;
DECLARE v_min_t DECIMAL (5,2);
DECLARE dt_min_t TIME;
DECLARE v_avg_t DECIMAL (5,2);
DECLARE v_avg_h DECIMAL (3,1);
DECLARE v_avg_ws DECIMAL (3,1);
DECLARE v_max_wg INTEGER;
DECLARE dt_max_wg TIME;
DECLARE v_sum_r DECIMAL (3,1);
DECLARE wd_count INT;
DECLARE wd SMALLINT(6);

SELECT temperature, time INTO v_max_t, dt_max_t FROM archive WHERE day_id = p_day_id ORDER BY temperature DESC LIMIT 0,1;
SELECT temperature, time INTO v_min_t, dt_min_t FROM archive WHERE day_id = p_day_id ORDER BY temperature ASC LIMIT 0,1;
SELECT avg(temperature) INTO v_avg_t FROM archive WHERE day_id = p_day_id;
SELECT avg(humidity) INTO v_avg_h FROM archive WHERE day_id = p_day_id;
SELECT avg(wind_speed) INTO v_avg_ws FROM archive WHERE day_id = p_day_id;
SELECT wind_gust, time INTO v_max_wg, dt_max_wg FROM archive WHERE day_id = p_day_id ORDER BY wind_gust DESC LIMIT 0,1;
SELECT sum(rain) INTO v_sum_r FROM archive WHERE day_id = p_day_id;
SELECT count(*), wind_direction INTO wd_count, wd FROM archive WHERE day_id = p_day_id ORDER BY count(*) DESC LIMIT 0,1;

UPDATE days SET
	max_temperature = CASE WHEN v_max_t >= max_temperature THEN v_max_t ELSE max_temperature END,
	max_temperaure_time = CASE WHEN v_max_t >= max_temperature THEN dt_max_t ELSE max_temperaure_time END,
	min_temperature = CASE WHEN v_min_t <= min_temperature THEN v_min_t ELSE min_temperature END,
	min_temperaure_time = CASE WHEN v_min_t <= min_temperature THEN dt_min_t ELSE min_temperaure_time END,
	avg_temperature = v_avg_t,
	avg_humidity = v_avg_h,
	max_windgust = CASE WHEN v_max_wg >= max_windgust THEN v_max_wg ELSE max_windgust END,
	max_windgust_time = CASE WHEN v_max_wg >= max_windgust THEN dt_max_wg ELSE max_windgust_time END,
	avg_windspeed = v_avg_ws,
	wind_direction = wd,
	sum_rain = v_sum_r
WHERE id = p_day_id;
	
END