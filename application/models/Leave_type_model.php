<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave_type_model extends CI_Model {

    public function get_all()
    {
        return $this->db->get('tblleavetype')->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('tblleavetype', $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('tblleavetype', $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete('tblleavetype');
    }

    public function get_by_id($id)
    {
        return $this->db->get_where('tblleavetype', ['id' => $id])->row_array();
    }
}
