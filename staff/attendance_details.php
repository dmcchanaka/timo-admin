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
	<link rel="icon" href="images/favicon.ico" type="image/ico" />

    <title>Timo Attendance</title>

    <!-- Bootstrap -->
    <link href="../template/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../template/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../template/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../template/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="../template/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="../template/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
    <!-- bootstrap-daterangepicker -->
    <link href="../template/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../template/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="nav-md footer_fixed">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
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
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="../logout.php">
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
                        <h3><small>Attendance Details</small></h3>
                    </div>

                    <div class="title_right"></div>
                </div>
                <div class="clearfix"></div>

                <div class="row" style="display: block;">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <form class="form-horizontal form-label-left" method="post">
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
                                    GROUP BY ua.ua_id";
                                    $result = mysqli_query($connection->myconn, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">USER</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" value="<?php echo $row['u_name'] ?>" readonly />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">YEAR MONTH</label>
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
                                    </div>
                                </form>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="attendance_info" style="text-align: center" class="table-responsive">
                                <?php 
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
                                GROUP BY uad.utd_id
                                ORDER BY uad.utd_id ASC";
                                $result_details = mysqli_query($connection->myconn, $query_details);
                                if (mysqli_num_rows($result_details) != 0) {
                                    ?>
                                    <table class="table table-striped jambo_table bulk_action" id="route_details">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>START TIME</th>
                                                <th>END TIME</th>
                                                <th>TOTAL TIME</th>
                                                <th>NIGHT</th>
                                                <th>ILLNESS</th>
                                                <th>VACATION</th>
                                                <th>HOLLIDAY</th>
                                                <th>NOTES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php while ($row = mysqli_fetch_assoc($result_details)) { ?>
                                            <tr>
                                                <!-- <td style="font-size: 12px;text-align: center"><?php echo $row['year']; ?></td>
                                                <td style="font-size: 12px;text-align: center"><?php
                                                    $monthNum  = $row['month'];
                                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                                    echo $monthName = $dateObj->format('F'); 
                                                ?></td> -->
                                                <td style="font-size: 12px;text-align: left"><?php 
                                                $fmt = datefmt_create("de_DE", IntlDateFormatter::FULL, IntlDateFormatter::NONE, 'Europe/Berlin', IntlDateFormatter::GREGORIAN);
                                                echo datefmt_format($fmt , strtotime($row['date']));
                                                ?></td>
                                                <td style="font-size: 12px;text-align: center"><?php echo $row['start_time']; ?></td>
                                                <td style="font-size: 12px;text-align: center"><?php echo $row['end_tme']; ?></td>
                                                <td style="font-size: 12px;text-align: center"><?php echo $row['total_time']. ' hours'; ?></td>
                                                <td style="font-size: 12px;text-align: center"><?php 
                                                if($row['night']==1){ ?>
                                                    <span class="badge badge-success">YES</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger">NO</span>
                                                <?php } ?>
                                                </td>
                                                <td style="font-size: 12px;text-align: center"><?php 
                                                if($row['illness']==1){ ?>
                                                    <span class="badge badge-success">YES</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger">NO</span>
                                                <?php } ?>
                                                </td>
                                                <td style="font-size: 12px;text-align: center"><?php 
                                                if($row['vacation']==1){ ?>
                                                    <span class="badge badge-success">YES</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger">NO</span>
                                                <?php } ?>
                                                </td>
                                                <td style="font-size: 12px;text-align: center"><?php 
                                                if($row['holiday']==1){ ?>
                                                    <span class="badge badge-success">YES</span>
                                                <?php } else { ?>
                                                    <span class="badge badge-danger">NO</span>
                                                <?php } ?>
                                                </td>
                                                <td style="font-size: 12px;text-align: center"><?php echo $row['notes']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                    </table>
                                <?php } else { ?>
                                    <div style="text-align: center;color: red"><span>No Record Found</span></div>
                                <?php }
                                ?>
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
    <!-- Chart.js -->
    <script src="../template/vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="../template/vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../template/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="../template/vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="../template/vendors/skycons/skycons.js"></script>
    <!-- Flot -->
    <script src="../template/vendors/Flot/jquery.flot.js"></script>
    <script src="../template/vendors/Flot/jquery.flot.pie.js"></script>
    <script src="../template/vendors/Flot/jquery.flot.time.js"></script>
    <script src="../template/vendors/Flot/jquery.flot.stack.js"></script>
    <script src="../template/vendors/Flot/jquery.flot.resize.js"></script>
    <!-- Flot plugins -->
    <script src="../template/vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
    <script src="../template/vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
    <script src="../template/vendors/flot.curvedlines/curvedLines.js"></script>
    <!-- DateJS -->
    <script src="../template/vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="../template/vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="../template/vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="../template/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="../template/vendors/moment/min/moment.min.js"></script>
    <script src="../template/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="../template/build/js/custom.min.js"></script>
	<script type="text/javascript">
        
    </script>
  </body>
</html>
<?php 
} else {
    header('Location:../index.php');
}