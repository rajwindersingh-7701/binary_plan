<?php require_once 'header.php' ?>
<div class="contact-form-area pt-3 pb-100 add-contact" id="contact">
        <div class="container">
            <div class="row">
                <div class="dreamit-section-title text-center up pb-40">
                    <h4>Contact</h4>
                    <h1>Contact <span>with Us</span></h1>
                    <p class="section-text">Cryptocurrencies are used primarily outside existing banking governmental
                        institutions and exchanged</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="contact-icon-box">
                        <div class="contact-icon-thumb">
                            <img src="<?php echo base_url('site-assets');?>/images/resource/contact1.png" alt="">
                        </div>
                        <div class="contact-text">
                            <p><?php echo email ;?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6  col-sm-12">
                    <div class="contact-icon-box">
                        <div class="contact-icon-thumb">
                            <img src="<?php echo base_url('site-assets');?>/images/resource/contact2.png" alt="">
                        </div>
                        <div class="contact-text">
                            <p><?php echo phone ; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6  col-sm-12">
                    <div class="contact-icon-box">
                        <div class="contact-icon-thumb">
                            <img src="<?php echo base_url('site-assets');?>/images/resource/contact3.png" alt="">
                        </div>
                        <div class="contact-text">
                            <p>Join Us on Telegram</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-50">
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="row">
                        <div class="contact-form-box">
                            <div class="contact-form-title">
                                <h3>Get In Touch</h3>
                            </div>
                            <form action="https://formspree.io/f/myyleorq" method="POST" id="dreamit-form">
                                <div class="row">
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <div class="from-box">
                                            <input type="text" name="name" placeholder="Your Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6  col-md-6 col-sm-12">
                                        <div class="from-box">
                                            <input type="text" name="phone" placeholder="Enter E-Mail">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="from-box">
                                            <input type="text" name="mail" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="from-box">
                                            <textarea name="massage" id="massage" placeholder="Massage"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="from-box">
                                    <button type="submit">Send Message</button>
                                </div>
                            </form>
                            <div id="status"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="contact-form-thumb">
                        <img src="<?php echo base_url('site-assets');?>/images/resource/cartoon-bg.png" alt="">
                        <div class="form-inner-thumb bounce-animate3">
                            <img src="<?php echo base_url('site-assets');?>/images/resource/cartoon.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'footer.php' ?>