<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("categories", Filter::$id);?>
<form class="xform" id="admin_form" method="post">
  <header>Resource Categories<span>Editing Category <i class="icon-angle-right"></i><?php echo $row->title;?></span></header>
  <div class="row">
    <section class="col col-12">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" value="<?php echo $row->title;?>" placeholder="<?php echo lang('TYPE_NAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('TYPE_NAME');?></div>
    </section>
  </div>
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="description" rows="5"><?php echo $row->description;?></textarea>
    </div>
  </section>
  <footer>
    <button class="button" name="dosubmit" type="submit">Update Category</button>
    <a href="index.php?do=categories" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
</form>
<?php echo Core::doForm("processCategory");?>
<?php break;?>
<?php case"add": ?>
<form class="xform" id="admin_form" method="post">
  <header>Resource Categories<span>Adding Resource Category</span></header>
  <div class="row">
    <section class="col col-12">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" placeholder="<?php echo lang('TYPE_NAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('TYPE_NAME');?></div>
    </section>
  </div>
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="description" rows="5"></textarea>
    </div>
  </section>
  <footer>
    <button class="button" name="dosubmit" type="submit">Add Categorie</button>
    <a href="index.php?do=categories" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
<?php echo Core::doForm("processCategory");?>
<?php break;?>
<?php default: ?>
<?php $typerow = $content->getCategories();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing Categories</h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Add Category" href="index.php?do=categories&amp;action=add"><span class="icon-plus"></span></a> </aside>
  </header>
  <div class="content2">
    <?php if(!$typerow):?>
    <?php echo Filter::msgInfo(lang('TYPE_NOTYPES'), false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header">Category Name</th>
          <th class="header">Category Description</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($typerow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->description;?></td>
        <td><span class="tbicon"> <a href="index.php?do=categories&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </table>
    <?php endif;?>
  </div>
</section>
<?php echo Core::doDelete(lang('TYPE_DELTYPE'), "deleteCategory");?>
<?php break;?>
<?php endswitch;?>