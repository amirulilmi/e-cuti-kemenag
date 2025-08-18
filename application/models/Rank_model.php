<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Rank_model extends CI_Model
{
    private $table = 'tblranks';

    // public function get_all()
    // {
    //     return $this->db->get($this->table)->result_array();
    // }

    public function get_all()
    {
        return $this->db
            ->select('tblranks.*, tblcategories.name AS category_name')
            ->from('tblranks')
            ->join('tblcategories', 'tblcategories.id = tblranks.id_category', 'left')
            ->get()
            ->result_array();
    }
    public function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
