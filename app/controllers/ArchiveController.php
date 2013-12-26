<?php

abstract class ArchiveController extends BaseController {
        protected $layout = 'layouts.archive';

        abstract protected function getDatePickerFormat();
	protected function getMinDate() {
		return Day::min('date');
	}

	protected function getMaxDate() {
		return Day::max('date');
	}

	protected function setUpDatePicker($view, $default_date = false) {
                $max_date = $this->getMaxDate();

                if (!$default_date)
                        $default_date = $max_date;
                $view->with('min_date', str_replace('-', '/', $this->getMinDate()));
                $view->with('max_date', str_replace('-', '/', $max_date));
                $view->with('datepicker_format', $this->getDatePickerFormat());
                $view->with('current_date', str_replace('-', '/', $default_date));

                return $view;
        }
}
