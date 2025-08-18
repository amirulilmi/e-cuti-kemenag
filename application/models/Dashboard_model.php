<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function count_leave()
    {
        return $this->db->count_all('tblleave');
    }

    public function count_leave_by_status($status)
    {
        $this->db->where('leave_status', $status);
        return $this->db->count_all_results('tblleave');
    }

    public function count_employees()
    {
        return $this->db->count_all('tblemployees');
    }

    public function count_departments()
    {
        return $this->db->count_all('tbldepartments');
    }

    public function count_leave_types()
    {
        return $this->db->count_all('tblleavetype');
    }

    public function get_departments_with_counts()
    {
        $departments = $this->db->get('tbldepartments')->result_array();
        $data = [];
        foreach ($departments as $dept) {
            $staffCount = $this->db->where('department', $dept['id'])->count_all_results('tblemployees');
            $managerCount = $this->db
                ->where('department', $dept['id'])
                ->where('role', 'Manager')
                ->count_all_results('tblemployees');
            $data[] = [
                'id'           => $dept['id'],
                'name'         => $dept['department_name'],
                'desc'         => $dept['department_desc'],
                'staffCount'   => $staffCount,
                'managerCount' => $managerCount
            ];
        }
        return $data;
    }

    public function get_total_staff()
    {
        return $this->db->count_all('tblemployees');
    }

    public function get_newest_employees()
    {
        // $this->db->where('DATE(date_created)', date('Y-m-d'));
        $this->db->order_by('date_created', 'DESC'); // urutkan berdasarkan tanggal terbaru
        $this->db->limit(5);
        return $this->db->get('tblemployees')->result_array();
    }

    public function get_recent_leave()
    {
        $this->db->select('l.id, l.leave_type_id, l.requested_days, l.from_date, l.to_date, l.remarks, l.created_date, l.leave_status, l.empid, e.first_name, e.middle_name, e.last_name');
        $this->db->from('tblleave l');
        $this->db->join('tblemployees e', 'l.empid = e.emp_id');
        $this->db->join('tblleavetype lt', 'l.leave_type_id = lt.id');
        $this->db->where('DATE(l.created_date)', date('Y-m-d'));
        $this->db->order_by('e.emp_id', 'ASC');
        $this->db->limit(5);
        return $this->db->get()->result();
    }
}
