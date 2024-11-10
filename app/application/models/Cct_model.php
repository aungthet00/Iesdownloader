<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cct_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_all_ccts()
	{
		$this->db->order_by('cct');
		return $this->db->get('cct')->result_array();
	}

	public function get_cct($id)
	{
		return $this->db->get_where('cct', array('id' => $id))->row_array();
	}

} 
