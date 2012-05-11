<?php

class Utils
{
	private $_ci;

	public function __construct()
	{
		$this->_ci = get_instance();
	}

	public function normalize($str)
	{
		return Normalizer::normalize($str, Normalizer::FORM_KC);
	}
}
