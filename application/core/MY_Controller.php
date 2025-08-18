<?php
class MY_Controller extends CI_Controller {
    
    protected $data = [];
    
    public function __construct() {
        parent::__construct();
        
        // Check if user is logged in
        if(!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
        
        // Set common data
        $this->data['user_name'] = $this->session->userdata('name');
        $this->data['user_role'] = $this->session->userdata('role');
        $this->data['user_id'] = $this->session->userdata('emp_id');
    }
    
    protected function render($view, $data = []) {
        $data = array_merge($this->data, $data);
        
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view($view, $data);
        $this->load->view('templates/footer', $data);
    }
    
    protected function json_response($data) {
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($data));
    }
    
    protected function check_permission($allowed_roles = []) {
        $user_role = $this->session->userdata('role');
        
        if(!in_array($user_role, $allowed_roles)) {
            if($this->input->is_ajax_request()) {
                $this->json_response(['status' => 'error', 'message' => 'Access denied']);
                exit;
            } else {
                show_error('You do not have permission to access this page', 403);
            }
        }
    }
}