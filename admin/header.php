<?php  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
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
<link rel="stylesheet" href="../assets/style/jquery-ui.css" type="text/css" />
<script type="text/javascript">
var SITEURL = "<?php echo $core->site_url; ?>";
var THEME = "<?php echo THEME;?>";
</script>
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/jquery-ui.js"></script>
<script src="../assets/js/jquery.ui.touch-punch.js"></script>
<script src="../assets/js/jquery.wysiwyg.js"></script>
<script src="../assets/js/global.js"></script>
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/nicescroll.js" type="text/javascript" ></script>
<script src="../assets/js/modernizr.mq.js" type="text/javascript" ></script>
<script src="../assets/js/checkbox.js"></script>
<script src="../assets/fancybox/jquery.fancybox.pack.js"></script>
<script src="../assets/fancybox/helpers/jquery.fancybox-media.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/fancybox/jquery.fancybox.css" media="screen" />
<script type="text/javascript">
jQuery(document).ready(function($){
    var windowH = $(window).height();
    var wrapperH = $('#bitset').height();
    if(windowH > wrapperH) {                            
        $('#bitset').css({'height':($(window).height())+'px'});
    }                                                                               
    $(window).resize(function(){
        var windowH = $(window).height();
        var wrapperH = $('#bitset').height();
        var differenceH = windowH - wrapperH;
        var newH = wrapperH + differenceH;
        var truecontentH = $('#truecontent').height();
        if(windowH > truecontentH) {
            $('#bitset').css('height', (newH)+'px');
        }

    })          
});
var SITEURL = "<?php echo $core->site_url; ?>";
var THEME = "<?php echo THEME;?>";
</script>
<script src="<?php echo THEME;?>/admin/js/menu.js"></script>
<?php if(file_exists("../plugins/" . Filter::$do . "/" . $core->theme . "_style.css")):?>
<link href="../plugins/<?php echo Filter::$do;?>/<?php echo $core->theme;?>_style.css" rel="stylesheet" type="text/css" />
<?php endif;?>
</head>
<body data-smooth-scrolling="1">
<div id="loader" style="display:none"></div>
<div class="bg">
  <div class="container">
  
<div class="row grid_24"  id="crumbs">
	
	<div class="col grid_5">
		<div class="header-logo"><a href="index.php"><?php echo ($core->logo) ? '<img src="'.SITEURL.'/uploads/'.$core->logo.'" alt="'.$core->company.'" class="logo"/>': $core->company;?></a></div>
	</div>
	<div class="col grid_19">
		<section class="row">
		  <div class="col grid_16">
			<h2>
			  <?php include("crumbs.php");?>
			</h2>
		  </div>
		  <div class="col grid_8"> 
			<!-- User Panel -->
			<div id="userpanel"> <img src="../thumbmaker.php?src=<?php echo UPLOADURL;?>/avatars/<?php echo ($user->avatar) ? $user->avatar : "blank.png";?>&amp;w=40&amp;h=40&amp;s=1&amp;a=t1" alt="" title="" /> <span><?php echo lang('MENU_WELCOME');?> <?php echo $user->username;?>!</span>
			  <ul class="profilenav">
				<li> <a href="#" id="showhide">
				  <p><?php echo lang('MENU_MA');?></p>
				  </a>
				  <div id="settingslist">
					<ul class="sub">
					  <li><i class="icon-reorder pull-left"></i> <a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $user->uid;?>">Account Settings</li>
					  <li><i class="icon-signout pull-left"></i> <a href="logout.php"><?php echo lang('MENU_LOGOUT');?></a></li>
					</ul>
				  </div>
				</li>
			  </ul>
			</div>
			<!-- User Panel /-->  
		  </div>
		</section>
	</div>
</div>
	
