<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calender_model extends CI_Model {

    public function get_all()
    {
        $this->db->order_by('holiday_date', 'ASC');
        return $this->db->get('calender')->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert('calender', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('calender', ['id' => $id]);
    }
}
