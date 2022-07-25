<?php
include 'includes/session.php';
if (isset($_SESSION["vm_id"])) {
	$CUST_ID = $_SESSION["vm_id"];
?>
	<html>

	<head>
		<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<style>
			body {
				font-family: 'Varela Round', sans-serif;
			}

			.modal-confirm {
				color: #636363;
				width: 325px;
				margin: 30px auto;
			}

			.modal-confirm .modal-content {
				padding: 20px;
				border-radius: 5px;
				border: none;
			}

			.modal-confirm .modal-header {
				border-bottom: none;
				position: relative;
			}

			.modal-confirm h4 {
				text-align: center;
				font-size: 26px;
				margin: 30px 0 -15px;
			}

			.modal-confirm .form-control,
			.modal-confirm .btn {
				min-height: 40px;
				border-radius: 3px;
			}

			.modal-confirm .close {
				position: absolute;
				top: -5px;
				right: -5px;
			}

			.modal-confirm .modal-footer {
				border: none;
				text-align: center;
				border-radius: 5px;
				font-size: 13px;
			}

			.modal-confirm .icon-box {
				color: #fff;
				position: absolute;
				margin: 0 auto;
				left: 0;
				right: 0;
				top: -70px;
				width: 95px;
				height: 95px;
				border-radius: 50%;
				z-index: 9;
				background: #82ce34;
				padding: 15px;
				text-align: center;
				box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
			}

			.modal-confirm .icon-box i {
				font-size: 58px;
				position: relative;
				top: 3px;
			}

			.modal-confirm.modal-dialog {
				margin-top: 80px;
			}

			.modal-confirm .btn {
				color: #fff;
				border-radius: 4px;
				background: #82ce34;
				text-decoration: none;
				transition: all 0.4s;
				line-height: normal;
				border: none;
			}

			.modal-confirm .btn:hover,
			.modal-confirm .btn:focus {
				background: #6fb32b;
				outline: none;
			}
		</style>

	</head>

	<body>
		<?php

		header("Pragma: no-cache");
		header("Cache-Control: no-cache");
		header("Expires: 0");

		// following files need to be included
		require_once("./lib/config_paytm.php");
		require_once("./lib/encdec_paytm.php");


		$paytmChecksum = "";
		$paramList = array();
		$isValidChecksum = "FALSE";

		$paramList = $_POST;
		$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

		//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
		$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


		if ($isValidChecksum == "TRUE") {

			if ($_POST["STATUS"] == "TXN_SUCCESS") {

				//Process your transaction here as success transaction.
				//Verify amount & order id received from Payment gateway with your application's order id and amount.
				
				$ORDERID = $_POST['ORDERID'];
				$TXNAMOUNT = $_POST['TXNAMOUNT'];
				$date = $_POST['TXNDATE'];
				$mode = $_POST['PAYMENTMODE'];
				$status = $_POST['STATUS'];
				$gatewayname = 5;
				$conn = $pdo->open();
				$query = "INSERT INTO `transaction` (`transaction_added_by`,`transaction_id`, `transaction_user_id`,`transaction_amount`,`transaction_date`, transaction_type, transaction_method, transaction_status) VALUES (:transaction_added_by,:transaction_id, :transaction_user_id, :transaction_amount, :date  ,:type ,:mode1 ,:status1 )";
				$stmt = $conn->prepare("$query");
				$stmt->execute(['transaction_added_by' => $CUST_ID, 'transaction_id' => $ORDERID, 'transaction_user_id' => $CUST_ID, 'transaction_amount' => $TXNAMOUNT, 'date' => $date, 'type' => $gatewayname, 'mode1' => $mode, 'status1' => $status]);
				$stmt = $conn->prepare("SELECT user_amount FROM users WHERE user_id=:id");
				$stmt->execute(['id' => $CUST_ID]);
				$user = $stmt->fetch();
				$total_amount = $user['user_amount'] + $TXNAMOUNT;
				$stmt = $conn->prepare("UPDATE users SET user_amount=:user_amount WHERE user_id=:id");
				$stmt->execute(['user_amount' => $total_amount, 'id' => $CUST_ID]);
				$pdo->close();
		?>

				<div class="modal-dialog modal-confirm">
					<div class="modal-content">
						<div class="modal-header">
							<div class="icon-box">
								<i class="material-icons">&#xE876;</i>
							</div>
							<h4 class="modal-title">Awesome!</h4>
						</div>
						<div class="modal-body">
							<p class="text-center">Your Reacharge is Added to Wallet.</p>
						</div>
						<div class="modal-footer">
							<a href="./account.php"><button class="btn btn-success btn-block" data-dismiss="modal">Continue</button></a>
						</div>
					</div>
				</div>

	<?php
			} else {
				echo  "transaction faiure";
			}
		} else {
			echo "<b>Checksum mismatched.</b>";
			//Process transaction as suspicious.
		}
		$_SESSION["vm_id"] = $CUST_ID;
	}
	?>
	</body>

	</html>