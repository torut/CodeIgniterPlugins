<?php

abstract class MY_Controller extends CI_Controller
{
	protected $_title = '';
	protected $_description = '';

	protected $_tplName = '';
	protected $_params = array();

	protected $_error = null;
	protected $_notice = null;

	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper(array('form', 'url', 'date', 'htmlspecialchars'));
		$this->load->library(array('layout', 'session'));

		$this->_tplName = implode('/', array(
									  $this->router->class,
									  $this->router->method,
		));
	}

	protected function _render($content = '')
	{
		if (empty($content)) {
			$content = $this->load->view($this->_tplName, $this->_params, true);
		}

		$this->layout
			->write('title', $this->_title)
			->write('description', $this->_description)
			->write('content', $content)
			->write('error', $this->_error)
			->write('notice', $this->_notice)
			->render();
	}

	protected function getMethod()
	{
		return $_SERVER['REQUEST_METHOD'];
	}

	protected function isPost()
	{
		if ($this->getMethod() == 'POST') {
			return true;
		}
		return false;
	}

	protected function isGet()
	{
		if ($this->getMethod() == 'GET') {
			return true;
		}
		return false;
	}

	protected function setError($err)
	{
		$this->_error = $err;
	}

	protected function setNotice($err)
	{
		$this->_notice = $err;
	}

}

