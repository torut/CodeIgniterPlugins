<?php

require_once APPPATH . '../system/libraries/Form_validation.php';

class MY_Form_validation extends CI_Form_validation
{

	public function __construct($rules = array())
	{
		parent::__construct($rules);

		$this->set_error_delimiters('<p class="help-block">', '</p>');

		log_message('debug', "MY Form Validation Class Initialized");
	}
}
