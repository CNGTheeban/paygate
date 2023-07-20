<?php
    include("Config/Database.php");
    // Instantiate DB & Connection
    $database = new Database();
    $db = $database->connect();
?>
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
            <form method="POST" id="payment_form" action="api/payments.php">
                <div class="row pt-5">
                    <div class="col">
                        <input type="text" class="form-control" name="clientid" id="clientid" placeholder="Client ID" value="14000396" readonly/>
                    </div>
                    <div class="col">
                        <input type="password" class="form-control" name="clienthash" id="clienthash" placeholder="Client Hash" value="14000396" readonly/>
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
                        <select class="form-select" name="customerid" id="customerid">
                            <option selected>Please select the Customer</option>
                            <?php
                                $stmt = $db->prepare("SELECT * FROM customers");
                                $stmt->execute();
                                $customers = $stmt->fetchAll();
                                foreach($customers as $customer){
                                    //echo json_encode($customer);
                                    $name = $customer['customer_name'];
                                    $id = $customer['id'];
                                    echo "<option value='$id'>$name</option>";
                                }
                            ?>
                        </select>
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
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script>
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
    </script>
    </body>
</html>