<?php include '../app/views/templates/header.php';?>

      <!-- contact section start -->
      <div class="contact_section layout_padding">
         <div class="container">
            <!-- Display Messages -->
            <?php if (isset($_SESSION['success'])): ?>
               <div class="alert alert-success" style="margin-bottom: 20px;">
                  <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
               </div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['errors'])): ?>
               <div class="alert alert-danger" style="margin-bottom: 20px;">
                  <?php foreach ($_SESSION['errors'] as $error): ?>
                     <p><?php echo $error; ?></p>
                  <?php endforeach; unset($_SESSION['errors']); ?>
               </div>
            <?php endif; ?>
            
            <div class="row">
               <div class="col-md-4">
                  <div class="contact_main">
                     <h1 class="contact_taital">Contact Us</h1>
                     <form id="contactForm">
                        <div class="form-group">
                           <input type="text" class="email-bt" placeholder="Name" name="name" id="name" required>
                        </div>
                        <div class="form-group">
                           <input type="email" class="email-bt" placeholder="Email" name="email" id="email" required>
                        </div>
                        <div class="form-group">
                           <input type="tel" class="email-bt" placeholder="Phone Number" name="phone" id="phone" required>
                        </div>
                        <div class="form-group">
                           <textarea class="massage-bt" placeholder="Message" rows="5" id="message" name="message" required></textarea>
                        </div>
                        <button type="button" id="sendToWa" class="main_bt" style="background: none; border: none; cursor: pointer; padding: 0;">SEND</button>
                     </form>
                  </div>
               </div>
               <div class="col-md-8">
                  <div class="location_text">
                     <ul>
                        <li>
                           <a href="https://maps.google.com/?q=Desa+Malangsari,+Tanjunganom" target="_blank">
                           <span class="padding_left_10 active"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Desa Malangsari, Tanjunganom</a>
                        </li>
                        <li>
                           <a href="https://wa.me/6281233286308">
                           <span class="padding_left_10"><i class="fa fa-phone" aria-hidden="true"></i></span>Call : +62 812-3328-6308
                           </a>
                        </li>
                        <li>
                           <a href="mailto:toko.mbah.meth@gmail.com">
                           <span class="padding_left_10"><i class="fa fa-envelope" aria-hidden="true"></i></span>Email : toko.mbah.meth@gmail.com
                           </a>
                        </li>
                     </ul>
                  </div>
                  <div class="mail_main">
                     <h3 class="newsletter_text">Newsletter</h3>
                     <form action="/contact/subscribe" method="POST" style="display: flex; gap: 10px;">
                        <div class="form-group" style="flex: 1;">
                           <input type="email" class="update_mail" placeholder="Enter Your Email" name="subscribe_email" required style="width: 100%; padding: 10px;">
                        </div>
                        <button type="submit" class="subscribe_bt" style="background: none; border: none; cursor: pointer; padding: 0;"><a href="#" onclick="return false;">Subscribe</a></button>
                     </form>
                  </div>
                  <div class="footer_social_icon">
                     <ul>
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- contact section end -->

      <script>
         (function(){
            var waNumber = '6281233286308'; // target WhatsApp number (without +)
            var btn = document.getElementById('sendToWa');
            if (!btn) return;

            btn.addEventListener('click', function () {
               var name = (document.getElementById('name') || {}).value || '';
               var email = (document.getElementById('email') || {}).value || '';
               var phone = (document.getElementById('phone') || {}).value || '';
               var message = (document.getElementById('message') || {}).value || '';

               // basic trim
               name = name.trim();
               email = email.trim();
               phone = phone.trim();
               message = message.trim();

               // simple validation
               if (!name || !email || !phone || !message) {
                  alert('Please fill all fields before sending.');
                  return;
               }

               var text = '';
               text += 'Nama: ' + name + '\n';
               text += 'Email: ' + email + '\n';
               text += 'No. Telp: ' + phone + '\n\n';
               text += 'Pesan: ' + message;

               var url = 'https://wa.me/' + waNumber + '?text=' + encodeURIComponent(text);

               // open in new tab when possible
               window.location.href = url;
            });
         })();
      </script>

      <?php include '../app/views/templates/footer.php'; ?>
