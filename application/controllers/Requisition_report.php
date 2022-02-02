<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Requisition_report extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('Requisition_Model');
        $this->load->model('API_Model');

        if(!$this->session->userdata('username')){
            redirect('');
        }
        
        $this->access['ApprovalAccess'] = $this->AccessList()["Approval"];
    }

    private function AccessList() {
        $user_role = $this->session->userdata('user_role');
        $userAccess = $this->API_Model->FetchAccessConfigs($user_role);
        return $arrayName = array('Assets' => $userAccess[0], 'Suppliers' => $userAccess[1], 'Employees' => $userAccess[2], 'Categories' => $userAccess[3], 'Register' => $userAccess[4],'Approval' => $userAccess[5],'User' => $userAccess[6]);
    }

    public function index(){
        redirect('requisitions/dashboard');
    }
// all reports code below 
public function pending_request_report(){ 
    $data['title'] = 'Reports > Reports';
    $data['body'] = 'requisitions/report/pending-request'; 
    $data['locations'] = $this->Requisition_Model->get_item_location(); 
    $data['departments'] = $this->Requisition_Model->department();
    $data['companies'] = $this->Requisition_Model->get_company();
    $data['pending_request_report'] = true;
    $data['breadcrumb'] = array("requisitions/report/pending-request" => "Pending Request");
    $this->load->view('admin/commons/new_template', $data);
} 

public function process_request_report(){ 
    $data['title'] = 'Reports > Reports';
    $data['body'] = 'requisitions/report/process-request'; 
    $data['locations'] = $this->Requisition_Model->get_item_location(); 
    $data['departments'] = $this->Requisition_Model->department();
    $data['companies'] = $this->Requisition_Model->get_company();
    $data['process_request_report'] = true;
    $data['breadcrumb'] = array("requisitions/report/process-request" => "Process Request");
    $this->load->view('admin/commons/new_template', $data);
} 

public function approved_request_report(){ 
    $data['title'] = 'Reports > Reports';
    $data['body'] = 'requisitions/report/approved-request'; 
    $data['locations'] = $this->Requisition_Model->get_item_location(); 
    $data['departments'] = $this->Requisition_Model->department();
    $data['companies'] = $this->Requisition_Model->get_company();
    $data['approved_request_report'] = true;
    $data['breadcrumb'] = array("requisitions/report/approved-request" => "Approved Request");
    $this->load->view('admin/commons/new_template', $data);
} 

public function reject_request_report(){ 
    $data['title'] = 'Reports > Reports';
    $data['body'] = 'requisitions/report/reject_request_report'; 
    $data['locations'] = $this->Requisition_Model->get_item_location(); 
    $data['departments'] = $this->Requisition_Model->department();
    $data['companies'] = $this->Requisition_Model->get_company();
    $data['reject_request_report'] = true;
    $data['breadcrumb'] = array("requisitions/report/reject-request" => "Reject Request");
    $this->load->view('admin/commons/new_template', $data);
} 
  // employee against location 
  public function city_user($loc_id){
    $location = $this->Requisition_Model->employee_against_location($loc_id);
    echo json_encode($location);
}

 // Invoices - Add invoice into the database.
 public function filter_request($offset = null){
    $data = array(
        'city' => $this->input->get('city'),
        'company' => $this->input->get('company'),
        'department' => $this->input->get('department'),
        'name' => $this->input->get('name'),
        'item' => $this->input->get('item'),
        'model' => $this->input->get('model'),
        'quantity' => $this->input->get('quantity'), 
    ); 
    $limit = 25;
    if($this->input->get('limit')) {
        $limit = $this->input->get('limit');
    }
    if(!empty($offset)){
        $config['uri_segment'] = 3;
    }
    $this->load->library('pagination');
    $url = base_url('report/filter_request');
    $rowscount = $this->Requisition_Model->request_count($limit, $offset,$data,$count = true);
    $config['base_url'] = $url;
    $config['total_rows'] = $rowscount;
    $config['per_page'] = $limit;
    $config['cur_tag_open'] = '<a class="pagination-link has-background-success has-text-white" aria-current="page">';
    $config['cur_tag_close'] = '</a>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_open'] = '</li>';
    $config['first_link'] = 'First';
    $config['prev_link'] = 'Previous';
    $config['next_link'] = 'Next';
    $config['last_link'] = 'Last';
    $config['attributes'] = array('class' => 'pagination-link');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);

    $data['title'] = 'Request Report > Request Report';
    $data['body'] = 'requisitions/report/filter-pending-request';
    $data['breadcrumb'] = array("requisitions/report/filter-pending_request" => "Filter pending request");
    $data['pending_request_report'] = true; 
    $data['results'] = $this->Requisition_Model->filter_request($limit, $offset,$data);
    $this->load->view('admin/commons/new_template', $data);        
}

 // Invoices - Add invoice into the database.
 public function filter_process_request($offset = null){
     $report = $this->uri->segment(2);
    $data = array(
        'city' => $this->input->get('city'),
        'company' => $this->input->get('company'),
        'department' => $this->input->get('department'),
        'name' => $this->input->get('name'),
        'item' => $this->input->get('item'),
        'model' => $this->input->get('model'),
        'quantity' => $this->input->get('quantity'), 
    );
    // echo "<pre>";
    // print_r($data);
    $limit = 25;
    if($this->input->get('limit')) {
        $limit = $this->input->get('limit');
    }
    if(!empty($offset)){
        $config['uri_segment'] = 3;
    }
    $this->load->library('pagination');
    $url = base_url('report/filter_request');
    $rowscount = $this->Requisition_Model->request_count($limit, $offset,$data,$count = true);
    $config['base_url'] = $url;
    $config['total_rows'] = $rowscount;
    $config['per_page'] = $limit;
    $config['cur_tag_open'] = '<a class="pagination-link has-background-success has-text-white" aria-current="page">';
    $config['cur_tag_close'] = '</a>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_open'] = '</li>';
    $config['first_link'] = 'First';
    $config['prev_link'] = 'Previous';
    $config['next_link'] = 'Next';
    $config['last_link'] = 'Last';
    $config['attributes'] = array('class' => 'pagination-link');
    $config['reuse_query_string'] = true;
    $this->pagination->initialize($config);

