<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Invoice For &rsaquo;<?php echo $row->ptitle;?></title>
</head>
<body>
<div style="padding: 0px; font-family: Arial, Helvetica, sans-serif; font-size: 13px; line-height: 1.5em; color: #000; margin: 30px;">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td style="background-color:#BCD030;padding:0 5px;height:10px"></td>
      <td width="250" style="background-color:#7C8083;padding:0 5px"></td>
    </tr>
  </table>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
    <td valign="top" style="padding:5px">
    <?php if(file_exists(UPLOADS.'print_logo.png')):?>
    <img src="<?php echo UPLOADURL;?>print_logo.png" alt="<?php echo Registry::get("Core")->company;?>" />
	<?php elseif (Registry::get("Core")->logo):?>
    <img src="<?php echo UPLOADURL.Registry::get("Core")->logo;?>" alt="<?php echo Registry::get("Core")->company;?>" />
	<?php else:?>
	<?php echo Registry::get("Core")->company;?>
	<?php endif;?></td>
      <td width="250" valign="top" style="padding:5px"><h4 style="margin:0px;padding:0px;font-size: 14px;">Invoice: #<?php echo Registry::get("Core")->invoice_number . $row->id;?></h4>
        <h4 style="margin:0px;padding:0px;font-size: 14px;"><?php echo date('M d Y');?></h4></td>
    </tr>
  </table>
  <div style="height:20px"></div>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top" style="padding:5px"><strong>Payment To</strong></td>
      <td colspan="2" valign="top" style="padding:5px"><strong>Bill To</strong></td>
    </tr>
    <tr>
      <td valign="top" style="padding:5px"><h2 style="font-size: 18px; margin: 0px; padding: 0px;"><?php echo Registry::get("Core")->company;?></h2>
        <?php echo Registry::get("Core")->address;?><br />
        <?php echo Registry::get("Core")->city.', '.Registry::get("Core")->state.' '.Registry::get("Core")->zip;?><br />
        <?php echo (Registry::get("Core")->phone) ? 'Phone: '.Registry::get("Core")->phone : '';?><br />
        <?php echo (Registry::get("Core")->fax) ? 'Fax: '.Registry::get("Core")->fax : '';?></td>
      <td width="250" colspan="2" valign="top" style="padding:5px"><h2 style="font-size: 18px; margin: 0px; padding: 0px;"><?php echo $row->name;?></h2>
        <?php echo $row->company;?><br />
        <?php echo $row->address;?><br />
        <?php echo $row->city.', '.$row->state.' '.$row->zip;?><br />
        <?php echo ($row->phone) ? 'Phone: '.$row->phone : '';?></td>
    </tr>
    <tr>
      <td colspan="3" valign="top" style="padding:5px"><div style="background-color:#7C8083;height:3px">&nbsp;</div></td>
    </tr>
    <tr>
      <td valign="top" style="padding:5px">Business Number: <?php echo Registry::get("Core")->tax_number;?>
      <?php if($row->vat):?><br />VAT: <?php echo $row->vat;?><?php endif;?></td>
      <td width="130" valign="top" style="padding:5px"><strong>Invoice Total:<br />
        <?php echo ($row->amount_paid != $row->amount_total) ? '<span style="color:#F00000">Amount Paid</span>' : 'Balance Due';?>:<br />
        Due Date:</strong></td>
      <td width="100" valign="top" style="padding:5px"><strong><?php echo $row->amount_total;?><br />
        <?php echo ($row->amount_paid != $row->amount_total) ? '<span style="color:#F00000">'.$row->amount_paid.'</span>' : $row->amount_paid;?> <br />
        <?php echo $row->ddate;?></strong></td>
    </tr>
  </table>
  <div style="height:20px"></div>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom-width: 4px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; border-bottom-color: #7C8083; border-left-color: #7C8083;">
    <tr>
      <td valign="top" style="background-color:#7C8083;padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><strong style="color:white">Invoice Items</strong></td>
      <td align="right" valign="top" style="background-color:#7C8083;padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><strong style="color:white">Price</strong></td>
    </tr>
    <?php if($invdata):?>
    <?php foreach($invdata as $irow):?>
    <tr>
      <td valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><h4 style="margin:0px;padding:0px;font-size: 14px;"><?php echo $irow->title;?></h4>
        <?php echo $irow->description;?></td>
      <td width="250" align="right" valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><?php echo $irow->amount;?></td>
    </tr>
    <?php endforeach;?>
    <?php if($row->tax):?>
    <tr>
      <td align="right" valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><?php echo Registry::get("Core")->tax_name;?>:</td>
      <td align="right" valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><?php echo $row->tax;?></td>
    </tr>
    <?php endif;?>
    <tr>
      <td align="right" valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><strong>Invoice Total:</strong></td>
      <td align="right" valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><?php echo $row->amount_total;?></td>
    </tr>
    <?php endif;?>
  </table>
  <?php if($paydata):?>
  <div style="height:20px"></div>
  <h3 style="font-size: 15px; margin: 0px; padding: 0px;">Payment Records</h3>
  <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border-bottom-width: 4px; border-left-width: 1px; border-bottom-style: solid; border-left-style: solid; border-bottom-color: #7C8083; border-left-color: #7C8083;">
    <tr>
      <td valign="top" style="background-color:#7C8083;padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><strong style="color:white">Payment Records</strong></td>
      <td align="right" valign="top" style="background-color:#7C8083;padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><strong style="color:white">Amount</strong></td>
    </tr>
    <?php foreach($paydata as $prow):?>
    <tr>
      <td valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><h4 style="margin:0px;padding:0px;font-size: 14px;">Reference on: <?php echo $prow->cdate?></h4>
        <?php echo $prow->description?></td>
      <td width="250" align="right" valign="top" style="padding:5px;border-right-width: 1px; border-right-style: solid; border-right-color: #7C8083; border-top-width: 1px; border-top-style: solid; border-top-color: #7C8083;"><?php echo $prow->amount;?></td>
    </tr>
    <?php endforeach;?>
  </table>
  <?php endif;?>
  <div style="height:20px"></div>
  <div style="font-size:11px;"><?php echo cleanOut($row->notes);?></div>
  <div style="height:20px"></div>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="background-color:#BCD030;padding:5px">To make a payment, please, login to the client area at: <?php echo Registry::get("Core")->site_url;?></td>
    </tr>
  </table>
</div>
</body>
</html>