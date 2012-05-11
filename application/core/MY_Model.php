<?php

abstract class MY_Model extends CI_Model
{
	protected $_tableName;

	public function getTableName()
	{
		return $this->_tableName;
	}

	public function findById($id)
	{
		$query = $this->db->get_where(
			$this->getTableName(),
			array('id' => $id)
		);

		if ($query) {
			return $query->row(0, get_class($this));
		}
		return false;
	}

	public function findAll()
	{
		$fields = $this->db->list_fields($this->getTableName());
		if (in_array('order', $fields)) {
			$this->db->order_by('order');
		} else {
			$this->db->order_by('id');
		}

		$query = $this->db->get($this->getTableName());

		return $query->result(get_class($this));
	}

	public function toArray()
	{
		$array = array();
		foreach ($this->db->list_fields($this->_tableName) as $field) {
			$array[$field] = $this->{$field};
		}
		return $array;
	}

	public function setColumns($data)
	{
		foreach ($this->db->list_fields($this->_tableName) as $field) {
			if (isset($data[$field])) {
				$this->{$field} = $data[$field];
			}
		}

		return $this;
	}

	public function insert($data)
	{
		$data['created_at'] = standard_date('DATE_ISO8601', time());
		if ($this->db->insert($this->getTableName(), $data)) {
			return $this->db->insert_id();
		}
		return false;
	}

	public function update($id, $data)
	{
		if (!($old = $this->findById($id))) {
			return false;
		}

		$data['updated_at'] = standard_date('DATE_ISO8601', time());
		$old->setColumns($data);

		return $this->db->update($this->getTableName(), $old->toArray(), array('id' => $id));
	}

	public function delete($id)
	{
		return $this->db->delete($this->_tableName, array('id' => $id));
	}

}
