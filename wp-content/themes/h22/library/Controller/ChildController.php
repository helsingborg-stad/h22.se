<?php

namespace H22\Controller;

class ChildController {
	public function __construct() {
		add_filter('Municipio/viewData', array($this, 'data'), 10, 1);
	}

	public function data($data) {
		return $data;
	}
}
