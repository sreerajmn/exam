<?php
  define("_VALID_PHP", true);
  define("_PIPN", true);

  ini_set('log_errors', true);
  ini_set('error_log', dirname(__file__) . '/ipn_errors.log');

  if (isset($_POST['payment_status'])) {
      require_once ("../../init.php");

      include (BASEPATH . 'lib/class_pp.php');
	  $listener = new IpnListener();
      $live = getValue("live", "gateways", "name = 'paypal'");

      /* only for debuggin purpose. Create logfile.txt and chmot to 0777
       ob_start();
       echo '<pre>';
       print_r($_POST);
       echo '</pre>';
       $logInfo = ob_get_contents();
       ob_end_clean();

       $file = fopen('logfile.txt', 'a');
       fwrite($file, $logInfo);
       fclose($file);
	   */
      
      $listener->use_live = $live;
      $listener->use_ssl = true;
      $listener->use_curl = false;

      try {
          $listener->requirePostMethod();
          $ppver = $listener->processIpn();
      }
      catch (exception $e) {
          error_log($e->getMessage());
          exit(0);
      }
	   
      $payment_status = $_POST['payment_status'];
      $receiver_email = $_POST['business'];
      $payer_email = $_POST['payer_email'];
      $payer_status = $_POST['payer_status'];

      list($user_id, $sesid) = explode('_', $_POST['custom']);
      $mc_gross = $_POST['mc_gross'];
      $inv_id = $_POST['item_number'];

      $pp_email = getValue("extra", "gateways", "name = 'paypal'");
      $invrow = $db->first("SELECT * FROM invoices WHERE id = " . (int)$inv_id);

      if ($ppver) {
          if ($_POST['payment_status'] == 'Completed') {
              if ($receiver_email == $pp_email && $invrow) {
                  $edata = array(
                      'project_id' => $invrow->project_id,
                      'invoice_id' => $invrow->id,
                      'amount' => floatval($mc_gross),
                      'recurring' => ($invrow->recurring) ? 1 : 0,
                      'created' => "NOW()",
                      'method' => "PayPal",
                      'description' => "Payment via Paypal");

                  $db->insert("invoice_payments", $edata);

                  $row = $db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");

                  $data['amount_paid'] = $row->amtotal;
                  $pdata['b_status'] = $data['amount_paid'];

                  $db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
                  
				  
				  //$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");
				  // Add Enrolment
				  $fdata = array(
					'course' => $invrow->project_id,
					'user' => $invrow->client_id,
					'date' => "NOW()", 
					'banned' => 0
				  );
				  $db->insert("enrollment", $fdata);
				  //
				  
				  
				  
                  $row2 = $db->first("SELECT amount_total, amount_paid FROM invoices WHERE id = '" . $edata['invoice_id'] . "'");
                  $idata['status'] = ($row2->amount_total == $row2->amount_paid) ? 'Paid' : 'Unpaid';
                  $db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");

                  /* == Notify User == */
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();

                  $userdata = $db->first("SELECT i.*," 
				  . "\n DATE_FORMAT(i.created, '" . $core->short_date . "') as cdate," 
				  . "\n DATE_FORMAT(i.duedate, '" . $core->short_date . "') as ddate," 
				  . "\n p.title as ptitle, CONCAT(u.fname,' ',u.lname) as name, u.email, u.address, u.city, u.zip, u.state, u.phone, u.company" 
				  . "\n FROM invoices as i" 
				  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
				  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
				  . "\n WHERE i.id = '" . $edata['invoice_id'] . "'");

                  ob_start();
                  require_once (BASEPATH . 'mailer/Email_Payment.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();

                  $subject = 'Payment Completed - ' . $userdata->ptitle;
                  $msg = Swift_Message::newInstance()
							->setSubject($subject)
							->setTo(array($userdata->email => $userdata->name))
							->setFrom(array(Registry::get("Core")
							->site_email => Registry::get("Core")->company))
							->setBody($html_message, 'text/html');
                  $mailer->send($msg);

              }
          }
      }
  }
?>