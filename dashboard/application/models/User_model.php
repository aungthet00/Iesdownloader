<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{
	private $table = 'elr_user';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function create($data)
	{
		if($this->db->insert($this->table, $data))
			return true;
		else
			return false;
	}

	public function is_unique($email)
	{
		return ($this->read_by_email($email)) ? FALSE : TRUE;
	}

	public function read($id)
	{
		return $this->db->get_where($this->table, array('id', $id))->result();
	}

	public function update($id, $data)
	{
		if($this->db->update($this->table, $data, array('id' => $id)))
			return true;
		else
			return false;
	}

	public function delete($id)
	{
		if(is_array($id))
		{
			$this->db->trans_start();
			foreach($id as $elem)
				$this->db->delete($this->table, array('id' => $elem));
			$this->db->trans_complete();
		}
		else
		{
			if($this->db->delete($this->table, array('id' => $id)))
				return true;
			else
				return false;
		}
	}

	public function listRows($limit = null, $offset = 0)
	{
		if(!is_null($limit))
			$this->db->limit($limit, $offset);
		return $this->db->get($this->table)->result();
	}

	public function read_by_email($email)
	{
		return $this->db->get_where($this->table, array('email' => $email))->row_array();
	}
}
