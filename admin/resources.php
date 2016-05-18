<?php

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("resources", Filter::$id);?>
<?php if(!$user->checkProjectAccess($row->id)): print Filter::msgInfo(lang('NOACCESS'), false); return; endif;?>
<?php $ptype = $content->getCategories();?>
  
<form class="xform" id="admin_form" method="post">
  <header>Resources<span>Editing Resource Item <i class="icon-angle-right"></i> <?php echo $row->title;?></span></header>
  <div class="row">
    <section class="col col-8">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" value="<?php echo $row->title;?>" placeholder="Resource title">
      </label>
      <div class="note note-error">Resource Title</div>
    </section>
    
	<section class="col col-4">
	  <select name="category">
		<option value="">-- Select Category --</option>
		<?php if ($ptype):?>
		<?php foreach ($ptype as $prow):?>
		<option value="<?php echo $prow->id;?>"<?php if($prow->id == $row->category) echo ' selected="selected"';?>><?php echo $prow->title;?></option>
		<?php endforeach;?>
		<?php unset($prow);?>
		<?php endif;?>
	  </select>
	  <div class="note note-error">Resource Category</div>
	</section>

  </div>
  
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="content" rows="20"><?php echo $row->content;?></textarea>
    </div>
  </section>
    
    <footer>
      <button class="button" name="dosubmit" type="submit">Update Resource</button>
      <a href="index.php?do=resources" class="button button-secondary"><?php echo lang('CANCEL');?></a>
	</footer>
    <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />

</form>
<?php echo Core::doForm("processResource");?> 
<?php break;?>

<?php case"add":?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('PROJ_NOPERM'), false); return; endif;?>
<?php $ptype = $content->getCategories();?>
<form class="xform" id="admin_form" method="post">
  <header>Resource Items<span>Add New Item</span></header>
  <div class="row">
    <section class="col col-8">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" placeholder="Exam title">
      </label>
      <div class="note note-error">Exam Title</div>
    </section>
	
    <section class="col col-4">
      <select name="category">
        <option value="">-- Select Category --</option>
        <?php if ($ptype):?>
        <?php foreach ($ptype as $prow):?>
        <option value="<?php echo $prow->id;?>"><?php echo $prow->title;?></option>
        <?php endforeach;?>
        <?php unset($prow);?>
        <?php endif;?>
      </select>
      <div class="note note-error">Resource Category</div>
    </section>
  </div>
  
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="content" rows="20"></textarea>
    </div>
  </section>
  
  <footer>
    <button class="button" name="dosubmit" type="submit">Add Resource Item</button>
    <a href="index.php?do=resources" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
<?php echo Core::doForm("processResource");?> 
<?php break;?>
<?php default: ?>
<?php $projectrow = $content->getResources();?>
<?php $ptype = $content->getCategories();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing All Resource Items</h1>
    <?php if($user->userlevel == 9):?>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Add Resource Item" href="index.php?do=resources&amp;action=add"><span class="icon-plus"></span></a> </aside>
    <?php endif;?>
  </header>
  <div class="content2">
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
            <select name="select" id="categoryfilter">
              <option value="">-- Select Category --</option>
              <?php if ($ptype):?>
			  <?php foreach ($ptype as $prow):?>
              <option value="<?php echo $prow->id;?>"<?php if($prow->id == get('sort')) echo 'selected="selected"';?>><?php echo $prow->title;?></option>
              <?php endforeach;?>
              <?php unset($prow);?>
              <?php endif;?>
            </select>
          </section>
		  
		  
          <section class="col col-3"> <?php echo $pager->items_per_page();?> </section>
          <section class="col col-3"> <?php echo $pager->jump_menu();?> </section>
        </form>
      </div>
    </div>
    <?php if(!$projectrow):?>
    <?php echo Filter::msgInfo(lang('PROJ_NOPROJECT'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header">Resource Title</th>
          <th class="header">Category Name</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($projectrow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->ctitle;?></td>
        <td>
		  
          <?php if($user->userlevel == 9):?>
		  
		  <span class="tbicon"> <a href="index.php?do=resources&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span>
		  
          <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span>
		  
          <?php endif;?></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </table>
    <?php if($pager->display_pages()):?>
    <?php echo $pager->display_pages();?>
    <?php endif;?>
    <?php endif;?>
  </div>
</section>
<?php echo Core::doDelete(lang('PROJ_DELETE'),"deleteResource");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#categoryfilter').change(function () {
		var res = $("#categoryfilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=resources' : window.location.href = 'index.php?do=resources&sort=' + res;
    })
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>