<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
  require_once(BASEPATH . "lib/class_dbtools.php");
  Registry::set('dbTools',new dbTools());
  $tools = Registry::get("dbTools");
?>
<?php if($user->userlevel !=9):?>
<?php Filter::msgAlert(lang('ADMINONLY'));?>
<?php else:?>
<?php
  if (isset($_GET['backupok']) && $_GET['backupok'] == "1")
      Filter::msgOk(lang('DB_CREATED'),1,1);
	    
  if (isset($_GET['create']) && $_GET['create'] == "1")
      $tools->doBackup('',false);
?>
<p class="greentip"><i class="icon-lightbulb icon-2x pull-left"></i><?php echo lang('DB_INFO');?></p>
<section class="widget">
  <header>
    <h1><i class="icon-reorder"></i> <?php echo lang('DB_SUB');?></h1>
    <?php if($user->userlevel == 9):?>
    <aside> <a class="hint--left hint--add hint--always hint--rounded" data-hint="<?php echo lang('DB_DOBACKUP');?>" href="index.php?do=backup&amp;create=1"><span class="icon-plus"></span></a> </aside>
    <?php endif;?>
  </header>
  <div class="content2">
    <?php
    $dir = BASEPATH . 'admin/backups/';
    if (is_dir($dir)):
        $getDir = dir($dir);
        while (false !== ($file = $getDir->read())):
            if ($file != "." && $file != ".." && $file != "index.php"):
                  $latest =  ($file == $core->sbackup) ? " db-latest" : "";
                  echo '<div class="db-backup' . $latest . '" id="item_' . $file . '"><i class="icon-hdd pull-left icon-4x icon-white"></i>';
                  echo '<span>' . getSize(filesize(BASEPATH . 'admin/backups/' . $file)) . '</span>';
                  
                  echo '<a class="delete">
                  <small class="sdelet tooltip" data-title="' .lang('DELETE').': '. $file . '"><i class="icon-trash icon-white"></i></small></a>';
                  
                  echo '<a href="' . ADMINURL . '/backups/' . $file . '">
                  <small class="sdown tooltip" data-title="' . lang('DOWNLOAD') . '"><i class="icon-download-alt icon-white"></i></small></a>';
                  
                  echo '<a class="restore">
				  <small class="srestore tooltip" data-title="' .lang('DB_DORESTORE').': '. $file . '"><i class="icon-refresh icon-white"></i></small></a>';
                  echo '<p>' . str_replace(".sql", "", $file) . '</p>';
                  
                  echo '</div>';
            endif;
        endwhile;
        $getDir->close();
    endif;
  ?>
  </div>
</section>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('a.delete').on('click', function () {
        var parent = $(this).closest('div');
        var id = parent.attr('id').replace('item_', '')
        var title = $(this).attr('data-rel');
        var text = "<div><i class=\"icon-warning-sign icon-2x pull-left\"></i><?php echo lang('DELCONFIRM');?></div>";
        new Messi(text, {
            title: "<?php echo lang('DB_DELETE');?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo lang('DELETE');?>",
                val: 'Y'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						url: "controller.php",
						data: 'deleteBackup=' + id,
						beforeSend: function () {
							parent.animate({
								'backgroundColor': '#FFBFBF'
							}, 400);
						},
						success: function (msg) {
							parent.fadeOut(400, function () {
								parent.remove();
							});
							$("html, body").animate({
								scrollTop: 0
							}, 600);
							$("#msgholder").html(msg);
						}
					});
                }
            }
        })
    });
	
    $('a.restore').on('click', function () {
        var parent = $(this).closest('div');
        var id = parent.attr('id').replace('item_', '')
        var title = $(this).attr('data-rel');
        var text = "<div><i class=\"icon-warning-sign icon-2x pull-left\"></i><?php echo lang('DB_RESCONFIRM');?></div>";
        new Messi(text, {
            title: "<?php echo lang('DB_DORESTORE');?>",
            modal: true,
            closeButton: true,
            buttons: [{
                id: 0,
                label: "<?php echo lang('DB_RESTORE');?>",
                val: 'Y'
            }],
            callback: function (val) {
                if (val === "Y") {
					$.ajax({
						type: 'post',
						url: "controller.php",
						data: 'restoreBackup=' + id,
						success: function (msg) {
							parent.effect('highlight', 1500);
							$("html, body").animate({
								scrollTop: 0
							}, 600);
							$("#msgholder").html(msg);
						}
					});
                }
            }
        })
    });
});
// ]]>
</script>
<?php endif;?>