<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accessory_model extends CI_Model
{
	private $accessory = 'accessory';
	private $group = 'group';

	public function __construct()
	{
		$this->load->database();
	}

	public function get_all_accessories()
	{
		$this->db->select($this->accessory . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->accessory);
		$this->db->join($this->group, $this->group . '.id = ' . $this->accessory . '.group_id');
		$this->db->order_by('accessory');
		return $this->db->get()->result_array();
	}

	public function get_accessory($id)
	{
		$this->db->select($this->accessory . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->accessory);
		$this->db->join($this->group, $this->group . '.id = ' . $this->accessory . '.group_id');
		$this->db->where($this->accessory . '.id', $id);
		return $this->db->get()->row_array();
	}

	public function get_accessories_by_group($group_id)
	{
		$this->db->select($this->accessory . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->accessory);
		$this->db->join($this->group, $this->group . '.id = ' . $this->accessory . '.group_id');
		$this->db->where($this->group . '.id', $group_id);
		return $this->db->get()->row_array();
	}

	public function get_accessories_by_ids($ids)
	{
		$this->db->select($this->accessory . '.*, ' . $this->group . '.horizontal_angles, ' . $this->group . '.vertical_angles');
		$this->db->from($this->accessory);
		$this->db->join($this->group, $this->group . '.id = ' . $this->accessory . '.group_id');
		$this->db->where_in($this->accessory . '.id', $ids);
		$this->db->order_by('accessory');
		return $this->db->get()->result_array();
	}

	public function get_compatible_accessories($lampid, $fixtureid)
	{
		$accessory_ids = $this->db->query("
			SELECT `accessory_ids`
			FROM `compatibility`
			WHERE `lamp_id` = '" . $lampid . "'
			AND `fixture_id` = '" . $fixtureid . "'
		")->row_array();

		$accessories = $this->db->query("
			SELECT * FROM `accessory`
			WHERE FIND_IN_SET(`id`, '" . $accessory_ids['accessory_ids'] . "')
			ORDER BY `accessory`
		")->result_array();
		return $accessories;
	}
}
