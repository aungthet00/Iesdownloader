<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Candela_model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function get_candela_values_by_lamp_group($group_id)
	{
		return $this->db->get_where('candelavalue', array('lamp_group_id' => $group_id))->result_array();
	}
} 