$data['title'] = 'Request Report > Request Report';
$data['body'] = 'requisitions/report/filter-pending-request';
$data['breadcrumb'] = array("requisitions/report/filter-pending_request" => "Filter process request");
$data['process_request_report'] = true; 
$data['results'] = $this->Requisition_Model->filter_request($limit, $offset,$data,$report);
$this->load->view('admin/commons/new_template', $data);        
}

 // Invoices - Add invoice into the database.
 public function filter_approved_request($offset = null){
    $report = $this->uri->segment(2);
   $data = array(
       'city' => $this->input->get('city'),
       'company' => $this->input->get('company'),
       'department' => $this->input->get('department'),
       'name' => $this->input->get('name'),
       'item' => $this->input->get('item'),
       'model' => $this->input->get('model'),
       'quantity' => $this->input->get('quantity'), 
   ); 
   $limit = 25;
   if($this->input->get('limit')) {
       $limit = $this->input->get('limit');
   }
   if(!empty($offset)){
       $config['uri_segment'] = 3;
   }
   $this->load->library('pagination');
   $url = base_url('report/filter_request');
   $rowscount = $this->Requisition_Model->request_count($limit, $offset,$data,$count = true);
   $config['base_url'] = $url;
   $config['total_rows'] = $rowscount;
   $config['per_page'] = $limit;
   $config['cur_tag_open'] = '<a class="pagination-link has-background-success has-text-white" aria-current="page">';
   $config['cur_tag_close'] = '</a>';
   $config['num_tag_open'] = '<li>';
   $config['num_tag_open'] = '</li>';
   $config['first_link'] = 'First';
   $config['prev_link'] = 'Previous';
   $config['next_link'] = 'Next';
   $config['last_link'] = 'Last';
   $config['attributes'] = array('class' => 'pagination-link');
   $config['reuse_query_string'] = true;
   $this->pagination->initialize($config);

$data['title'] = 'Request Report > Request Report';
$data['body'] = 'requisitions/report/filter-pending-request';
$data['breadcrumb'] = array("requisitions/report/filter-pending_request" => "Filter process request");
$data['approved_request_report'] = true; 
$data['results'] = $this->Requisition_Model->filter_request($limit, $offset,$data,$report);
$this->load->view('admin/commons/new_template', $data);        
}
 // Invoices - Add invoice into the database.
 public function filter_reject_request($offset = null){
    $report = $this->uri->segment(2); 
   $data = array(
       'city' => $this->input->get('city'),
       'company' => $this->input->get('company'),
       'department' => $this->input->get('department'),
       'name' => $this->input->get('name'),
       'item' => $this->input->get('item'),
       'model' => $this->input->get('model'),
       'quantity' => $this->input->get('quantity'), 
   ); 
   $limit = 25;
   if($this->input->get('limit')) {
       $limit = $this->input->get('limit');
   }
   if(!empty($offset)){
       $config['uri_segment'] = 3;
   }
   $this->load->library('pagination');
   $url = base_url('report/reject_request_report');
   $rowscount = $this->Requisition_Model->request_count($limit, $offset,$data,$count = true);
   $config['base_url'] = $url;
   $config['total_rows'] = $rowscount;
   $config['per_page'] = $limit;
   $config['cur_tag_open'] = '<a class="pagination-link has-background-success has-text-white" aria-current="page">';
   $config['cur_tag_close'] = '</a>';
   $config['num_tag_open'] = '<li>';
   $config['num_tag_open'] = '</li>';
   $config['first_link'] = 'First';
   $config['prev_link'] = 'Previous';
   $config['next_link'] = 'Next';
   $config['last_link'] = 'Last';
   $config['attributes'] = array('class' => 'pagination-link');
   $config['reuse_query_string'] = true;
   $this->pagination->initialize($config);

$data['title'] = 'Request Report > Request Report';
$data['body'] = 'requisitions/report/filter-pending-request';
$data['breadcrumb'] = array("requisitions/report/filter-pending_request" => "Filter process request");
$data['reject_request_report'] = true; 
$data['results'] = $this->Requisition_Model->filter_request($limit, $offset,$data,$report);
$this->load->view('admin/commons/new_template', $data);        
}
     // 404 page.
    public function page_not_found(){
        echo "We're sorry but the page you're looking for could not be found.";
    }
}
