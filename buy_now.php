<?php
include 'includes/session.php';
include './includes/req_start.php';

use PHPMailer\PHPMailer\PHPMailer;

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

// Assuming you have retrieved the email address from somewhere
$email = 'Srinivasvk77@gmail.com';
if ($req_per == 1) {
    $redirect = 0;
    $id = $_SESSION['vm_id'];
    //Sanitizing inputs.
    if ($id > 0) {
        $conn = $pdo->open();
        $flag = 0;
        $stmt_semopher = $conn->prepare("SELECT * FROM semopher WHERE semopher_id=:semopher");
        $stmt_semopher->execute(['semopher' => 1]);
        foreach ($stmt_semopher as $row_semopher) {
            $lock = $row_semopher['semopher_value'];
            if ($lock == 0) {
                $stmt_semopher = $conn->prepare("UPDATE semopher SET semopher_value=:semopher WHERE semopher_id=:semopher_id");
                $stmt_semopher->execute(['semopher' => 1, 'semopher_id' => 1]);
            }
        }
        if ($lock == 0) {
            $total = 0;
            $display_machine_id = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 1;
            $stmt_check = $conn->prepare("SELECT * FROM cart left join display_items on display_spring_id=cart_spring_id left join items on items_id=display_items_id WHERE cart_user_id=:cart_user_id AND cart_machine_id=:display_machine_id");
            $stmt_check->execute(['cart_user_id' => $id, 'display_machine_id' => $display_machine_id]);
            foreach ($stmt_check as $row_check) {
                $flag++;
                if ($row_check['display_items_qty'] >= $row_check['cart_qty']) {
                    if ($flag == 1) {
                        $qty_array = $row_check['cart_qty'];
                        $item_array = $row_check['display_items_id'];
                        $sitem_array = $row_check['display_spring_id'];
                        $cost_array = $row_check['items_cost'];
                    } else {
                        $qty_array .= ',' . $row_check['cart_qty'];
                        $item_array .= ',' . $row_check['display_items_id'];
                        $sitem_array .= ',' . $row_check['display_spring_id'];
                        $cost_array .= ',' . $row_check['items_cost'];
                    }
                    $total += $row_check['cart_qty'] * $row_check['items_cost'];
                } else {
                    $pdo->close();
                    $_SESSION['error'] = 'Try Agian.';
                    header('location: MyCart');
                    exit();
                }
            }
            if ($flag == 0)
                $_SESSION['error'] = 'Cart Is Empty.';
            else {
                $stmt_user = $conn->prepare("SELECT * FROM users WHERE user_id=:id");
                $stmt_user->execute(['id' => $id]);
                foreach ($stmt_user as $row_user)
                    if ($row_user['user_amount'] >= $total) {
                        $redirect = 1;
                        $update_qty = explode(',', $qty_array);
                        $update_items = explode(',', $item_array);
                        echo $update_items;
                        $i = 0;
                        foreach ($update_items as $dis_id) {

                            if (!empty($dis_id)) {
                                $stmt_display = $conn->prepare("SELECT * FROM display_items WHERE display_id=:dis_id");
                                $stmt_display->execute(['dis_id' => $dis_id]);
                                foreach ($stmt_display as $row_display)
                                    $rem_qty = $row_display['display_items_qty'] - $update_qty[$i];
                                $stmt_display_update = $conn->prepare("UPDATE display_items SET display_items_qty=:rem_qty WHERE display_id= :dis_id");
                                $stmt_display_update->execute(['rem_qty' => $rem_qty, 'dis_id' => $dis_id]);
                            }
                            $i++;
                        }

                        date_default_timezone_set('Asia/Kolkata');
                        $today = date('Y-m-d h:i:s a');
                        $stmt = $conn->prepare("INSERT INTO orders (orders_qty,orders_cost,orders_items,orders_user_id,orders_date, orders_spring_id) VALUES (:orders_qty,:orders_cost,:orders_items,:orders_user_id,:orders_date, :orders_spring_id)");
                        $stmt->execute(['orders_qty' => $qty_array, 'orders_cost' => $cost_array, 'orders_items' => $item_array, 'orders_user_id' => $id, 'orders_date' => $today, 'orders_spring_id' => $sitem_array]);
                        // Fetch data for the email body
                        $stmt2 = $conn->prepare("SELECT display_items_qty FROM display_items WHERE display_items_qty <= 2");
                        $stmt2->execute();
                        if ($stmt2->rowCount() > 0) {
                            // Fetch data from the database
                            $stmt = $conn->prepare("SELECT display_items_qty, items_name, display_machine_id
                                                    FROM items
                                                    RIGHT JOIN display_items ON items.items_id = display_items.display_items_id
                                                    ORDER BY display_machine_id, items_name");
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            $currentMachineId = null;
                            $table = "";
                            foreach ($result as $row) {
                                if ($row['display_machine_id'] !== $currentMachineId) {
                                    // Start a new table for a new machine ID
                                    if ($currentMachineId !== null) {
                                        $table .= "</table>";
                                    }
                                    $table .= "<table style='border-collapse: collapse; width: 100%;'>
                                    <tr>
                                        <th colspan='2' style='font-size: 18px; color: #2196F3; background-color: cyan; padding: 10px; border: 2px solid #dddddd;'>Machine {$row['display_machine_id']}</th>
                                    </tr>
                                    <tr>
                                        <th style='background-color: #4CAF50; color: white; padding: 10px; border: 1px solid #dddddd;'>Items Name</th>
                                        <th style='background-color: #4CAF50; color: white; padding: 10px; border: 1px solid #dddddd;'>Display Items Qty</th>
                                    </tr>";

                                    $currentMachineId = $row['display_machine_id'];
                                }

                                // Display row in the current table
                                $color = ($row['display_items_qty'] <= 2) ? 'red' : 'green';
                                $table .= "<tr>
                                               <td style='border: 2px solid #dddddd; padding: 20px;  color: $color;'>{$row['items_name']}</td>
                                               <td style='border: 2px solid #dddddd; padding: 20px; color: $color;'>{$row['display_items_qty']}</td>
                                           </tr>";
                            }

                            // Close the last table
                            if ($currentMachineId !== null) {
                                $table .= "</table>";
                            }

                            // Your logic for sending the email
                            $message = "<center><h1 style=color:red;>Stock Getting Low. Fill up fast</h1> <br> .$table. </br></center>";

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
                            $mail->send();
                        }
                        $stmt = $conn->prepare("DELETE FROM cart WHERE cart_user_id=:id AND cart_machine_id=:display_machine_id");
                        $stmt->execute(['id' => $id, 'display_machine_id' => $display_machine_id]);
                        $balance = $row_user['user_amount'] - $total;
                        $stmt_user_update = $conn->prepare("UPDATE users SET user_amount=$balance WHERE user_id=$id");
                        $stmt_user_update->execute();
                        $stmt = $conn->prepare("INSERT INTO transaction (transaction_user_id,transaction_send_to,transaction_amount,transaction_added_by,transaction_type,transaction_date) VALUES (:transaction_user_id,:transaction_send_to,:transaction_amount,:transaction_added_by,:transaction_type,:transaction_date)");
                        $stmt->execute(['transaction_user_id' => $id, 'transaction_send_to' => 'Ordered', 'transaction_amount' => -$total,  'transaction_added_by' => $id, 'transaction_type' => 1, 'transaction_date' => $today]);
                    } else
                        $_SESSION['error'] = 'Insufficient Balance.';
                
            }
        }
    } else {
        $_SESSION['error'] = 'Wrong Inputs.';
    }
}
$stmt_semopher = $conn->prepare("UPDATE semopher SET semopher_value=:semopher WHERE semopher_id=:semopher_id");
                $stmt_semopher->execute(['semopher' => 0, 'semopher_id' => 1]);
$pdo->close();

if ($redirect == 1 && isset($redirect))
    header('location: vend_now.php');
else
    header('location: MyCart');
