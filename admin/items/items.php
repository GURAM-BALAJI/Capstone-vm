<?php include '../includes/session.php'; ?>
<?php include '../includes/header.php'; ?>
<?php if($admin['items_view']){?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include '../includes/navbar.php'; ?>
  <?php include '../includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Items
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage</li>
        <li class="active">Items</li>
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
              <?php if($admin['items_create']){ ?>
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New Items</a>
            </div>
              <?php } ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                <th>ID</th>
                <th>Image</th>
                  <th>Name</th>
                  <th>Cost</th>
                    <th>Added Date</th>
                    <th>Updated Date</th>
                   <?php if($admin['items_edit'] || $admin['items_del']){ ?>
                  <th>Tools</th>
                 <?php } ?>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM items WHERE items_delete='0'");
                      $stmt->execute();
                      foreach($stmt as $row){
                        $image = (!empty($row['items_image'])) ? '../../items_images/'.$row['items_image'] : '../../items_images/noimage.jpg';
                       echo  "<td>".$row['items_id']."</td>
                        <td>
                          <img src='".$image."' height='30px' width='30px'>";
                      if($admin['items_edit'])
                          echo "<span class='pull-right'><a href='#items_image' class='items_image' data-toggle='modal' data-id='".$row['items_id']."'><i class='fa fa-edit'></i></a></span>";
                        echo "</td>
                            <td>".$row['items_name']."</td>
                            <td>".$row['items_cost']."</td>
                            <td>".$row['items_add_date']."</td>
                            <td>".$row['items_updated_date']."</td>";
                        if($admin['items_edit'] || $admin['items_del'])
                          echo "<td>";
                          if($admin['items_edit'])
                              echo "<button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['items_id']."'><i class='fa fa-edit'></i> Edit</button> ";
                               if($admin['items_del'])
                              echo "<button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['items_id']."'><i class='fa fa-trash'></i> Delete</button>";
                            if($admin['items_edit'] || $admin['items_del'])
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
    <?php include 'items_modal.php'; ?>

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

  $(document).on('click', '.items_image', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            getRow(id);
        });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'items_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.imageid').val(response.items_id);
      $('.catid').val(response.items_id);
      $('#edit_name').val(response.items_name);
         $('#edit_cost').val(response.items_cost);
        $('.catname').html(response.items_name);
    }
  });
}
</script>
</body>
<?php } ?>
</html>
