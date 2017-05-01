<?php

class Users extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();  

        if(!isset($_SESSION['user_logged'])){
            $this->session->set_flashdata("error", "You can't access this page without login");
            redirect("auth/login");
        }
    }

    public function profile(){
        $this->load->view('users/account');
    }
}