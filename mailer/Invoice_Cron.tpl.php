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
        <td style="text-align: left;" valign="top">Hello <strong>[CLIENTNAME]</strong>,<br/>
          <br/>
          This is a reminder that your invoice <strong>[INVNAME]</strong> for a project <strong>[PROJECTNAME]</strong> is due in <?php echo Registry::get("Core")->invdays;?> days.<br>
                    <table width="100%" border="0" cellpadding="5" cellspacing="2">
            <tr>
              <td width="150" style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">Amount Owning:</td>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">[AMOUNT]</td>
            </tr>
            <tr>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">Payment Method:</td>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">[METHOD]</td>
            </tr>
            <tr>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">Invoice Due Date:</td>
              <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;">[DUEDATE]</td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td style="text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;font-size:12px" valign="top"> This email is sent to you directly from <a href="<?php echo Registry::get("Core")->site_url;?>"><?php echo Registry::get("Core")->company;?></a> The information above is gathered from the user input. &copy;<?php echo date('Y');?> <a href="<?php echo Registry::get("Core")->site_url;?>"><?php echo Registry::get("Core")->company;?></a>. All rights reserved.</td>
      </tr>
  </table>
</div>
</body>
</html>