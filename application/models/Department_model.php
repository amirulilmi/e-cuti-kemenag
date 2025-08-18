<?php
class Department_model extends CI_Model {
    
    private $table = 'tbldepartments';

    
    public function get_with_stats() {
        $departments = $this->db->get('tbldepartments')->result_array();

        foreach ($departments as &$dept) {
            // Hitung jumlah karyawan
            $this->db->where('department', $dept['id']);
            $dept['employee_count'] = $this->db->count_all_results('tblemployees');

            // Hitung jumlah manager
            $this->db->where('department', $dept['id'])
                     ->where('role', 'Manager');
            $dept['manager_count'] = $this->db->count_all_results('tblemployees');
        }

        return $departments; // array of array
    }

    public function get_staff_by_department($department_id) {
        return $this->db
                    ->where('department', $department_id)
                    ->get('tblemployees')
                    ->result_array();
    }
    
    public function insert($data) {
        $data['creation_date'] = date('Y-m-d H:i:s');
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        $data['last_modified_date'] = date('Y-m-d H:i:s');
        return $this->db->where('id', $id)->update($this->table, $data);
    }
    
    public function delete($id) {
        // Check if department has employees
        $this->db->where('department', $id);
        $count = $this->db->count_all_results('tblemployees');
        
        if($count > 0) {
            return ['status' => false, 'message' => 'Cannot delete department with employees'];
        }
        
        $this->db->where('id', $id)->delete($this->table);
        return ['status' => true, 'message' => 'Department deleted successfully'];
    }
}