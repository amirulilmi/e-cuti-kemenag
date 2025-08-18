<?php
class Employee_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_all_employees() {
        return $this->db->get('tblemployees')->result();
    }
    
    public function get_employee($id) {
        return $this->db->where('emp_id', $id)->get('tblemployees')->row();
    }
    
    public function insert_employee($data) {
        // Hash password
        if(isset($data['password'])) {
            $data['password'] = md5($data['password']);
        }
        return $this->db->insert('tblemployees', $data);
    }
    
    public function update_employee($id, $data) {
        if(isset($data['password']) && !empty($data['password'])) {
            $data['password'] = md5($data['password']);
        } else {
            unset($data['password']);
        }
        return $this->db->where('emp_id', $id)->update('tblemployees', $data);
    }
    
    public function delete_employee($id) {
        return $this->db->where('emp_id', $id)->delete('tblemployees');
    }
    
    public function authenticate($email, $password) {
        $password = md5($password);
        return $this->db->where('email_id', $email)
                        ->where('password', $password)
                        ->get('tblemployees')
                        ->row();
    }
}