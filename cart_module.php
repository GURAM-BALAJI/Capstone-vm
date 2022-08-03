<div class="modal fade" id="buy">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>BUY NOW....</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="buy_now.php">
                    <center>
                        <h1 style="color: #d24026;">Are you sure, You want to buy.</h1>
                    </center>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> NO</button>
                        <?php if (!isset($_SESSION['vm_id'])) { ?>
                            <a href="login.php">
                                <button style=" background-color: #d24026; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                                    LOGIN</button>
                            </a><?php } else { ?>
                            <button type="submit" class="btn btn-success btn-flat" name="buy"><i class="fa fa-lightbulb-o"></i> YES</button>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 
history list 
1-vended.
2-cancel.
3-time out.
-->
<?php if (isset($_SESSION['vm_user'])) { ?>
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
                        $stmt = $conn->prepare("SELECT * FROM orders WHERE orders_user_id = :id ORDER BY orders_date DESC");
                        $stmt->execute(['id' => $id]);
                        foreach ($stmt as $row) {
                        ?>
                            <table>
                                <tr style="background-color: lightblue;">
                                    <th colspan="2">ORDER ID : <?php echo $row['orders_id']; ?></th>
                                    <th colspan="2" >Remaining Time :<b style="color:#d24026;"> <?php date_default_timezone_set('Asia/Kolkata');
                                                                    echo gmdate("i:s",(strtotime($row['orders_date']) + 900) - strtotime(date('Y-m-d h:i:s'))); ?></b></th>
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
                                            $stmt_display = $conn->prepare("SELECT items_name FROM display_items left join items on items_id=display_id WHERE display_id=:item");
                                            $stmt_display->execute(['item' => $item]);
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
                                        <center><a href="./vend_now.php"><button class="vend_btn">Vend Now</button></a></center>
                                    </th>
                                </tr>
                            </table>
                            <hr><?php
                            }
                            $stmt = $conn->prepare("SELECT * FROM history WHERE history_user_id = :id ORDER BY history_date DESC LIMIT 7");
                            $stmt->execute(['id' => $id]);
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
                                            $stmt_display = $conn->prepare("SELECT items_name FROM display_items left join items on items_id=display_id WHERE display_id=:item");
                                            $stmt_display->execute(['item' => $item]);
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
                                        <?php if ($row['history_delivered'] == 1) { ?>
                                            <center><button class="btn btn-success">ORDER HAS BEEN COMPLETED</button></center>
                                        <?php } elseif ($row['history_delivered'] == 3) { ?>
                                            <center><button class="btn btn-danger">TIME OUT</button></center>
                                        <?php } elseif ($row['history_delivered'] == 2) { ?>
                                            <center><button class="btn btn-secondary">CANCELLED</button></center>
                                        <?php } ?>
                                    </th>
                                </tr>
                            </table>
                            <hr><?php
                            }
                            $pdo->close();
                                ?>

                    </center>
                </div>
            </div>
        </div>
    </div>
<?php } ?>