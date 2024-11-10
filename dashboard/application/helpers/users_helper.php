<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function is_logged_in()
{
	$CI =& get_instance();
	if($CI->session->userdata('uid')) 
	{
		return $CI->session->userdata('uid');
	}
	return FALSE;
}

function is_admin()
{
	$CI =& get_instance();
	return $CI->session->userdata('isadmin');
}

function gen_password($password)
{
	$mdhash = md5($password);
	return hash('sha256', $password . $mdhash);
}

function is_compatible($lamp_id,$fixture_id,$accessory_id){

	$CI =& get_instance();
	$row = $CI->db->query("SELECT id FROM compatibility WHERE lamp_id = $lamp_id AND fixture_id = $fixture_id AND 
		FIND_IN_SET('$accessory_id',accessory_ids)")->row();
	
	if($row){
		return true;
	}

	return false;
}

function get_factor($group_id,$x_value,$y_value){

	$CI =& get_instance();
	$row = $CI->db->query("SELECT factor FROM angle WHERE group_id = $group_id AND x_value = $x_value AND y_value = $y_value")->row();

	if($row){
		return $row->factor;
	}
	
	return '';
	

}
