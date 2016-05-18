<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("exams", Filter::$id);?>
<?php if(!$user->checkProjectAccess($row->id)): print Filter::msgInfo(lang('NOACCESS'), false); return; endif;?>
<?php $ptype = $content->getProjectTypes();?>

<form class="xform" id="admin_form" method="post">
  <header>Exams<span>Editing Exam <i class="icon-angle-right"></i> <?php echo $row->title;?></span></header>
  <div class="row">
    <section class="col col-5">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" value="<?php echo $row->title;?>" placeholder="Exam title">
      </label>
      <div class="note note-error">Exam Title</div>
    </section>
	
	<section class="col col-3">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="duration" value="<?php echo $row->duration;?>" placeholder="Exam duration">
      </label>
      <div class="note note-error">Exam Duration(minutes)</div>
    </section>
    
	<section class="col col-4">
        <select name="course">
          <option value="">-- Select Course --</option>
          <?php if ($ptype):?>
          <?php foreach ($ptype as $prow):?>
          <option value="<?php echo $prow->id;?>"<?php if($prow->id == $row->course) echo ' selected="selected"';?>><?php echo $prow->title;?></option>
          <?php endforeach;?>
          <?php unset($prow);?>
          <?php endif;?>
        </select>
        <div class="note note-error">Related Course</div>
      </section>

  </div>
  
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="syllabus" rows="5"><?php echo $row->syllabus;?></textarea>
    </div>
  </section>
    
    <footer>
      <button class="button" name="dosubmit" type="submit">Update Exam</button>
      <a href="index.php?do=exams" class="button button-secondary"><?php echo lang('CANCEL');?></a>
	</footer>
    <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />

</form>
<?php echo Core::doForm("processExam");?> 
<?php break;?>

<?php case"add":?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('PROJ_NOPERM'), false); return; endif;?>
<?php $ptype = $content->getProjectTypes();?>
<form class="xform" id="admin_form" method="post">
  <header>Exams<span>Add New Exam</span></header>
  <div class="row">
    <section class="col col-5">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" placeholder="Exam title">
      </label>
      <div class="note note-error">Exam Title</div>
    </section>
	
	<section class="col col-3">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="duration" placeholder="Exam duration">
      </label>
      <div class="note note-error">Exam Duration(minute)</div>
    </section>
    
    <section class="col col-4">
      <select name="course">
        <option value="">-- Select Course --</option>
        <?php if ($ptype):?>
        <?php foreach ($ptype as $prow):?>
        <option value="<?php echo $prow->id;?>"><?php echo $prow->title;?></option>
        <?php endforeach;?>
        <?php unset($prow);?>
        <?php endif;?>
      </select>
      <div class="note note-error">Related Course</div>
    </section>
  </div>
  
  <section>
    <div class="field-wrap wysiwyg-wrap">
      <textarea class="post" name="syllabus" rows="5"></textarea>
    </div>
  </section>
  
  <footer>
    <button class="button" name="dosubmit" type="submit">Add Exam</button>
    <a href="index.php?do=exams" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
<?php echo Core::doForm("processExam");?> 
<?php break;?>
<?php default: ?>
<?php $projectrow = $content->getExams();?>
<?php $ptype = $content->getProjectTypes();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing All Exams</h1>
    <?php if($user->userlevel == 9):?>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Add Exam" href="index.php?do=exams&amp;action=add"><span class="icon-plus"></span></a> </aside>
    <?php endif;?>
  </header>
  <div class="content2">
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
            <select name="select" id="coursefilter">
              <option value="">-- Select Course --</option>
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
          <th class="header">Exam Title</th>
          <th class="header">Course Title</th>
          <th class="header">Duration</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($projectrow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->ctitle;?></td>
        <td><?php echo $row->duration;?> (minutes)</td>
        <td>
		  
		  <span class="tbicon"> <a href="index.php?do=questions&amp;sort=<?php echo $row->id;?>" class="tooltip" data-title="Exam Details"><i class="icon-suitcase"></i></a> </span>

          <?php if($user->userlevel == 9):?>

          <span class="tbicon"> <a href="index.php?do=questions&amp;action=add&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo 'Add Question to: '.$row->title;?>"><i class="icon-plus"></i></a> </span>
		  
		  <span class="tbicon"> <a href="index.php?do=exams&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span>
		  
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
<?php echo Core::doDelete(lang('PROJ_DELETE'),"deleteProject");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#coursefilter').change(function () {
		var res = $("#coursefilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=exams' : window.location.href = 'index.php?do=exams&sort=' + res;
    })
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>