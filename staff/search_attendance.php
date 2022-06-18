<?php
session_start();
require_once '../library/config.php';
if ($_SESSION['user_type'] == 'staff') {
$connection = new createConnection();
$connection->connectToDatabase();

$user = "";
$year = "";
$month = "";
if($_REQUEST['u_id'] != '0'){
    $user = "AND u.u_id ='".$_REQUEST['u_id']."'";
}
if($_REQUEST['month']!=''){
    $year = "AND ua.year ='".date('Y',strtotime($_REQUEST['month']))."'";
    $month = "AND ua.month ='".date('m',strtotime($_REQUEST['month']))."'";
}

$query = "SELECT 
ua.ua_id, u.u_name, u.sur_name, ua.year, ua.month 
FROM 
`user_attendance` ua
INNER JOIN 
`user_attendance_details` uad ON uad.ua_id = ua.ua_id
INNER JOIN
`users` u ON u.u_id = ua.u_id
WHERE 
ua.ua_status = '0' $user $year $month
AND u.u_id = '".$_SESSION['user_id']."'
GROUP BY ua.ua_id
ORDER BY ua.ua_id DESC";
$result = mysqli_query($connection->myconn, $query);
if (mysqli_num_rows($result) != 0) {
    ?>
    <table class="table table-striped jambo_table bulk_action table-bordered" id="route_details">
        <thead>
            <tr>
                <th>NAME</th>
                <th>SURNAME</th>
                <th>YEAR</th>
                <th>MONTH</th>
                <th>VIEW</th>
                <th>EDIT</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td style="font-size: 12px;text-align: left"><?php echo $row['u_name']; ?></td>
                    <td style="font-size: 12px;text-align: left"><?php echo $row['sur_name']; ?></td>
                    <td style="font-size: 12px;text-align: center"><?php echo $row['year']; ?></td>
                    <td style="font-size: 12px;text-align: center"><?php
                        $monthNum  = $row['month'];
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        echo $monthName = $dateObj->format('F'); 
                     ?></td>
                    <td>
                        <a style="cursor:pointer;color:#5777ba !important" class="btnup" id="" name="" onClick="window.open('attendance_details.php?att_id=<?php echo $row['ua_id']; ?>');"><i class="fa fa-list-ul" style="font-size: 20px"></i></a>
                    </td>
                    <td>
                        <a style="cursor:pointer;color:#5777ba !important" class="btnup" id="" name="" onClick="window.open('attendance_edit.php?att_id=<?php echo $row['ua_id']; ?>');"><i class="fa fa-pencil" style="font-size: 20px"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div style="text-align: center;color: red"><span>No Record Found</span></div>
<?php }
$connection->close();
} else {
    header('Location:../index.php');
}
?>