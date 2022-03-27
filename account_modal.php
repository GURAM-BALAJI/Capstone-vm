<?php if (isset($_SESSION['vm_id'])) { ?>
    <!-- history list -->
    <div class="modal fade" id="history">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>HISTORY</b></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $id = $_SESSION['vm_id'];
                    $conn = $pdo->open();
                    $stmt = $conn->prepare("SELECT * FROM history WHERE history_user_id = $id ORDER BY history_id DESC LIMIT 10");
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        $color = $row['history_delivered'];
                        if ($color == 0)
                            $color = "green"; //delivered
                        elseif ($color == 1)
                            $color = "orange"; //time out
                        elseif ($color == 2)
                            $color = "red"; //order cancel
                    ?>
                        <center>
                            <table style="border-collapse: collapse;width: 100%;background-color:<?php echo $color; ?>;padding: 15px;" border="1">
                                <tr>
                                    <td style="padding: 5px;" colspan="3"><b>Ordered On:</b> <?php echo $row['history_date']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><b>Qty</b></td>
                                    <td><b>Cost</b></td>
                                </tr>
                                <tr>
                                    <?php
                                    $history_qty = $row['history_qty'];
                                    $history_cost = $row['history_cost'];
                                    $history_item = $row['history_item'];
                                    $history_qty = explode(',', $history_qty);
                                    $history_cost = explode(',', $history_cost);
                                    $history_item = explode(',', $history_item);
                                    $i = 0;
                                    foreach ($history_item as $dis_id) {
                                        if (!empty($dis_id)) {
                                            $stmt_display = $conn->prepare("SELECT * FROM display_items left join items on items_id=display_id WHERE display_id='$dis_id'");
                                            $stmt_display->execute();
                                            foreach ($stmt_display as $row_display) { ?>
                                                <td style="padding: 5px;"><?php echo $row_display['items_name']; ?></td>
                                                <td style="padding: 5px;"><?php echo $history_qty[$i]; ?></td>
                                                <td style="padding: 5px;"><?php echo $history_cost[$i] * $history_qty[$i]; ?></td>
                                <tr>
                        <?php }
                                        }
                                        $i++;
                                    }
                        ?>
                                </tr>
                            </table>
                        </center>
                        <hr>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<!-- trasaction -->
<div class="modal fade" id="trasaction">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>TRANSACTION</b></h4>
            </div>
            <div class="modal-body">

                <?php
                if (isset($_SESSION['vm_id'])) {
                    $id = $_SESSION['vm_id'];
                    $conn = $pdo->open();
                    $stmt = $conn->prepare("SELECT * FROM transaction WHERE transaction_user_id = $id ORDER BY transaction_id DESC LIMIT 15");
                    $stmt->execute();
                    foreach ($stmt as $row) { ?>
                        <?php if ($row['transaction_amount'] < 0)
                            $color = "red";
                        else
                            $color = "green"; ?>
                        <div style="padding: 5px; margin: 0;  background-color:<?php echo $color; ?>;  border-radius: 9px;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="float:left;">
                                        <h3><?php echo $row['transaction_send_to']; ?></h3>
                                    </td>
                                    <td rowspan="2">&#8377;<?php echo $row['transaction_amount']; ?></td>
                                <tr>
                                    <td style=""><?php echo date("d-M-Y h:i:s A", strtotime($row['transaction_date'])); ?></td>
                                </tr>
                                </tr>
                            </table>
                        </div>
                        <hr>
                <?php }
                } ?>

            </div>
        </div>
    </div>
</div>

  <!-- Pay -->
  <div class="modal fade" id="pay">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>Pay To Friend </b></h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="POST" action="pay_friend.php">
                        <div class="form-group">
                            <label for="phone" class="col-sm-3 control-label">ENTER PHONE NUMBER: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="phone" name="phone" id="phone" placeholder="With Out +91" required>
                            </div>
                        </div>
                        <center>
                        <div id="phone_check"></div>
                        </center>
                        <div class="form-group">
                            <label for="amount" class="col-sm-3 control-label">COINS TO SEND: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="number" step="any" name="amount" id="amount" placeholder="10" min="10" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">PASSWORD: </label>
                            <div class="col-sm-9">
                                <input class="form-control" type="password" name="password" id="password" placeholder="login password" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
                            <?php if (!isset($_SESSION['vm_id'])) { ?>
                                <a href="login.php">
                                    <button style=" background-color: #d24026; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                                        LOGIN</button>
                                </a><?php } else { ?>
                                <button type="submit" class="btn btn-primary btn-flat" name="pay"><i class="fa fa-paper-plane-o"></i> PAY</button>
                            <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_SESSION['vm_id'])) { ?>
    <!-- orders list -->
    <div class="modal fade" id="orders">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>ORDERS</b></h4>
                </div>
                <div class="modal-body">
                    <?php
                    $id = $_SESSION['vm_id'];
                    $conn = $pdo->open();
                    $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = $id ORDER BY orders_id DESC LIMIT 10");
                    $stmt->execute();
                    foreach ($stmt as $row) {
                    ?>
                        <center>
                            <table style="border-collapse: collapse;width: 100%;padding: 15px;" border="1">
                                <tr>
                                    <td style="padding: 5px;" colspan="3"><b>Ordered On:</b> <?php echo $row['orders_date']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><b>Qty</b></td>
                                    <td><b>Cost</b></td>
                                </tr>
                                <tr>
                                    <?php
                                    $orders_qty = $row['orders_qty'];
                                    $orders_cost = $row['orders_cost'];
                                    $orders_item = $row['orders_items'];
                                    $orders_qty = explode(',', $orders_qty);
                                    $orders_cost = explode(',', $orders_cost);
                                    $orders_item = explode(',', $orders_item);
                                    $i = 0;
                                    foreach ($orders_item as $dis_id) {
                                        if (!empty($dis_id)) {
                                            $stmt_display = $conn->prepare("SELECT * FROM display_items left join items on items_id=display_id WHERE display_id='$dis_id'");
                                            $stmt_display->execute();
                                            foreach ($stmt_display as $row_display) { ?>
                                                <td style="padding: 5px;"><?php echo $row_display['items_name']; ?></td>
                                                <td style="padding: 5px;"><?php echo $orders_qty[$i]; ?></td>
                                                <td style="padding: 5px;"><?php echo $orders_cost[$i] * $orders_qty[$i]; ?></td>
                                <tr>
                        <?php }
                                        }
                                        $i++;
                                    }
                        ?>
                                </tr>
                                <tr>
                                    <td style="padding: 5px;" colspan="3"><center><h4>OTP: <b> <?php echo $row['orders_otp']; ?></b></h4></center></td>
                                </tr>
                            </table>
                        </center>
                        <hr>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>