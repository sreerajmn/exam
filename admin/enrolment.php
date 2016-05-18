<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $enrolment = $content->getEnrolment();?>
<?php $ptype = $content->getProjectTypes();?>
<?php $userlist = $user->getUserList(1);?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing All Enrolments</h1>
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
    <?php if(!$enrolment):?>
    <?php echo Filter::msgInfo(lang('PROJ_NOPROJECT'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header">User Name</th>
          <th class="header">Course Title</th>
          <th class="header">Date</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($enrolment as $row):?>
      <tr>
        <td><?php echo $row->fname . ' ' . $row->lname;?></td>
        <td><?php echo $content->getCoursetitle($row->course);?></td>
		<td><?php echo $row->rdate;?></td>
        <td>
		  
		  <span class="tbicon"> <a href="index.php?do=enrolment&amp;banned=<?php echo $row->id;?>" class="tooltip" data-title="Disable Enrolment"><i class="icon-pencil"></i></a> </span>
		  
		  <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->fname . ' ' . $row->lname;?>" data-title="<?php echo lang('DELETE').' Enrolment';?>"><i class="icon-trash"></i></a> </span>

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
<?php echo Core::doDelete(lang('PROJ_DELETE'),"deleteEnrolment");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#coursefilter').change(function () {
		var res = $("#coursefilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=enrolment' : window.location.href = 'index.php?do=enrolment&sort=' + res;
    })
	
	$('#userfilter').change(function () {
		var ress = $("#userfilter option:selected").val();
		(ress == "NA" ) ? window.location.href = 'index.php?do=enrolment' : window.location.href = 'index.php?do=enrolment&uid=' + ress;
    })
});
// ]]>
</script>