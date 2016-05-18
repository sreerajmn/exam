<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("faqs", Filter::$id);?>

<form class="xform" id="admin_form" method="post">
  <header>FAQ Items<span>Editing FAQ Item <i class="icon-angle-right"></i><?php echo $row->title;?></span></header>
  <div class="row">
    <section class="col col-9">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" value="<?php echo $row->title;?>" placeholder="FAQ Title">
      </label>
      <div class="note note-error">FAQ Title Here</div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="order" value="<?php echo $row->order;?>" placeholder="Item Order">
      </label>
      <div class="note note-error">FAQ Item Order</div>
    </section>
  </div>
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="content" rows="15"><?php echo $row->content;?></textarea>
    </div>
  </section>
  <footer>
    <button class="button" name="dosubmit" type="submit">Update FAQ</button>
    <a href="index.php?do=faqs" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
</form>
<?php echo Core::doForm("processFAQ");?>
<?php break;?>
<?php case"add": ?>
<form class="xform" id="admin_form" method="post">
  <header>FAQs<span>Adding FAQ Item</span></header>
  <div class="row">
    <section class="col col-9">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" placeholder="FAQ Title">
      </label>
      <div class="note note-error">FAQ Title Here</div>
    </section>
	<section class="col col-3">
      <label class="input"></i>
        <input type="text" name="order" placeholder="Item order">
      </label>
      <div class="note note-error">FAQ item order</div>
    </section>
  </div>
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="content" rows="15"></textarea>
    </div>
  </section>
  <footer>
    <button class="button" name="dosubmit" type="submit">Add FAQ Item</button>
    <a href="index.php?do=faqs" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
</div>
<?php echo Core::doForm("processFAQ");?>
<?php break;?>
<?php default: ?>
<?php $typerow = $content->getFAQs();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing FAQ Items</h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Add FAQ Item" href="index.php?do=faqs&amp;action=add"><span class="icon-plus"></span></a> </aside>
  </header>
  <div class="content2">
    <?php if(!$typerow):?>
    <?php echo Filter::msgInfo(lang('TYPE_NOTYPES'), false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header">Item Title</th>
          <th class="header">Description</th>
          <th class="header">Order</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($typerow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->content;?></td>
        <td><?php echo $row->order;?></td>
        <td><span class="tbicon"> <a href="index.php?do=faqs&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </table>
    <?php endif;?>
  </div>
</section>
<?php echo Core::doDelete(lang('TYPE_DELTYPE'), "deleteFAQ");?>
<?php break;?>
<?php endswitch;?>