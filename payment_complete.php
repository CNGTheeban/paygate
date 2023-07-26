
<html>
    <head>
        <meta charset="UTF-8">
        <title>Payment Complete Response -demo</title>
        <link rel="stylesheet" href="css/bootstrap.css" media="screen">
        <link rel="stylesheet" href="css/bootswatch.min.css">
        <script src="js/jquery-1.10.2.min.js"></script>
    </head>
    <body>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client/GatewayClient.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.config/ClientConfig.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.component/RequestHeader.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.component/CreditCard.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.component/TransactionAmount.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.component/Redirect.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.facade/BaseFacade.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.facade/Payment.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.payment/PaymentInitRequest.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.payment/PaymentInitResponse.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.root/PaycorpRequest.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.utils/IJsonHelper.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.helpers/PaymentInitJsonHelper.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.utils/HmacUtils.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.utils/CommonUtils.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.utils/RestClient.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.enums/TransactionType.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.enums/Version.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.enums/Operation.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.facade/Vault.php"; ?>
        <?php include $_SERVER["DOCUMENT_ROOT"] . "paygate/includes/au.com.gateway.client.payment/PaymentCompleteRequest.php"; ?>

    <?php
        echo "Payment Complete Successfully!".'<br></br>';
      

    // error handler function
    function myErrorHandler($errno, $errstr, $errfile, $errline)
    {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting, so let it fall
            // through to the standard PHP error handler
            return false;
        }

        switch ($errno) {
        case E_USER_ERROR:
            echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
            echo "  Fatal error on line $errline in file $errfile";
            echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
            echo "Aborting...<br />\n";
            exit(1);
            break;

        case E_USER_WARNING:
            echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
            break;

        case E_USER_NOTICE:
            echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
            break;

        default:
            echo "Unknown error type: [$errno] $errstr<br />\n";
            break;
        }

        /* Don't execute PHP internal error handler */
        return true;
    }// end function
    try

    {
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
          STEP3: Build PaymentCompleteRequest object
          ------------------------------------------------------------------------------ */

        $completeRequest = new PaymentCompleteRequest();
        $completeRequest->setClientId(14005830);
        $completeRequest->setReqid($_GET['reqid']);

        $completeResponse = $client->getPayment()->complete($completeRequest);

        //echo "response code is " . $completeResponse->getResponseCode();
        //echo json_encode($jsonResponse);

} //try

catch(Exception $e){echo "Error :".$e->getMessage();}//catch

        ?>

            <script src="js/bootstrap.min.js"></script>
            <script src="js/bootswatch.js"></script>
        </div>
    </body>
</html>
