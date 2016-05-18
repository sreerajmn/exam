<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $urow = Core::getRowById("users", Filter::$id);?>
<?php $projectrow = $content->getProjectsForClient($urow->id);?>
<?php $invoicerow = $content->getInvoiceForClient($urow->id);?>
<p class="pagetip"><i class="icon-lightbulb icon-2x pull-left"></i><?php echo lang('OVER_INFO');?></p>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('OVER_SUB') . $urow->fname.' '.$urow->lname;?></h1>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('PROJ_BACK');?>" href="index.php?do=projects"><span class="icon-hand-left"></span></a> </aside>
  </header>
  <div class="content2">
    <table class="myTable dataview">
      <tr>
        <td><?php echo lang('INVC_CNAME');?>:</td>
        <td><a href="index.php?do=clients&amp;action=edit&amp;id=<?php echo $urow->id;?>"><?php echo $urow->fname.' '.$urow->lname;?></a></td>
      </tr>
      <tr>
        <td><?php echo lang('INVC_CEMAIL');?>:</td>
        <td><a href="index.php?do=email&amp;emailid=<?php echo urlencode($urow->email);?>"><?php echo $urow->email;?></a></td>
      </tr>
      <tr>
        <td><?php echo lang('OVER_NOTE');?>:</td>
        <td><?php echo cleanOut(wordwrap($urow->notes,100,'<br />'));?></td>
      </tr>
    </table>
    <div class="hr3"></div>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('PROJ_NAME');?></th>
          <th class="header"><?php echo lang('PROJ_MANAGER');?></th>
          <th class="header"><?php echo lang('CREATED');?></th>
          <th class="header"><?php echo lang('STATUS');?></th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php if($projectrow == 0):?>
      <tr>
        <td colspan="5"><?php echo Filter::msgAlert(lang('PROJ_NOPROJECT'),false);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($projectrow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->staffname;?></td>
        <td><?php echo Filter::doDate($core->short_date, $row->start_date);?></td>
        <td><?php echo $content->progressBarStatus($row->p_status);?></td>
        <td><span class="tbicon"> <a href="index.php?do=projects&amp;action=edit&amp;id=<?php echo $row->pid;?>" class="tooltip" data-title="<?php echo lang('EDIT').': '.$row->title;?>"><i class="icon-pencil"></i></a> </span>
          <?php if($user->userlevel == 9):?>
          <span class="tbicon"> <a href="javascript:void(0);" id="item_<?php echo $row->pid;?>" class="tooltip delete" data-rel="<?php echo $row->title;?>" data-title="<?php echo lang('DELETE').': '.$row->title;?>"><i class="icon-trash"></i></a> </span>
          <?php endif;?></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </table>
    <div class="hr3"></div>
    <table class="myTable">
      <thead>
        <tr>
          <th class="header"><?php echo lang('INVC_NAME');?></th>
          <th class="header"><?php echo lang('TOTAL');?></th>
          <th class="header"><?php echo lang('PAID');?></th>
          <th class="header"><?php echo lang('OVER_BSTATUS');?></th>
          <th class="header"><?php echo lang('ACTIONS');?></th>
        </tr>
      </thead>
      <?php if(!$invoicerow):?>
      <tr>
        <td colspan="5"><?php echo Filter::msgInfo(lang('INVC_NOINVOICE2'),false);?></td>
      </tr>
      <?php else:?>
      <?php foreach ($invoicerow as $row):?>
      <tr>
        <td><?php echo $row->title;?></td>
        <td><?php echo $core->formatMoney($row->amount_total);?></td>
        <td><?php echo $core->formatMoney($row->amount_paid);?></td>
        <td><?php echo $content->progressBarBilling($row->amount_paid,$row->amount_total);?></td>
        <td><span class="tbicon"> <a href="index.php?do=invoices&amp;id=<?php echo $row->project_id;?>" class="tooltip" data-title="<?php echo lang('VIEW').': '.$row->title;?>"><i class="icon-bookmark"></i></a> </span></td>
      </tr>
      <?php endforeach;?>
      <?php unset($row);?>
      <?php endif;?>
    </table>
  </div>
</section>
<?php echo Core::doDelete(lang('PROJ_DELETE'),"deleteProject");?>