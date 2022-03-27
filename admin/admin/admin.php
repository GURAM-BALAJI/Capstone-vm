<?php include '../includes/session.php'; ?>
<?php include '../includes/header.php';?>
<?php if($admin['admin_view']){?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  <?php include '../includes/navbar.php'; ?>
  <?php include '../includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Admin
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Admin</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <?php
        if(isset($_SESSION['error'])){
          echo "
            <div class='alert alert-danger alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-warning'></i> Error!</h4>
              ".$_SESSION['error']."
            </div>
          ";
          unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])){
          echo "
            <div class='alert alert-success alert-dismissible'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4><i class='icon fa fa-check'></i> Success!</h4>
              ".$_SESSION['success']."
            </div>
          ";
          unset($_SESSION['success']);
        }
      ?>
        <div class="panel panel-default" style="overflow-x:auto;">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
              <?php if($admin['admin_create']){?>
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New Admin</a>
            </div>
              <?php } ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                <th>ID</th>
                  <th>Photo</th>
                  <th>Email</th>
                  <th>Name</th>
                  <th>Status</th>
                    <th>Phone</th>
                <th>Added Date</th>
                   <?php if($admin['admin_edit'] || $admin['admin_del']){ ?>
                  <th>Tools</th>
                <?php } ?>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_delete='0'");
                      $stmt->execute();
                      foreach($stmt as $row){
                        $image = (!empty($row['admin_photo'])) ? '../../images/'.$row['admin_photo'] : '../../images/profile.jpg';
                        $status = ($row['admin_status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Not Active</span>';
                        $active = (!$row['admin_status']) ? '<span class="pull-right"><a href="#activate" class="status" data-toggle="modal" data-id="'.$row['admin_id'].'"><i class="fa fa-check-square-o"></i></a></span>' : '<span class="pull-right"><a href="#not_activate" class="status" data-toggle="modal" data-id="'.$row['admin_id'].'"><i class="fa fa-check-square-o"></i></a></span>';
                        echo "
                          <tr>
                          <td>".$row['admin_id']."</td>
                            <td>
                              <img src='".$image."' height='30px' width='30px'>";
                         if($admin['admin_edit'])
                              echo "<span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['admin_id']."'><i class='fa fa-edit'></i></a></span> ";
                            echo "</td>
                            <td>".$row['admin_email']."</td>
                            <td>".$row['admin_name']."</td>
                            <td>
                             $status";
                          if($admin['admin_edit'])
                              echo "$active";
                            echo "</td>";
                           echo "<td>".$row['admin_phone']."</td>";
                          echo "<td>".date('M d Y', strtotime($row['admin_added_date']))."</td>";
                          if($admin['admin_edit'] || $admin['admin_del'])
                          echo "<td>";
                                if($admin['admin_edit'])
                                    echo "<button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['admin_id'] . "'><i class='fa fa-edit'></i> Edit</button> ";
                                if($admin['admin_special']){
                              $num=$row['admin_id'];
        echo "<a rel='facebox' class='btn btn-warning btn-sm ' href='admin_permission_modal.php?id=$num'><i class='fa fa-user-secret'></i> Permisson</a> ";
                                }
                                    if($admin['admin_del'])
                              echo "<button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['admin_id']."'><i class='fa fa-trash'></i> Delete</button>";
                          if($admin['admin_edit'] || $admin['admin_del'])
                              echo "</td>";
                          echo "</tr>
                        ";
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
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
    <?php include 'admin_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include '../includes/scripts.php'; ?>
<script>
$(function(){

  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.status', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });


});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'admin_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.adminid').val(response.admin_id);
      $('#edit_email').val(response.admin_email);
      $('#edit_password').val(response.admin_password);
      $('#edit_name').val(response.admin_name);
      $('#edit_contact').val(response.admin_phone);
      $('.fullname').html(response.admin_name);
    }
  });
}
</script>
</body>
<?php } ?>
</html>