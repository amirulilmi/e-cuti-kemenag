<?php
class SecurityCheck {
    
    private $CI;
    
    public function __construct() {
        $this->CI =& get_instance();
    }
    
    public function check_csrf() {
        // Skip CSRF for certain controllers
        $skip = ['auth'];
        
        if(!in_array($this->CI->router->class, $skip)) {
            // Verify CSRF token for POST requests
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $token = $this->CI->input->post('csrf_token');
                if($token !== $this->CI->session->userdata('csrf_token')) {
                    show_error('Invalid CSRF Token', 403);
                }
            }
        }
    }
    
    public function check_session_timeout() {
        if($this->CI->session->userdata('logged_in')) {
            $last_activity = $this->CI->session->userdata('last_activity');
            $timeout = 1800; // 30 minutes
            
            if(time() - $last_activity > $timeout) {
                $this->CI->session->sess_destroy();
                redirect('auth/login');
            }
            
            $this->CI->session->set_userdata('last_activity', time());
        }
    }
}