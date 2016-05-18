<?php

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $results = $content->getResults();?>
<?php $ptype = $content->getExamTypes();?>
<?php $userlist = $user->getUserList(1);?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('PROJ_SUB3');?></h1>
  </header>
  <div class="content2">
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
			<select name="exam_type" id="examfilter">
			  <option value=""> -- Select Exam -- </option>
			  <?php if ($ptype):?>
			  <?php foreach ($ptype as $prow):?>
			  <option value="<?php echo $prow->id;?>"<?php if($prow->id == get('qid')) echo ' selected="selected"';?>><?php echo $prow->title;?></option>
			  <?php endforeach;?>
			  <?php unset($prow);?>
			  <?php endif;?>
			</select>
			<div class="note note-error">Choose Exam</div>
		  </section>
		  <section class="col col-6">
			  <select name="user_id" id="userfilter">
				<option value="">--- Select User ---</option>
				<?php if($userlist):?>
				<?php foreach ($userlist as $crow):?>
				<option value="<?php echo $crow->id;?>"><?php echo $crow->name;?></option>
				<?php endforeach;?>
				<?php unset($crow);?>
				<?php endif;?>
			  </select>
			  <div class="note note-error">Select User</div>
		  </section>
     
        </form>
      </div>
    </div>
    <?php if(!$results):?>
    <?php echo Filter::msgInfo(lang('PROJ_NOPROJECT'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header">User Name</th>
          <th class="header">Exam Title</th>
          <th class="header">Score</th>
          <th class="header">Date</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($results as $row):?>
      <tr>
        <td><?php echo $row->fname . ' ' . $row->lname;?></td>
        <td><?php echo $content->getExamtitle($row->exam);?></td>
        <td><?php echo $row->score;?>% (<?php echo intval($row->marks);?>/<?php echo intval($row->fullmarks);?>)</td>
		<td><?php echo $row->rdate;?></td>
        <td>
		  <span class="tbicon"> <a href="index.php?do=results&amp;banned=<?php echo $row->id;?>" class="tooltip" data-title="Disable Result"><i class="icon-pencil"></i></a> </span>
		  
		  <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->fname . ' ' . $row->lname;?>" data-title="<?php echo lang('DELETE').' Result';?>"><i class="icon-trash"></i></a> </span>
		</td>
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
<?php echo Core::doDelete('Delete Project',"deleteResult");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#examfilter').change(function () {
		var res = $("#examfilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=results' : window.location.href = 'index.php?do=results&sort=' + res;
    })
	
	$('#userfilter').change(function () {
		var ress = $("#userfilter option:selected").val();
		(ress == "NA" ) ? window.location.href = 'index.php?do=results' : window.location.href = 'index.php?do=results&uid=' + ress;
    })
});
// ]]>
</script>