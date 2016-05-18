<?php
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<?php include("header.php");?>
<div class="row heading-row">
	<h1>Contact Us</h1>
</div><div id="msgresult"></div>
<div class="row xform">
	<section class="col col-8">
	<form id="contact_form" method="post">
		<label class="input"> <i class="icon-prepend icon-user"></i> 
		<input type="text" name="fullname" placeholder="Name">
		</label>
		<div class="note">Write your full name</div>
		<br/><br/>
		<label class="input"> <i class="icon-prepend icon-inbox"></i> 
		<input type="email" name="semail" placeholder="Email">
		</label>
		<div class="message">Write your email address</div>
		<br/><br/>	
		<textarea style="padding: 10px;" name="notes" rows="10"></textarea>
		<div class="note">Please write here if you have any queries about our product and services.</div>
				<input type="hidden" name="recemail" value="<?php echo $core->site_email; ?>">
				<input type="hidden" name="rectitle" value="Contact request from <?php echo $core->company; ?>">
				<input type="hidden" name="doContact" value="1">
		<button class="button" name="dosubmit" type="submit">Submit</button>		
	</form>
	</section>
	<section class="col col-4">
		<p>We welcomes your questions, comments, suggestions, compliments and complaints as one critical way to continuously improve our services to you.</p>
		<ul class="contact-details">
				<li><i class="icon-truck"></i><span><?php echo $core->address . ', ' . $core->city . ', ' . $core->state;?></span><li>
				<li><i class="icon-phone-sign"></i><span><?php echo $core->phone;?></span><li>
				<li><i class="icon-envelope"></i><span><?php echo $core->site_email;?></span><li>
		</ul>
	</section>
</div>
<script type="text/javascript">
// <![CDATA[
  $(document).ready(function () {
      $("#contact_form").submit(function () {
          var str = $(this).serialize();
          showLoader();
          $.ajax({
              type: "POST",
              dataType: 'json',
              url: "sendmail.php",
              data: str,
              success: function (json) {
                  hideLoader();
                  if (json.type == "success") {
                      $("#msgresult").html(json.info);
					  $("#contact_form").hide();
                  } else {
                      $("#msgresult").html(json.message);
                  }
                  $("html, body").animate({
                      scrollTop: 0
                  }, 600);
              }
          });
          return false;
      });
  });
// ]]>
</script>
<?php include("footer.php");?>