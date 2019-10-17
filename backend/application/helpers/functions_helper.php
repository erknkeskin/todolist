<?php

function output($data)
{
    $ci = &get_instance();

    $ci->output->set_content_type('application/json', 'utf-8')
        ->set_status_header(200)
        ->set_output(json_encode($data));
}

function get_all_post_data()
{

    $data = array();

    foreach ($_POST as $key => $value) {
        $data[$key] = $value;
    }

    return $data;
}

function debug($param){
    echo "<pre>";
    print_r($param);
    echo "</pre>";
    exit;
}

function email_validate($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
}