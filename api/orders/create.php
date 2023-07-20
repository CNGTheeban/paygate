<?php

    // Headers
    header('Access-Control-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../Config/Database.php';
    include_once '../../Models/Orders.php';

    // Instantiate DB & Connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate Order Object
    $order = new Orders($db);

    //Get Raw post data
    $data = json_decode(file_get_contents("php://input"));

    $order->item_id = $data->item_id;
    $order->customer_id = $data->customer_id;
    $order->transferRef = $data->transferRef;
    $order->amount = $data->amount;
    $order->order_status = $data->order_status;
    $order->paydate = $data->paydate;

    // create array
    $orderdetails_arr = array(
        'requestDate' => $order->paydate,
        'validateOnly' => false,
        'requestData' => array(
            'clientid' => $data->clientid,
            'clienthash' => $data->clienthash,
            'transectiontype' => $data->transectiontype,
            'transectionAmount' => array(
                'id' => $order->id,
                'item_id' => $order->item_id,
                'customer_id' => $order->customer_id,
                'transferRef' => $order->transferRef,
                'amount' => $order->amount,
                'order_status' => $order->order_status,
                'currency' => $data->currency,
            )
        )
    );

    //Create Order
    if($order->create()){
        echo json_encode(
            array("Message" => "Order Created Successfully!", "Response" => $orderdetails_arr)
        );
    }else{
        echo json_encode(
            array("Message" => "Order not Created")
        );
    }

?>