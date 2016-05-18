<?php
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('CONF_SUB');?></header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_COMPANY_T');?>"></i>
        <input type="text" name="company" value="<?php echo $core->company;?>" placeholder="<?php echo lang('CONF_COMPANY');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_COMPANY');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_URL_T');?>"></i>
        <input type="text" name="site_url" value="<?php echo $core->site_url;?>" placeholder="<?php echo lang('CONF_URL');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_URL');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_EMAIL_T');?>"></i>
        <input type="text" name="site_email" value="<?php echo $core->site_email;?>" placeholder="<?php echo lang('CONF_EMAIL');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_EMAIL');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="address" value="<?php echo $core->address;?>" placeholder="<?php echo lang('CONF_ADDRESS');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_ADDRESS');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="city" value="<?php echo $core->city;?>" placeholder="<?php echo lang('CONF_CITY');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_CITY');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="state" value="<?php echo $core->state;?>" placeholder="<?php echo lang('CONF_STATE');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_STATE');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="zip" value="<?php echo $core->zip;?>" placeholder="<?php echo lang('CONF_ZIP');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_ZIP');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="phone" value="<?php echo $core->phone;?>" placeholder="<?php echo lang('CONF_PHONE');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_PHONE');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="fax" value="<?php echo $core->fax;?>" placeholder="<?php echo lang('CONF_FAX');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_FAX');?></div>
    </section>
  </div>
  <hr>
  <section>
    <div class="row">
      <div class="col col-4">
        <label class="label"><?php echo lang('CONF_OFFLINE');?></label>
        <label class="radio">
          <input type="radio" name="enable_offline" value="1" <?php getChecked($core->enable_offline, 1); ?>>
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" name="enable_offline" value="0" <?php getChecked($core->enable_offline, 0); ?>>
          <i></i><?php echo lang('NO');?></label>
      </div>
      <div class="col col-8">
        <label class="label"><?php echo lang('CONF_OFFLINEINFO');?></label>
        <label class="textarea">
          <textarea name="offline_info" placeholder="<?php echo lang('CONF_OFFLINEINFO');?>" rows="3"><?php echo $core->offline_info;?></textarea>
        </label>
      </div>
    </div>
  </section>
  <div class="row">

    <input type="hidden" name="quote_number" value="<?php echo $core->quote_number;?>" placeholder="<?php echo lang('CONF_QTYNUMBER');?>">
	
    <section class="col col-3">
      <label class="input"> <i class="icon-append icon-exclamation-sign tooltip" data-title="Exam Passing Score"></i>
        <input type="text" name="passing_score" value="<?php echo $core->passing_score;?>" placeholder="Exam Passing Score">
      </label>
      <div class="note note">Exam Passing Score</div>
    </section>
	<section class="col col-3">
      <label class="input"> <i class="icon-append icon-exclamation-sign tooltip" data-title="<?php echo lang('CONF_INVNUMBER_T');?>"></i>
        <input type="text" name="invoice_number" value="<?php echo $core->invoice_number;?>" placeholder="<?php echo lang('CONF_INVNUMBER');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_INVNUMBER');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input name="logo" type="file" class="fileinput"/>
      </label>
      <div class="note note"><?php echo lang('CONF_LOGO');?></div>
    </section>
    <section class="col col-2">
      <div class="inline-group">
        <label class="checkbox">
          <input name="dellogo" type="checkbox" value="1" class="checkbox"/>
          <i></i><?php echo lang('CONF_DELLOGO');?></label>
      </div>
      <div class="note note"><?php echo lang('CONF_DELLOGO_T');?></div>
    </section>
  </div>
  <div class="row">
    <section>
      <label class="textarea textarea-resizable"><i class="icon-append icon-exclamation-sign tooltip" data-title="<?php echo lang('INVC_NOTE_T');?>"></i>
        <textarea name="invoice_note" placeholder="<?php echo lang('CONF_INVNOTE');?>" rows="3"><?php echo $core->invoice_note;?></textarea>
      </label>
      <div class="note note"><?php echo lang('CONF_INVNOTE');?></div>
    </section>
  </div>
  <hr>

  <div class="row">
    <section>
      <label class="textarea textarea-resizable"><i class="icon-append icon-exclamation-sign tooltip" data-title="Google Analytics Code"></i>
        <textarea name="google_analytics" placeholder="Google Analytics Code" rows="3"><?php echo $core->google_analytics;?></textarea>
      </label>
      <div class="note note">Google Analytics Code</div>
    </section>
  </div>
  <hr>
  
  
  
  
  <div class="row">
    <section class="col col-4">
      <label class="input"> 
        <input type="text" name="social_gplus" value="<?php echo $core->social_gplus;?>" placeholder="Google Plus Profile URl">
      </label>
      <div class="note note-error">Google Plus Profile URl</div>
    </section>
	<section class="col col-4">
      <label class="input"> 
        <input type="text" name="social_twitter" value="<?php echo $core->social_twitter;?>" placeholder="Twitter Profile URl">
      </label>
      <div class="note note-error">Twitter Profile URl</div>
    </section>
	<section class="col col-4">
      <label class="input"> 
        <input type="text" name="social_facebook" value="<?php echo $core->social_facebook;?>" placeholder="Facebook Profile URl">
      </label>
      <div class="note note-error">Facebook Profile URl</div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"> 
        <input type="text" name="social_pinterest" value="<?php echo $core->social_pinterest;?>" placeholder="Pinterest Profile URl">
      </label>
      <div class="note note-error">Pinterest Profile URl</div>
    </section>
	<section class="col col-4">
      <label class="input"> 
        <input type="text" name="social_linkedin" value="<?php echo $core->social_linkedin;?>" placeholder="LinkedIn Profile URl">
      </label>
      <div class="note note-error">LinkedIn Profile URl</div>
    </section>
	<section class="col col-4">
      <label class="input"> 
        <input type="text" name="social_rss" value="<?php echo $core->social_rss;?>" placeholder="RSS URl">
      </label>
      <div class="note note-error">Rss URl</div>
    </section>
  </div>
  
  
  
  
  
  
  
  <hr>
  <div class="row">
    <section class="col col-3">
      <label class="label"><?php echo lang('CONF_SDATE');?></label>
      <select name="short_date">
        <?php echo $core->getShortDate();?>
      </select>
    </section>
    <section class="col col-4">
      <label class="label"><?php echo lang('CONF_LDATE');?></label>
      <select name="long_date">
        <?php echo $core->getLongDate();?>
      </select>
    </section>
    <section class="col col-5">
      <label class="label"><?php echo lang('CONF_TZ');?></label>
      <select name="dtz">
        <?php echo $core->getTimezones();?>
      </select>
    </section>
  </div>
  <div class="row">
    <section class="col col-12">
      <label class="label"><?php echo lang('CONF_LANG');?></label>
      <select name="lang">
        <?php foreach($core->fetchLanguage() as $langlist):?>
        <option value="<?php echo $langlist;?>"<?php if($core->lang == $langlist) echo ' selected="selected"';?>><?php echo strtoupper($langlist);?></option>
        <?php endforeach;?>
      </select>
    </section>
  </div>
  <hr>
  <div class="row">
    <section class="col col-12">
      <label class="label"><?php echo lang('CONF_REGYES');?></label>
      <label class="radio">
        <input type="radio" name="enable_reg" value="1" <?php getChecked($core->enable_reg, 1); ?>>
        <i></i><?php echo lang('YES');?></label>
      <label class="radio">
        <input type="radio" name="enable_reg" value="0" <?php getChecked($core->enable_reg, 0); ?>>
        <i></i><?php echo lang('NO');?></label>
      <div class="note note"><?php echo lang('CONF_REGYES_T');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_CURRENCY_T');?>"></i>
        <input type="text" name="currency" value="<?php echo $core->currency;?>" placeholder="<?php echo lang('CONF_CURRENCY');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_CURRENCY');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_CURSYMBOL_T');?>"></i>
        <input type="text" name="cur_symbol" value="<?php echo $core->cur_symbol;?>" placeholder="<?php echo lang('CONF_CURSYMBOL');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_CURSYMBOL');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="tsep" value="<?php echo $core->tsep;?>" placeholder="<?php echo lang('CONF_TSEP');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_TSEP');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="dsep" value="<?php echo $core->dsep;?>" placeholder="<?php echo lang('CONF_DSEP');?>">
      </label>
      <div class="note note-error"><?php echo lang('CONF_DSEP');?></div>
    </section>
  </div>
  <hr>
  <div class="row">
    <section class="col col-12">
      <label class="label"><?php echo lang('CONF_PPMASSLIVE');?></label>
      <label class="radio">
        <input type="radio" name="pp_mode" value="1" <?php getChecked($core->pp_mode, 1); ?>>
        <i></i><?php echo lang('YES');?></label>
      <label class="radio">
        <input type="radio" name="pp_mode" value="0" <?php getChecked($core->pp_mode, 0); ?>>
        <i></i><?php echo lang('NO');?></label>
    </section>
  </div>

  <hr />
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="perpage" value="<?php echo $core->perpage;?>" placeholder="<?php echo lang('CONF_IPP');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_IPP');?></div>
    </section>
    <section class="col col-4">
      <label class="input"><i class="icon-append icon-exclamation-sign tooltip" data-title="<?php echo lang('CONF_INVREMINDER_T');?>"></i>
        <input type="text" name="invdays" value="<?php echo $core->invdays;?>" placeholder="<?php echo lang('CONF_INVREMINDER');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_INVREMINDER');?></div>
    </section>
    <section class="col col-4">
      <select name="theme">
        <?php getTemplates(BASEPATH."/theme/", $core->theme)?>
      </select>
      <div class="note note"><?php echo lang('CONF_THEME');?></div>
    </section>
  </div>
  <hr />
  <header><?php echo lang('CONF_MAILER');?></header>
  <div class="row">
    <section class="col col-6">
      <select name="mailer" id="mailerchange">
        <option value="PHP"<?php if ($core->mailer == "PHP") echo " selected=\"selected\"";?>>PHP Mailer</option>
        <option value="SMTP"<?php if ($core->mailer == "SMTP") echo " selected=\"selected\"";?>>SMTP Mailer</option>
        <option value="SMAIL"<?php if ($core->mailer == "SMAIL") echo " selected=\"selected\"";?>>Sendmail</option>
      </select>
      <div class="note note"><?php echo lang('CONF_MAILER_T');?></div>
    </section>
  </div>
  <div class="row showsmail">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_SMAILPATH_T');?>"></i>
        <input type="text" name="sendmail" value="<?php echo $core->sendmail;?>" placeholder="<?php echo lang('CONF_SMAILPATH');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_SMAILPATH');?></div>
    </section>
  </div>
  <div class="row showsmtp">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_SMTP_HOST_T');?>"></i>
        <input type="text" name="smtp_host" value="<?php echo $core->smtp_host;?>" placeholder="<?php echo lang('CONF_SMTP_HOST');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_SMTP_HOST');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="smtp_user" value="<?php echo $core->smtp_user;?>" placeholder="<?php echo lang('CONF_SMTP_USER');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_SMTP_USER');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="smtp_pass" value="<?php echo $core->smtp_pass;?>" placeholder="<?php echo lang('CONF_SMTP_PASS');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_SMTP_PASS');?></div>
    </section>
  </div>
  <div class="row showsmtp">
    <section class="col col-4">
      <label class="label"><?php echo lang('CONF_SMTP_SSL');?></label>
      <label class="radio">
        <input type="radio" name="is_ssl" value="1" <?php getChecked($core->is_ssl, 1); ?>>
        <i></i><?php echo lang('YES');?></label>
      <label class="radio">
        <input type="radio" name="is_ssl" value="0" <?php getChecked($core->is_ssl, 0); ?>>
        <i></i><?php echo lang('NO');?></label>
      <div class="note note"><?php echo lang('CONF_SMTP_SSL_T');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CONF_SMTP_PORT_T');?>"></i>
        <input type="text" name="smtp_port" value="<?php echo $core->smtp_port;?>" placeholder="<?php echo lang('CONF_SMTP_PORT');?>">
      </label>
      <div class="note note"><?php echo lang('CONF_SMTP_PORT');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('CONF_UPDATE');?></button>
  </footer>
</form>
<?php echo Core::doForm("processConfig");?> 
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	var res2 = '<?php echo $core->mailer;?>';
		(res2 == "SMTP" ) ? $('.showsmtp').show() : $('.showsmtp').hide();
    $('#mailerchange').change(function () {
		var res = $("#mailerchange option:selected").val();
		(res == "SMTP" ) ? $('.showsmtp').show() : $('.showsmtp').hide();
	});
	
    (res2 == "SMAIL") ? $('.showsmail').show() : $('.showsmail').hide();
    $('#mailerchange').change(function () {
        var res = $("#mailerchange option:selected").val();
        (res == "SMAIL") ? $('.showsmail').show() : $('.showsmail').hide();
    });
});
// ]]>
</script>