<div class="row grid_24 clearfix">
	<div id="bitset" class="col grid_5">
	<div id="truecontent">
		<!-- Header -->
		<header id="header" class="clearfix">
			<nav class="cbp-hsmenu-wrapper" id="cbp-hsmenu-wrapper">
			  <div class="cbp-hsinner">
				<ul class="cbp-hsmenu">
				  
				  <li> <a href="#">User Manager</a>
					<ul class="cbp-hssubmenu">
					  <li><a href="index.php?do=users"><i class="icon-user menu-icon"></i><span>Staff</span></a></li>
					  <?php if($user->userlevel == 9):?>
					  <li><a href="index.php?do=clients"><i class="icon-users menu-icon"></i><span>Clients</span></a></li>
					  <?php endif;?>
					</ul>
				  </li>
				  <li> <a href="#">Course & Exams</a>
					<ul class="cbp-hssubmenu">
					  <?php if($user->userlevel == 9):?>
					  <li><a href="index.php?do=courses"><i class="icon-copy menu-icon"></i><span>Manage Courses</span></a></li>
					  <li><a href="index.php?do=exams"><i class="icon-exams menu-icon"></i><span>Manage Exams</span></a></li>
					  <li><a href="index.php?do=questions"><i class="icon-ques menu-icon"></i><span>Manage Questions</span></a></li>
					  <li><a href="index.php?do=questions&amp;action=add"><i class="icon-addq menu-icon"></i><span>Add Question</span></a></li>					  
					  <?php endif;?>
					  <li><a href="index.php?do=results"><i class="icon-result menu-icon"></i><span>Results</span></a></li>
					</ul>
				  </li>
				  <li> <a href="#">Enrolment & Billing</a>
					<ul class="cbp-hssubmenu">
					  <li><a href="index.php?do=enrolment"><i class="icon-enrol menu-icon"></i><span>Enrolment</span></a></li>
					  <li><a href="index.php?do=transactions"><i class="icon-trans menu-icon"></i><span><?php echo lang('MENU_VT');?></span></a></li>
					  <li><a href="index.php?do=gateways"><i class="icon-payment menu-icon"></i><span><?php echo lang('MENU_PG');?></span></a></li>
					</ul>
				  </li>
				  <li> <a href="#">Contents</a>
					<ul class="cbp-hssubmenu">
					  <li><a href="index.php?do=categories"><i class="icon-category menu-icon"></i><span>Resource Categories</span></a></li>
					  <li><a href="index.php?do=resources"><i class="icon-resource menu-icon"></i><span>Resource Items</span></a></li>
					  <li><a href="index.php?do=resources&amp;action=add"><i class="icon-addq menu-icon"></i><span>Add Resource Item</span></a></li>
					  <li><a href="index.php?do=faqs"><i class="icon-faq menu-icon"></i><span>Manage FAQs</span></a></li>
					  <li><a href="index.php?do=faqs&amp;action=add"><i class="icon-addq menu-icon"></i><span>Add FAQ Item</span></a></li>
					  
					</ul>
				  </li>
				  <?php if($user->userlevel == 9):?>
				  <li><a href="#">System Setting</a>
					<ul class="cbp-hssubmenu">
					  <li><a href="index.php?do=config"><i class="icon-config menu-icon"></i><span><?php echo lang('MENU_SC');?></span></a></li>
					  <li><a href="index.php?do=backup"><i class="icon-database menu-icon"></i><span><?php echo lang('MENU_DB');?></span></a></li>
					  <li><a href="index.php?do=email"><i class="icon-email menu-icon"></i><span><?php echo lang('MENU_EM');?></span></a></li>
					</ul>
				  </li>
				  <?php endif;?>
				  <?php if(Core::fetchPluginInfo()):?>
				  <li> <a href="#"><?php echo lang('PLUGINS');?></a>
					<ul class="cbp-hssubmenu">
					  <?php foreach(Core::fetchPluginInfo() as $i => $prow):?>
					  <li><a href="index.php?do=<?php echo $prow->admin_url;?>"><img src="../plugins/<?php echo $prow->dir;?>/images/icon.png" alt="plg_<?php echo $i;?>"/><span><?php echo $prow->{'title_' . $core->lang};?></span></a></li>
					  <?php endforeach;?>
					</ul>
				  </li>
				  <?php endif;?>
				</ul>
			  </div>
			</nav>
			<!-- Main Menu  /--> 
		  
		</header>
		<!-- Header /--> 
    </div>
    </div>
	
	<div class="col grid_19">
    
    <!-- Main Content -->
    <div id="msgholder"></div>
   
