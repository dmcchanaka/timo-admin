<?php
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
if ($_SESSION['user_type'] == 'staff') {
$connection = new createConnection();
$connection->connectToDatabase();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Timo Attendance</title>

    <!-- Bootstrap -->
    <link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link href="../template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->

    <link href="../template/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="../template/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="../template/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="../template/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="../template/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../template/build/css/custom.min.css" rel="stylesheet">
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="../admin/index.php" class="site_title"><i class="fa fa-paw"></i> <span>Attendance</span></a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="../images/user.png" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2><?php echo $_SESSION['user_name']; ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br />

                    <!-- sidebar menu -->
                    <?php require_once('../layout/staff_sidebar.php'); ?>
                    <!-- /sidebar menu -->

                    <!-- /menu footer buttons -->
                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                            <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Lock">
                            <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
                    </div>
                    <!-- /menu footer buttons -->
                </div>
            </div>

            <!-- top navigation -->
            <?php require_once('../layout/header.php'); ?>
            <!-- /top navigation -->

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3> <small>Attendance</small></h3>
                        </div>

                        <div class="title_right">

                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 ">
                            <div class="x_panel">
                                <?php if(isset($_SESSION['status'])){ ?>
                                    <?php if($_SESSION['status'] == 1){ ?>
                                    <div class="alert alert-success alert-dismissible " role="alert" id="success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <strong>Success!</strong> Record has been successfully added
                                    </div>
                                    <?php } ?>
                                    <?php if($_SESSION['status'] == 0){ ?>
                                    <div class="alert alert-danger alert-dismissible " role="alert" id="error">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <strong>Opps!</strong> Record has not been successfully added
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                                <div class="x_title">
                                    <h2><small>Attendance form</small></h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <form class="form-horizontal form-label-left" method="post" action="update_attendance.php">
                                        <?php 
                                        $query = "SELECT 
                                        ua.ua_id, u.u_name, ua.year, ua.month 
                                        FROM 
                                        `user_attendance` ua
                                        INNER JOIN 
                                        `user_attendance_details` uad ON uad.ua_id = ua.ua_id
                                        INNER JOIN
                                        `users` u ON u.u_id = ua.u_id
                                        WHERE 
                                        ua.ua_status = '0' AND ua.ua_id = '".$_REQUEST['att_id']."' 
                                        AND ua.u_id = '".$_SESSION['user_id']."'
                                        GROUP BY ua.ua_id";
                                        $result = mysqli_query($connection->myconn, $query);
                                        $row = mysqli_fetch_assoc($result);
                                        ?>
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">MONTH</label>
                                                        <div class="col-sm-9">
                                                        <input type="text" value="<?php 
                                                        $monthNum  = $row['month'];
                                                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                        $monthName = $dateObj->format('F');
                                                        echo $row['year'].' '.$monthName; 
                                                        ?>" class="form-control" placeholder="Month" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                            <div id="attendance_info" style="text-align: center" class="table-responsive">
                                            <?php
                                            $from_date = date('Y-m-01',strtotime($row['year'].'-'.$row['month']));
                                            $to_date = date('Y-m-t',strtotime($row['year'].'-'.$row['month']));

                                            $start_date = date_create($from_date);
                                            $end_date   = date_create($to_date);

                                            $interval = DateInterval::createFromDateString('1 day');
                                            $daterange = new DatePeriod($start_date, $interval ,$end_date);
                                            ?>
                                            <input type="hidden" id="year" name="year" value="<?php echo $row['year']; ?>" />
                                            <input type="hidden" id="month" name="month" value="<?php echo $row['month']; ?>" />
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

                                                        $query_details = "SELECT 
                                                        uad.year, 
                                                        uad.month, 
                                                        uad.date, 
                                                        uad.start_time, 
                                                        uad.end_tme,
                                                        TIMEDIFF(uad.end_tme, uad.start_time) as total_time,
                                                        uad.night, 
                                                        uad.illness, 
                                                        uad.vacation, 
                                                        uad.holiday, 
                                                        uad.notes
                                                        FROM 
                                                        `user_attendance` ua
                                                        INNER JOIN 
                                                        `user_attendance_details` uad ON uad.ua_id = ua.ua_id
                                                        INNER JOIN
                                                        `users` u ON u.u_id = ua.u_id
                                                        WHERE 
                                                        ua.ua_status = '0'
                                                        AND ua.ua_id = '".$_REQUEST['att_id']."'
                                                        AND u.u_id = '".$_SESSION['user_id']."'
                                                        AND uad.date = '".$date1->format('Y-m-d')."'
                                                        GROUP BY uad.utd_id
                                                        ORDER BY uad.utd_id ASC";
                                                        $result_details = mysqli_query($connection->myconn, $query_details);
                                                        $row = mysqli_fetch_assoc($result_details);
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" id="date_<?php echo $count; ?>" name="date_<?php echo $count; ?>" value="<?php echo $date1->format('Y-m-d'); ?>" readonly />
                                                        </td>
                                                        <td>
                                                            <input type="time" id="start_time_<?php echo $count; ?>" name="start_time_<?php echo $count; ?>" value="<?php echo $row['start_time'] ?>" />
                                                        </td>
                                                        <td>
                                                            <input type="time" id="end_time_<?php echo $count; ?>" name="end_time_<?php echo $count; ?>" value="<?php echo $row['end_tme'] ?>" />
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="night_<?php echo $count; ?>" name="night_<?php echo $count; ?>" <?php if(isset($row['night']) && $row['night'] == 1){ echo 'checked'; } else {echo ''; }; ?> />
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="illness_<?php echo $count; ?>" name="illness_<?php echo $count; ?>" <?php if(isset($row['illness']) && $row['illness'] == 1){ echo 'checked'; } else {echo ''; }; ?> />
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="vacation_<?php echo $count; ?>" name="vacation_<?php echo $count; ?>" <?php if(isset($row['vacation']) && $row['vacation'] == 1){ echo 'checked'; } else {echo ''; }; ?> />
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" id="holliday_<?php echo $count; ?>" name="holliday_<?php echo $count; ?>" <?php if(isset($row['holiday']) && $row['holiday'] == 1){ echo 'checked'; } else {echo ''; }; ?> />
                                                        </td>
                                                        <td>
                                                            <textarea id="notes_<?php echo $count; ?>" name="notes_<?php echo $count; ?>" rows="1"><?php if(isset($row['notes'])){ echo $row['notes']; } ?></textarea>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    <input type="hidden" id="item_count" name="item_count" value="<?php echo $count; ?>" />
                                                    <input type="hidden" id="attendance_id" name="attendance_id" value="<?php echo $_REQUEST['att_id']; ?>" />
                                                </tbody>
                                            </table>
                                            <div class="form-group" style="text-align:left">
                                                <div class="col-md-9 col-sm-9">
                                                    <button type="reset" class="btn btn-danger">Reset</button>
                                                    <button type="submit" class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- /page content -->

    <!-- footer content -->
    <?php require_once('../layout/footer.php'); ?>
    <!-- /footer content -->
    </div>
    </div>

    <!-- jQuery -->
    <script src="../template/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../template/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FastClick -->
    <script src="../template/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../template/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="../template/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="../template/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../template/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../template/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../template/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../template/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../template/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../template/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../template/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../template/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../template/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../template/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../template/vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="../template/vendors/jszip/dist/jszip.min.js"></script>
    <script src="../template/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../template/vendors/pdfmake/build/vfs_fonts.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../template/build/js/custom.min.js"></script>
    <script type="text/javascript">
        function load_month(){
            if($('#month').val() == ''){
                alert('please select month');
            } else {
                $('#attendance_info').html('<p><img width="100px" src="../images/loader.gif"  /></p>');
                $('#attendance_info').load("attendance_month_info.php",{
                    'month':$('#month').val()
                });
            }
        }
    </script>
</body>

</html>
<?php 
unset($_SESSION['status']);
} else {
  header('Location:../index.php');
}