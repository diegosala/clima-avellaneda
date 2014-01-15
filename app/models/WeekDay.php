<?php
class WeekDay {
	public static function getSpanish($dayNumber) {
		switch ($dayNumber) {
			case 0: return "Domingo"; break;
			case 1: return "Lunes"; break;
			case 2: return "Martes"; break;
			case 3: return "Mi&eacute;rcoles"; break;
			case 4: return "Jueves"; break;
			case 5: return "Viernes"; break;
			case 6: return "S&aacute;bado"; break;
		}
	}
}
?>
