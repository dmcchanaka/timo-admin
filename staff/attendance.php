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
                                        <form class="form-horizontal form-label-left" method="post" action="save_attendance.php">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-sm-3 col-form-label">MONTH</label>
                                                        <div class="col-sm-9">
                                                            <input type="month" class="form-control" id="month" name="month" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-md-9 col-sm-9  offset-md-3">
                                                            <button type="button" class="btn btn-success" onclick="load_month()">LOAD</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3"></div>
                                            </div>
                                            <div id="attendance_info" style="text-align: center" class="table-responsive"></div>
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