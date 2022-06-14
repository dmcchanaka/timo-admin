<?php
session_start();
require_once '../library/config.php';
require_once '../library/functions.php';
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
    <link href="../template/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet" />
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
                <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Download sample excel sheet</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <p>Please click download button to download excel sheet related to corresponding month</p><br/>
                            <div class="alert alert-success alert-dismissible " role="alert" id="success" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong> Done
                            </div>
                            <div class="alert alert-danger alert-dismissible " role="alert" id="error" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                </button>
                                <strong>Opps!</strong> Please try again
                            </div>
                            <form class="form-horizontal form-label-left">
                                <div class="form-group row">
                                    <label class="control-label col-md-3 col-sm-3 ">Month</label>
                                    <div class="col-md-9 col-sm-9 ">
                                        <input type="month" id="month" name="month" class="form-control" placeholder="Month">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-9 col-sm-9  offset-md-3">
                                        <button type="reset" class="btn btn-primary">Reset</button>
                                        <button type="button" class="btn btn-success" onclick="exportExcel();">Download</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>File uploader</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <p>Select excel file to the box below for upload or click to select file.</p>
                                <div id="alert_div">
                                    <div class="alert alert-success alert-dismissible " role="alert" id="alert" style="display: none;">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                        </button>
                                        <strong><span id="alert_header_msg"></strong>&nbsp;<span id="alert_msg"></span>
                                    </div>
                                </div>
                                
                                <form action="attendance_upload.php" method="POST" id="attendance_upload_form">
                                    <div class="form-group row">
                                        <label for="exampleFormControlFile1" class="col-md-3 col-sm-3">Example file input</label>
                                        <div class="col-md-9 col-sm-9 ">
                                            <input type="file" class="form-control-file" id="attendance_file" name="attendance_file">
                                        </div>
                                    </div>
                                    <!-- <div class="custom-file form-group row">
                                        <input type="file" class="custom-file-input" id="attendance_file" name="attendance_file" required>
                                        <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                                        <div class="invalid-feedback">Example invalid custom file feedback</div>
                                    </div> -->
                                    <div class="form-group" id="process" style="display:none;">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-9 col-sm-9  offset-md-3">
                                            <button type="reset" class="btn btn-primary">Reset</button>
                                            <button type="button" class="btn btn-success" onclick="importExcel();" id="upload_att">Upload</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
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
    <script lang="js">
        function exportExcel(){
            if($('#month').val()==""){
                alert('Please select Correct Month')
            } else {
                $.ajax({
                    url: 'generate_sample_excel.php',
                    data: {
                        'month':$('#month').val()
                    },
                    success: function(data) {
                        console.log(data);
                        var arr = JSON.parse(data);
                        if(arr.status == '1'){
                            $('#success').show('slow');
                            $('#error').hide('slow');
                            window.open(arr.url,'_blank' );
                        } else {
                            $('#success').hide('slow');
                            $('#error').show('slow');
                        }
                    }
                });
            }
        }

        function importExcel(){
            var data = new FormData(document.getElementById("attendance_upload_form"));

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = ((evt.loaded / evt.total) * 100);
                            var percentComplete = parseFloat(percentComplete).toFixed(2);
                            $(".progress-bar").width(percentComplete + '%');
                            $(".progress-bar").html(percentComplete+'%');
                        }
                    }, false);
                    return xhr;
                },
                type: "POST",
                url: "attendance_upload.php",
                data: data,
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function () {
                    $('#alert').hide('slow');
                    var button = document.getElementById('upload_att');
                    button.innerText = 'SUBMITTING !!!';
                    $("#upload_att").attr("disabled", "disabled");
                    $("#upload_att").prop('disabled', true); // disable button
                    
                    $('#process').css('display', 'block');
                },
                success: function (data) {
                    console.log(data);
                    
                    if (data === '1') {
                        $('#alert').show('slow');
                        var button = document.getElementById('upload_att');
                        button.innerText = 'SUBMITTED';
                        document.getElementById('alert_msg').innerHTML = 'Attendance Has Been Submited Successfully';
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    } else {
                        $('#alert').show('slow');
                        document.getElementById('alert_msg').innerHTML = 'Attendance Has Not Been Submited Successfully';
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    }
                    setTimeout(function(){
                        $('#alert_msg').html('');
                    }, 5000);
                }
            });
        }
    </script>
</body>

</html>