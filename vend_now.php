<?php
include 'includes/session.php';
include './includes/req_start.php';

// Function to encrypt data using AES-256-CBC
function encryptData($data, $secret_key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $secret_key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

if (isset($_SESSION['vm_user'])) {
    $id = $_SESSION['vm_id'];
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = :id LIMIT 1");
    $stmt->execute(['id' => $id]);
    $redirect = 0;

    // Replace 'your_secret_key' with your actual secret key
    $secret_key = '1234';

    foreach ($stmt as $row) {
        $redirect = 1;
        date_default_timezone_set('Asia/Kolkata');
        $today = date('Y-m-d h:i:s');
        $remaining_time = (strtotime($row['orders_date']) + 900) - strtotime($today);

        $data = [
            'orderid' => $row['orders_id'],
            'orderspring' => $row['orders_spring_id'],
            'orders_qty' => $row['orders_qty'],
            'orders_date' => $row['orders_date']
        ];
        
        $jsonData = json_encode($data);
       
        $qr_data = encryptData($jsonData, $secret_key);

    }

    // Rest of your code...
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
                                <!-- Adjust the chs parameter to increase QR code size (e.g., chs=300x300) -->
                                <img class="img-fluid" src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo urlencode($qr_data); ?>" alt="QR Code">
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
        header('location: MyCart');
        exit();
    }
} else {
    header('location: MyCart');
}
include './includes/req_end.php';
?>
