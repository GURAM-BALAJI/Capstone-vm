<?php
include 'includes/session.php';
use PHPMailer\PHPMailer\PHPMailer;

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

// Assuming you have retrieved the email address from somewhere
$email = 'Srinivasvk77@gmail.com';

// Check if stock_mail is equal to 1
$stmt1 = $conn->prepare("SELECT * FROM mailalert WHERE stock_mail = 1 LIMIT 1");
$stmt1->execute();
$stock_mail = $stmt1->fetch(PDO::FETCH_ASSOC);
$stmt1->closeCursor(); // Close the cursor to allow for the next query

if ($stock_mail) {
    // Fetch data for the email body
    $stmt2 = $conn->prepare("SELECT  display_items.display_items_qty, items.items_name
                            FROM items
                            RIGHT JOIN display_items ON items.items_id = display_items.display_items_id
                            WHERE display_items.display_items_qty <= 2");
    $stmt2->execute();
    $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $stmt2->closeCursor(); // Close the cursor

    // Create a table to format the data
    $table = "<table border='1'>
               <tr>
                   <th>Display Items Qty</th>
                   <th>Items Name</th>
               </tr>";

    // Fetch and display each row
    foreach ($result as $row) {
        $table .= "<tr>
                       <td>{$row['display_items_qty']}</td>
                       <td>{$row['items_name']}</td>
                   </tr>";
    }

    $table .= "</table>";

    // Your logic for sending the email
    $message = "<center><h1 style=color:red;>Stock getting Low. Fill up fast</h1> <br> .$table. </br></center>";

    $mail = new PHPMailer();
    // Server settings
    $mail->isSMTP();
    $mail->Host = "smtp.hostinger.com";
    $mail->SMTPAuth = true;
    $mail->Username = "vm@immunityspot.com"; // enter your email address
    $mail->Password = "SI@7softsolution"; // enter your email password
    $mail->Port = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->setFrom('vm@immunityspot.com', 'Stock alert.');

    // Recipients
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Inventory alert....';
    $mail->Body = $message;

    if ($mail->send()) {
        // Update stock_mail to 0 after sending the email
        $stmt3 = $conn->prepare("UPDATE mailalert SET stock_mail = 0 WHERE stock_mail = 1");
        $stmt3->execute();
    } else {
        $_SESSION['error'] = "Mail can't be sent. Please check your email.";
    }
}
?>
