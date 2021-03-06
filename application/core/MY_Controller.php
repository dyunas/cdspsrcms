<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('login/Login_model', 'login');
		$this->Is_logged_in();
		$this->Check_user_type();
	}

	public function Is_logged_in()
	{
		// check if there is a valid session
		if ($this->session->userdata('is_in'))
		{
			$is_valid_sess = $this->login->check_user_credentials($this->session->userdata('uname'));
			if ($is_valid_sess)
			{
				return isset($is_valid_sess);
			}
			else
			{
				$this->session->sess_destroy();
				redirect(site_url('login'));
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'Please log-in to access the system');
			redirect(site_url('login'));
		}
	}

	public function Check_user_type()
	{
		$role = $this->login->get_user_role($this->session->userdata('role'));
		if ($this->uri->segment(1) != $role)
		{
			redirect(site_url($role.'/dashboard'));
		}
	}
}
