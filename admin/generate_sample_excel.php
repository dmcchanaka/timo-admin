<?php 
require_once '../library/config.php';
require_once '../library/functions.php';
$connection = new createConnection();
$connection->connectToDatabase();

require_once '../library/SimpleXLSXGen.php';

$headings = array();
$data = array();

$from_date = date('Y-m-01',strtotime($_REQUEST['month']));
$to_date = date('Y-m-t',strtotime($_REQUEST['month']));

$start_date = date_create($from_date);
$end_date   = date_create($to_date);

$interval = DateInterval::createFromDateString('1 day');
$daterange = new DatePeriod($start_date, $interval ,$end_date);

$headings = array('name' ,'surname', 'idCode', 'month', 'year');
$body = array();

foreach($daterange as $date1){

   $timeStart = 'day_'.$date1->format('d').'_time_start';
   $timeEnd = 'day_'.$date1->format('d').'_time_end';
   $night = 'day_'.$date1->format('d').'_night';
   $illness = 'day_'.$date1->format('d').'_illness';
   $vacation = 'day_'.$date1->format('d').'_vacation';
   $holiday = 'day_'.$date1->format('d').'_holiday';
   $notes = 'day_'.$date1->format('d').'_notes';

   array_push($headings, $timeStart, $timeEnd, $night, $illness, $vacation, $holiday, $notes);
}

array_push($data, $headings);

/**USER INFO */
$query = "SELECT u_name, sur_name, u_code FROM users u WHERE u.status = '0' AND u.u_tp_id = '2'";
$result = mysqli_query($connection->myconn, $query);
while($row = mysqli_fetch_assoc($result)){
    $body = array($row['u_name'], $row['sur_name'], $row['u_code'], date('m',strtotime($_REQUEST['month'])),date('Y',strtotime($_REQUEST['month'])));
    array_push($data, $body);
}

$filename = 'excel/sample_excel.xlsx';
$sampleExcelUrl = '../excel/sample_excel.xlsx';

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


