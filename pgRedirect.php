<?php
include 'includes/session.php';
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");
// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");



$checkSum = "";
$paramList = array();
if (isset($_SESSION['vm_id'])) {
	$CUST_ID = $_SESSION['vm_id'];
	$ORDER_ID = $CUST_ID . rand(10000, 99999) . time();
	$INDUSTRY_TYPE_ID = $_POST["INDUSTRY_TYPE_ID"];
	$CHANNEL_ID = $_POST["CHANNEL_ID"];
	$TXN_AMOUNT = $_POST["price"];
	// Create an array having all required parameters for creating checksum.
	$paramList["MID"] = PAYTM_MERCHANT_MID;
	$paramList["ORDER_ID"] = $ORDER_ID;
	$paramList["CUST_ID"] = $CUST_ID;
	$paramList["INDUSTRY_TYPE_ID"] = $INDUSTRY_TYPE_ID;
	$paramList["CHANNEL_ID"] = $CHANNEL_ID;
	$paramList["TXN_AMOUNT"] = $TXN_AMOUNT;
	$paramList["WEBSITE"] = PAYTM_MERCHANT_WEBSITE;
	$paramList["CALLBACK_URL"] = "http://192.168.0.104/vending-machine-in-php/pgResponse.php";
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d h:i:s a');
	$checkSum = getChecksumFromArray($paramList, PAYTM_MERCHANT_KEY);
	$conn = $pdo->open();
	$query = "INSERT INTO `transaction` (`transaction_send_to`,`transaction_added_by`,`transaction_order`, `transaction_user_id`,`transaction_amount`,`transaction_date`, transaction_type, transaction_status) VALUES (:transaction_send_to,:transaction_added_by,:transaction_order, :transaction_user_id, :transaction_amount, :date  ,:type ,:status1 )";
	$stmt = $conn->prepare("$query");
	$stmt->execute(['transaction_send_to' => 'Recharged', 'transaction_added_by' => $CUST_ID, 'transaction_order' => $ORDER_ID, 'transaction_user_id' => $CUST_ID, 'transaction_amount' => $TXN_AMOUNT, 'date' => $date, 'type' => '4', 'status1' => 'TXN_INIT']);
	$pdo->close();
?>

	<html>

	<head>
		<title>Recharge</title>
	</head>

	<body>
		<center>
			<h1>Please do not refresh this page...</h1>
		</center>
		<form method="post" action="<?php echo PAYTM_TXN_URL ?>" name="f1">
			<table border="1">
				<tbody>
					<?php
					foreach ($paramList as $name => $value) {
						echo '<input type="hidden" name="' . $name . '" value="' . $value . '">';
					}
					?>
					<input type="hidden" name="CHECKSUMHASH" value="<?php echo $checkSum ?>">
				</tbody>
			</table>
			<script type="text/javascript">
				document.f1.submit();
			</script>

		</form>
	</body>

	</html>
<?php } else {
	header('location:account.php');
} ?>