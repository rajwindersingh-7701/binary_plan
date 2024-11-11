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
  <!-- App Css-->
  <link href="<?php echo base_url('NewDashboard/') ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
  <link href="https://fonts.cdnfonts.com/css/koho-2" rel="stylesheet">

  <link href="<?php echo base_url('NewDashboard/') ?>assets/css/successview.css" rel="stylesheet" type="text/css" />


</head>

<body>

      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-lg-5 col-md-6 col-12">
            <div class="card">
              <div class="card-body">
                <div class="top_logo">
                  <a href="/" class="logo logo-admin">
                    <img src="<?php echo logo; ?>" class="logo_img" alt="logo">
                  </a>
                </div>
           

              <h5 class="welcome-txt">Welcome Back</h5>
              <h2 class="page-title"><i>Registration Successfull</i></h2>

              <?php
              echo '<h5 class="mainboxes">' . $message . '</h5>';
              ?>
              <div class="mt-2">
                <a class="button-three" href="<?php echo base_url('login'); ?>">Clik Here to Login</a>
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
</body>

</html>