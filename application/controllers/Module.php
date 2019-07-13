<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends CI_Controller {

    function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }	

	public function index()
	{
		if($this->session->userdata('status') == TRUE)
		{
			redirect(base_url("module/beranda"));
		}

		$data 	= array(
				"BASE_URL" 			=> base_url(),
				"SITE_URL"			=> site_url(),
				"TITLE"				=> "Login | SIM808",				
		);

		$data["MESSAGES"]	= $this->session->flashdata('message');
		$this->parser->parse('signin',$data);
	}


	public function beranda()
	{
		$this->_check();//check session login

		$dist 	= $this->m_main->get('distance');
		$speed  = $this->m_main->get('data');

		$data 	= array(
				"BASE_URL" 			=> base_url(),
				"SITE_URL"			=> site_url(),
				"META_TITLE"		=> "Beranda | Iot",	
				"USERNAME"			=> $this->session->userdata('nama'),			
				"BREADCUMB"			=> "Beranda",
				"TITLE"				=> "Map Tracker",
				"TITLE_SECOND"		=> "Maps",
				"BREADCUMB_URL"		=> site_url("module/users"),
				"SUBTITLE"			=> "Edit Profile",		
				"DISTANCE"			=> ( ($dist == false) ? 0 : $dist[0]['total_distance'] ),	
				"SPEED"				=> ( ($speed == false) ? 0 : $speed[0]['speed_vehicle'] ),	
		);

		$data['CHARTS']		= $this->parser->parse('page/chart',$data,true);		
		$data['CONTENT']	= $this->parser->parse('page/beranda',$data,true);
		$data['NAVIGATION']	= $this->parser->parse('layout/navigation',$data,true);
		$data['FOOTER']		= $this->parser->parse('layout/footer',$data,true);
		$this->parser->parse('layout/main_layout',$data);
	}


	public function auth()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$where = array(
			'login_username' => $username,
			'login_password' => md5($password)
		);

		$check = $this->m_main->auth_process($where)->num_rows(); //check usernam & password database

		if($check == 1)
		{
			$data_session = array(
				'nama' => $username,
				'status' => true
			);
 
			$this->session->set_userdata($data_session); //set session data
 
			redirect(base_url("module/beranda"));
		}
		else
		{
			$msg 	= $this->_set_msg_error("username or password invalid !!!");
			$this->session->set_flashdata("message",$msg);					
			redirect(base_url("module/index"));
		}	
	}


	public function users()
	{
		$this->_check();

		$data 	= array(
				"BASE_URL" 			=> base_url(),
				"SITE_URL"			=> site_url(),
				"META_TITLE"		=> "Setting Users | Iot",
				"BREADCUMB"			=> "Form Users",
				"BREADCUMB_URL"		=> site_url("module/users"),
				"SUBTITLE"			=> "Edit Profile",			
				"SUBTITLE_SECOND"	=> "Edit Password",
				"ACTIVE"			=> "active",
		);

		$where = array('login_username' => $this->session->userdata('nama'));
		$data["MESSAGES"]	= $this->session->flashdata('message');
		$data['DATA_ENTRY']	= $this->m_main->getWhere("login","*",$where);
		$data['CONTENT']	= $this->parser->parse('page/form_user',$data,true);
		$data['NAVIGATION']	= $this->parser->parse('layout/navigation',$data,true);
		$data['FOOTER']		= $this->parser->parse('layout/footer',$data,true);
		
		$this->parser->parse('layout/main_layout',$data);
	}


	public function users_profil()
	{
		$this->_check();

		$params = array(
				"login_name" 		=> $this->input->post("login_name"),
				"login_email" 		=> $this->input->post("login_email"),
			);

        $this->form_validation->set_rules('login_name', 'nama', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('login_email', 'e-mail', 'trim|required|max_length[30]|valid_email');

		$where 		= array('login_username' => $this->session->userdata('nama'));

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_main->update("login",$params,$where);
			$msg 	= $this->_set_msg_success("Update Berhasil");
			$this->session->set_flashdata("message",$msg);		

			redirect(base_url("module/users"));
		}
		else
		{
			$msg 	= $this->_set_msg_error(validation_errors());
			$this->session->set_flashdata("message",$msg);					
			redirect(base_url("module/users"));

		}
	}


	public function users_pass()
	{
		$this->_check();

		$params = array(
				"login_password" 	=> md5($this->input->post("login_password"))
			);

        $this->form_validation->set_rules('login_password', 'nama', 'trim|required|max_length[20]|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'nama', 'trim|required|matches[login_password]');

		$where 		= array('login_username' => $this->session->userdata('nama'));

		if ($this->form_validation->run() == TRUE) 
		{
			$this->m_main->update("login",$params,$where);
			$msg 	= $this->_set_msg_success("Update Berhasil");
			$this->logout();
			redirect(base_url("module/users"));
		}
		else
		{
			$msg 	= $this->_set_msg_error(validation_errors());
			$this->session->set_flashdata("message",$msg);					
			redirect(base_url("module/users"));

		}
	}


	public function getLonLat()
	{
		$sql 	= $this->m_main->get("data");
		if ($sql != false) 
		{
			$data = array(
				"lon" 	=> $sql[0]["long_map"],
				"lat"	=> $sql[0]["lat_map"]
			);
			
			echo json_encode($data);
		}
	}


	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('module/index'));
	}



	private function _check()
	{
		if($this->session->userdata('status') != TRUE)
		{
			redirect(base_url("module/index"));
		}				
	}

	private function _set_msg_success($params)
	{
		$html = "                        
				<div class='alert alert-success'>
	                <span><b>Success:</b> ".$params." </span>
	            </div>";

		return $html;		
	}

	private function _set_msg_error($params)
	{
		$html = "                        
				<div class='alert alert-danger' style='color:red'>
	                <span>".$params." '<br>'</span>
	            </div>";

		return $html;		
	}
}
