<?php 
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
if ($_SESSION['user_type'] == 'staff') {
$connection = new createConnection();
$connection->connectToDatabase();

$all_query = true;
mysqli_query($connection->myconn, "SET AUTOCOMMIT=0");
mysqli_query($connection->myconn, "START TRANSACTION");

$year = date('Y',strtotime($_REQUEST['month']));
$month = date('m',strtotime($_REQUEST['month']));

$query = "SELECT u_id, u_name, sur_name, u_code FROM users u WHERE u.status = '0' AND u.u_id = '".$_SESSION['user_id']."' AND u.u_tp_id = '2'";
$result = mysqli_query($connection->myconn, $query);
$row_user = mysqli_fetch_assoc($result);

//CK MAIN QUERY
$ck_main_query = "SELECT * FROM user_attendance WHERE u_id ='".$row_user['u_id']."' AND u_code='".$row_user['u_code']."' AND `year`='".$year."' AND `month`='".$month."'";
$ck_main_result = mysqli_query($connection->myconn, $ck_main_query);
if(mysqli_num_rows($ck_main_result) == 0){
    //INSERT ATTENDANCE INFO
    $main_query = "INSERT INTO user_attendance (u_id,u_code,`year`,`month`) VALUES ('".$row_user['u_id']."','".$row_user['u_code']."','".$year."','".$month."')";
    $main_result = mysqli_query($connection->myconn, $main_query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

    $last_attendance_id = mysqli_insert_id($connection->myconn);
} else {
    $row_attendance = mysqli_fetch_assoc($ck_main_result);
    //UPDATE ATTENDANCE INFO
    $update_main_query = "UPDATE user_attendance SET u_id='".$row_user['u_id']."',u_code='".$row_user['u_code']."',`year`='".$year."',`month`='".$month."' WHERE ua_id='".$row_attendance['ua_id']."'";
    $update_main_result = mysqli_query($connection->myconn, $update_main_query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

    $last_attendance_id = $row_attendance['ua_id'];
}

$timeStart= "";
$timeEnd = "";
$night = 0;
$illness = 0;
$vacation = 0;
$holiday = 0;
$notes = "";
if(isset($_REQUEST['item_count']) && $_REQUEST['item_count']>0){
    for($i = 1; $i <= $_REQUEST['item_count']; $i++){

        if($_REQUEST['start_time_'.$i]!=""){
            $timeStart = $_REQUEST['start_time_'.$i];
        } else {
            $timeStart = "";
        }
        if($_REQUEST['end_time_'.$i]!=""){
            $timeEnd = $_REQUEST['end_time_'.$i];
        } else {
            $timeEnd = "";
        }
        if(isset($_REQUEST['night_'.$i]) && $_REQUEST['night_'.$i]== 'on'){
            $night = 1;
        } else {
            $night = 0;
        }
        if(isset($_REQUEST['illness_'.$i]) && $_REQUEST['illness_'.$i]== 'on'){
            $illness = 1;
        } else {
            $illness = 0;
        }
        if(isset($_REQUEST['vacation_'.$i]) && $_REQUEST['vacation_'.$i]== 'on'){
            $vacation = 1;
        } else {
            $vacation = 0;
        }
        if(isset($_REQUEST['holliday_'.$i]) && $_REQUEST['holliday_'.$i]== 'on'){
            $holiday = 1;
        } else {
            $holiday = 0;
        }
        if(isset($_REQUEST['notes_'.$i]) && $_REQUEST['notes_'.$i] != ''){
            $notes = $_REQUEST['notes_'.$i];
        } else {
            $notes = "";
        }

        if($_REQUEST['start_time_'.$i]!="" && $_REQUEST['end_time_'.$i]!=""){
            $ck_details_query = "SELECT * FROM user_attendance_details WHERE u_id='".$row_user['u_id']."' AND ua_id='$last_attendance_id' AND `date`='".$_REQUEST['date_'.$i]."'";
            $ck_details_result = mysqli_query($connection->myconn, $ck_details_query);
            if(mysqli_num_rows($ck_details_result) == 0){
                //INSERT ATT DETAILS
               echo $query_details = "INSERT INTO user_attendance_details (ua_id,u_id,`year`,`month`,`day`,`date`,start_time,end_tme,night,illness,vacation,holiday,notes) VALUES ('$last_attendance_id','".$row_user['u_id']."','".$year."','".$month."','".date('d',strtotime($_REQUEST['date_'.$i]))."','".$_REQUEST['date_'.$i]."','$timeStart','$timeEnd','$night','$illness','$vacation','$holiday','$notes')";
                $result_details = mysqli_query($connection->myconn, $query_details) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;
            } else {
                $row_attendance_details = mysqli_fetch_assoc($ck_details_result);
                //UPDATE ATT DETAILS
                $update_details = "UPDATE user_attendance_details SET ua_id='$last_attendance_id',u_id='".$row_user['u_id']."',`year`='".$year."',`month`='".$month."',`day`='".date('d',strtotime($_REQUEST['date_'.$i]))."',`date`='".$_REQUEST['date_'.$i]."',start_time='$timeStart',end_tme='$timeEnd',night='$night',illness='$illness',vacation='$vacation',holiday='$holiday',notes='$notes' WHERE utd_id = '".$row_attendance_details['utd_id']."'";
                $update_details_result = mysqli_query($connection->myconn, $update_details)  ? null : $all_query = false;
            }
        }
    }
}

if ($all_query) {
    mysqli_query($connection->myconn,"COMMIT");
    $_SESSION['status'] = 1;
}else{
    mysqli_query($connection->myconn,"ROLLBACK");
    $_SESSION['status'] = 0;
}
header("Location: attendance.php");

} else {
  header('Location:../index.php');
}
