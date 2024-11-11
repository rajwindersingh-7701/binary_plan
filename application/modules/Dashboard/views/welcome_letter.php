<?php include_once 'header.php'; ?>

<style>
	.main-body {
		text-align: center;
		border: 2px #ebe9e9 solid;
		padding: 40px 0;
		background: #fff;
		border-radius: 8px;
		box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	}

	.main-body h2 {
		border-bottom: 2px #000 solid;
		display: inline;
		font-weight: bold;
		color: #000;
		font-size: 30px;
	}

	.letter-body {
		width: 70%;
		text-align: left;
		margin: 0px auto;
		margin-top: 30px;
		color: #000;
	}

	.letter-body span {
		display: block;
		margin-top: 20px;
		font-size: 18px;
	}

	.letter-body h5 {
		font-size: 20px;
		font-weight: 600;
		margin-top: 25px;
	}

	.letter-body p {
		font-size: 16px;
		line-height: 35px;
		font-weight: inherit;
		margin-top: 20px;
		font-family: system-ui;
	}

	.letter-body-footer h6 {
		font-weight: normal;
		font-size: 20px;
	}

	img.welcome-logo {
		margin-right: 40px;
		max-width: 150px;
	}

	.img-style {
		display: flex;
		align-items: center;
		justify-content: end;
	}

	span.add-title {
		font-size: 18px;
		font-weight: 500;
	}

	.letter-body-footer h3 {
		font-size: 22px;
		font-weight: 500;
		text-transform: uppercase;
	}

	@media screen and (max-width:767px) {
		.letter-body {
			width: 95%;
		}

	}

	.welcome-letter-img img {
		width: 200px;
		height: 200px;
	}

	#sig-canvas {
		border: 2px dotted #CCCCCC;
		border-radius: 15px;
		cursor: crosshair;
	}

	span.add-title.add-height {
		line-height: 1.5;
	}

	@media (max-width:375px) {
		.welcome-letter-img img {
			width: 150px;
			height: 150px;
		}

		span.add-title {
			font-size: 17px;
		}
	}

	@media (max-width:320px) {

		span.add-title {
			font-size: 14px;
			font-weight: bold;
		}

		.welcome-letter-img img {
			width: 100px;
			height: 100px;
		}

		.letter-body h5 {
			font-size: 18px;
			font-weight: 500;

		}

		.letter-body p {
			font-size: 14px;
		}

		.letter-body-footer h3 {
			font-size: 18px;
		}
	}
