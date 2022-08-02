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
        $remaing_time = (strtotime($row['orders_date']) + 900) - strtotime($today);
        if (intval($remaing_time) <= 0) {
            if ($req_per == 1) {
                $orders_cost = explode(',', $row['orders_cost']);
                $update_qty = explode(',', $row['orders_qty']);
                $update_items = explode(',', $row['orders_items']);
                $cost = $i = 0;
                foreach ($update_items as $dis_id) {
                    if (!empty($dis_id)) {
                        $cost += $orders_cost[$i] * $update_qty[$i];
                        $stmt_display = $conn->prepare("SELECT * FROM display_items WHERE display_id=:dis_id");
                        $stmt_display->execute(['dis_id' => $dis_id]);
                        foreach ($stmt_display as $row_display)
                            $rem_qty = $row_display['display_items_qty'] + $update_qty[$i];
                        $stmt_display_update = $conn->prepare("UPDATE display_items SET display_items_qty=:rem_qty WHERE display_id=:dis_id");
                        $stmt_display_update->execute(['rem_qty'=>$rem_qty,'dis_id' => $dis_id]);
                    }
                    $i++;
                }
                $stmt_user = $conn->prepare("SELECT * FROM users WHERE user_id=:id");
                $stmt_user->execute(['id' => $id]);
                foreach ($stmt_user as $row_user) {
                    $balance = $row_user['user_amount'] + $cost;
                    $stmt_user_update = $conn->prepare("UPDATE users SET user_amount=:balance WHERE user_id=:id");
                    $stmt_user_update->execute(['balance' => $balance,'id' => $id]);
                }
                $stmt = $conn->prepare("INSERT INTO transaction (transaction_user_id,transaction_send_to,transaction_amount,transaction_added_by,transaction_type,transaction_date) VALUES (:transaction_user_id,:transaction_send_to,:transaction_amount,:transaction_added_by,:transaction_type,:transaction_date)");
                $stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => 'Refunded', 'transaction_amount' => $cost,  'transaction_added_by' => $id, 'transaction_type' => 3, 'transaction_date' => $today]);
                $stmt_user_update = $conn->prepare("UPDATE orders SET orders_delivered=:orders_delivered WHERE orders_user_id = :id AND orders_id=:orders_id");
                $stmt_user_update->execute(['orders_delivered' => 3,'id' => $id, 'orders_id' => $row['orders_id']]);
                $stmt = $conn->prepare("DELETE FROM orders WHERE orders_id=:id AND orders_user_id=:user_id");
                $stmt->execute(['id' => $row['orders_id'], 'user_id' => $id]);
                header('location:cart.php');
                exit();
            }
        }
