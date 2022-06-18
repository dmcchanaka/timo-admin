<?php
session_start();
require_once '../library/config.php';
if ($_SESSION['user_type'] == 'admin') {
    $connection = new createConnection();
    $connection->connectToDatabase();

    $all_query = true;
    mysqli_query($connection->myconn, "SET AUTOCOMMIT=0");
    mysqli_query($connection->myconn, "START TRANSACTION");

    $ckUserQuery = "SELECT * FROM users WHERE u_id ='".$_REQUEST['u_id']."'";
    $ckUserResult = mysqli_query($connection->myconn, $ckUserQuery);
    if(mysqli_num_rows($ckUserResult) > 0){
        
        $update = "UPDATE users SET u_name='".$_REQUEST['name']."',sur_name='".$_REQUEST['surname']."',u_code='".$_REQUEST['usercode']."',username='".$_REQUEST['username']."' WHERE u_id='".$_REQUEST['u_id']."'";
        $result_user = mysqli_query($connection->myconn, $update) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

        if($_REQUEST['password']!=""){
            $up_pw_query = "UPDATE users SET `password`='".md5($_REQUEST['password'])."' WHERE u_id='".$_REQUEST['u_id']."'";
            $result_up_pw = mysqli_query($connection->myconn, $up_pw_query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

        }
    }

    if ($all_query) {
        mysqli_query($connection->myconn,"COMMIT");
        $_SESSION['status'] = 1;
    }else{
        mysqli_query($connection->myconn,"ROLLBACK");
        $_SESSION['status'] = 0;
    }
    header("Location: user_edit.php?u_id=".$_REQUEST['u_id']);
} else {
    header('Location:../index.php');
}
