<?php
include '../includes/session.php';

if (isset($_POST['QRSubmit'])) {
	$QrData = test_input($_POST['QrData']);
	if (!empty($QrData)) {
		$conn = $pdo->open();
		try {
			$stmt = $conn->prepare("UPDATE adminqrcode SET qr_code=:qr_code ");
			$stmt->execute(['qr_code' => $QrData]);
			$_SESSION['success'] = 'QR Data Updated Successfully';
		} catch (PDOException $e) {
			$_SESSION['error'] = "Something Went Wrong.";
		}

		$pdo->close();
	} else {
		$_SESSION['error'] = 'Please Enter Data.';
	}
} else {
	$_SESSION['error'] = 'Enter Qr data first..!';
}

header('location: admin_qr.php');