</style>
<div id="content">

	<div class="main-content app-content mt-0">
		<div class="container">
			<div class="row" id="printarea">
				<div class="col-xl-12 main-body">
					<h2>Business Welcome Letter</h2>
					<div class="letter-body">
						<div class="row">
							<div class="col-md-6 col-6">

								<span class="add-title add-height">To:<?php echo strtoupper($userData['name']); ?><br>
									User ID :<?php echo strtoupper($userData['user_id']); ?><br>
									Mobile :<?php echo strtoupper($userData['phone']); ?><br>
									Address :<?php echo strtoupper($userData['address']); ?><br>
									Package :<?php echo strtoupper($userData['package_amount']); ?></span>

							</div>
							<div class="col-md-6 col-6 welcome-letter-img text-right img-style">

								<a class="add-imges" href="<?php echo base_url('dashboard/'); ?>">
									<img src="<?php echo logo; ?>" class="header-brand-img desktop-logo" alt="logodc" />
									<img src="<?php echo logo; ?>" class="header-brand-img light-logo1" alt="logo" />
								</a>

								<?php if (!empty($userinfo['profile_image'])) { ?>
									<img style="max-width:205px;" src="<?php echo base_url('uploads/' . $userinfo['profile_image']); ?>" clas="img-fluid">
								<?php } else { ?>
									<!-- <a href="<?php //echo base_url('Dashboard/Profile'); 
													?>" class="btn btn-danger">Upload Profile Image</a> -->
								<?php } ?>
							</div>
						</div>
						<span class="add-title">From:<?php echo title; ?></span>
						<h5>Subject:</h5>
						<span class="add-title">Dear: <b><?php echo $userData['name']; ?><b></span>
						<p>Company ,would like to inform you Have purchase the product by <?php echo title ?> Marketing. It is a tremendous Honor to be able to work with an experience company such as yours.</p>
						<p>We are aware you that you are capable of guite innovative sales strategies and would like you to handle that. We would also like to remind you that the agreed upon budget still needs to be Product Followed. Everything mentioned in the contract.</p>
						<p>In case of queries feel free to contact <?php echo title ?> we look forward to a fruitful business partnership with Company</P>
						<p><b>Note: You have paid Rs.<?php echo strtoupper($userData['package_amount']); ?> for product thuse amount are non refundable and company has provide the product.</b></p>
						<div class="letter-body-footer">
							<h3>Sincerely</h3>
							<span><b><?php echo title ?></b></span>

						</div>
					</div>
					<div class="signaure text-right">
						<?php //if (!empty($userinfo['signature'])) { 
						?>
						<!-- <canvas id="sig-canvas">	 -->
						<!-- <img src="<?php //echo base_url('uploads/' . $userinfo['signature']); 
										?>" clas="img-fluid" style="width:200px;  margin-right: 30px;"> -->
						<?php //} else { 
						?>
						<!-- <a href="<?php //echo base_url('Dashboard/Profile'); 
										?>" class="btn btn-danger">Upload Signature</a> -->
						<?php //} 
						?>
					</div>
					<!-- <?php //if (!empty($userinfo['signature']) && !empty($userinfo['profile_image'])) { 
							?> -->
					<!-- <button target="_blank" id="btnp" class="btn btn-default" onclick="window.print()"><i class="fas fa-print"></i> Download</button> -->

					<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script> -->
				</div>

				<!-- <button id="captureButton"> <i class="fa fa-download"></i></button> -->

				<?php //} else { 
				?>
				<!-- <button type="button" class="btn btn-danger">Upload Profile Image & Signature</button> -->
				<!-- <a href="<?php //echo base_url('Dashboard/Profile'); 
								?>" class="btn btn-danger">Please Upload Signature</a> -->

				<?php //} 
				?>
				<!-- <img src="<?php //echo base_url(logo); 
								?>" class="welcome-logo" style="max-width:150px;float:right;"> -->
			</div>
		</div>

		<div class="text-center">
			<!-- <a class="btn btn-secondary" id="mainImage_download" href="<?php //echo base_url('Dashboard/Settings/welcomeLetter') ;
																			?>" target="_self" download>Download </a> -->
			<!-- <script>
				document.getElementById("captureButton").addEventListener("click", function() {
					// Capture the content as an image
					html2canvas(document.getElementById("content")).then(function(canvas) {
						// Create a link element for downloading the screenshot
						var downloadLink = document.createElement("a");
						downloadLink.href = canvas.toDataURL("image/png"); // Convert canvas to base64 image data
						downloadLink.download = "Rptyre_WelcomeLetter.png"; // Specify the desired filename

						// Trigger a click event on the link element
						document.body.appendChild(downloadLink);
						downloadLink.click();
						document.body.removeChild(downloadLink);
					});
				});
			</script> -->
			<!-- <button class="btn btn-primary mt-4" onclick="window.print()">Download</button> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
			<div class="text-center">
				<button id="captureButton" class="btn btn-primary mt-5"><i class="fa fa-download">Download</i></button>
			</div>

		</div>
	</div>
</div>





<?php include_once 'footer.php';
?>

<script>
	function pageprint() {
		var divToPrint = document.getElementById('printarea');
		var newWin = window.open('', 'Print-Window');
		newWin.document.open();
		newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');
		newWin.document.close();
		setTimeout(function() {
			newWin.close();
		}, 10);

		//$("#printarea").print();
		//window.print() ;
	}
</script>
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
			downloadLink.download = "RptyreIcard.png"; // Specify the desired filename

			// Trigger a click event on the link element
			document.body.appendChild(downloadLink);
			downloadLink.click();
			document.body.removeChild(downloadLink);
		});
	});
</script>
<script>
	$(document).on('click', '.zmimg', function() {
		var image = $(this).data('image');
		$('#mainImage').attr('src', image);
		$('#exampleModal1').modal('show');
		$('#mainImage_download').attr('href', image);

	})
</script>