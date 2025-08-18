<?php
class Category_model extends CI_Model {
    
    private $table = 'tblcategories';

    
    public function get_with_stats() {
        $categories = $this->db->get('tblcategories')->result_array();
    
        foreach ($categories as &$catg) {
            // Hitung jumlah golongan / ranks
            $this->db->where('id_category', $catg['id']);
            $catg['rank_count'] = $this->db->count_all_results('tblranks');
    
            // Hitung jumlah staff berdasarkan tblemployees.id_ranks → tblranks.id_category
            $this->db->select('COUNT(tblemployees.emp_id) AS total_staff');
            $this->db->from('tblemployees');
            $this->db->join('tblranks', 'tblranks.id = tblemployees.id_ranks', 'inner');
            $this->db->where('tblranks.id_category', $catg['id']);
            $query = $this->db->get()->row_array();
    
            $catg['staff_count'] = (int) $query['total_staff'];
        }
    
        return $categories;
    }

    public function get_ranks_by_category($category_id) {
        return $this->db
                    ->where('id_category', $category_id)
                    ->get('tblranks')
                    ->result_array();
    }
    
    public function get_all()
    {
        return $this->db->get($this->table)->result_array();
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