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

    // Customer Query
    $result = $customer->read();

    // Get Row count
    $num = $result->rowCount();

    //Check if any Customers
    if($num > 0){
        // Customer Array
        $customer_arr = array();
        $customer_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $customer_item = array(
                'id' => $id,
                'customer_name' => $customer_name,
                'customer_email' => $customer_email,
                'customer_contactno' => $customer_contactno,
                'customer_status' => $customer_status
            );

            // Push to "Data"
            array_push($customer_arr['data'], $customer_item);
        }

        // Turn to JSON & Output
        echo json_encode($customer_arr);
    }else{
        // No Customer
        echo json_encode(
            array("Message" => "Customers not found")
        );
    }
?>