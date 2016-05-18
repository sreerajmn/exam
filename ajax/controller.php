<?php
  define("_VALID_PHP", true);
  require_once("../init.php");

  if (!$user->logged_in)
      redirect_to("../index.php");
?>
<?php
  /* == Proccess User == */
  if (isset($_POST['processUser'])):
      if (intval($_POST['processUser']) == 0 || empty($_POST['processUser'])):
          redirect_to("../account.php");
      endif;
      $user->updateProfile();
  endif;
?>
<?php
  /* == Proccess Submission == */
  if (isset($_POST['processSubmissionRecord'])):
      if (intval($_POST['processSubmissionRecord']) == 0 || empty($_POST['processSubmissionRecord'])):
          redirect_to("../account.php");
      endif;

      $id = intval($_POST['processSubmissionRecord']);
      $data = array(
			'status' => intval($_POST['status']), 
			'review' => sanitize($_POST['review']), 
			'reviewed' => intval($_POST['status']) == 3 ? 0 : 1,
			'review_date' => "NOW()"
	  );

      $db->update("submissions", $data, "id='" . (int)$id . "'");
      print ($db->affected()) ? Filter::msgOk(lang('FPRO_SUBSENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));;

	  require_once (BASEPATH . "lib/class_mailer.php");
	  $row = $user->getSingleSubmissionsById($id );
	  $mailer = $mail->sendMail();
	  $subject = lang('FPRO_SUBESUBJECT') . cleanOut($row->title);

	  ob_start();
	  require_once (BASEPATH . 'mailer/Submission_From_Client.tpl.php');
	  $html_message = ob_get_contents();
	  ob_end_clean();
	  
	  $msg = Swift_Message::newInstance()
			  ->setSubject($subject)
			  ->setTo(array($row->email => $row->staffname))
			  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
			  ->setBody($html_message, 'text/html');

	  $mailer->send($msg);

  endif;
?>
<?php
  /* == Proccess Project File == */
  if (isset($_POST['processProjectFile'])):
      if (intval($_POST['processProjectFile']) == 0 || empty($_POST['processProjectFile'])):
          die();
      endif;
      $user->processProjectFile();
  endif;
?>
<?php
  /* == Proccess Contact Request == */
  if (isset($_POST['processContact'])):
      if (intval($_POST['processContact']) == 0 || empty($_POST['processContact'])):
          die();
      endif;

      if (empty($_POST['msgsubject']))
          Filter::$msgs['msgsubject'] = lang('FMSG_MSGERR1');
		   
      if (empty($_POST['message']))
          Filter::$msgs['message'] = lang('FMSG_MSGERR2');

	  $upl = Uploader::instance($core->file_max, $core->file_types);
	  if (!empty($_FILES['attachment']['name']) and empty(Filter::$msgs)) {
		  $dir = UPLOADS . 'tempfiles/';
		  $upl->upload('attachment', $dir, "ATT_");
	  }
		   
      if (empty(Filter::$msgs)) {
		  if (Filter::$id) {
			  $data = array(
				  'uid1' => Filter::$id,
				  'uid2' => intval($_POST['uid2']),
				  'msgsubject' => "",
				  'user1' => Registry::get("Users")->uid,
				  'user2' => 0,
				  'body' => $_POST['message'],
				  'attachment' => "",
				  'created' => "NOW()",
				  'user1read' => "yes",
				  'user2read' => "no",
				  );
			  $db->insert("messages", $data);

			  $data2 = array('user' . intval($_POST['userp']) . 'read' => "no");
			  $db->update("messages", $data2, "uid1='" . Filter::$id . "' AND uid2 = '1'");
			  
			  $sql = "SELECT email, CONCAT(fname,' ',lname) as staffname FROM users WHERE id = " . (int)$_POST['recipient'];
			  $row = $db->first($sql);

			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('MSG_ESUBJECT') . cleanOut($_POST['msgsubject']);
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Reply_Message_From_Client.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->staffname))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setBody($html_message, 'text/html');
	
			 $mailer->send($msg);

			 print 'OK';

		  } else {
			  $single = $db->first("SELECT COUNT(id) as recip, id as recipid, (SELECT COUNT(*) FROM messages) as newmsg FROM users where id='" . intval($_POST['recipient']) . "'");
			  $data = array(
				  'uid1' => intval($single->newmsg + 1),
				  'uid2' => 1,
				  'msgsubject' => sanitize($_POST['msgsubject']),
				  'user1' => Registry::get("Users")->uid,
				  'user2' => intval($single->recipid),
				  'body' => $_POST['message'],
				  'attachment' => !empty($_FILES['attachment']['name']) ? $upl->fileInfo['fname'] : "",
				  'created' => "NOW()",
				  'user1read' => "yes",
				  'user2read' => "no",
				  );
				  
			  $db->insert("messages", $data);
			  
			  $sql = "SELECT email, CONCAT(fname,' ',lname) as staffname FROM users WHERE id = " . (int)$_POST['recipient'];
			  $row = $db->first($sql);

			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('MSG_ESUBJECT') . cleanOut($_POST['msgsubject']);
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Reply_Message_From_Client.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->staffname))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setBody($html_message, 'text/html');
	
			 $mailer->send($msg);

			 print 'OK';
		  }

      } else 
          print Filter::msgStatus();
  endif;
  
  /* == Delete Message == */
  if (isset($_POST['deleteMessage']))
      : if (intval($_POST['deleteMessage']) == 0 || empty($_POST['deleteMessage']))
      : die();
  endif;
  
  list($id, $uid) = explode(":", $_POST['deleteMessage']);
  $res = $db->delete("messages", "id='" . (int)$id . "'");
  $db->delete("messages", "uid1='" . (int)$uid . "'");
  $title = sanitize($_POST['title']);
  
  print ($res) ? Filter::msgOk(str_replace("[MESSAGE]", $title, lang('MSG_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Client Credit == */
  if (isset($_POST['docredit'])):
      if (intval($_POST['docredit']) == 0 || empty($_POST['docredit'])):
          die();
      endif;

      $invrow = $user->getInvoiceById(intval($_POST['invid']));
      if ($invrow):
          $amount = $invrow->amount_total - $invrow->amount_paid;
          $credit = getValue("credit", "users", "id = '" . $user->uid . "'");

          if (number_format($credit, 2, '.', '') >= number_format($amount, 2, '.', '')):
              $edata = array(
                  'project_id' => $invrow->project_id,
                  'invoice_id' => $invrow->id,
                  'amount' => floatval($amount),
                  'recurring' => ($invrow->recurring) ? 1 : 0,
                  'created' => "NOW()",
                  'method' => "Credit",
                  'description' => "Payment via Available Credit");

              $db->insert("invoice_payments", $edata);
              $row = $db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");

              $data['amount_paid'] = $row->amtotal;
              $pdata['b_status'] = $data['amount_paid'];

              $db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
              $db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");

              $row2 = $db->first("SELECT amount_total, amount_paid FROM invoices WHERE id = '" . $edata['invoice_id'] . "'");
              $idata['status'] = ($row2->amount_total == $row2->amount_paid) ? 'Paid' : 'Unpaid';
              $db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");

			  $udata['credit'] = number_format($credit, 2, '.', '') - number_format($amount, 2, '.', '');
			  $db->update("users", $udata, "id='" . $user->uid . "'");
			  
              $json['type'] = 'success';
              $json['info'] = 'full';
			  $json['paid'] = $amount;
              $json['credit'] = number_format($credit, 2, '.', '') - number_format($amount, 2, '.', '');
			  $json['message'] = '<div class="blue"><p><span class="icon-info-sign"></span><i class="close icon-double-angle-down"></i>' . lang('FBILL_PAYINFULL') . '</p></div>';
              print json_encode($json);

          else:
              $edata = array(
                  'project_id' => $invrow->project_id,
                  'invoice_id' => $invrow->id,
                  'amount' => floatval($credit),
                  'recurring' => ($invrow->recurring) ? 1 : 0,
                  'created' => "NOW()",
                  'method' => "Credit",
                  'description' => "Payment via Available Credit");
				  
              $db->insert("invoice_payments", $edata);
              $row = $db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");

              $data['amount_paid'] = $row->amtotal;
              $pdata['b_status'] = $data['amount_paid'];

              $db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
              $db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");

              $row2 = $db->first("SELECT amount_total, amount_paid FROM invoices WHERE id = '" . $edata['invoice_id'] . "'");
              $idata['status'] = ($row2->amount_total == $row2->amount_paid) ? 'Paid' : 'Unpaid';
              $db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");
			  
			  $udata['credit'] = 0.00;
			  $db->update("users", $udata, "id='" . $user->uid . "'");
			  
			  $total = $user->getInvoiceById(intval($_POST['invid']));

              $json['type'] = 'success';
              $json['info'] = 'partial';
			  $json['paid'] = number_format($total->amount_paid,2);
              $json['invpending'] = number_format($total->amount_total, 2) - number_format($total->amount_paid,2);
			  $json['message'] = '<div class="blue"><p><span class="icon-info-sign"></span><i class="close icon-double-angle-down"></i>' . lang('FBILL_PAYPARTIAL') . '</p></div>';
              print json_encode($json);

          endif;

      else:
	      $json['type'] = 'error';
		  $json['message'] = 'invalid invoice id';
          print json_encode($json);
      endif;

  endif;
?>
<?php
  /* == Load Gateways == */
  if (isset($_POST['loadgateway'])):
      if (intval($_POST['loadgateway']) == 0 || empty($_POST['loadgateway'])):
          die();
      endif;
	  $gate_id = intval($_POST['loadgateway']);
	  $inv_id = intval($_POST['invoice_id']);
	  $amount = floatval($_POST['amount']);
	  $pamount = floatval($_POST['pamount']);
	  if ($amount == 0 or (empty($amount)) or $amount > $pamount) {
		  print Filter::msgError(lang('FBILL_ERR1'));
	  } else {
		  if ($gate_id == 100) {
			  print '<p class="pagetip">' . cleanOut($core->offline_info) . '<p>';
		  } else {
			  $row = $core->getRowById("gateways", $gate_id, false, false);
			  $row2 = $user->getInvoiceById($inv_id);

			  $form_url = BASEPATH . "gateways/" . $row->dir . "/form.tpl.php";
			  (file_exists($form_url)) ? include ($form_url) : Filter::msgError(lang('FBILL_ERR2'));
		  }
	  }
  endif;
?>
<?php
  /* == View Task Data == */
  if (isset($_POST['viewTaskData'])):
      if (intval($_POST['viewTaskData']) == 0 || empty($_POST['viewTaskData'])):
          die();
      endif;
      $tid = intval($_POST['tid']); 
      $row = $user->getTaskByProjectId($tid);
	  print '<p style="max-width:450px">' . cleanOut($row->details) . '</p>';
  endif;
?>
<?php
  /* == View Filedescription Data == */
  if (isset($_POST['viewFileDescData'])):
      if (intval($_POST['viewFileDescData']) == 0 || empty($_POST['viewFileDescData'])):
          die();
      endif;
      $details = getValueById("filedesc", "project_files", Filter::$id);
	  print '<p style="max-width:450px">' . cleanOut($details) . '</p>';
  endif;
?>
<?php
  /* == Reply Support Ticket == */
  if (isset($_POST['replySupportTicket'])):
      if (intval($_POST['replySupportTicket']) == 0 || empty($_POST['replySupportTicket'])):
          die();
      endif;
      Filter::$id = intval($_POST['replySupportTicket']); 
      $user->replySupportTicket();
  endif;

  /* == Load Support Ticket == */
  if (isset($_POST['loadReplyEntries'])):
      if (intval($_POST['loadReplyEntries']) == 0 || empty($_POST['loadReplyEntries'])):
          die();
      endif;
	  
      Filter::$id = intval($_POST['loadReplyEntries']);
      $resrow = $user->getResponseByTicketId();

      if ($resrow):
          print '<ul id="reply-list">';
          foreach ($resrow as $trow):
              $class = ($trow->user_type == "client") ? 'row-client' : 'row-staff';
			  $type = ($trow->user_type == "client") ? lang('YOU') : lang('STAFF');
              print '<li class="' . $class . '">'
			  . '<span class="label2 label-inverse">' . lang('CREATED') . '</span> ' . Filter::dodate($core->long_date, $trow->created) . ' - <span class="label2 label-info">' . lang('AUTHOR') . '</span> ' . $trow->name . ' (' . $type . ')';
              print '<div>' . cleanOut($trow->body) . '</div></li>';
          endforeach;
          print '</ul>';
      endif;
  endif;
        
        
  /* == Close Ticket Status == */
  if (isset($_POST['closeTicket'])):
      if (intval($_POST['closeTicket']) == 0 || empty($_POST['closeTicket'])):
          die();
      endif;
	  print 'ok';
      $id = intval($_POST['closeTicket']); 
	  $data['status'] = 'Closed';
      $db->update("support_tickets", $data, "id = '" . $id . "'");
  endif;
  
  /* == Proccess Ticket == */
  if (isset($_POST['processSupportTicket'])):
      if (intval($_POST['processSupportTicket']) == 0 || empty($_POST['processSupportTicket'])):
          die();
      endif;
      $user->processSupportTicket();
  endif;
?>
<?php
  /* == Make Pdf == */
  if (isset($_GET['dopdf'])):
      if (intval($_GET['dopdf']) == 0 || empty($_GET['dopdf'])):
          redirect_to("../account.php");
      endif;
	  
	  Filter::$id = intval($_GET['dopdf']);
	  $title = cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $_GET['title']));
	  ob_start();
	  require_once(BASEPATH . 'print_pdf.php');
	  $pdf_html = ob_get_contents();
	  ob_end_clean();

	  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
	  $dompdf = new DOMPDF();
	  $dompdf->load_html($pdf_html);
	  $dompdf->render();
	  $dompdf->stream($title . ".pdf");
  endif;
?>