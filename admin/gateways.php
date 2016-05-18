<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("gateways", Filter::$id);?>
<form class="xform" id="admin_form" method="post">
  <header>
    <div class="row">
      <section class="col col-6"> <?php echo lang('GATE_SUB1');?><span><?php echo lang('GATE_SUB') . $row->displayname;?></span> </section>
      <section class="col col-6">
        <div class="right"><a href="javascript:void(0);" class="viewtip right"><i class="icon-question-sign icon-2x"></i></a></div>
      </section>
    </div>
  </header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="displayname" value="<?php echo $row->displayname;?>" placeholder="<?php echo lang('GATE_NAME');?>">
      </label>
      <div class="note"><?php echo lang('GATE_NAME');?></div>
    </section>
    <section class="col col-6">
      <label class="input">
        <input type="text" name="extra" value="<?php echo $row->extra;?>" placeholder="<?php echo $row->extra_txt;?>">
      </label>
      <div class="note note"><?php echo $row->extra_txt;?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input">
        <input type="text" name="extra2" value="<?php echo $row->extra2;?>" placeholder="<?php echo $row->extra_txt2;?>">
      </label>
      <div class="note"><?php echo $row->extra_txt2;?></div>
    </section>
    <section class="col col-6">
      <label class="input">
        <input type="text" name="extra3" value="<?php echo $row->extra3;?>" placeholder="<?php echo $row->extra_txt3;?>">
      </label>
      <div class="note note"><?php echo $row->extra_txt3;?></div>
    </section>
  </div>
  <section>
    <div class="row">
      <div class="col col-6">
        <label class="label"><?php echo lang('GATE_LIVE');?></label>
        <label class="radio">
          <input type="radio" name="live" value="1" <?php getChecked($row->live, 1); ?>>
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" name="live" value="0" <?php getChecked($row->live, 0); ?>>
          <i></i><?php echo lang('NO');?></label>
        <div class="note note"><?php echo lang('GATE_LIVE_T');?></div>
      </div>
      <div class="col col-6">
        <label class="label"><?php echo lang('GATE_ACTIVE');?></label>
        <label class="radio">
          <input type="radio" name="active" value="1" <?php getChecked($row->active, 1); ?>>
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" name="active" value="0" <?php getChecked($row->active, 0); ?>>
          <i></i><?php echo lang('NO');?></label>
        <div class="note note"><?php echo lang('GATE_ACTIVE_T');?></div>
      </div>
    </div>
  </section>
  <hr />
  <div class="row">
    <section class="col col-6">
      <label class="input">
        <input type="text" disabled="disabled" value="<?php echo SITEURL.'/gateways/'.$row->dir.'/ipn.php';?>" readonly="readonly">
      </label>
      <div class="note"><?php echo lang('GATE_IPN');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('GATE_UPDATE');?></button>
    <a href="index.php?do=gateways" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
</form>
<div id="showhelp" style="display:none"><?php echo cleanOut($row->info);?></div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
	$('a.viewtip').on('click', function () {
		var text = $("#showhelp").html();
		new Messi(text, {
			title: "<?php echo $row->displayname;?>"
		});
	});
});
// ]]>
</script> 
<?php echo Core::doForm("processGateway");?>
<?php break;?>
<?php default: ?>
<?php $gaterow = $content->getGateways();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('GATE_SUB1');?></h1>
  </header>
  <div class="content2">
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('GATE_NAME');?></th>
          <th class="header"><?php echo lang('EDIT');?></th>
        </tr>
      </thead>
      <tbody>
        <?php if(!$gaterow):?>
        <tr>
          <td colspan="2"><?php echo $core->msgError(lang('GATE_NOGATE'),false);?></td>
        </tr>
        <?php else:?>
        <?php foreach ($gaterow as $row):?>
        <tr>
          <td><?php echo $row->displayname;?></td>
          <td><span class="tbicon"> <a href="index.php?do=gateways&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->displayname;?>"><i class="icon-pencil"></i></a> </span></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
        <?php endif;?>
      </tbody>
    </table>
  </div>
</section>
<?php break;?>
<?php endswitch;?>