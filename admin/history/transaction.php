<?php include '../includes/session.php'; ?>
<?php include '../includes/header.php'; ?>
<?php if ($admin['history_view']) { ?>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      <?php include '../includes/navbar.php'; ?>
      <?php include '../includes/menubar.php'; ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            History
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">History</li>
          </ol>
        </section>
        <section class="content">
          <div class="panel panel-default" style="overflow-x:auto;">
          <form method="POST">
                <div class="form-group">
                  <div class="col-sm-4">
                    <input type="date" class="form-control" name="date" id="date" required>
                  </div>
                  <div class="col-sm-4">
                    <input type="submit" class="form-control-static" name="submit" id="submit" value=" Submit ">
                  </div>
                </div>
              </form>
            <div class="row">
                   <div class="col-xs-12">
                <div class="box">
                  <div class="box-body">
                    <table id="example1" class="table table-bordered">
                      <thead>
                        <th>#</th>
                        <th>USER ID</th>
                        <th>AMOUNT</th>
                        <th>HOW</th>
                        <th>BY(ADMIN)</th>
                        <th>Date</th>
                      </thead>
                      <tbody>
                        <?php
                        date_default_timezone_set('Asia/Kolkata');
                        if (isset($_POST['submit'])){
                          $today = strtotime($_POST['date']);
                          $day=date('d',$today);
                          $month=date('m',$today);
                          $year=date('Y',$today);
                        }else{
                          $day=date('d');
                          $month=date('m');
                          $year=date('Y');
                      }
                        $conn = $pdo->open();
                        try {
                          $slno = 1;
                          $stmt = $conn->prepare("SELECT * FROM transaction WHERE day(transaction_date)=$day AND month(transaction_date)=$month AND year(transaction_date)=$year AND transaction_type='0' ORDER BY transaction_id DESC");
                          $stmt->execute();
                          foreach ($stmt as $row) {
                            echo "<tr>";
                            echo "<td>" . $slno++ . "</td>";
                            echo "<td>" . $row['transaction_user_id'] . "</td>";
                            echo "<td>" . $row['transaction_amount'] . "</td>";
                            echo "<td>" . $row['transaction_send_to'] . "</td>";
                            echo "<td>" . $row['transaction_added_by'] . "</td>";
                            echo "<td>" . $row['transaction_date'] . "</td>";
                            echo "</tr>";
                          }
                        } catch (PDOException $e) {
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

    </div>
    <!-- ./wrapper -->

    <?php include '../includes/scripts.php'; ?>
  </body>
<?php } ?>

</html>