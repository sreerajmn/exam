<?php
  define("_VALID_PHP", true);

  if (is_dir("../setup"))
      : die("<div style='text-align:center;margin-top:20px'>" 
		  . "<span style='padding: 10px; border: 1px solid #999; background-color:#EFEFEF;" 
		  . "font-family: Verdana; font-size: 12px; margin-left:auto; margin-right:auto;color:red'>" 
		  . "<b>Warning:</b> Please delete setup directory!</span></div>");
  endif;
    
  require_once("init.php");
  if (!$user->is_Admin())
      redirect_to("login.php");
?>
<?php include("header.php");?>
  <!-- Start Content-->
   <?php (Filter::$do && file_exists(Filter::$do.".php")) ? include(Filter::$do.".php") : include("main.php");?>
  <!-- End Content/-->
<?php include("footer.php");?>