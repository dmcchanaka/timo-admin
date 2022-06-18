<?php
session_start();
require_once '../library/config.php';
if ($_SESSION['user_type'] == 'admin') {
    $connection = new createConnection();
    $connection->connectToDatabase();

    $all_query = true;
    mysqli_query($connection->myconn, "SET AUTOCOMMIT=0");
    mysqli_query($connection->myconn, "START TRANSACTION");

    $up_query = "UPDATE users SET `status`='1' WHERE u_id='".$_REQUEST['u_id']."'";
    $result_up = mysqli_query($connection->myconn, $up_query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

    if ($all_query) {
        mysqli_query($connection->myconn,"COMMIT");
        echo 1;
    }else{
        mysqli_query($connection->myconn,"ROLLBACK");
        echo 0;
    }
} else {
    header('Location:../index.php');
}