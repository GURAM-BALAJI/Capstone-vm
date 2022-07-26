<?php if (isset($_SESSION['vm_id'])) { ?>
    <!-- history list -->
    <div class="modal fade" id="history">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><b>ORDER HISTORY</b></h4>
                </div>
                <div class="modal-body">
                    <center>
                        <?php
                        $id = $_SESSION['vm_id'];
                        $conn = $pdo->open();
                        $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = $id ORDER BY orders_id DESC");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                        ?>
                            <table>
                                <tr style="background-color: lightblue;">
                                    <th colspan="2">ORDER ID : <?php echo $row['orders_id']; ?></th>
                                    <th colspan="2">ORDER DATE : <?php echo $row['orders_date']; ?></th>
                                </tr>
                                <tr>
                                    <th>NAME</th>
                                    <th>QTY</th>
                                    <th>PER COST</th>
                                    <th>SUB-TOTAL</th>
                                </tr>
                                <?php $total = $count = 0;
                                $orders_item = $row['orders_items'];
                                $orders_qty = $row['orders_qty'];
                                $orders_cost = $row['orders_cost'];
                                $orders_qty = explode(',', $orders_qty);
                                $orders_cost = explode(',', $orders_cost);
                                $orders_item = explode(',', $orders_item);
                                foreach ($orders_item as $item) {
                                ?>
                                    <tr>
                                        <td><?php
                                            $stmt_display = $conn->prepare("SELECT items_name FROM display_items left join items on items_id=display_id WHERE display_id='$item'");
                                            $stmt_display->execute();
                                            foreach ($stmt_display as $row_display)
                                                echo $row_display['items_name']; ?></td>
                                        <td><?php echo $orders_qty[$count]; ?></td>
                                        <td><?php echo $orders_cost[$count]; ?></td>
                                        <td><?php echo $orders_qty[$count] * $orders_cost[$count];
                                            $total += $orders_qty[$count] * $orders_cost[$count];
                                            $count++;
                                            ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="3">TOATL:</th>
                                    <th><?php echo $total; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                        <center><button class="vend_btn">Vend Now</button></center>
                                    </th>
                                </tr>
                            </table><hr><?php
                                }
                        $stmt = $conn->prepare("SELECT * FROM history WHERE history_user_id = $id ORDER BY history_id DESC");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                        ?>
                            <table>
                                <tr style="background-color: lightblue;">
                                    <th colspan="2">ORDER ID : <?php echo $row['history_id']; ?></th>
                                    <th colspan="2">ORDER DATE : <?php echo $row['history_date']; ?></th>
                                </tr>
                                <tr>
                                    <th>NAME</th>
                                    <th>QTY</th>
                                    <th>PER COST</th>
                                    <th>SUB-TOTAL</th>
                                </tr>
                                <?php $total = $count = 0;
                                $history_item = $row['history_item'];
                                $history_qty = $row['history_qty'];
                                $history_cost = $row['history_cost'];
                                $history_qty = explode(',', $history_qty);
                                $history_cost = explode(',', $history_cost);
                                $history_item = explode(',', $history_item);
                                foreach ($history_item as $item) {
                                ?>
                                    <tr>
                                        <td><?php
                                            $stmt_display = $conn->prepare("SELECT items_name FROM display_items left join items on items_id=display_id WHERE display_id='$item'");
                                            $stmt_display->execute();
                                            foreach ($stmt_display as $row_display)
                                                echo $row_display['items_name']; ?></td>
                                        <td><?php echo $history_qty[$count]; ?></td>
                                        <td><?php echo $history_cost[$count]; ?></td>
                                        <td><?php echo $history_qty[$count] * $history_cost[$count];
                                            $total += $history_qty[$count] * $history_cost[$count];
                                            $count++;
                                            ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <th colspan="3">TOATL:</th>
                                    <th><?php echo $total; ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4">
                                    <?php if($row['history_delivered']==0){ ?>
                                        <center><button class="btn btn-success">ORDER HAS BEEN COMPLETED</button></center>
                                        <?php }elseif($row['history_delivered']==1){?>
                                            <center><button class="btn btn-danger">TIME OUT</button></center>
                                            <?php } ?>
                                    </th>
                                </tr>
                            </table><hr><?php
                                }
                                    ?>

                    </center>
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
                        <?php if ($row['transaction_amount'] < 0){
                            $color = "red";
                            $val="Debited from..";
                        }else{
                            $color = "green";
                            $val="Credited to..";
                         } ?>
                        <div style="padding: 5px; margin: 5px; border-radius: 9px; border: 3px solid orange;">
                            <table style="width:100%;">
                                <tr>
                                    <td style="float:left;font-size:large;">
                                        <b><?php echo $row['transaction_send_to']; ?></b>
                                    </td>
                                    <td  style="width: 150px;color:<?php echo $color; ?>;">&#8377;<?php echo floatval($row['transaction_amount']); ?> /-</td>
                                <tr>
                                    <td style="background-color:white;"><?php echo date("d-M-Y h:i:s A", strtotime($row['transaction_date'])); ?></td>
                                    <td style="width: 150px;color:<?php echo $color; ?>;background-color:white;"><?php echo $val; ?> </td>
                                <tr>
                                </tr>
                                </tr>
                            </table>
                        </div>
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