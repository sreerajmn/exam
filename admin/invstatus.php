<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php if($user->userlevel == 5): print Filter::msgInfo(lang('ADMINONLY'), false); return; endif;?>
<?php $invrow = $content->getInvoicesByStatus();?>
<p class="pagetip"><i class="icon-lightbulb icon-2x pull-left"></i><?php echo lang('INVC_INFO4');?></p>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('INVC_SUB4');?></h1>
  </header>
  <div class="content2">
    <div class="row">
      <div class="ptop10">
        <form class="xform" id="dForm" method="post" style="padding:0;padding-top:15px">
          <section class="col col-6">
            <select name="sort" id="invfilter">
              <option value="NA"><?php echo lang('INVC_RESET');?></option>
              <?php echo $content->invoiceStatusList(get('sort'));?>
            </select>
          </section>
          <section class="col col-3"> <?php echo $pager->items_per_page();?> </section>
          <section class="col col-3"> <?php echo $pager->jump_menu();?> </section>
          <div class="hr2"></div>
          <section class="col col-5">
            <label class="input"> <i class="icon-prepend icon-calendar"></i>
              <input type="text" name="fromdate"  id="fromdate" placeholder="<?php echo lang('INVC_DUEFROM');?>">
            </label>
          </section>
          <section class="col col-5">
            <label class="input"> <i class="icon-prepend icon-calendar"></i>
              <input type="text" name="enddate"  id="enddate" placeholder="<?php echo lang('INVC_DUETO');?>">
            </label>
          </section>
          <section class="col col-2">
            <button class="button inline" name="find" type="submit"><?php echo lang('FIND');?></button>
          </section>
        </form>
      </div>
    </div>
   <?php if(!$invrow):?>
    <?php echo Filter::msgInfo(lang('INVC_NOINVOICE2'),false);?>
    <?php else:?>
    <table class="myTable">
      <thead>
        <tr>
          <th>#</th>
          <th class="header"><?php echo lang('INVC_NAME');?></th>
          <th class="header"><?php echo lang('INVC_CNAME');?></th>
          <th class="header"><?php echo lang('CREATED');?> / <?php echo lang('INVC_DUEDATE');?></th>
          <th class="header"><?php echo lang('TOTAL');?> / <?php echo lang('PENDING');?></th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($invrow as $row):?>
        <tr>
          <td><?php echo $core->invoice_number . $row->id;?></td>
          <td><?php echo $row->title;?></td>
          <td><?php echo $row->name;?></td>
          <td><?php echo Filter::dodate($core->short_date, $row->created);?> / <?php echo Filter::dodate($core->short_date, $row->duedate);?></td>
          <td><?php echo number_format($row->amount_total,2);?> / <?php echo number_format($row->amount_total - $row->amount_paid,2);?></td>
          <td><span class="tbicon"> <a href="#" class="tooltip" data-title="<?php echo lang('STATUS') . ' ' . $row->status;?>"><i class="icon-<?php echo ($row->status == "Paid") ? "ok" : "time" ;?>"></i></a></span> <span class="tbicon"> <a href="index.php?do=invoices&amp;action=edit&amp;pid=<?php echo $row->project_id;?>&amp;id=<?php echo $row->id;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->id.':'.$row->project_id;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span></td>
        </tr>
        <?php endforeach;?>
        <?php unset($row);?>
      </tbody>
    </table>
    <?php if($pager->display_pages()):?>
    <?php echo $pager->display_pages();?>
    <?php endif;?>
    <?php endif;?>
  </div>
</section>
<?php echo Core::doDelete(lang('INVC_DELETEINV'),"deleteInvoice");?> 
<script type="text/javascript"> 
// <![CDATA[  
$(document).ready(function () {
    $('#invfilter').change(function () {
		var res = $("#invfilter option:selected").val();
		(res == "NA" ) ? window.location.href = 'index.php?do=invstatus' : window.location.href = 'index.php?do=invstatus&sort=' + res;
    })
});
// ]]>
</script>