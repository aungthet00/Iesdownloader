<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Angle_model extends CI_Model
{
	private $angle = 'angle';
	// private $factor = 'factor';
	private $group = 'group';
	function __construct()
	{
		$this->load->database();
	}

	public function get_angles($group_id, $module)
	{
		$this->db->select($this->angle . '.*');
		$this->db->join($this->group, $this->angle . '.group_id = ' . $this->group . '.id');
		$this->db->order_by($this->angle . 'x_value, ' . $this->angle . 'y_value');
		$where = array(
			$this->angle . '.group_id' => $group_id,
			$this->group . '.group_type' => $module
		);
		return $this->db->get_where($this->angle, $where)->result_array();
	}

	public function get_horizontal_angles($group_id, $module)
	{
		$this->db->select($this->angle . '.x_value');
		$this->db->group_by('x_value');
		$this->db->join($this->group, $this->angle . '.group_id = ' . $this->group . '.id');
		$where = array(
			$this->angle . '.group_id' => $group_id,
			$this->group . '.group_type' => $module
		);
		return $this->db->get_where($this->angle, $where)->result_array();
	}

	public function get_vertical_angles_by_horizontal_group($group_id, $module, $x_value)
	{
		$this->db->select($this->angle . '.*');
		$this->db->join($this->group, $this->angle . '.group_id = ' . $this->group . '.id');

		$where = array(
			$this->angle . '.group_id' => $group_id,
			$this->group . '.group_type' => $module,
			$this->angle . '.x_value' => $x_value
		);

		$this->db->order_by($this->angle . '.y_value');
		return $this->db->get_where($this->angle, $where)->result_array();
	}
} 
