<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("questions", Filter::$id);?>
<?php $arow = $content->loadAnswer($row->id);?>
<?php if(!$user->checkProjectAccess($row->id)): print Filter::msgInfo(lang('NOACCESS'), false); return; endif;?>
<?php $ptype = $content->getExamTypes();?>
<form class="xform" id="admin_form" method="post">
  <div class="subheader">
    <div class="row">
      <section class="col col-8"> Edit Qustion<span>Editing Question <i class="icon-angle-right"></i> <?php echo $row->description;?></span> </section>
      <section class="col col-4">
        <div class="radio-toolbar" id="tabs">
          <?php if($row->type == 1){ ?>
		  <input name="qtype" type="radio" id="radio1" value="<?php echo $row->type;?>" /><label for="radio1">True/False</label>
		  <?php } elseif($row->type == 2){ ?>
          <input name="qtype" type="radio" id="radio2" value="<?php echo $row->type;?>" /><label for="radio2">MCQ(1 from 4)</label>
		  <?php } elseif($row->type == 3){ ?>
          <input name="qtype" type="radio" id="radio3" value="<?php echo $row->type;?>" /><label for="radio2">MCQ(multiple answer)</label>
		  <?php } elseif($row->type == 4){ ?>
          <input name="qtype" type="radio" id="radio4" value="<?php echo $row->type;?>" /><label for="radio2">Writing</label>
		  <?php } ?>
        </div>
      </section>
    </div>
  </div>
  <input name="utype" type="hidden" value="<?php echo $row->type;?>" />
  <div id="general" class="tab_content">
    <div class="row">
	  <section class="col col-9">
        <select name="uexam">
          <option value=""> -- Select Exam --</option>
          <?php if ($ptype):?>
          <?php foreach ($ptype as $prow):?>
          <option value="<?php echo $prow->id;?>"<?php if($prow->id == $row->exam) echo ' selected="selected"';?>><?php echo $prow->title;?></option>
          <?php endforeach;?>
          <?php unset($prow);?>
          <?php endif;?>
        </select>
        <div class="note note-error">Choose Exam</div>
      </section>
	  
	  <section class="col col-3">
        <label class="input"> <i class="icon-append icon-asterisk"></i>
          <input type="text" name="umarks" value="<?php echo $row->marks;?>" placeholder="Marks">
        </label>
        <div class="note note-error">Marks for Question</div>
      </section>
    </div>
    
	<section>
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="udescription" rows="5"><?php echo $row->description;?></textarea>
      </div>
    </section>
	
	<?php if($row->type == 1){ ?>
	<div class="row">	  
	  <section class="col col-12">
	  <?php foreach ($arow as $answers):?>
	    <input name="ansid1" type="hidden" value="<?php echo $answers->id;?>" />
		<div class="radio-toolbar" style="float: left;">
		  <?php if($answers->correct == 1): ?>
			<input name="answer1" type="radio" id="answer11" value="1" checked="checked" /><label for="answer11">True</label>
			<input name="answer1" type="radio" id="answer12" value="0" /><label for="answer12">False</label>
		  <?php else: ?>
			<input name="answer1" type="radio" id="answer11" value="1" /><label for="answer11">True</label>
			<input name="answer1" type="radio" id="answer12" value="0" checked="checked" /><label for="answer12">False</label>
		  <?php endif; ?>
        </div>	
	  <?php endforeach;?>
	  <?php unset($answers);?>
      </section>
    </div>
	<?php } ?>
	
	<?php if($row->type == 2){ ?>
	<div class="row">	  
	  <?php foreach ($arow as $answers):?>
	  <input name="ansid2[]" type="hidden" value="<?php echo $answers->id;?>" />
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer2[]" rows="5"><?php echo $answers->answer; ?></textarea>
		</div>
      </section>
	  <?php
	  if($answers->correct == 1){
		$selected1 = ' selected';
		$selected2 = '';
	  }else{
		$selected1 = '';
		$selected2 = ' selected';
	  }
	  ?>
	  <section class="col col-3">
		<select name="correct2[]">
			<option value="0"<?php echo $selected2; ?>>Incorrect</option>
			<option value="1"<?php echo $selected1; ?>>Correct</option>
		</select>
      </section>	  

	  <?php endforeach;?>
	  <?php unset($answers);?>
    </div>
	<?php } ?>

	<?php if($row->type == 3){ ?>
	<div class="row">	  
	  <?php foreach ($arow as $answers):?>
	  <input name="ansid3[]" type="hidden" value="<?php echo $answers->id;?>" />
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer3[]" rows="5"><?php echo $answers->answer; ?></textarea>
		</div>
      </section>
	  <?php
	  if($answers->correct == 1){
		$selected1 = ' selected';
		$selected2 = '';
	  }else{
		$selected1 = '';
		$selected2 = ' selected';
	  }
	  
	  if($answers->banned == 0){
		$banned1 = ' selected';
		$banned2 = '';
	  }else{
		$banned1 = '';
		$banned2 = ' selected';
	  }
	  ?>
	  <section class="col col-3">
		<select name="correct3[]">
			<option value="0"<?php echo $selected2; ?>>Incorrect</option>
			<option value="1"<?php echo $selected1; ?>>Correct</option>
		</select>
		<br>
		<select name="banned3[]">
			<option value="0"<?php echo $banned1; ?>>Active</option>
			<option value="1"<?php echo $banned2; ?>>Disable</option>
		</select>
      </section>	  

	  <?php endforeach;?>
	  <?php unset($answers);?>
    </div>
	<?php } ?>

	<?php if($row->type == 4){ ?>
	<div class="row">	  
	  <?php foreach ($arow as $answers):?>
	    <input name="ansid4" type="hidden" value="<?php echo $answers->id;?>" />
		<section class="col col-12">
			<label class="input"> <i class="icon-append icon-asterisk"></i>
			  <input type="text" name="answer4" value="<?php echo $answers->answer; ?>" placeholder="write the answer">
			</label>
			<div class="note note-error">Answer for Question</div>
		</section>
	  <?php endforeach;?>
	  <?php unset($answers);?>
    </div>
	<?php } ?>
	
    <footer>
      <button class="button" name="dosubmit" type="submit">Update Question</button>
      <a href="index.php?do=questions" class="button button-secondary"><?php echo lang('CANCEL');?></a>
	</footer>
    <input name="client_id" type="hidden" value="<?php echo $row->client_id;?>" />
    <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
  </div>
