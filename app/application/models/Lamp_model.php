<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Lamp_model extends CI_Model
{
	private $lamp = 'lamp';
	private $group = 'group';

	public function __construct()
	{
		$this->load->database();
	}

	public function get_all_lamps()
	{
		$this->db->select($this->lamp . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->lamp);
		$this->db->join($this->group, $this->group . '.id = ' . $this->lamp . '.group_id');
		return $this->db->get()->result_array();
	}

	
	public function get_lamp($id)
	{
		$this->db->select($this->lamp . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->lamp);
		$this->db->join($this->group, $this->group . '.id = ' . $this->lamp . '.group_id');
		$this->db->where($this->lamp . '.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_lamps_by_group($group_id)
	{
		$this->db->select($this->lamp . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->lamp);
		$this->db->join($this->group, $this->group . '.id = ' . $this->lamp . '.group_id');
		$this->db->where($this->group . '.id', $group_id);
		return $this->db->get()->result_array();
	}

	public function get_lamp_categories()
	{
	    $this->db->query("SET sql_mode=(SELECT REPLACE(@@sql_mode, 'ONLY_FULL_GROUP_BY', ''));");
		return $this->db->query("SELECT * FROM `$this->lamp` GROUP BY `$this->lamp`.`lamp_cat` ORDER BY `$this->lamp`.`lamp_cat`")->result_array();
	}

	public function get_lamps_by_category($cat)
	{
		return $this->db->query("SELECT * FROM `$this->lamp` WHERE `$this->lamp`.`lamp_cat` = '$cat'")->result_array();
	}
}