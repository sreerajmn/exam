<?php
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<?php
  if ($user->is_Admin())
      redirect_to("index.php");
	  
  if (isset($_POST['submit']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  //Login successful 
  if ($result)
      : redirect_to("index.php");
  endif;
  endif;

?>
<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<title><?php echo $core->company;?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="../theme/<?php echo $core->theme;?>/admin/style/style.css"  type="text/css" />
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/jquery-ui.js"></script>
</head>
<body>
<div class="bgb">
  <div class="container">
    <div class="body body-s">
      <form id="admin_form" name="admin_form" method="post" action="#" class="xform loginform" style="background: #009fda; color: #fff;">
        <header><h2 style="color: #fff; text-align: center;"><?php echo $core->company;?> - Admin Panel</h2></header>
        <section>
          <div class="row">
            <div class="col col-3">
              <label><?php echo lang('USERNAME');?></label>
            </div>
            <div class="col col-9">
              <label class="input"> <i class="icon-prepend icon-user"></i>
                <input placeholder="<?php echo lang('USERNAME');?>"  name="username">
              </label>
            </div>
          </div>
        </section>
        <section>
          <div class="row">
            <div class="col col-3">
              <label><?php echo lang('PASSWORD');?></label>
            </div>
            <div class="col col-9">
              <label class="input"> <i class="icon-prepend icon-lock"></i>
                <input placeholder="**********" type="password" name="password">
              </label>
            </div>
          </div>
        </section>
        <footer>
          <button name="submit" class="button"><?php echo lang('LOGIN');?></button>
          <a href="../index.php" class="button button-secondary">Back to Front</a> </footer>
      </form>
      <div id="message-login-box"><?php print Filter::$showMsg;?></div>
    </div>
    <!-- form holder /--> 
  </div>
  <!-- container /--> 
</div>
</body>
</html>