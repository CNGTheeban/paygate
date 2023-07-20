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

    // Order Query
    $result = $order->read();

    // Get Row count
    $num = $result->rowCount();

    //Check if any orders
    if($num > 0){
        // Order Array
        $order_arr = array();
        $order_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $order_item = array(
                'id' => $id,
                'item_id' => $item_id,
                'customer_id' => $customer_id,
                'transferRef' => $transferRef,
                'amount' => $amount,
                'order_status' => $order_status,
                'paydate' => $paydate
            );

            // Push to "Data"
            array_push($order_arr['data'], $order_item);
        }

        // Turn to JSON & Output
        echo json_encode($order_arr);
    }else{
        // No Order
        echo json_encode(
            array("Message" => "Orders not found")
        );
    }
?>