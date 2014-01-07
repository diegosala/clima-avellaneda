<?php

abstract class ArchiveController extends BaseController {
        protected $layout = 'layouts.archive';

        abstract protected function getDatePickerFormat($php = false);
	protected function getMinDate() {
		$d = Day::min('date');		
		return date($this->getDatePickerFormat(true), strtotime($d));
	}

	protected function getMaxDate() {
		$d = Day::max('date');
                return date($this->getDatePickerFormat(true), strtotime($d));
	}

	protected function setUpdatePicker($view, $default_date = false) {
                $max_date = $this->getMaxDate();

                if (!$default_date)
                        $default_date = $max_date;
                $view->with('min_date', $this->getMinDate());
                $view->with('max_date', $max_date);
                $view->with('datepicker_format', $this->getDatePickerFormat());
                $view->with('current_date', $default_date);
		$view->with('avoid_date', date(str_replace(array('m', 'd'), array('n', 'j'), $this->getDatePickerFormat(true)), strtotime($default_date)));

                return $view;
        }
}
