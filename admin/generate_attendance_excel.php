<?php 
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
if ($_SESSION['user_type'] == 'admin') {
$connection = new createConnection();
$connection->connectToDatabase();

require_once '../library/SimpleXLSXGen.php';

$headings = array();
$data = array();

$from_date = date('Y-m-01',strtotime($_REQUEST['month']));
$to_date = date('Y-m-t',strtotime($_REQUEST['month']));

$start_date = date_create($from_date);
$end_date   = date_create($to_date);

// $interval = DateInterval::createFromDateString('1 day');
// $daterange = new DatePeriod($start_date, $interval ,$end_date);

$daterange = new DatePeriod(new DateTime($from_date),new DateInterval('P1D'),(new DateTime($to_date))->modify("+1 second"));

$headings = array('name' ,'surname', 'idCode', 'month', 'year');
$body = array();

foreach($daterange as $date1){

   $timeStart = 'day_'.$date1->format('d').'_time_start';
   $timeEnd = 'day_'.$date1->format('d').'_time_end';
   $totalTime = 'day_'.$date1->format('d').'_total_time';
   $night = 'day_'.$date1->format('d').'_night';
   $illness = 'day_'.$date1->format('d').'_illness';
   $vacation = 'day_'.$date1->format('d').'_vacation';
   $holiday = 'day_'.$date1->format('d').'_holiday';
   $notes = 'day_'.$date1->format('d').'_notes';

   array_push($headings, $timeStart, $timeEnd, $totalTime, $night, $illness, $vacation, $holiday, $notes);
}

array_push($data, $headings);

/**USER INFO */
$userId = "";
if($_REQUEST['u_id']!= '0'){
    $userId = "AND u.u_id = '".$_REQUEST['u_id']."'";
}
$query = "SELECT u_id, u_name, sur_name, u_code FROM users u WHERE u.status = '0' AND u.u_tp_id = '2' $userId";
$result = mysqli_query($connection->myconn, $query);
while($row = mysqli_fetch_assoc($result)){

    $body = array($row['u_name'], $row['sur_name'], $row['u_code'], date('m',strtotime($_REQUEST['month'])),date('Y',strtotime($_REQUEST['month'])));

    $query_att = "SELECT
        uad.year,
        uad.month,
        uad.date,
        uad.start_time,
        uad.end_tme,
        TIMEDIFF(uad.end_tme, uad.start_time) AS total_time,
        IF(uad.night = 1,'Yes','No') AS night,
        IF(uad.illness = 1,'Yes','No') AS illness,
        IF(uad.vacation = 1,'Yes','No') AS vacation,
        IF(uad.holiday = 1,'Yes','No') AS holiday,
        uad.notes
    FROM
        `user_attendance` ua
    INNER JOIN `user_attendance_details` uad ON
        uad.ua_id = ua.ua_id
    INNER JOIN `users` u ON
        u.u_id = ua.u_id
    WHERE
        ua.ua_status = '0' 
        AND ua.u_id = '".$row['u_id']."' 
        AND ua.year = '".date('Y',strtotime($_REQUEST['month']))."' 
        AND ua.month = '".date('m',strtotime($_REQUEST['month']))."'
    GROUP BY
        uad.utd_id
    ORDER BY
        uad.utd_id ASC";
    $result_att = mysqli_query($connection->myconn, $query_att);
    if(mysqli_num_rows($result_att)>0){
        while($row_att = mysqli_fetch_assoc($result_att)){
            foreach($daterange as $date1){
                if($row_att['date'] == $date1->format('Y-m-d')){
                    $body['day_'.$date1->format('d').'_time_start'] = $row_att['start_time'];
                    $body['day_'.$date1->format('d').'_time_end'] = $row_att['end_tme'];
                    $body['day_'.$date1->format('d').'_total_time'] = $row_att['total_time'];
                    $body['day_'.$date1->format('d').'_night'] = $row_att['night'];
                    $body['day_'.$date1->format('d').'_illness'] = $row_att['illness'];
                    $body['day_'.$date1->format('d').'_vacation'] = $row_att['vacation'];
                    $body['day_'.$date1->format('d').'_holiday'] = $row_att['holiday'];
                    $body['day_'.$date1->format('d').'_notes'] = $row_att['notes'];
                } 
            }
        }
    }
    array_push($data, $body);
}

$filename = 'excel/attendance_excel.xlsx';
$sampleExcelUrl = '../excel/attendance_excel.xlsx';

$xlsx = Shuchkin\SimpleXLSXGen::fromArray($data);
$xlsx->saveAs($sampleExcelUrl);



$response = array();

if (file_exists($filename)) {
    $response['status'] = 1;
} else {
    $response['status'] = 1;
}
$response['url'] = dataFunctions::getBaseUrl(trim($filename));
echo json_encode($response);
exit();

} else {
    header('Location:../index.php');
}
