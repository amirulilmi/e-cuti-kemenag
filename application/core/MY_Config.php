<?php
class MY_Config extends CI_Config {
    public function __construct()
    {
        parent::__construct();

        // Force HTTPS if coming from ngrok / devtunnel
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
            $this->set_item('base_url', 'https://'.$_SERVER['HTTP_HOST'].'/dipecut/');
        }
    }
}