<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cri_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_all_cris()
	{
		$this->db->order_by('cri');
		return $this->db->get('cri')->result_array();
	}

	public function get_cri($id)
	{
		return $this->db->get_where('cri', array('id' => $id))->row_array();
	}
} 
