<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php $row = Core::getRowById("users", Filter::$id);?>
<?php if($user->userlevel == 5 and $user->uid != Filter::$id): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('STAFF_MEMBER');?><span><?php echo lang('STAFF_SUB') . $row->fname.' '.$row->lname;?></span></header>
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
      <div class="note note"><?php echo lang('EMAIL');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-phone"></i>
        <input type="text" name="phone" value="<?php echo $row->phone;?>" placeholder="<?php echo lang('PHONE');?>">
      </label>
      <div class="note note"><?php echo lang('PHONE');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="fname" value="<?php echo $row->fname;?>" placeholder="<?php echo lang('FNAME');?>">
      </label>
      <div class="note note"><?php echo lang('FNAME');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-user"></i> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="lname" value="<?php echo $row->lname;?>" placeholder="<?php echo lang('LNAME');?>">
      </label>
      <div class="note note"><?php echo lang('LNAME');?></div>
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
      <div class="note note"><?php echo lang('ZIP');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input">
        <input name="avatar" type="file" class="fileinput"/>
      </label>
      <div class="note note"><?php echo lang('AVATAR');?></div>
    </section>
    <section class="col col-4"> <img src="../thumbmaker.php?src=<?php echo UPLOADURL;?>/avatars/<?php echo ($row->avatar) ? $row->avatar : "blank.png";?>&amp;w=40&amp;h=40&amp;s=1&amp;a=t1" alt="" title="" class="avatar" /> </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-map-marker"></i>
        <input type="text" name="address" value="<?php echo $row->address;?>" placeholder="<?php echo lang('ADDRESS');?>">
      </label>
      <div class="note note"><?php echo lang('ADDRESS');?></div>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-umbrella"></i>
        <input type="text" name="state" value="<?php echo $row->state;?>" placeholder="<?php echo lang('STATE');?>">
      </label>
      <div class="note note"><?php echo lang('STATE');?></div>
    </section>
    <input type="hidden" name="pp_email" value="<?php echo $row->pp_email;?>" placeholder="<?php echo lang('PPEMAIL');?>">
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-calendar"></i>
        <input type="text" disabled="disabled" readonly="readonly" name="created" value="<?php echo $row->created;?>" placeholder="<?php echo lang('CREATED');?>">
      </label>
      <div class="note note"><?php echo lang('CREATED');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-calendar"></i>
        <input type="text" disabled="disabled" readonly="readonly" name="lastlogin" value="<?php echo $row->lastlogin;?>" placeholder="<?php echo lang('STAFF_LASTLOGIN');?>">
      </label>
      <div class="note note"><?php echo lang('STAFF_LASTLOGIN');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-laptop"></i>
        <input type="text" disabled="disabled" readonly="readonly" name="lastip" value="<?php echo $row->lastip;?>" placeholder="<?php echo lang('STAFF_LASTIP');?>">
      </label>
      <div class="note note"><?php echo lang('STAFF_LASTIP');?></div>
    </section>
  </div>
  <hr>
  <?php echo $content->rendertCustomFields('s', $row->custom_fields);?>
  <?php if($user->userlevel == 9):?>
  <header><?php echo lang('STAFF_ACCLEVEL');?></header>
  <section>
    <div>
      <label class="radio">
        <input type="radio" name="userlevel" value="9" <?php getChecked($row->userlevel, 9); ?>>
        <i></i><?php echo lang('ADMIN');?></label>
      <label class="radio">
        <input type="radio" name="userlevel" value="5" <?php getChecked($row->userlevel, 5); ?>>
        <i></i><?php echo lang('STAFF');?></label>
      <div class="note note-info"><?php echo lang('STAFF_ACCLEVEL_T');?></div>
    </div>
  </section>
  <?php endif;?>
  <div class="row">
    <section>
      <label class="textarea">
        <textarea name="notes" placeholder="<?php echo lang('NOTES');?>" rows="3"><?php echo $row->notes;?></textarea>
      </label>
      <div class="note note"><?php echo lang('NOTES');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('STAFF_UPDATE');?></button>
    <a href="index.php?do=users" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <?php if($user->userlevel == 5):?>
  <input name="userlevel" type="hidden" value="5" />
  <?php endif;?>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
  <input name="username" type="hidden" value="<?php echo $row->username;?>" />
