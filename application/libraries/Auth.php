<?php

class Auth
{
	private $_ci;

	private $_tableName   = 'operators';
	private $_identityCol = 'username';
	private $_passwordCol = 'password';

	private $_authKey = '';

	public function __construct()
	{
        $this->_ci = get_instance();
		$this->_authKey = 'SECRET_KEY';
	}

	public function autholize()
	{
		if (!$row = $this->findByIdentity($this->_ci->input->post($this->_identityCol))) {
			return false;
		}
		
		$hash = $this->hashPassword(
			$this->_ci->input->post($this->_passwordCol),
			$row->password
		);
		if ($hash != $row->password) {
			return false;
		}

		$this->_ci->load->library('session');
		$this->_ci->session->set_userdata(
			$this->_authKey,
			$row->{$this->_identityCol}
		);

		return $row;
	}

	public function isAutholized()
	{
		$this->_ci->load->library('session');
		if (!$identity = $this->_ci->session->userdata($this->_authKey)) {
			return false;
		}

		if ($row = $this->findByIdentity($identity)) {
			$this->_ci->session->set_userdata(
				$this->_authKey,
				$row->{$this->_identityCol}
			);
			return $row;
		}

		return false;
	}

	public function logout()
	{
		$this->_ci->load->library('session');
		$this->_ci->session->unset_userdata(
			array(
				$this->_authKey => null,
			)
		);

		return true;
	}

	public function hashPassword($str, $salt = null, $saltLength = 16)
	{
		if ($salt == null) {
			$char  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$char .= 'abcdefghijklmnopqrstuvwxyz';
			$char .= '0123456789';
			$char .= '+/';
			$charLength = strlen($char) - 1;

			$salt = '';

			for ($i = 0; $i < $saltLength; $i++) {
				$salt .= $char[mt_rand(0, $charLength)];
			}
			
			$salt = bin2hex(base64_decode($salt));
		}

		$salt = substr($salt, 0, $saltLength);
		$hash = $salt . sha1($salt . $str . $salt);

		return $hash;
	}

	public function findByIdentity($value)
	{
		$this->_ci->load->database();
		$query = $this->_ci->db->get_where(
			$this->_tableName,
			array(
				$this->_identityCol => $value,
			)
		);

		if ($row = $query->row(0)) {
			return $row;
		}

		return false;
	}
}
