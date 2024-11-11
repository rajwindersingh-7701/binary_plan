<?php
if (http == 0) {
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('uploads/favicon.png'); ?>">
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/register.css" rel="stylesheet" type="text/css" />


    <!-- App Css-->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link href="https://fonts.cdnfonts.com/css/koho-2" rel="stylesheet">

</head>

<body>

    <div id="space">


        <div class="account-pages ">
            <div class="container-fluid ">
                <div class="row justify-content-center">
              
                
                <div class="col-xl-4 col-lg-5 col-md-6 col-12">

                        <div class="card">
                            <div class="card-body tab-got">
                            <div class="sub_title">
                                <a href="<?php echo base_url(); ?>">
                                    <img src=" <?php echo logo; ?>" class="header-brand-img desktop-logo" alt="logo" />
                                </a>
                                <h6 class="account1">Forgot Password</h6>
                            </div>

                            <div class="">
                                <div class="panel panel-primary">
                                    <?php echo form_open(base_url('dashboard/forget-password')); ?>
                                    <p style="color:red;text-align: center;"><?php echo $this->session->flashdata('message'); ?></p>
                                    <div class="panel-body card-body">
                                        <div class="details password-form">
                                            <fieldset>
                                                <div class="form-group">
                                                    <div class="label-area">
                                                    </div>
                                                    <div class="row-holder">

                                                        <input id="SiteURL" type='text' name='email' maxlength='50' class="form-control  mt-3" placeholder="Enter Email ID" />
                                                    </div>

                                                </div>
                                                <div class="form-field">

                                                    <input type="text" class="form-control" placeholder="Enter User ID" name="user_id" value="<?php echo set_value('user_id'); ?>" style="margin-top: 17px;">
                                                    <span class="ion ion-locked form-control-feedback "></span>
                                                </div>

                                                <div class="text-start ">

                                                    <p>Still no account? <a href="<?php echo base_url(); ?>register" class="tgreen">Create new account</a></p>

                                                </div>

                                                <div class="form-group has-feedback">
                                                    <button id="signupBtn" type="submit" class="button-three" name='Submit' value='Login'>Forgot Password</button>
                                                </div>



                                            </fieldset>
                                        </div>
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                            </div>
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>
    
    





    <!-- JAVASCRIPT -->
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/node-waves/waves.min.js"></script>

    <script src="<?php echo base_url('NewDashboard/') ?>assets/js/app.js"></script>


    <script>
        $(document).on('blur', '#sponser_id', function() {
            check_sponser();
        })

        function check_sponser() {
            var user_id = $('#sponser_id').val();
            if (user_id != '') {
                var url = '<?php echo base_url("Dashboard/User/get_user/") ?>' + user_id;
                $.get(url, function(res) {
                    $('#errorMessage').html(res);
                })
            }
        }
        check_sponser();
        $(document).on('submit', '#RegisterForm', function() {
            if (confirm('Please Check All The Fields Before Submit')) {
                yourformelement.submit();
            } else {
                return false;
            }
        })
    </script>

    <script>
        const maxWidth = window.screen.width;
        const maxHeight = window.screen.height;

        function Random(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min) + min);
        }

        function Shadows(amount) {
            let shadow = "";
            for (let i = 0; i < amount; i++) {
                shadow += Random(0, maxWidth) + "px " + Random(0, maxHeight) + "px " + "rgb(255," + Random(0, 256) + "," + Random(0, 256) + "), ";
            }
            shadow += Random(0, maxWidth) + "px " + Random(0, maxHeight) + "px " + "rgb(255," + Random(0, 256) + "," + Random(0, 256) + ")";
            return (shadow);
        }

        for (let i = 1; i <= 3; i++) {
            document.documentElement.style.setProperty('--shadows' + i, Shadows(100));
        }
    </script>
</body>

</html>