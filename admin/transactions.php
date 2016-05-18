<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>

<?php $transrow = $content->getPaymentTransactions();?>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('TRANS_SUB');?></h1>
		<aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="Export Transactions" href="controller.php?action=createTransReport"><span class="icon-reorder"></span></a> </aside>
  </header>
  <div class="content2">
    <?php if(!$transrow):?>
    <?php echo Filter::msgInfo(lang('TRANS_NOTRANS'),false);?>
    <?php else:?>
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
            <select name="select" id="paymentfilter">
              <option value="NA"><?php echo lang('TRANS_RESET');?></option>
              <?php echo $content->getPaymentFilter();?>
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
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('PROJ_NAME');?></th>
          <th class="header">#<?php echo lang('TRANS_INVOICE');?></th>
          <th class="header"><?php echo lang('TRANS_PAYDATE');?></th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
          <th class="header"><?php echo lang('PAYMETHOD');?></th>
          <th class="header"><?php echo lang('AMOUNT');?></th>
        </tr>
      </thead>
      <?php foreach ($transrow as $row):?>
      <tr>
        <td><a href="index.php?do=projects&amp;action=edit&amp;id=<?php echo $row->project_id;?>"><?php echo $row->ptitle;?></a></td>
        <td><a href="index.php?do=invoices&amp;action=edit&amp;pid=<?php echo $row->project_id;?>&amp;id=<?php echo $row->invoice_id;?>"><?php echo ($core->invoice_number . $row->invoice_id);?></a></td>
        <td><?php echo Filter::dodate($core->short_date, $row->created);?></td>
        <td><span class="tbicon"> <a href="javascript:void(0);" class="tooltip" data-title="<?php echo wordwrap($row->description, 20, "<br />\n");?>"><i class="icon-info"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id;?>" class="tooltip delete" data-rel="<?php echo $row->ptitle;?>" data-title="<?php echo lang('DELETE').': '.$row->ptitle;?>"><i class="icon-trash"></i></a> </span></td>
        <td><?php echo $row->method;?></td>
        <td><?php echo $row->amount;?></td>
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
<?php echo Core::doDelete(lang('TRANS_DELETE'),"deleteInvoiceRecord");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#paymentfilter').change(function () {
		var res = $("#paymentfilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=transactions' : window.location.href = 'index.php?do=transactions&sort=' + res;
    })
});
// ]]>
</script>