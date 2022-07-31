<?php include '../includes/session.php'; ?>
<?php include '../includes/header.php'; ?>
<?php if($admin['slogan_view']){?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include '../includes/navbar.php'; ?>
  <?php include '../includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Slogan
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage</li>
        <li class="active">Slogan</li>
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
              <?php if($admin['slogan_create']){ ?>
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-plus"></i> New slogan</a>
            </div>
              <?php } ?>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                <th>ID</th>
                  <th>Sentance</th>
                   <?php if($admin['slogan_edit'] || $admin['slogan_del']){ ?>
                  <th>Tools</th>
                 <?php } ?>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT * FROM slogan");
                      $stmt->execute();
                      $slno=1;
                      foreach($stmt as $row){
                        $image = (!empty($row['slogan_image'])) ? '../../slogan_images/'.$row['slogan_image'] : '../../slogan_images/noimage.jpg';
                       echo  "<td>".$slno++."</td>
                            <td>".$row['slogan_sentance']."</td>";
                        if($admin['slogan_edit'] || $admin['slogan_del'])
                          echo "<td>";
                          if($admin['slogan_edit'])
                              echo "<button class='btn btn-success btn-sm edit btn-flat' data-id='".$row['slogan_id']."'><i class='fa fa-edit'></i> Edit</button> ";
                               if($admin['slogan_del'])
                              echo "<button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['slogan_id']."'><i class='fa fa-trash'></i> Delete</button>";
                            if($admin['slogan_edit'] || $admin['slogan_del'])
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
    <?php include 'slogan_modal.php'; ?>

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

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'slogan_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.slogan_id').val(response.slogan_id);
      $('#slogan_sentance').val(response.slogan_sentance);
$('.delete_slogan_id').val(response.slogan_id);
      $('.delete_slogan_sentance').html(response.slogan_sentance);
    }
  });
}
</script>
</body>
<?php } ?>
</html>
