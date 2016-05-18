<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch(Filter::$action): case "edit": ?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php $row = $content->getProjectInvoiceById();?>
<?php $invdata = $content->getProjectInvoiceData();?>
<?php $paydata = $content->getProjectInvoicePayments();?>
<p class="greentip"><i class="icon-lightbulb icon-3x pull-left"></i> <?php echo lang('INVC_INFO');?><br>
  <?php echo lang('REQFIELD1');?> <i class="icon-append icon-asterisk"></i> <?php echo lang('REQFIELD2');?></p>
<?php if(!$row):?>
<?php echo Filter::msgError( lang('INVC_ERR'), false);?>
<?php else:?>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('INVC_SUB4');?><span><?php echo lang('INVC_SUB') . $row->ptitle;?></span></header>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" value="<?php echo $row->title;?>" placeholder="<?php echo lang('INVC_NAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('INVC_NAME');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input type="text" name="name" value="<?php echo $row->name;?>" readonly="readonly" disabled="disabled" placeholder="<?php echo lang('INVC_CNAME');?>">
      </label>
      <div class="note"><?php echo lang('INVC_CNAME');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input type="text" name="email" value="<?php echo $row->email;?>" readonly="readonly" disabled="disabled" placeholder="<?php echo lang('INVC_CEMAIL');?>">
      </label>
      <div class="note"><?php echo lang('INVC_CEMAIL');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <label class="input"><i class="icon-append icon-dollar tooltip"></i>
        <input type="text" name="amount_total" value="<?php echo $row->amount_total;?>" readonly="readonly" disabled="disabled" placeholder="<?php echo lang('INVC_TOTAL');?>">
      </label>
      <div class="note note-error"><?php echo lang('INVC_TOTAL');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input type="text" name="amount_paid" value="<?php echo $row->amount_paid;?>" readonly="readonly" disabled="disabled" placeholder="<?php echo lang('INVC_PAID');?>">
      </label>
      <div class="note"><?php echo lang('INVC_PAID');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input type="text" name="amount_due" value="<?php echo number_format($row->amount_total - $row->amount_paid,2);?>" readonly="readonly" disabled="disabled" placeholder="<?php echo lang('FBILL_PENDING');?>">
      </label>
      <div class="note"><?php echo lang('FBILL_PENDING');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="input">
        <input type="text" name="duedate" value="<?php echo $row->duedate;?>" id="date" placeholder="<?php echo lang('INVC_DUEDATE');?>">
      </label>
      <div class="note"><?php echo lang('INVC_DUEDATE');?></div>
    </section>
    <section class="col col-6">
      <label class="input">
        <input type="text" name="tax" value="<?php echo $row->tax;?>" readonly="readonly" disabled="disabled" placeholder="<?php echo $core->tax_name;?>">
      </label>
      <div class="note"><?php echo $core->tax_name;?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <select name="method">
        <option value="Offline"<?php if($row->method == 'Offline') echo ' selected="selected"';?>><?php echo lang('OFFLINE');?></option>
        <?php foreach ($content->getGateways() as $grow):?>
        <option value="<?php echo $grow->displayname;?>"<?php if($row->method == $grow->displayname) echo ' selected="selected"';?>><?php echo $grow->displayname;?></option>
        <?php endforeach;?>
        <?php unset($grow);?>
      </select>
      <div class="note"><?php echo lang('PAYMETHOD');?></div>
    </section>
    <section class="col col-6">
      <select name="status">
        <?php echo $content->invoiceStatusList($row->status);?>
      </select>
      <div class="note"><?php echo lang('STATUS');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <?php if($row->status == "Unpaid"):?>
      <div class="inline-group">
        <label class="radio">
          <input type="radio" value="1" name="onhold" <?php getChecked($row->onhold, 1); ?>>
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" value="0" name="onhold" <?php getChecked($row->onhold, 0); ?>>
          <i></i><?php echo lang('NO');?></label>
      </div>
      <div class="note"><?php echo lang('INVC_ONHOLD');?> <i class="icon-exclamation-sign tooltip" data-title="<?php echo lang('INVC_ONHOLD_T');?>"></i></div>
      <?php endif;?>
    </section>
    <section class="col col-6">
      <label class="input">
        <input type="text" name="invoice_number" value="<?php echo $core->invoice_number . $row->id;?>" readonly="readonly" disabled="disabled" placeholder="<?php echo lang('INVC_INVNUMBER');?>">
      </label>
      <div class="note"><?php echo lang('INVC_INVNUMBER');?></div>
    </section>
  </div>
  <hr />
  <div class="row">
  <section class="col col-12"> <span class="tbicon large"> <a id="list_<?php echo $row->id;?>" class="sendinvoice tooltip" data-title="<?php echo lang('INVC_EMAIL_T');?>"><i class="icon-envelope-alt icon-2x"></i></a> </span> <span class="tbicon large"> <a href="print_invoice.php?id=<?php echo Filter::$id;?>" target="_blank" class="tooltip" data-title="<?php echo lang('INVC_PRINT_T');?>"><i class="icon-print icon-2x"></i></a> </span> <span class="tbicon large"> <a href="controller.php?dopdf=<?php echo $row->id;?>&amp;title=<?php echo urlencode($row->title);?>" class="tooltip" data-title="<?php echo lang('INVC_PDF_T');?>"><i class="icon-file-alt icon-2x"></i></a> </span>
    <div class="note"><?php echo lang('ACTIONS');?></div>
  </section>
  </div>
  <header><?php echo lang('INVC_NOTES');?></header>
  <div class="row">
    <section>
      <label class="label"><?php echo lang('INVC_NOTE');?></label>
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="notes" rows="5"><?php echo ($row->notes) ? $row->notes : $core->invoice_note;?></textarea>
      </div>
      <div class="note"><?php echo lang('INVC_NOTE_T');?></div>
    </section>
    <section>
      <label class="label"><?php echo lang('INVC_COMMENT');?></label>
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="comment" rows="5"><?php echo $row->comment;?></textarea>
      </div>
      <div class="note"><?php echo lang('INVC_COMMENT_T');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('INVC_UPDATE');?></button>
    <a href="index.php?do=invoices&amp;id=<?php echo $row->project_id;?>" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
  <input name="amount_total" type="hidden" value="<?php echo $row->amount_total;?>" />
</form>
<?php echo Core::doForm("updateInvoice");?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('INVC_SUBENTRY');?></h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('INVC_ADDENTRY');?>" href="javascript:void(0);" onclick="$('#newentry').slideToggle();"><span class="icon-plus"></span></a> </aside>
  </header>
  <div class="content2">
    <div id="invoice-entries">
      <?php if(!$invdata):?>
      <div class="norecord"><?php echo Filter::msgInfo(lang('INVC_NOENTRY'),false);?></div>
      <?php endif;?>
      <table class="myTable">
        <thead>
          <tr>
            <th class="header"><?php echo lang('INVC_ENTRYTITLE');?></th>
            <th class="header"><?php echo lang('DESC');?></th>
            <th class="header"><?php echo lang('AMOUNT');?></th>
            <th class="header"><?php echo lang('ACTIONS');?></th>
          </tr>
        </thead>
        <tbody>
          <?php if($invdata):?>
          <?php foreach ($invdata as $irow):?>
          <tr>
            <td><?php echo $irow->title;?></td>
            <td><?php echo $irow->description;?></td>
            <td><?php echo $irow->amount;?></td>
            <td><span class="tbicon"> <a href="index.php?do=invoices&amp;action=editentry&amp;id=<?php echo $irow->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$irow->title;?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a id="item_<?php echo $irow->id.':'.$irow->project_id.':'.$irow->invoice_id;?>" class="tooltip delete" data-rel="<?php echo $irow->title;?>" data-title="<?php echo lang('DELETE').': '.$irow->title;?>"><i class="icon-trash"></i></a> </span></td>
          </tr>
          <?php endforeach;?>
          <?php unset($irow);?>
          <?php endif;?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<div id="newentry" style="display:none">
  <form class="xform" id="entry_form" method="post">
    <header><?php echo lang('INVC_SUBENTRY1');?></header>
    <div class="row">
      <section class="col col-4">
        <label class="input"> <i class="icon-append icon-asterisk"></i>
          <input type="text" name="etitle" placeholder="<?php echo lang('INVC_ENTRYTITLE');?>">
        </label>
        <div class="note note-error"><?php echo lang('INVC_ENTRYTITLE');?></div>
      </section>
      <section class="col col-4">
        <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-dollar"></i>
          <input type="text" name="eamount" placeholder="<?php echo lang('AMOUNT');?>">
        </label>
        <div class="note note-error"><?php echo lang('AMOUNT');?></div>
      </section>
      <section class="col col-4">
        <label class="input">
          <input type="text" name="edesc" placeholder="<?php echo lang('DESC');?>">
        </label>
        <div class="note"><?php echo lang('DESC');?></div>
      </section>
    </div>
    <div class="row">
      <section class="col col-4">
        <div class="inline-group">
          <label class="radio">
            <input type="radio" name="etax" value="1" >
            <i></i><?php echo lang('YES');?></label>
          <label class="radio">
            <input type="radio" name="etax" value="0" checked="checked">
            <i></i><?php echo lang('NO');?></label>
        </div>
        <div class="note"><?php echo lang('TAXABLE');?></div>
      </section>
      <section class="col col-8">
        <button class="butsmall pull-left" id="doentry" type="button"><?php echo lang('INVC_ADDENTRY');?></button>
        <span class="loading"></span> </section>
    </div>
    <div class="emsg"></div>
  </form>
  <hr />
</div>
<?php echo Core::doDelete(lang('INVC_DELENTRY'),"deleteInvoiceEntry");?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('INVC_SUBRECORD');?></h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" id="add-record" data-hint="<?php echo lang('INVC_ADDRECORD');?>" href="javascript:void(0);" onclick="$('#newrecord').slideToggle();"><span class="icon-plus"></span></a> </aside>
  </header>
  <div class="content2">
    <div id="invoice-records">
      <?php if(!$paydata):?>
      <div class="norecord"><?php echo Filter::msgInfo(lang('INVC_NORECORD'),false);?></div>
      <?php endif;?>
      <table class="myTable">
        <thead>
          <tr>
            <th class="header"><?php echo lang('INVC_RECPAID');?></th>
            <th class="header"><?php echo lang('DESC');?></th>
            <th class="header"><?php echo lang('AMOUNT');?></th>
            <th class="header"><?php echo lang('ACTIONS');?></th>
          </tr>
        </thead>
        <tbody>
          <?php if($paydata):?>
          <?php foreach ($paydata as $prow):?>
          <tr>
            <td><?php echo Filter::dodate($core->short_date, $prow->created);?></td>
            <td><?php echo $prow->description;?></td>
            <td><?php echo $prow->amount;?></td>
            <td><span class="tbicon"> <a href="index.php?do=invoices&amp;action=editrecord&amp;id=<?php echo $prow->id;?>" class="tooltip" data-title="<?php echo lang('EDIT');?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a id="pitem_<?php echo $prow->id.':'.$prow->project_id.':'.$prow->invoice_id;?>" class="tooltip rdelete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE');?>"><i class="icon-trash"></i></a> </span></td>
          </tr>
          <?php endforeach;?>
          <?php unset($prow);?>
          <?php endif;?>
        </tbody>
      </table>
    </div>
  </div>
</section>
<div id="newrecord" style="display:none">
  <form class="xform" id="record_form" method="post">
    <header><?php echo lang('INVC_SUBRECORD1');?></header>
    <div class="row">
      <section class="col col-4">
        <label class="input"> <i class="icon-append icon-calendar"></i>
          <input type="text" name="rcreated" value="<?php echo date('Y-m-d');?>" id="rdate" placeholder="<?php echo lang('INVC_DUEDATE');?>">
        </label>
        <div class="note note-error"><?php echo lang('INVC_DUEDATE');?></div>
      </section>
      <section class="col col-4">
        <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('INVC_RECAMOUNT_T');?>"></i>
          <input type="text" name="ramount" placeholder="<?php echo lang('AMOUNT');?>">
        </label>
        <div class="note note-error"><?php echo lang('AMOUNT');?></div>
      </section>
      <section class="col col-4">
        <label class="input">
          <input type="text" name="rdesc" placeholder="<?php echo lang('DESC');?>">
        </label>
        <div class="note"><?php echo lang('DESC');?></div>
      </section>
    </div>
    <div class="row">
      <section class="col col-4">
        <select name="method">
          <option value="Offline"><?php echo lang('OFFLINE');?></option>
          <?php foreach ($content->getGateways() as $grow):?>
          <option value="<?php echo $grow->displayname;?>"><?php echo $grow->displayname;?></option>
          <?php endforeach;?>
          <?php unset($grow);?>
        </select>
        <div class="note"><?php echo lang('PAYMETHOD');?></div>
      </section>
      <section class="col col-4">
        <button class="butsmall pull-left" id="dorecord" type="button"><?php echo lang('INVC_ADDRECORD');?></button>
        <span class="loading"></span> </section>
    </div>
    <div class="rmsg"></div>
  </form>
  <hr />
</div>
<?php echo Core::doDelete(lang('INVC_DELRECORD'), "deleteInvoiceRecord", "controller.php", "pitem_", "a.rdelete");?> 
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    // Add Entry
	$('#doentry').on('click', function () {
        var str = $("#entry_form").serialize();
        str += '&processInvoiceEntry=1';
        str += '&invoice_id=<?php echo Filter::$id;?>';
		str += '&add_entry=1';
		str += '&project_id=<?php echo $row->project_id;?>';
        $.ajax({
            type: "post",
            dataType: 'json',
            url: "controller.php",
            data: str,
            beforeSend: showsLoader('#newentry'),
            success: function (json) {
                hidesLoader('#newentry');
                if (json.type == "success") {
					var rowCount = $('#invoice-entries > tbody > tr').length;
					if(rowCount == 0) {
						$(json.message).appendTo('#invoice-entries tbody').effect("highlight", {}, 3000);
					} else {
						$(json.message).insertAfter('#invoice-entries tbody tr:last').effect("highlight", {}, 3000);
					}
					$("#newentry .norecord").remove();
                    $("#newentry .emsg").html(json.info);
                } else {
                    $("#newentry .emsg").html(json.message);
                }
            }
        });
        return false;
    });
    // Add Record
	$('#dorecord').on('click', function () {
        var str = $("#record_form").serialize();
        str += '&processInvoiceRecord=1';
        str += '&invoice_id=<?php echo Filter::$id;?>';
		str += '&ptitle=<?php echo urlencode($row->title);?>';
		str += '&add_record=1';
		str += '&project_id=<?php echo $row->project_id;?>';
        $.ajax({
            type: "post",
            dataType: 'json',
            url: "controller.php",
            data: str,
            beforeSend: showsLoader('#newrecord'),
            success: function (json) {
                hidesLoader('#newrecord');
                if (json.type == "success") {
					var rowCount = $('#invoice-records > tbody > tr').length;
					if(rowCount == 0) {
						$(json.message).appendTo('#invoice-records tbody').effect("highlight", {}, 3000);
					} else {
						$(json.message).insertAfter('#invoice-records tbody tr:last').effect("highlight", {}, 3000);
					}
					$("#newrecord .norecord").remove();
                    $("#newrecord .rmsg").html(json.info);
                } else {
                    $("#newrecord .rmsg").html(json.message);
                }
            }
        });
        return false;
    });
    // Send Invoice
    $('a.sendinvoice').click(function () {
        var id = $(this).attr('id').replace('list_', '')
        var text = "<p><i class=\"icon-warning-sign\"></i> <?php echo lang('INVC_SEND_T');?></p>";
        new Messi(text, {
            title: "<?php echo lang('INVC_EMAIL_T2');?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo lang('SEND');?>",
                val: 'Y'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						url: "controller.php",
						data: 'sendInvoice=' + id,
						beforeSend: function () {
							$("#loader").fadeIn(200);
						},
						success: function (msg) {
							$("#loader").fadeOut(200);
							$("#msgholder").html(msg);
						}
					});
                }
            }
        })
    });
    $("#date, #rdate").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
