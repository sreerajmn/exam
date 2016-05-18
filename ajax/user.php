<?php
  define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  /* Registration */
  if (isset($_POST['doRegister'])):
      if (intval($_POST['doRegister']) == 0 || empty($_POST['doRegister'])):
          redirect_to("../register.php");
      endif;
      $user->register();
  endif;
?>
<?php
  /* Registration */
  if (isset($_POST['doInvoice'])):
      if (intval($_POST['doInvoice']) == 0 || empty($_POST['doInvoice'])):
          redirect_to("../account.php?do=courses");
      endif;
	  $user->addInvoice();
  endif;

  if (isset($_POST['doEnrol'])):
      if (intval($_POST['doEnrol']) == 0 || empty($_POST['doEnrol'])):
          redirect_to("../account.php?do=courses");
      endif;
	  $user->addEnrol();
  endif;

  if (isset($_POST['doQuize'])):
      if (intval($_POST['doQuize']) == 0 || empty($_POST['doQuize'])):
          redirect_to("../account.php?do=courses");
      endif;
	  $user->doQuize();
  endif;
?>
<?php
  /* Password Reset */
  if (isset($_POST['passReset'])):
      if (intval($_POST['passReset']) == 0 || empty($_POST['passReset'])):
          redirect_to("../index.php");
      endif;
      $user->passReset();
  endif;
?>
<?php
  /* Check Username */
  if (isset($_POST['checkUsername'])):

      $username = trim(strtolower($_POST['checkUsername']));
      $username = $db->escape($username);

      $sql = "SELECT username FROM users WHERE username = '" . $username . "' LIMIT 1";
      $result = $db->query($sql);
      $num = $db->numrows($result);

      print $num;

  endif;
?>
<?php
  /* == Load Gateways == */
  if (isset($_POST['loadgateway'])):
	  if (isset($_POST['doservice'])):
          $gate_id = intval($_POST['loadgateway']);
		  $amount = floatval($_POST['amount']);
		  $row = $core->getRowById("gateways", $gate_id, false, false);
		  $row2 = $core->getRowById("estimator", FIlter::$id, false, false);
		  $form_url = BASEPATH . "gateways/" . $row->dir . "/eform.tpl.php";
		  (file_exists($form_url)) ? include ($form_url) : Filter::msgError(lang('FBILL_ERR2'));
	  endif;
 endif;
?>