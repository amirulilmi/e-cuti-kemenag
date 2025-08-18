<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave_model extends CI_Model
{

    // 
    // 
    // APPLY LEAVE
    public function get_employees()
    {
        $this->db->select('emp_id, first_name, middle_name, last_name');
        $this->db->from('tblemployees');
        return $this->db->get()->result();
    }
    public function insertLeave($empId, $leaveType, $startDate, $endDate, $numberDays, $remarks, $sickFilePath, $approveFilePath)
    {
        $data = [
            'empid' => $empId,
            'leave_type_id' => $leaveType,
            'from_date' => $startDate,
            'to_date' => $endDate,
            'requested_days' => $numberDays,
            'remarks' => $remarks,
            'sick_file' => $sickFilePath,
            'file' => $approveFilePath
        ];

        return $this->db->insert('tblleave', $data);
    }
    // public function getLeaveTypesByEmployee($empId)
    // {
    //     $this->db->select('lt.id, lt.leave_type, lt.allowsat, lt.allowsun , el.available_days');
    //     $this->db->from('employee_leave_types el');
    //     $this->db->join('tblleavetype lt', 'lt.id = el.leave_type_id');
    //     $this->db->where('el.emp_id', $empId);

    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

    public function getLeaveTypesByEmployee($empId)
    {
        $this->db->select('
            lt.id, 
            lt.leave_type, 
            lt.leave_allowsat, 
            lt.leave_allowsun, 
            el.available_days,
            d.id as department_id,
            d.dept_allowsun,
            d.dept_allowsat,
        ');
        $this->db->from('employee_leave_types el');
        $this->db->join('tblleavetype lt', 'lt.id = el.leave_type_id');
        $this->db->join('tblemployees e', 'e.emp_id = el.emp_id');
        $this->db->join('tbldepartments d', 'd.id = e.department', 'left'); // pakai left join biar aman
    
        $this->db->where('el.emp_id', $empId);
    
        $query = $this->db->get();

        
        return $query->result_array();
    }

    public function update_leave($leave_id, $data) {
        $this->db->where('id', $leave_id);
        return $this->db->update('tblleave', $data);
    }
    // 
    // 
    // MY LEAVE

    public function get_user_leaves($userId)
    {
        $this->db->select('l.leave_type_id, l.from_date, l.to_date, l.requested_days, lt.leave_type');
        $this->db->from('tblleave l');
        $this->db->join('tblleavetype lt', 'l.leave_type_id = lt.id');
        $this->db->where('l.empid', $userId);
        $this->db->where('l.leave_status', 4);

        return $this->db->get()->result_array();
    }

    public function get_available_days($userId)
    {
        $this->db->select('leave_type_id, available_days');
        $this->db->from('employee_leave_types');
        $this->db->where('emp_id', $userId);
        $query = $this->db->get();

        $result = $query->result_array();

        $data = [];
        foreach ($result as $row) {
            $data[$row['leave_type_id']] = $row['available_days'];
        }

        return $data;
    }

    public function get_n1($userId)
    {
        $this->db->select('leave_type_id,n1');
        $this->db->from('employee_leave_types');
        $this->db->where('emp_id', $userId);
        $query = $this->db->get();

        $result = $query->result_array();

        $data = [];
        foreach ($result as $row) {
            $data[$row['leave_type_id']] = $row['n1'];
        }

        return $data;
    }

    public function get_n2($userId)
    {
        $this->db->select('leave_type_id, n2');
        $this->db->from('employee_leave_types');
        $this->db->where('emp_id', $userId);
        $query = $this->db->get();

        $result = $query->result_array();

        $data = [];
        foreach ($result as $row) {
            $data[$row['leave_type_id']] = $row['n2'];
        }

        return $data;
    }



    public function get_assign_days()
    {
        // Ambil data id dan assign_days dari tabel tblleavetype
        $query = $this->db->select('id, assign_days')
            ->from('tblleavetype')
            ->get();

        $result = $query->result_array();

        // Ubah hasil query jadi associative array: [id => assign_days]
        $data = [];
        foreach ($result as $row) {
            $data[$row['id']] = $row['assign_days'];
        }

        return $data;
    }

    public function getLeaveTypes()
    {
        $query = $this->db->select('id, leave_type')
            ->from('tblleavetype')
            ->get();

        $result = $query->result_array();

        $data = [];
        foreach ($result as $row) {
            $data[$row['id']] = $row['leave_type'];  // mapping id => leave_type
        }

        return $data;
    }

    // public function get_leave_request_by_id($id)
    // {
    //     $this->db->select('lr.*, e.first_name, e.last_name');
    //     $this->db->from('tblleaverequest lr');
    //     $this->db->join('employees e', 'e.id = lr.emp_id', 'left');
    //     $this->db->where('lr.id', $id);
    //     return $this->db->get()->row();
    // }

    public function getFilteredStaff($searchQuery = '', $leaveStatusFilter = '', $userId = '', $statusMap = [])
    {
        $this->db->select('
            tblleave.*,
            CONCAT_WS(" ", tblemployees.first_name, tblemployees.middle_name, tblemployees.last_name) AS staff_name,
            tblemployees.image_path,
            tblemployees.designation,
            tblleavetype.leave_type,
            elt.available_days
        ');
        $this->db->from('tblleave');
        $this->db->join('tblemployees', 'tblemployees.emp_id = tblleave.empid', 'left');
        $this->db->join('tblleavetype', 'tblleavetype.id = tblleave.leave_type_id', 'left');
        $this->db->join('employee_leave_types elt', 'elt.emp_id = tblleave.empid AND elt.leave_type_id = tblleave.leave_type_id', 'left');

        // Filter berdasarkan user tertentu
        if (!empty($userId)) {
            $this->db->where('tblleave.empid', $userId);
        }
        
        // Filter status cuti
        if (isset($leaveStatusFilter) && $leaveStatusFilter !== '' && $leaveStatusFilter !== 'Show all' && isset($statusMap[$leaveStatusFilter])) {
            $statusValue = $statusMap[$leaveStatusFilter];
            $this->db->where('tblleave.leave_status', $leaveStatusFilter);
        }
        // Filter pencarian
        if (!empty($searchQuery)) {
            $this->db->group_start();
            $this->db->like('tblemployees.first_name', $searchQuery);
            $this->db->or_like('tblemployees.middle_name', $searchQuery);
            $this->db->or_like('tblemployees.last_name', $searchQuery);
            $this->db->or_like('tblleave.remarks', $searchQuery);
            $this->db->or_like('tblleavetype.leave_type', $searchQuery);
            $this->db->group_end();
        }

        $this->db->order_by('tblleave.created_date', 'DESC');

        $query = $this->db->get();
        $leaves = $query->result();

        // Hitung remaining_days untuk setiap cuti
        foreach ($leaves as $leave) {
            $leave->remaining_days = $leave->available_days;
        }

        return $leaves;
    }



    // 
    // 
    // 
    // ALL LEAVES

    public function get_available_days_type($emp_id, $leave_type_id) {
        $this->db->select('available_days');
        $this->db->from('employee_leave_types');
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_type_id', $leave_type_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->available_days;
        }
        return 0;
    }

    public function get_employee_name($emp_id) {
        $this->db->select("CONCAT(first_name, ' ', IFNULL(middle_name, ''), ' ', last_name) AS name", FALSE);
        $this->db->from('tblemployees');
        $this->db->where('emp_id', $emp_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->name;
        }
        return null;
    }

    public function get_leave_type_description($leave_type_id) {
        $this->db->select('leave_type');
        $this->db->from('tblleavetype');
        $this->db->where('id', $leave_type_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row()->leave_type;
        }
        return null;
    }

    public function get_supervisor_info($emp_id) {
        $this->db->select("s.email_id AS supervisor_email, CONCAT(s.first_name, ' ', IFNULL(s.middle_name, ''), ' ', s.last_name) AS supervisor_name", FALSE);
        $this->db->from('tblemployees e');
        $this->db->join('tblemployees s', 'e.supervisor_id = s.emp_id');
        $this->db->where('e.emp_id', $emp_id);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return [
                'email' => $row->supervisor_email,
                'name' => $row->supervisor_name
            ];
        }
        return null;
    }

    public function get_all_employee_emails() {
        $this->db->select('email_id');
        $this->db->from('tblemployees');
        $query = $this->db->get();
        
        $emails = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                if (filter_var($row->email_id, FILTER_VALIDATE_EMAIL)) {
                    $emails[] = $row->email_id;
                }
            }
        }
        return $emails;
    }

    /**
     * Insert leave request
     */
    // public function insert_leave_request($data) {
    //     $insert_data = [
    //         'leave_type_id' => $data['leave_type_id'],
    //         'requested_days' => $data['requested_days'],
    //         'from_date' => $data['from_date'],
    //         'to_date' => $data['to_date'],
    //         'created_date' => date('Y-m-d H:i:s'),
    //         'leave_status' => 0,
    //         'empid' => $data['empid'],
    //         'remarks' => $data['remarks'],
    //         'sick_file' => isset($data['sick_file']) ? $data['sick_file'] : null
    //     ];
        
    //     return $this->db->insert('tblleave', $insert_data);
    // }

    /**
     * Get leave requests with filters
     */
    public function get_leave_requests($filters = []) {
        $this->db->select('l.*, e.first_name, e.middle_name, e.last_name, e.image_path, e.designation, lt.leave_type, elt.available_days');
        $this->db->from('tblleave l');
        $this->db->join('tblemployees e', 'l.empid = e.emp_id');
        $this->db->join('tblleavetype lt', 'l.leave_type_id = lt.id');
        $this->db->join('employee_leave_types elt', 'l.empid = elt.emp_id AND l.leave_type_id = elt.leave_type_id');
        $this->db->order_by('l.created_date', 'DESC'); // urutkan berdasarkan created_date terbaru
        
        // Apply role-based conditions
        if (isset($filters['user_role']) && $filters['user_role'] !== 'Admin') {
            if ($filters['user_role'] === 'Manager') {
                $this->db->where('e.department', $filters['user_department']);
                $this->db->where('l.empid !=', $filters['user_id']);
            } elseif (isset($filters['is_supervisor']) && $filters['is_supervisor'] == 1) {
                $this->db->where('e.supervisor_id', $filters['user_id']);
                $this->db->where('l.empid !=', $filters['user_id']);
            }
        }

        // print_r($filters);
        // Apply leave status filter
        if (isset($filters['leave_status']) && $filters['leave_status'] !== 'Show all') {
            $status_map = [
                '0' => 'Pending Admin Approval',
                '1' => 'Rejected by Admin',
                '2' => 'Forwarded to Kepala',
                '3' => 'Rejected by Kepala',
                '4' => 'Approved',
                '5' => 'Cancelled',
                '6' => 'Recalled',
            ];

            if (isset($status_map[$filters['leave_status']])) {
                $this->db->where('l.leave_status', $filters['leave_status']);
            }
        }

        // Apply search filter
        if (isset($filters['search_query']) && !empty($filters['search_query'])) {
            $search = $filters['search_query'];
            $this->db->group_start();
            $this->db->like('e.first_name', $search);
            $this->db->or_like('e.last_name', $search);
            $this->db->or_like('e.designation', $search);
            $this->db->or_like('lt.leave_type', $search);
            $this->db->or_like('l.remarks_admin', $search);
            $this->db->group_end();
        }

        $this->db->order_by('CASE WHEN l.leave_status = 0 THEN 0 ELSE 1 END', '', FALSE);
        $this->db->order_by('l.created_date', 'DESC');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get leave request by ID
     */
    public function get_leave_by_id($id_leave) {
        $this->db->select('*');
        $this->db->from('tblleave');
        $this->db->where('id', $id_leave);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return null;
    }

    /**
     * Update leave status
     */
    // public function update_leave_status($id, $status,$letter_number,$approveFilePath) {
    //     $this->db->where('id', $id);
    //     return $this->db->update('tblleave', ['leave_status' => $status]);
    // }

    public function update_leave_status($id, $status, $letter_number = null, $approveFilePath = null, $remarks_admin = null) {
        $data = [
            'leave_status' => $status
        ];
    
        if (!empty($letter_number)) {
            $data['letter_number'] = $letter_number;
        }
    
        if (!empty($approveFilePath)) {
            $data['file'] = $approveFilePath;
        }

        if (!empty($remarks_admin)) {
            $data['remarks_admin'] = $remarks_admin;
        }

    
        $this->db->where('id', $id);
        return $this->db->update('tblleave', $data);
    }
    /**
     * Update employee leave type available days
     */
    public function update_available_days($emp_id, $leave_type_id, $days, $operation = 'subtract') {
        if ($operation === 'subtract') {
            $this->db->set('available_days', 'available_days - ' . $days, FALSE);
        } else {
            $this->db->set('available_days', 'available_days + ' . $days, FALSE);
        }
        
        $this->db->where('emp_id', $emp_id);
        $this->db->where('leave_type_id', $leave_type_id);
        return $this->db->update('employee_leave_types');
    }

    /**
     * Delete leave request
     */
    public function delete_leave($id) {
        $this->db->where('id', $id);
        return $this->db->delete('tblleave');
    }

    /**
     * Get leave types
     */
    public function get_leave_types() {
        $this->db->select('id, leave_type');
        $this->db->from('tblleavetype');
        $query = $this->db->get();
        
        $types = [];
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $types[$row->id] = $row->leave_type;
            }
        }
        return $types;
    }

    /**
     * Get leave status counts
     */
    public function get_leave_status_counts($filters = []) {
        $leave_data = $this->get_leave_requests($filters);
        
        $status_map = [
            '0' => 'Pending Admin Approval',
            '1' => 'Rejected by Admin',
            '2' => 'Forwarded to Kepala',
            '3' => 'Rejected by Kepala',
            '4' => 'Approved',
            '5' => 'Cancelled',
            '6' => 'Recalled',
        ];
        
        $counts = array_fill_keys(array_keys($status_map), 0);
        
        foreach ($leave_data as $leave) {
            $status = $leave['leave_status'];
            if (isset($counts[$status])) {
                $counts[$status]++;
            }
        }
        
        return $counts;
    }

}
