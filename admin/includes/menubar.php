<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo (!empty($admin['admin_photo'])) ? '../../images/' . $admin['admin_photo'] : '../../images/profile.jpg'; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $admin['admin_name']; ?></p>
        <a><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">REPORTS</li>
      <li><a href="../home/home.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      <?php if ($admin['contact_view']) { ?>
        <li class="header">REQUESTS</li>
      <?php } ?>
      <?php if ($admin['contact_view']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-phone"></i>
            <span>Contacts</span> <b style="color:RED;"> <?php
                                                          $conn = $pdo->open();
                                                          foreach ($conn->query('SELECT COUNT(*) FROM contact WHERE contact_view=0') as $row) {
                                                            if ($row['COUNT(*)'] != 0)
                                                              echo $row['COUNT(*)'];
                                                          } ?></b>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../contact/contact.php"><i class="fa fa-eye-slash"></i> New Contact</a></li>
            <li><a href="../contact/contact_view.php"><i class="fa fa-eye"></i> Viewed Contact</a></li>
          </ul>
        </li>
      <?php $pdo->close();
      } ?>


      <li class="header">MANAGE</li>
      <?php if ($admin['users_view']) { ?>
        <li><a href="../users/users.php"><i class="fa fa-users"></i> <span>Users</span></a></li>
      <?php }
      if ($admin['history_view']) { ?>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-history"></i>
            <span>HISTORY</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="../history/ordered_history.php"><i class="fa fa-first-order"></i> Orders</a></li>
            <li><a href="../history/pay_to_friend.php"><i class="fa fa-paper-plane"></i> Pay To Friend</a></li>
            <li><a href="../history/recharged_history.php"><i class="fa fa-retweet"></i> Recharged</a></li>
            <li><a href="../history/refunded_history.php"><i class="fa fa-undo"></i> Refunded</a></li>
          </ul>
        </li>
      <?php } ?>
      <?php if ($admin['orders_view']) { ?>
        <li><a href="../orders/orders_histroy.php"><i class="fa fa-shopping-bag"></i> <span>Orders History</span></a></li>
        <li><a href="../orders/orders.php"><i class="fa fa-shopping-cart"></i> <span>Present Orders</span></a></li>
      <?php }
      if ($admin['display_items_view']) { ?>
        <li><a href="../display_items/display_items.php"><i class="fa fa-television"></i> <span>Display Items</span></a></li>
      <?php }
      if ($admin['items_view']) { ?>
        <li><a href="../items/items.php"><i class="fa fa-sitemap"></i> <span>Items</span></a></li>
      <?php }
      if ($admin['slogan_view']) { ?>
        <li><a href="../slogan/slogan.php"><i class="fa fa-comments-o"></i> <span>Slogan</span></a></li>
      <?php }
      if ($admin['admin_view']) { ?>
        <li><a href="../admin/admin.php"><i class="fa fa-grav"></i> <span>Admin</span></a></li>
      <?php }
      if ($admin['message_view']) { ?>
        <li><a href="../message/message.php"><i class="fa fa-comment"></i> <span>Message</span></a></li>
      <?php  }
      if ($admin['admin_view']) { ?>
        <li><a href="../Adminqr/admin_qr.php"><i class="fa fa-qrcode"></i> <span>QR Code</span></a></li>
      <?php } ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>