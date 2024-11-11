<?php include 'header.php'
?>

<?php

$user_info = userinfo();
$bank_info = bankinfo();

?>
<style>
  .table_content {
    color: black !important;
  }
</style>

<head>
  <style>
    .outer-content {
      background-color: #fff;
      border-radius: 10px;
      border: 1px #d5d5d5 solid;

      position: relative;
      overflow: hidden;
    }

    .photo {
      margin-top: 30px;
      display: inline-block;
    }

    .id-card-detail {
      display: inline-block;
      text-align: left;
      margin-top: 20px;
      margin-bottom: 30px;
    }

    .id-card-detail h5 {
      color: #000;
      font-size: 14px;
      font-weight: 500;
      margin-bottom: 0px;
      line-height: 30px;
    }

    a.img-add img {
      width: 100px;
      margin-top: 30px;
    }

    .sign_img img {
      float: right;
      max-width: 150px;
    }
  </style>
</head>

<body>
  <main class="main-content app-content mt-0">
    <div id="content">
      <div class="hidden-print">
        <div style="cursor:hand;">
          <div class="container text-center" style="text-align:center">
            <!-- <input type="button" onClick="window.print()" value="Print" style="margin-top:20px" title="Take a print of icard"> -->
            <!-- <button class="btn btn-secondary" onclick="window.print()">Print</button> -->
          </div><!--<div class="container text-center">-->
        </div>
      </div>
      <br>

      <div class="col-md-4 m-auto">

        <div class="outer-content">
          <div id="pdf-content">

            <div class="position-relative">
              <div class="text-center " style="text-align: center;">
                <div class="top_img">
                  <img src="<?php echo base_url('uploads/card_top.png'); ?>" alt="">
                </div>

                <div class="text-center">
                  <div class="id-card-detail">
                    <h5>Name : <span style="color: #1e8709;"><?php echo $user_info->name; ?></span></h5>
                    <h5>Id No. : <span style="color: #1e8709;"><?php echo $user_info->user_id; ?></span> </h5>
                    <h5>Doj : <span style="color: #1e8709;"><?php echo $user_info->created_at; ?></span> </h5>
                    <h5>Mob No : <span style="color: #1e8709;"><?php echo $user_info->phone; ?></span></h5>
                    <h5>Email : <span style="color: #1e8709;"><?php echo $user_info->email; ?></span></h5>
                  </div>
                </div>
                <div class="sign_img">
                  <img src="<?php echo base_url('uploads/sign.png'); ?>" alt="">
                </div>
                <div class="top_img">
                  <img src="<?php echo base_url('uploads/card_btm.png'); ?>" alt="">
                </div>

              </div>
            </div>
          </div>


          <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
          <div class="text-center">
            <button id="captureButton" class="btn btn-primary mt-5"><i class="fa fa-download">Download</i></button>
          </div>
        </div>
  </main>
</body>

</html>
<?php include_once 'footer.php'; ?>
<script>
  var buttonElement = document.querySelector("#btn-generate");
  buttonElement.addEventListener('click', function() {
    var pdfContent = document.getElementById("pdf-content").innerHTML;
    var windowObject = window.open();

    windowObject.document.write(pdfContent);

    windowObject.print();
    windowObject.close();
  });
</script>

<script>
  document.getElementById("captureButton").addEventListener("click", function() {
    // Capture the content as an image
    html2canvas(document.getElementById("content")).then(function(canvas) {
      // Create a link element for downloading the screenshot
      var downloadLink = document.createElement("a");
      downloadLink.href = canvas.toDataURL("image/png"); // Convert canvas to base64 image data
      downloadLink.download = "<?php echo title; ?>.png"; // Specify the desired filename

      // Trigger a click event on the link element
      document.body.appendChild(downloadLink);
      downloadLink.click();
      document.body.removeChild(downloadLink);
    });
  });
</script>