<?php

    // Headers
    header('Access-Control-Origin: *');
    header('Content-Type: application/json');

    include_once '../../Config/Database.php';
    include_once '../../Models/Customers.php';

    // Instantiate DB & Connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate Customer Object
    $customer = new Customers($db);

    //Get ID
    $customer->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Customer Query
    $result = $customer->read_single();

    // create array
    $customer_arr = array(
        'id' => $customer->id,
        'customer_name' => $customer->customer_name,
        'customer_email' => $customer->customer_email,
        'customer_contactno' => $customer->customer_contactno,
        'customer_status' => $customer->customer_status
    );

    // Make JSON
    print_r(json_encode($customer_arr));
?>