<?php
/**
 * Template Name: Contact
 *
 * Allows users to send email to Karen
 * @package freak-child
 */

 add_action('wp_footer', function () {
   echo '<script src="'.get_template_directory_uri().'/assets/scripts/contact.js"></script>';
 }, 20);

 if ($_POST) {
   $message = $_POST['message']."\n\nReply to ".filter_var($_POST['email_address'], FILTER_SANITIZE_EMAIL).".";
   $message_sent = wp_mail('Karen@kjemconsulting.com', 'Message from '.$_POST['first_name'].' at KJEM Consulting', $message);

   exit(json_encode([
     "message" => ($message_sent) ? "Message sent." : "There was a problem sending the message.",
     "status_code" => 200
   ]));
 }

get_header();
?>
<div id="primary-mono" class="content-area <?php do_action('freak_primary-width') ?> page">
  <main id="main" class="site-main" role="main">
    <h1 class="page-description">Send a message.</h1>
    <form id="contact-form" method="POST">
      <input type="text" name="first_name" placeholder="First Name">
      <input type="email" name="email_address" placeholder="Email Address">
      <textarea name="message" placeholder="Your message" cols="40" rows="20"></textarea>
      <button class="contact-submit-button">Send</button>
    </form>
  </main> <!-- #main .site-main -->
</div> <!-- #primary-mono .content-area -->

<div class="sending-snackbar">
  <p>Sending...</p>
</div> <!-- .sending-snackbar -->

<?php get_sidebar() ?>
<?php get_footer() ?>
