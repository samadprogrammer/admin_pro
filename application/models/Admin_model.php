<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Admin_model extends CI_Model{
    public function UserRoles() {
        $this->db->from('users_roles');
        return $this->db->get()->result();
    }
    public function EmployeesStatistics() {
        $this->db->select('users.id, users.fullname, users_roles.type as role_type, locations.name as location');
        $this->db->from('users');
        $this->db->join('locations', 'users.location = locations.id', 'left');
        $this->db->join('users_roles', 'users.user_role = users_roles.id', 'left');
        $this->db->group_by('users.id');
        $this->db->order_by('users.id', 'ASC');
        return $this->db->get()->result();
    }
    public function EmployeeAddedItems($id) {
        $this->db->select('COUNT(added_by) AS total');
        $this->db->from('items');
        $this->db->where('added_by', $id);
        return $this->db->get()->result();
    }
    public function EmployeeAssignedItems($id) {
        $this->db->select('COUNT(assigned_by) AS total');
        $this->db->from('item_assignment');
        $this->db->where('assigned_by', $id);
        return $this->db->get()->result();
    }
    public function EmployeeAddedSuppliers($id) {
        $this->db->select('COUNT(added_by) AS total');
        $this->db->from('suppliers');
        $this->db->where('added_by', $id);
        return $this->db->get()->result();
    }
    
    // Get User Role
    public function component_access_list($component_type) {
        $this->db->select('users_roles.title, acl_configuration.component, acl_configuration.read, acl_configuration.write, acl_configuration.update, acl_configuration.delete');
        $this->db->from('users_roles');
        $this->db->join('acl_configuration', 'users_roles.id = acl_configuration.role_id', 'left');
        $this->db->join('acl_components', 'acl_configuration.component = acl_components.id', 'left');
        $this->db->where('acl_components.type', $component_type);
        return $this->db->get()->result();
    }
    // Get pending requisitions.
    public function pending_requisitions(){
        $this->db->select('item_requisitions.id,
                            item_requisitions.item_name,
                            item_requisitions.item_desc,
                            item_requisitions.item_qty,
                            item_requisitions.requested_by,
                            item_requisitions.status,
                            item_requisitions.created_at,
                            item_requisitions.updated_at,
                            users.id as user_id,
                            users.fullname,
                            users.location,
                            users.supervisor,
                            inventory.id as inv_id,
                            inventory.name as inv_name,
                            sub_categories.id as sub_cat_id,
                            sub_categories.name as sub_cat_name,
                            categories.id as cat_id,
                            categories.cat_name');
        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $this->db->join('inventory', 'item_requisitions.item_name = inventory.id', 'left');
        $this->db->join('sub_categories', 'item_requisitions.item_name = sub_categories.id', 'left');
        $this->db->join('categories', 'sub_categories.cat_id = categories.id', 'left');
        $this->db->where('item_requisitions.status', 0);
        $this->db->order_by('id', 'DESC');
        // $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Get approved requisitions.
    public function approved_requisitions($limit, $offset){
        $this->db->select('item_requisitions.id,
                            item_requisitions.item_name,
                            item_requisitions.item_desc,
                            item_requisitions.item_qty,
                            item_requisitions.requested_by,
                            item_requisitions.status,
                            item_requisitions.created_at,
                            item_requisitions.updated_at,
                            users.id as user_id,
                            users.fullname,
                            users.location,
                            users.supervisor,
                            inventory.id as inv_id,
                            inventory.name as inv_name,
                            sub_categories.id as sub_cat_id,
                            sub_categories.name as sub_cat_name,
                            categories.id as cat_id,
                            categories.cat_name');
        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $this->db->join('inventory', 'item_requisitions.item_name = inventory.id', 'left');
        $this->db->join('sub_categories', 'item_requisitions.item_name = sub_categories.id', 'left');
        $this->db->join('categories', 'sub_categories.cat_id = categories.id', 'left');
        $this->db->where('item_requisitions.status', 1);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Get rejected requisitions.
    public function rejected_requisitions($limit, $offset){
        $this->db->select('item_requisitions.id,
                            item_requisitions.item_name,
                            item_requisitions.item_desc,
                            item_requisitions.item_qty,
                            item_requisitions.requested_by,
                            item_requisitions.status,
                            item_requisitions.created_at,
                            item_requisitions.updated_at,
                            users.id as user_id,
                            users.fullname,
                            users.location,
                            users.supervisor,
                            inventory.id as inv_id,
                            inventory.name as inv_name,
                            sub_categories.id as sub_cat_id,
                            sub_categories.name as sub_cat_name,
                            categories.id as cat_id,
                            categories.cat_name');
        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $this->db->join('inventory', 'item_requisitions.item_name = inventory.id', 'left');
        $this->db->join('sub_categories', 'item_requisitions.item_name = sub_categories.id', 'left');
        $this->db->join('categories', 'sub_categories.cat_id = categories.id', 'left');
        $this->db->where('item_requisitions.status', 2);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // View requisition detail.
    public function request_detail($id){
        $this->db->select('item_requisitions.id,
                            item_requisitions.item_name,
                            item_requisitions.item_desc,
                            item_requisitions.item_qty,
                            item_requisitions.requested_by,
                            item_requisitions.status,
                            item_requisitions.created_at,
                            item_requisitions.updated_at,
                            users.id as user_id,
                            users.fullname,
                            users.location,
                            users.supervisor,
                            users.email,
                            users.user_role,
                            inventory.id as inv_id,
                            inventory.name as inv_name,
                            sub_categories.id as sub_cat_id,
                            sub_categories.name as sub_cat_name,
                            categories.id as cat_id,
                            categories.cat_name,
                            locations.id as loc_id,
                            locations.name as loc_name');
        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $this->db->join('inventory', 'item_requisitions.item_name = inventory.id', 'left');
        $this->db->join('sub_categories', 'inventory.name = sub_categories.id', 'left');
        $this->db->join('categories', 'sub_categories.cat_id = categories.id', 'left');
        $this->db->join('locations', 'users.location = locations.id', 'left');
        $this->db->where('item_requisitions.id', $id);
        $this->db->order_by('id', 'DESC');
        return $this->db->get()->row();
    }
    // Count pending requisitions
    public function total_pending(){
        return $this->db->from('item_requisitions')->where(array('status' => 0))->count_all_results();
    }
    // Count approved requisitions
    public function total_approved(){
        return $this->db->from('item_requisitions')->where(array('status' => 1))->count_all_results();
    }
    // Count rejected requisitions
    public function total_rejected(){
        return $this->db->from('item_requisitions')->where(array('status' => 2))->count_all_results();
    }
    // Approve request.
    public function approve_request($id, $data){
        $this->db->where('id', $id);
        $this->db->update('item_requisitions', $data);
        return true;
    }
    // Model for Updating Asset Access
    public function access_update($data, $role_id, $component) {
        $this->db->where('role_id', $role_id);
        $this->db->where('component', $component);
        $this->db->update('acl_configuration', $data);
        return true;
    }
    // Model for Updating Asset Access
    public function update_supervisor_asset_access($data) {
        $this->db->where('config', 'SUPERVISOR_ASSET_ACCESS');    
        $this->db->update('acl_configuration', $data);
        return true;
    }
    // Model for Requesting Asset Access Configs
    public function request_db_configs($user_role) {
        $this->db->from('acl_configuration');
        $this->db->where('role_id', $user_role);
        return $this->db->get()->result();
    }
    // Reject request.
    public function reject_request($id, $data){
        $this->db->where('id', $id);
        $this->db->update('item_requisitions', $data);
        return true;
    }
    // Suppliers - Add new supplier
    public function add_supplier($data){
        $this->db->insert('suppliers', $data);
        $id = $this->db->insert_id();
        return $id;
    }
    // Count suppliers
    public function count_suppliers(){
        $this->db->from('suppliers');
        $this->db->where(array('status' => 1));
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('suppliers.location', $this->session->userdata('location'));
        }
        return $this->db->count_all_results();
    }
    // Count acl_components
    public function count_acl_components(){
        $this->db->from('acl_components');
        return $this->db->count_all_results();
    }
    // Count users_roles
    public function count_users_roles(){
        $this->db->from('users_roles');
        return $this->db->count_all_results();
    }
    // Count suppliers
    public function count_suppliers_week_change(){
        $this->db->from('suppliers');
        $this->db->where(array('status' => 1));
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('suppliers.location', $this->session->userdata('location'));
        }
        $this->db->where('suppliers.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }
    // Count suppliers
    public function count_suppliers_last_week_change(){
        $this->db->from('suppliers');
        $this->db->where(array('status' => 1));
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('suppliers.location', $this->session->userdata('location'));
        }
        $this->db->where('(suppliers.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK))');
        return $this->db->count_all_results();
    }
    // Get suppliers
    public function get_suppliers($limit, $offset){
        $this->db->select('suppliers.id as sup_id, suppliers.name sup_name, suppliers.category, suppliers.email, suppliers.phone, suppliers.location, suppliers.region,suppliers.ntn_number,suppliers.rating, suppliers.address, suppliers.status, suppliers.created_at,locations.id,locations.name,categories.id as cat_id,categories.cat_name');
        $this->db->from('suppliers');
        $this->db->join('locations', 'suppliers.location = locations.id', 'left');
        $this->db->join('categories', 'suppliers.category = categories.id', 'left');
        $this->db->where('status', 1);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('suppliers.location', $this->session->userdata('location'));
        }
        $this->db->order_by('suppliers.rating', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Remove supplier
    public function delete_supplier($id,$data){
        $this->db->where('id', $id);
        $this->db->update('suppliers',$data);
        return true;
    }
    // Get supplier for edit by id
    public function edit_supplier($id){
        $this->db->select('id, name, category, email, phone, location, region,ntn_number,rating ,address, status, created_at');
        $this->db->from('suppliers');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Update supplier by ID.
    public function update_supplier($id, $data){
        $this->db->where('id', $id);
        $this->db->update('suppliers', $data);
        return true;
    }
    // Inventory - Add inventory.
    public function add_inventory($data){
        $this->db->insert('inventory', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Count inventory.
    public function count_inventory(){
        return $this->db->from('inventory')->count_all_results();
    }
    // get inventory for adding an inventory
    public function get_categories(){
        return $this->db->from('categories')->get()->result();
    }
    // Get sub categories based on cat_id
    public function get_sub_categories($cat_id){
        $this->db->select('id, name');
        $this->db->from('sub_categories');
        $this->db->where('cat_id', $cat_id);
        return $this->db->get()->result();
    }
   // Sub sub_categories for asset list > List sub categories
   public function invoice_sub_categories($id){
    $this->db->select('sub_categories.id, sub_categories.cat_id, sub_categories.name, assets.id as asset_id, assets.sub_categories');
    $this->db->from('sub_categories'); 
    $this->db->join('assets', 'sub_categories.id = assets.sub_categories', 'left');
    $this->db->where('assets.id', $id);
    return $this->db->get()->result();
}
    // Inventory - Get inventory.
    public function get_inventory($limit, $offset){
        $this->db->select('inventory.id,
                            inventory.category,
                            inventory.name,
                            inventory.status,
                            inventory.item_qty,
                            inventory.unit_price,
                            inventory.created_at,
                            categories.id as cat_id,
                            categories.cat_name,
                            categories.cat_location,
                            sub_categories.id as sub_cat_id,
                            sub_categories.name as sub_cat_name,
                            locations.name as loc_name');
        $this->db->from('inventory');
        $this->db->join('categories', 'inventory.category = categories.id', 'left');
        $this->db->join('sub_categories', 'inventory.name = sub_categories.id', 'left');
        $this->db->join('locations', 'categories.cat_location = locations.id', 'left');
        $this->db->where('status', '0');
        $this->db->order_by('inventory.id', 'DESC');
        $this->db->group_by('inventory.id');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
        // get_assign_inventory - Get assign inventory.
        public function get_assign_inventory($limit, $offset){
            $this->db->select('inventory.id,
                                inventory.category,
                                inventory.name,
                                inventory.status,
                                inventory.item_qty,
                                inventory.unit_price,
                                inventory.created_at,
                                categories.id as cat_id,
                                categories.cat_name,
                                categories.cat_location,
                                sub_categories.id as sub_cat_id,
                                sub_categories.name as sub_cat_name,
                                locations.name as loc_name');
            $this->db->from('inventory');
            $this->db->join('categories', 'inventory.category = categories.id', 'left');
            $this->db->join('sub_categories', 'inventory.name = sub_categories.id', 'left');
            $this->db->join('locations', 'categories.cat_location = locations.id', 'left');
            $this->db->where('status', '1');
            $this->db->order_by('inventory.id', 'DESC');
            $this->db->group_by('inventory.id');
            $this->db->limit($limit, $offset);
            return $this->db->get()->result();
        }
    // Edit inventory - Get record for edit.
    public function edit_inventory($id){
        $this->db->select('id, created_at');
        $this->db->from('inventory');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Update Inventory
    public function update_inventory($id, $data){
        $this->db->where('id', $id);
        $this->db->update('inventory', $data);
        return true;
    }
    // Remove inventory.
    public function delete_inventory($id){
        $this->db->where('id', $id);
        $this->db->delete('inventory');
        return true;
    }
    // Count users.
    public function count_users(){
        return $this->db->from('users')->count_all_results();
    }
    // Users - Get all users
    public function get_users($limit, $offset){
        $this->db->select('id, fullname, email, username, location, user_role, created_at');
        $this->db->from('users');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Users = Remove users.
    public function delete_user($id){
        $this->db->where('id', $id);
        $this->db->delete('users');
        return true;
    }
    // Invoices - Add invoice
    public function add_invoice($data){
        $this->db->insert('invoices', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
  // Get employ for edit by id
  public function edit_invoice($id){
     $this->db->select('invoices.id, 
                        invoices.inv_no, 
                        invoices.inv_date, 
                        invoices.project, 
                        invoices.supplier, 
                        invoices.file, 
                        invoices.vendor, 
                        invoices.region,
                        invoices.item, 
                        invoices.amount,
                        invoices.inv_desc, 
                        invoices.status,
                        invoices.created_at,
                        projects.id as project_id,
                        projects.project_name,
                        ');
    $this->db->from('invoices'); 
    $this->db->join('projects', 'invoices.project = projects.id', 'left');
    $this->db->where('invoices.id', $id);
    return $this->db->get()->row();
} 
// Update employ by ID.
public function update_invoice($id, $data){
    $this->db->where('id', $id);
    $this->db->update('invoices', $data);
    return true;
}

    // Get suppliers for inovice form
    public function get_suppliers_for_invoice(){
        $this->db->select('id, name');
        $this->db->from('suppliers');
        $this->db->where('status', 1);
        return $this->db->get()->result();
    }
    // Count invoices.
    public function count_invoices(){
        return $this->db->from('invoices')->count_all_results();
    }
    
      // get suppliers for invoice form
      public function suppliers(){
        $this->db->select('id,name as sup_name');
        $this->db->from('suppliers');  
        return $this->db->get()->result(); 
    }
    
    // Invoices - Get invoices
    public function get_invoices($limit, $offset){
     $this->db->select('invoices.id,
                        invoices.inv_no, 
                        invoices.inv_date, 
                        invoices.project, 
                        invoices.supplier, 
                        invoices.vendor, 
                        invoices.region, 
                        invoices.item,
                        invoices.amount,
                        invoices.inv_desc, 
                        invoices.status_reason, 
                        invoices.status, 
                        invoices.created_at,
                        locations.id as loc_id,
                        locations.name,
                        suppliers.id as sup_id,
                        suppliers.name as sup_name,
                        projects.id as project_id,
                        projects.project_name');
        $this->db->from('invoices');
        $this->db->join('locations', 'invoices.region = locations.id', 'left');
        $this->db->join('suppliers', 'invoices.supplier = suppliers.id', 'left');
        $this->db->join('projects', 'invoices.project = projects.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('invoices.id', 'DESC');
        return $this->db->get()->result();
    }
    // Invoices - print invoice
    public function print_invoice($id){
                        $this->db->select('invoices.id, 
                        invoices.inv_no, 
                        invoices.inv_date, 
                        invoices.project, 
                        invoices.vendor, 
                        invoices.region, 
                        invoices.item, 
                        invoices.amount, 
                        invoices.inv_desc, 
                        invoices.status, 
                        invoices.created_at,
                        locations.id as loc_id,
                        locations.name,
                        projects.id as project_id,
                        projects.project_name');
        $this->db->from('invoices');
        $this->db->join('locations','invoices.region = locations.id','left');
        $this->db->join('projects','invoices.project = projects.id','left');
        $this->db->where('invoices.id', $id);
        return $this->db->get()->row();
    }
    // Invoices - status change to cleared.
    public function update_status($id, $data){
        $this->db->where('id', $id);
        $this->db->update('invoices', $data);
        return true;
    }
       // Invoices - status change to pending.
       public function invoice_status_pending($id, $data){
        $this->db->where('id', $id);
        $this->db->update('invoices', $data);
        return true;
    }
    // Invoices - Remove invoice
    public function delete_invoice($id){
        $this->db->where('id', $id);
        $this->db->delete('invoices');
        return true;
    }
      // Invoice image - Remove from invoice invoice
      public function invoice_file($id){
        $this->db->select('id,file');
        $this->db->from('invoices');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Projects - Add project
    public function save_project($data){
        $this->db->insert('projects', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Projects - Get projects.
    public function get_projects($limit, $offset){
        $this->db->select('id, project_name, project_desc, status, created_at');
        $this->db->from('projects');
        // $this->db->where('status', 1);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    
    // Count all projects from projects 
    public function count_projects(){
        $this->db->from('projects'); 
        return $this->db->count_all_results();
    }
       // get projects for add invoice form
       public function inoice_project($id = null){
        $this->db->select('id,project_name');
        $this->db->from('projects');
        return $this->db->get()->result(); 
    }     

    // get projects for add item form
    public function project($id = null){
        $this->db->select('projects.id,projects.project_name,invoices.id as inv_id,invoices.project');
        $this->db->from('projects');
        $this->db->join('invoices', 'projects.id = invoices.project', 'left');
        $this->db->where('invoices.id',$id);
        return $this->db->get()->result(); 
    }
    // get suppliers for edit invoice form
    public function invoice_supplier($id = null){
        $this->db->select('suppliers.id,suppliers.name as sup_name,invoices.id as inv_id,invoices.supplier');
        $this->db->from('suppliers');
        $this->db->join('invoices', 'suppliers.id = invoices.supplier', 'left'); 
        return $this->db->get()->result(); 
    }
    // get department for add item form
    public function department(){
        return $this->db->from('departments')->get()->result();
    }
    
    // Project - Get project by id
    public function edit_project($id){
        $this->db->select('id, project_name, project_desc,status');
        $this->db->from('projects');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Projects - Update project
    public function update_project($id, $data){
        $this->db->where('id', $id);
        $this->db->update('projects', $data);
        return true;
    }
    // Projects - Active project
    public function active_project($id, $data){
        $this->db->where('id', $id);
        $this->db->update('projects',$data);
        return true;
    }
    // Projects - De Active project
    public function de_active_project($id, $data){
        $this->db->where('id', $id);
        $this->db->update('projects',$data);
        return true;
    } 
    // Search projects / company
    public function search_project($search){
        $this->db->select('id, project_name, project_desc,status,created_at');
        $this->db->from('projects');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('assets.location', $this->session->userdata('location'));
        }
        
        $this->db->group_start(); //start group
        $this->db->like('project_name', $search);
        $this->db->or_like('project_desc', $search); 
        $this->db->group_end(); //close group

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Expenses - region based - Islamabad
    public function expenses_isbd(){
        $this->db->select('SUM(IF(region="islamabad", amount, 0)) as isbd_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'islamabad', 'status' => 1, 'project !=' => 'CTC OWN'));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Expenses - CTC Own Isbd
    public function ctc_own_isbd(){
        $this->db->select('SUM(IF(project="CTC OWN", amount, 0)) as ctc_own_isbd');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'islamabad', 'status' => 1));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Expenses - region based - Balochistan
    public function expenses_bln(){
        $this->db->select('SUM(IF(region="balochistan", amount, 0)) as bln_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'balochistan', 'status' => 1, 'project !=' => 'CTC OWN'));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
        // List locations for supplier form
        public function list_locations_suppliers(){
            $this->db->select('id, name');
            $this->db->from('locations');
            return $this->db->get()->result();
        }
        
    // get inventory for adding an inventory
    public function get_item_categories(){
        return $this->db->from('categories')->get()->result();
    }
    // get status list
    public function status_list(){
        $this->db->select('item_status.id, item_status.type');
        $this->db->from('item_status');
        return $this->db->get()->result();
    }
    // Expenses - ctc own Bln
    public function ctc_own_bln(){
        $this->db->select('SUM(IF(project="CTC OWN", amount, 0)) as ctc_own_bln');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'balochistan', 'status' => 1));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Expenses - region based - Khyber PK
    public function expenses_kp(){
        $this->db->select('SUM(IF(region="khyber PK", amount, 0)) as kp_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'khyber PK', 'status' => 1, 'project !=' => 'CTC OWN'));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Expenses - ctc own KP
    public function ctc_own_kp(){
        $this->db->select('SUM(IF(project="CTC OWN", amount, 0)) as ctc_own_kp');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'khyber PK', 'status' => 1));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Expenses - region based - Sindh
    public function expenses_sindh(){
        $this->db->select('SUM(IF(region="sindh", amount, 0)) as sindh_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'sindh', 'status' => 1, 'project !=' => 'CTC OWN'));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
   // Expenses - ctc own Sindh
   public function ctc_own_sindh(){
    $this->db->select('SUM(IF(project="CTC OWN", amount, 0)) as ctc_own_sindh');
    $this->db->from('invoices');
    $this->db->where(array('region' => 'sindh', 'status' => 1));
    $this->db->like('inv_date', date('Y-m'));
    return $this->db->get()->row();
   } 
    // Expenses - region based - Sindh
    public function expenses_punjab(){
        $this->db->select('SUM(IF(region="punjab", amount, 0)) as punjab_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'sindh', 'status' => 1, 'project !=' => 'CTC OWN'));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Expenses - ctc own Punjab
    public function ctc_own_punjab(){
        $this->db->select('SUM(IF(project="CTC OWN", amount, 0)) as ctc_own_punjab');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'sindh', 'status' => 1));
        $this->db->like('inv_date', date('Y-m'));
        return $this->db->get()->row();
    }
    // Equipment maintenance - Add new record
    public function add_maint_record($data){
        $this->db->insert('equipment_maintenance', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Overall stats - Islamabad
    public function overall_stats_isbd(){
        $this->db->select('SUM(amount) as isbd_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'islamabad', 'status' => 1));
        return $this->db->get()->row();
    }
    // Overall stats - Balochistan
    public function overall_stats_bln(){
        $this->db->select('SUM(amount) as bln_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'balochistan', 'status' => 1));
        return $this->db->get()->row();
    }
    // Overall stats - Khyber PK
    public function overall_stats_khyber(){
        $this->db->select('SUM(amount) as kp_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'khyber PK', 'status' => 1));
        return $this->db->get()->row();
    }
    // Overall stats - Sindh
    public function overall_stats_sindh(){
        $this->db->select('SUM(amount) as sindh_total');
        $this->db->from('invoices');
        $this->db->where(array('region' => 'sindh', 'status' => 1));
        return $this->db->get()->row();
    }
    // Overall stats - Annual expenses
    public function annual_expenses(){
        $this->db->select('SUM(amount) as annual_expenses');
        $this->db->from('invoices');
        $this->db->where('status', 1);
        $this->db->like('inv_date', date('Y'));
        return $this->db->get()->row();
    }
    // Count maintenance record.
    public function count_maint_record(){
        return $this->db->from('equipment_maintenance')->count_all_results();
    }
    // Equipment maintenance - Get maintenance record
    public function get_maint_record($limit, $offset){
        $this->db->select('id, region, maint_date, maint_cat, maint_desc, vendor, qty_size, unit_price, total_amount, maint_remarks, created_at');
        $this->db->from('equipment_maintenance');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Equipment maintenance = Delete record
    public function delete_maint_record($id){
        $this->db->where('id', $id);
        $this->db->delete('equipment_maintenace');
        return true;
    }
    // Assets - Add new item
    public function add_item($data){
        $this->db->insert('assets', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Count all items for asset register
    public function count_assets(){
        $this->db->from('assets');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('assets.location', $this->session->userdata('location'));
        }
        return $this->db->count_all_results();
    }
    // Get assets/items.
    public function get_assets($limit, $offset){
        $this->db->select('assets.id, 
        assets.date, 
        assets.category, 
        assets.description, 
        assets.quantity, 
        assets.purchase_date, 
        assets.location, 
        assets.user,
        assets.remarks, 
        assets.created_at,
        locations.id as loc_id,
        locations.name,
        categories.id as cat_id,
        categories.cat_name,
        users.id as user_ids,
        users.fullname');
        $this->db->from('assets');
        $this->db->join('locations', 'assets.location = locations.id', 'left');
        $this->db->join('categories', 'assets.category = categories.id', 'left');
        $this->db->join('users', 'assets.user = users.id', 'left');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('assets.location', $this->session->userdata('location'));
        }
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Asset detail - view and edit.
    public function asset_detail($id){ 
        $this->db->select('assets.id, 
                        assets.date,
                        assets.category,
                        assets.sub_categories,
                        assets.description,
                        assets.quantity, 
                        assets.price, 
                        assets.purchase_date, 
                        assets.location, 
                        assets.designation, 
                        assets.user,remarks,
                        assets.created_at,
                        locations.id as loc_id,
                        locations.name,
                        sub_categories.id as sub_id,
                        sub_categories.name,');
        $this->db->from('assets');
        $this->db->join('locations', 'assets.location = locations.id', 'left');
        $this->db->join('sub_categories', 'assets.sub_categories = sub_categories.id', 'left');
        $this->db->where('assets.id', $id); 
        // echo "<pre>";
        // print_r($this->db->get()->row());exit;
        return $this->db->get()->row();
    } 
    // Asset detail - Update existing record
    public function update_item($id, $data){
        $this->db->where('id', $id);
        $this->db->update('assets', $data);
        return true;
    }
    // Asset register - Delete an asset
    public function delete_asset($id){
        $this->db->where('id', $id);
        $this->db->delete('assets');
        return true;
    }
    // Count contacts
    public function count_contacts(){
        return $this->db->from('contact_list')->count_all_results();
    }
    // Contact list - get all contacts.
    public function get_contacts($limit, $offset){
        $this->db->select('*');
        $this->db->from('contact_list');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Contact list - Add new contact
    public function add_contact($data){
        $this->db->insert('contact_list', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Contact list - Contact detail
    public function contact_detail($id){
        $this->db->select('*');
        $this->db->from('contact_list');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // contact list - update contact.
    public function update_contact($id, $data){
        $this->db->where('id', $id);
        $this->db->update('contact_list', $data);
        return true;
    }
    // Contact list - Delete contact.
    public function delete_contact($id){
        $this->db->where('id', $id);
        $this->db->delete('contact_list');
        return true;
    }
    // count location to add pagination.
    public function count_locations(){
        $this->db->from('locations');
        return $this->db->count_all_results();
    }

    // count location to add pagination.
    public function count_locations_week_change(){
        $this->db->from('locations');
        $this->db->where('locations.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }

    // count location to add pagination.
    public function count_locations_last_week_change(){
        $this->db->from('locations');
        $this->db->where('locations.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK)');
        return $this->db->count_all_results();
    }

    // Locations - Get locations
    public function get_locations($limit, $offset){
        $this->db->select('id, name, province, created_at');
        $this->db->from('locations');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Location - Add new location
    public function add_location($data){
        $this->db->insert('locations', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Locations - get location by ID for edit
    public function edit_location($id){
        $this->db->select('id, name, province');
        $this->db->from('locations');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Locations - Update location
    public function update_location($id, $data){
        $this->db->where('id', $id);
        $this->db->update('locations', $data);
        return true;
    }
    // Location - Delete location
    public function delete_location($id){
        $this->db->where('id', $id);
        $this->db->delete('locations');
        return true;
    }
    // count leaves
    public function count_leaves(){
        return $this->db->from('employee_leaves')->count_all_results();
    }
    // Total travel requests.
    public function total_travel_requests(){
        return $this->db->from('travel_hotel_stay')->count_all_results();
    }
    // Count all travel requisitions for logged in supervisor.
    public function total_travel_requisitions($limit, $offset){
        $this->db->select('travel_hotel_stay.*,
                            users.id as user_id,
                            users.fullname,
                            users.department,
                            users.supervisor');
        $this->db->from('travel_hotel_stay');
        $this->db->join('users', 'travel_hotel_stay.requested_by = users.id', 'left');
        $this->db->limit($limit, $offset);
        $this->db->order_by('travel_hotel_stay.created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Travel detail > Print travel request form.
    // Count all travel requisitions for logged in supervisor.
    public function print_travel($travel_id){
        $this->db->select('travel_hotel_stay.*,
                            users.id as user_id,
                            users.fullname,
                            users.department,
                            users.supervisor');
        $this->db->from('travel_hotel_stay');
        $this->db->join('users', 'travel_hotel_stay.requested_by = users.id', 'left');
        $this->db->where('travel_hotel_stay.id', $travel_id);
        return $this->db->get()->row();
    }
    // Count categories
    public function count_categories(){
        $this->db->from('categories');
        return $this->db->count_all_results();
    }

    // Count categories (week change)
    public function count_categories_week_change(){
        $this->db->from('categories');
        $this->db->where('categories.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }

    // Count categories (2 weeks change)
    public function count_categories_last_week_change(){
        $this->db->from('categories');
        $this->db->where('categories.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK)');
        return $this->db->count_all_results();
    }

    // Categories > List categories and sub categories
    public function categories($limit, $offset){
        $this->db->select('categories.id,
                            categories.cat_name,
                            categories.added_by,
                            categories.cat_location,
                            categories.created_at,
                            users.fullname,
                            locations.name');
        $this->db->from('categories');
        $this->db->join('users', 'categories.added_by = users.id', 'left');
        $this->db->join('locations', 'categories.cat_location = locations.id', 'left');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
    // Add category.
    public function add_category($data){
        $this->db->insert('categories', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Edit category > Get category by ID to update.
    public function edit_category($id){
        $this->db->select('id, cat_name, cat_location');
        $this->db->from('categories');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Update category
    public function update_category($id, $data){
        $this->db->where('id', $id);
        $this->db->update('categories', $data);
        return true;
    }
    // Delete category by ID
    public function delete_category($id){
        $this->db->where('id', $id);
        $this->db->delete('categories');
        return true;
    }
    // Get Parent Category Name
    public function parent_category_name($cat_id){
        $this->db->select('categories.cat_name');
        $this->db->from('categories');
        $this->db->where('categories.id', $cat_id); 
        return $this->db->get()->result();
    }
    // Sub Categories > List sub categories
    public function sub_categories($cat_id){
        $this->db->select('sub_categories.id, sub_categories.cat_id, sub_categories.name, sub_categories.added_by, sub_categories.created_at, categories.id as parent_cat, categories.cat_name, users.fullname');
        $this->db->from('sub_categories');
        $this->db->join('categories', 'sub_categories.cat_id = categories.id', 'left');
        $this->db->join('users', 'sub_categories.added_by = users.id', 'left');
        $this->db->where('categories.id', $cat_id); 
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Add sub category
    public function add_sub_category($data){
        $this->db->insert('sub_categories', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
    // Edit sub category
    public function edit_sub_category($id){
        $this->db->select('id, name');
        $this->db->from('sub_categories');
        $this->db->where('id', $id);
        return $this->db->get()->row();
    }
    // Update sub category by ID
    public function update_sub_category($id, $data){
        $this->db->where('id', $id);
        $this->db->update('sub_categories', $data);
        return true;
    }
    // Delete sub category by ID
    public function delete_sub_category($id){
        $this->db->where('id', $id);
        $this->db->delete('sub_categories');
        return true;
    }
    //== ----------------------------------------- Search filters --------------------------------------- ==\\
    // Search filters - suppliers search
    public function search_suppliers($search){
        $this->db->select('id, name, category, email, phone, location,ntn_number,category,rating, region, address, status, created_at');
        $this->db->from('suppliers');
        $this->db->like('name', $search);
        $this->db->or_like('category', $search);
        $this->db->or_like('region', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - inventory search
    public function search_inventory($search){
        $this->db->select('inventory.id,
                            inventory.category,
                            inventory.name,
                            inventory.item_qty,
                            inventory.unit_price,
                            inventory.created_at,
                            categories.id as cat_id,
                            categories.cat_name,
                            categories.cat_location,
                            sub_categories.id as sub_cat_id,
                            sub_categories.name as sub_cat_name,
                            locations.name as loc_name');
        $this->db->from('inventory');
        $this->db->join('categories', 'inventory.category = categories.id', 'left');
        $this->db->join('sub_categories', 'inventory.name = sub_categories.id', 'left');
        $this->db->join('locations', 'categories.cat_location = locations.id', 'left');
        $this->db->like('inventory.name', $search);
        $this->db->or_like('inventory.item_desc', $search);
        $this->db->or_like('categories.cat_name', $search);
        // $this->db->or_like('locations.name', $search);
        $this->db->group_by('inventory.id');
        $this->db->order_by('inventory.created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - users search
    public function search_users($search){
        $this->db->select('id, fullname, email, username, location, user_role, created_at');
        $this->db->from('users');
        $this->db->like('fullname', $search);
        $this->db->or_like('username', $search);
        $this->db->or_like('location', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - invoices search
    public function search_invoices($search){
                    $this->db->select('invoices.id, 
                    invoices.inv_no, 
                    invoices.inv_date, 
                    invoices.project, 
                    invoices.supplier, 
                    invoices.region, 
                    invoices.item, 
                    invoices.amount, 
                    invoices.inv_desc, 
                    invoices.status, 
                    invoices.created_at,
                    locations.id as loc_id,
                    locations.name,
                    suppliers.id as sup_id,
                    suppliers.name as sup_name,
                    projects.id as project_id,
                    projects.project_name');
        $this->db->from('invoices');
        $this->db->join('locations','invoices.region = locations.id');
        $this->db->join('suppliers','invoices.supplier = suppliers.id');
        $this->db->join('projects','invoices.project = projects.id');
        $this->db->like('inv_no', $search);
        $this->db->or_like('project', $search);
        $this->db->or_like('suppliers.name', $search); 
        $this->db->or_like('invoices.region', $search);
        $this->db->or_like('item', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - assets search
    public function search_asset_register($search){
        $this->db->select('assets.id, 
        assets.date, 
        assets.category, 
        assets.description, 
        assets.quantity, 
        assets.purchase_date, 
        assets.location, 
        assets.designation, 
        assets.user,
        assets.remarks, 
        assets.created_at,
        categories.id,
        categories.cat_name,');
        $this->db->from('assets');
        $this->db->join('categories', 'assets.category = categories.id', 'left'); 
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('assets.location', $this->session->userdata('location'));
        }
        
        $this->db->group_start(); //start group
        $this->db->like('category', $search);
        $this->db->or_like('description', $search);
        $this->db->or_like('quantity', $search);
        $this->db->or_like('purchase_date', $search);
        $this->db->or_like('location', $search);
        $this->db->or_like('designation', $search);
        $this->db->or_like('user', $search);
        $this->db->or_like('remarks', $search); 
        $this->db->group_end(); //close group

        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - equipment maintenance search
    public function search_equip_maintenance($search){
        $this->db->select('id, region, maint_date, maint_cat, maint_desc, vendor, qty_size, unit_price, total_amount, maint_remarks, created_at');
        $this->db->from('equipment_maintenance');
        $this->db->like('region', $search);
        $this->db->or_like('maint_cat', $search);
        $this->db->or_like('maint_desc', $search);
        $this->db->or_like('vendor', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - contact list search
    public function search_contact_list($search){
        $this->db->select('*');
        $this->db->from('contact_list');
        $this->db->like('name', $search);
        $this->db->or_like('project', $search);
        $this->db->or_like('province', $search);
        $this->db->or_like('gender', $search);
        $this->db->or_like('grader', $search);
        $this->db->or_like('designation', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - locations list search
    public function search_locations($search){
        $this->db->select('id, name, province, created_at');
        $this->db->from('locations');
        $this->db->like('name', $search);
        $this->db->or_like('province', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - locations list search
    public function search_categories($search){
        $this->db->select('categories.id,
                            categories.cat_location,
                            categories.cat_name,
                            categories.created_at,
                            locations.name,
                            users.fullname');
        $this->db->from('categories');
        $this->db->join('locations', 'categories.cat_location = locations.id', 'left');
        $this->db->join('users', 'categories.added_by = users.id', 'left');
        $this->db->like('categories.cat_name', $search);
        $this->db->or_like('locations.name', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Search filters - locations list search
    public function search_sub_categories($cat_id, $search){
        $this->db->select('sub_categories.id, sub_categories.cat_id, sub_categories.name, sub_categories.added_by, sub_categories.created_at, categories.id as parent_cat, categories.cat_name, users.fullname');
        $this->db->from('sub_categories');
        $this->db->join('categories', 'sub_categories.cat_id = categories.id', 'left');
        $this->db->join('users', 'sub_categories.added_by = users.id', 'left');
        $this->db->like('sub_categories.name', $search);
        $this->db->where('sub_categories.cat_id = ' . $cat_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    } 
    // Count all items by search
    public function count_item_search($search){
        $this->db->select('items.id, items.location, items.*, sub_categories.name as names, categories.cat_name');
        $this->db->from('items');
        $this->db->join('categories', 'items.category = categories.id', 'left');
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
        $this->db->join('item_assignment', 'items.category = item_assignment.item_id', 'left');

        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        
        $this->db->group_start(); //start group
        $this->db->like(array('items.category' => $search));
        $this->db->or_like(array('items.sub_category' => $search));
        $this->db->or_like(array('items.type_name' => $search));
        $this->db->or_like(array('items.model' => $search));
        $this->db->or_like(array('items.supplier' => $search)); 
        $this->db->or_like(array('sub_categories.name' => $search));
        $this->db->or_like(array('categories.cat_name' => $search));
        $this->db->group_end(); //close group

        $num_results = $this->db->count_all_results();
        return $num_results;
    }
    // Count all items 
    public function count_item(){
        $this->db->from('items');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $num_results = $this->db->count_all_results();
        return $num_results;
    }
      // Count damaged items 
      public function count_damaged_item(){
        $this->db->from('item_assignment');
        $num_results = $this->db->count_all_results();
        return $num_results;
    }
    // Count all items between two weeks
    public function count_item_week_change(){
        $this->db->from('items');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('items.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        $num_results = $this->db->count_all_results();
        return $num_results;
    }
    // Count all items by last two week
    public function count_item_last_week_change(){
        $this->db->from('items');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('items.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK)');
        $num_results = $this->db->count_all_results();
        return $num_results;
    }
    // Count all items by date
    public function count_item_date($date_from, $date_to) {
        $this->db->select('id');
        $this->db->from('items');
        $this->db->where('items.created_at BETWEEN \'' . $date_from . '\' AND \'' . $date_to . '\'');
        
        $num_results = $this->db->count_all_results();
        return $num_results;
    }
    // Count all purchase items 
    public function count_purchase(){
        return $this->db->from('purchase_orders')->count_all_results();
    }
    // Count all assign items 
    public function count_assign_item(){
        $this->db->select('item_assignment.id');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->where('return_back_date =', null);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        return $this->db->count_all_results();
    }

    // Count all assign items 
    public function count_assign_item_week_change(){
        $this->db->select('item_assignment.id');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->where('return_back_date =', null);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('item_assignment.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }

    // Count all assign items 
    public function count_assign_item_last_week_change(){
        $this->db->select('item_assignment.id');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->where('return_back_date =', null);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('item_assignment.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK)');
        return $this->db->count_all_results();
    }

    // Get items.
    public function get_items($limit, $offset, $date_from = null, $date_to = null ){
        $this->db->select('items.id, items.location, items.category, items.sub_category, items.type_name, items.model, items.status as item_status, items.serial_number, items.supplier, items.price, items.quantity, items.depreciation, items.purchasedate, items.created_at, users.fullname as employ_name, users.id as employ_id, sub_categories.name as names, categories.cat_name, locations.name, item_assignment.id as item_ids, item_assignment.assignd_to, item_assignment.item_id, item_assignment.status, item_assignment.return_back_date, suppliers.id sup_id, suppliers.name as sup_name ');
        $this->db->from('items');
        $this->db->join('categories', 'items.category = categories.id', 'left');
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
        $this->db->join('locations', 'items.location = locations.id', 'left');
        $this->db->join('item_assignment', 'items.id = item_assignment.item_id', 'left');
        $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
        $this->db->join('suppliers', 'items.supplier = suppliers.id', 'left');
        if (!empty($date_from) && !empty($date_to)) {  
            $this->db->where('items.created_at BETWEEN \'' . $date_from . '\' AND \'' . $date_to . '\'');
        }
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->group_by('items.id'); 
        $this->db->group_by('item_assignment.status'); 
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result(); 
    } 
        // Get Available items.
        public function get_available_items($limit, $offset){
            $this->db->select('items.id, items.location, items.category, items.sub_category, items.type_name, items.model, items.serial_number, items.supplier, items.price, items.quantity, items.depreciation, items.purchasedate, items.created_at, users.fullname as employ_name, users.id as employ_id, item_assignment.id as item_ids, item_assignment.item_id, item_assignment.status, item_assignment.assignd_to, sub_categories.name as names, categories.cat_name, locations.name, suppliers.id sup_id, suppliers.name as sup_name');
            $this->db->from('items');
            $this->db->join('categories', 'items.category = categories.id', 'left');
            $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
            $this->db->join('locations', 'items.location = locations.id', 'left');
            $this->db->join('item_assignment', 'items.id = item_assignment.item_id', 'left');
            $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
            $this->db->join('suppliers', 'items.supplier = suppliers.id', 'left');
            $this->db->where('items.quantity >', 0);
            if ($this->session->userdata('user_role') != '1') {
                $this->db->where('items.location', $this->session->userdata('location'));
            }
            $this->db->group_by('items.id'); 
            $this->db->order_by('id', 'DESC');
            $this->db->limit($limit, $offset);
            return $this->db->get()->result();
        }
        // Get Damaged items.
        public function get_damaged_items($limit, $offset){
            $this->db->select('items.id, items.location, items.category, items.sub_category, items.type_name, items.model, items.serial_number, items.supplier, items.price, items.quantity, items.depreciation, items.purchasedate, items.created_at, users.fullname as employ_name, users.id as employ_id, item_assignment.id as item_ids, item_assignment.item_id,item_assignment.remarks, item_assignment.status, item_assignment.assignd_to, sub_categories.name as names, categories.cat_name, locations.name, suppliers.id sup_id, suppliers.name as sup_name');
            $this->db->from('items');
            $this->db->join('categories', 'items.category = categories.id', 'left');
            $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
            $this->db->join('locations', 'items.location = locations.id', 'left');
            $this->db->join('item_assignment', 'items.id = item_assignment.item_id', 'left');
            $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
            $this->db->join('suppliers', 'items.supplier = suppliers.id', 'left');
            $this->db->where(array('item_assignment.status' => 0));
            if ($this->session->userdata('user_role') != '1') {
                $this->db->where('items.location', $this->session->userdata('location'));
            }
            $this->db->group_by('item_assignment.id'); 
            $this->db->order_by('id', 'DESC');
            $this->db->limit($limit, $offset);
            return $this->db->get()->result();
        }
           // Get Assign items.
           public function assign_item_list($limit, $offset){
            $this->db->select('items.id, items.location, items.category, items.sub_category, items.type_name, items.model, items.serial_number, items.supplier, items.price, items.quantity, items.depreciation, items.purchasedate, items.created_at, users.fullname as employ_name, users.id as employ_id, item_assignment.item_id, item_assignment.status, item_assignment.id as item_ids, item_assignment.assignd_to, sub_categories.name as names, categories.cat_name, locations.name, suppliers.id as sup_id, suppliers.name as sup_name ');
            $this->db->from('items');
            $this->db->join('categories', 'items.category = categories.id', 'left');
            $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
            $this->db->join('locations', 'items.location = locations.id', 'left');
            $this->db->join('item_assignment', 'items.id = item_assignment.item_id', 'left');
            $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
            $this->db->join('suppliers', 'items.sub_category = suppliers.id', 'left');
            // $this->db->join('item_assignment', 'items.category = item_assignment.item_id', 'left');
            // $this->db->group_by('item_assignment.item_id'); 
            $this->db->where('item_assignment.item_id !=', null);
            $this->db->where('item_assignment.status', 1);
            if ($this->session->userdata('user_role') != '1') {
                $this->db->where('items.location', $this->session->userdata('location'));
            }
            $this->db->order_by('id', 'DESC');
            $this->db->limit($limit, $offset);
            return $this->db->get()->result(); 
        }  
         // Get available items detail .
 public function get_item_card_detail($id){ 
    $this->db->select('items.id, 
                       items.location, 
                       items.quantity, 
                       items.category, 
                       items.sub_category,
                       items.type_name, 
                       items.model, 
                       items.serial_number, 
                       items.supplier,
                       items.price, 
                       items.depreciation,
                       items.purchasedate,
                       items.created_at, 
                       locations.id as ids,
                       locations.name,
                       categories.id as cat_id, 
                       categories.cat_name, 
                       sub_categories.name as names, 
                       sub_categories.id as sub_ids, 
                       users.id as user_id,
                       users.fullname, 
                       users.department,
                       users.doj,
                       users.phone,
                       ');
    $this->db->from('items'); 
    $this->db->join('locations', 'items.location = locations.id', 'left');
    $this->db->join('categories', 'items.category = categories.id', 'left'); 
    $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
    $this->db->join('users', 'items.added_by = users.id', 'left');
    $this->db->where('items.id', $id);
    $this->db->order_by('id', 'ASC');
    return $this->db->get()->row(); 
}
    // Assign item list.
    public function assign_list($limit, $offset){ 
        $this->db->select('items.id, 
                           items.location,
                           items.category, 
                           items.sub_category,
                           items.type_name, 
                           items.model, 
                           items.serial_number, 
                           items.supplier,
                           items.price, 
                           items.depreciation,
                           items.purchasedate, 
                           items.created_at,
                           sub_categories.name as names, 
                           categories.cat_name, 
                           locations.name,  
                           item_assignment.item_type_id');
        $this->db->from('items');
        $this->db->join('categories', 'items.category = categories.id', 'left');
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
        $this->db->join('locations', 'items.location = locations.id', 'left');
        $this->db->join('item_assignment', 'items.category = item_assignment.item_id', 'left');
        $this->db->where('items.category = item_assignment.item_id');
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result(); 
    } 
    // Assign item list.
    public function returning_assignment_list($id){ 
        $this->db->select('items.id, 
                           items.location,
                           items.category, 
                           items.sub_category,
                           items.type_name, 
                           items.model, 
                           items.serial_number, 
                           items.supplier,
                           items.price, 
                           items.depreciation,
                           items.purchasedate, 
                           items.created_at,
                           sub_categories.name as names, 
                           categories.cat_name, 
                           locations.name,  
                           item_assignment.item_type_id');
        $this->db->from('items');
        $this->db->join('categories', 'items.category = categories.id', 'left');
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
        $this->db->join('locations', 'items.location = locations.id', 'left');
        $this->db->join('item_assignment', 'items.category = item_assignment.item_id', 'left');
        $this->db->where('items.id',$id);
        $this->db->order_by('id', 'ASC'); 
        return $this->db->get()->row(); 
    } 
    // Item - Add new item
    public function item_save($data, $model, $quantity){
        if($quantity > 99) {
            return false;
        } elseif ($quantity == null) {
            $quantity = 1;
        }
        for ($i = 0; $i<$quantity; $i++) {
            $this->db->insert('items', $data);
            $id = $this->db->insert_id();
            $item_type = array(
                'item_type' => $id,
                'model' => $this->input->post('model')
            );  
            $this->db->insert('item_model', $item_type);
        }
        $this->db->insert('item_model', $item_type);
        if($this->db->affected_rows() > 0){
        return true;
        }else{
        return false;
        }
    } 
    
     // get Supplier for adding an item
     public function get_item_supplier(){
        $this->db->select('id, name');
        $this->db->from('suppliers'); 
        return $this->db->get()->result();
    }
        // item detail - view and edit.
        public function item_detail($id){ 
                                        $this->db->select('items.id, items.location,
                                        items.department, items.category,
                                        items.status, items.sub_category,
                                        items.project, items.type_name, 
                                        items.model, items.serial_number, 
                                        items.supplier,items.price, 
                                        items.depreciation,items.purchasedate,
                                        items.quantity, items.created_at,
                                        projects.id as project_id,
                                        projects.project_name,
                                        departments.id as dep_id,
                                        departments.department');
                                        $this->db->from('items');
                                        $this->db->join('projects', 'items.project = projects.id', 'left');
                                        $this->db->join('departments', 'items.department = departments.id', 'left');
                                        $this->db->where('items.id', $id);
                                        return $this->db->get()->row();
        }
    // get sub categories for edit item page 
    public function get_item_sub_category(){
        return $this->db->from('sub_categories')->get()->result();
    }
    
    // Count all items 
    public function count_subcategory(){
        $this->db->from('sub_categories');
        $this->db->where('cat_id',$this->uri->segment(3));
        $num_results = $this->db->count_all_results();
        return $num_results;
    }

    // Count Available Items
    public function count_available_items() {
        $this->db->select('items.id');
        $this->db->from('items');
        $this->db->where('items.quantity >', 0);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        return $this->db->count_all_results();
    }

    // Count Available Items (last week)
    public function count_available_items_week_change() {
        $this->db->select('items.id');
        $this->db->from('items');
        $this->db->where('items.quantity >', 0);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('items.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }

    // Count Available Items (last 2 weeks)
    public function count_available_items_last_week_change() {
        $this->db->select('items.id');
        $this->db->from('items');
        $this->db->where('items.quantity >', 0);
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('items.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK)');
        return $this->db->count_all_results();
    }

    // Count Damage Items
    public function count_damaged_items() {
        $this->db->select('item_assignment.id, item_assignment.item_id, item_assignment.remarks');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->group_by('item_assignment.item_id');
        $this->db->where('item_assignment.remarks IS NOT NULL');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        return $this->db->count_all_results();
    }

    // Count Damage Items (week change)
    public function count_damaged_items_week_change() {
        $this->db->select('item_assignment.id, item_assignment.item_id, item_assignment.remarks, item_assignment.created_at');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->group_by('item_assignment.item_id');
        $this->db->where('item_assignment.remarks IS NOT NULL');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('item_assignment.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }

    // Count Damage Items (2 weeks change)
    public function count_damaged_items_last_week_change() {
        $this->db->select('item_assignment.id, item_assignment.item_id, item_assignment.remarks, item_assignment.created_at');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->group_by('item_assignment.item_id');
        $this->db->where('item_assignment.remarks IS NOT NULL');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        $this->db->where('item_assignment.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK)');
        return $this->db->count_all_results();
    }

    
    // get sub categories for edit item page 
    public function get_item_depreciation($id){
        return $this->db->from('items')->where('id',$id)->get()->result();
    }
    // Get sub categories based on cat_id
    public function get_item_sub_categories($cat_id){
        $this->db->select('id, name');
        $this->db->from('sub_categories');
        $this->db->where('cat_id', $cat_id);
        return $this->db->get()->result();
    } 
    // Get supplier against on location
    public function supplier_against_location($loc_id){
        $this->db->select('id, name, email');
        $this->db->from('suppliers');
        $this->db->where(array('location'=> $loc_id,'status' => 1));
        $this->db->where('location', $loc_id);
        return $this->db->get()->result();
    }
    // Get category for supplier form
    public function suppliers_category(){
        $this->db->select('id, cat_name');
        $this->db->from('categories'); 
        return $this->db->get()->result();
    }
  //== ----------------------------------------- Search filters --------------------------------------- ==\\
    // Search filters - search Item
    public function search_items($search, $limit, $offset){
        $this->db->select('items.id, items.location, items.category, items.sub_category, items.type_name, items.model, items.serial_number, items.supplier, items.quantity, items.price, items.depreciation, items.purchasedate, items.created_at, users.fullname as employ_name, users.id as employ_id, sub_categories.name as names, categories.cat_name, locations.name, item_assignment.status, item_assignment.assignd_to, item_assignment.id as item_ids, suppliers.id as sup_id, suppliers.name as sup_name');
        $this->db->from('items');
        $this->db->join('categories', 'items.category = categories.id', 'left');
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
        $this->db->join('locations', 'items.location = locations.id', 'left');
        $this->db->join('item_assignment', 'items.category = item_assignment.item_id', 'left');
        $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
        $this->db->join('suppliers', 'items.supplier = suppliers.id', 'left');
        
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('items.location', $this->session->userdata('location'));
        }
        
        $this->db->group_start(); //start group
        $this->db->like(array('items.category' => $search));
        $this->db->or_like(array('items.sub_category' => $search));
        $this->db->or_like(array('items.type_name' => $search));
        $this->db->or_like(array('items.model' => $search));
        $this->db->or_like(array('items.supplier' => $search)); 
        $this->db->or_like(array('sub_categories.name' => $search));
        $this->db->or_like(array('categories.cat_name' => $search));
        $this->db->group_end(); //close group
        
        $this->db->order_by('items.created_at', 'DESC');
        $this->db->order_by('id', 'ASC'); 

        $this->db->limit($limit, $offset);
        return $this->db->get()->result(); 
    }
     // uupdate Item - Update existing record
    public function modify_item($id, $data){
        $this->db->where('id', $id);
        $this->db->update('items', $data);
        return true;
    } 
     // Item Assign - Assignment Item
    public function assign_to(){ 
        $this->db->select('id, fullname');
        $this->db->from('users'); 
        return $this->db->get()->result();
    }
    // Item Assign By - Assign By Item
    public function assign_by(){ 
        $this->db->select('id, username');
        $this->db->from('users'); 
        $this->db->where('id', $this->session->userdata('id'));
        return $this->db->get()->result();
    }
    // Assign Item Save - 
    public function assign_item_save($data,$item,$invantory,$item_id){ 
           $this->db->insert('item_assignment', $data);
//  select items quantity from items to subtract assign item from it
        $this->db->select('quantity');
        $this->db->from('items');
        $this->db->where('id',$item_id);
        $value = $this->db->get()->result();
         $qty = $value[0]->quantity;
        // echo $qty;exit;
// select items from item_assignment to subtract from all quantity        
        $this->db->select('quantity');
        $this->db->from('item_assignment');
        $this->db->where('item_id',$item_id);
        $item_assign = $this->db->count_all_results();
        // $item_assign;
        $total = $qty - $item_assign;
         $total = $qty - 1; 
        $quantity = array( 
            'quantity' => $total, 
            'status' => 1
        );
        $this->db->where('id',$item_id);
        $this->db->update('items', $quantity);
    //   $this->db->insert('item_assignment', $data);
      $this->db->update('inventory', $invantory);
      $this->db->update('items', $item); 
        if($this->db->affected_rows() > 0){
        return true;
        }else{
        return false;
        }
  }
  
    // Get location where from where employee belongs to
    public function get_employ_location($id){   
        { 
          $this->db->select('locations.id,locations.name,users.id as emp_id,users.location');
          $this->db->from('locations');
          $this->db->join('users', 'locations.id = users.location', 'left');
          $this->db->where('users.id',$id);
          return $this->db->get()->result(); 
        } 
    }

    // Get locationfor invoice form
    public function get_invoice_location($id){
          $this->db->select('locations.id,locations.name,invoices.id as inv_id,invoices.region');
          $this->db->from('locations');
          $this->db->join('invoices', 'locations.id = invoices.region', 'left');
          $this->db->where('invoices.id',$id);
          return $this->db->get()->result(); 
    }
  // Get employee based on city
  public function get_location_employ($loc_id){  
      $role = ($this->session->userdata('user_role')); 
      if($role == 'admin'){
        $this->db->select('id, fullname as name');
        $this->db->from('users');
        $this->db->where('location', $loc_id);
        return $this->db->get()->result();
      }else{
        $this->db->select('id, fullname as name');
        $this->db->from('users');
        $this->db->where('location',$this->session->userdata('location'));
        return $this->db->get()->result(); 
      }  
  }
  // Get supplier based on city
  public function get_location_suplier(){  
    $this->db->select('id, name,email');
    $this->db->from('suppliers');
    if ($this->session->userdata('user_role') != '1') {
        $this->db->where('location', $this->session->userdata('location'));
    }
    return $this->db->get()->result(); 
  }

  // Get supplier email based on supplier
  public function get_suplier_email($loc_id){
      $this->db->select('id, name,email');
      $this->db->from('suppliers');
      $this->db->where('id', $loc_id);
      return $this->db->get()->result();
  }
    // Get category 
    public function get_assign_category($cat_id){ 
        $this->db->select('id, name');
        $this->db->from('sub_categories');
        $this->db->where('cat_id', $cat_id);
        return $this->db->get()->result();
    }
    // Get item type based on item
    public function get_item_type($item_id){
              $this->db->select('items.id, items.sub_category, items.type_name, sub_categories.id');
              $this->db->distinct('items.type_name');
              $this->db->from('items');  
              $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
              $this->db->where('sub_category', $item_id);
              $this->db->group_by('items.type_name'); 
              return $this->db->get()->result();
    }
    // Get item model based on item type
    public function get_item_model($item_type){
              $this->db->select('items.id,items.quantity,items.type_name,item_model.item_type,item_model.model');
              $this->db->from('item_model');   
              $this->db->join('items', 'items.id = item_model.item_type', 'left');
              $this->db->where('item_model.id', $item_type);
              return $this->db->get()->result();
    }
    // Get employ assign item record against emply
    public function get_employ_data($employ_id){ 
        $this->db->select('item_assignment.id,item_assignment.item_id,
                           item_assignment.assignd_to,users.id, 
                           users.fulname,items.id,items.sub_category,
                           sub_categories.id,sub_categories.name as sub_cat');
        $this->db->from('item_assignment');   
        $this->db->join('items', 'item_assignment.item_id = items.id', 'left');       
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left'); 
        $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
        $this->db->where(array('item_assignment.assignd_to' => $employ_id, 'item_assignment.status' => 1));
        // $query = $this->db->get();
        // echo $this->db->last_query();
        return $this->db->get()->result();
    } 
    // Count employ
    public function count_employ(){
        $this->db->from('users');
        $this->db->where(array('status' => 1));
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('users.location', $this->session->userdata('location'));
        }
        return $this->db->count_all_results();
    }

    // Count employee comparing between two weeks
    public function count_employ_week_change(){
        $this->db->from('users');
        $this->db->where(array('status' => 1));
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('users.location', $this->session->userdata('location'));
        }
        $this->db->where('users.created_at BETWEEN date_sub(now(),INTERVAL 1 WEEK) and now()');
        return $this->db->count_all_results();
    }

    // Count employee from two weeks before
    public function count_employ_last_week_change(){
        $this->db->from('users');
        $this->db->where(array('status' => 1));
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('users.location', $this->session->userdata('location'));
        }
        $this->db->where('(users.created_at BETWEEN date_sub(now(),INTERVAL 2 WEEK) and date_sub(now(),INTERVAL 1 WEEK))');
        return $this->db->count_all_results();
    }

    // Count employ by location
    public function count_employ_by_location($location){
        return $this->db->from('users')->where(array('status' => 1, 'location' => $location))->count_all_results();
    }
    // Get employ
    public function get_employ($limit, $offset){
        $this->db->select('users.id as emp_id, users.fullname as emp_name,
                           users.doj, users.email,users.department, 
                           users.phone, users.location, users.region,
                           users.address, users.status, 
                           users.created_at,locations.id,locations.name');
        $this->db->from('users');
        $this->db->join('locations', 'users.location = locations.id', 'left');
        // $this->db->where('status', 1);
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
      // Search filters - suppliers search
      public function search_employ($search){
        $this->db->select('users.id, users.fullname, users.email,
                           users.phone, users.doj, users.location, users.department,
                           users.region, users.address, users.status,users.dob,
                           users.created_at,locations.id as loc_id,
                           locations.name');
        $this->db->from('users');
        $this->db->join('locations', 'users.location = locations.id', 'left');
        $this->db->like('fullname', $search);
        $this->db->or_like('department', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('phone', $search);
        $this->db->or_like('location', $search);
        $this->db->or_like('region', $search);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get()->result();
    }
    // Employ - Add new Employ
    public function add_employ($data){ 
        $this->db->insert('users', $data);
        if($this->db->affected_rows() > 0){
        return true;
        }else{
        return false;
        }
    }
    // Get employ for edit by id
    public function edit_employ($id){
        $this->db->select('users.id, 
                            users.username, 
                            users.fullname, 
                            users.email, 
                            users.phone, 
                            users.location,
                            users.doj, 
                            users.department,
                            users.region, 
                            users.address, 
                            users.status,
                            users.dob, 
                            users.created_at,
                            locations.id as loc_id,
                            locations.name,
                            users_roles.id as user_role');
        $this->db->from('users');
        $this->db->join('locations', 'users.location = locations.id', 'left');
        $this->db->join('users_roles', 'users.user_role = users_roles.id', 'left');
        $this->db->where('users.id', $id);
        return $this->db->get()->row();
    } 
    // Update employ by ID.
    public function update_employ($id, $data){
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return true;
    }
    // Remove employ
    public function delete_employ($id){
        $this->db->where('id', $id);
        $this->db->delete('employ');
        return true;
    }
    // Get item serial number based on item type
    public function get_item_serial_umber($serial_number){
              $this->db->select('items.id,items.model,items.serial_number,item_model.id,item_model.model');
              $this->db->join('item_model', 'items.model = item_model.model', 'left');
              $this->db->from('items');    
              $this->db->where('item_model.id', $serial_number);
              return $this->db->get()->result();
    } 
 // Get item quantity based on item id
 public function get_item_quantity($item_id){
            $assign_quantity = $this->db->select('item_type')->from('item_assignment')->where(array('item_type' => $item_id))->count_all_results(); 
            $total_quantity = $this->db->select('quantity')->from('items')->where(array('id' => $item_id))->get()->row(); 
            $total_value = $total_quantity->quantity;
            $total = $total_value - $assign_quantity;
            return $total;
 }
  // Return Item Save - 
  public function return_item_save($data,$invantory,$item,$item_id,$assign_item_id){    
 
        $this->db->where(array('item_assignment.id' => $assign_item_id, 'item_assignment.status' => 1));
        $this->db->update('item_assignment', $data); 
        $this->db->update('inventory', $invantory);
        //  select items quantity from items to add assign back 
        $this->db->select('quantity');
        $this->db->from('items');
        $this->db->where('id',$item_id);
        $value = $this->db->get()->result();
        $qty = $value[0]->quantity; 
        $total = $qty + 1;   
        // echo $total;exit;
        $quantity = array( 
            'quantity' => $total,  
            'status' => 0 
        );
        $this->db->where('id', $item_id);
        $this->db->update('items', $quantity);  
        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
}
    // Check Assign Item  - Check Assign Item show at item register page
    public function check_assign(){ 
        $this->db->select('status');
        $this->db->from('item_assignment'); 
        $this->db->where('status',1);
        return $this->db->get()->result();
    }
    // Get Item to show at assign item page  - Get Item
    public function get_item(){ 
        return $this->db->from('sub_categories')->get()->result(); 
    }   
    // Get Item model 
    public function get_model(){ 
        $this->db->select('id,model');
        $this->db->from('item_model');  
        return $this->db->get()->result();
    } 
 
     // Get category to show at assign item page  - Get category
    public function get_category(){ 
        return $this->db->from('categories')->get()->result(); 
    }
     // Count all items 
     public function count_item_assign(){
        return $this->db->from('item_assignment')->count_all_results();
    }
    // Count all items by location
    public function count_item_assign_by_location($location){
        return $this->db->from('item_assignment')->where(array('location' => $location))->count_all_results();
    }
      // Check Assign list  - Check Assign list 
      public function check_assign_list($limit, $offset){  
        $this->db->select('item_assignment.id as item_ids,
                           item_assignment.assignd_to, 
                           item_assignment.assignd_by,
                           item_assignment.item_status,
                           item_assignment.item_id,
                           item_assignment.description,
                           item_assignment.status,
                           item_assignment.item_type,
                           item_assignment.item_type_id,
                           item_assignment.created_at,
                           items.id,
                           items.serial_number,
                           items.type_name, 
                           suppliers.name as supplier,
                           suppliers.location,
                           suppliers.id,
                           inventory.name,
                           sub_categories.id as sub_id,
                           sub_categories.name as sub_cat_name');
        $this->db->from('item_assignment'); 
        // $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
        $this->db->join('suppliers', 'item_assignment.assignd_to = suppliers.id', 'left');
        $this->db->join('items', 'item_assignment.item_type = items.sub_category', 'left');
        $this->db->join('inventory', 'item_assignment.item_id = inventory.name', 'left');
        $this->db->join('sub_categories','item_assignment.item_id = sub_categories.id', 'left'); 
        $this->db->group_by('item_assignment.item_id'); 
        // $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }
        public function available_item_list($limit, $offset){  
            $this->db->select('item_assignment.id as item_ids,
                               item_assignment.assignd_to, 
                               item_assignment.assignd_by,
                               item_assignment.item_status,
                               item_assignment.item_id,
                               item_assignment.description,
                               item_assignment.status,
                               item_assignment.item_type,
                               item_assignment.item_type_id,
                               item_assignment.created_at,
                               items.id,
                               items.serial_number,
                               items.type_name, 
                               suppliers.name as supplier,
                               suppliers.location,
                               suppliers.id,
                               inventory.name,
                               sub_categories.id as sub_id,
                               sub_categories.name as sub_cat_name');
            $this->db->from('item_assignment'); 
            // $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
            $this->db->join('suppliers', 'item_assignment.assignd_to = suppliers.id', 'left');
            $this->db->join('items', 'item_assignment.item_type = items.sub_category', 'left');
            $this->db->join('inventory', 'item_assignment.item_id = inventory.name', 'left');
            $this->db->join('sub_categories','item_assignment.item_id = sub_categories.id', 'left'); 
            $this->db->group_by('item_assignment.item_id'); 
            $this->db->where('item_assignment.status' , 0);
            // $this->db->limit($limit, $offset);
            return $this->db->get()->result();
        }
    // Search filters - assign Item search
    public function search_assign_item($search){
        $this->db->select('item_assignment.id as item_ids,
                            item_assignment.assignd_to, 
                            item_assignment.assignd_by,
                            item_assignment.item_status,
                            item_assignment.item_id,
                            item_assignment.description,
                            item_assignment.status,
                            item_assignment.created_at,
                            users.id,
                            users.fullname,
                            users.username,
                            inventory.name,
                            sub_categories.name as sub_cat_name');
        $this->db->from('item_assignment');
        $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
        $this->db->join('inventory', 'item_assignment.item_id = inventory.name', 'left');
        $this->db->join('sub_categories','item_assignment.item_id = sub_categories.id', 'left'); 
        $this->db->like('item_assignment.assignd_to', $search);
        $this->db->or_like('item_assignment.assignd_by', $search);
        $this->db->or_like('item_assignment.item_id', $search);
        $this->db->or_like('item_assignment.item_status', $search);
        $this->db->or_like('item_assignment.return_back_date', $search);
        $this->db->or_like('item_assignment.created_at', $search); 
        $this->db->order_by('item_assignment.created_at', 'DESC');
        return $this->db->get()->result();
    }
   // Get assign items detail.
   public function get_item_card($id){
    $this->db->select('items.id, 
                       items.location,  
                       items.quantity, 
                       items.category, 
                       items.sub_category,
                       items.type_name, 
                       items.model, 
                       items.serial_number, 
                       items.supplier,
                       items.price, 
                       items.depreciation,
                       items.purchasedate,
                       items.created_at, 
                       users.id as user_id,
                       users.fullname as emp_name,
                       users.location,
                       users.id as employ_id,
                       users.phone,
                       users.department,
                       users.doj,
                       sub_categories.name as names,
                       categories.cat_name, 
                       locations.name,
                       item_assignment.id as asignment_id,
                       item_assignment.item_type,
                       item_assignment.item_file,
                       item_assignment.returning_description,
                       item_assignment.item_type_id,
                       item_assignment.return_back_date,
                       item_assignment.created_at as assign_date,
                       item_assignment.assignd_to, 
                       item_assignment.status, 
                       ');
    $this->db->from('items');
    $this->db->join('categories', 'items.category = categories.id', 'left'); 
    $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
    $this->db->join('locations', 'items.location = locations.id', 'left');
    $this->db->join('item_assignment', 'item_assignment.item_id = items.id', 'left');
    $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');  
    $this->db->where('item_assignment.item_id', $id);
    // if(isset($employ_id)){
    //     $this->db->where('item_assignment.assignd_to', $employ_id);
    // }
    $this->db->order_by('item_assignment.id', 'DESC'); 

    return $this->db->get()->result(); 
}
    // assifned item employee detail
    public function assigned_item_emp($id){
        $this->db->select('item_assignment.id as assignment_id,
        item_assignment.assignd_to,
        item_assignment.item_id,
        item_assignment.remarks,
        item_assignment.item_file,
        item_assignment.returning_description,
        item_assignment.created_at as assigned_date,
        item_assignment.return_back_date as return_date,
        users.id,
        users.fullname,
        users.department,
        sub_categories.id as sub_id,
        sub_categories.name as sub_name,
        items.id,
        items.sub_category
        ');
        $this->db->from('item_assignment'); 
        $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
        $this->db->join('items', 'item_assignment.item_id = items.id', 'left');
        $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
        $this->db->where('item_assignment.id', $id);
        $this->db->order_by('item_assignment.id', 'DESC'); 
        return $this->db->get()->row();
    }
  // current_item_assign assign detail.
  public function current_item_assign($id){
    $this->db->select('users.id as employ_id,
                       users.fullname as emp_name,
                       users.location,
                       users.department,
                       users.doj,
                       users.phone,
                       users.department,  
                       item_assignment.id as asignment_id,
                       item_assignment.item_type, 
                       item_assignment.item_id, 
                       item_assignment.return_back_date,
                       item_assignment.created_at as assign_date,
                       item_assignment.assignd_to, 
                       item_assignment.status, 
                       ');
    $this->db->from('users');
    $this->db->join('item_assignment', 'users.id = item_assignment.assignd_to', 'left');   
    $this->db->where(array('item_assignment.return_back_date' => null, 'item_assignment.item_id' => $id)); 
    $this->db->order_by('users.id', 'ASC');
    return $this->db->get()->result(); 
  }    
    // Count qutation
    public function count_qutation($id){
        $this->db->select('purchase_id');
        $this->db->from('po_suppliers');
        $this->db->where('id',$id);
        $p_id = $this->db->get()->row();
       // $po_id = $p_id->purchase_id;  
        // return $this->db->from('qutations')->where(array('po_id' => $po_id))->count_all_results();
        return $this->db->from('qutations')->where(array('po_id' => $id))->count_all_results();
    } 
    
    // Locations - Get item locations
    public function get_item_location(){
        $location = $this->session->userdata('location'); 
        $this->db->from('locations');
        if ($this->session->userdata('user_role') != '1') {
            $this->db->where('id', $this->session->userdata('location'));
        }
        return $this->db->get()->result();
    } 

    // Item register - Delete an Item
    public function delete_item($id){
        $this->db->where('id', $id);
        $this->db->delete('items_detail');
        return true;
    }

    public function total_items_count_by_days() {
        $result = array();

        for ($i = 0; $i <= 6; $i++) {
            $time = date("Y-m-d", time() - ((60*60*24) * $i));

            $this->db->select("COUNT(*) as count");
            $this->db->from('items');

            $this->db->where("CAST(items.created_at AS date) = '$time'");

            if ($this->session->userdata('user_role') != '1') {
                $this->db->where('items.location', $this->session->userdata('location'));
            }

            array_push($result, $this->db->get()->result()[0]->count);
        }

        return $result;
    }

    public function damaged_items_count_by_days() {
        $result = array();

        for ($i = 0; $i <= 6; $i++) {
            $time = date("Y-m-d", time() - ((60*60*24) * $i));

            $this->db->select("COUNT(*) as count");
            $this->db->from('item_assignment');

            $this->db->where("item_assignment.status = 0");
            $this->db->where("CAST(item_assignment.created_at AS date) = '$time'");
                    
            $this->db->join('items', 'item_assignment.id = items.id', 'left');
            if ($this->session->userdata('user_role') != '1') {
                $this->db->where('items.location', $this->session->userdata('location'));
            }

            array_push($result, $this->db->get()->result()[0]->count);
        }

        return $result;
    }

    public function assigned_items_count_by_days() {
        $result = array();

        for ($i = 0; $i <= 6; $i++) {
            $time = date("Y-m-d", time() - ((60*60*24) * $i));

            $this->db->select("COUNT(*) as count");
            $this->db->from('item_assignment');

            $this->db->where("CAST(item_assignment.created_at AS date) = '$time'");
                    
            $this->db->join('items', 'item_assignment.id = items.id', 'left');

            $this->db->where('item_assignment.status = 1');
            if ($this->session->userdata('user_role') != '1') {
                $this->db->where('items.location', $this->session->userdata('location'));
            }

            array_push($result, $this->db->get()->result()[0]->count);
        }

        return $result;
    }
}
