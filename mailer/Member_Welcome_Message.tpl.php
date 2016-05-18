<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo Registry::get("Core")->company;?></title>
<style type="text/css">
a { color: #2D7BE0; }
a:hover { text-decoration: none; }
</style>
</head>
<body>
<div style="font-family:Arial, Helvetica, sans-serif; font-size:13px;margin:20px" align="center">
  <table style="background-color:#F4F4F4; border: 2px solid #bbbbb;" border="0" cellpadding="10" cellspacing="5" width="650">
    <tbody>
      <tr>
        <th style="background-color:#ccc; font-size:16px;padding:5px;border-bottom-width:2px; border-bottom-color:#fff; border-bottom-style:solid"><a href="<?php echo Registry::get("Core")->site_url;?>"><?php if(file_exists(UPLOADS.'print_logo.png')):?>
    <img src="<?php echo UPLOADURL;?>print_logo.png" alt="<?php echo Registry::get("Core")->company;?>" border="0" />
	<?php elseif (Registry::get("Core")->logo):?>
    <img src="<?php echo UPLOADURL.Registry::get("Core")->logo;?>" alt="<?php echo Registry::get("Core")->company;?>" border="0" />
	<?php else:?>
	<?php echo Registry::get("Core")->company;?>
	<?php endif;?></a></th>
      </tr>
      <tr>
        <td style="text-align: left;" valign="top"> Dear <?php echo $data['fname'].' '.$data['lname'];?>, <br>
          Welcome to <?php echo Registry::get("Core")->company;?> To start using <?php echo Registry::get("Core")->company;?> you will need to <a href="<?php echo Registry::get("Core")->site_url;?>">login to your member panel</a> </td>
      </tr>
      <tr>
        <td style="text-align: left;" valign="top"><strong>Account Details:</strong><br>
          <br>
          <table width="100%" border="0" cellpadding="5" cellspacing="2">
            <tr>
              <td width="150" style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">Username:</td>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;"><?php echo $data['username'];?></td>
            </tr>
            <tr>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">Password</td>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;"><?php echo $pass;?></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td style="text-align: left;" valign="top"><em>From the member panel, you will be able to view your project status, print invoices and so much more. Thank You,<br/>
          <a href="<?php echo Registry::get("Core")->site_url;?>"><?php echo Registry::get("Core")->company;?></a></em></td>
      </tr>
      <tr>
        <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;font-size:12px" valign="top"> This email is sent to you directly from <a href="<?php echo Registry::get("Core")->site_url;?>"><?php echo Registry::get("Core")->company;?></a> The information above is gathered from the user input. &copy;<?php echo date('Y');?> <a href="<?php echo Registry::get("Core")->site_url;?>"><?php echo Registry::get("Core")->company;?></a>. All rights reserved.</td>
      </tr>
    </tbody>
  </table>
</div>
</body>
</html>