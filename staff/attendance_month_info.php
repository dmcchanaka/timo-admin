<?php 
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
if ($_SESSION['user_type'] == 'staff') {
$connection = new createConnection();
$connection->connectToDatabase();

$from_date = date('Y-m-01',strtotime($_REQUEST['month']));
$to_date = date('Y-m-t',strtotime($_REQUEST['month']));

$start_date = date_create($from_date);
$end_date   = date_create($to_date);

$interval = DateInterval::createFromDateString('1 day');
$daterange = new DatePeriod($start_date, $interval ,$end_date);
?>
<table class="table table-striped jambo_table bulk_action" id="route_details">
    <thead>
        <tr>
            <th>DATE</th>
            <th>START TIME</th>
            <th>END TIME</th>
            <th>NIGHT</th>
            <th>ILLNESS</th>
            <th>VACATION</th>
            <th>HOLLIDAY</th>
            <th>NOTES</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $count = 0;
        foreach($daterange as $date1){
            $count++;
        ?>
        <tr>
            <td>
                <input type="text" id="date_<?php echo $count; ?>" name="date_<?php echo $count; ?>" value="<?php echo $date1->format('Y-m-d'); ?>" readonly />
            </td>
            <td>
                <input type="time" id="start_time_<?php echo $count; ?>" name="start_time_<?php echo $count; ?>" />
            </td>
            <td>
                <input type="time" id="end_time_<?php echo $count; ?>" name="end_time_<?php echo $count; ?>" />
            </td>
            <td>
                <input type="checkbox" id="night_<?php echo $count; ?>" name="night_<?php echo $count; ?>" />
            </td>
            <td>
                <input type="checkbox" id="illness_<?php echo $count; ?>" name="illness_<?php echo $count; ?>" />
            </td>
            <td>
                <input type="checkbox" id="vacation_<?php echo $count; ?>" name="vacation_<?php echo $count; ?>" />
            </td>
            <td>
                <input type="checkbox" id="holliday_<?php echo $count; ?>" name="holliday_<?php echo $count; ?>" />
            </td>
            <td>
                <textarea id="notes_<?php echo $count; ?>" name="notes_<?php echo $count; ?>" rows="1"></textarea>
            </td>
        </tr>
        <?php } ?>
        <input type="hidden" id="item_count" name="item_count" value="<?php echo $count; ?>" />
    </tbody>
</table>
<div class="form-group" style="text-align:left">
    <div class="col-md-9 col-sm-9">
        <button type="reset" class="btn btn-danger">Reset</button>
        <button type="submit" class="btn btn-success">Submit</button>
    </div>
</div>
<?php 
} else {
  header('Location:../index.php');
}