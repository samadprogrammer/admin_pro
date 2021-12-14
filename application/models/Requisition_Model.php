<?php defined('BASEPATH') OR exit('No direct script access allowed!');
/**
 * undocumented class
 */
class Requisition_Model extends CI_Model{
    
// trequest list
    public function RequestList($limit, $offset,$user){
        $this->db->select('item_requisitions.id,item_requisitions.item_name,
        item_requisitions.item_desc,
        item_requisitions.item_qty,
        item_requisitions.requested_by,
        item_requisitions.status,
        item_requisitions.created_at as date,
        users.id as userId,
        users.fullname');
    $this->db->from('item_requisitions');
    $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');

    $data = $this->uri->segment(3);
    if(isset($data)){
    if($data == 0){ 
        $this->db->where(array('item_requisitions.requested_by' => $user, 'item_requisitions.status' => $data));
    }
    if($data == 1){ 
        $this->db->where(array('item_requisitions.requested_by' => $user, 'item_requisitions.status' => $data));
    }
    if($data == 2){ 
        $this->db->where(array('item_requisitions.requested_by' => $user, 'item_requisitions.status' => $data));
    }
    if($data == 3){ 
        $this->db->where(array('item_requisitions.requested_by' => $user, 'item_requisitions.status' => null));
    }
    
    if(!isset($data)){ 
        $this->db->where('item_requisitions.requested_by', $user);
        $this->db->limit($limit, $offset); 
    } 
} 
// $this->db->order_by(array('item_requisitions.id' => 'DESC', 'item_requisitions.status' => 2));
// $this->db->order_by("item_requisitions.id DESC, item_requisitions.status 2");

$this->db->order_by('item_requisitions.id', 'desc');
// $this->db->order_by('item_requisitions.status', 'null');
$this->db->order_by('item_requisitions.status', '3');

    return $this->db->get()->result();
    } 
// search request list --> record    
public function SearchRequest($search,$user){
        $this->db->select('item_requisitions.id,
        item_requisitions.item_name,
        item_requisitions.item_desc,
        item_requisitions.item_qty,
        item_requisitions.requested_by,
        item_requisitions.status,
        item_requisitions.created_at as date,
        users.id as userId,
        users.fullname');
    $this->db->from('item_requisitions');     
    $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left'); 
    
    $this->db->group_start(); //start group 
    $this->db->or_like('item_name', $search);
    $this->db->or_like('item_desc', $search);
    $this->db->or_like('item_qty', $search);
    $this->db->or_like('requested_by', $search);
    $this->db->or_like('fullname', $search); 
    $this->db->group_end(); //close group

    $this->db->where('item_requisitions.requested_by', $user);
    $this->db->order_by('item_requisitions.created_at', 'DESC');
    return $this->db->get()->result();    

}

public function AddRequest($data, $user) {
    $this->db->trans_begin();

    $this->db->query("INSERT INTO item_requisitions (`item_name`, `item_desc`, `item_qty`,`location_id`,`department_id`,`company_id`, `requested_by`, `status`) VALUES ('$data->item_name', '$data->item_desc', $data->item_qty, ' $data->location','$data->department','$data->company','$user', NULL)");

    if ($this->db->trans_status() === FALSE)
    {
        $this->db->trans_rollback();
        return false;
    }
    $this->db->trans_commit();
    return true;
}
// view request -- detail
public function ViewRequest($id){

    $this->db->select('item_requisitions.id, 
    item_requisitions.item_name,
    item_requisitions.item_desc,
    item_requisitions.item_qty,
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
    company.name as company_name ');
    $this->db->from('item_requisitions');
    $this->db->join('users', 'item_requisitions.requested_by = users.id', 'left');
    $this->db->join('locations', 'item_requisitions.location_id = locations.id', 'left');
    $this->db->join('departments', 'item_requisitions.department_id = departments.id', 'left');
    $this->db->join('company', 'item_requisitions.company_id = company.id', 'left');
    $this->db->where('item_requisitions.id', $id);
    return $this->db->get()->row();

}
// forwarder request to director or GM
public function ForwardList($id,$data){
    $this->db->where('id', $id);
    $this->db->update('item_requisitions', $data);
    return true;
}
// Approved request List
public function ApprovedList($id,$data){
    $this->db->where('id', $id);
    $this->db->update('item_requisitions', $data);
    return true;
}
// Reject request
public function RejectList($id,$data){
    $this->db->where('id', $id);
    $this->db->update('item_requisitions', $data);
    return true;
}
}
