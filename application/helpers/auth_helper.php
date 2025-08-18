<?php
function is_logged_in() {
    $CI =& get_instance();
    return $CI->session->userdata('logged_in') ? true : false;
}

function get_user_role() {
    $CI =& get_instance();
    return $CI->session->userdata('role');
}

function has_permission($required_role) {
    $user_role = get_user_role();
    $roles = ['Staff' => 1, 'Manager' => 2, 'Admin' => 3];
    
    return isset($roles[$user_role]) && 
           isset($roles[$required_role]) && 
           $roles[$user_role] >= $roles[$required_role];
}