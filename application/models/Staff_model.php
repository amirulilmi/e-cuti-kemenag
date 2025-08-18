<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff_model extends CI_Model {

    public function get_departments() {
        return $this->db->select('id, department_name')
                        ->from('tbldepartments')
                        ->order_by('department_name', 'ASC')
                        ->get()
                        ->result_array();
    }

    public function get_staff($department_id = null, $search = null) {
        $this->db->select('emp_id, first_name, middle_name, last_name, phone_number, designation, email_id, department, image_path');
        $this->db->from('tblemployees');

        if (!empty($department_id)) {
            $this->db->where('department', $department_id);
        }

        if (!empty($search)) {
            $this->db->group_start()
                     ->like('first_name', $search)
                     ->or_like('middle_name', $search)
                     ->or_like('last_name', $search)
                     ->or_like('email_id', $search)
                     ->group_end();
        }

        $this->db->order_by('date_created', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_staff_by_id($id) {
        return $this->db->where('emp_id', $id)->get('tblemployees')->row_array();
    }

    public function get_department_by_id($id) {
        return $this->db->where('id', $id)->get('tbldepartments')->row_array();
    }

    public function get_all_departments() {
        return $this->db->get('tbldepartments')->result_array();
    }
    public function insert_staff($data) {
        return $this->db->insert('tblemployees', $data);
    }

    public function update_staff($id, $data) {
        return $this->db->where('emp_id', $id)->update('tblemployees', $data);
    }

    public function delete_staff($id)
    {
        return $this->db->delete('tblemployees', ['emp_id' => $id]);
    }

    // 
    // 
    // 

    public function get_all_staff() {
        $this->db->select('e.*, d.department_name');
        $this->db->from('tblemployees e');
        $this->db->join('tbldepartments d', 'e.department = d.id', 'left');
        $this->db->order_by('e.date_created', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get employee data by ID
     */
    public function get_employee_by_id($emp_id) {
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get('tblemployees');
        return $query->row_array();
    }

    /**
     * Add new staff member
     */
    public function add_staff($data) {
        return $this->db->insert('tblemployees', $data);
    }


    public function get_supervisor($emp_id) {
        $this->db->select('s.emp_id, s.first_name, s.middle_name, s.last_name');
        $this->db->from('tblemployees e');
        $this->db->join('tblemployees s', 'e.supervisor_id = s.emp_id');
        $this->db->where('e.emp_id', $emp_id);
        $query = $this->db->get();
        return $query->row_array();
    }

    /**
     * Get assigned leave types for an employee
     */
    public function get_assigned_leave_types($emp_id) {
        $this->db->select('lt.leave_type, lt.assign_days, elt.available_days,elt.n1,elt.n2,elt.leave_type_id');
        $this->db->from('tblleavetype lt');
        $this->db->join('employee_leave_types elt', 'lt.id = elt.leave_type_id');
        $this->db->where('elt.emp_id', $emp_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get all active leave types
     */
    public function get_all_leave_types() {
        $this->db->where('status', '1');
        $query = $this->db->get('tblleavetype');
        return $query->result_array();
    }

    /**
     * Get assigned leave types with IDs for an employee
     */
    public function get_assigned_leave_types_with_ids($emp_id) {
        $this->db->select('leave_type_id, available_days, n1, n2');
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get('employee_leave_types');
        
        $result = array();
        foreach($query->result_array() as $row) {
            $result[$row['leave_type_id']] = $row['available_days'];
        }
        return $result;
    }

    // public function get_assigned_leave_types_with_ids($emp_id) {
    //     $this->db->select('leave_type_id, available_days, n1, n2');
    //     $this->db->where('emp_id', $emp_id);
    //     $query = $this->db->get('employee_leave_types');
        
    //     $result = array();
    //     foreach($query->result_array() as $row) {
    //         $result[$row['leave_type_id']] = [
    //             'available_days' => $row['available_days'],
    //             'n1' => $row['n1'],
    //             'n2' => $row['n2']
    //         ];
    //     }
    //     return $result;
    // }


    public function get_department_name($dept_id) {
        $this->db->select('department_name');
        $this->db->where('id', $dept_id);
        $query = $this->db->get('tbldepartments');
        $result = $query->row_array();
        return $result ? $result['department_name'] : '';
    }

    public function get_potential_supervisors($emp_id) {
        // First get employee's role and department
        $employee = $this->get_employee_by_id($emp_id);
        
        if (!$employee) {
            return array();
        }
        
        if ($employee['role'] === 'Manager') {
            // If manager, show only other managers in same department
            $this->db->select('emp_id, first_name, middle_name, last_name');
            $this->db->where('role', 'Manager');
            $this->db->where('department', $employee['department']);
            $this->db->where('emp_id !=', $emp_id);
        } else {
            // If staff, show managers or supervisors in same department
            $this->db->select('emp_id, first_name, middle_name, last_name');
            $this->db->group_start();
                $this->db->where('role', 'Manager');
                $this->db->or_where('is_supervisor', 1);
            $this->db->group_end();
            $this->db->where('department', $employee['department']);
            $this->db->where('emp_id !=', $emp_id);
        }
        
        $this->db->order_by('first_name', 'ASC');
        $query = $this->db->get('tblemployees');
        return $query->result_array();
    }

    /**
     * Assign supervisor to employee
     */
    public function assign_supervisor($emp_id, $supervisor_id) {
        $data = array('supervisor_id' => $supervisor_id);
        $this->db->where('emp_id', $emp_id);
        return $this->db->update('tblemployees', $data);
    }

    /**
     * Update employee leave types
     */
    public function update_employee_leave_types($emp_id, $leave_types) {
        // Start transaction
        $this->db->trans_start();
        
        // First, get current leave types
        $current_types = $this->get_assigned_leave_types_with_ids($emp_id);
        
        // Remove leave types that are no longer selected (only if not used)
        foreach($current_types as $type_id => $available_days) {
            if (!in_array($type_id, $leave_types)) {
                // Get original assigned days for this type
                $this->db->select('assign_days');
                $this->db->where('id', $type_id);
                $original = $this->db->get('tblleavetype')->row_array();
                
                // Only remove if not used (available_days equals assign_days)
                if ($original && $available_days == $original['assign_days']) {
                    $this->db->where('emp_id', $emp_id);
                    $this->db->where('leave_type_id', $type_id);
                    $this->db->delete('employee_leave_types');
                }
            }
        }
        
        // Add new leave types
        foreach($leave_types as $type_id) {
            if (!array_key_exists($type_id, $current_types)) {
                // Get assign_days for this leave type
                $this->db->select('assign_days');
                $this->db->where('id', $type_id);
                $leave_type = $this->db->get('tblleavetype')->row_array();
                
                if ($leave_type) {
                    $data = array(
                        'emp_id' => $emp_id,
                        'leave_type_id' => $type_id,
                        'available_days' => $leave_type['assign_days']
                    );
                    $this->db->insert('employee_leave_types', $data);
                }
            }
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    /**
     * Change password for employee
     */
    public function change_password($emp_id, $new_password) {
        // Consider using password_hash() instead of md5 for better security
        $data = array('password' => md5($new_password));
        $this->db->where('emp_id', $emp_id);
        return $this->db->update('tblemployees', $data);
    }

    /**
     * Verify old password
     */
    public function verify_old_password($emp_id, $old_password) {
        $this->db->select('password');
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get('tblemployees');
        $result = $query->row_array();
        
        return ($result && $result['password'] === md5($old_password));
    }

    /**
     * Check if email exists (for validation)
     */
    public function email_exists($email, $exclude_emp_id = null) {
        $this->db->where('email_id', $email);
        if ($exclude_emp_id) {
            $this->db->where('emp_id !=', $exclude_emp_id);
        }
        $query = $this->db->get('tblemployees');
        return $query->num_rows() > 0;
    }

    /**
     * Check if staff ID exists (for validation)
     */
    public function staff_id_exists($staff_id, $exclude_emp_id = null) {
        $this->db->where('staff_id', $staff_id);
        if ($exclude_emp_id) {
            $this->db->where('emp_id !=', $exclude_emp_id);
        }
        $query = $this->db->get('tblemployees');
        return $query->num_rows() > 0;
    }

    /**
     * Get staff count by department
     */
    public function get_staff_count_by_department() {
        $this->db->select('d.department_name, COUNT(e.emp_id) as staff_count');
        $this->db->from('tbldepartments d');
        $this->db->join('tblemployees e', 'd.id = e.department', 'left');
        $this->db->group_by('d.id');
        $this->db->order_by('d.department_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get staff by department
     */
    public function get_staff_by_department($dept_id) {
        $this->db->select('e.*, d.department_name');
        $this->db->from('tblemployees e');
        $this->db->join('tbldepartments d', 'e.department = d.id', 'left');
        $this->db->where('e.department', $dept_id);
        $this->db->order_by('e.first_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get staff by role
     */
    public function get_staff_by_role($role) {
        $this->db->select('e.*, d.department_name');
        $this->db->from('tblemployees e');
        $this->db->join('tbldepartments d', 'e.department = d.id', 'left');
        $this->db->where('e.role', $role);
        $this->db->order_by('e.first_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Search staff members
     */
    public function search_staff($keyword) {
        $this->db->select('e.*, d.department_name');
        $this->db->from('tblemployees e');
        $this->db->join('tbldepartments d', 'e.department = d.id', 'left');
        
        $this->db->group_start();
        $this->db->like('e.first_name', $keyword);
        $this->db->or_like('e.middle_name', $keyword);
        $this->db->or_like('e.last_name', $keyword);
        $this->db->or_like('e.email_id', $keyword);
        $this->db->or_like('e.staff_id', $keyword);
        $this->db->or_like('e.designation', $keyword);
        $this->db->or_like('d.department_name', $keyword);
        $this->db->group_end();
        
        $this->db->order_by('e.first_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get supervisors and their subordinates
     */
    public function get_supervisor_subordinates($supervisor_id) {
        $this->db->select('e.*, d.department_name');
        $this->db->from('tblemployees e');
        $this->db->join('tbldepartments d', 'e.department = d.id', 'left');
        $this->db->where('e.supervisor_id', $supervisor_id);
        $this->db->order_by('e.first_name', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get leave types assigned to an employee with detailed info
     */
    public function get_employee_leave_balance($emp_id) {
        $this->db->select('lt.id, lt.leave_type, lt.assign_days, elt.available_days, 
                          (lt.assign_days - elt.available_days) as used_days');
        $this->db->from('tblleavetype lt');
        $this->db->join('employee_leave_types elt', 'lt.id = elt.leave_type_id');
        $this->db->where('elt.emp_id', $emp_id);
        $this->db->where('lt.status', '1');
        $this->db->order_by('lt.leave_type', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Update leave balance for an employee
     */
    public function update_leave_balance($emp_id, $leave_type_id, $days_used) {
        // Get current available days
        $this->db->select('available_days');
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_type_id', $leave_type_id);
        $query = $this->db->get('employee_leave_types');
        $current = $query->row_array();
        
        if ($current) {
            $new_available = $current['available_days'] - $days_used;
            
            $data = array('available_days' => max(0, $new_available));
            $this->db->where('emp_id', $emp_id);
            $this->db->where('leave_type_id', $leave_type_id);
            return $this->db->update('employee_leave_types', $data);
        }
        
        return false;
    }

}
