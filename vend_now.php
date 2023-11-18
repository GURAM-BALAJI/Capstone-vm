<?php
include 'includes/session.php';
include './includes/req_start.php';


if (isset($_SESSION['vm_user'])) {
    $id = $_SESSION['vm_id'];
    $conn = $pdo->open();
    $order_id = isset($_GET['order_id']) ? $_GET['order_id'] : null;
    if ($order_id !== null) {
        $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = :id AND orders_id = :order_id");
        $stmt->execute(['id' => $id, 'order_id' => $order_id]);
        // ...
    } else {
        // Handle the case where order_id is not provided
        $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = :id ORDER BY orders_id DESC LIMIT 1");
        $stmt->execute(['id' => $id]);
        $redirect = 0;
    }



    foreach ($stmt as $row) {
        $redirect = 1;
        date_default_timezone_set('Asia/Kolkata');
        $today = date('Y-m-d h:i:s');
        $remaining_time = (strtotime($row['orders_date']) + 900) - strtotime($today);

        $data = [
            implode(',', [
                'O:' . implode('/', explode(',', $row['orders_id'])),
                'I:' . implode('/', explode(',', $row['orders_spring_id'])),
                'Q:' . implode('/', explode(',', $row['orders_qty'])),
            ])
        ];

        $dataString = implode(', ', $data);
        $cipher = "aes-128-cbc";


        $encryption_key = isset($_COOKIE['theme']) ? "2345234523452345" : "1234123412341234";

        $iv = isset($_COOKIE['theme']) ? "2345234523452345" : "1234123412341234";

        //Data to encrypt
        $encrypted_data = openssl_encrypt($dataString, $cipher, $encryption_key, 0, $iv);

    }

    // Display the QR code with the data
    $qr_code_data = urlencode($encrypted_data);
    $qr_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=$qr_code_data&model=2";
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    </head>

    <body>
        <div class="container" style="margin-top: 5%;">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card mx-auto">
                        <center>
                            <style>
                                .aap {
                                    color: #581845;
                                    font-size: 30px;
                                    font-weight: bold;
                                }

                                .bharth> :last-child {
                                    transform: rotatex(180deg) translatey(15px);
                                    -webkit-mask-image: linear-gradient(transparent 40%, white 90%);
                                    mask-image: linear-gradient(transparent 50%, white 90%);
                                    opacity: 0.7;
                                }
                            </style>
                            <div class="bharth">
                                <p class="heading mb-0 text-center aap" style="color:">
                                    Scan the QR Code to Vend Now
                                </p>
                                <p class="heading mb-0 text-center aap" style="color:">
                                    Scan the QR Code to Vend Now
                                </p>
                            </div>
                        </center>
                        <form method="post" action="vended.php">
                            <input type="hidden" name="order_id" value="<?php echo $row['orders_id']; ?>">
                            <div class="form-group text-center">
                                <!-- QR code from QR Server API -->
                                <img class="img-fluid" src="<?php echo $qr_url; ?>" alt="QR Code">
                            </div>
                            <center>
                                <p class="text-success ">
                                    <b> <span style="color:red;">*</span> After scanning the QR Code, your order will be
                                        vended.</b>
                                </p>
                                <p class="text-success mb-0 text-center">
                                    <b> <span style="color:red;">*</span> In the event of non-vending, you will receive a
                                        refund within the next 4 days of the timeout.</b>
                                </p>
                            </center>
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