</form>
<?php echo Core::doForm("processUser");?>
<?php break;?>
<?php case"add": ?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('STAFF_MEMBER');?><span><?php echo lang('STAFF_SUB1');?></span></header>
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
      <label class="input">
        <input name="avatar" type="file" class="fileinput"/>
      </label>
      <div class="note note"><?php echo lang('AVATAR');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-map-marker"></i>
        <input type="text" name="address" placeholder="<?php echo lang('ADDRESS');?>">
      </label>
    </section>
    <section class="col col-6">
      <label class="input"> <i class="icon-prepend icon-umbrella"></i>
        <input type="text" name="state" placeholder="<?php echo lang('STATE');?>">
      </label>
    </section>
    <input type="hidden" name="pp_email" placeholder="<?php echo lang('PPEMAIL');?>">
  </div>
  <hr>
  <?php echo $content->rendertCustomFields('s', false);?>
  <header><?php echo lang('STAFF_ACCLEVEL');?></header>
  <section>
    <div>
      <label class="radio">
        <input type="radio" name="userlevel" value="9">
        <i></i><?php echo lang('ADMIN');?></label>
      <label class="radio">
        <input type="radio" name="userlevel" checked="checked" value="5">
        <i></i><?php echo lang('STAFF');?></label>
      <div class="note note-info"><?php echo lang('STAFF_ACCLEVEL_T');?></div>
      <label class="checkbox">
        <input type="checkbox" name="notify" value="1">
        <i></i><?php echo lang('STAFF_NOTIFY');?></label>
      <div class="note note-info"><?php echo lang('STAFF_NOTIFY_T');?></div>
    </div>
  </section>
  <div class="row">
    <section>
      <label class="textarea">
        <textarea name="notes" placeholder="<?php echo lang('NOTES');?>" rows="3"></textarea>
      </label>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('STAFF_ADD');?></button>
    <a href="index.php?do=users" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
