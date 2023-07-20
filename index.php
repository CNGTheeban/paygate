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
            <h1 class="pt-5">Customer Registration</h1>
            <form method="post" id="customer_register">
                <div class="row pt-5">
                    <div class="col">
                        <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Customer Name"/>
                    </div>
                    <div class="col">
                        <input type="email" class="form-control" name="customer_email" id="customer_email" placeholder="Customer Email" />
                    </div>
                    <div class="col">
                        <input type="tel" class="form-control" name="customer_contactno" id="customer_contactno" placeholder="Customer Contact No" />
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

            $("#customer_register").on("submit", function(e){
                e.preventDefault();

                // Get form data
                var formData = {
                    customer_name: $('input[name=customer_name]').val(),
                    customer_email: $('input[name=customer_email]').val(),
                    customer_contactno: $('input[name=customer_contactno]').val(),
                    customer_status: "1"
                };
                // var formData = $("#payment_form").serialize();
                // console.log(formData);
                // console.log(JSON.stringify(formData));
                // console.log(currentDateTime);
                // console.log(formattedDateTime);
                $.ajax({
                    type: "POST",
                    url: "api/customers/create.php",
                    data: JSON.stringify(formData),
                    success: function (response) {
                        //alert("Success!");                    
                        console.log(response);
                        $("#customer_name").val('');
                        $("#customer_email").val('');
                        $("#customer_contactno").val('');
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