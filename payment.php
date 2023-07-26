<?php include 'includes/au.com.gateway.client/GatewayClient.php'; ?>
<?php include 'includes/au.com.gateway.client.config/ClientConfig.php'; ?>
<?php include 'includes/au.com.gateway.client.component/RequestHeader.php'; ?>
<?php include 'includes/au.com.gateway.client.component/CreditCard.php'; ?>
<?php include 'includes/au.com.gateway.client.component/TransactionAmount.php'; ?>
<?php include 'includes/au.com.gateway.client.component/Redirect.php'; ?>
<?php include 'includes/au.com.gateway.client.facade/BaseFacade.php'; ?>
<?php include 'includes/au.com.gateway.client.facade/Payment.php';?>
<?php include 'includes/au.com.gateway.client.payment/PaymentInitRequest.php';?>
<?php include 'includes/au.com.gateway.client.payment/PaymentInitResponse.php';?>
<?php include 'includes/au.com.gateway.client.root/PaycorpRequest.php';?>
<?php include 'includes/au.com.gateway.client.utils/IJsonHelper.php';?>
<?php include 'includes/au.com.gateway.client.helpers/PaymentInitJsonHelper.php';?>
<?php include 'includes/au.com.gateway.client.utils/HmacUtils.php'; ?>
<?php include 'includes/au.com.gateway.client.utils/CommonUtils.php'; ?>
<?php include 'includes/au.com.gateway.client.utils/RestClient.php'; ?>
<?php include 'includes/au.com.gateway.client.enums/TransactionType.php';?>
<?php include 'includes/au.com.gateway.client.enums/Version.php';?>
<?php include 'includes/au.com.gateway.client.enums/Operation.php';?>
<?php include 'includes/au.com.gateway.client.facade/Vault.php'; ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Payment Gatway</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <div class="container pt-5">
            <a href="index.php" class="btn btn-success" name="customerregistration" id="customerregistration">Customer Registration</a>
            <a href="payment.php" class="btn btn-success" name="payment" id="payment">Payment</a>
            <h1 class="pt-5">Payment Gateway Testing</h1>
            <!-- <form method="POST" id="payment_form" action="api/payments.php"> -->
            <form method="POST" id="payment_form">
                <div class="row pt-5">
                    <div class="col">
                        <input type="text" class="form-control" name="clientid" id="clientid" placeholder="Client ID" value="14005830" readonly/>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" name="clienthash" id="clienthash" placeholder="Client Hash" value="gsHJAsDdS4C2AQ4i" readonly/>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" name="authtoken" id="authtoken" placeholder="Auth Token" value="b1a7c130-68ff-433e-bb3c-b1810067db22" readonly/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="transectiontype" id="transectiontype" placeholder="Transection Type" value="PURCHASE" readonly/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="currency" id="currency" placeholder="Currency" value="LKR" readonly/>
                    </div>
                </div>
                <div class="row pt-5">
                    <div class="col">
                        <input type="text" class="form-control" name="customername" id="customername" placeholder="Customer Name"/>
                    </div>
                    <div class="col">
                        <input type="email" class="form-control" name="customeremail" id="customeremail" placeholder="Customer Email"/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="item" id="item" placeholder="Item Name"/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="itemprice" id="itemprice" placeholder="Item Amount"/>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="transferRef" id="transferRef" placeholder="Transfer Reference"/>
                    </div>
                </div>
                <div class="row pt-5">
                    <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Submit"/>
                </div>
            </form>
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "paygate"; 

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                if (isset($_POST['submit'])) {
                    $clientid = $_POST['clientid'];
                    $clienthash = $_POST['clienthash'];
                    $transectiontype = $_POST['transectiontype'];
                    $currency = $_POST['currency'];
                    $item_id = $_POST['item'];
                    $customer_name = $_POST['customername'];
                    $customer_email = $_POST['customeremail'];
                    $transferRef = $_POST['transferRef'];
                    $amount = $_POST['itemprice'];
                    $order_status = '1';
                    $paydate = date('Y-m-d H:i:s');;

                    $sql = "INSERT INTO `orders`(`item_id`, `customer_name`, `customer_email`, `transferRef`, `amount`, `order_status`, `paydate`) 
                            VALUES ('$item_id','$customer_name','$customer_email','$transferRef','$amount','$order_status','$paydate')";
                    $result = $conn->query($sql);

                    if ($result == TRUE) {
                        //echo "New record created successfully.";
                        try{
                            date_default_timezone_set('Asia/Colombo');
                            $validateOnly = "FALSE";
                            $clientId = $clientid;
                            $transactionType = $transectiontype;
                            $tokenize ="TRUE";
                            $tokenReference ="";
                            $clientRef = "Theeban test";
                            $comment = "";
                            $msisdn = "";
                            $sessionId = "";
                            $item_id = $item_id;
                            $customer_name = $customer_name;
                            $customer_email = $customer_email;
                            $totalAmount = 200;
                            $serviceFeeAmount = 0;
                            $paymentAmount = $amount;
                            $currency = "LKR";
                            $returnUrl ="http://localhost/paygate/payment_complete.php";
                            $returnMethod ="GET";
                            date_default_timezone_set('Asia/Colombo');

                            /* ------------------------------------------------------------------------------
                              STEP1: Build PaycorpClientConfig object
                              ------------------------------------------------------------------------------ */
                            $clientConfig = new ClientConfig();
                            $clientConfig->setServiceEndpoint("https://sampath.paycorp.lk/rest/service/proxy");
                            $clientConfig->setAuthToken("b1a7c130-68ff-433e-bb3c-b1810067db22");
                            $clientConfig->setHmacSecret("gsHJAsDdS4C2AQ4i");
                            $clientConfig->setValidateOnly(FALSE);
                
                            /* ------------------------------------------------------------------------------
                              STEP2: Build PaycorpClient object
                              ------------------------------------------------------------------------------ */
                            $client = new GatewayClient($clientConfig);
                
                            /* ------------------------------------------------------------------------------
                              ------------------------------------------------------------------------------ */
                            $initRequest = new PaymentInitRequest();
                
                            $initRequest->setClientId($clientId);
                            $initRequest->setTransactionType(TransactionType::$PURCHASE);
                            $initRequest->setClientRef($clientRef);
                            $initRequest->setComment($comment);
                            $initRequest->setTokenize(false);
                            $initRequest->setExtraData(array("msisdn" => "$msisdn", "sessionId" => "$sessionId", "item_id" => "$item_id", "customer_name" => "$customer_name", "customer_email" => "$customer_email"));
                
                            // sets transaction-amounts details (all amounts are in cents)
                            $transactionAmount = new TransactionAmount($totalAmount);
                            $transactionAmount->setTotalAmount($totalAmount);
                            $transactionAmount->setServiceFeeAmount($serviceFeeAmount);
                            $transactionAmount->setPaymentAmount($paymentAmount*100);
                            $transactionAmount->setCurrency($currency);
                            $initRequest->setTransactionAmount($transactionAmount);
                            // sets redirect settings
                
                            $redirect = new Redirect($returnUrl);
                            // $redirect->setReturnUrl($returnUrl);
                            $redirect->setReturnMethod($returnMethod);
                            $initRequest->setRedirect($redirect);
                            /* ------------------------------------------------------------------------------
                              STEP4: Process PaymentInitRequest object
                              ------------------------------------------------------------------------------ */
                            // echo "Before sending payment init";
                            $initResponse = $client->getPayment()->init($initRequest);
                            // echo "After sending payment init";
                            // $reURL = $initResponse->getPaymentPageUrl();
                            // header('Location: '.$reURL);
                            // header("Location:https://www.google.com/");
                            // echo '
                            //     <div style="float:left">
                            //         <br><br><br><br>
                            //         <iframe class="col-lg-12" height="600px" width="600px" src="'.$initResponse->getPaymentPageUrl().'" ></iframe>
                            //     </div>
                            // ';
                        }
                        catch(Exception $e){echo "Error :".$e->getMessage();}//catch

                        header('Location: ' . $initResponse->getPaymentPageUrl());
                    }else{
                        echo "Error:". $sql . "<br>". $conn->error;
                    }
                    $conn->close(); 
                }
            ?> 
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <!-- <script>
            // Helper function to add a leading zero if the number is less than 10
            function addLeadingZero(number) {
                return number < 10 ? "0" + number : number;
            }

            $("#payment_form").on("submit", function(e){
                e.preventDefault();
                // Get the current date and time
                var currentDateTime = new Date();

                // Format the date and time to desired format (e.g., yyyy-mm-dd HH:mm:ss)
                var formattedDateTime = currentDateTime.getFullYear() + "-" +
                        addLeadingZero(currentDateTime.getMonth() + 1) + "-" +
                        addLeadingZero(currentDateTime.getDate()) + " " +
                        addLeadingZero(currentDateTime.getHours()) + ":" +
                        addLeadingZero(currentDateTime.getMinutes()) + ":" +
                        addLeadingZero(currentDateTime.getSeconds());

                // Get form data
                var formData = {
                    clientid: $('input[name=clientid]').val(),
                    clienthash: $('input[name=clienthash]').val(),
                    authtoken: $('input[name=authtoken]').val(),
                    transectiontype: $('input[name=transectiontype]').val(),
                    currency: $('input[name=currency]').val(),
                    item_id: $('input[name=item]').val(),
                    customer_id: $('#customerid').val(),
                    transferRef: $('input[name=transferRef]').val(),
                    amount: $('input[name=itemprice]').val(),
                    order_status: "1",
                    paydate: formattedDateTime
                };
                // var formData = $("#payment_form").serialize();
                // console.log(formData);
                // console.log(JSON.stringify(formData));
                // console.log(currentDateTime);
                // console.log(formattedDateTime);
                $.ajax({
                    type: "POST",
                    url: "api/orders/create.php",
                    data: JSON.stringify(formData),
                    success: function (response) {
                        //alert("Success!");                    
                        console.log(response);
                        $("#item").val('');
                        $("#itemprice").val('');
                        $("#transferRef").val('');
                        $("#customerid").val('');
                        //alert(response);
                        //location.reload();
                    },                
                    error: function(xhr, status, error) {
                        console.error('Error saving:', xhr.responseText);
                        console.error('xhr', xhr);
                        console.error('status', status);
                        console.error('error', error);
                        //console.log(frm_data);  
                    }
                });
            });
    </script> -->
    </body>
</html>