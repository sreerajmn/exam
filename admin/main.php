<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $enrolment = $content->getEnrolment();?>
<script type="text/javascript" src="../assets/js/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="../assets/js/flot/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="../assets/js/flot/excanvas.min.js"></script>

<div class="row grid_24"> 
	<section class="">
      <div class="content2">
        <ul class="stat-list">
          <li>
            <label class="label-warning"><i class="icon-user icon-white"><b><?php echo $core->countUsers(1);?></b></i><br><h4 class="sub">Active Users</h4></label>
          </li>
          <li>
            <label class="label-important"><i class="icon-group icon-white"><b><?php echo $core->countUsers(1);?></b></i><br><h4 class="sub"><?php echo lang('DASH_STAFFMEMBER');?></h4></label>
            
          </li>
          <li>
            <label class="label-success"><i class="icon-copy icon-white"><b><?php echo $core->countCourses();?></b></i><br><h4 class="sub">Courses</h4></label>
            
          </li>
          <li>
            <label class="label-info"><i class="icon-exams icon-white"><b><?php echo $core->countExams();?></b></i><br><h4 class="sub">Active Exams</h4></label>
            
          </li>
          <li>
            <label class="label-system"><i class="icon-enrol icon-white"><b><?php echo $core->countEnrol();?></b></i><br><h4 class="sub">Enrolment</h4></label>   
          </li>
          <li>
            <label class="label-inverse"><i class="icon-ques icon-white"><b><?php echo $core->countQues();?></b></i><br><h4 class="sub">Questions</h4></label>
          </li>
          <li>
            <label class="label-system"><i class="icon-resource icon-white"><b><?php echo $core->countResources();?></b></i><br><h4 class="sub">Resource Items</h4></label>
          </li>
          <li>
            <label class="label-inverse"><i class="icon-faq icon-white"><b><?php echo $core->countFaqs();?></b></i><br><h4 class="sub">FAQ Items</h4></label>
          </li>
        </ul>
      </div>
    </section>
</div>

<div class="row grid_24"> 
  <!-- Grid 24 -->
  <div class="col grid_24">
    <?php if($user->userlevel == 9):?>
    <!-- Start Right Statist List -->
    <section class="widget">
      <header>
        <h1><i class="icon-money"></i> Traffic Statistics</h1>
        <aside>
          <ul class="settingsnav">
            <li> <a href="#" data-hint="<?php echo lang('ACTIONS');?>" class="minilist hint--left hint--add hint--always hint--rounded"><span class="icon-reorder"></span></a>
              <div id="settingslist2">
                <ul class="sub">
                  <li><i class="icon-calendar pull-left"></i> <a href="javascript:void(0);" data-type="day"><?php echo lang('DASH_TODAY');?></a></li>
                  <li><i class="icon-calendar pull-left"></i> <a href="javascript:void(0);" data-type="week"><?php echo lang('DASH_WEEK');?></a></li>
                  <li><i class="icon-calendar pull-left"></i> <a href="javascript:void(0);" data-type="month"><?php echo lang('DASH_MONTH');?></a></li>
                  <li><i class="icon-calendar pull-left"></i> <a href="javascript:void(0);" data-type="year"><?php echo lang('DASH_YEAR');?></a></li>
                </ul>
              </div>
            </li>
          </ul>
        </aside>
      </header>
      <div class="content2"> 
        <!-- Start Chart -->
        <div class="box">
          <div id="chart" style="height:300px"></div>
        </div>
        <!-- End Chart /-->
      </div>
    </section>
    <!-- End Right Statist List /-->
    <?php endif;?>
    
    <!-- Start Pending Projects -->
    <section class="widget">
      <header>
        <h1><i class="icon-briefcase"></i> Recent Enrolment</h1>
      </header>
      <div class="content2">
      
		<?php if(!$enrolment):?>
		<?php echo Filter::msgInfo(lang('PROJ_NOPROJECT'),false);?>
		<?php else:?>
		<table class="myTable">
		  <thead>
			<tr>
			  <th class="header">User Name</th>
			  <th class="header">Course Title</th>
			  <th class="header">Date</th>
			</tr>
		  </thead>
		  <?php foreach ($enrolment as $row):?>
		  <tr>
			<td><?php echo $row->fname . ' ' . $row->lname;?></td>
			<td><?php echo $content->getCoursetitle($row->course);?></td>
			<td><?php echo $row->rdate;?></td>  
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
    <!-- End Pending Projects /--> 
  </div>
  <!-- Grid 18 --> 
</div>
<?php if($user->userlevel == 9):?>
<script type="text/javascript">
// <![CDATA[
function getChart(range) {
    $.ajax({
        type: 'GET',
        url: 'controller.php',
		data : {
			'getSaleStats' :1,
			'timerange' : range
		},
        dataType: 'json',
        async: false,
        success: function (json) {
            var option = {
                shadowSize: 0,
                lines: {
                    show: true,
                    fill: true,
                    lineWidth: 1
                },
                grid: {
                    backgroundColor: '#FFFFFF'
                },
                xaxis: {
                    ticks: json.xaxis
                }
            }
            $.plot($('#chart'), [json.order], option);
        }
    });
}
getChart(0);
$(document).ready(function () {
    $('#settingslist2 a').on('click', function () {
        var type = $(this).attr('data-type')
		  getChart(type);
	});  
 });	  
// ]]>
</script>
<?php endif;?>