// ]]>
</script>
<?php endif;?>
<?php break;?>
<?php case"editentry": ?>
<?php $row = Core::getRowById("invoice_data", Filter::$id);?>
<p class="greentip"><i class="icon-lightbulb icon-3x pull-left"></i> <?php echo lang('INVC_ENTRYINFO2');?><br>
<?php echo lang('REQFIELD1');?> <i class="icon-append icon-asterisk"></i> <?php echo lang('REQFIELD2');?></p>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('INVC_TITLE3');?><span><?php echo lang('INVC_ENTRYSUB2') . $row->title;?></span></header>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="etitle" value="<?php echo $row->title;?>" placeholder="<?php echo lang('INVC_ENTRYTITLE');?>">
      </label>
      <div class="note note-error"><?php echo lang('INVC_ENTRYTITLE');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-dollar"></i>
        <input type="text" name="eamount" value="<?php echo $row->amount;?>" placeholder="<?php echo lang('AMOUNT');?>">
      </label>
      <div class="note note-error"><?php echo lang('AMOUNT');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input type="text" name="edesc" value="<?php echo $row->description;?>" placeholder="<?php echo lang('DESC');?>">
      </label>
      <div class="note"><?php echo lang('DESC');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <div class="inline-group">
        <label class="radio">
          <input type="radio" name="etax" value="1" <?php if($row->tax <> 0) echo 'checked="checked"'; ?>>
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" name="etax" value="0" <?php if($row->tax == 0) echo 'checked="checked"'; ?>>
          <i></i><?php echo lang('NO');?></label>
      </div>
      <div class="note"><?php echo lang('TAXABLE');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('INVC_ENTRYUPDATE');?></button>
    <a href="index.php?do=invoices&amp;action=edit&amp;pid=<?php echo $row->project_id;?>&amp;id=<?php echo $row->invoice_id;?>" class="button button-secondary"><?php echo lang('CANCEL');?></a></footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
  <input name="invoice_id" type="hidden" value="<?php echo $row->invoice_id;?>" />
  <input name="project_id" type="hidden" value="<?php echo $row->project_id;?>" />
