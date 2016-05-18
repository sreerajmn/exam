<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("users", Filter::$id);?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>

<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('STAFF_MEMBER');?><span><?php echo lang('CLIENT_SUB') . $row->fname.' '.$row->lname;?></span></header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" disabled="disabled" name="username" readonly="readonly" value="<?php echo $row->username;?>" placeholder="<?php echo lang('USERNAME');?>">
      </label>
      <div class="note"><?php echo lang('USERNAME');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-lock"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="password" placeholder="<?php echo lang('PASSWORD');?>">
      </label>
      <div class="note note-error"><?php echo lang('PASSWORD_T');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-envelope-alt"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="email" value="<?php echo $row->email;?>" placeholder="<?php echo lang('EMAIL');?>">
      </label>
      <div class="note"><?php echo lang('EMAIL');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-phone"></i>
        <input type="text" name="phone" value="<?php echo $row->phone;?>" placeholder="<?php echo lang('PHONE');?>">
      </label>
      <div class="note"><?php echo lang('PHONE');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="fname" value="<?php echo $row->fname;?>" placeholder="<?php echo lang('FNAME');?>">
      </label>
      <div class="note"><?php echo lang('FNAME');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="lname" value="<?php echo $row->lname;?>" placeholder="<?php echo lang('LNAME');?>">
      </label>
      <div class="note"><?php echo lang('LNAME');?></div>
    </section>
  </div>
  <hr>
  <div class="row">
    <section class="col col-5">
      <select name="country">
        <option value="0"><?php echo lang('COUNTRY');?></option>
        <?php foreach($content->getCountryList() as $country):?>
        <?php $sel = ($country->id == $row->country) ? " selected=\"selected\"" : "" ;?>
        <option value="<?php echo $country->id;?>"<?php echo $sel;?>><?php echo $country->name;?></option>
        <?php endforeach;?>
        <?php unset($country);?>
      </select>
      <div class="note note"><?php echo lang('COUNTRY');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-flag"></i>
        <input type="text" name="city" value="<?php echo $row->city;?>" placeholder="<?php echo lang('CITY');?>">
      </label>
      <div class="note note"><?php echo lang('CITY');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-pushpin"></i>
        <input type="text" name="zip" value="<?php echo $row->zip;?>" placeholder="<?php echo lang('ZIP');?>">
      </label>
      <div class="note"><?php echo lang('ZIP');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-building"></i>
        <input type="text" name="company" value="<?php echo $row->company;?>" placeholder="<?php echo lang('COMPANY');?>">
      </label>
      <div class="note"><?php echo lang('COMPANY');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-map-marker"></i>
        <input type="text" name="address" value="<?php echo $row->address;?>" placeholder="<?php echo lang('ADDRESS');?>">
      </label>
      <div class="note note"><?php echo lang('ADDRESS');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-umbrella"></i>
        <input type="text" name="state" value="<?php echo $row->state;?>" placeholder="<?php echo lang('STATE');?>">
      </label>
      <div class="note"><?php echo lang('STATE');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input">
        <input name="avatar" type="file" class="fileinput"/>
      </label>
      <div class="note"><?php echo lang('AVATAR');?></div>
    </section>
    <section class="col col-2"> <img src="../thumbmaker.php?src=<?php echo UPLOADURL;?>/avatars/<?php echo ($row->avatar) ? $row->avatar : "blank.png";?>&amp;w=40&amp;h=40&amp;s=1&amp;a=t1" alt="" title="" class="avatar" /> </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-credit-card"></i>
        <input type="text" name="vat" value="<?php echo $row->vat;?>" placeholder="<?php echo lang('UVAT');?>">
      </label>
      <div class="note"><?php echo lang('UVAT');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-money"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CLIENT_CURRENCY_T');?>"></i>
        <input type="text" name="currency" value="<?php echo $row->currency;?>" placeholder="<?php echo lang('CONF_CURRENCY');?>">
      </label>
      <div class="note"><?php echo lang('CONF_CURRENCY');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-calendar"></i>
        <input type="text" disabled="disabled" readonly="readonly" name="created" value="<?php echo $row->created;?>" placeholder="<?php echo lang('CREATED');?>">
      </label>
      <div class="note"><?php echo lang('CREATED');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-calendar"></i>
        <input type="text" disabled="disabled" readonly="readonly" name="lastlogin" value="<?php echo $row->lastlogin;?>" placeholder="<?php echo lang('STAFF_LASTLOGIN');?>">
      </label>
      <div class="note"><?php echo lang('STAFF_LASTLOGIN');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-laptop"></i>
        <input type="text" disabled="disabled" readonly="readonly" name="lastip" value="<?php echo $row->lastip;?>" placeholder="<?php echo lang('STAFF_LASTIP');?>">
      </label>
      <div class="note"><?php echo lang('STAFF_LASTIP');?></div>
    </section>
  </div>
  <hr>
  <?php echo $content->rendertCustomFields('c', $row->custom_fields);?>
  <div class="row">
    <section>
      <label class="textarea">
        <textarea name="notes" placeholder="<?php echo lang('NOTES');?>" rows="3"><?php echo $row->notes;?></textarea>
      </label>
      <div class="note"><?php echo lang('NOTES');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('STAFF_UPDATE');?></button>
    <a href="index.php?do=clients" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
  <input name="username" type="hidden" value="<?php echo $row->username;?>" />
  <input name="userlevel" type="hidden" value="1" />
