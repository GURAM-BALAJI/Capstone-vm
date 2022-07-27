<?php
	include '../includes/session.php';

	if(isset($_POST['update'])) {
        $id = $_POST['id'];
        if(isset($_POST['users_view']))
            $users_view =1;
        else
            $users_view =0;
        if(isset($_POST['users_create']))
            $users_create =1;
        else
            $users_create =0;
        if(isset($_POST['users_edit']))
            $users_edit =1;
        else
            $users_edit =0;
        if(isset($_POST['users_del']))
            $users_del =1;
        else
            $users_del =0;
        if(isset($_POST['admin_view']))
            $admin_view =1;
        else
            $admin_view =0;
        if(isset($_POST['admin_create']))
            $admin_create =1;
        else
            $admin_create =0;
        if(isset($_POST['admin_edit']))
            $admin_edit =1;
        else
            $admin_edit =0;
        if(isset($_POST['admin_del']))
            $admin_del =1;
        else
            $admin_del =0;
        if(isset($_POST['items_view']))
            $items_view =1;
        else
            $items_view =0;
        if(isset($_POST['items_create']))
            $items_create =1;
        else
            $items_create =0;
        if(isset($_POST['items_edit']))
            $items_edit =1;
        else
            $items_edit =0;
        if(isset($_POST['items_del']))
            $items_del =1;
        else
            $items_del =0;

            if(isset($_POST['slogan_view']))
            $slogan_view =1;
        else
            $slogan_view=0;
        if(isset($_POST['slogan_create']))
            $slogan_create =1;
        else
            $slogan_create=0;
        if(isset($_POST['slogan_edit']))
            $slogan_edit =1;
        else
            $slogan_edit=0;
        if(isset($_POST['slogan_del']))
            $slogan_del =1;
        else
            $slogan_del=0;

            if(isset($_POST['display_items_view']))
            $display_items_view =1;
        else
            $display_items_view =0;
        if(isset($_POST['display_items_create']))
            $display_items_create =1;
        else
            $display_items_create =0;
        if(isset($_POST['display_items_edit']))
            $display_items_edit =1;
        else
            $display_items_edit =0;
        if(isset($_POST['display_items_del']))
            $display_items_del =1;
        else
            $display_items_del =0;
        if(isset($_POST['contact_view']))
            $contact_view =1;
        else
            $contact_view =0;
        if(isset($_POST['contact_edit']))
            $contact_edit =1;
        else
            $contact_edit =0;
         if(isset($_POST['users_special']))
            $users_special =1;
        else
            $users_special =0;
        if(isset($_POST['admin_special']))
            $admin_special =1;
        else
            $admin_special =0;
        if(isset($_POST['message_view']))
            $message_view =1;
        else
            $message_view=0;
            if(isset($_POST['history_view']))
            $history_view =1;
        else
            $history_view=0;
            if(isset($_POST['orders_view']))
            $orders_view =1;
        else
            $orders_view=0;
        $conn = $pdo->open();
        try {
            $stmt = $conn->prepare("UPDATE admin SET users_special=:users_special,admin_special=:admin_special,users_view=:users_view,users_create=:users_create,users_edit=:users_edit,users_del=:users_del,admin_view=:admin_view,admin_create=:admin_create,admin_edit=:admin_edit,admin_del=:admin_del,items_view=:items_view,items_create=:items_create,items_edit=:items_edit,items_del=:items_del,contact_view=:contact_view,contact_edit=:contact_edit,message_view=:message_view,display_items_view=:display_items_view,display_items_create=:display_items_create,display_items_edit=:display_items_edit,display_items_del=:display_items_del,history_view=:history_view,orders_view=:orders_view,slogan_view=:slogan_view,slogan_create=:slogan_create,slogan_edit=:slogan_edit,slogan_del=:slogan_del WHERE admin_id=:id");
            $stmt->execute(['users_special'=>$users_special, 'admin_special'=>$admin_special, 'users_view' => $users_view, 'users_create' => $users_create, 'users_edit' => $users_edit, 'users_del' => $users_del, 'admin_view' => $admin_view, 'admin_create' => $admin_create, 'admin_edit' => $admin_edit, 'admin_del' => $admin_del, 'items_view' => $items_view, 'items_create' => $items_create, 'items_edit' => $items_edit, 'items_del' => $items_del,'contact_view' => $contact_view,'contact_edit' => $contact_edit,'message_view'=>$message_view, 'display_items_view' => $display_items_view, 'display_items_create' => $display_items_create, 'display_items_edit' => $display_items_edit, 'display_items_del' => $display_items_del, 'history_view'=>$history_view,'orders_view'=>$orders_view,'slogan_view'=>$slogan_view,'slogan_create'=>$slogan_create,'slogan_edit'=>$slogan_edit,'slogan_del'=>$slogan_del,'id' => $id]);
            $_SESSION['success'] = 'Admin Permission Updated Successfully';

        } catch (PDOException $e) {
            $_SESSION['error'] = $e->getMessage();
        }
        $pdo->close();
    }
header('location: admin.php');
