<?php 
session_start();
require_once '../library/config.php';
$connection = new createConnection();
$connection->connectToDatabase();

$all_query = true;
mysqli_query($connection->myconn, "SET AUTOCOMMIT=0");
mysqli_query($connection->myconn, "START TRANSACTION");

$ckUserQuery = "SELECT * FROM users WHERE u_code ='".$_REQUEST['usercode']."' AND username ='".$_REQUEST['username']."'";
$ckUserResult = mysqli_query($connection->myconn, $ckUserQuery);
if(mysqli_num_rows($ckUserResult) > 0){
    $_SESSION['status'] = 2;
} else {
    $query = "INSERT INTO users (u_name,sur_name,u_code,u_tp_id,username,`password`) VALUES ('".$_REQUEST['name']."','".$_REQUEST['surname']."','".$_REQUEST['usercode']."',2,'".$_REQUEST['username']."','".md5($_REQUEST['password'])."')";
    $result = mysqli_query($connection->myconn, $query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;
}

if ($all_query) {
    mysqli_query($connection->myconn,"COMMIT");
    $_SESSION['status'] = 1;
}else{
    mysqli_query($connection->myconn,"ROLLBACK");
    $_SESSION['status'] = 0;
}
header("Location: user_registraton.php");