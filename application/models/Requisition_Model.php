<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Requisition_Model extends CI_Model{
    
    // RequestList() function
    public function RequestList($limit, $offset, $user) {        
        $this->db->select('
            item_requisitions.id,
            item_requisitions.item_name,
            item_requisitions.item_desc,
            item_requisitions.item_qty,
            item_requisitions.requested_by,
            item_requisitions.status,
            item_requisitions.created_at as date,
            users.id as userId,
            users.fullname'
        );

        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $role = $this->session->userdata('user_role');
        if($role != 3 && $role != 1){
            $this->db->where('item_requisitions.requested_by' , $user);
        }
        $data = $this->uri->segment(3); // take segment 3 when click on tab
        if(isset($data)) { 
            if($data == 0) { 
                $this->db->where(array('item_requisitions.status' => $data));
            } 
            if($data == 1) { 
                $this->db->where(array('item_requisitions.status' => $data));
            } 
            if($data == 2) { 
                $this->db->where(array('item_requisitions.status' => $data));
            } 
            if($data == 3) { 
                $this->db->where(array('item_requisitions.status' => null));
            } 
            if(!isset($data)) { 
                $this->db->where('item_requisitions.requested_by', $user);
                $this->db->limit($limit, $offset); 
            }
        }
        return $this->db->get()->result();
    }

    // Approval list
    public function ApprovalList($limit, $offset, $user,$role_id) { 
        $role = $this->db->select('role_id,read')->from('request_access')->where(array('role_id' => $role_id, 'read' => 1))->get()->row(); 
    //    echo $role->role_id;exit;
        if(!empty($role)){
            $roleId = $role->role_id; // this query is used to take common role id --
            $read = $role->read; 
        }else{
            $roleId = 0;
        }
      
        $this->db->select('
            item_requisitions.id,
            item_requisitions.item_name,
            item_requisitions.item_desc,
            item_requisitions.reject_reason,
            item_requisitions.item_qty,
            item_requisitions.requested_by,
            item_requisitions.status,
            item_requisitions.created_at as date,
            users.id as userId,
            users.fullname,
            users.user_role,
            request_access.id as access_id,
            request_access.request_id,
            request_access.role_id,
            request_access.read,
            quotations.id as quot_id,
            quotations.price'
        ); 
        // echo $roleId;exit;
        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $this->db->join('request_access', 'users.user_role = request_access.role_id', 'left');
        $this->db->join('quotations', 'item_requisitions.id = quotations.item', 'left');
        // $this->db->where('request_access.role_id', $role_id); 
        if(!empty($read)){
        $this->db->where(array($roleId => $role_id, $read => 1));
        }else{
        $this->db->where(array($roleId => $role_id, 'request_access.read' => 1));
        }// $this->db->where($roleId,$role_id); 
        // $this->db->where('request_access.read', 1); 
        $this->db->group_by('item_requisitions.id');
        $id = $this->uri->segment(3);
        if(isset($id)) { 
            if($id == 0) { 
                $this->db->where(array('item_requisitions.status' => $id));
            } 
            if($id == 1) { 
                $this->db->where(array('item_requisitions.status' => $id));
            } 
            if($id == 2) { 
                $this->db->where(array('item_requisitions.status' => $id));
            } 
            if($id == 3) { 
                $this->db->where(array('item_requisitions.status' => null));
            } 
            if(!isset($id)) { 
                $this->db->where('item_requisitions.requested_by', $role_id);
                $this->db->limit($limit, $offset); 
            }  
        } 
        $this->db->order_by('item_requisitions.id', 'desc');
        $this->db->order_by('item_requisitions.status', '3'); 
        return $this->db->get()->result();
    } 
    // aproval list end
 
    // SearchRequest() function - Searches the request list in requisitions    
    public function SearchRequest($search, $user) {
        $this->db->select('item_requisitions.id,
            item_requisitions.item_name,
            item_requisitions.item_desc,
            item_requisitions.item_qty,
            item_requisitions.requested_by,
            item_requisitions.status,
            item_requisitions.created_at as date,
            users.id as userId,
            users.fullname'
        );
    
        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');

        $this->db->group_start(); //Start Grouping
        $this->db->or_like('item_name', $search);
        $this->db->or_like('item_desc', $search);
        $this->db->or_like('item_qty', $search);
        $this->db->or_like('requested_by', $search);
        $this->db->or_like('fullname', $search); 
        $this->db->group_end(); //Close Grouping
        $role = $this->session->userdata('user_role');
        if($role != 1 && $role != 3){
        $this->db->where('item_requisitions.requested_by', $user);
        }
        $this->db->order_by('item_requisitions.created_at', 'DESC');

        return $this->db->get()->result();
    }

    // AddRequest() function - Adds request for requisition from user
    public function AddRequest($data, $user) {
        $this->db->trans_begin();

        $this->db->query("INSERT INTO item_requisitions (`item_name`,`item_requirement`, `item_desc`, `item_qty`,`location_id`,`department_id`,`company_id`, `requested_by`, `status`) VALUES ('$data->item_name','$data->item_requirement', '$data->item_desc', $data->item_qty, ' $data->location','$data->department','$data->company','$user', NULL)");
        $last_insert_id = $this->db->insert_id();
        
        $users_roles = $this->db->query("SELECT `id`, `type` FROM users_roles")->result();
        
        foreach($users_roles as $data) {
            if ($data->type == 'supervisor') {
                $this->db->query("INSERT INTO request_access (`request_id`, `role_id`,`read`) VALUES ('$last_insert_id', '$data->id', 1)");    
            } else {
                $this->db->query("INSERT INTO request_access (`request_id`, `role_id`,`read`) VALUES ('$last_insert_id', '$data->id', 0)");
            }
        }

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        }

        $this->db->trans_commit();

        return true;
    }

    // ViewRequest() function - View details of request
    public function ViewRequest($id) {

        $this->db->select('item_requisitions.id, 
            item_requisitions.item_name,
            item_requisitions.item_desc,
            item_requisitions.item_qty,
            item_requisitions.item_requirement,
            item_requisitions.status,
            item_requisitions.created_at as date, 
            item_requisitions.requested_by,
            item_requisitions.location_id,
            item_requisitions.department_id,
            item_requisitions.company_id,
            users.id as user_id, users.fullname,
            departments.id as dep_id,
            departments.department,
            locations.id as loc_id,
            locations.name as loc_name,
            company.id as company_id,
            company.name as company_name'
        );

        $this->db->from('item_requisitions');
        $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
        $this->db->join('locations', 'item_requisitions.location_id = locations.id', 'left');
        $this->db->join('departments', 'item_requisitions.department_id = departments.id', 'left');
        $this->db->join('company', 'item_requisitions.company_id = company.id', 'left');
        $this->db->where('item_requisitions.id', $id);

        return $this->db->get()->row();
    }

    // ForwardList() function - Forwardes the request
    public function ForwardList($id,$role_id, $data,$forward_request) {
        // echo $id;exit;
        $this->db->where('request_id', $id);
        $this->db->where('role_id', $role_id);
        $this->db->update('request_access', $forward_request);

        $this->db->where('id', $id);
        $this->db->update('item_requisitions', $data);

        return true;
    }

    // ApprovedList() function - Approved request List
    public function ApprovedList($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('item_requisitions', $data);
        return true;
    }

    // RejectList() function - Rejects request
    public function RejectList($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('item_requisitions', $data);
        return true;
    }
