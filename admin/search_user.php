<?php
session_start();
require_once '../library/config.php';
$connection = new createConnection();
$connection->connectToDatabase();

$user_code = "";
$user_name = "";
if($_REQUEST['user_code'] != ''){
    $user_code = "AND u.u_code LIKE '%".$_REQUEST['user_code']."%'";
}
if($_REQUEST['user_name']!=''){
    $user_code = "AND u.u_name LIKE '%".$_REQUEST['user_name']."%'";
}

$query = "SELECT 
u.u_id, u.u_name, u.sur_name, u.u_code 
FROM 
`users` u
WHERE 
u.status = '0' $user_code $user_code
GROUP BY u.u_id
ORDER BY u.u_name DESC";
$result = mysqli_query($connection->myconn, $query);
if (mysqli_num_rows($result) != 0) {
    ?>
    <table class="table table-striped jambo_table bulk_action table-bordered" id="datatable">
        <thead>
            <tr>
                <th>NAME</th>
                <th>SURNAME</th>
                <th>UCODE</th>
                <th>EDIT</th>
                <th>DELETE</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td style="font-size: 12px;text-align: left"><?php echo $row['u_name']; ?></td>
                    <td style="font-size: 12px;text-align: left"><?php echo $row['sur_name']; ?></td>
                    <td style="font-size: 12px;text-align: center"><?php echo $row['u_code']; ?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
<?php } else { ?>
    <div style="text-align: center;color: red"><span>No Record Found</span></div>
<?php }
$connection->close();
?>