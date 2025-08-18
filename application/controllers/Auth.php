<?php
class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('employee_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login()
    {
        header("Access-Control-Allow-Origin: *"); // Atau spesifik: http://e-cuti-kemenag.test
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // print_r('asd');exit;
        if ($this->form_validation->run() == FALSE) {
            echo json_encode(array('status' => 'error', 'message' => validation_errors()));
            return;
        }

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->employee_model->authenticate($email, $password);
        if ($user) {
            $session_data = array(
                'emp_id' => $user->emp_id,
                'user_id' => $user->emp_id,
                'email' => $user->email_id,
                'name' => $user->first_name . ' ' . $user->last_name,
                'role' => $user->role,
                'department' => $user->department,
                'logged_in' => TRUE,
                'image' => $user->image_path,
                'first_name' => $user->first_name,
                'middle_name' =>  $user->middle_name,
                'last_name' => $user->last_name,
            );
            $this->session->set_userdata($session_data);

            echo json_encode(array(
                'status' => 'success',
                'message' => 'Login successful',
                'role' => strtolower($user->role)
            ));

            //remember me
            if ($this->input->post('remember') == 1) {
                // Buat token unik (tidak pakai password langsung)
                $user_token = bin2hex(random_bytes(32)); 
            
                // Simpan token ini di database
                $this->db->insert('user_tokens', [
                    'user_id' => $user->id,
                    'token' => hash('sha256', $user_token), // hash token sebelum simpan
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))
                ]);
            
                // Set cookie berisi token asli (bukan hash)
                $this->input->set_cookie([
                    'name'   => 'remember_token',
                    'value'  => $user_token,
                    'expire' => 60*60*24*30, // 30 hari
                    'secure' => true, // kalau HTTPS
                    'httponly' => true
                ]);
            }
          
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Email atau Password Salah'));
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }
}