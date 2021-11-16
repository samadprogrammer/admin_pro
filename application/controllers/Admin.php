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
        $this->load->model('user_model');
        $this->load->model('supervisor_model');
        $this->load->helper('paginate');
        if(!$this->session->userdata('username')){
            redirect('');
        }
        $this->access['AssetsAccess'] = $this->AccessList()["Assets"];
        $this->access['SuppliersAccess'] = $this->AccessList()["Suppliers"];
        $this->access['EmployeesAccess'] = $this->AccessList()["Employees"];
        $this->access['CategoriesAccess'] = $this->AccessList()["Categories"];
        $this->access['RegisterAccess'] = $this->AccessList()["Register"];

      
    }

    public function AccessList() {
        $user_role = $this->session->userdata('user_role');
        $userAccess = $this->admin_model->request_db_configs($user_role);
        return $arrayName = array('Assets' => $userAccess[0], 'Suppliers' => $userAccess[1], 'Employees' => $userAccess[2], 'Categories' => $userAccess[3], 'Register' => $userAccess[4]);
    }

    // Load the dashboard.
    public function index(){
       redirect('admin/dashboard');
    }
    public function dashboard() {
        $data['title'] = 'Home | Admin & Procurement';
        $data['body'] = 'admin/dashboard';
        $data['total_employees'] = $this->admin_model->count_employ();
        $data['count_employ_week_change'] = $this->admin_model->count_employ_week_change();
        if ($this->admin_model->count_employ_last_week_change() != 0) {
            $data['count_employ_last_week_change'] = $this->admin_model->count_employ_last_week_change();
        } else {
            $data['count_employ_last_week_change'] = 1;
        }
        
        
        $data['total_items'] = $this->admin_model->count_item();
        $data['total_items_week_change'] = $this->admin_model->count_item_week_change();
        if ($this->admin_model->count_item_last_week_change() != 0) {
            $data['total_items_last_week_change'] = $this->admin_model->count_item_last_week_change();
        } else {
            $data['total_items_last_week_change'] = 1;
        }

        $data['total_suppliers'] = $this->admin_model->count_suppliers();
        $data['total_suppliers_week_change'] = $this->admin_model->count_suppliers_week_change();
        if ($this->admin_model->count_suppliers_last_week_change() != 0) {
            $data['total_suppliers_last_week_change'] = $this->admin_model->count_suppliers_last_week_change();
        } else {
            $data['total_suppliers_last_week_change'] = 1;
        }

        $data['total_categories'] = $this->admin_model->count_categories();
        $data['total_categories_week_change'] = $this->admin_model->count_categories_week_change();
        if ($this->admin_model->count_categories_last_week_change() != 0) {
            $data['total_categories_last_week_change'] = $this->admin_model->count_categories_last_week_change();
        } else {
            $data['total_categories_last_week_change'] = 1;
        }

        $data['total_offices'] = $this->admin_model->count_locations();
        $data['total_offices_week_change'] = $this->admin_model->count_locations_week_change();
        if ($this->admin_model->count_locations_last_week_change() != 0) {
            $data['total_offices_last_week_change'] = $this->admin_model->count_locations_last_week_change();
        } else {
            $data['total_offices_last_week_change'] = 1;
        }

        $data['total_available_items'] = $this->admin_model->count_available_items();
        $data['total_available_items_week_change'] = $this->admin_model->count_available_items_week_change();
        if ($this->admin_model->count_available_items_last_week_change() != 0) {
            $data['total_available_items_last_week_change'] = $this->admin_model->count_available_items_last_week_change();
        } else {
            $data['total_available_items_last_week_change'] = 1;
        }

        $data['total_assigned_items'] = $this->admin_model->count_assign_item();
        $data['total_assigned_items_week_change'] = $this->admin_model->count_assign_item_week_change();
        if ($this->admin_model->count_assign_item_last_week_change() != 0) {
            $data['total_assigned_items_last_week_change'] = $this->admin_model->count_assign_item_last_week_change();
        } else {
            $data['total_assigned_items_last_week_change'] = 1;
        }

        $data['total_damaged_items'] = $this->admin_model->count_damaged_items();
        $data['total_damaged_items_week_change'] = $this->admin_model->count_damaged_items_week_change();
        if ($this->admin_model->count_damaged_items_last_week_change() != 0) {
            $data['total_damaged_items_last_week_change'] = $this->admin_model->count_damaged_items_last_week_change();
        } else {
            $data['total_damaged_items_last_week_change'] = 1;
        }

        $data['employees_statistics'] = $this->admin_model->EmployeesStatistics();

        $data['total_items_count_by_days'] = $this->admin_model->total_items_count_by_days();

        $data['assigned_items_count_by_days'] = $this->admin_model->assigned_items_count_by_days();

        $data['damaged_items_count_by_days'] = $this->admin_model->damaged_items_count_by_days();
        
        $data['breadcrumb'] = array("Dashboard");
        
        $this->load->view('admin/commons/new_template', $data);
    }    
    // Pending requests - listing
    public function pending_requests($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/pending_requests';
        $rowscount = $this->admin_model->total_pending();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Pending Requests | Admin & Procurement';
        $data['body'] = 'admin/pending-requests';
        $data['pending_requisitions'] = $this->admin_model->pending_requisitions($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // Approved requests - listing
    public function approved_requests($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/approved_requests';
        $rowscount = $this->admin_model->total_approved();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Approved Requests | Admin & Procurement';
        $data['body'] = 'admin/approved-requests';
        $data['approved_requisitions'] = $this->admin_model->approved_requisitions($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // Rejected requests - listing
    public function rejected_requests($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/rejected_requests';
        $rowscount = $this->admin_model->total_rejected();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Rejected Requests | Admin & Procurement';
        $data['body'] = 'admin/rejected-requests';
        $data['rejected_requisitions'] = $this->admin_model->rejected_requisitions($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // Request detail - Filter by ID.
    public function request_detail($id){
        if(!$this->session->userdata('username')){
            redirect('');
        }
        $data['title'] = 'Request Detail | Admin & Procurement';
        $data['body'] = 'admin/request_detail';
        $data['request_detail'] = $this->admin_model->request_detail($id);
        $this->load->view('admin/commons/template', $data);
    }
    // Approve request.
    public function approve_request($id){
        if(!$this->session->userdata('username')){
            redirect('');
        }
        $data = array(
            'status' => 1,
            'updated_at' => date('Y-m-d')
        );
        if($this->admin_model->approve_request($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Request approval was successful.');
            redirect('admin');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong in request approval. Please try again.');
            redirect('admin/request_detail/'.$id);
        }
    }
    // Reject request.
    public function reject_request($id){
        if(!$this->session->userdata('username')){
            redirect('');
        }
        $data = array(
            'status' => 2,
            'updated_at' => date('Y-m-d')
        );
        if($this->admin_model->approve_request($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Request rejection was successful.');
            redirect('admin');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong in request rejection. Please try again.');
            redirect('admin/request_detail/'.$id);
        }
    }
    // Suppliers - Go to suppliers page.
    public function suppliers($offset = null){
        if ($this->AccessList()["Suppliers"]->read == 0) {
            redirect('admin/dashboard');
        }
       
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
    
        $this->load->library('pagination');
        $url = base_url('admin/suppliers');
        $rowscount = $this->admin_model->count_suppliers();

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
       
        
        $data['title'] = 'Suppliers | Admin & Procurement';
        $data['body'] = 'admin/suppliers/suppliers';
        $data['suppliers'] = $this->admin_model->get_suppliers($limit, $offset);
        $data['locations'] = $this->admin_model->list_locations_suppliers();
        $data['categories'] = $this->admin_model->suppliers_category();
        $data['suppliers_page'] = true;
        $data['breadcrumb'] = array("Suppliers");
        
        $this->load->view('admin/commons/new_template', $data);
    }
    // Add Suppliers - Go to add suppliers page.
    public function add_supplier(){
        if ($this->AccessList()["Suppliers"]->write == 0) {
            redirect('admin/dashboard');
        }
        $data['title'] = 'Add Supplier | Admin & Procurement';
        $data['body'] = 'admin/suppliers/add_supplier';
        $data['locations'] = $this->admin_model->list_locations_suppliers();
        $data['categories'] = $this->admin_model->suppliers_category();
        $data['add_supplier_page'] = true;
        $data['breadcrumb'] = array("admin/suppliers" => "Suppliers", "Add Supplier");
        
        $this->load->view('admin/commons/new_template', $data);
    }
    // Edit Supplier - Navigates to `Edit Supplier` page
    public function edit_supplier($id = null){  
        if ($this->AccessList()["Suppliers"]->update == 0) {
            redirect('admin/dashboard');
        }

        $data['edit'] = $this->admin_model->edit_supplier($id); 
        
        if ($data['edit'] == NULL) {
            redirect('admin/suppliers');
        }

        $data['title'] = 'Edit Supplier | Admin & Procurement';
        $data['body'] = 'admin/suppliers/edit_supplier';
        $data['locations'] = $this->admin_model->list_locations_suppliers(); 
        $data['categories'] = $this->admin_model->suppliers_category();
        $data['suppliers_page'] = true;
        $data['breadcrumb'] = array("admin/suppliers" => "Suppliers", "Edit Supplier");
        $this->load->view('admin/commons/new_template', $data);
    }
    // Suppliers - Add new supplier
    public function add_supplier_request(){ 
        $data = array(
            'name' => $this->input->post('name'),
            'added_by' => $this->session->userdata('id'),
            'category' => $this->input->post('category'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'location' => $this->input->post('location'), 
            'ntn_number' => $this->input->post('ntn_number'),
            'rating' => $this->input->post('rating'),
            'address' => ucfirst($this->input->post('address')),
            'created_at' => date('Y-m-d')
        ); 
        if ($id = $this->admin_model->add_supplier($data)) {
            $this->session->set_flashdata('success', 'Supplier (<strong>' . $this->input->post('name') . '</strong>) was added successfully.');
            redirect('admin/edit_supplier/' . $id);
        }else{
            $this->session->set_flashdata('failed', 'Something went wrong, please try again!');
            redirect('admin/suppliers');
        }
    }
     // get_supplier against location 
     public function supplier_against_location($loc_id){
        $location = $this->admin_model->supplier_against_location($loc_id);
        echo json_encode($location);
    }
    // Suppliers - Remove supplier
    public function delete_supplier($id){
        if ($this->AccessList()["Suppliers"]->delete == 0) {
            redirect('admin/dashboard');
        }

        $data = array(
            'status' => 0
        );

        if($this->admin_model->delete_supplier($id,$data)){
            $this->session->set_flashdata('success', '<strong>Success:</strong> Supplier removal was successful.');
            redirect('admin/suppliers');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed:</strong> Something went wrong, please try again!');
            redirect('admin/suppliers');
        }
    }
    // Update supplier
    public function update_supplier($id = NULL){
        if ($id == NULL) {
            redirect('admin/edit_supplier');
        }

        $data = array(
            'location' => $this->input->post('location'),
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'category' => $this->input->post('category'),    
            'ntn_number' => $this->input->post('ntn_number'),
            'rating' => $this->input->post('rating'), 
            'address' => $this->input->post('address')
        );  
        if($this->admin_model->update_supplier($id, $data)){
            $this->session->set_flashdata('success', 'Supplier (<strong>' . $this->input->post('name') . '</strong>) was updated successfully.');
            redirect('admin/edit_supplier/' . $id);
        }else{
            $this->session->set_flashdata('failed', 'Something went wrong, please try again!');
            redirect('admin/edit_supplier/' . $id);
        }
    }
    // Employ - Go to employ page.
    public function employee($offset = null){
        if ($this->AccessList()["Employees"]->read == 0) {
            redirect('admin/dashboard');
        }
      
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
    
        $this->load->library('pagination');
        $url = base_url('admin/employee');
        $rowscount = $this->admin_model->count_employ();

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

        $data['title'] = 'Employ | Admin & Procurement';
        $data['body'] = 'admin/employ/employ';
        $data['employ'] = $this->admin_model->get_employ($limit, $offset);
        $data['locations'] = $this->admin_model->list_locations_suppliers();
        $data['employees_page'] = true;
        $data['breadcrumb'] = array("Employees");
        
        $this->load->view('admin/commons/new_template', $data);
    } 

    // Controller for ACL page
    public function acl(){
        $data['title'] = 'Access Control List | Admin & Procurement';
        $data['body'] = 'admin/ACL/acl';
        $data['assets_access_list'] = $this->admin_model->component_access_list('assets');
        $data['suppliers_access_list'] = $this->admin_model->component_access_list('suppliers');
        $data['employees_access_list'] = $this->admin_model->component_access_list('employees');
        $data['categories_access_list'] = $this->admin_model->component_access_list('categories');
        $data['register_access_list'] = $this->admin_model->component_access_list('register');
        $data['acl_page'] = true;
        $data['breadcrumb'] = array("Access Control List");
        
        $this->load->view('admin/commons/new_template', $data);
    } 
    // Form Logic for Assets Access on ACL Page
    public function update_access_list() {
        $asset_read = $this->input->post('read'); // read[1][1], read[1][2], read[1][3]
        $asset_write = $this->input->post('write'); 
        $asset_update = $this->input->post('update'); 
        $asset_delete = $this->input->post('delete'); 

        for ($i = 1; $i <= $this->admin_model->count_acl_components(); $i++) { 
            // $i => component
            for ($j = 1; $j <= $this->admin_model->count_users_roles(); $j++) { 
                // $j => role_id
                $data = array(
                    "read" => isset($asset_read[$i][$j]),
                    "write" => isset($asset_write[$i][$j]),
                    "update" => isset($asset_update[$i][$j]),
                    "delete" => isset($asset_delete[$i][$j]),
                );

                $access_update = $this->admin_model->access_update($data, $j, $i);

            }

        }

        if($access_update){
            $this->session->set_flashdata('success', '<strong class="mr-1">Success.</strong>Employ added successfully.');
            redirect('admin/acl');
        }else{
            $this->session->set_flashdata('failed', '<strong class="mr-1">Failed.</strong>Something went wrong, please try again!');
            redirect('admin/acl');
        }
    }
  // employee register - add new employee.
  public function add_employee(){
    if ($this->AccessList()["Employees"]->write == 0) {
        redirect('admin/dashboard');
    }
    $data['title'] = 'Add Employee';
    $data['add_page'] = true;
    $data['body'] = 'admin/employ/add_employee';   
    $data['locations'] = $this->admin_model->get_item_location(); 
    $data['user_roles'] = $this->admin_model->UserRoles();
    $data['breadcrumb'] = array("admin/employee" => "Employee List", "Add Employee");
    $this->load->view('admin/commons/new_template', $data);
}
    // Suppliers - Add new supplier
    public function employee_save(){ 
        $data = array(
            'fullname' => ucfirst($this->input->post('full_name')),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'username' => ucfirst($this->input->post('user_name')),
            'department' =>ucfirst($this->input->post('department')),
            'location' => $this->input->post('location'),
            'password' => sha1($this->input->post('phone')),
            'region' => ucfirst($this->input->post('region')),
            'address' => ucfirst($this->input->post('address')),
            'status' => 1,
            'dob' => $this->input->post('dob'),
            'doj' => $this->input->post('doj'),
            'user_role' => $this->input->post('user_role'),
            'created_at' => date('Y-m-d')
        );  
        if($this->admin_model->add_employ($data)){
            $this->session->set_flashdata('success', '<strong>Success! /strong>Employ added successfully.');
            redirect('admin/employee');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/employee');
        }
    } 
    // Edit detail
    public function edit_employ($id){
        if ($this->AccessList()["Employees"]->update == 0) {
            redirect('admin/dashboard');
        }
        $data['title'] = 'Edit Employee';
        $data['body'] = 'admin/employ/add_employee';
        $data['locations'] = $this->admin_model->get_employ_location($id); 
        $data['edit'] = $this->admin_model->edit_employ($id);  
        $data['user_roles'] = $this->admin_model->UserRoles();
        $data['breadcrumb'] = array("admin/employee" => "Employee List", "Edit Employee");
        $data['employees_page'] = true;
        $this->load->view('admin/commons/new_template', $data);
    }

    // Get single employee by id
    public function edit_employ_changed($id){ 
        $employ = $this->admin_model->edit_employ($id);
        echo json_encode($employ);
    }
    // Update employ
    public function update_employ(){
        $id = $this->input->post('id'); 
        $data = array(
            'fullname' => ucfirst($this->input->post('full_name')), 
            'email' => $this->input->post('email'), 
            'phone' => $this->input->post('phone'), 
            'department' =>ucfirst($this->input->post('department')),
            'location' => $this->input->post('location'), 
            'region' => ucfirst($this->input->post('region')),
            'address' => ucfirst($this->input->post('address')),
            'status' => 1,
            'dob' => $this->input->post('dob'),
            'doj' => $this->input->post('doj'),
            'user_role' => $this->input->post('user_role')
        );
        // echo "<pre>";
        // print_r($data);exit;  
        if($this->admin_model->update_employ($id, $data)){
            $this->session->set_flashdata('success', 'Employee (<strong>' . $this->input->post('full_name') . '</strong>) was updated successfully.'); 
            redirect('admin/edit_employ/' . $id);
        }else{
            $this->session->set_flashdata('failed', 'Something went wrong, please try again!');
            redirect('admin/edit_employ/' . $id);
        }
    }
     // Search filters - search employ
     public function search_employ(){
        if ($this->AccessList()["Employees"]->read == 0) {
            redirect('admin/dashboard');
        }
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Employ';
        $data['body'] = 'admin/employ/employ';
        $data['results'] = $this->admin_model->search_employ($search); 
        $data['breadcrumb'] = array("admin/employ" => "Employees", "Search: " . $search); 
        $data['search_employ_page'] = true;

        $this->load->view('admin/commons/new_template', $data);
    } 
    // Employ - Remove employ
    public function delete_employ($id){
        if($this->admin_model->delete_employ($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Employ removal was successful.');
            redirect('admin/employ');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/employ');
        }
    }
    // Inventory - Go to inventory page.
    public function inventory($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/inventory';
        $rowscount = $this->admin_model->count_inventory();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Inventory | Admin & Procurement';
        $data['body'] = 'admin/inventory';
        $data['locations'] = $this->login_model->get_locations();
        $data['categories'] = $this->admin_model->get_categories();
        $data['inventory'] = $this->admin_model->get_inventory($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    } 
    // Inventory - Go to assign inventory page.
    public function assign_inventory($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/inventory';
        $rowscount = $this->admin_model->count_inventory();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Inventory | Admin & Procurement';
        $data['body'] = 'admin/assign_inventory';
        $data['locations'] = $this->login_model->get_locations();
        $data['categories'] = $this->admin_model->get_categories();
        $data['assign_inventory'] = $this->admin_model->get_assign_inventory($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    
    // Get all sub categories based on cat_id
    public function get_sub_categories($cat_id){
        $sub_categories = $this->admin_model->get_sub_categories($cat_id);
        echo json_encode($sub_categories);
    }
    // Inventory - Add inventory.
    public function add_inventory(){
        $data = array(
            'location' => $this->input->post('location'),
            'category' => $this->input->post('category'),
            'name' => $this->input->post('item_name'),
            'item_qty' => $this->input->post('item_qty'),
            'unit_price' => $this->input->post('unit_price'),
            'item_desc' => $this->input->post('item_desc')
        );
        if($this->admin_model->add_inventory($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Inventory was added successfully');
            redirect('admin/inventory');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/inventory');
        }
    }
    // Invnetory - Edit inventory
    public function edit_inventory($id){
        $inventory = $this->admin_model->edit_inventory($id);
        echo json_encode($inventory);
    }
    // Inventory - update inventory info
    public function update_inventory(){
        $id = $this->input->post('id');
        $data = array(
            'location' => $this->input->post('location'),
            'category' => $this->input->post('category'),
            'name' => $this->input->post('item_name'),
            'item_qty' => $this->input->post('item_qty'),
            'unit_price' => $this->input->post('unit_price'),
            'item_desc' => $this->input->post('item_desc')
        );
        if($this->admin_model->update_inventory($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Inventory was updated successfully');
            redirect('admin/inventory');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/inventory');
        }
    }
    // Inventory - Remove inventory
    public function delete_inventory($id){
        if($this->admin_model->delete_inventory($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Inventory removal was successful.');
            redirect('admin/inventory');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/inventory');
        }
    }
    // Users - Go to users page where the users will be listed.
    public function users($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/users';
        $rowscount = $this->admin_model->count_users();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Users | Admin & Procurement';
        $data['body'] = 'admin/users';
        $data['users'] = $this->admin_model->get_users($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // Users - Remove user.
    public function delete_user($id){
        if($this->admin_model->delete_user($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>User removal was successful.');
            redirect('admin/users');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/users');
        }
    }
    // Invoices - Go to the invoices list page.
    public function invoices($offset = null){
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }
        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
        $this->load->library('pagination');
        $url = base_url('admin/invoices');
        $rowscount = $this->admin_model->count_invoices();

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

        $data['title'] = 'Invoices | Admin & Procurement';
        $data['body'] = 'admin/invoices';
        $data['breadcrumb'] = array("admin/invoices" => "Invoice List");
        $data['invoices'] = true;  
        $data['body'] = 'admin/invoices';
        $data['suppliers'] = $this->admin_model->get_suppliers_for_invoice();
        $data['invoices'] = $this->admin_model->get_invoices($limit, $offset); 
        $data['locations'] = $this->login_model->get_locations();
        $this->load->view('admin/commons/new_template', $data);
    }

       // Add invoice - add new invoice.
       public function add_invoice(){
        $data['title'] = 'Add Invoice';
        $data['body'] = 'admin/add_invoice';
        $data['breadcrumb'] = array("admin/add_invoice" => "Add Invoice");
        $data['add_invoice'] = true; 
        $data['projects'] = $this->admin_model->inoice_project();
        $data['suppliers'] = $this->admin_model->suppliers();
        $data['locations'] = $this->login_model->get_locations();
        $this->load->view('admin/commons/new_template', $data);
    }
    // Invoices - Add invoice into the database.
    public function save_invoice(){

        $file = $this->input->post('userfile'); 
        $config['upload_path']   = './upload/invoices/'; 
        $config['allowed_types'] = 'gif|jpg|png';  
        $this->load->library('upload', $config); 
      
        if ( ! $this->upload->do_upload('userfile')) { 
            echo $this->upload->display_errors(); exit;
           $error = array('error' => $this->upload->display_errors()); 
           redirect('admin/invoices');
        }
        else {   
           $datas = $this->upload->data();  
        $data = array(
            'inv_no' => $this->input->post('inv_no'),
            'inv_date' => date('Y-m-d', strtotime($this->input->post('inv_date'))),
            'project' => $this->input->post('project'),
            'supplier' => $this->input->post('supplier'),
            'file' => $datas['full_path'],
            'region' => $this->input->post('region'),
            'item' => $this->input->post('item_name'),
            'amount' => $this->input->post('amount'),
            'inv_desc' => $this->input->post('inv_desc'),
            'created_at' => date('Y-m-d')
        ); 
        if($this->admin_model->add_invoice($data)){
            $this->session->set_flashdata('success', '<strong>Invoice! </strong>Invoice Added successfully.');
            redirect('admin/invoices');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/invoices');
        }
        }
    }
    
    // Edit detail
    public function edit_invoice($id){   
        $data['title'] = 'Edit Invoice';
        $data['body'] = 'admin/add_invoice';
        $data['breadcrumb'] = array("admin/add_invoice" => "Edit Invoice");
        $data['locations'] = $this->admin_model->get_invoice_location($id); 
        $data['edit'] = $this->admin_model->edit_invoice($id); 
        $data['projects'] = $this->admin_model->project($id);
        $data['suppliers'] = $this->admin_model->invoice_supplier($id);
        $data['breadcrumb'] = array("admin/invoices" => "Invoice List", "Edit Invoice");
        $data['employees_page'] = true;
        $this->load->view('admin/commons/new_template', $data);
    }
    // Update Invoice
    public function update_invoice(){
        $id = $this->input->post('id'); 

        $image = $this->admin_model->invoice_file($id); // checking file against id 
        $new_name = $_FILES["userfile"]['name'];
      
 if(!empty($new_name)){
        $new_name = time().$_FILES["userfile"]['name'];
        $config['file_name']        = $new_name;
        $config['upload_path']   = './assets/uploads/'; 
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';  
        $this->load->library('upload', $config);  
        $this->upload->do_upload('userfile');
        $_data = $this->upload->data();

        if (isset($image)) {
            unlink($image->file); // if file exsist it will be removed from folder
        }
    } 
    if (isset($_data['full_path']))  
    {
      $_data[ 'full_path' ]; 
    }
    else {
        $_data[ 'full_path' ] = $image->file;
    }
        $data = array(
            'inv_no' => $this->input->post('inv_no'),
            'inv_date' => date('Y-m-d', strtotime($this->input->post('inv_date'))),
            'project' => $this->input->post('project'),
            'supplier' => $this->input->post('supplier'),
            'file' => $_data['full_path'], 
            'region' => $this->input->post('region'),
            'item' => $this->input->post('item_name'),
            'amount' => $this->input->post('amount'),
            'inv_desc' => $this->input->post('inv_desc'),
            'created_at' => date('Y-m-d')
        );
        if($this->admin_model->update_invoice($id, $data)){
            $this->session->set_flashdata('success', 'Product (<strong>' . $this->input->post('item_name') . '</strong>) was updated successfully.'); 
            redirect('admin/edit_invoice/' . $id);
        }else{
            $this->session->set_flashdata('failed', 'Something went wrong, please try again!');
            redirect('admin/edit_invoice/' . $id);
        }
}



    // Invoices - print invoice
    public function print_invoice($id){
        $data['title'] = 'Print Invoice | Admin & Procurement';
        $data['body'] = 'admin/print_invoice';
        $data['invoice'] = $this->admin_model->print_invoice($id);
        $this->load->view('admin/commons/new_template', $data);
    }
    // Invoices - Remove invoices
    public function delete_invoice($id){
        if($this->admin_model->delete_invoice($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Invoice removal was successful.');
            redirect('admin/invoices');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/invoices');
        }
    }
    // Invoices - Changes invoice status to cleared
    public function invoice_status($id){
        $data = array(
            'status_reason' => "    ",
            'status' => 1
        ); 
        if($this->admin_model->update_status($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Invoice status change was successful.');
            redirect('admin/invoices');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/invoices');
        }
    }
      // Invoices - Changes invoice status to pending
      public function invoice_status_pending(){
        $id = $this->input->post('id');
        $data = array(
            'status_reason' => $this->input->post('reason'),
            'status' => 0,
        ); 
       
        // $logs_data = array(
        //     'status_reason' => $this->input->post('reason'),
        //     'added_by' => $this->session->userdata('id'),
        //     'created_at' => date('Y-m-d'),
        //     'status' => 0,
        // ); 


        // $invoice_data = json_encode($logs_data, true);
        // echo "<pre>";
        // print_r($invoice_data);exit;
        if($this->admin_model->invoice_status_pending($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Invoice status change was successful.');
            redirect('admin/invoices');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/invoices');
        }
    }
    // Projects - Go to projects page.
    public function projects($offset = null){ 
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
    
        $this->load->library('pagination');
        $url = base_url('admin/projects');
        $rowscount = $this->admin_model->count_projects();

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

        $data['title'] = 'Projects | Admin & Procurement';
        $data['body'] = 'admin/projects/project_list';
        $data['breadcrumb'] = array("admin/projects/project_list" => "Project List");
        $data['projects'] = true; 
        $data['projects'] = $this->admin_model->get_projects($limit, $offset);
        $this->load->view('admin/commons/new_template', $data);
    }
    
    // Add Projects - add new project.
    public function add_project(){
        $data['title'] = 'Project Detail';
        $data['body'] = 'admin/projects/add_project';
        $data['breadcrumb'] = array("admin/projects/add_project" => "Project List","Add Project");
        $data['add_project'] = true; 
        $this->load->view('admin/commons/new_template', $data);
    }
    // Projects - Add new project
    public function save_project(){
        $data = array(
            'project_name' => $this->input->post('project_name'),
            'status' => 1,
            'project_desc' => $this->input->post('project_desc'),
            'created_at' => date('Y-m-d')
        );
        if($this->admin_model->save_project($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Project was added successfully.');
            redirect('admin/projects');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/projects');
        }
    }
    // Edit projects
    public function edit_project($id = null){  
        $data['edit'] = $this->admin_model->edit_project($id); 
        if ($data['edit'] == NULL) {
            redirect('admin/projects');
        }
        $data['title'] = 'Edit Projects | Admin & Procurement';
        $data['body'] = 'admin/projects/add_project'; 
        $data['edit_project'] = true;
        $data['breadcrumb'] = array("admin/projects/add_project" => "Project List","Edit Project");
        $this->load->view('admin/commons/new_template', $data);
    }
    // Projects - update project
    public function update_project(){
        $id = $this->input->post('project_id');
        $data = array(
            'project_name' => $this->input->post('project_name'),
            'project_desc' => $this->input->post('project_desc'), 
        ); 
        if($this->admin_model->update_project($id, $data)){
            $this->session->set_flashdata('success', 'Product (<strong>' . $this->input->post('project_name') . '</strong>) was updated successfully.'); 
            redirect('admin/edit_project/' . $id);
        }else{
            $this->session->set_flashdata('failed', 'Something went wrong, please try again!');
            redirect('admin/edit_project/' . $id);
        } 
    }
    // Projects - Active project
    public function active_project($id){
        $data = array(
            'status' => 1,
        );
        if($this->admin_model->active_project($id,$data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Project was Active successful.');
            redirect('admin/projects');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/projects');
        }
    } 
   // Projects - DeActive project
   public function de_active_project($id){
    $data = array(
        'status' => 0,
    );
    if($this->admin_model->de_active_project($id,$data)){
        $this->session->set_flashdata('success', '<strong>Success! </strong>Project was De Active successful.');
        redirect('admin/projects');
    }else{
        $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
        redirect('admin/projects');
    }
}

    // Search filters - search asset register
    public function search_project(){ 
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Project list';
        $data['body'] = 'admin/projects/project_list';
        $data['breadcrumb'] = array("admin/project_list" => "Project List", "Search: " . $search);
        $data['search_project'] = true; 
        $data['results'] = $this->admin_model->search_project($search);
        $this->load->view('admin/commons/new_template', $data);
    }
    // Maintenance - Office equipments
    public function maintenance($offset = null){
        $limit = 10;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/maintenance';
        $rowscount = $this->admin_model->count_maint_record();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Maintenance | Admin & Procurement';
        $data['body'] = 'admin/maintenance';
        $data['maintenance_items'] = $this->admin_model->get_maint_record($limit, $offset);
        $data['locations'] = $this->login_model->get_locations();
        $this->load->view('admin/commons/template', $data);
    }
    // Maintenance - Add new record
    public function add_maintenance(){
        $data = array(
            'region' => $this->input->post('maint_region'),
            'maint_date' => $this->input->post('maint_date'),
            'maint_cat' => $this->input->post('maint_cat'),
            'maint_desc' => $this->input->post('maint_desc'),
            'vendor' => $this->input->post('vendor'),
            'qty_size' => $this->input->post('qty_size'),
            'unit_price' => $this->input->post('unit_price'),
            'total_amount' => $this->input->post('total_amount'),
            'maint_remarks' => $this->input->post('remarks')
        );
        if($this->admin_model->add_maint_record($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Maintenance record was added successfully.');
            redirect('admin/maintenance');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/maintenance');
        }
    }
    // Maintenance - Delete a record
    public function delete_record($id){
        if($this->admin_model->delete_record($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Record removal was successful.');
            redirect('admin/maintenace');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/maintenance');
        }
    }
    // Asset register
    public function asset_register($offset = null){
        if ($this->AccessList()["Assets"]->read == 0) {
            redirect('admin/dashboard');
        }

        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
    
        $this->load->library('pagination');
        $url = base_url('admin/asset_register');
        $rowscount = $this->admin_model->count_assets();

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
               
        $data['title'] = 'Asset Register | Admin & Procurement';
        $data['body'] = 'admin/asset-register';
        $data['assets'] = $this->admin_model->get_assets($limit, $offset);
        $data['asset_register'] = true;
        $data['breadcrumb'] = array("Assets List");
        $this->load->view('admin/commons/new_template', $data);
    }
    // Asset register - add new asset.
    public function add_asset(){
        if ($this->AccessList()["Assets"]->write == 0) {
            redirect('admin/dashboard');
        }
        $data['title'] = 'Asset Detail';
        $data['body'] = 'admin/asset-detail';
        $data['breadcrumb'] = array("admin/asset_register" => "Assets List", "Add Asset");
        $data['add_asset'] = true;
        $data['locations'] = $this->admin_model->get_item_location();
        $data['categories'] = $this->admin_model->get_item_categories();
        $this->load->view('admin/commons/new_template', $data);
    }
    // Asset detail
    public function asset_detail($id){ 
        if ($this->AccessList()["Assets"]->read == 0) {
            redirect('admin/dashboard');
        }
        if ($this->AccessList()["Assets"]->update == 0) {
            redirect('admin/dashboard');
        }
        $data['title'] = 'Asset Detail';
        $data['body'] = 'admin/asset-detail';
        $data['locations'] = $this->admin_model->get_item_location();
        $data['categories'] = $this->admin_model->get_item_categories();
        $data['edit'] = $this->admin_model->asset_detail($id);
        $data['sub_categories'] = $this->admin_model->invoice_sub_categories($id);
        $data['breadcrumb'] = array("admin/asset_register" => "Assets List", "Edit Asset");
        $data['asset_register'] = true;
        $this->load->view('admin/commons/new_template', $data);
    }
        // Add new asset into the database
        public function save_item(){
            $data = array(
                'purchase_date' => $this->input->post('purchase_date'), 
                'category' => $this->input->post('category'),
                'sub_categories' => $this->input->post('sub_categories'),
                'description' => $this->input->post('description'),
                'quantity' => $this->input->post('quantity'),
                'price' => $this->input->post('price'),
                'location' => $this->input->post('location'), 
                'user' => $this->session->userdata('id'), 
                'created_at' => date('Y-m-d')
            );
            if($this->admin_model->add_item($data)){
                $this->session->set_flashdata('success', '<strong>Success! </strong>Item was added successfully.');
                redirect('admin/asset_register');
            }else{
                $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again later.');
                redirect('admin/asset_register');
            }
        }
    // Update an existing asset record
    public function update_item(){
        $id = $this->input->post('id');
        $data = array(
            'purchase_date' => $this->input->post('purchase_date'), 
            'category' => $this->input->post('category'), 
            'sub_categories' => $this->input->post('sub_categories'),
            'description' => $this->input->post('description'),
            'quantity' => $this->input->post('quantity'), 
            'price' => $this->input->post('price'),
            'location' => $this->input->post('location'), 
            'user' => $this->session->userdata('id'), 
            'created_at' => date('Y-m-d')
        );
                if($this->admin_model->update_item($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Item was updated successfully.');
            redirect('admin/asset_register');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/asset_register');
        }
    }
    // Delete asset
    public function delete_asset($id){
        if ($this->AccessList()["Assets"]->delete == 0) {
            redirect('admin/dashboard');
        }
        if($this->admin_model->delete_asset($id)){
            $this->session->set_flashdata('success', '<strong>Delete! </strong>Item was deleted successfully.');
            redirect('admin/asset_register');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/asset_register');
        }
    }
    // Contact list - Master contact list
    public function contact_list($offset = null){
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/contact_list';
        $rowscount = $this->admin_model->count_contacts();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Contact List | Admin & Procurement';
        $data['body'] = 'admin/contact_list';
        $data['contacts'] = $this->admin_model->get_contacts($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // Contact list - Load, view or edit contact.
    public function add_contact(){
        $data['title'] = 'Contact List | Admin & Procurement';
        $data['body'] = 'admin/add_contact';
        $this->load->view('admin/commons/template', $data);
    }
    // Contact list - Save new contact.
    public function save_contact(){
        $data = array(
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'project' => $this->input->post('project'),
            'district' => $this->input->post('district'),
            'province' => $this->input->post('province'),
            'gender' => $this->input->post('gender'),
            'cnic' => $this->input->post('cnic'),
            'personal_contact' => $this->input->post('personal_contact'),
            'official_contact' => $this->input->post('official_contact'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'grader' => $this->input->post('grader'),
            'supervisor' => $this->input->post('supervisor'),
            'dob' => $this->input->post('dob'),
            'doj' => $this->input->post('doj')
        );
        if($this->admin_model->add_contact($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Contact information was added successfully.');
            redirect('admin/contact_list');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/contact_list');
        }
    }
    // Contact list - contact detail
    public function contact_detail($id){
        $data['title'] = 'Contact List | Admin & Procurement';
        $data['body'] = 'admin/add_contact';
        $data['edit'] = $this->admin_model->contact_detail($id);
        $this->load->view('admin/commons/template', $data);
    }
    // Contact list - update contact
    public function update_contact(){
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'project' => $this->input->post('project'),
            'district' => $this->input->post('district'),
            'province' => $this->input->post('province'),
            'gender' => $this->input->post('gender'),
            'cnic' => $this->input->post('cnic'),
            'personal_contact' => $this->input->post('personal_contact'),
            'official_contact' => $this->input->post('official_contact'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'grader' => $this->input->post('grader'),
            'supervisor' => $this->input->post('supervisor'),
            'dob' => $this->input->post('dob'),
            'doj' => $this->input->post('doj')
        );
        if($this->admin_model->update_contact($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Contact information was updated successfully.');
            redirect('admin/contact_list');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/contact_list');
        }
    }
    // Contact list - delete contact
    public function delete_contact($id){
        if($this->admin_model->delete_contact($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Contact information was deleted successfully.');
            redirect('admin/contact_list');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/contact_list');
        }
    }
    // Location - Load the page and list existing locations.
    public function locations($offset = null){
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/locations';
        $rowscount = $this->admin_model->count_locations();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Locations | Admin & Procurement';
        $data['body'] = 'admin/locations';
        $data['locations'] = $this->admin_model->get_locations($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // Locations - Add new location
    public function add_location(){
        $data = array(
            'name' => $this->input->post('location_name'),
            'province' => $this->input->post('province')
        );
        if($this->admin_model->add_location($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Location information was added successfully.');
            redirect('admin/locations');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/locations');
        }
    }
    // Locations - Edit location
    public function edit_location($id){
        $location = $this->admin_model->edit_location($id);
        echo json_encode($location);
    }
    // Locations - update location
    public function update_location(){
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('location_name'),
            'province' => $this->input->post('province')
        );
        if($this->admin_model->update_location($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Location information was updated successfully.');
            redirect('admin/locations');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/locations');
        }
    }
    // Locations - Delete location by ID.
    public function delete_location($id){
        if($this->admin_model->delete_location($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Location information was deleted successfully.');
            redirect('admin/locations');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/locations');
        }
    }
    // Travels and hotel stays information.
    public function travels_info($offset = null){
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/travels_info';
        $rowscount = $this->admin_model->total_travel_requests();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Travle & Stay Info | Admin & Procurement';
        $data['body'] = 'admin/travels_info';
        $data['travels'] = $this->admin_model->total_travel_requisitions($limit, $offset);
        $this->load->view('admin/commons/template', $data);
    }
    // View travel detail and print by ID.
    public function print_travel($travel_id){
        $data['title'] = 'Print Travel > Travel History';
        $data['body'] = 'admin/print_travel';
        $data['travel'] = $this->admin_model->print_travel($travel_id);
        // echo json_encode($data['travel']); exit;
        $this->load->view('admin/commons/template', $data);
    }
    // Categories and sub-categories
    public function categories($offset = null){
        if ($this->AccessList()["Categories"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        }
        $url = 'admin/categories';
        $rowscount = $this->admin_model->count_categories();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Categories > Admin & Procurement';
        $data['body'] = 'admin/categories';
        $data['categories'] = $this->admin_model->categories($limit, $offset);
        $data['locations'] = $this->login_model->get_locations();
        $data['categories_page'] = true;
        $data['breadcrumb'] = array("Item Categories");

        $this->load->view('admin/commons/new_template', $data);
    }
    // Adding a category
    public function add_category(){
        if ($this->AccessList()["Categories"]->write == 0) {
            redirect('admin/dashboard');
        }
        $data = array( 
            'cat_name' => $this->input->post('cat_name'),
            'added_by' => $this->session->userdata('id')
        );
        $checkIfExist = $this->db->select('cat_name')->from('categories')->where('cat_name', strtolower($data['cat_name']))->get()->row(); // Get sub_category name.
        if(strtolower($checkIfExist->cat_name) != NULL){
            $this->session->set_flashdata('failed', '<strong class="mr-1">Failed.</strong>Category already exists, try adding a different one.');
            redirect($_SERVER['HTTP_REFERER']); 
            exit;
        }
        elseif($this->admin_model->add_category($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Category was added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Edit category > Get category by ID to update it
    public function edit_category($id){
        $category = $this->admin_model->edit_category($id);
        echo json_encode($category);
    }
    // Adding a category
    public function update_category(){
        $id = $this->input->post('id');
        $data = array(
            'cat_location' => $this->input->post('cat_location'),
            'cat_name' => $this->input->post('cat_name')
        );
        if($this->admin_model->update_category($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Updating a category was successful.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Delete category by ID
    public function delete_category($id){
        if ($this->AccessList()["Categories"]->delete == 0) {
            redirect('admin/dashboard');
        }
        if($this->admin_model->delete_category($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Deleting a category was successful.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Sub categories > Listing and adding sub categories
    public function sub_categories($cat_id,$offset = null){ // $id = category ID 
        if ($this->AccessList()["Categories"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 10; 
        if(!empty($offset)){
            $config['uri_segment'] = 4;
        }

        $this->load->library('pagination');
        $url = base_url('admin/sub_categories');
        $rowscount = $this->admin_model->count_subcategory();
        
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
        $this->pagination->initialize($config);

        $data['title'] = 'Sub Categories | Categories';
        $data['body'] = 'admin/sub_categories'; 
        $data['cat_id'] = $cat_id;
        $data['sub_categories'] = $this->admin_model->sub_categories($cat_id);
        $data['parent_category'] = $this->admin_model->parent_category_name($cat_id);
        $data['categories_page'] = true;
        $data['breadcrumb'] = array("admin/categories" => "Item Categories", $this->admin_model->parent_category_name($cat_id)[0]->cat_name);

        $this->load->view('admin/commons/new_template', $data);
    }
    // Adding a sub category
    public function add_sub_category(){
        if ($this->AccessList()["Categories"]->write == 0) {
            redirect('admin/dashboard');
        }
        $data = array(
            'cat_id' => $this->input->post('parent_category'),
            'name' => $this->input->post('name'),
            'added_by' => $this->session->userdata('id')
        );
        $checkIfExist = $this->db->select('name')->from('sub_categories')->where('name', strtolower($data['name']))->get()->row(); // Get sub_category name.
        if(strtolower($checkIfExist->name) != NULL){
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Record already exists, try adding a different one.');
            redirect($_SERVER['HTTP_REFERER']); 
            exit;
        }
        elseif($this->admin_model->add_sub_category($data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Category was added successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Edit sub category > get sub category by ID
    public function edit_sub_category($id){
        if ($this->AccessList()["Categories"]->update == 0) {
            redirect('admin/dashboard');
        }
        $sub_category = $this->admin_model->edit_sub_category($id);
        echo json_encode($sub_category);
    }
    // Update sub category by ID
    public function update_sub_category(){
        if ($this->AccessList()["Categories"]->update == 0) {
            redirect('admin/dashboard');
        }
        $id = $this->input->post('sub_cat_id');
        $data = array(
            'name' => $this->input->post('name'), 
        );
        if($this->admin_model->update_sub_category($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Category was updated successfully.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    // Delete sub category
    public function delete_sub_category($id){
        if ($this->AccessList()["Categories"]->delete == 0) {
            redirect('admin/dashboard');
        }
        if($this->admin_model->delete_sub_category($id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Deleting a category was successful.');
            redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    //== ----------------------------------------- Search filters ---------------------------------------- ==\\
    // Search filters - search suppliers
    public function search_suppliers(){
        if ($this->AccessList()["Suppliers"]->read == 0) {
            redirect('admin/dashboard');
        }
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Suppliers';
        $data['body'] = 'admin/suppliers/suppliers';
        $data['results'] = $this->admin_model->search_suppliers($search);
        $data['locations'] = $this->admin_model->list_locations_suppliers();
        $data['suppliers_page'] = true;
        $data['breadcrumb'] = array("admin/suppliers" => "Suppliers", "Search: " . $search);
        
        $this->load->view('admin/commons/new_template', $data);
    } 
    // Search filters - search inventory
    public function search_inventory(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Inventory';
        $data['body'] = 'admin/inventory';
        $data['locations'] = $this->login_model->get_locations();
        $data['results'] = $this->admin_model->search_inventory($search);
        $this->load->view('admin/commons/template', $data);
    }
    // Search filters - search users
    public function search_users(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Users';
        $data['body'] = 'admin/users';
        $data['results'] = $this->admin_model->search_users($search);
        $this->load->view('admin/commons/template', $data);
    }
    // Search filters - search invoices
    public function search_invoices(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Invoices';
        $data['body'] = 'admin/invoices';
        $data['breadcrumb'] = array("admin/invoices" => "Invoice List", "Search: " . $search);
        $data['results'] = $this->admin_model->search_invoices($search);
        $this->load->view('admin/commons/new_template', $data);
    }
    // Search filters - search asset register
    public function search_asset_register(){
        if ($this->AccessList()["Assets"]->read == 0) {
            redirect('admin/dashboard');
        }
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Asset Register';
        $data['body'] = 'admin/asset-register';
        $data['breadcrumb'] = array("admin/asset_register" => "Assets List", "Search: " . $search);
        $data['asset_register'] = true;
        $data['results'] = $this->admin_model->search_asset_register($search);
        $this->load->view('admin/commons/new_template', $data);
    }
    // Search filter - search equipment maintenance
    public function search_equip_maintenance(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Equipment Maintenance';
        $data['body'] = 'admin/maintenance';
        $data['results'] = $this->admin_model->search_equip_maintenance($search);
        $this->load->view('admin/commons/template', $data);
    }
    // Search filters - Search contact list
    public function search_contact_list(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Contact List';
        $data['body'] = 'admin/contact_list';
        $data['results'] = $this->admin_model->search_contact_list($search);
        $this->load->view('admin/commons/template', $data);
    }
    // Search filters - Search locations list
    public function search_locations(){
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Locations';
        $data['body'] = 'admin/locations';
        $data['results'] = $this->admin_model->search_locations($search);
        $this->load->view('admin/commons/template', $data);
    }
    // Search filters - search categories
    public function search_categories(){
        if ($this->AccessList()["Categories"]->read == 0) {
            redirect('admin/dashboard');
        }
        $search = $this->input->get('search');
        $data['title'] = 'Search Results > Categories';
        $data['body'] = 'admin/categories';
        $data['results'] = $this->admin_model->search_categories($search);
        $data['breadcrumb'] = array("admin/categories" => "Item Categories", "Search: " . $search);
        $data['search_categories_page'] = true;
        
        $this->load->view('admin/commons/new_template', $data);
    }
    // Search filters - search sub categories
    public function search_sub_categories(){
        if ($this->AccessList()["Categories"]->read == 0) {
            redirect('admin/dashboard');
        }
        $search = $this->input->get('search');
        $cat_id = $this->input->get('cat_id');
        $parent_cat = $this->admin_model->parent_category_name($cat_id);
        $data['title'] = 'Search Results > Categories';
        $data['body'] = 'admin/sub_categories';
        $data['results'] = $this->admin_model->search_sub_categories($cat_id, $search);
        $data['breadcrumb'] = array("admin/categories" => "Item Categories", "admin/sub_categories/" . $cat_id => $parent_cat[0]->cat_name, "Search: " . $search);
        $data['search_sub_categories_page'] = true;

        $this->load->view('admin/commons/new_template', $data);
    }

    //Item register 
    public function product_card($id,$offset = null){
    $employ_id = $this->uri->segment(4);   
        $data['title'] = 'Item Register | Admin & Procurement';
        $data['body'] = 'admin/item_assignment/card';  
        $data['items'] = $this->admin_model->get_item_card($id); 
        $data['current_item'] = $this->admin_model->current_item_assign($id); 
        $data['item'] = $this->admin_model->get_item_card_detail($id); 
        $this->load->view('admin/commons/new_template', $data);
    }

    //Item register 
    public function item_register($offset = null){ 
        if ($this->AccessList()["Register"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
    
        $this->load->library('pagination');
        $url = base_url('admin/item_register');
        $rowscount = $this->admin_model->count_item();

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
        
        $data['title'] = 'Item Register | Admin & Procurement';
        $data['body'] = 'admin/item_assignment/item-register';
        $data['item_register'] = true;
        $data['items'] = $this->admin_model->get_items($limit, $offset);
        $data['breadcrumb'] = array("Item Register");

        $this->load->view('admin/commons/new_template', $data);
    }

    
    //Assign item employee detail 
    public function assigned_item_emp($id){ 
        $employee = $this->admin_model->assigned_item_emp($id);
        echo json_encode($employee); 
    }
    //Available Item list
    public function available_item_list($offset = null){ 
        if ($this->AccessList()["Register"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }

        $this->load->library('pagination');
        $url = base_url('admin/available_item_list');
        $rowscount = $this->admin_model->count_item();

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

        $data['title'] = 'Item Register | Admin & Procurement';
        $data['body'] = 'admin/item_assignment/item-register';
        $data['available_page'] = true;
        $data['items'] = $this->admin_model->get_available_items($limit, $offset); 
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Available List");

        $this->load->view('admin/commons/new_template', $data);
    }
     //Damaget Item list
     public function get_damaged_item($offset = null){ 
        if ($this->AccessList()["Register"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }

        $this->load->library('pagination');
        $url = base_url('admin/get_damaged_item');
        $rowscount = $this->admin_model->count_damaged_item();

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

        $data['title'] = 'Item Register | Admin & Procurement';
        $data['body'] = 'admin/item_assignment/item-register';
        $data['damaged_item'] = true;
        $data['items'] = $this->admin_model->get_damaged_items($limit, $offset); 
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Damaged");

        $this->load->view('admin/commons/new_template', $data);
    }
    //Assign item list
    public function get_assign_item($offset = null){  
        if ($this->AccessList()["Register"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 25;
        if($this->input->get('limit')) {
            $limit = $this->input->get('limit');
        }
        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }

        $this->load->library('pagination');
        $url = 'admin/assign-list';
        $rowscount = $this->admin_model->count_assign_item();

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

        $data['title'] = 'Item Register | Admin & Procurement';
        $data['body'] = 'admin/item_assignment/item-register';
        $data['assign_page'] = true;
        $data['items'] = $this->admin_model->assign_item_list($limit, $offset); 
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Assigned List");
        $this->load->view('admin/commons/new_template', $data);
    }
    //Assign item 
       public function assign_list($offset = null){ 
            $limit = 15;
            if(!empty($offset)){
            $this->uri->segment(3);
            }
        $url = 'admin/item_register';
        $rowscount = $this->admin_model->count_item();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Item Register | Admin & Procurement';
        $data['body'] = 'admin/item_assignment/assign-list';
        $data['items'] = $this->admin_model->assign_list($limit, $offset); 
        $this->load->view('admin/commons/template', $data);
    }
    // item register - add new item.
    public function add_item(){
        if ($this->AccessList()["Register"]->write == 0) {
            redirect('admin/dashboard');
        }
        $data['title'] = 'Item Detail';
        $data['add_page'] = true;
        $data['body'] = 'admin/item_assignment/item-detail';  
        $data['categories'] = $this->admin_model->get_item_categories();
        $data['supplier'] = $this->admin_model->get_item_supplier();
        $data['locations'] = $this->admin_model->get_item_location(); 
        $data['departments'] = $this->admin_model->department(); 
        $data['projects'] = $this->admin_model->project(); 
        $data['status_list'] = $this->admin_model->status_list(); 
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Add Item");
        $this->load->view('admin/commons/new_template', $data);
    }
    // Add new Item into the database
    public function item_save(){  
        $model = $this->input->post('model');
        $result = $this->input->post('type_name');  
        $data = array(
            'location' => $this->input->post('location'),
            'department' => $this->input->post('department'),
            'category' => $this->input->post('category'),
            'sub_category' => $this->input->post('sub_category'),
            'project' => $this->input->post('project'),
            'type_name' => $this->input->post('item_name'),
            'status' => $this->input->post('status'),
            'quantity' => 1,
            'model' => $this->input->post('model'),
            'serial_number' => $this->input->post('serial_number'),
            'supplier' => $this->input->post('supplier'),
            'price' => $this->input->post('price'), 
            'purchasedate' => $this->input->post('purchasedate'),
            'depreciation' => $this->input->post('depreciation'), 
            'added_by' => $this->session->userdata('id'),
            'created_at' => date('Y-m-d')
        );  
        if($this->admin_model->item_save($data, $model, $this->input->post('quantity'))){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Item was added successfully.');
            redirect('admin/item_register');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again later.');
            redirect('admin/item_register');
        }
    }
    // Update an existing asset record
    public function modify_item(){
        $id = $this->input->post('id'); 
        $data = array(
            'department' => $this->input->post('department'),
            'type_name' => $this->input->post('item_name'),
            'status' => $this->input->post('status'),
            'project' => $this->input->post('project'),
            'model' => $this->input->post('model'),
            'serial_number' => $this->input->post('serial_number'),
            'price' => $this->input->post('price'),
            'purchasedate' => $this->input->post('purchasedate'),
            'depreciation' => $this->input->post('depreciation'), 
            'created_at' => date('Y-m-d')
        );
        if($this->admin_model->modify_item($id, $data)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Item was updated successfully.');
            redirect('admin/item_register');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again.');
            redirect('admin/item_register');
        }
    }
    // Item detail
    public function item_detail($id){  
        if ($this->AccessList()["Register"]->update == 0) {
            redirect('admin/dashboard');
        } 
        $data['title'] = 'Item Detail';
        $data['body'] = 'admin/item_assignment/item-detail';
        $data['edit'] = $this->admin_model->item_detail($id);
        $data['categories'] = $this->admin_model->get_item_categories();
        $data['sub_categories'] = $this->admin_model->get_item_sub_category();    
        $data['supplier'] = $this->admin_model->get_item_supplier();
        $data['projects'] = $this->admin_model->project(); 
        $data['departments'] = $this->admin_model->department(); 
        $data['locations'] = $this->admin_model->get_item_location();
        $data['depreciation'] = $this->admin_model->get_item_depreciation($id);
        $data['status_list'] = $this->admin_model->status_list(); 
        $data['edit_item'] = true;
        $data['item_register'] = true;
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Edit Item");
        
        $this->load->view('admin/commons/new_template', $data);
    }
     // Get all sub categories based on cat_id of items
    public function get_item_sub_categories($cat_id){
        $sub_categories = $this->admin_model->get_item_sub_categories($cat_id);
        echo json_encode($sub_categories);
    }
    // Search filters - search asset register
    public function search_item($offset = null){
        $limit = 15;

        if(!empty($offset)){
            $config['uri_segment'] = 3;
        }
        $search = $this->input->get('search'); 
        $this->load->library('pagination');
        $url = base_url('admin/search_item');
        $rowscount = $this->admin_model->count_item_search($search);

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
        
        $data['title'] = 'Search Results > Item List';
        $data['body'] = 'admin/item_assignment/item-register'; 
        $data['assign_flag'] = false; 
        $data['items'] = $this->admin_model->search_items($search, $limit, $offset);
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Search: " . $search);
        $this->load->view('admin/commons/new_template', $data);
    }
    // Delete item
    public function delete_item($id){
        if($this->admin_model->delete_item($id)){
            $this->session->set_flashdata('success', '<strong>Delete! </strong>Item was deleted successfully.');
            redirect('admin/asset_register');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again!');
            redirect('admin/asset_register');
        }
    }
     // Assignment Item List- 
     public function assign_item_list($offset = null){
        if ($this->AccessList()["Register"]->read == 0) {
            redirect('admin/dashboard');
        }
        $limit = 15;
        if(!empty($offset)){
            $this->uri->segment(3);
        } 
        $url = 'admin/assign_item_list';
        $rowscount = $this->admin_model->count_item_assign();
        paginate($url, $rowscount, $limit);
        $data['title'] = 'Assign Item list';
        $data['body'] = 'admin/item_assignment/assign-item-list'; 
        $data['items'] = $this->admin_model->check_assign_list($limit, $offset); 
        $this->load->view('admin/commons/template', $data);
    }
      // Assignment Item form- To employ
      public function assign_item($id){
        $data['title'] = 'Assign Item';
        $data['body'] = 'admin/item_assignment/assign-item'; 
        $data['assign_to'] = $this->admin_model->assign_to();
        $data['assign_by'] = $this->admin_model->assign_by(); 
        $data['get_item'] = $this->admin_model->get_item();  
        $data['get_model'] = $this->admin_model->get_model(); 
        $data['get_category'] = $this->admin_model->get_category(); 
        $data['locations'] = $this->admin_model->get_item_location(); 
        $data['returning_items'] = $this->admin_model->returning_assignment_list($id); 
        $data['breadcrumb'] = array("admin/item_register" => "Item Register", "Assign Item");
        $data['item_register'] = true;
        $this->load->view('admin/commons/new_template', $data);
    }
        // assign_item_save into the database
        public function assign_item_save(){  
        $item_id = $this->input->post('item_id');   
        $assign = $this->input->post('employ');   
        if(!empty($assign)){
        $data = array(
            'assignd_to' => $this->input->post('employ'),
            'assigned_by' => $this->session->userdata('id'),
            'item_id' => $this->input->post('item_id'),   
            'quantity' => 1,  
            'status' => 1,  
            'created_at' => date('Y-m-d'),
        );
        $invantory = array( 
            'status' => 1,   
        );
        $item = array( 
            'status' => 0,   
        );
        $return_back = array( 
            'return_back_date' => null,   
        );
        } 
        if($this->admin_model->assign_item_save($data,$item,$invantory,$item_id)){
            $this->session->set_flashdata('success', '<strong>Success! </strong>Item was assignd successfully.');
            redirect('admin/item_register');
        }else{
            $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again later.');
            redirect('admin/item_register');
        }
        }
        // assign_item_save into the database
        public function return_item(){ 
        $id = $this->input->post('id'); 
         $model_explode = explode('/', $id); 
        $assign_item_id =  $model_explode[0]; 
        $item_id =  $model_explode[1];
        $remarks = $this->input->post('remarks'); 
        $description = $this->input->post('description');
        $file = $this->input->post('userfile'); 
        $config['upload_path']   = './upload/'; 
        $config['allowed_types'] = 'gif|jpg|png';  
        $this->load->library('upload', $config); 
      
        if ( ! $this->upload->do_upload('userfile')) { 
            echo $this->upload->display_errors(); exit;
           $error = array('error' => $this->upload->display_errors()); 
           redirect('admin/item_register');
        }
        else {   
          
           $datas = $this->upload->data(); 
           $fileUpload = $datas['file_name'];  
            $data = array(   
                'remarks' => $remarks,
                'item_file' => $fileUpload,
                'returning_description' => $description, 
                'status' => 0,  
                'return_back_date' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            );  
            $invantory = array( 
                'status' => 0,   
            );
             $item = array( 
                'status' => 1,   
            ); 
            if($this->admin_model->return_item_save($data,$invantory,$item,$item_id,$assign_item_id)){
                $this->session->set_flashdata('success', '<strong>Success! </strong>Item was return back successfully.');
                redirect('admin/item_register');
            }else{
                $this->session->set_flashdata('failed', '<strong>Failed! </strong>Something went wrong, please try again later.');
                redirect('admin/item_register');
            } 
        }
        } 
    // Search filters - search asset register
    public function search_assign_items(){
        $search = $this->input->get('search'); 
        $data['title'] = 'Search Results > Assign Item';
        $data['body'] = 'admin/item_assignment/assign-item-list'; 
        $data['results'] = $this->admin_model->search_assign_item($search);
        $this->load->view('admin/commons/template', $data);
    }   
     // Get all suppliers based on city
     public function get_assign_category($loc_id){
        $get_assign_category = $this->admin_model->get_assign_category($loc_id);
        echo json_encode($get_assign_category);
    }  
    // Get all suppliers based on city
    public function get_location_employ($loc_id){
        $get_location_employ = $this->admin_model->get_location_employ($loc_id);
        echo json_encode($get_location_employ);
    }  
    // Get all suppliers based on city
    public function get_location_suplier(){
       
        $get_location_suplier = $this->admin_model->get_location_suplier();
        echo json_encode($get_location_suplier);
    }   
    // Get all suppliers based on city
    public function get_suplier_email($loc_id){
        $get_suplier_email = $this->admin_model->get_suplier_email($loc_id);
        echo json_encode($get_suplier_email);
    }  
    // Get all item type based on item
    public function get_item_type($item_id){ 
        $get_item_type = $this->admin_model->get_item_type($item_id);
        echo json_encode($get_item_type);
    }  
    // Get item model against item type
    public function get_item_model($item_type){ 
        $get_item_model = $this->admin_model->get_item_model($item_type);
        echo json_encode($get_item_model);
    }
     // Get assign item data against employ
     public function get_employ_data($data){   
        $get_employ_data = $this->admin_model->get_employ_data($data);
        echo json_encode($get_employ_data);
    } 
    // Get item model against item type
    public function get_item_serial_umber($id){
        $get_item_serial_umber = $this->admin_model->get_item_serial_umber($id);
        echo json_encode($get_item_serial_umber);
    }    
    //Item card   
    public function item_card($id,$offset = null){
    $employ_id = $this->uri->segment(4);   
     $data['title'] = 'Item Register | Admin & Procurement';
     $data['body'] = 'admin/item_assignment/item-card';
     $data['items'] = $this->admin_model->get_item_card($id,$employ_id); 
     $data['item'] = $this->admin_model->get_item_card_detail($id);
     $this->load->view('admin/commons/template', $data);
 }
     // 404 page.
    public function page_not_found(){
        echo "We're sorry but the page you're looking for could not be found.";
    }
}
