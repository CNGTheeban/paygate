<?php

    // Headers
    header('Access-Control-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../Config/Database.php';
    include_once '../../Models/Customers.php';

    // Instantiate DB & Connection
    $database = new Database();
    $db = $database->connect();

    // Instantiate Customer Object
    $customer = new Customers($db);

    //Get Raw post data
    $data = json_decode(file_get_contents("php://input"));

    $customer->customer_id = $data->customer_name;
    $customer->customer_email = $data->customer_email;
    $customer->customer_contactno = $data->customer_contactno;
    $customer->customer_status = $data->customer_status;

    //Create Customer
    if($customer->create()){
        echo json_encode(
            array("Message" => "Customer Created Successfully!")
        );
    }else{
        echo json_encode(
            array("Message" => "Customer not Created")
        );
    }

?>