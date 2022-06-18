<?php
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
if ($_SESSION['user_type'] == 'admin') {
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

    <link rel="stylesheet" href="../template/css/jquery-confirm.min.css">
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
            <?php require_once('../layout/sidebar.php'); ?>
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
                <h3> <small>Users</small></h3>
              </div>

              <div class="title_right">
                
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><small>Users</small></h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                          <div class="card-box table-responsive">
                            <?php 
                            $query = "SELECT 
                            u.u_id, u.u_name, u.sur_name, u.u_code, u.status 
                            FROM 
                            `users` u
                            WHERE 
                            1
                            GROUP BY u.u_id
                            ORDER BY u.u_name DESC";
                            $result = mysqli_query($connection->myconn, $query);
                            ?>
                            <table class="table table-striped jambo_table bulk_action table-bordered" id="datatable">
                            <thead>
                                <tr>
                                    <th>NAME</th>
                                    <th>SURNAME</th>
                                    <th>UCODE</th>
                                    <th>STATUS</th>
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
                                        <td style="font-size: 12px;text-align: center">
                                          <?php if($row['status'] == '1'){ ?>
                                          <span style="color:red">INACTIVE</span>
                                          <?php } else { ?>
                                            <span style="color:green">ACTIVE</span>
                                          <?php } ?>
                                        </td>
                                        <td style="font-size: 12px;text-align: center">
                                          <?php if($row['status'] == '0'){ ?>
                                          <a style="cursor:pointer;color:#5777ba !important" class="btnup" id="" name="" onClick="window.open('user_edit.php?u_id=<?php echo $row['u_id']; ?>');"><i class="fa fa-pencil" style="font-size: 20px"></i></a>
                                          <?php } ?>
                                        </td>
                                        <td style="font-size: 12px;text-align: center">
                                        <?php if($row['status'] == '0'){ ?>
                                        <a style="cursor:pointer;color:#5777ba !important" class="btnup" id="" name="" onclick="delete_user('<?php echo $row['u_id']; ?>');"><i class="fa fa-trash" style="font-size: 20px;color:red"></i></a>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
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

    <script src="../template/js/jquery-confirm.min.js"></script>
    <script>
      function delete_user(id){
        $.confirm({
            title: 'Confirm?',
            content: 'Are you sure do you want to remove this item ?',
            type: 'green',
            buttons: {
                Okey: {
                    text: 'Yes',
                    btnClass: 'btn-blue',
                    keys: ['enter'],
                    action: function () {
                      $.ajax({
                      url: 'delete_user.php',
                      type: 'POST',
                      data: {
                        u_id: id
                      },
                      success: function(data){
                        console.log(data);
                      }
                    });
                    }
                },
                cancel: {
                    text: 'No',
                    btnClass: 'btn-red',
                    keys: ['esc'],
                    action: function () {

                    }
                }
            }
        });
      }
    </script>                             
  </body>
</html>
<?php 
} else {
  header('Location:../index.php');
}