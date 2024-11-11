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
    <!-- <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" /> -->
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('uploads/favicon.png'); ?>">
    <!-- Bootstrap Css -->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/register.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?php echo base_url('NewDashboard/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.cdnfonts.com/css/koho-2" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">



</head>

<body>


    <div id="space">
        <div class="account-pages login-3">

            <div class="container-fluid">
                <div class="row add-reg">
                    <div class="col-lg-6 bg-img">
                        <div class="informeson">
                            <div class="typing">
                                <h1>Welcome To <?php echo title; ?></h1>
                            </div>
                            <p class="add-p">Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, blanditiis.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6 col-md-6 col-11 inner-form-wrap p-0">

                        <div class="card overflow-hidden">
                            <div class="card-body">
                                <div class="sub_title">
                                    <a href="<?php echo base_url(); ?>">
                                        <img src=" <?php echo logo; ?>" class="header-brand-img desktop-logo" alt="logo" />
                                    </a>
                                    <h6 class="account1">Register</h6>
                                </div>

                                <div class="">
                                    <div class="panel panel-primary">

                                        <div class="">

                                            <div class="card-body">
                                                <div class="">
                                                    <div class="form-element">
                                                        <?php echo $this->session->flashdata('register_message'); ?>
                                                        <?php echo form_open('register', array('id' => 'registerForm')); ?>
                                                        <div class="form-wrap has-feedback align-items-start mb-0">
                                                            <input type="text" class="form-control" id="sponser_id" placeholder="Sponser ID" value="<?php echo $sponser_id; ?>" name="sponser_id" required />
                                                            <span class="text-danger"><?php echo form_error('sponser_id'); ?></span>
                                                            <span id="sponser_name" class="text-danger"> </span>
                                                        </div>
                                                        <div class="form-wrap has-feedback mb-0 mt-3">
                                                            <input type="text" class="form-control" id="name" placeholder="Name" name="name" required />
                                                            <span class="text-danger"><?php echo form_error('name'); ?></span>
                                                        </div>

                                                        <div class="form-wrap has-feedback mb-0 mt-3">
                                                            <input type="number" class="form-control" id="phone" placeholder="Phone Number" name="phone" required />

                                                            <span class="text-danger"><?php echo form_error('phone'); ?></span>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-wrap has-feedback mt-3">
                                                                    <input type="email" class="form-control" placeholder="Email ID" name="email" value="<?php echo set_value('email'); ?>" required>
                                                                    <span class="text-danger"><?php echo form_error('email'); ?></span>
                                                                </div>

                                                            </div>

                                                            <!-- <div class="col-md-12">
                                                                <div class="form-wrap has-feedback ">
                                                                    <select class="form-control" name='country' id="allcountry">
                                                                        <option value="<?php //echo $conty['name'] 
                                                                                        ?>"><?php //echo $conty['name']; 
                                                                                            ?></option>
                                                                        <?php //foreach ($countries as $key => $cou) { 
                                                                        ?>
                                                                            <option value="<?php //echo $cou['name'] 
                                                                                            ?>"><?php //echo $cou['name'] 
                                                                                                ?></option>
                                                                        <?php  //} 
                                                                        ?>
                                                                    </select>
                                                                    <span class="ion ion-locked form-control-feedback "></span>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-2 pr-0">
                                                                <div class="form-wrap has-feedback ">
                                                                    <input type="text" class="form-control country_code" name="country_code" value="+91" id="countryCode1" readonly>

                                                                </div>
                                                            </div>
                                                
                                                            </div> -->
                                                        </div>


                                                        <div class="form-wrap has-feedback" id="">
                                                            <!-- <button type="submit" value="register" class="btn from-right">Sign Up</button> -->
                                                            <button type="submit" value="register" class="btn from-right">Register</button>
                                                        </div>
                                                        <div class="text-center create-acc mt-3">
                                                            <p class="m-0 add-link">Already have account? <a href="<?php echo base_url('login'); ?>" class="tgreen">Login</a></p>
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
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?php echo base_url('NewDashboard/') ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var selection = document.getElementById("allcountry");
        selection.onchange = function(event) {
            var option = '';
            var countryID = event.target.value;
            if (countryID != '') {
                var url = "<?php echo base_url('Dashboard/Register/countryCode/'); ?>" + countryID;
                fetch(url, {
                        method: "GET",
                    })
                    .then(response => response.json())
                    .then(response => {
                        console.log(response);
                        document.getElementById('countryCode1').value = '+' + response.phonecode;
                    });
            } else {
                document.getElementById('countryCode1').value = '';
            }
        };
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

    <script>
        $(document).on('submit', 'form', function() {
            if (confirm('Are You sure!')) {
                yourformelement.submit();
            } else {
                return false;
            }
        })

        function submitFunction() {
            document.getElementById('subbtn').style.display = 'none';
        }

        $(document).on('blur', '#sponser_id', function() {
            check_sponser();
        })

        function check_sponser() {
            var user_id = $('#sponser_id').val();
            if (user_id != '') {
                var url = '<?php echo base_url("Dashboard/UserInfo/get_user/") ?>' + user_id;
                $.get(url, function(res) {
                    $('#sponser_name').html(res);
                })
            }
        }

        check_sponser();
    </script>

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
                    var csrf_length = document.getElementsByName("csrf_test_name").length;
                    for (let i = 0; i < csrf_length; i++) {
                        document.getElementsByName("csrf_test_name")[i].value = result.token;
                    }

                    if (result.status == '1') {
                        toastr.success(result.message);
                        window.location.href = result.url;
                        //location.reload();
                    } else if (result.status == '2') {
                        toastr.info(result.message)
                    } else {
                        toastr.error(result.message)
                    };
                });
        }
    </script>
</body>

</html>