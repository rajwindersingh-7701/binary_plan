<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Reports extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('session', 'pagination'));
        $this->load->model(array('User_model'));
        $this->load->helper(array('user', 'super'));
        if (is_logged_in() === false) {
            redirect('Dashboard/User/logout');
            exit;
        }
    }
}