</form>
<?php echo Core::doForm("updateQuestion");?> 
<?php break;?>
<?php case"add":?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('PROJ_NOPERM'), false); return; endif;?>
<?php $ptype = $content->getExamTypes();?>
<form class="xform" id="admin_form" method="post">
  <div class="subheader">
    <div class="row">
      <section class="col col-12"> Question<span>Add New Question</span> </section>
      <section class="col col-12">
        <div class="radio-toolbar" id="tabs">
          <input name="qtype" type="radio" id="radio1" value="1" /><label for="radio1">True/False</label>
          <input name="qtype" type="radio" id="radio2" value="2" /><label for="radio2">MCQ(1 from 4)</label>
          <input name="qtype" type="radio" id="radio3" value="3" /><label for="radio3">MCQ(multiple answer)</label>
          <input name="qtype" type="radio" id="radio4" value="4" /><label for="radio4">Writing</label>
        </div>
      </section>
    </div>
  </div>
  <div id="general" class="tab_content">
    <div class="row">
	  <section class="col col-9">
        <select name="examid">
          <option value=""> -- Select Exam --</option>
          <?php if ($ptype):?>
          <?php foreach ($ptype as $prow):?>
          <option value="<?php echo $prow->id;?>"<?php if($prow->id == get('id')) echo ' selected="selected"';?>><?php echo $prow->title;?></option>
          <?php endforeach;?>
          <?php unset($prow);?>
          <?php endif;?>
        </select>
        <div class="note note-error">Choose Exam</div>
      </section>
	  
	  <section class="col col-3">
        <label class="input"> <i class="icon-append icon-asterisk"></i>
          <input type="text" name="marks" value="" placeholder="Marks">
        </label>
        <div class="note note-error">Marks for Question</div>
      </section>
    </div>
    
	<section>
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="question" rows="5"></textarea>
      </div>
    </section>
	<hr>
	<section>
      <h2>Answer for Question</h2>
    </section>
	
	<div class="row" id="qtypea1">	  
	  <section class="col col-12">
		<div class="radio-toolbar" style="float: left;">
          <input name="answer1" type="radio" id="answer11" value="1" /><label for="answer11">True</label>
          <input name="answer1" type="radio" id="answer12" value="0" /><label for="answer12">False</label>
        </div>		
      </section>
    </div>
	<div class="row" id="qtypea2">	  
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer2[]" rows="5"></textarea>
		</div>
      </section>
	  <section class="col col-3">
		<select name="correct2[]">
			<option value="0">Incorrect</option>
			<option value="1">Correct</option>
		</select>
      </section>	  
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer2[]" rows="5"></textarea>
		</div>
      </section>
	  <section class="col col-3">
		<select name="correct2[]">
			<option value="0">Incorrect</option>
			<option value="1">Correct</option>
		</select>
      </section>	  
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer2[]" rows="5"></textarea>
		</div>
      </section>
	  <section class="col col-3">
		<select name="correct2[]">
			<option value="0">Incorrect</option>
			<option value="1">Correct</option>
		</select>
      </section>	  
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer2[]" rows="5"></textarea>
		</div>
      </section>
	  <section class="col col-3">
		<select name="correct2[]">
			<option value="0">Incorrect</option>
			<option value="1">Correct</option>
		</select>
      </section>
    </div>
	<div class="row input_fields_wrap" id="qtypea3">	  
	  <section class="col col-12">
        <button class="button add_field_button" style="float: left;">Add More Answer</button>
      </section>
	  <section class="col col-9">
		<div class="field-wrap">
			<textarea class="post" name="answer3[]" rows="5"></textarea>
		</div>
      </section>
	  <section class="col col-3">
		<select name="correct3[]">
			<option value="0">Incorrect</option>
			<option value="1">Correct</option>
		</select>
      </section>
    </div>
	<div class="row" id="qtypea4">	  
	  <section class="col col-12">
        <label class="input"> <i class="icon-append icon-asterisk"></i>
          <input type="text" name="answer4" value="" placeholder="write the answer">
        </label>
        <div class="note note-error">Answer for Question</div>
      </section>
    </div>
	
    <footer>
      <button class="button" name="dosubmit" type="submit">Add Question</button>
      <a href="index.php?do=questions" class="button button-secondary"><?php echo lang('CANCEL');?></a>
	</footer>
  </div>
