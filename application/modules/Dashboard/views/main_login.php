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
    <!-- <script src="<?php echo base_url('NewDashboard/') ?>js/custom.js"></script> -->

    <!-- App Css-->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/register.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- EXTRA LINKS -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head><style>
    form-control .eyebx {
    position: relative;
}
</style>

<body>

    <div id="">
        <div class="account-pages ">
            <div class="container">
                <div class="row justify-content-center">
               
                    <div class="col-xl-5 col-lg-6 col-md-8 col-12">

                        <div class="card">
                            <div class="card-body tab-got">
                                <div class="sub_title">
                                    <a href="<?php echo base_url(); ?>">
                                        <img src=" <?php echo logo; ?>" class="header-brand-img desktop-logo" alt="logo" />
                                    </a>
                                    <h6 class="account1">Login</h6>
                                </div>

                                <div class="col-sm-12 col-md-12 text-white text-center mt-4">
                                    <h5 style="text-transform: uppercase;color: #000;font-weight: bold;font-size: 22px;"></h5>
                                    <!-- <p class="m-0">Login to Your Personal Account</p> -->
                                </div>
                                <div class="">
                                    <div class="panel panel-primary">

                                        <p style="color:red;text-align: center;"><?php echo $this->session->flashdata('message'); ?></p>
                                        <?php echo form_open(base_url('login'), array('id' => 'mainLogin')); ?>
                                        <!-- <input type="hidden" class="form-control" id="wallet_address" name="wallet_address"> -->
                                        <div class="panel-body card-body">
                                            <div class="form-wrap">
                                                <input type="text" class="form-control" id="" placeholder="Enter User ID" name="user_id" value="<?php echo set_value('user_id'); ?>">
                                                <span class="ion ion-locked form-control-feedback "></span>
                                            </div>

                                            <div class="password-field eyebx position-relative mb-3">
                                                <input type="password" id="fakePassword" class="form-control " placeholder="Enter Password" name="password" value="<?php echo set_value('password'); ?>">
                                                <span class="ion ion-locked form-control-feedback eye-btn"><i id="toggler"class="far fa-eye"></i></span>
                                            </div>

                                            <div class="details password-form">
                                                <div class="d-flex align-item-center justify-content-between position-relative">
                                                    <div class="form-check-inline m-0">
                                                        <input id="deviceremember" type="checkbox" class="mr-2">
                                                        <label class="form-check-label" for="deviceremember">Remember Me</label>
                                                    </div>
                                                    <a href="<?php echo base_url('dashboard/forget-password') ?>" class="forgot_pw">Forgot password?</a>
                                                </div>
                                                <div class="form-group has-feedback">
                                                    <button type="button" id="deposit" onclick="submit_form(this, 'mainLogin')" value="login" class="button-three">Login</button>
                                                </div>
                                                <div class="text-center create-acc mt-3">

                                                    <p class="m-0">Still no account? <a href="<?php echo base_url(); ?>register" class="tgreen">Create new account</a></p>

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

        <!-- JAVASCRIPT -->
        <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/simplebar/simplebar.min.js"></script>

        <!-- EXTRA LINKS -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</html>
<script>
    async function submit_form(evt, id) {

        var url = document.getElementById(id).action;
        var element = document.getElementById(id);
        fetch(url, {
                method: "POST",
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: new FormData(element),
            })
            .then(response => response.json())
            .then(result => {
                toastr.options.newestOnTop = true;
                toastr.options.progressBar = true;
                toastr.options.closeButton = true;
                toastr.options.preventDuplicates = true;

                if (result.status == '1') {
                    toastr.success(result.message);
                    setTimeout(function() {
                        window.location.href = result.url;
                    }, 1000);
                } else if (result.status == '0') {
                    toastr.info(result.message)
                } else {
                    toastr.error(result.message)
                };
            });
    }
</script>


<script>
    var password = document.getElementById('fakePassword');
var toggler = document.getElementById('toggler');
showHidePassword = () => {
if (password.type == 'password') {
password.setAttribute('type', 'text');
toggler.classList.add('fa-eye-slash');
} else {
toggler.classList.remove('fa-eye-slash');
password.setAttribute('type', 'password');
}
};
toggler.addEventListener('click', showHidePassword);
    </script>
</body>

</html>