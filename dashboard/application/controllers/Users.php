<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model', 'user');
	}

	public function index()
	{
		if (is_logged_in()) {
			redirect('elr/groups');
		}
		else
		{
			redirect('users/login');
		}
	}

	public function login()
	{
		if (is_logged_in()) redirect('elr/groups');

		$this->load->library('form_validation');

		$data['title'] = 'Login User';
		
		$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
		$this->form_validation->set_rules("password", "Password", "trim|required|min_length[6]");

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view("template/header", $data);
			$this->load->view("users/login", $data);
			$this->load->view("template/footer");
		}
		else
		{
			$user = $this->user->read_by_email($this->input->post('email'));
			if ($user)
			{
				$password = $user['password'];
				if($password == gen_password($this->input->post('password')))
				{
					$this->session->set_userdata('uid', $user['id']);
					$this->session->set_userdata('isadmin', $user['is_admin']);
					$this->session->set_userdata('currentuser', ucwords($user['fname'] . ' ' . $user['lname']));
					$this->session->set_flashdata('userloggedin', ucfirst($user['fname']) . ' is successfully logged in.');
					redirect('elr/groups');
				}
				else
				{
					$this->session->set_flashdata('incorrectpassword', 'You entered wrong password');
					redirect('users/login');
				}
			}
			else
			{
				$this->session->set_flashdata('usernotfound', 'User is not found on the system');
				redirect('users/login');
			}
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
}
