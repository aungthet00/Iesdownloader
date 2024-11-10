<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Elr extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ( ! is_logged_in()) {
			redirect('users/login');
		}
		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}

	public function elr_ouput($output = null)
	{
		$this->load->view('template/header', (array)$output);
		$this->load->view('elr',(array)$output);
		$this->load->view('template/footer');
	}


	public function index()
	{
		redirect('elr/lamps');
	}

	public function lamps()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('lamp');
		$crud->set_subject('Lamp');

		$crud->columns('group_id', 'module', 'category', 'module_cat', 'lumens', 'power', 'width', 'length', 'height', 'factor','PA','lumens_PA','HP','lumens_HP','PA_98','lumens_PA98');

		$crud->required_fields('group_id', 'module', 'category', 'lumens', 'power', 'width', 'length', 'height', 'factor', 'module_cat', 'lamp_cat');

		$crud->display_as('group_id', 'Group');

		$crud->set_relation('group_id', 'group', '{id} - {title}', '`group_type` = ' . "'l'");			

		$crud->change_field_type('module_cat', 'enum', ['Single CCT','WD','TW-FK','RGBW (5.5W per Channel)','RGBA (16W per Channel)','RGBW (16W per Channel)']);

		$crud->unset_fields('created_at', 'updated_at');

		$output = $crud->render();

		$output->page_title = 'Lamps';

		$this->elr_ouput($output);
	}

	public function groups()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('group');
		$crud->set_subject('Group');

		$crud->columns('id', 'title', 'group_type', 'vertical_angles', 'horizontal_angles');
		$crud->required_fields('title', 'group_type', 'vertical_angles', 'horizontal_angles');
		$crud->unset_fields('created_at', 'updated_at');

		$crud->display_as('fcode', 'Lens Code');
		$crud->display_as('lcode', 'Chip Code');
		$crud->callback_before_update(array($this, 'update_time'));

		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function ccts()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('cct');
		$crud->set_subject('CCT');

		$crud->columns('cct', 'factor');
		$crud->unset_fields('created_at', 'updated_at');
		$crud->required_fields('cct', 'factor');

		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function cris()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('cri');
		$crud->set_subject('CRI');

		$crud->columns('cri', 'factor');
		$crud->required_fields('cri', 'factor');
		$crud->unset_fields('created_at', 'updated_at');

		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function fixtures()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('fixture');
		$crud->set_subject('Fixture');
		$crud->unset_columns('created_at', 'updated_at');
		$crud->unset_fields('created_at', 'updated_at');

		$crud->required_fields('group_id', 'fixture', 'category', 'width', 'length', 'height');

		$crud->display_as('group_id', 'Group');

		$crud->set_relation('group_id', 'group', '{id} - {title}', '`group_type` = ' . "'f'");
		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function accessories()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('accessory');
		$crud->set_subject('Accessory');
		$crud->unset_columns('created_at', 'updated_at');
		$crud->unset_fields('created_at', 'updated_at');

		$crud->required_fields('group_id', 'accessory');

		$crud->display_as('group_id', 'Group');

		$crud->set_relation('group_id', 'group', '{id} - {title}', '`group_type` = ' . "'a'");

		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function angles()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('angle');
		$crud->set_subject('Angle');
		$crud->unset_columns('created_at', 'updated_at');
		$crud->unset_fields('created_at', 'updated_at');
		$crud->required_fields('group_id', 'factor', 'x_value', 'y_value');

		$crud->display_as('group_id', 'Group');

		$crud->set_relation('group_id', 'group', '{id} - {group_type} - {title}', '`group_type` != ' . "'a'");
		
		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function users()
	{
		$crud = new grocery_CRUD();
		$this->load->model('user_model', 'user');
		$crud->set_theme('datatables');
		$crud->set_table('elr_user');
		$crud->set_subject('User');
		$crud->unset_columns('created_at', 'updated_at', 'password');
		$crud->required_fields('fname', 'lname', 'email', 'password', 'is_admin');
		$crud->field_type('email', 'email');
		$crud->field_type('password', 'password');

		$crud->unique_fields(array('email'));
		$crud->change_field_type('is_admin', 'true_false');
		$crud->unset_clone();
		$crud->set_rules("fname", "Firstname", "trim|required|min_length[3]");
		$crud->set_rules("lname", "Lastname", "trim|required|min_length[3]");
		$crud->set_rules("email", "Email", array('required', 'trim', 'valid_email'));
		$crud->set_rules("password", "Password", "trim|required");
		$crud->unset_fields('created_at', 'updated_at');

		$crud->callback_edit_field('password',array($this,'set_password_input_to_empty'));

		$crud->callback_before_insert(array($this, 'encrypt_password_callback'));
		$crud->callback_before_update(array($this, 'encrypt_password_and_update'));
		
		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function compatibility()
	{
		$crud = new grocery_CRUD();

		$crud->set_theme('datatables');
		$crud->set_table('compatibility');
		$crud->set_subject('Compatibility');
		$crud->unset_columns('created_at', 'updated_at');
		$crud->unset_fields('created_at', 'updated_at');
		$crud->required_fields('lamp_id');
		$crud->order_by('lamp_id');

		$crud->display_as('fixture_id', 'Fixture');

		$crud->set_relation('fixture_id', 'fixture', '{id} - {fixture}');
		$crud->set_relation('lamp_id', 'lamp', '{id} - {module}');
		
		$output = $crud->render();

		$this->elr_ouput($output);
	}

	public function compatibility_ui(){

		$this->load->view('template/header');


		$lamps = $this->db->query("SELECT id, module FROM lamp ORDER BY module")->result();
		$fixtures = $this->db->query("SELECT id, fixture FROM fixture ORDER BY fixture")->result();
		$accessories = $this->db->query("SELECT accessory.id, `group`.`title`, accessory FROM accessory INNER JOIN `group` ON accessory.group_id = group.id ORDER BY accessory")->result();

		$data["lamps"] = $lamps;
		$data["fixtures"] = $fixtures;
		$data["accessories"] = $accessories;

		

		$this->load->view('compatibility_ui',$data);
		$this->load->view('template/footer');

	}

	public function angles_new($group_id = 0){

		$this->load->view('template/header');

		$data = array();

		$groups = $this->db->query("SELECT * FROM `group` WHERE group_type = 'l' OR group_type = 'f' ")->result();

		if($group_id > 0){
			$group = $this->db->query("SELECT * FROM `group` WHERE id = $group_id")->row();
			$x_angles = $this->db->query("SELECT DISTINCT(x_value) as x_value FROM angle WHERE group_id = $group_id")->result_array();

			$y_angles = $this->db->query("SELECT DISTINCT(y_value) as y_value FROM angle WHERE group_id = $group_id")->result_array();

			$angles = $this->db->query("SELECT * FROM angle WHERE group_id = $group_id")->result_array();

			
			$data["g"] = $group;
			
			$data["x_angles"] = $x_angles;
			$data["y_angles"] = $y_angles;
			$data["angles"] = $angles;
		}

		$data["groups"] = $groups;

		$data["selected_group_id"] = $group_id;
		
		
 

		$this->load->view('angles_new',$data);
		$this->load->view('template/footer');

	}

	public function save_angles(){

		$response = array();

		header('Content-Type: text/plain');
		$all_data = utf8_encode($_POST['all_data']); // Don't forget the encoding
		$group_id = utf8_encode($_POST['group_id']); // Don't forget the encoding
		$data = json_decode($all_data,true);


		$this->db->query("DELETE FROM angle WHERE group_id = $group_id");

		
		foreach ($data as &$value) {

			//$group_id = $value['group_id'];
			$factor = $value['factor'];
			$x_value = $value['x_value'];
			$y_value = $value['y_value'];

    		$this->db->query("INSERT INTO angle (group_id, factor, x_value, y_value) VALUES ($group_id,$factor,$x_value,$y_value)");

		}

		//$row = $this->db->query("SELECT * FROM compatibility WHERE lamp_id = $lamp_id AND fixture_id = $fixture_id")->row_array();


		var_dump($data);
		


		//$response["test"] = "abc";
		//echo json_encode($response);


	}

	public function update_compatibility(){

		$lamp_id = $this->input->post("lamp_id");
		$fixture_id = $this->input->post("fixture_id");
		$accessory_id = $this->input->post("accessory_id");
		$action = $this->input->post("action");

		$row = $this->db->query("SELECT * FROM compatibility WHERE lamp_id = $lamp_id AND fixture_id = $fixture_id")->row_array();

		



		$accessories_array = explode(",",$row["accessory_ids"]);

		if($action == "add"){
			$accessories_array[] = $accessory_id;
		}
		else{

			//$accessories_array = array_diff($accessories_array, array($accessory_id));

			//unset($accessories_array[$accessory_id]);

			if (($key = array_search($accessory_id, $accessories_array, true)) !== false) {
			    unset($accessories_array[$key]);
			}


		}
		$accessories_array = array_values($accessories_array);

		$accessories_array_joined = trim(join(",",$accessories_array),",");
		
		if	(empty($accessories_array_joined)){

			$row_update = $this->db->query("UPDATE compatibility SET accessory_ids = NULL WHERE lamp_id = $lamp_id AND fixture_id = $fixture_id");
		}
		else {
			$row_update = $this->db->query("UPDATE compatibility SET accessory_ids = '$accessories_array_joined' WHERE lamp_id = $lamp_id AND fixture_id = $fixture_id");
		}



		$response["debug"] = "$action - $lamp_id - $fixture_id - $accessory_id";
		$response["accessories_array"] = $accessories_array_joined;
		$response["id_to_update"] = "btn-id-$lamp_id-$fixture_id-$accessory_id";
		$response["action"] = $action;
		

		echo json_encode($response);
	}

	function encrypt_password_callback($post_array)
	{
		$post_array['password'] = gen_password($post_array['password']);

		return $post_array;
	}

	function encrypt_password_and_update($post_array)
	{
		$post_array['password'] = gen_password($post_array['password']);
		$post_array['updated_at'] = date('Y-m-d H:i:s');

		return $post_array;
	}

	function set_password_input_to_empty()
	{
		return "<input type='password' name='password' value='' class='form-control'/>";
	}
}
