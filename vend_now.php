<?php
include 'includes/session.php';
include './includes/req_start.php';


if (isset($_SESSION['vm_user'])) {
    $id = $_SESSION['vm_id'];
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $redirect = 0;


    foreach ($stmt as $row) {
        $redirect = 1;
        date_default_timezone_set('Asia/Kolkata');
        $today = date('Y-m-d h:i:s');
        $remaining_time = (strtotime($row['orders_date']) + 900) - strtotime($today);

        $data = [
            'i' => $row['orders_id'],
            's' => $row['orders_spring_id'],
            'q' => $row['orders_qty'],
            'd' => $row['orders_date'],
            't' => $remaining_time, // Add the remaining time to the QR code data
        ];
        
        $jsonData = json_encode($data);
       
        $cipher = "aes-128-cbc";

        //Generate a 256-bit encryption key
        $encryption_key = "1234123412341234";
        
        $iv = "1234123412341234";
        
        //Data to encrypt
        $encrypted_data = openssl_encrypt($jsonData, $cipher, $encryption_key, 0, $iv);

    }
    
    // Display the QR code with the data
    $qr_code_data = urlencode($qr_data);
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=$qr_code_data&model=2";
    ?>
    <!DOCTYPE html>
    <html>
    <head>  
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
        <style>
            /* Your custom CSS styles here */
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card mx-auto">
                    <p class="heading mb-0 text-center"><b><h3>Scan the QR Code to Vend Now..</h3></b></p>
                        <form method="post" action="vended.php">
                            <input type="hidden" name="order_id" value="<?php echo $row['orders_id']; ?>">
                            <div class="form-group text-center">
                                <!-- QR code from QR Server API -->
                                <img class="img-fluid" src="<?php echo $qr_url; ?>" alt="QR Code">
                            </div>
                            <p class="text-warning ">
                                <span style="color:red;">*</span> After scanning the QR Code, your order will be vended.
                            </p>
                            <p class="text-warning mb-0 text-center">
                                <span style="color:red;">*</span> In the event of non-vending, you will receive a refund within the next 4 days of the timeout.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript and jQuery libraries -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
    <?php

    if ($redirect == 0) {
        error_log("No redirect");
        header('location: MyCart');
        exit();
    }
} else {
    error_log("Session error");
    header('location: MyCart');
}
include './includes/req_end.php';
?>