</form>
<?php echo Core::doForm("processInvoiceEntry");?>
<?php break;?>
<?php case"editrecord": ?>
<?php $row = Core::getRowById("invoice_payments", Filter::$id);?>
<p class="greentip"><i class="icon-lightbulb icon-3x pull-left"></i> <?php echo lang('INVC_RECINFO2');?><br>
  <?php echo lang('REQFIELD1');?> <i class="icon-append icon-asterisk"></i> <?php echo lang('REQFIELD2');?></p>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('INVC_TITLE3');?><span><?php echo lang('INVC_RECSUB2') . getValue("title","invoices","id = '".$row->invoice_id."'");?></span></header>
  <div class="row">
    <section class="col col-4">
      <label class="input"> <i class="icon-append icon-calendar"></i>
        <input type="text" name="rcreated" size="25" value="<?php echo $row->created;?>" id="rdate" placeholder="<?php echo lang('INVC_DUEDATE');?>">
      </label>
      <div class="note note-error"><?php echo lang('INVC_DUEDATE');?></div>
    </section>
    <section class="col col-4">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('INVC_RECAMOUNT_T');?>"></i>
        <input type="text" name="ramount" value="<?php echo $row->amount;?>" placeholder="<?php echo lang('AMOUNT');?>">
      </label>
      <div class="note note-error"><?php echo lang('AMOUNT');?></div>
    </section>
    <section class="col col-4">
      <label class="input">
        <input type="text" name="rdesc" value="<?php echo $row->description;?>" placeholder="<?php echo lang('DESC');?>">
      </label>
      <div class="note"><?php echo lang('DESC');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <select name="method">
        <option value="Offline"<?php if($row->method == 'Offline') echo ' selected="selected"';?>><?php echo lang('OFFLINE');?></option>
        <?php foreach ($content->getGateways() as $grow):?>
        <option value="<?php echo $grow->displayname;?>"><?php echo $grow->displayname;?></option>
        <?php endforeach;?>
        <?php unset($grow);?>
      </select>
      <div class="note"><?php echo lang('PAYMETHOD');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('INVC_RECUPDATE');?></button>
    <a href="index.php?do=invoices&amp;action=edit&amp;pid=<?php echo $row->project_id;?>&amp;id=<?php echo $row->invoice_id;?>" class="button button-secondary"><?php echo lang('CANCEL');?></a> </footer>
  <input name="id" type="hidden" value="<?php echo Filter::$id;?>" />
  <input name="invoice_id" type="hidden" value="<?php echo $row->invoice_id;?>" />
  <input name="project_id" type="hidden" value="<?php echo $row->project_id;?>" />
