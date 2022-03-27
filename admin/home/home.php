<?php
include '../includes/session.php';
include '../includes/header.php'; ?>

<?php include '../includes/navbar.php'; ?>
<?php include '../includes/menubar.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
        </h1>
        <ol class="breadcrumb">
          <li><i class="fa fa-dashboard"></i> Home</li>
          <li class="active">Dashboard</li>
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
        <?php if ($admin['users_view']) { ?>
          <!-- /.row -->
          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-gray">
                <div class="inner">
                  <?php
                  $conn = $pdo->open();
                  $query5 = 0;
                  $stmt1 = $conn->prepare("SELECT user_amount from users Where user_delete='0'");
                  $stmt1->execute();
                  foreach ($stmt1 as $row1)
                    $query5 += $row1['user_amount'];
                  echo "<h3>" . $query5 . "</h3>";
                  ?>
                  <div class="stat-panel-title text-uppercase">Total User`s Amount</div>
                </div>
                <div class="icon">
                  <i class="fa fa-money"></i>
                </div>
                <a href="../users/users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <?php
                  $sql6 = "SELECT admin_id from admin Where admin_delete=0 AND admin_status=1";
                  $query6 = $conn->prepare($sql6);;
                  $query6->execute();
                  $results6 = $query6->fetchAll(PDO::FETCH_OBJ);
                  $query = $query6->rowCount();
                  $sql2 = "SELECT admin_id from admin Where admin_delete=0 AND admin_status=0";
                  $query2 = $conn->prepare($sql2);;
                  $query2->execute();
                  $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                  $query1 = $query2->rowCount();
                  echo "<h6>Active Admin's: " . htmlentities($query) . "</h6>";
                  echo "<h6>In-Active Admin's:" . htmlentities($query1) . "</h6>";
                  echo "<h6>Total Admin's:" . htmlentities($query1 + $query) . "</h6>";
                  ?>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="../admin/admin.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <?php
                  $query = $query1 = 0;
                  $sql6 = "SELECT user_id from users Where user_delete=0 AND user_status=1";
                  $query6 = $conn->prepare($sql6);;
                  $query6->execute();
                  $results6 = $query6->fetchAll(PDO::FETCH_OBJ);
                  $query = $query6->rowCount();
                  $sql2 = "SELECT user_id from users Where user_delete=0 AND user_status=0";
                  $query2 = $conn->prepare($sql2);;
                  $query2->execute();
                  $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
                  $query1 = $query2->rowCount();
                  echo "<h6>Active User's: " . htmlentities($query) . "</h6>";
                  echo "<h6>In-Active User's:" . htmlentities($query1) . "</h6>";
                  echo "<h6>Total User's:" . htmlentities($query1 + $query) . "</h6>";
                  ?>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="../users/users.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-gray">
                <div class="inner">
                  <?php
                  $conn = $pdo->open();
                  $query5 = 0;
                  $stmt1 = $conn->prepare("SELECT COUNT(*) AS numrows from orders ");
                  $stmt1->execute();
                  $row = $stmt1->fetch();
                  echo "<h3>" . $row['numrows'] . "</h3>";
                  ?>
                  <div class="stat-panel-title text-uppercase">Total Present Orders</div>
                </div>
                <div class="icon">
                  <i class="fa fa-shopping-cart"></i>
                </div>
                <a href="../orders/orders.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>
        <?php } ?>
    </div>
    <?php include '../includes/scripts.php'; ?>
</body>

</html>