</form>
<?php echo Core::doForm("processQuestion");?>
<script type="text/javascript">
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<section class="col col-9"> <div class="field-wrap"> <textarea class="post" name="answer3[]" rows="5"></textarea> </div> </section> <section class="col col-3"> <select name="correct3[]"> <option value="0">Incorrect</option> <option value="1">Correct</option> </select> </section>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
<script type="text/javascript"> 
// <![CDATA[
  $(document).ready(function(){
	$("input[name='qtype']").change(function () {
		var deger = $(this).val();

		if (deger == 1) {
			$("#qtypea1").show();
			$("#qtypea2").hide();
			$("#qtypea3").hide();
			$("#qtypea4").hide();
		}
		else if (deger == 2) {
			$("#qtypea1").hide();
			$("#qtypea2").show();
			$("#qtypea3").hide();
			$("#qtypea4").hide();
		}
		else if (deger == 3) {
			$("#qtypea1").hide();
			$("#qtypea2").hide();
			$("#qtypea3").show();
			$("#qtypea4").hide();
		}
		else{
			$("#qtypea1").hide();
			$("#qtypea2").hide();
			$("#qtypea3").hide();
			$("#qtypea4").show();
		}
	});
});
// ]]>
</script>
<?php break;?>
<?php case"details":?>
<?php $row = Core::getRowById("questions", Filter::$id);?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing Question</h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Back to Questions" href="index.php?do=questions"><span class="icon-hand-left"></span></a> </aside>
  </header>
  <div class="content2" style="padding: 10px;">
    <h2><?php echo $row->description; ?></h2>
	<?php $arow = $user->loadAnswer(Filter::$id);?>
	<?php $k = 1; $l = 0; ?>
	<?php foreach ($arow as $answers):?>
	
		<?php if($row->type == 1){?>	
		
			<br><?php echo $k; ?>) True <?php if($answers->correct == 1){ echo "(Correct)";} ?><br><br>
			<?php echo $k+1; ?>) False <?php if($answers->correct == 0){ echo "(Correct)";} ?>
			
		<?php } else if($row->type == 2){?>
		
			<br><?php echo $k; ?>) <?php echo $answers->answer; ?> <?php if($answers->correct == 1){ echo "(Correct)";} ?><br>
			
		<?php } else if($row->type == 3){?>
			
			<br><?php echo $k; ?>) <?php echo $answers->answer; ?> <?php if($answers->correct == 1){ echo "(Correct)";} ?><br>
			
		<?php } else if($row->type == 4){?>
			<label class="input <?php echo "correct-class"; ?>">
				Answer: <?php echo $answers->answer;?>
			</label>
		<?php } ?>
	
		<?php $k++; $l++; ?>

	<?php endforeach;?>
	<?php unset($answers);?>
	
  </div>
