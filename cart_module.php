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
                    <center><h1 style="color: #d24026;">Are you sure, You want to buy.</h1></center>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> NO</button>
                        <?php if(!isset($_SESSION['vm_id'])){ ?>
                        <a href="login.php">
                            <button
                                style=" background-color: #d24026; border: none; color: white; padding: 10px; text-align: center; text-decoration: none; display: inline-block; font-size: 12px; margin: 4px 2px; cursor: pointer; border-radius: 10px;">
                                LOGIN</button>
                        </a><?php }else{?>
                        <button type="submit" class="btn btn-success btn-flat" name="buy"><i
                                class="fa fa-lightbulb-o"></i> YES</button>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>