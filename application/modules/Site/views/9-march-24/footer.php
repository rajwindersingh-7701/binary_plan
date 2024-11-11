
        <!-- Footer section -->
        <footer class="footer-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-content">
                           <img src="<?php echo base_url('assets/');?>img/logo.png" alt="" class="footer-logo">
                        </div>
                   
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-content">
                            <h2>About Property</h2>
                        </div>
                        <div class="footer-item">
                            <p class="mb-15">Embark on a journey into the realm of dried fruits, where nature's goodness meets culinary delight. </p>


                            <ul class="footer-links">
                                <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                <li><a href="#"><i class="icofont-twitter"></i></a></li>
                                <li><a href="#"><i class="icofont-linkedin"></i></a></li>
                                <li><a href="#"><i class="icofont-instagram"></i></a></li>
                                <li><a href="#"><i class="icofont-dribble"></i></a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="menu-item">
                            <div class="footer-content">
                                <h2>Useful Links</h2>
                            </div>
                            <ul class="quick-menu">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </div>   
                    </div>
 
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="footer-content">
                            <h2>Contact</h2>
                        </div>
                        <div class="footer-info">
                           
                            <ul class="contact-info">
                                <li>
                                    <i class="flaticon-phone-call"></i> 
                                    Call Us: +91 <?php echo phone;?>
                                </li>
                                <li>
                                    <i class="flaticon-mail"></i>
                                    <a href="#"><?php echo email;?></a>
                                </li>
                                <li>
                                    <i class="flaticon-facebook-placeholder-for-locate-places-on-maps"></i>
                                    5560 Lorem Ave, San Diego, <br> USA
                                </li>
                            </ul>
                        </div>
                    </div>
                
                </div>
            </div>
        </footer>
        <!-- End Footer section -->

        <!-- Footer-bottom section -->
        <div class="footer-bottom">
            <div class="container">
                <div class="bottom-content">
                    <p>Copyright 2023 <?php echo title;?>. All Rights Reserved.</p>
                </div>
            </div>
        </div>
        <!-- End Footer-bottom section -->

        
        <!-- jQuery Min JS -->
        <script src="<?php echo base_url('assets/');?>js/jquery.min.js"></script>
        <!-- Prpper JS -->
        <script src="<?php echo base_url('assets/');?>js/popper.min.js"></script>
        <!-- Bootstrap Min JS -->
        <script src="<?php echo base_url('assets/');?>js/bootstrap.min.js"></script>
        <!-- Owl Min JS -->
        <script src="<?php echo base_url('assets/');?>js/owl.carousel.min.js"></script>
        <!-- Mixitup Min JS -->
        <script src="<?php echo base_url('assets/');?>js/jquery.mixitup.min.js"></script>
        <!-- Magnific Min JS -->
        <script src="<?php echo base_url('assets/');?>js/jquery.magnific-popup.min.js"></script>
        <!-- WOW JS -->
        <script src="<?php echo base_url('assets/');?>js/wow.min.js"></script>
        <!-- AjaxChimp Min JS -->
        <script src="<?php echo base_url('assets/');?>js/jquery.ajaxchimp.min.js"></script>
        <!-- Form Validator Min JS -->
        <script src="<?php echo base_url('assets/');?>js/form-validator.min.js"></script>
        <!-- Contact Form Min JS -->
        <script src="<?php echo base_url('assets/');?>js/contact-form-script.js"></script>
        <!-- Main JS -->
        <script src="<?php echo base_url('assets/');?>js/main.js"></script>
        <script>
    $('.dry-fruits').owlCarousel({
      center: false,
      loop: true,
      autoplay: true,
      margin: 30,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 4
        },
        1200: {
          items: 6
        }
      }
    });
  </script>
    </body>
</html>