</form>
<?php echo $core->doForm("processInvoiceRecord");?> 
<script type="text/javascript">
$(document).ready(function () {
    $("#rdate").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<?php break;?>











<?php case"add": ?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php $prodrow = $content->getProjectList();?>
<?php $userlist = $user->getUserList(1);?>
<p class="greentip"><i class="icon-lightbulb icon-3x pull-left"></i> <?php echo lang('INVC_INFO2');?><br>
  <?php echo lang('REQFIELD1');?> <i class="icon-append icon-asterisk"></i> <?php echo lang('REQFIELD2');?></p>
<form class="xform" id="admin_form" method="post">
  <header><?php echo lang('INVC_SUB4');?><span><?php echo lang('INVC_SUB2');?><?php echo (Filter::$id) ? lang('INVC_SUB2_1') . getValue("title","projects","id = '".Filter::$id."'") : '';?></span></header>
  <div class="row">
    <section class="col col-6">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="title" placeholder="<?php echo lang('INVC_NAME');?>">
      </label>
      <div class="note note-error"><?php echo lang('INVC_NAME');?></div>
    </section>
    <section class="col col-6">
      <select name="project_id">
        <option value="">--- <?php echo lang('INVC_PROJCSELETC');?> ---</option>
        <?php if($prodrow):?>
        <?php foreach ($prodrow as $prow):?>
        <option value="<?php echo $prow->id;?>"<?php if($prow->id == Filter::$id) echo ' selected="selected"';?>><?php echo $prow->title;?></option>
        <?php endforeach;?>
        <?php unset($srow);?>
        <?php endif;?>
      </select>
      <div class="note"><?php echo lang('PROJ_NAME');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <select name="client_id">
        <option value="">--- <?php echo lang('INVC_CLIENTSELECT');?> ---</option>
        <?php if($userlist):?>
        <?php foreach ($userlist as $srow):?>
        <option value="<?php echo $srow->id;?>"<?php if($srow->id == getValue("client_id","projects","id = '".Filter::$id."'")) echo ' selected="selected"';?>><?php echo $srow->name;?></option>
        <?php endforeach;?>
        <?php unset($srow);?>
        <?php endif;?>
      </select>
      <div class="note note-error"><?php echo lang('INVC_CLIENTSELECT');?></div>
    </section>
    <section class="col col-6">
      <select name="method">
        <option value="Offline"><?php echo lang('OFFLINE');?></option>
        <?php foreach ($content->getGateways() as $grow):?>
        <option value="<?php echo $grow->displayname;?>"><?php echo $grow->displayname;?></option>
        <?php endforeach;?>
        <?php unset($grow);?>
      </select>
      <div class="note"><?php echo lang('PAYMETHOD');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-6">
      <label class="label"><?php echo lang('INVC_RECURRING_PAY');?></label>
      <label class="radio">
        <input type="radio" name="recurring" value="1">
        <i></i><?php echo lang('YES');?></label>
      <label class="radio">
        <input type="radio" name="recurring" value="0" checked="checked">
        <i></i><?php echo lang('NO');?></label>
    </section>
    <section class="col col-6">
      <select name="period">
        <option value="D"><?php echo lang('INVC_REC_DAYS');?></option>
        <option value="W"><?php echo lang('INVC_REC_WEEKS');?></option>
        <option value="M"><?php echo lang('INVC_REC_MONTHS');?></option>
        <option value="Y"><?php echo lang('INVC_REC_YEARS');?></option>
      </select>
      <div class="note"><i class="icon-caret-down"></i></div>
      <label class="input"> <i class="icon-append icon-exclamation-sign  tooltip" data-title="<?php echo lang('INVC_RECURRING_PER_T');?>"></i>
        <input type="text" name="days" placeholder="<?php echo lang('INVC_RECURRING_PER');?>">
      </label>
      <div class="note note"><?php echo lang('INVC_RECURRING_PER');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-3">
      <div class="inline-group">
        <label class="radio">
          <input type="radio" name="tax" value="1">
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" name="tax" value="0" checked="checked">
          <i></i><?php echo lang('NO');?></label>
      </div>
      <div class="note"><?php echo lang('TAXABLE');?></div>
    </section>
    <section class="col col-3">
      <div class="inline-group">
        <label class="radio">
          <input type="radio" name="onhold" value="1">
          <i></i><?php echo lang('YES');?></label>
        <label class="radio">
          <input type="radio" name="onhold" value="0" checked="checked">
          <i></i><?php echo lang('NO');?></label>
        <?php echo tooltip(lang('INVC_ONHOLD_T'));?></div>
      <div class="note"><?php echo lang('INVC_ONHOLD');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="created" value="<?php echo date('Y-m-d');?>" id="datec" placeholder="<?php echo lang('CREATED');?>">
      </label>
      <div class="note"><?php echo lang('CREATED');?></div>
    </section>
    <section class="col col-3">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i>
        <input type="text" name="duedate" value="<?php echo date('Y-m-d', strtotime("+30 days"));?>" id="dated" placeholder="<?php echo lang('INVC_DUEDATE');?>">
      </label>
      <div class="note"><?php echo lang('INVC_DUEDATE');?></div>
    </section>
  </div>
  <header><?php echo lang('INVC_SUBENTRY');?></header>
  <div class="row clonedInput" id="container1">
    <section class="col col-4">
      <label class="input"> <i class="icon-append icon-asterisk"></i>
        <input type="text" name="dtitle[]" placeholder="<?php echo lang('INVC_ENTRYTITLE');?>">
      </label>
      <div class="note note-error"><?php echo lang('INVC_NAME');?></div>
    </section>
    <section class="col col-2">
      <label class="input"> <i class="icon-prepend icon-asterisk"></i> <i class="icon-append icon-exclamation-sign tooltip" data-title="<?php echo lang('INVC_AMOUNT_T');?>"></i>
        <input type="text" name="amount[]" placeholder="<?php echo lang('AMOUNT');?>">
      </label>
      <div class="note note-error"><?php echo lang('AMOUNT');?></div>
    </section>
    <section class="col col-6">
      <label class="input">
        <input type="text" name="description[]" placeholder="<?php echo lang('DESC');?>">
      </label>
      <div class="note"><?php echo lang('DESC');?></div>
    </section>
  </div>
  <div class="row">
    <section class="col col-4">
      <button class="butsmall" id="btnAdd" type="button"><?php echo lang('INVC_ADD_ITEM');?></button>
      <button class="butsmall red" id="btnDel" type="button"><?php echo lang('DELETE');?></button>
    </section>
  </div>
  <header><?php echo lang('INVC_NOTES');?></header>
  <div class="row">
    <section>
      <label class="label"><?php echo lang('INVC_NOTE');?></label>
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="notes" rows="5"><?php echo $core->invoice_note;?></textarea>
      </div>
      <div class="note"><?php echo lang('INVC_NOTE_T');?></div>
    </section>
    <section>
      <label class="label"><?php echo lang('INVC_COMMENT');?></label>
      <div class="field-wrap wysiwyg-wrap">
        <textarea class="post" name="comment" rows="5"></textarea>
      </div>
      <div class="note"><?php echo lang('INVC_COMMENT_T');?></div>
    </section>
  </div>
  <footer>
    <button class="button" name="dosubmit" type="submit"><?php echo lang('INVC_ADD');?></button>
    <?php echo (Filter::$id) ? '<a href="index.php?do=invoices&amp;id='.Filter::$id.'" class="button button-secondary">' .lang('CANCEL') . '</a>' : '';?> </footer>
</form>
<?php echo Core::doForm("addInvoice");?> 
<script type="text/javascript">
$(document).ready(function () {
    $('#btnAdd').click(function () {
        var num = $('.clonedInput').length;
        var newNum = new Number(num + 1);
        var newElem = $('#container' + num).clone().attr('id', 'container' + newNum);
        $('#container' + num).after(newElem);
        $('#btnDel').attr('disabled', false);
        if (newNum == 15) $('#btnAdd').attr('disabled', 'disabled');
    });
    $('#btnDel').click(function () {
        var num = $('.clonedInput').length;
        $('#container' + num).remove();
        $('#btnAdd').attr('disabled', false);
        if (num - 1 == 1) $('#btnDel').attr('disabled', 'disabled');
    });
    $('#btnDel').attr('disabled', 'disabled');
    $("#datec, #dated").datepicker({
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<?php break;?>

















<?php default:?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php $invrow = $content->getProjectInvoices();?>
<p class="pagetip"><i class="icon-lightbulb icon-2x pull-left"></i><?php echo lang('INVC_INFO3');?></p>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('INVC_SUB3') . getValue("title","projects","id = '".Filter::$id."'");?></h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('INVC_ADD');?>" href="index.php?do=invoices&amp;action=add&amp;id=<?php echo Filter::$id;?>"><span class="icon-plus"></span></a> </aside>
  </header>
  <div class="content2">
    <?php if(!$invrow):?>
    <?php echo Filter::msgInfo(lang('INVC_NOINVOICE'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th>#</th>
          <th class="header"><?php echo lang('INVC_NAME');?></th>
          <th class="header"><?php echo lang('INVC_CNAME');?></th>
          <th class="header"><?php echo lang('CREATED');?> / <?php echo lang('INVC_DUEDATE');?></th>
          <th class="header"><?php echo lang('TOTAL');?> / <?php echo lang('PAID');?></th>
          <th class="header"><?php echo lang('STATUS');?></th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php foreach ($invrow as $row):?>
      <tr>
        <td><?php echo ($core->invoice_number . $row->id);?></td>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->name;?></td>
        <td><?php echo Filter::dodate($core->short_date, $row->created);?> / <?php echo Filter::dodate($core->short_date, $row->duedate);?></td>
        <td><?php echo $row->amount_total;?> / <?php echo $row->amount_paid;?></td>
        <td><?php echo $row->status;?></td>
        <td><span class="tbicon"> <a href="index.php?do=invoices&amp;action=edit&amp;pid=<?php echo $row->project_id;?>&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a id="item_<?php echo $row->id.':'.$row->project_id;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
    </table>
    <?php endif;?>
  </div>
</section>
<?php echo Core::doDelete(lang('INVC_DELETEINV'),"deleteInvoice");?>
<?php break;?>
<?php endswitch;?>