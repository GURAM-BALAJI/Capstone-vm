<!-- Add -->
<div class="modal fade" id="addnew">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Add New Display Items</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="display_items_add.php">
                <div class="form-group">
                        <label for="machine_id" class="col-sm-3 control-label">Machine No</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="machine_id" name="machine_id" required>
                                <option value="">Select Machine</option>
                                <option value="1">1 Machine</option>
                                <option value="2">2 Machine</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="spring_id" class="col-sm-3 control-label">Spring Id</label>
                        <div class="col-sm-9">
                            <?php
                            $stmt1 = $conn->prepare("SELECT * FROM display_items");
                            $stmt1->execute();
                            $i = 0;
                            foreach ($stmt1 as $row1)
                                $arry[$i++] = $row1['display_spring_id'];
                            ?>
                            <select class="form-control" id="spring_id" name="spring_id" required>
                                <option value="">Select Spring Id</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                                <option value="16">16</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="items_id" class="col-sm-3 control-label">Item</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="items_id" name="items_id" required>
                                <option value="">Select Items</option>
                                <?php
                                $stmt1 = $conn->prepare("SELECT * FROM items WHERE items_delete=:items_delete");
                                $stmt1->execute(['items_delete'=>0]);
                                foreach ($stmt1 as $row1)
                                    echo "<option value='" . $row1['items_id'] . "'>" . $row1['items_name'] . " (" . $row1['items_cost'] . " .Rs)</option>";
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="qty" class="col-sm-3 control-label">Item QTY Present</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="qty" name="qty" required>
                            <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                                class="fa fa-close"></i> Close</button>
                        <button type="submit" class="btn btn-primary btn-flat" name="add"><i class="fa fa-save"></i>
                            Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit -->
<div class="modal fade" id="edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Edit Display items</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="display_items_edit.php">
                    <input type="hidden" class="edit_id" name="id">
                    <div class="form-group">
                        <label for="qty" class="col-sm-3 control-label">Item QTY Present</label>
                        <div class="col-sm-9">
                            <select class="form-control" id="edit_qty" name="edit_qty" required>
                            <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i>
                    Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete -->
<div class="modal fade" id="delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Deleting...</b></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="display_items_delete.php">
                    <input type="hidden" class="catid" name="id">
                    <div class="text-center">
                        <p>DELETE SPRING</p>
                        <h2 class="bold stringid"></h2>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i
                        class="fa fa-close"></i> Close</button>
                <button type="submit" class="btn btn-danger btn-flat" name="delete"><i class="fa fa-trash"></i>
                    Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>