// slect supplier for po - purchase order
    public function supplier(){
        $this->db->select('suppliers.id as sup_id, suppliers.name sup_name,suppliers.email, suppliers.phone, suppliers.location,suppliers.status');
        $this->db->from('suppliers');
        // $this->db->where('suppliers.status', 1); 
        $this->db->where('suppliers.location', $this->session->userdata('location')); 
        $this->db->order_by('suppliers.rating', 'DESC');
        return $this->db->get()->result();
    }
    // select supplier email
public function supplier_email($vendor){
    $this->db->select('id,email');
    $this->db->from('suppliers');
    $this->db->where('id', $vendor); 
    return $this->db->get()->row();
}
// select product detail for qutation
public function product_detail($request_id){
    $this->db->select('id,item_name,item_desc,item_qty,location_id');
    $this->db->from('item_requisitions');
    $this->db->where('id', $request_id); 
    return $this->db->get()->row();
}
// select location for quotation
public function location($location_id){
    $this->db->select('id,name');
    $this->db->from('locations');
    $this->db->where('id', $location_id);
    return $this->db->get()->row();
}
    // Inventory - send quotation
    public function send_quotation($data){
        $this->db->insert('quotations', $data);
        $last_insert_id = $this->db->insert_id();

        $users_roles = $this->db->query("SELECT `id`, `type` FROM users_roles")->result();
        
        foreach($users_roles as $data) {
            if ($data->type == 'supervisor') {
                $this->db->query("INSERT INTO quotations_access (`quotation_id`, `role_id`,`read`) VALUES ('$last_insert_id', '$data->id', 1)");    
            } else {
                $this->db->query("INSERT INTO quotations_access (`quotation_id`, `role_id`,`read`) VALUES ('$last_insert_id', '$data->id', 0)");
            }
        }

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
      // Inventory - Add inventory.
      public function SaveQuotation($id,$data){
        $this->db->where('id', $id);
        $this->db->update('quotations', $data);

        if($this->db->affected_rows() > 0){
            return true;
        }else{
            return false;
        }
    }
   // Approval list
   public function QuotationList($limit, $offset) { 
    $this->db->select('
        quotations.id,
        quotations.item,
        quotations.quantity,
        quotations.description,
        quotations.price,
        quotations.requested_by,
        quotations.supplier_id,
        quotations.status,
        quotations.created_at as date,
        item_requisitions.id as req_id,
        item_requisitions.item_name,
        users.id as user_id,
        users.fullname, 
        quotations_access.id as quot_id,
        quotations_access.quotation_id,
        quotations_access.read, 
        suppliers.id as sup_id,
        suppliers.name as sup_name
        '); 
    $this->db->from('quotations');
    $this->db->join('users', 'quotations.requested_by = users.id', 'left');
    $this->db->join('suppliers', 'quotations.supplier_id = suppliers.id', 'left');
    $this->db->join('item_requisitions', 'quotations.item = item_requisitions.id', 'left');
    $this->db->join('quotations_access', 'quotations.id = quotations_access.quotation_id', 'left');

    $this->db->group_by('quotations.id');
    $this->db->limit($limit, $offset); 
    return $this->db->get()->result();
} 
// qutation list end
// vendor qutation form
public function VendorQuotation($id){ 
        $this->db->select('
            quotations.id as qut_id, 
            quotations.item, 
            quotations.description,
            quotations.quantity,
            quotations.price,
            quotations.created_at as date, 
            quotations.requested_by,
            quotations.supplier_id,
            quotations.location_id,
            item_requisitions.id,
            item_requisitions.item_name,
            item_requisitions.item_requirement,
            item_requisitions.item_qty,
            item_requisitions.location_id,
            item_requisitions.department_id,
            item_requisitions.company_id,
            locations.id as loc_id, 
            locations.name as loc_name,

            suppliers.id as sup_id,
            suppliers.name as sup_name,
            suppliers.email as sup_email,
            users.id as user_id, 
            users.fullname'
        ); 
        $this->db->from('quotations');
        $this->db->join('users', 'quotations.requested_by = users.id', 'left'); 
        $this->db->join('suppliers', 'quotations.supplier_id = suppliers.id', 'left'); 
        $this->db->join('item_requisitions', 'quotations.item = item_requisitions.id', 'left');
        $this->db->join('locations', 'quotations.location_id = locations.id', 'left');
        $this->db->where('quotations.id', $id);
        // echo "<pre>";
        // print_r($this->db->get()->row());exit;
        return $this->db->get()->row();
    }
// vendor qutation form end 

public function ForwardQuotation($id,$role_id, $data,$forward_request) {
    $this->db->where('quotation_id', $id);
    $this->db->where('role_id', $role_id);
    $this->db->update('quotations_access', $forward_request);

    $this->db->where('id', $id);
    $this->db->update('quotations', $data);
    return true;
}

public function email_id($id){
    $this->db->select('item_requisitions.id as item_id,item_requisitions.item_name,item_requirement,item_requisitions.item_qty,quotations.id as quot_id,quotations.supplier_id,quotations.item,quotations.price');
    $this->db->from('quotations'); 
    $this->db->join('item_requisitions', 'quotations.item = item_requisitions.id', 'left');
    $this->db->where('quotations.id', $id);
    return $this->db->get()->row();
}

// approved quotation  
 public function ApprovedQuotation($id, $data) {
    $dataa = array(
        'status' => 3
    ); 
    $this->db->where('id', $id);
    $this->db->update('quotations', $data);

    $this->db->select('id,item,status');
    $this->db->from('quotations');
    $this->db->where(array('id' => $id, 'status' => 1));
    $item = $this->db->get()->row();
    $item_id = $item->item;  
    // $this->db->select('item,status');
    // $this->db->from('quotations');
    // $this->db->where(array('item' => $item_id)); 
    $this->db->where('item', $item_id);
    $this->db->where('status', NULL);
    $this->db->update('quotations', $dataa); 
    return true;
}
// Reject Quotation
public function RejectQuotation($id, $data) {
    $this->db->where('id', $id);
    $this->db->update('quotations', $data);
    return true;
}
    // Count user assign asset
    public function count_user_assign_asset(){
        $this->db->select('item_assignment.id as assign_id, item_assignment.assignd_to');
        $this->db->from('item_assignment');
        $this->db->join('items', 'items.id = item_assignment.item_id', 'left');
        $this->db->where('return_back_date =', null);
        if ($this->session->userdata('user_role') != '1' && $this->session->userdata('user_role') != '3') {
            $this->db->where('items.location', $this->session->userdata('location'));
            $this->db->where('item_assignment.assignd_to', $this->session->userdata('id')); 
        } 
        return $this->db->count_all_results(); 
    }

// user item detail list 
public function user_asset_list($limit, $offset){
    $this->db->select('items.id, items.location, items.category, items.sub_category, items.type_name, items.model, items.serial_number, items.supplier, items.price, items.quantity, items.depreciation, items.purchasedate, items.created_at, users.fullname as employ_name, users.id as employ_id, item_assignment.id,item_assignment.item_id, item_assignment.status, item_assignment.id as item_ids, item_assignment.assignd_to, sub_categories.name as names, categories.cat_name, locations.name, suppliers.id as sup_id, suppliers.name as sup_name');
    $this->db->from('item_assignment');
    $this->db->join('items', 'item_assignment.item_id = items.id', 'left');
    $this->db->join('categories', 'items.category = categories.id', 'left');
    $this->db->join('sub_categories', 'items.sub_category = sub_categories.id', 'left');
    $this->db->join('users', 'item_assignment.assignd_to = users.id', 'left');
    $this->db->join('locations', 'users.location = locations.id', 'left'); 
    $this->db->join('suppliers', 'items.sub_category = suppliers.id', 'left'); 
    $this->db->where('item_assignment.item_id !=', null);
    $this->db->group_by('item_assignment.id');

    $role = $this->session->userdata('user_role'); 
    if($role != 3 && $role != 1){ 
        $this->db->where('item_assignment.assignd_to', $this->session->userdata('id'));
    }
    
    $id = $this->uri->segment(3); // taking segment 3 when click on tab 
    if(isset($id)) { 
        if($id == 0) {
            $this->db->where(array('item_assignment.status' => 0));
        } 
        if($id == 1) { 
            $this->db->where(array('item_assignment.status' => 1));
        } 
    } 
    if(!isset($id)){
        $this->db->limit($limit, $offset); 
    }
    // echo $this->db->last_query(); exit;
    return $this->db->get()->result(); 

   }

// all report code below
  // Locations - Get item locations
  public function get_item_location(){
    $location = $this->session->userdata('location'); 
    $this->db->from('locations');
    if ($this->session->userdata('user_role') != '1') {
        $this->db->where('id', $this->session->userdata('location'));
    }
    return $this->db->get()->result();
} 
   // get department for for report
   public function department(){
    return $this->db->from('departments')->get()->result();
}
   // get company
   public function get_company(){
    $this->db->select('id,name,code');
    $this->db->from('company'); 
    return $this->db->get()->result();
} 

    // Count request
    public function request_count(){
        $this->db->select('item_requisitions.id as req_id, item_requisitions.status');
        $this->db->from('item_requisitions'); ;
        $this->db->where('item_requisitions.status', null);
        if ($this->session->userdata('user_role') != '1' && $this->session->userdata('user_role') != '3') {
            $this->db->where('item_requisitions.location_id', $this->session->userdata('location'));
        } 
        return $this->db->count_all_results(); 
    }
 
    // filter_request 
    public function filter_request($limit, $offset,$data,$report = null,$count = null){
        $this->db->select('item_requisitions.id, 
        item_requisitions.item_name, 
        item_requisitions.item_requirement, 
        item_requisitions.item_qty,
        item_requisitions.status,
        item_requisitions.item_desc,
        item_requisitions.location_id, 
        item_requisitions.department_id, 
        item_requisitions.company_id, 
        item_requisitions.requested_by, 
        item_requisitions.created_at as date,
        locations.id as loc_id,
        locations.name,
        users.id as user_id,
        users.fullname,
        company.id as company_id,
        company.name as company_name,
        departments.id as dep_id,
        departments.department as department_name,
        locations.id as loc_id,
        locations.name as loc_name');
    $this->db->from('item_requisitions');
    $this->db->join('locations','item_requisitions.location_id = locations.id');
    $this->db->join('users','item_requisitions.requested_by = users.id');
    $this->db->join('company','item_requisitions.company_id = company.id');
    $this->db->join('departments','item_requisitions.department_id = departments.id');

    if($data['city'] != null){
        $this->db->where('location_id', $data['city']);
    } 
    if($data['company'] != null){ 
        $this->db->like('item_requisitions.company_id', $data['company']);
    } 
    if($data['department'] != null){
        $this->db->where('department_id', $data['department']);
    } 
    if($data['name'] != null){
        $this->db->where('requested_by', $data['name']);
    } 
    if($data['item'] != null){
        $this->db->where('item_name', $data['item']);
    } 
    if($data['model'] != null){
        $this->db->where('item_requirement', $data['model']);
    } 
    if($data['quantity'] != null){
        $this->db->where('item_qty', $data['quantity']);
    }
    if($count != false) {
        return $this->db->count_all_results();
    }
    if($report == "filter_process_request"){ 
        $this->db->where('item_requisitions.status', '2');
    }if(empty($report)){
        $this->db->where('item_requisitions.status', null);
    }if($report == "filter_approved_request"){
        $this->db->where('item_requisitions.status', '1');
    }if($report == "filter_reject_request"){
        $this->db->where('item_requisitions.status', '0');
    }

    $this->db->limit($limit, $offset);
    
    return $this->db->get()->result();
    } 
  // Get employee against on location
  public function employee_against_location($loc_id){
    $this->db->select('id, fullname, email');
    $this->db->from('users');
    $this->db->where(array('location'=> $loc_id));
    return $this->db->get()->result();
}


}
