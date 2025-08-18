<?php
$config = [
    'employee_create' => [
        ['field' => 'first_name', 'label' => 'First Name', 'rules' => 'required|alpha'],
        ['field' => 'last_name', 'label' => 'Last Name', 'rules' => 'required|alpha'],
        ['field' => 'email_id', 'label' => 'Email', 'rules' => 'required|valid_email|is_unique[tblemployees.email_id]'],
        ['field' => 'phone_number', 'label' => 'Phone', 'rules' => 'required|numeric|min_length[10]'],
        ['field' => 'department', 'label' => 'Department', 'rules' => 'required'],
        ['field' => 'password', 'label' => 'Password', 'rules' => 'required|min_length[6]']
    ],
    
    'leave_apply' => [
        ['field' => 'leave_type_id', 'label' => 'Leave Type', 'rules' => 'required'],
        ['field' => 'from_date', 'label' => 'From Date', 'rules' => 'required|callback_check_date'],
        ['field' => 'to_date', 'label' => 'To Date', 'rules' => 'required|callback_check_date'],
        ['field' => 'requested_days', 'label' => 'Days', 'rules' => 'required|numeric|greater_than[0]']
    ],
    
    'task_create' => [
        ['field' => 'title', 'label' => 'Title', 'rules' => 'required|min_length[3]'],
        ['field' => 'description', 'label' => 'Description', 'rules' => 'required'],
        ['field' => 'assigned_to', 'label' => 'Assigned To', 'rules' => 'required'],
        ['field' => 'priority', 'label' => 'Priority', 'rules' => 'required|in_list[Low,Medium,High]'],
        ['field' => 'due_date', 'label' => 'Due Date', 'rules' => 'required']
    ]
];