?>
        <!DOCTYPE html>
        <html>

        <head>

            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');


                body {
                    background: linear-gradient(to right, rgba(235, 224, 232, 1) 52%, rgba(254, 191, 1, 1) 53%, rgba(254, 191, 1, 1) 100%);
                    font-family: 'Roboto', sans-serif;
                }

                /* The Modal (background) */
                .modal {
                    display: none;
                    /* Hidden by default */
                    position: fixed;
                    /* Stay in place */
                    z-index: 1;
                    /* Sit on top */
                    padding-top: 100px;
                    /* Location of the box */
                    left: 0;
                    top: 0;
                    width: 100%;
                    /* Full width */
                    height: 100%;
                    /* Full height */
                    overflow: auto;
                    /* Enable scroll if needed */
                    background-color: rgb(0, 0, 0);
                    /* Fallback color */
                    background-color: rgba(0, 0, 0, 0.4);
                    /* Black w/ opacity */
                }

                /* Modal Content */
                .modal-content {
                    background-color: #fefefe;
                    margin: auto;
                    padding: 20px;
                    border: 1px solid #888;
                    width: 80%;
                }

                /* The Close Button */
                .close {
                    color: #aaaaaa;
                    float: right;
                    font-size: 28px;
                    font-weight: bold;
                }

                .close:hover,
                .close:focus {
                    color: #000;
                    text-decoration: none;
                    cursor: pointer;
                }

                .card {
                    border: none;
                    max-width: 450px;
                    border-radius: 15px;
                    margin: 100px 0 auto;
                    padding: 35px;
                    padding-bottom: 20px !important;
                }

                .heading {
                    color: #322F2F;
                    font-size: 20px;
                    font-weight: bold;
                }



                img:hover {
                    cursor: pointer;
                }

                .text-warning {
                    font-size: 12px;
                    font-weight: 500;
                    color: #edb537 !important;
                    text-transform: capitalize;
                }

                #cno {
                    transform: translateY(-10px);
                }

                input {
                    border-bottom: 1.5px solid #E8E5D2 !important;
                    font-weight: bold;
                    border-radius: 0;
                    border: 0;

                }

                .form-group input:focus {
                    border: 0;
                    outline: 0;
                }

                .col-sm-5 {
                    padding-left: 40%;
                }

                .btn {
                    background: #F3A002 !important;
                    border: none;
                    border-radius: 30px;
                }

                .btn:focus {
                    box-shadow: none;
                }

                .but {
                    border-radius: 10px;
                    font-size: small;
                }

                .but:hover {
                    background-color: #F7D178;

                }

                input::-webkit-outer-spin-button,
                input::-webkit-inner-spin-button {
                    -webkit-appearance: none;
                    margin: 0;
                }

                /* Firefox */
                input[type=number] {
                    -moz-appearance: textfield;
                }

                .rupee-img {
                    position: relative;
                    left: 17px;
                    top: 2px;
                    height: 14px;
                    width: 10px;
                    display: inline-block;
                }

                .base-timer {
                    margin: 40px;
                    position: relative;
                    width: 150px;
                    height: 150px;
                }

                .base-timer__svg {
                    transform: scaleX(-1);
                }

                .base-timer__circle {
                    fill: none;
                    stroke: none;
                }

                .base-timer__path-elapsed {
                    stroke-width: 7px;
                    stroke: grey;
                }

                .base-timer__path-remaining {
                    stroke-width: 7px;
                    stroke-linecap: round;
                    transform: rotate(90deg);
                    transform-origin: center;
                    transition: 1s linear all;
                    fill-rule: nonzero;
                    stroke: currentColor;
                }

                .base-timer__path-remaining.green {
                    color: rgb(65, 184, 131);
                }

                .base-timer__path-remaining.orange {
                    color: orange;
                }

                .base-timer__path-remaining.red {
                    color: red;
                }

                .base-timer__label {
                    position: absolute;
                    width: 150px;
                    height: 150px;
                    top: 0;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 25px;
                }
            </style>
        </head>

        <body>
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
            <form method="post" action="vended.php">
                <input type="hidden" name="order_id" value="<?php echo $row['orders_id']; ?>">
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-12">
                            <div class="card mx-auto">
                                <p class="heading">Click To Vend Now.. </p>
                                <div class="form-group mb-3">
                                    <p class="text-warning mb-0 col-sm-12">
                                        <spam style="color:red;">*</spam> After Clicking On Vend Now Button Your Order Will Be Vended.
                                    </p>
                                    <p class="text-warning mb-0 col-sm-12">
                                        <spam style="color:red;">*</spam> To cancel order click me.
                                    </p>
                                    <p class="text-warning mb-0 col-sm-12">
                                        <spam style="color:red;">*</spam> In case of Not Vend, You will get refunded within 5 minutes of Time out.
                                    </p>
                                    <p class="text-warning mb-0 col-sm-12">
                                        <spam style="color:red;">*</spam> To cancel order <b id="myBtn" style="color:red;text-decoration:none;"> Click me.</b>
                                    </p>
                                    <center>
                                        <div id="app"></div>
                                    </center>
                                </div>
                                <input type="submit" class="btn btn-primary" id="vend_now" value="VEND NOW">

                            </div>
                        </div>
                    </div>
                </div>
                </div>

            </form>
            <div id="myModal" class="modal">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="./cancel_order.php">
                                <center>
                                    <h1 style="color: #d24026;text-transform:capitalize;">Are you sure, You want to cancel Order.</h1>
                                </center>
                                <div class="modal-footer">
                                     <?php if (!isset($_SESSION['vm_id'])) { ?>
                                        <a href="login.php">
                                            <button style=" background-color: #d24026; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                                                LOGIN</button>
                                        </a><?php } else { ?>
                                        <button type="submit" style="background-color:red;border: none;border-radius: 10px;font-size:20px;padding:15px;" name="cancel"><i class="fa fa-lightbulb-o"></i> YES</button>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                </div>
            </div>

        </body>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script>
            // Credit: Mateusz Rybczonec

            const FULL_DASH_ARRAY = 283;
            const WARNING_THRESHOLD = 60;
            const ALERT_THRESHOLD = 10;

            const COLOR_CODES = {
                info: {
                    color: "green"
                },
                warning: {
                    color: "orange",
                    threshold: WARNING_THRESHOLD
                },
                alert: {
                    color: "red",
                    threshold: ALERT_THRESHOLD
                }
            };

            const TIME_LIMIT = 900;
            let timePassed = 900 - parseInt("<?php echo $remaing_time; ?>");
            let timeLeft = TIME_LIMIT;
            let timerInterval = null;
            let remainingPathColor = COLOR_CODES.info.color;

            document.getElementById("app").innerHTML = `
<div class="base-timer">
  <svg class="base-timer__svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <g class="base-timer__circle">
      <circle class="base-timer__path-elapsed" cx="50" cy="50" r="45"></circle>
      <path
        id="base-timer-path-remaining"
        stroke-dasharray="283"
        class="base-timer__path-remaining ${remainingPathColor}"
        d="
          M 50, 50
          m -45, 0
          a 45,45 0 1,0 90,0
          a 45,45 0 1,0 -90,0
        "
      ></path>
    </g>
  </svg>
  <span id="base-timer-label" class="base-timer__label">${formatTime(
    timeLeft
  )}</span>
</div>
`;

            startTimer();

            function onTimesUp() {
                clearInterval(timerInterval);
                location.reload();
            }

            function startTimer() {
                timerInterval = setInterval(() => {
                    timePassed = timePassed += 1;
                    timeLeft = TIME_LIMIT - timePassed;
                    document.getElementById("base-timer-label").innerHTML = formatTime(
                        timeLeft
                    );
                    setCircleDasharray();
                    setRemainingPathColor(timeLeft);

                    if (timeLeft === 0) {
                        onTimesUp();
                    }
                }, 1000);
            }

            function formatTime(time) {
                const minutes = Math.floor(time / 60);
                let seconds = time % 60;

                if (seconds < 10) {
                    seconds = `0${seconds}`;
                }

                return `${minutes}:${seconds}`;
            }

            function setRemainingPathColor(timeLeft) {
                const {
                    alert,
                    warning,
                    info
                } = COLOR_CODES;
                if (timeLeft <= alert.threshold) {
                    document
                        .getElementById("base-timer-path-remaining")
                        .classList.remove(warning.color);
                    document
                        .getElementById("base-timer-path-remaining")
                        .classList.add(alert.color);
                } else if (timeLeft <= warning.threshold) {
                    document
                        .getElementById("base-timer-path-remaining")
                        .classList.remove(info.color);
                    document
                        .getElementById("base-timer-path-remaining")
                        .classList.add(warning.color);
                }
            }

            function calculateTimeFraction() {
                const rawTimeFraction = timeLeft / TIME_LIMIT;
                return rawTimeFraction - (1 / TIME_LIMIT) * (1 - rawTimeFraction);
            }

            function setCircleDasharray() {
                const circleDasharray = `${(
    calculateTimeFraction() * FULL_DASH_ARRAY
  ).toFixed(0)} 283`;
                document
                    .getElementById("base-timer-path-remaining")
                    .setAttribute("stroke-dasharray", circleDasharray);
            }
            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the button that opens the modal
            var btn = document.getElementById("myBtn");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal 
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>

        </html>
        <?php include './includes/req_end.php'; ?>
<?php    }
    if ($redirect == 0) {
        header('location:cart.php');
        exit();
    }
} else {
    header('location:cart.php');
}
?>