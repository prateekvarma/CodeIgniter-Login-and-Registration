<?php

class Auth extends CI_Controller {

	public function login(){

			$this->form_validation->set_rules('inputEmail', 'Email', 'required');
			$this->form_validation->set_rules('inputPassword', 'Password', 'required');

			if ($this->form_validation->run() === TRUE)
            {

            	$email = $_POST['inputEmail'];
            	$password = md5($_POST['inputPassword']);

            	$this->db->select('*');
            	$this->db->from('users');
            	$this->db->where(array('email' => $email, 'password' => $password));
            	
            	$query = $this->db->get();

            	$returned_user = $query->row();

            	if($returned_user->email) {
            		$this->session->set_flashdata("success", "You are logged in!");

            		$_SESSION['user_logged'] = TRUE;
            		$_SESSION['name'] = $returned_user->name;

            		redirect("users/profile", "refresh");
            	}

            	else{
            		$this->session->set_flashdata("error", "Credentials do not match");
            		redirect("users/profile", "refresh");
            	}
            }

		$this->load->view('users/login');
	}

	public function registration(){

		
			$this->form_validation->set_rules('inputName', 'name field', 'required');
			$this->form_validation->set_rules('inputEmail', 'email field', 'required');
			$this->form_validation->set_rules('inputPhone', 'phone field', 'required');
			$this->form_validation->set_rules('inputPassword', 'password field', 'required');
		

		if ($this->form_validation->run() === TRUE)
            {
                

                $data = array(
                	'name' => $_POST['inputName'],
                	'email' => $_POST['inputEmail'],
                	'phone' => $_POST['inputPhone'],
                	'password' => md5($_POST['inputPassword']),
                	'created' => date('Y-m-d'),
                	'modified' => date('Y-m-d')
                );

                $this->db->insert('users', $data);  

                $this->session->set_flashdata("success", "You are now registered :)"); 
                redirect("auth/registration", "refresh");
        
            }
            

		$this->load->view('users/registration');
	}


	public function logout(){
		unset($_SESSION);
		redirect("auth/login", "refresh");
	}

	

}