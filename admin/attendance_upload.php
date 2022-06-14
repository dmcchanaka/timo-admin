<?php 
require_once '../library/config.php';
require_once '../library/functions.php';
$connection = new createConnection();
$connection->connectToDatabase();

ini_set('error_reporting', E_ALL);
ini_set('display_errors', true);
require_once '../library/SimpleXLSX.php';

if (isset($_FILES['attendance_file'])) {
    $header_values = $rows = [];
    if ($xlsx = SimpleXLSX::parse($_FILES['attendance_file']['tmp_name'])) {
        
        foreach ($xlsx->rows() as $k => $r) {
            if ($k === 0) {
                $header_values = $r;
                continue;
            }
            if (count($r) === count($header_values)) {
                $rows[] = array_combine($header_values, $r);
            }
        }

        // echo date("H:i:s", ExcelToPHP($rows[0]['day_01_time_start']));

        // echo '<pre>';
        // print_r($rows);
        // echo '</pre>';

        $all_query = true;
        mysqli_query($connection->myconn, "SET AUTOCOMMIT=0");
        mysqli_query($connection->myconn, "START TRANSACTION");

        if(sizeof($rows)>0){

            $last_attendance_id = NULL;

            $timeStart = NULL;
            $timeEnd = NULL;
            $night = NULL;
            $illness = NULL;
            $vacation = NULL;
            $holiday = NULL;
            $notes = NULL;

            foreach($rows AS $user){

                $query = "SELECT u_id, u_name, sur_name, u_code FROM users u WHERE u.status = '0' AND u.u_code = '".$user['idCode']."' AND u.u_tp_id = '2'";
                $result = mysqli_query($connection->myconn, $query);
                $row_user = mysqli_fetch_assoc($result);

                //CK MAIN QUERY
                $ck_main_query = "SELECT * FROM user_attendance WHERE u_id ='".$row_user['u_id']."' AND u_code='".$user['idCode']."' AND `year`='".$user['year']."' AND `month`='".$user['month']."'";
                $ck_main_result = mysqli_query($connection->myconn, $ck_main_query);
                if(mysqli_num_rows($ck_main_result) == 0){

                    //INSERT ATTENDANCE INFO
                    $main_query = "INSERT INTO user_attendance (u_id,u_code,`year`,`month`) VALUES ('".$row_user['u_id']."','".$user['idCode']."','".$user['year']."','".$user['month']."')";
                    $main_result = mysqli_query($connection->myconn, $main_query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

                    $last_attendance_id = mysqli_insert_id($connection->myconn);
                } else {
                    $row_attendance = mysqli_fetch_assoc($ck_main_result);
                    //UPDATE ATTENDANCE INFO
                    $update_main_query = "UPDATE user_attendance SET u_id='".$row_user['u_id']."',u_code='".$user['idCode']."',`year`='".$user['year']."',`month`='".$user['month']."' WHERE ua_id='".$row_attendance['ua_id']."'";
                    $update_main_result = mysqli_query($connection->myconn, $update_main_query) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;

                    $last_attendance_id = $row_attendance['ua_id'];
                }

                //INSERT ATTENDANCE DETAILS
                $from_date = date('Y-m-01',strtotime($user['year'] . '-' . $user['month']));
                $to_date = date('Y-m-t',strtotime($user['year'] . '-' . $user['month']));

                $start_date = date_create($from_date);
                $end_date   = date_create($to_date);

                $interval = DateInterval::createFromDateString('1 day');
                $daterange = new DatePeriod($start_date, $interval ,$end_date);
                foreach($daterange as $date1){
                    
                    if($user['day_'.$date1->format('d').'_time_start']!=""){
                        $timeStart = date("H:i:s", ExcelToPHP($user['day_'.$date1->format('d').'_time_start']));
                    } else {
                        $timeStart = "";
                    }
                    if($user['day_'.$date1->format('d').'_time_end']!=""){
                        $timeEnd = date("H:i:s", ExcelToPHP($user['day_'.$date1->format('d').'_time_end']));
                    } else {
                        $timeEnd = "";
                    }

                    $night = ($user['day_'.$date1->format('d').'_night'])?$user['day_'.$date1->format('d').'_night']:0;
                    $illness = ($user['day_'.$date1->format('d').'_illness'])?$user['day_'.$date1->format('d').'_illness']:0;
                    $vacation = ($user['day_'.$date1->format('d').'_vacation'])?$user['day_'.$date1->format('d').'_vacation']:0;
                    $holiday = ($user['day_'.$date1->format('d').'_holiday'])?$user['day_'.$date1->format('d').'_holiday']:0;
                    $notes = $user['day_'.$date1->format('d').'_notes'];

                    if($user['day_'.$date1->format('d').'_time_start']!="" && $user['day_'.$date1->format('d').'_time_end']!=""){
                        $ck_details_query = "SELECT * FROM user_attendance_details WHERE u_id='".$row_user['u_id']."' AND ua_id='$last_attendance_id' AND `date`='".$date1->format('Y-m-d')."'";
                        $ck_details_result = mysqli_query($connection->myconn, $ck_details_query);
                        if(mysqli_num_rows($ck_details_result) == 0){
                            //INSERT ATT DETAILS
                           echo $query_details = "INSERT INTO user_attendance_details (ua_id,u_id,`year`,`month`,`day`,`date`,start_time,end_tme,night,illness,vacation,holiday,notes) VALUES ('$last_attendance_id','".$row_user['u_id']."','".$user['year']."','".$user['month']."','".$date1->format('d')."','".$date1->format('Y-m-d')."','$timeStart','$timeEnd','$night','$illness','$vacation','$holiday','$notes')";
                            $result_details = mysqli_query($connection->myconn, $query_details) or die(mysqli_error($connection->myconn)) ? null : $all_query = false;
                        } else {
                            $row_attendance_details = mysqli_fetch_assoc($ck_details_result);
                            //UPDATE ATT DETAILS
                            $update_details = "UPDATE user_attendance_details SET ua_id='$last_attendance_id',u_id='".$row_user['u_id']."',`year`='".$user['year']."',`month`='".$user['month']."',`day`='".$date1->format('d')."',`date`='".$date1->format('Y-m-d')."',start_time='$timeStart',end_tme='$timeEnd',night='$night',illness='$illness',vacation='$vacation',holiday='$holiday',notes='$notes' WHERE utd_id = '".$row_attendance_details['utd_id']."'";
                            $update_details_result = mysqli_query($connection->myconn, $update_details)  ? null : $all_query = false;
                        }
                    }
                }
                
            }
        }

        if ($all_query) {
            mysqli_query($connection->myconn,"COMMIT");
            echo 1;
        }else{
            mysqli_query($connection->myconn,"ROLLBACK");
            echo 0;
        }
        
    } else {
        echo SimpleXLSX::parseError();
    }
}



function ExcelToPHP($dateValue = 0, $ExcelBaseDate = 1900) {
    if ($ExcelBaseDate == 1900) {
        $myExcelBaseDate = 25569;
        //    Adjust for the spurious 29-Feb-1900 (Day 60)
        if ($dateValue < 60) {
            --$myExcelBaseDate;
        }
    } else {
        $myExcelBaseDate = 24107;
    }

    // Perform conversion
    if ($dateValue >= 1) {
        $utcDays = $dateValue - $myExcelBaseDate;
        $returnValue = round($utcDays * 86400);
        if (($returnValue <= PHP_INT_MAX) && ($returnValue >= -PHP_INT_MAX)) {
            $returnValue = (integer) $returnValue;
        }
    } else {
        $hours = round($dateValue * 24);
        $mins = round($dateValue * 1440) - round($hours * 60);
        $secs = round($dateValue * 86400) - round($hours * 3600) - round($mins * 60);
        $returnValue = (integer) gmmktime($hours, $mins, $secs);
    }

    // Return
    return $returnValue;
}

// if($_FILES['attendance_file']['name']) {
//     $arrFileName = explode('.', $_FILES['attendance_file']['name']);
//     if ($arrFileName[1] == 'xlsx') {
//         $handle = fopen($_FILES['attendance_file']['tmp_name'], "r");

//         $excelUrl = $_FILES['attendance_file']['tmp_name'];
//         $header_values = $rows = [];
//         $headers = [];
//         if ($xlsx = SimpleXLSX::parse($excelUrl)) {
//             foreach ($xlsx->rows() as $k => $r) {
//                 if ($k === 0) {
//                     $header_values = $r;
//                     continue;
//                 }
//                 if (count($r) === count($header_values)) {
//                     $rows[] = array_combine($header_values, $r);
//                     $new_array[] = $r;
//                 }
//             }

//             echo '<pre>';
//             print_r($rows);
//             echo '</pre>';
//         } else {
//             echo SimpleXLSX::parseError();
//         }
//     }
// }