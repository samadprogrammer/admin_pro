<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Admin extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('admin_model');
    }
    public function index(){
        $data['title'] = 'Home | Admin & Procurement';
        $data['body'] = 'admin/dashboard';
        $this->load->view('admin/commons/template', $data);
    }
}
