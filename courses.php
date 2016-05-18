<?php
  define("_VALID_PHP", true);
  require_once("init.php");
?>
<?php include("header.php");?>
<?php $courses = $content->getProjectTypes();?>

<div class="row">
	
</div>
<?php if($courses):?>
<div class="row xform course-box">
	<h1>Available Courses</h1>
	<?php foreach ($courses as $course):?>
	<section class="col col-4">
	  <div class="box">
		  <div class="course-upper">
			<a href="exams.php?sort=<?php echo $course->id;?>"><h1><?php echo $course->title;?></h1></a>
			<h4>5 Exams</h4>
			<?php if($course->fees <= 0){ ?>
			<h2>FREE</h2>
			<?php } else { ?>
			<h2>$<?php echo $course->fees;?> USD<?php if($course->recurring == 1){ echo '/' . $course->days . $course->period; } ?></h2>
			<?php } ?>
		  </div>
		  <div class="course-lower">
			<a href="exams.php?sort=<?php echo $course->id;?>" class="button course-details">Details</a>
			<?php if ($user->logged_in){ ?>
			
				<?php $erow = $user->checkEnrol($user->uid,$course->id);?>
				<?php if ($erow){?>
					<a href="exams.php?sort=<?php echo $course->id;?>" class="button button-secondary">Enrolled</a>
				<?php } else { ?>	
					<a href="account.php?do=enrolment&id=<?php echo $course->id;?>" class="button ">Enrol Now</a>
				<?php } ?>	
				
			<?php } ?>
		  </div>
	  </div>
	</section>
	<?php endforeach;?>
    <?php unset($course);?>
</div>
<?php endif;?>
<?php echo Core::doDelete(lang('PROJ_DELETE'),"processEnrol");?>
<?php include("footer.php");?>