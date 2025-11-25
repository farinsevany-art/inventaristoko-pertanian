<?php include '../app/views/templates/header.php'; ?>

<div class="contact_section layout_padding">
    <div class="container">
        <div class="row">

            <!-- LEFT -->
            <div class="col-md-4">
                <div class="contact_main">
                    <h1 class="contact_taital">Contact Us</h1>

                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" class="email-bt" placeholder="Name" name="name">
                        </div>
                        <div class="form-group">
                            <input type="email" class="email-bt" placeholder="Email" name="email">
                        </div>
                        <div class="form-group">
                            <input type="text" class="email-bt" placeholder="Phone Number" name="phone">
                        </div>
                        <div class="form-group">
                            <textarea class="massage-bt" placeholder="Message" rows="5" name="message"></textarea>
                        </div>

                        <button type="submit" class="main_bt">SEND</button>
                    </form>

                </div>
            </div>
            <div class="col-md-8">
                <div class="location_text">
                    <ul>
                        <li>
                            <a href="https://www.google.com/maps?q=Desa+Malangsari,+Tanjunganom,+Nganjuk,+Jawa+Timur" target="_blank">
                                <span class="padding_left_10 active">
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                </span>
                                Desa Malangsari, Kecamatan Tanjunganom, Kabupaten Nganjuk, Jawa Timur
                            </a>
                        </li>

                        <li>
                            <a href="https://wa.me/6281233286308" target="_blank">
                                <span class="padding_left_10">
                                    <i class="fa fa-phone" aria-hidden="true"></i>
                                </span>
                                WhatsApp : +62 812-3328-6308
                            </a>
                        </li>

                        <li>
                            <a href="mailto:tokombahmeth@gmail.com">
                                <span class="padding_left_10">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                                Email : tokombahmeth@gmail.com
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mail_main">
                    <h3 class="newsletter_text">Newsletter</h3>
                    <div class="form-group">
                        <textarea class="update_mail" placeholder="Enter Your Email"></textarea>
                        <div class="subscribe_bt"><a href="#">Subscribe</a></div>
                    </div>
                </div>

                <div class="footer_social_icon">
                    <ul>
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <iframe 
                    src="https://www.google.com/maps?q=Desa+Malangsari,+Tanjunganom,+Nganjuk,+Jawa+Timur&hl=id&z=15&output=embed" 
                    width="100%" 
                    height="350" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>

    </div>
</div>

<?php include '../app/views/templates/footer.php'; ?>