</form>
<?php echo Core::doForm("processUser");?>
<?php break;?>
<?php case"view": ?>
<?php if($user->userlevel == 5 and $user->uid != Filter::$id): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php $payrow = $user->getStafPaymentHistory();?>
<section class="widget">
  <header>
    <h1><i class="icon-group"></i> <?php echo lang('STAFF_SUB3') . $user->name;?></h1>
  </header>
  <div class="content2">
    <?php if(!$payrow):?>
    <?php echo Filter::msgInfo(lang('CLIENT_NOTXN'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th class="left"><?php echo lang('STAFF_PPTXN');?></th>
          <th class="left"><?php echo lang('INVC_PAID');?></th>
          <th class="left"><?php echo lang('CREATED');?></th>
          <th class="left"><?php echo lang('NOTES');?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($payrow as $row):?>
        <tr>
          <td><?php echo $row->txn_id;?></td>
          <td><?php echo $row->amount . ' ' . $row->currency;?></td>
          <td><?php echo Filter::dodate($core->long_date, $row->created);?></td>
          <td><?php echo cleanOut($row->note);?></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
      </tbody>
    </table>
    <?php endif;?>
  </div>
</section>
<?php break;?>
<?php default: ?>
<?php $userrow = $user->getUsers();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('STAFF_SUB2');?></h1>
    <?php if($user->userlevel == 9):?>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('STAFF_ADD');?>" href="index.php?do=users&amp;action=add"><span class="icon-plus"></span></a> </aside>
    <?php endif;?>
  </header>
  <div class="content2">
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('NAME');?></th>
          <th class="header"><?php echo lang('EMAIL');?></th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($userrow as $row):?>
      <tr>
        <td><img src="../thumbmaker.php?src=<?php echo UPLOADURL;?>/avatars/<?php echo ($row->avatar) ? $row->avatar : "blank.png";?>&amp;w=40&amp;h=40&amp;s=1&amp;a=t1" alt="" class="avatar2"/><?php echo $row->fname . ' ' . $row->lname;?></td>
        <td><a href="index.php?do=email&amp;emailid=<?php echo urlencode($row->email);?>"><?php echo $row->email;?></a></td>
        <td><span class="tbicon"> <a href="index.php?do=users&amp;action=edit&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->username;?>"><i class="icon-pencil"></i></a> </span>
          <?php if($user->userlevel == 9):?>
          <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->username;?>" data-title="<?php echo lang('DELETE').': '.$row->username;?>"><i class="icon-trash"></i></a> </span>
          <?php endif;?></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </table>
  </div>
</section>
<?php if($user->userlevel == 9):?>
<?php echo Core::doDelete(lang('STAFF_DELUSER'),"deleteUser");?> 
<script type="text/javascript"> 
// <![CDATA[
function showLoader() {
    $("#loader").fadeIn(200);
}

function hideLoader() {
    $("#loader").fadeOut(200);
};

$(document).ready(function () {
    $('a.addpay').on('click', function () {
        var uid = $(this).attr('id').replace('uid_', '')
        var parent = $(this).parent().parent();
		  $.ajax({
			  type: 'post',
			  url: "controller.php",
			  data: {
				  getUserInfo: 1,
				  id: uid,
			  },
			  cache: false,
			  success: function (msg) {
				  $(".messi-content #pemail").val(msg);
			  }
		  });
        var text = "<table class=\"myTable\">";
        text += "<tr><th><?php echo lang('EMAIL');?>:</th>";
        text += "<td><input name=\"receiverEmail\" id=\"pemail\" type=\"text\" class=\"inputbox\" value=\"\" size=\"35\" /></td></tr>";
        text += "<tr><th><?php echo lang('TRANS_PAYAMOUNT');?>:</th>";
        text += "<td><input name=\"amount\" id=\"pamount\" type=\"text\" value=\"\" size=\"15\" /></td></tr>";
        text += "<tr><th><?php echo lang('STAFF_PAYCURRENCY');?>:</th>";
        text += "<td><input name=\"currency\" id=\"pcurrency\" type=\"text\" value=\"<?php echo $core->currency;?>\" size=\"15\" /></td></tr>";
        text += "<tr><th><?php echo lang('NOTES');?>:</th>";
        text += "<td><textarea name=\"note\" id=\"pnote\" cols=\"35\" rows=\"4\"></textarea></td></tr>";
        text += "<input name=\"uid\" id=\"uid\" type=\"hidden\" value=\"" + uid + "\" /></table>";
		
        new Messi(text, {
            title: "<?php echo lang('STAFF_PAYSTAFF');?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo lang('STAFF_ADDPAY');?>",
                val: 'Y'
            }]
        });
    });
	
	$('body').on('click', '.messi a.mod-button', function () {
		var temail = $('#pemail').val();
		var tval = $('#pamount').val();
		var tnote = $('#pnote').val();
		var tcur = $('#pcurrency').val();
		var uid = $('#uid').val();
		$.ajax({
			type: 'post',
			url: "controller.php",
			dataType: 'json',
			data: {
				'MassPay': 1,
				'id': uid,
				'email': temail,
				'amount': tval,
				'cur': tcur,
				'note': tnote
			},
			beforeSend: function () {
				showLoader()
			},
			success: function (json) {
				hideLoader();
				if (json.type == "success") {
					$("#msgholder").html(json.info);
				} else {
					$("#msgholder").html(json.message);
				}
			}
		});
	});
});
// ]]>
</script>
<?php endif;?>
<?php break;?>
<?php endswitch;?>