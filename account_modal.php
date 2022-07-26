


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