<?php

class Layout {

	private $_ci;

	private $_data = array();

	private $_layout;

	public function __construct($layout = 'layout/main') {
		$this->_ci = get_instance();
		$this->_layout = $layout;
	}

	public function setLayout($layout) {
		$this->_layout = $layout;
		return $this;
	}

	public function write($key, $value) {
		$this->_data[$key] = $value;
		return $this;
	}

	public function render($ret = FALSE) {
		if ($ret === TRUE) {
			$out = $this->_ci->load->view($this->_layout, $this->_data, $ret);
			return  $out;
		}
		$this->_ci->load->view($this->_layout, $this->_data);
	}
}