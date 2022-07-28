<?php
include 'includes/session.php';

?>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="UTF-8">
	<link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style>
		body {
			background: linear-gradient(to right, rgba(235, 224, 232, 1) 52%, rgba(254, 191, 1, 1) 53%, rgba(254, 191, 1, 1) 100%);
			font-family: 'Roboto', sans-serif;
			padding-top: 100px;
			text-align: center;
		}

		.wrapper {
			-webkit-animation: wrapperAni 230ms ease-in 200ms forwards;
			animation: wrapperAni 230ms ease-in 200ms forwards;
			background: white;
			border: 1px solid rgba(0, 0, 0, 0.15);
			border-radius: 4px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			display: inline-block;
			height: 400px;
			margin: 0 20px;
			opacity: 0;
			position: relative;
			vertical-align: top;
			width: 300px;
		}

		.header__wrapper {
			height: 200px;
			overflow: hidden;
			position: relative;
			width: 100%;
		}

		.header {
			-webkit-animation: headerAni 230ms ease-in 430ms forwards;
			animation: headerAni 230ms ease-in 430ms forwards;
			border-radius: 0;
			height: 700px;
			left: -200px;
			opacity: 0;
			position: absolute;
			top: -500px;
			width: 700px;
		}

		.header .sign {
			-webkit-animation: signAni 430ms ease-in 660ms forwards;
			animation: signAni 430ms ease-in 660ms forwards;
			border-radius: 50%;
			bottom: 50px;
			display: block;
			height: 100px;
			left: calc(50% - 50px);
			opacity: 0;
			position: absolute;
			width: 100px;
		}

		h1,
		p {
			margin: 0;
		}

		h1 {
			color: rgba(0, 0, 0, 0.8);
			font-size: 30px;
			font-weight: 700;
			margin-bottom: 10px;
			padding-top: 50px;
		}

		p {
			color: rgba(0, 0, 0, 0.7);
			padding: 0 40px;
			font-size: 18px;
			line-height: 1.4em;
		}

		button {
			background: white;
			border: 1px solid rgba(0, 0, 0, 0.15);
			border-radius: 20px;
			bottom: -20px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
			color: rgba(0, 0, 0, 0.7);
			cursor: pointer;
			font-family: inherit;
			font-size: 16px;
			font-weight: 600;
			height: 40px;
			left: calc(50% - 85px);
			outline: none;
			position: absolute;
			transition: all 170ms ease-in;
			width: 170px;
		}

		/*
 * COLOR SPECIFIC
*/
		.red .header {
			background-color: #ffb3b3;
		}

		.red .sign {
			background-color: #ff3535;
			box-shadow: 0 0 0 15px #ff8282, 0 0 0 30px #ffa2a2;
		}

		.red .sign:before,
		.red .sign:after {
			background: white;
			border-radius: 2px;
			content: "";
			display: block;
			height: 40px;
			left: calc(50% - 2px);
			position: absolute;
			top: calc(50% - 20px);
			width: 5px;
		}

		.red .sign:before {
			transform: rotate(45deg);
		}

		.red .sign:after {
			transform: rotate(-45deg);
		}

		.red button:hover {
			border-color: #ff3535;
		}

		.red button:focus {
			background-color: #ffb3b3;
			border-color: #ff3535;
		}

		.green .header {
			background-color: #bef0c8;
		}

		.green .sign {
			background-color: #4ec45e;
			box-shadow: 0 0 0 15px #74d181, 0 0 0 30px #9bdea4;
		}

		.green .sign:before,
		.green .sign:after {
			background: white;
			border-radius: 2px;
			content: "";
			display: block;
			height: 40px;
			left: calc(50% - 2px);
			position: absolute;
			top: calc(50% - 20px);
			width: 5px;
		}

		.green .sign:before {
			left: calc(50% + 5px);
			transform: rotate(45deg);
			top: calc(50% - 20px);
		}

		.green .sign:after {
			height: 20px;
			left: calc(50% - 15px);
			transform: rotate(-45deg);
			top: calc(50% - 5px);
		}

		.green button:hover {
			border-color: #4ec45e;
		}

		.green button:focus {
			background-color: #bef0c8;
			border-color: #4ec45e;
		}

		/*
 * ANIMATIONS
*/
		@-webkit-keyframes wrapperAni {
			0% {
				opacity: 0;
				transform: scale(0.95) translateY(40px);
			}

			100% {
				opacity: 1;
				transform: scale(1) translateY(0);
			}
		}

		@keyframes wrapperAni {
			0% {
				opacity: 0;
				transform: scale(0.95) translateY(40px);
			}

			100% {
				opacity: 1;
				transform: scale(1) translateY(0);
			}
		}

		@-webkit-keyframes headerAni {
			0% {
				border-radius: 0;
				opacity: 0;
				transform: translateY(-100px);
			}

			100% {
				border-radius: 50%;
				opacity: 1;
				transform: translateY(0);
			}
		}

		@keyframes headerAni {
			0% {
				border-radius: 0;
				opacity: 0;
				transform: translateY(-100px);
			}

			100% {
				border-radius: 50%;
				opacity: 1;
				transform: translateY(0);
			}
		}

		@-webkit-keyframes signAni {
			0% {
				opacity: 0;
				transform: scale(0.3) rotate(180deg);
			}

			60% {
				transform: scale(1.3);
			}

			80% {
				transform: scale(0.9);
			}

			100% {
				opacity: 1;
				transform: scale(1) rotate(0);
			}
		}

		@keyframes signAni {
			0% {
				opacity: 0;
				transform: scale(0.3) rotate(180deg);
			}

			60% {
				transform: scale(1.3);
			}

			80% {
				transform: scale(0.9);
			}

			100% {
				opacity: 1;
				transform: scale(1) rotate(0);
			}
		}

		/*
 * EMBED STYLING
*/
	</style>

