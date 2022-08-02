<?php include '../includes/session.php'; ?>
<html>

<head>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        h2 {
            color: #1c94c4;
            text-align: center;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>

    <h2>PERMISSION</h2>
    <form class="form-horizontal" method="POST" action="admin_permission_edit.php">
        <?php
        $id = strip_tags($_GET['id']);
        $conn = $pdo->open();
        $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_id=:id");
        $stmt->execute(['id' => $id]);
        foreach ($stmt as $row) {
        ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <table>
                <tr>
                    <th> </th>
                    <th style="color: #3a8104;"> Name </th>
                    <th style="color: #3a8104;"> View </th>
                    <th style="color: #3a8104;"> Create </th>
                    <th style="color: #3a8104;"> Edit </th>
                    <th style="color: #3a8104;"> Delete </th>
                    <th style="color: #3a8104;"> Special </th>
                    <th> </th>
                </tr>
                <tr>
                    <td> </td>
                    <td> USER </td>
                    <td style="text-align: center;"> <input type="checkbox" name="users_view" <?php if ($row['users_view']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="users_create" <?php if ($row['users_create']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="users_edit" <?php if ($row['users_edit']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="users_del" <?php if ($row['users_del']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="users_special" <?php if ($row['users_special']) echo "checked"; ?>> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> ADMIN </td>
                    <td style="text-align: center;"> <input type="checkbox" name="admin_view" <?php if ($row['admin_view']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="admin_create" <?php if ($row['admin_create']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="admin_edit" <?php if ($row['admin_edit']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="admin_del" <?php if ($row['admin_del']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="admin_special" <?php if ($row['admin_special']) echo "checked"; ?>> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> DISPLAY ITEMS </td>
                    <td style="text-align: center;"> <input type="checkbox" name="display_items_view" <?php if ($row['display_items_view']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="display_items_create" <?php if ($row['display_items_create']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="display_items_edit" <?php if ($row['display_items_edit']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="display_items_del" <?php if ($row['display_items_del']) echo "checked"; ?>> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> SLOGAN </td>
                    <td style="text-align: center;"> <input type="checkbox" name="slogan_view" <?php if ($row['slogan_view']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="slogan_create" <?php if ($row['slogan_create']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="slogan_edit" <?php if ($row['slogan_edit']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="slogan_del" <?php if ($row['slogan_del']) echo "checked"; ?>> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> ITEMS </td>
                    <td style="text-align: center;"> <input type="checkbox" name="items_view" <?php if ($row['items_view']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="items_create" <?php if ($row['items_create']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="items_edit" <?php if ($row['items_edit']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="items_del" <?php if ($row['items_del']) echo "checked"; ?>> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                    <tr>
                    <td> </td>
                    <td> Contact </td>
                    <td style="text-align: center;"> <input type="checkbox" name="contact_view" <?php if ($row['contact_view']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"> </td>
                    <td style="text-align: center;"> <input type="checkbox" name="contact_edit" <?php if ($row['contact_edit']) echo "checked"; ?>> </td>
                    <td style="text-align: center;"></td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> MESSAGE </td>
                    <td style="text-align: center;"> <input type="checkbox" name="message_view" <?php if ($row['message_view']) echo "checked"; ?>> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> HISTORY </td>
                    <td style="text-align: center;"> <input type="checkbox" name="history_view" <?php if ($row['history_view']) echo "checked"; ?>> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
                <tr>
                    <td> </td>
                    <td> ORDER </td>
                    <td style="text-align: center;"> <input type="checkbox" name="orders_view" <?php if ($row['orders_view']) echo "checked"; ?>> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>
            </table>
        <?php } ?>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success btn-flat" name="update"><i class="fa fa-check"></i> UPDATE</button>
        </div>
    </form>
</body>

</html>