</form>
<?php echo $core->doForm("processUser");?>
<?php break;?>
<?php case"add": ?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>

<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('STAFF_MEMBER');?><span><?php echo lang('CLIENT_SUB1');?></span></header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="username" placeholder="<?php echo lang('USERNAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('REQFIELD3');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-lock"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="password" placeholder="<?php echo lang('PASSWORD');?>">
      </label>
      <div class="note note-error"><?php echo lang('REQFIELD3');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-envelope-alt"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="email" placeholder="<?php echo lang('EMAIL');?>">
      </label>
      <div class="note note-error"><?php echo lang('REQFIELD3');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-phone"></i>
        <input type="text" name="phone" placeholder="<?php echo lang('PHONE');?>">
      </label>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="fname" placeholder="<?php echo lang('FNAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('REQFIELD3');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="lname" placeholder="<?php echo lang('LNAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('REQFIELD3');?></div>
    </section>
  </div>
  <hr>
  <div class="row">
    <section class="col col-5">
      <select name="country">
        <option disabled="" selected="" value="0"><?php echo lang('COUNTRY');?></option>
        <?php foreach($content->getCountryList() as $country):?>
        <option value="<?php echo $country->id;?>"><?php echo $country->name;?></option>
        <?php endforeach;?>
        <?php unset($country);?>
      </select>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-flag"></i>
        <input type="text" name="city" placeholder="<?php echo lang('CITY');?>">
      </label>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-pushpin"></i>
        <input type="text" name="zip" placeholder="<?php echo lang('ZIP');?>">
      </label>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-building"></i>
        <input type="text" name="company" placeholder="<?php echo lang('COMPANY');?>">
      </label>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-map-marker"></i>
        <input type="text" name="address" placeholder="<?php echo lang('ADDRESS');?>">
      </label>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-umbrella"></i>
        <input type="text" name="state" placeholder="<?php echo lang('STATE');?>">
      </label>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input">
        <input name="avatar" type="file" class="fileinput"/>
      </label>
      <div class="note note"><?php echo lang('AVATAR');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-credit-card"></i>
        <input type="text" name="vat" placeholder="<?php echo lang('UVAT');?>">
      </label>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-money"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('CLIENT_CURRENCY_T');?>"></i>
        <input type="text" name="currency" placeholder="<?php echo lang('CONF_CURRENCY');?>">
      </label>
    </section>
  </div>
  <hr>
  <?php echo $content->rendertCustomFields('c', false);?>
  <div class="row">
    <section>
      <label class="checkbox">
        <input type="checkbox" name="notify" value="1">
        <i></i><?php echo lang('STAFF_NOTIFY');?></label>
      <div class="note note-info"><?php echo lang('STAFF_NOTIFY_T');?></div>
    </section>
  </div>
  <div class="row">
    <section>
      <label class="textarea">
        <textarea name="notes" placeholder="<?php echo lang('NOTES');?>" rows="3"></textarea>
      </label>
    </section>
  </div>
  <input name="userlevel" type="hidden" value="1" />
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('CLIENT_ADD');?></button>
    <a href="index.php?do=clients" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
<?php echo $core->doForm("processUser");?>
<?php break;?>
<?php default: ?>
<?php $clientrow = $user->getClients();?>

<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('CLIENT_SUB2');?></h1>
    <?php if($user->userlevel == 9):?>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('CLIENT_ADD');?>" href="index.php?do=clients&amp;action=add"><span class="icon-plus"></span></a> </aside>
    <?php endif;?>
  </header>
  <div class="content2">
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
            <select name="select" id="clientfilter">
              <option value="NA"><?php echo lang('CLIENT_RESET');?></option>
              <?php echo $user->getClientFilter();?>
            </select>
          </section>
          <section class="col col-3"> <?php echo $pager->items_per_page();?> </section>
          <section class="col col-3"> <?php echo $pager->jump_menu();?> </section>
          <div class="hr2"></div>
          <section class="col col-5">
            <label class="input"> <i class="icon-prepend icon-calendar"></i>
              <input type="text" name="fromdate"  id="fromdate" placeholder="<?php echo lang('FROM');?>">
            </label>
          </section>
          <section class="col col-5">
            <label class="input"> <i class="icon-prepend icon-calendar"></i>
              <input type="text" name="enddate"  id="enddate" placeholder="<?php echo lang('TO');?>">
            </label>
          </section>
          <section class="col col-2">
            <button class="button inline" name="find" type="submit"><?php echo lang('FIND');?></button>
          </section>
        </form>
      </div>
    </div>
    <?php if(!$clientrow):?>
	<?php echo Filter::msgAlert(lang('CLIENT_NOCLIENTS'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('NAME');?></th>
          <th class="header"><?php echo lang('COMPANY');?></th>
          <?php if($user->userlevel == 9):?>
          <th class="header"><?php echo lang('EMAIL');?></th>
          <?php endif;?>
          <?php if($user->userlevel == 9):?>
          <th class="header"><?php echo lang('ACTIONS');?></th>
          <?php endif;?>
        </tr>
      </thead>
      <?php foreach ($clientrow as $row):?>
      <tr>
        <td><img src="../thumbmaker.php?src=<?php echo UPLOADURL;?>/avatars/<?php echo ($row->avatar) ? $row->avatar : "blank.png";?>&amp;w=40&amp;h=40&amp;s=1&amp;a=t1" alt="" class="avatar2"/><?php echo $row->fullname;?></td>
        <td><?php echo $row->company;?></td>
        <?php if($user->userlevel == 9):?>
        <td><a href="index.php?do=email&amp;emailid=<?php echo urlencode($row->email);?>"><?php echo $row->email;?></a></td>
        <?php endif;?>
        <?php if($user->userlevel == 9):?>
        <td><span class="tbicon"> <a href="index.php?do=clients&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->fullname;?>"><i class="icon-pencil"></i></a> </span>
          <?php if($user->userlevel == 9):?>
          <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->username;?>" data-title="<?php echo lang('DELETE').': '.$row->username;?>"><i class="icon-trash"></i></a> </span>
          <?php endif;?></td>
        <?php endif;?>
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
<?php echo Core::doDelete(lang('CLIENT_DELCLIENT'),"deleteUser");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('a.do-funds').on('click', function () {
        var id = $(this).attr('id').replace('list_', '');
        var text = "<form action=\"#\" class=\"xform\">";
        text += "<p class=\"pagetip\"><?php echo lang('CLIENT_ADDCREDIT_I');?></p>";
        text += "<label class=\"input\">";
        text += "<i class=\"icon-append icon-money\"></i><input name=\"amount\" id=\"total-amount\" placeholder=\"<?php echo lang('CLIENT_ADDCREDIT_I1');?>\" type=\"text\">";
        text += "</label>";
        text += "<input name=\"uid\" id=\"uid\" type=\"hidden\" value=\"" + id + "\" /></form>";

        new Messi(text, {
            title: "<?php echo lang('CLIENT_ADDCREDIT_T');?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo lang('SUBMIT');?>",
                val: 'Y'
            }]
        });
		
		$('body').on('click', '.messi a.mod-button', function () {
			$.ajax({
				type: 'post',
				url: "controller.php",
				data: {
					'addClientFunds': $("#uid").val(),
					'amount': $("#total-amount").val()
				},
				success: function (res) {
					setTimeout(function () {
						$("#get-funds_" + id).html(res).effect("highlight", {}, 1500);
					}, 500);
				}
			});
		});
    });
    $('#clientfilter').change(function () {
        var res = $("#clientfilter option:selected").val();
        (res == "NA") ? window.location.href = 'index.php?do=clients' : window.location.href = 'index.php?do=clients&sort=' + res;
    })

    var dates = $('#fromdate, #enddate').datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd',
        onSelect: function (selectedDate) {
            var option = this.id == "fromdate" ? "minDate" : "maxDate";
            var instance = $(this).data("datepicker");
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });

});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>