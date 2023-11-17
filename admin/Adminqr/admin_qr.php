<?php include '../includes/session.php'; ?>
<?php include '../includes/header.php'; ?>
<?php if ($admin['admin_view']) {


    ?>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php include '../includes/navbar.php'; ?>
            <?php include '../includes/menubar.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        QR Code
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i> Home</li>
                        <li>Mannage</li>
                        <li class="active">QR Code</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
                        unset($_SESSION['success']);
                    }
                    ?>
                    <div class="panel panel-default" style="overflow-x:auto;">
                        <div class="row">
                            <div class="col-xs-12">

                                <div class="box">
                                    <form action="QrUpdate.php" method="post">
                                        <div class="form-group">
                                            <div class="col-sm-8">
                                                <?php
                                                $QrData = "";
                                                $stmt = $conn->prepare("SELECT * FROM adminqrcode");
                                                $stmt->execute();
                                                foreach ($stmt as $row) {
                                                    $QrData = $row['qr_code'];
                                                } ?>
                                                <input type="text" class="form-control" name="QrData"
                                                    value="<?php echo $QrData; ?>">

                                            </div>
                                            <div class="col-sm-4">
                                                <input class="form-control-static" name="QRSubmit" type="submit"
                                                    value="Submit">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="box-body">
                                        <?php
                                        $cipher = "aes-128-cbc";

                                        //Generate a 256-bit encryption key
                                        $encryption_key = "1234123412341234";

                                        $iv = "1234123412341234";

                                        //Data to encrypt
                                        $encrypted_data = openssl_encrypt($QrData, $cipher, $encryption_key, 0, $iv);

                                        ?>

                                        <div class="form-group text-center">
                                            <!-- Adjust the chs parameter to increase QR code size (e.g., chs=300x300) -->
                                            <img class="img-fluid"
                                                src="https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl=<?php echo urlencode($encrypted_data); ?>"
                                                alt="QR Code">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

        </div>
        <!-- ./wrapper -->

        <?php include '../includes/scripts.php'; ?>
    </body>
<?php } ?>

</html>