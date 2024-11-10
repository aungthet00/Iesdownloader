<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fixture_model extends CI_Model
{
	private $fixture = 'fixture';
	private $group = 'group';

	public function __construct()
	{
		$this->load->database();
	}

	public function get_all_fixtures()
	{
		$this->db->select($this->fixture . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->fixture);
		$this->db->join($this->group, $this->group . '.id = ' . $this->fixture . '.group_id');
		return $this->db->get()->result_array();
	}

	public function get_fixture($id)
	{
		$this->db->select($this->fixture . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->fixture);
		$this->db->join($this->group, $this->group . '.id = ' . $this->fixture . '.group_id');
		$this->db->where($this->fixture . '.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_fixtures_by_group($group_id)
	{
		$this->db->select($this->fixture . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->fixture);
		$this->db->join($this->group, $this->group . '.id = ' . $this->fixture . '.group_id');
		$this->db->where($this->group . '.id', $group_id);
		return $this->db->get()->row_array();
	}

	public function get_compatible_fixtures($lamp_id)
	{
		$query = $this->db->query("
			SELECT `fixture`.* FROM `compatibility`
			JOIN `fixture` 
			ON `fixture`.`id` = `compatibility`.`fixture_id`
			WHERE `compatibility`.`lamp_id` = '" . $lamp_id . "'
		");

		return $query->result_array();
	}

	public function get_compatible_cri_cct($lamp_id)
	{
		$lamp = $this->db->query("
			SELECT * FROM `lamp` 
			WHERE `lamp`.`id` = '" . $lamp_id . "'
		")->row_array();

		if ($lamp['module_cat'] === "Single CCT" AND (!strpos($lamp['module'], 'ND+')))
		{
			$data['ccts'] = $this->db->query("SELECT * FROM cct WHERE `cct` NOT IN ('WARM DIM', 'tuneWHITE / flexiK', 'RGBW (5.5W per Channel)', 'RGBA (16W per Channel)', 'RGBW (16W per Channel)')")->result_array();
			$data['cris'] = $this->db->query("SELECT * FROM cri")->result_array();
			if ( $lamp['HP'] === '-') {
				$data['cris'] = $this->db->query("SELECT * FROM cri WHERE NOT `cri` = 'HP'")->result_array();
			}
			/* The code block you provided is part of a PHP function within a CodeIgniter model. Let's break
			down the logic: */
			// else if (is_string($lamp['HP']) && $lamp['HP'] > 0) {
			// 	$data['cris'] = $this->db->query("SELECT * FROM cri WHERE NOT `cri` = 'HP'")->result_array();	
			// }
			return $data;
		}

		if ($lamp['module_cat'] === "Single CCT" AND strpos($lamp['module'], 'ND+'))
		{
			$data['ccts'] = $this->db->query("SELECT * FROM `cct` WHERE `cct` IN ('2700K', '3000K', '3500K')")->result_array();
			$data['cris'] = $this->db->query("SELECT * FROM `cri` WHERE `cri` LIKE '%CRI95%'")->result_array();
			return $data;
		}

		if ($lamp['module_cat'] === "WD")
		{
			$data['ccts'] = $this->db->query("SELECT * FROM `cct` WHERE `cct` = 'WARM DIM'")->result_array();
			$data['cris'] = $this->db->query("SELECT * FROM `cri` WHERE `cri` LIKE '%CRI95%'")->result_array();
			return $data;
		}

		if ($lamp['module_cat'] === "TW-FK")
		{
			$data['ccts'] = $this->db->query("SELECT * FROM `cct` WHERE `cct` = 'tuneWHITE / flexiK'")->result_array();
			$data['cris'] = $this->db->query("SELECT * FROM `cri` WHERE `cri` LIKE '%CRI95%'")->result_array();
			return $data;
		}
		return null;
	}
}
