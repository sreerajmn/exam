<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php $userdata = $user->getAllUsers();?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('MAIL_TITLE');?><span><?php echo lang('MAIL_SUB');?></span></header>
  <div class="row">
    <section class="col col-6">
      <label class="input state-disabled">
        <input name="title" type="text" disabled="disabled" value="<?php echo $core->site_email;?>" placeholder="<?php echo lang('MAIL_FROM');?>" readonly="readonly">
      </label>
      <div class="note"><?php echo lang('MAIL_FROM');?></div>
    </section>
    <section class="col col-6">
      <?php if(isset(Filter::$get['emailid'])):?>
      <label class="input">
      <input name="recipient" type="text" value="<?php echo sanitize(Filter::$get['emailid']);?>" placeholder="<?php echo lang('MAIL_REC');?>" >
      </label>
      <?php else:?>
      <select name="recipient" id="multiusers">
        <option value="all"><?php echo lang('MAIL_REC_ALL');?></option>
        <option value="clients"><?php echo lang('MAIL_REC_C');?></option>
        <option value="staff"><?php echo lang('MAIL_REC_S');?></option>
        <option value="multiple"><?php echo lang('MAIL_REC_M');?></option>
      </select>
      <?php endif;?>
      <div class="note"><?php echo lang('MAIL_REC');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input name="subject" type="text"  placeholder="<?php echo lang('MAIL_REC_SUJECT');?>">
      </label>
      <div class="note note-error"><?php echo lang('MAIL_REC_SUJECT');?></div>
    </section>
    <section class="col col-6 multiuserList" style="display:none">
      <div class="scrollbox" style="min-height:150px">
      <?php if($userdata):?>
      <?php $class = 'odd';?>
      <?php foreach ($userdata as $udata):?>
      <?php $class = ($class == 'even' ? 'odd' : 'even');?>
      <div class="<?php echo $class;?>">
        <label class="checkbox">
          <input type="checkbox" value="<?php echo $udata->id;?>" name="multilist[]">
          <i></i><?php echo $udata->name.' - '.$udata->username;?></label>
      </div>
      <?php endforeach;?>
      <?php unset($udata);?>
      <?php endif;?>
    </section>
  </div>
  <?php if(isset(Filter::$get['emailid'])):?>
  <div class="row">
    <section class="col col-6">
      <label class="input">
        <input name="logo" type="file" class="fileinput"/>
      </label>
      <div class="note"><?php echo lang('MAIL_REC_ATTACH');?></div>
    </section>
  </div>
  <?php endif;?>
  <hr />
  <div class="row">
    <section class="col col-12">
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="body" rows="20">&lt;div style=&quot;font-family:Arial, Helvetica, sans-serif; font-size:13px;margin:20px&quot; align=&quot;center&quot;&gt;
  &lt;table style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 2px solid #bbbbb;&quot; border=&quot;0&quot; cellpadding=&quot;10&quot; cellspacing=&quot;5&quot; width=&quot;650&quot;&gt;
    &lt;tbody&gt;
      &lt;tr&gt;
        &lt;th style=&quot;background-color: rgb(204, 204, 204); font-size:16px;padding:5px;border-bottom-width:2px; border-bottom-color:#fff; border-bottom-style:solid&quot;&gt;[LOGO]&lt;/th&gt;
      &lt;/tr&gt;
      &lt;tr&gt;
        &lt;td style=&quot;text-align: left;&quot; valign=&quot;top&quot;&gt;Hello [NAME],

      &lt;tr&gt;
        &lt;td style=&quot;text-align: left;&quot; valign=&quot;top&quot;&gt;Place your content here...&lt;/td&gt;
      &lt;/tr&gt;
      &lt;tr&gt;
        &lt;td style=&quot;text-align: left;&quot; valign=&quot;top&quot;&gt;&lt;em&gt;Thank You,&lt;br/&gt;
          &lt;a href=&quot;[URL]&quot;&gt;[COMPANY]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;
      &lt;/tr&gt;
      &lt;tr&gt;
        &lt;td style=&quot;text-align: left; background-color:#fff;border-top-width:2px; border-top-color:#ccc; border-top-style:solid;font-size:12px&quot; valign=&quot;top&quot;&gt; This email is sent to you directly from&amp;nbsp;&lt;a href=&quot;[URL]&quot;&gt;[COMPANY]&lt;/a&gt; The information above is gathered from the user input.&lt;br/&gt;
          &copy;[YEAR] &lt;a href=&quot;[URL]&quot;&gt;[COMPANY]&lt;/a&gt;. All rights reserved.&lt;/td&gt;
      &lt;/tr&gt;
    &lt;/tbody&gt;
  &lt;/table&gt;
&lt;/div&gt;</textarea>
      </div>
      <div class="label2 label-important"><?php echo lang('MAIL_NOTE');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('MAIL_SEND');?></button>
  </footer>
</form>
<?php echo Core::doForm("processEmail");?> 
<script type="text/javascript">
  $(document).ready(function() {
    $('#multiusers').change(function () {
		var option = $("#multiusers option:selected").val();
		(option == 'multiple') ? $('.multiuserList').show() : $('.multiuserList').hide()
    });
  });
</script> 