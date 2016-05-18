<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("project_types", Filter::$id);?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('TYPE_SUB2');?><span><?php echo lang('TYPE_SUB') . $row->title;?></span></header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" value="<?php echo $row->title;?>" placeholder="<?php echo lang('TYPE_NAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('TYPE_NAME');?></div>
    </section>
	<section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="fees" value="<?php echo $row->fees;?>" placeholder="Enter course fees">
      </label>
      <div class="note note-error">Course fees</div>
    </section>
  </div>
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="description" rows="5"><?php echo $row->description;?></textarea>
    </div>
  </section>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('TYPE_UPDATE');?></button>
    <a href="index.php?do=courses" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
</form>
<?php echo Core::doForm("processProjectType");?>
<?php break;?>
<?php case"add": ?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('TYPE_SUB2');?><span><?php echo lang('TYPE_SUB1');?></span></header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" placeholder="<?php echo lang('TYPE_NAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('TYPE_NAME');?></div>
    </section>
	<section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="fees" placeholder="Enter course fees">
      </label>
      <div class="note note-error">Course fees</div>
    </section>
  </div>
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="description" rows="5"></textarea>
    </div>
  </section>
  <div class="row">
    <section class="col col-6">
      <label class="label"><?php echo lang('INVC_RECURRING_PAY');?></label>
      <label class="radio">
        <input type="radio" name="recurring" value="1">
        <i></i><?php echo lang('YES');?></label>
      <label class="radio">
        <input type="radio" name="recurring" value="0" checked="checked">
        <i></i><?php echo lang('NO');?></label>
    </section>
    <section class="col col-6">
      <select name="period">
        <option value="D"><?php echo lang('INVC_REC_DAYS');?></option>
        <option value="W"><?php echo lang('INVC_REC_WEEKS');?></option>
        <option value="M"><?php echo lang('INVC_REC_MONTHS');?></option>
        <option value="Y"><?php echo lang('INVC_REC_YEARS');?></option>
      </select>
      <div class="note"><i class="icon-caret-down"></i></div>
      <label class="input"> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('INVC_RECURRING_PER_T');?>"></i>
        <input type="text" name="days" placeholder="<?php echo lang('INVC_RECURRING_PER');?>">
      </label>
      <div class="note note"><?php echo lang('INVC_RECURRING_PER');?></div>
    </section>
  </div>
  
  
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('TYPE_ADD');?></button>
    <a href="index.php?do=courses" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
</div>
<?php echo Core::doForm("processProjectType");?>
<?php break;?>
<?php default: ?>
<?php $typerow = $content->getProjectTypes();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('TYPE_SUB2');?></h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('TYPE_ADD');?>" href="index.php?do=courses&amp;action=add"><span class="icon-plus"></span></a> </aside>
  </header>
  <div class="content2">
    <?php if(!$typerow):?>
    <?php echo Filter::msgInfo(lang('TYPE_NOTYPES'), false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('TYPE_NAME');?></th>
          <th class="header"><?php echo lang('TYPE_DESC');?></th>
          <th class="header">Fees</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($typerow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->description;?></td>
        <td>$<?php echo $row->fees;?> USD</td>
        <td><span class="tbicon"> <a href="index.php?do=courses&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </table>
    <?php endif;?>
  </div>
</section>
<?php echo Core::doDelete(lang('TYPE_DELTYPE'), "deleteProjectType");?>
<?php break;?>
<?php endswitch;?>