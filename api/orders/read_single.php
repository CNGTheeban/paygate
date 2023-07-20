<?php

    // Headers
    header('Access-Control-Origin: *');
    header('Content-Type: application/json');

    include_once '../../Config/Database.php';
    include_once '../../Models/Orders.php';

    // Instantiate DB & Connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate Order Object
    $order = new Orders($db);

    //Get ID
    $order->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Order Query
    $result = $order->read_single();

    // create array
    $order_arr = array(
        'id' => $order->id,        
        'item_id' => $order->item_id,
        'customer_id' => $order->customer_id,
        'transferRef' => $order->transferRef,
        'amount' => $order->amount,
        'order_status' => $order->order_status,
        'paydate' => $order->paydate
    );

    // Make JSON
    print_r(json_encode($order_arr));
?>