</head>

<body>
	<?php
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
		$ORDERID = $_POST['ORDERID'];
		$status = $_POST['STATUS'];
		$conn = $pdo->open();
		if (isset($_SESSION["vm_id"])) {
			$vm_id = $_SESSION["vm_id"];
		} else {
			$stmt = $conn->prepare("SELECT transaction_user_id FROM transaction WHERE transaction_order=:id");
			$stmt->execute(['id' => $ORDERID]);
			$user = $stmt->fetch();
			$_SESSION['vm_user'] = 'True';
			$vm_id = $_SESSION['vm_id'] = $user['transaction_user_id'];
		}
		include './includes/req_start.php';
		if ($req_per == 1) {
			$date = $_POST['TXNDATE'];
			$stmt = $conn->prepare("UPDATE transaction SET transaction_status=:transaction_status,transaction_date=:transaction_date WHERE transaction_order=:id");
			$stmt->execute(['transaction_status' => $status, 'transaction_date' => $date, 'id' => $ORDERID]);
		}
		if ($_POST["STATUS"] == "TXN_SUCCESS") {
			$TXNAMOUNT = $_POST['TXNAMOUNT'];
			
			$mode = $_POST['PAYMENTMODE'];
			if ($req_per == 1) {
				$stmt = $conn->prepare("SELECT user_amount FROM users WHERE user_id=:id");
				$stmt->execute(['id' => $vm_id]);
				$user = $stmt->fetch();
				$total_amount = $user['user_amount'] + $TXNAMOUNT;
				$stmt = $conn->prepare("UPDATE users SET user_amount=:user_amount WHERE user_id=:id");
				$stmt->execute(['user_amount' => $total_amount, 'id' => $vm_id]);
			}

	?> <div class="wrapper green">
				<div class="header__wrapper">
					<div class="header">
						<div class="sign"><span></span></div>
					</div>
				</div>
				<h1>Yeah..!</h1>
				<p>Everything works fine!</p>

				<a href="./account.php"><button>Now go on</button></a>
			</div>

		<?php

		} else {

		?>
			<div class="wrapper red">
				<div class="header__wrapper">
					<div class="header">
						<div class="sign"><span></span></div>
					</div>
				</div>
				<h1>Whooops..!</h1>
				<p>Something went wrong, please try again.</p>

				<a href="./account.php"><button>Dismiss</button></a>
			</div>
		<?php
		}
		$pdo->close();
	} else { ?>
		<div class="wrapper red">
			<div class="header__wrapper">
				<div class="header">
					<div class="sign"><span></span></div>
				</div>
			</div>
			<h1>Whooops..!</h1>
			<p>Checksum mismatched.</p>

			<a href="./account.php"><button>Dismiss</button></a>
		</div>
	<?php }

	?>
</body>

</html>