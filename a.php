<?php
include 'includes/session.php';

if (isset($_SESSION['vm_id'])) {
    
    $id = $_SESSION['vm_id'];
    echo"$id";
}
    ?>