</section>
<?php break;?>
<?php default: ?>
<?php $projectrow = $content->getQuestions();?>
<?php $ptype = $content->getExamTypes();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> Viewing All Question</h1>
    <?php if($user->userlevel == 9):?>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Add Question" href="index.php?do=questions&amp;action=add"><span class="icon-plus"></span></a> </aside>
    <?php endif;?>
  </header>
  <div class="content2">
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
            <select name="select" id="examfilter">
              <option value="">-- Select Exam --</option>
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
    <?php echo Filter::msgInfo('No Question Found',false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header">Question Title</th>
          <th class="header">Exam Name</th>
          <th class="header">Question Type</th>
          <th class="header">Marks</th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($projectrow as $row):?>
      <tr>
        <td><?php echo $row->description;?></td>
        <td><?php echo $row->etitle;?></td>
        <td><?php if($row->type == 1){ echo 'True/False';}else if($row->type == 2){ echo 'MCQ(1 from 4)';} else if($row->type == 3){ echo 'MCQ(Multiple Answer)';} else if($row->type == 4){ echo 'Writing';} ?></td>
        <td><?php echo $row->marks;?></td>
		
        <td><span class="tbicon"> <a href="index.php?do=questions&amp;action=details&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="Question Details"><i class="icon-suitcase"></i></a> </span>
		<span class="tbicon"> <a href="index.php?do=questions&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->description;?>"><i class="icon-pencil"></i></a> </span>
        <?php if($user->userlevel == 9):?>
        <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->description;?>" data-title="<?php echo lang('DELETE').': '.$row->description;?>"><i class="icon-trash"></i></a> </span>
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
<?php echo Core::doDelete(lang('PROJ_DELETE'),"deleteQuestion");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#examfilter').change(function () {
		var res = $("#examfilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=questions' : window.location.href = 'index.php?do=questions&sort=' + res;
    })
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>