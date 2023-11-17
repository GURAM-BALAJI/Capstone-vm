<?php include '../includes/session.php'; ?>
<?php include '../includes/header.php'; ?>
<?php if ($admin['display_items_view']) { ?>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php include '../includes/navbar.php'; ?>
      <?php include '../includes/menubar.php'; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Display Items
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Manage</li>
            <li class="active">Display Items</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <?php
          if (isset($_SESSION['error'])) {
            echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              " . $_SESSION['error'] . "
            </div>
          ";
            unset($_SESSION['error']);
          }
          if (isset($_SESSION['success'])) {
            echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              " . $_SESSION['success'] . "
            </div>
          ";
            unset($_SESSION['success']);
          }
          ?>
          <div class="panel panel-default" style="overflow-x:auto;">
            <div class="row">
              <div class="col-xs-12">
                <div class="box">
                  <?php if ($admin['display_items_create']) { ?>
                    <div class="box-header with-border">
                      <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New Display Items</a>
                    </div>
                  <?php } ?>
                  <div class="box-body">
                    <table id="example1" class="table table-bordered">
                      <thead>
                      <th>Machine Id</th>
                        <th>Spring Id</th>
                        <th>Iteam Id</th>
                        <th>Name</th>
                        <th>Cost</th>
                        <th>QTY</th>
                        <th>Added Date</th>
                        <th>Updated Date</th>
                        <?php if ($admin['display_items_edit'] || $admin['display_items_del']) { ?>
                          <th>Tools</th>
                        <?php } ?>
                      </thead>
                      <tbody>
                        <?php
                        $conn = $pdo->open();

                        try {
                          $stmt = $conn->prepare("SELECT * FROM display_items");
                          $stmt->execute();
                          foreach ($stmt as $row) {
                            $item_id = $row['display_items_id'];
                            echo "<td>" . $row['display_machine_id'] . "</td>";
                            echo  "<td>" . $row['display_spring_id'] . "</td>";
                            echo  "<td>" . $item_id . "</td>";
                            $stmt1 = $conn->prepare("SELECT * FROM items WHERE items_id=:item_id");
                            $stmt1->execute(['item_id' => $item_id]);
                            foreach ($stmt1 as $row1) {
                              echo "<td>" . $row1['items_name'] . "</td>
                              <td>" . $row1['items_cost'] . "</td>";
                            }
                            echo "
                            <td>" . $row['display_items_qty'] . "</td>
                            <td>" . $row['display_items_add_date'] . "</td>
                            <td>" . $row['display_items_updated_date'] . "</td>";
                            if ($admin['display_items_edit'] || $admin['display_items_del'])
                              echo "<td>";
                            if ($admin['display_items_edit'])
                              echo "<button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['display_spring_id'] . "'><i class='fa fa-edit'></i> Edit</button> ";
                            if ($admin['display_items_del'])
                              echo "<button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['display_spring_id'] . "'><i class='fa fa-trash'></i> Delete</button>";
                            if ($admin['display_items_edit'] || $admin['display_items_del'])
                              echo "</td>";
                            echo "</tr>
                        ";
                          }
                        } catch (PDOException $e) {
                          echo "Something Went Wrong.";
                        }

                        $pdo->close();
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
      <?php include 'display_items_modal.php'; ?>

    </div>
    <!-- ./wrapper -->

    <?php include '../includes/scripts.php'; ?>
    <script>
      $(function() {
        $(document).on('click', '.edit', function(e) {
          e.preventDefault();
          $('#edit').modal('show');
          var id = $(this).data('id');
          getRow(id);
        });

        $(document).on('click', '.delete', function(e) {
          e.preventDefault();
          $('#delete').modal('show');
          var id = $(this).data('id');
          getRow(id);
        });

      });

      function getRow(id) {
        $.ajax({
          type: 'POST',
          url: 'display_items_row.php',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {
            $('.edit_id').val(response.display_spring_id);
            $('.catid').val(response.display_spring_id);
            $('.stringid').html(response.display_spring_id);
          }
        });
      }
    </script>
  </body>
<?php } ?>

</html>