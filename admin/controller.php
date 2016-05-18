<?php
  define("_VALID_PHP", true);
  
  require_once("init.php");
  if (!$user->is_Admin())
    redirect_to("login.php");
?>
<?php
  /* == Proccess Configuration == */
  if (isset($_POST['processConfig'])):
      $core->processConfig();
  endif;
?>
<?php
  /* == Proccess Gateway == */
  if (isset($_POST['processGateway']))
      : if (intval($_POST['processGateway']) == 0 || empty($_POST['processGateway']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processGateway();
  endif;
?>
<?php
  /* == Proccess News == */
  if (isset($_POST['processNews'])):
      if (intval($_POST['processNews']) == 0 || empty($_POST['processNews'])):
          redirect_to("index.php?do=news");
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->processNews();
  endif;

  /* == Update Question == */
  if (isset($_POST['updateQuestion'])):
      if (intval($_POST['updateQuestion']) == 0 || empty($_POST['updateQuestion'])):
          redirect_to("index.php?do=questions");
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->updateQuestion();
  endif;
  
  /* == Delete News == */
  if (isset($_POST['deleteNews'])):
      if (intval($_POST['deleteNews']) == 0 || empty($_POST['deleteNews'])):
          die();
      endif;

      $id = intval($_POST['deleteNews']);
      $db->delete("news", "id='" . $id . "'");

      $title = sanitize($_POST['title']);
	  print ($db->affected()) ? Filter::msgOk(str_replace("[NEWS]", $title, lang('NEWS_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  /* == Delete Result == */
  if (isset($_POST['deleteResult'])):
      if (intval($_POST['deleteResult']) == 0 || empty($_POST['deleteResult'])):
          die();
      endif;

      $id = intval($_POST['deleteResult']);
      $db->delete("results", "id='" . $id . "'");

      $title = sanitize($_POST['title']);
	  print ($db->affected()) ? Filter::msgOk(str_replace("[Result]", 'Result', lang('NEWS_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;

  /* == Delete Enrolment == */
  if (isset($_POST['deleteEnrolment'])):
      if (intval($_POST['deleteEnrolment']) == 0 || empty($_POST['deleteEnrolment'])):
          die();
      endif;

      $id = intval($_POST['deleteEnrolment']);
      $db->delete("enrollment", "id='" . $id . "'");

      $title = sanitize($_POST['title']);
	  print ($db->affected()) ? Filter::msgOk(str_replace("[Enrolment]", 'Enrolment', lang('NEWS_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;


  /* == Process Enrolment == */
  if (isset($_POST['processEnrol'])):
      if (intval($_POST['processEnrol']) == 0 || empty($_POST['processEnrol'])):
          die();
      endif;

      $id = intval($_POST['processEnrol']);
	  
	  $data = array(
			'user' => 2, 
			'course' => $id, 
			'date' => "NOW()", 
			'banned' => 0
	  );
	  
	  $db->insert("enrollment", $data);
	  
      $title = sanitize($_POST['title']);
	  print ($db->affected()) ? Filter::msgOk(str_replace("[NEWS]", $title, lang('NEWS_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Email == */
  if (isset($_POST['processEmail']))
      : if (intval($_POST['processEmail']) == 0 || empty($_POST['processEmail']))
      : die();
  endif;
  $content->processEmail();
  endif;
?>
<?php
  /* == Proccess Project == */
  if (isset($_POST['processProject']))
      : if (intval($_POST['processProject']) == 0 || empty($_POST['processProject']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processProject();
  endif;

  
  /* == Delete Project == */
  if (isset($_POST['deleteProject']))
      : if (intval($_POST['deleteProject']) == 0 || empty($_POST['deleteProject']))
      : die();
  endif;
  
  $id = intval($_POST['deleteProject']);
  $res = $db->delete("projects", "id='" . $id . "'");
  $db->delete("permissions", "project_id='" . $id . "'");
  $db->delete("tasks", "project_id='" . $id . "'");
  $db->delete("submissions", "project_id='" . $id . "'");
  $db->delete("invoices", "project_id='" . $id . "'");
  $db->delete("invoice_data", "project_id='" . $id . "'");
  $db->delete("invoice_payments", "project_id='" . $id . "'");
  $db->delete("time_billing", "project_id='" . $id . "'");
  
  $filename = getValue("filename", "project_files", "project_id='" . $id . "'");
  @unlink(UPLOADS . 'data/'.$filename);
  
  $db->delete("project_files", "project_id='" . $id . "'");
  $title = sanitize($_POST['title']);
  
  print ($res) ? Filter::msgOk(str_replace("[PROJECT]", $title, lang('PROJ_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  
  /* == Proccess Question == */
  if (isset($_POST['processQuestion']))
      : if (intval($_POST['processQuestion']) == 0 || empty($_POST['processQuestion']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processQuestion();
  endif;
  
  
  /* == Delete Question == */
  if (isset($_POST['deleteQuestion']))
      : if (intval($_POST['deleteQuestion']) == 0 || empty($_POST['deleteQuestion']))
      : die();
  endif;
  
  $id = intval($_POST['deleteQuestion']);
  $res = $db->delete("questions", "id='" . $id . "'");
  $db->delete("answers", "question='" . $id . "'");
  
  print ($res) ? Filter::msgOk(str_replace("[PROJECT]", $title, lang('PROJ_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Exam == */
  if (isset($_POST['processExam']))
      : if (intval($_POST['processExam']) == 0 || empty($_POST['processExam']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processExam();
  endif;

  /* == Delete Exam == */
  if (isset($_POST['deleteExam']))
      : if (intval($_POST['deleteExam']) == 0 || empty($_POST['deleteExam']))
      : die();
  endif;
  
  $id = intval($_POST['deleteExam']);
  $res = $db->delete("exams", "id='" . $id . "'");
  
  print ($res) ? Filter::msgOk(str_replace("[PROJECT]", $title, lang('PROJ_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Resource Category == */
  if (isset($_POST['processCategory'])):
      if (intval($_POST['processCategory']) == 0 || empty($_POST['processCategory'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->processCategory();
  endif;

  /* == Delete Project Type == */
  if (isset($_POST['deleteCategory'])):
      if (intval($_POST['deleteCategory']) == 0 || empty($_POST['deleteCategory'])):
          die();
      endif;

      $id = intval($_POST['deleteCategory']);
      $db->delete("categories", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[TYPE]", $title, lang('TYPE_DELTYPE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Resource Item == */
  if (isset($_POST['processFAQ'])):
      if (intval($_POST['processFAQ']) == 0 || empty($_POST['processFAQ'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->processFAQ();
  endif;

  /* == Delete Project Type == */
  if (isset($_POST['deleteFAQ'])):
      if (intval($_POST['deleteFAQ']) == 0 || empty($_POST['deleteFAQ'])):
          die();
      endif;

      $id = intval($_POST['deleteFAQ']);
      $db->delete("faqs", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[TYPE]", $title, lang('TYPE_DELTYPE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Resource Item == */
  if (isset($_POST['processResource'])):
      if (intval($_POST['processResource']) == 0 || empty($_POST['processResource'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->processResource();
  endif;

  /* == Delete Project Type == */
  if (isset($_POST['deleteResource'])):
      if (intval($_POST['deleteResource']) == 0 || empty($_POST['deleteResource'])):
          die();
      endif;

      $id = intval($_POST['deleteResource']);
      $db->delete("resources", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[TYPE]", $title, lang('TYPE_DELTYPE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Project Type == */
  if (isset($_POST['processProjectType'])):
      if (intval($_POST['processProjectType']) == 0 || empty($_POST['processProjectType'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->processProjectType();
  endif;

  /* == Delete Project Type == */
  if (isset($_POST['deleteProjectType'])):
      if (intval($_POST['deleteProjectType']) == 0 || empty($_POST['deleteProjectType'])):
          die();
      endif;

      $id = intval($_POST['deleteProjectType']);
      $db->delete("project_types", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

      print ($db->affected()) ? Filter::msgOk(str_replace("[TYPE]", $title, lang('TYPE_DELTYPE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Project Task == */
  if (isset($_POST['processProjectTask'])):
      if (intval($_POST['processProjectTask']) == 0 || empty($_POST['processProjectTask'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
      $content->processProjectTask();
  endif;

  /* == Load Task Templates == */
  if (isset($_POST['getTaskTemplateList'])):
      $id = intval($_POST['getTaskTemplateList']);
	  if($row = $db->first("SELECT * FROM task_templates WHERE id = '" . $id . "'")) :
		  print json_encode($row);
	    else :
		  print 0;
	  endif;
  endif;
  
  /* == Delete Project Task == */
  if (isset($_POST['deleteProjectTask'])):
      if (intval($_POST['deleteProjectTask']) == 0 || empty($_POST['deleteProjectTask'])):
          die();
      endif;

      $id = intval($_POST['deleteProjectTask']);
      $db->delete("tasks", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

	  print ($db->affected()) ? Filter::msgOk(str_replace("[TASK]", $title, lang('TASK_DELTASK_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Task Templates == */
  if (isset($_POST['processTaskTemplate'])):
      if (intval($_POST['processTaskTemplate']) == 0 || empty($_POST['processTaskTemplate'])):
          die();
      endif;
      $content->processTaskTemplate();
  endif;

  /* == Delete Task Template == */
  if (isset($_POST['deleteTaskTemplate'])):
      if (intval($_POST['deleteTaskTemplate']) == 0 || empty($_POST['deleteTaskTemplate'])):
          die();
      endif;

      $id = intval($_POST['deleteTaskTemplate']);
      $db->delete("task_templates", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

	  print ($db->affected()) ? Filter::msgOk(str_replace("[TEMPLATE]", $title, lang('TTASK_DELTEMPLATE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Project Submission == */
  if (isset($_POST['processSubmission']))
      : if (intval($_POST['processSubmission']) == 0 || empty($_POST['processSubmission']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processProjectSubmission();
  endif;

  /* == Delete Project Submission == */
  if (isset($_POST['deleteSubmission']))
      : if (intval($_POST['deleteSubmission']) == 0 || empty($_POST['deleteSubmission']))
      : die();
  endif;
  
  $id = intval($_POST['deleteSubmission']);
  $db->delete("submissions", "id='" . $id . "'");
  $title = sanitize($_POST['title']);
  
  print ($db->affected()) ? Filter::msgOk(str_replace("[SUBMISSION]", $title, lang('SUBS_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess Project File == */
  if (isset($_POST['processProjectFile'])):
      if (intval($_POST['processProjectFile']) == 0 || empty($_POST['processProjectFile'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $content->processProjectFile();
  endif;

  /* == Delete Project File == */
  if (isset($_POST['deleteProjectFile'])):
      if (empty($_POST['deleteProjectFile'])):
          die();
      endif;

      list($id, $filename) = explode(":", $_POST['deleteProjectFile']);
      @unlink(UPLOADS . '/data/' . $filename);

      $db->delete("project_files", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

	  print ($db->affected()) ? Filter::msgOk(str_replace("[FILE]", $title, lang('FILE_DELFILE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));

  endif;
?>
<?php
  /* == Update Invoice == */
  if (isset($_POST['updateInvoice']))
      : if (intval($_POST['updateInvoice']) == 0 || empty($_POST['updateInvoice']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->updateInvoice();
  endif;

  /* == Add Invoice == */
  if (isset($_POST['addInvoice']))
      : if (intval($_POST['addInvoice']) == 0 || empty($_POST['addInvoice']))
      : die();
  endif;

  $content->addInvoice();
  endif;
  
  /* == Send Invoice == */
  if (isset($_POST['sendInvoice']))
      : if (intval($_POST['sendInvoice']) == 0 || empty($_POST['sendInvoice']))
      : die();
  endif;
  $id = intval($_POST['sendInvoice']); 
  $content->sendInvoice($id);
  endif;
  
  /* == Delete Invoice == */
  if (isset($_POST['deleteInvoice']))
      : if (empty($_POST['deleteInvoice']))
      : die();
  endif;
  
  list($id, $pid) = explode(":",$_POST['deleteInvoice']);

  $res = $db->delete("invoices", "id='" . (int)$id . "'");
  $db->delete("invoice_payments", "invoice_id='" . (int)$id . "'");
  $db->delete("invoice_data", "invoice_id='" . (int)$id . "'");
  $row = $db->first("SELECT SUM(amount_paid) as amtotal FROM invoices WHERE project_id = '" . (int)$pid . "' GROUP BY project_id");
  
  $pdata['b_status'] = ($row) ? $row->amtotal : 0.00;
  $db->update("projects", $pdata, "id='" . (int)$pid . "'");
  
  $title = sanitize($_POST['title']);
  
  print ($res) ? Filter::msgOk(str_replace("[INVOICE]", $title, lang('INVC_DELETEINV_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  /* == Load Invoice Entries == */
  if (isset($_POST['loadInvoiceEntries'])):
      if (intval($_POST['loadInvoiceEntries']) == 0 || empty($_POST['loadInvoiceEntries'])):
          die();
      endif;
      $id = intval($_POST['loadInvoiceEntries']);
      $content->loadInvoiceEntries($id);
  endif;
  
  /* == Process Invoice Entry == */
  if (isset($_POST['processInvoiceEntry'])):
      if (intval($_POST['processInvoiceEntry']) == 0 || empty($_POST['processInvoiceEntry'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
      $content->processInvoiceEntry();
  endif;
  
  /* == Delete Invoice Entry == */
  if (isset($_POST['deleteInvoiceEntry'])):
      if (empty($_POST['deleteInvoiceEntry'])):
          die();
      endif;
      $content->deleteInvoiceEntry($_POST['deleteInvoiceEntry']);
  endif;
  
  /* == Load Invoice Records == */
  if (isset($_POST['loadInvoiceRecords'])):
      if (intval($_POST['loadInvoiceRecords']) == 0 || empty($_POST['loadInvoiceRecords'])):
          die();
      endif;
      $id = intval($_POST['loadInvoiceRecords']);
      $content->loadInvoiceRecords($id);
  endif;
  
  /* == Process Invoice Record == */
  if (isset($_POST['processInvoiceRecord'])):
      if (intval($_POST['processInvoiceRecord']) == 0 || empty($_POST['processInvoiceRecord'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
      $content->processInvoiceRecord();
  endif;
  
  /* == Delete Invoice Record == */
  if (isset($_POST['deleteInvoiceRecord'])):
      if (empty($_POST['deleteInvoiceRecord'])):
          die();
      endif;
      $content->deleteInvoiceRecord($_POST['deleteInvoiceRecord']);
  endif;
?>
<?php
  /* == Add Quote == */
  if (isset($_POST['addQuote']))
      : if (intval($_POST['addQuote']) == 0 || empty($_POST['addQuote']))
      : die();
  endif;

  $content->addQuote();
  endif;

  /* == Convert Quote == */
  if (isset($_POST['convertQuote']))
      : if (intval($_POST['convertQuote']) == 0 || empty($_POST['convertQuote']))
      : die();
  endif;

  $content->convertQuote();
  endif;
  
  /* == Send Quote == */
  if (isset($_POST['sendQuote']))
      : if (intval($_POST['sendQuote']) == 0 || empty($_POST['sendQuote']))
      : die();
  endif;
  $id = intval($_POST['sendQuote']); 
  $content->sendQuote($id);
  endif;

  /* == Delete Quote == */
  if (isset($_POST['deleteQuote']))
      : if (empty($_POST['deleteQuote']))
      : die();
  endif;
  
  $id = intval($_POST['deleteQuote']);

  $res = $db->delete("quotes", "id='" . (int)$id . "'");
  $db->delete("quotes_data", "quote_id='" . (int)$id . "'");
  $title = sanitize($_POST['title']);
  
  print ($res) ? Filter::msgOk(str_replace("[QUOTE]", $title, lang('QUTS_DELETEINV_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Proccess User == */
  if (isset($_POST['processUser'])):
      if (intval($_POST['processUser']) == 0 || empty($_POST['processUser'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      $user->processUser();
  endif;

  /* == Add Client Funds == */
  if (isset($_POST['addClientFunds'])):
      $amount = floatval($_POST['amount']);
	  $userid = intval($_POST['addClientFunds']);
	  $totalnow = getValue("credit", "users","id = $userid");
	  
	  $data['credit'] = ($totalnow == 0.00 and $amount < 1) ? '0.00' : floatval($totalnow + $amount);
	  $db->update("users", $data, "id='" . $userid . "'");
	  print $data['credit'];
  
  endif;
  
  /* == Delete User== */
  if (isset($_POST['deleteUser'])):
      if (intval($_POST['deleteUser']) == 0 || empty($_POST['deleteUser'])):
          die();
      endif;

      $id = intval($_POST['deleteUser']);
      if ($id == 1):
          Filter::msgError(lang('STAFF_DELUSER_ERR1'));
      else:
          if ($projects = $db->fetch_all("SELECT id FROM enrollment WHERE user = '$id'")):
              foreach ($projects as $row):
                  $db->delete("invoice_data", "project_id='" . $row->id . "'");
                  $db->delete("invoice_payments", "project_id='" . $row->id . "'");
                  $db->delete("invoices", "project_id='" . $row->id . "'");
              endforeach;
          endif;
          $db->delete("enrollment", "user='" . $id . "'");
          $db->delete("users", "id='" . $id . "'");
          $username = sanitize($_POST['title']);

          print ($db->affected()) ? Filter::msgOk(str_replace("[USERNAME]", $username, lang('STAFF_DELUSER_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
      endif;
  endif;
  
  /* == Get User Info == */
  if (isset($_POST['getUserInfo'])):
      if (intval($_POST['getUserInfo']) == 0 || empty($_POST['getUserInfo'])):
          die();
      endif;
      Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
      if ($pp_email = getValue("pp_email", "users", "id = '" . Filter::$id . "'")):
          print $pp_email;
	  endif;
  endif;
  
  /* == Staff Pay == */
  if (isset($_POST['MassPay']) and $user->userlevel == 9):
      if (intval($_POST['MassPay']) == 0 || empty($_POST['MassPay'])):
          die();
      endif;
      $user->staffPay();
  endif;
?>
<?php
  /* == Proccess Time Billing Record == */
  if (isset($_POST['processTimeRecord']))
      : if (intval($_POST['processTimeRecord']) == 0 || empty($_POST['processTimeRecord']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processTimeRecord();
  endif;

  /* == Delete Time Billing Record == */
  if (isset($_POST['deleteTimeBillingRecord'])):
      if (empty($_POST['deleteTimeBillingRecord'])):
          die();
      endif;
	  
  $id = intval($_POST['deleteTimeBillingRecord']);
  $db->delete("time_billing", "id='" . $id . "'");
  $title = sanitize($_POST['title']);
  
  print ($db->affected()) ? Filter::msgOk(str_replace("[TIMEBILL]", $title, lang('BILL_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  /* == Delete Time Billing == */
  if (isset($_POST['deleteTimeBilling'])):
      if (empty($_POST['deleteTimeBilling'])):
          die();
      endif;
	  
  $id = intval($_POST['deleteTimeBilling']);
  $db->delete("time_billing", "project_id='" . $id . "'");
  $title = sanitize($_POST['title']);
  
  print ($db->affected()) ? Filter::msgOk(str_replace("[TIMEBILL]", $title, lang('BILL_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  /* == Create Time Billing Report == */
  if (isset($_GET['action']) and $_GET['action'] == "createTimeReport"):

	  $sql = "SELECT tb.*,"
	  . "\n tb.created as cdate,"
	  . "\n p.title as ptitle, ts.title as tasktitle, CONCAT(u.fname,' ',u.lname) as fullname"
	  . "\n FROM time_billing as tb"
	  . "\n LEFT JOIN projects as p ON p.id = tb.project_id"
	  . "\n LEFT JOIN tasks as ts ON ts.id = tb.task_id"
	  . "\n LEFT JOIN users as u ON u.id = tb.client_id";
	  
	  $result = $db->fetch_all($sql);
	  
      $type = "vnd.ms-excel";
	  $date = date('m-d-Y H:i');
	  $title = "Exported from the " . $core->company . " on $date";
	  
      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
	  header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");
	  
	  print '
	  <table width="100%" cellpadding="1" cellspacing="2" border="1">
	  <caption>' . $title . '</caption>
	    <thead>
		<tr>
		  <td>#</th>
		  <td>' . lang('BILL_RECNAME') . '</td>
		  <td>' . lang('PROJ_NAME') . '</td>
		  <td>' . lang('INVC_CNAME') . '</td>
		  <td>' . lang('TASK_NAME') . '</td>
		  <td>' . lang('CREATED') . '</td>
		  <td>' . lang('HOURS') . '</td>
		  <td>' . lang('DESC') . '</td>
		</tr>
		</thead>';
		foreach ($result as $v) {
			print '<tr>
			  <td>'.$v->id.'</td>
			  <td>'.$v->title.'</td>
			  <td>'.$v->ptitle.'</td>
			  <td>'.$v->fullname.'</td>
			  <td>'.$v->tasktitle.'</td>
			  <td>'.Filter::dodate($core->long_date, $v->cdate).'</td>
			  <td>'.$v->hours.'</td>
			  <td>'.sanitize($v->description).'</td>
			</tr>';
		}
	  print '</table>';
	  unset($v);
	  exit();
  endif;
?>
<?php
  /* == Create Enrolment Transaction Report == */
  if (isset($_GET['action']) and $_GET['action'] == "createTransReport"):
  
	  $sql = "SELECT invoices.id, users.fname as fname, users.lname as lname, invoices.title, invoices.amount_paid, invoices.method, invoices.duedate FROM invoices 
	  INNER JOIN users 
	  ON invoices.client_id=users.id WHERE invoices.status='Paid'";
	  
	  $result = $db->fetch_all($sql);
	  
      $type = "vnd.ms-excel";
	  $date = date('m-d-Y H:i');
	  $title = "Exported from the " . $core->company . " on $date";

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
	  header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");
	  
	  print '
	  <table width="100%" cellpadding="1" cellspacing="2" border="1">
	  <caption>' . $title . '</caption>
	    <thead>
		<tr>
		  <td>ID</td>
		  <td>Client Name</td>
		  <td>Transaction Details</td>
		  <td>Amount</td>
		  <td>Method</td>
		  <td>Date</td>
		</tr>
		</thead>';
		foreach ($result as $v) {
			print '<tr>
			  <td>'. $v->id .'</td>
			  <td>'. $v->fname .' '.$v->lname.'</td>
			  <td>'. $v->title .'</td>
			  <td>'. $v->amount_paid .'</td>
			  <td>'. $v->method .'</td>
			  <td>'. $v->duedate .'</td>
			</tr>';
		}
	  print '</table>';
	  unset($v);
	  exit();
  endif;

  /* == Create Project Transaction Report == */
  if (isset($_GET['action']) and $_GET['action'] == "createReport"):
  
	  $sql = "SELECT ip.*,"
	  . "\n ip.created as cdate,"
	  . "\n p.title as ptitle, i.title as ititle, CONCAT(u.fname,' ',u.lname) as fullname"
	  . "\n FROM invoice_payments as ip"
	  . "\n LEFT JOIN projects as p ON p.id = ip.project_id"
	  . "\n LEFT JOIN invoices as i ON i.id = ip.invoice_id"
	  . "\n LEFT JOIN users as u ON u.id = i.client_id";
	  
	  $result = $db->fetch_all($sql);
	  
      $type = "vnd.ms-excel";
	  $date = date('m-d-Y H:i');
	  $title = "Exported from the " . $core->company . " on $date";

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
	  header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");
	  
	  print '
	  <table width="100%" cellpadding="1" cellspacing="2" border="1">
	  <caption>' . $title . '</caption>
	    <thead>
		<tr>
		  <td>#</th>
		  <td>' . lang('PROJ_NAME') . '</td>
		  <td>' . lang('INVC_CNAME') . '</td>
		  <td>#' . lang('TRANS_INVOICE') . '</td>
		  <td>' . lang('TRANS_PAYDATE') . '</td>
		  <td>' . lang('PAYMETHOD') . '</td>
		  <td>' . lang('AMOUNT') . '</td>
		  <td>' . lang('INFO') . '</td>
		</tr>
		</thead>';
		foreach ($result as $v) {
			print '<tr>
			  <td>'.$v->id.'</td>
			  <td>'.$v->ptitle.'</td>
			  <td>'.$v->fullname.'</td>
			  <td>'.($core->invoice_number . $v->invoice_id).'</td>
			  <td>'.Filter::dodate($core->long_date, $v->cdate).'</td>
			  <td>'.$v->method.'</td>
			  <td>'.$v->amount.'</td>
			  <td>'.$v->description.'</td>
			</tr>';
		}
	  print '</table>';
	  unset($v);
	  exit();
  endif;
  
  /* == Create Service Transaction Report == */
  if (isset($_GET['action']) and $_GET['action'] == "createServiceReport"):
  
	  $sql = "SELECT *"
	  . "\n FROM payments "
	  . "\n ORDER BY created";
	  
	  $result = $db->fetch_all($sql);
	  
      $type = "vnd.ms-excel";
	  $date = date('m-d-Y H:i');
	  $title = "Exported from the " . $core->company . " on $date";

      header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
	  header("Content-Type: application/$type");
      header("Content-Disposition: attachment;filename=temp_" . time() . ".xls");
      header("Content-Transfer-Encoding: binary ");
	  
	  print '
	  <table width="100%" cellpadding="1" cellspacing="2" border="1">
	  <caption>' . $title . '</caption>
	    <thead>
		<tr>
		  <td>#</th>
		  <td>' . lang('FROM') . '</td>
		  <td>' . lang('EMAIL') . '</td>
		  <td>' . lang('AMOUNT') . '</td>
		  <td>' . lang('FDASH_METHOD') . '</td>
		  <td>' . lang('CREATED') . '</td>
		</tr>
		</thead>';
		foreach ($result as $v) {
			print '<tr>
			  <td>'.$v->txn_id.'</td>
			  <td>'.$v->user.'</td>
			  <td>'.$v->email.'</td>
			  <td>'.$v->price.'</td>
			  <td>'.$v->pp.'</td>
			  <td>'.$v->created.'</td>
			</tr>';
		}
	  print '</table>';
	  unset($v);
	  exit();
  endif;
?>
<?php
  /* == Proccess Support Ticket == */
  if (isset($_POST['processSupportTicket'])):
      if (intval($_POST['processSupportTicket']) == 0 || empty($_POST['processSupportTicket'])):
          die();
      endif;
      Filter::$id = intval($_POST['id']); 
      $content->processSupportTicket();
  endif;

  /* == Reply Support Ticket == */
  if (isset($_POST['replySupportTicket'])):
      if (intval($_POST['replySupportTicket']) == 0 || empty($_POST['replySupportTicket'])):
          die();
      endif;
      Filter::$id = intval($_POST['replySupportTicket']); 
      $content->replySupportTicket();
  endif;

  /* == Add Support Ticket == */
  if (isset($_POST['addSupportTicket'])):
      if (intval($_POST['addSupportTicket']) == 0 || empty($_POST['addSupportTicket'])):
          die();
      endif;
      $content->addSupportTicket();
  endif;
  
  /* == Load Support Ticket == */
  if (isset($_POST['loadReplyEntries'])):
      if (intval($_POST['loadReplyEntries']) == 0 || empty($_POST['loadReplyEntries'])):
          die();
      endif;
	  
      Filter::$id = intval($_POST['loadReplyEntries']);
      $resrow = $content->getResponseByTicketId();

      if ($resrow):
          print '<ul id="reply-list">';
          foreach ($resrow as $trow):
              $class = ($trow->user_type == "client") ? 'row-client' : 'row-staff';
              print '<li class="' . $class . '">'
			  . '<span class="label2 label-inverse">' . lang('CREATED') . '</span> ' . Filter::dodate($core->long_date, $trow->created) . ' - <span class="label2 label-info">' . lang('AUTHOR') . '</span> ' . $trow->name . ' (' . $trow->user_type . ')'
			  . '<span class="tbicon pull-right">'
			  . '<a href="javascript:void(0);" class="delete tooltip" id="item_' . $trow->id . '" data-title="' . Filter::dodate($core->long_date, $trow->created) . '>"><i class="icon-trash"></i></a>'
			  . '</span>';
              print '<div>' . cleanOut($trow->body) . '</div></li>';
          endforeach;
          print '</ul>';
      endif;
  endif;


  /* == Delete Support Reply == */
  if (isset($_POST['deleteSupportReply'])):
      if (intval($_POST['deleteSupportReply']) == 0 || empty($_POST['deleteSupportReply'])):
          die();
      endif;

      $id = intval($_POST['deleteSupportReply']);
	  $db->delete("support_responses", "id='" . $id . "'");
      $title = sanitize($_POST['title']);

	  print ($db->affected()) ? Filter::msgOk(str_replace("[REPLY]", $title, lang('SUP_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  /* == Delete Support Ticket == */
  if (isset($_POST['deleteSupportTicket'])):
      if (intval($_POST['deleteSupportTicket']) == 0 || empty($_POST['deleteSupportTicket'])):
          die();
      endif;

      $id = intval($_POST['deleteSupportTicket']);
      $db->delete("support_tickets", "id='" . $id . "'");
	  $db->delete("support_responses", "ticket_id='" . $id . "'");
      $title = sanitize($_POST['title']);

	  print ($db->affected()) ? Filter::msgOk(str_replace("[TICKET]", $title, lang('SUP_DELTICKET_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
?>
<?php
  /* == Load Calendar == */
  if (isset($_POST['month'])):
	require_once(BASEPATH . "lib/class_calendar.php");
	Registry::set('Calendar',new Calendar());
	$cal = Registry::get("Calendar");
	
	$cal->renderCalendar();
  endif;
?>
<?php
  /* == Delete SQL Backup == */
  if (isset($_POST['deleteBackup'])):
      $action = @unlink(BASEPATH . 'admin/backups/' . sanitize($_POST['deleteBackup']));
      print ($action) ? Filter::msgOk(lang('DB_DELETE_OK')) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;

  /* == Restore SQL Backup == */
  if (isset($_POST['restoreBackup'])):
      if ($tools->doRestore($_POST['restoreBackup'])):
          print Filter::msgOk(lang('DB_RESTORED'));
      endif;
  endif;
?>
<?php
  /* == Visual Form Options == */
  if (isset($_POST['doVisualForm'])):
      require_once (BASEPATH . "lib/class_forms.php");
      Registry::set('Forms', new Forms());
      $forms = Registry::get("Forms");

      /* == Proccess Visual Form == */
      if (isset($_POST['processVisualForm'])):
          $forms->processForm();
      endif;

      /* == Load Form Fields == */
      if (isset($_POST['loadFormFields'])):
          $fieldrows = Registry::get("Forms")->getAllFields();
          print '<div id="form-fields" style="min-width:450px">';
          if (!$fieldrows):
              print Filter::msgAlert(lang('FORM_NOFIELDS'), false);
          else:
              print '<div class="row">';
              foreach ($fieldrows as $i => $row):
                  if (!($i % 3) && $i > 0):
                      print '</div>';
                      print '<div class="row">';
                  endif;
                  print '<div class="col grid_8">';
                  print '<div class="field-item" data-id="' . $row->id . '">' . $row->title . '</div>';
                  print '</div>';
              endforeach;
              print '</div>';
              unset($row);
          endif;
              print '</div>';
      endif;

      /* == Retrieve Single Field == */
      if (isset($_POST['retrieveFormField'])):
          if ($row = Core::getRowById(Forms::fTable, Filter::$id)):
              print '<label class="input label3 label-inverse" data-field="' . $row->id . '">' . cleanOut($row->title) . '</label>';
          else:
              print "N";
          endif;
      endif;

      /* == Add New Field == */
      if (isset($_POST['addField']) and !empty($_POST['fieldType'])):
          print '<header>' . lang('FORM_EL_REQATTRIB') . '<span>' . lang('FORM_F_NEWCREATE') . ' <i class="icon-double-angle-right"></i> ' . sanitize($_POST['ftitle']) . '</span></header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDTITLE') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" name="vform-title">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDLABEL') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" name="vform-desc">
					</label>
				  </section>
				</div>';
          if ($_POST['fieldType'] != "labelfield" and $_POST['fieldType'] != "parafield" and $_POST['fieldType'] != "hr"):
          print '<header>' . lang('FORM_EL_OPTATTRIB') . '</header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_ERRORMSG') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-exclamation"></i>
					  <input type="text" name="vform-msgerror">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_TOOLTIP') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-info"></i>
					  <input type="text" name="vform-tooltip">
					</label>
				  </section>
				</div>';
          endif;
          Forms::addFormField(sanitize($_POST['fieldType']));
          print '<div class="row"><section class="col col-4"><button class="button button-green doleft" name="dosubmit" type="submit">' . lang('FORM_F_NEWCREATE2') . '</button>';
          print '<span class="sloading"></span> </section></row>';
      endif;

      /* == Process Form Field == */
      if (isset($_POST['processFormField'])):
          Registry::get("Forms")->processFormField();
      endif;

      /* == Update Existing Field == */
      if (isset($_POST['editField']) and !empty(Filter::$id)):
          $row = Core::getRowById(Forms::fTable, Filter::$id);
          print '<header>' . lang('FORM_EL_REQATTRIB') . '<span>' . lang('FORM_F_EDIT_FIELD') . ' <i class="icon-double-angle-right"></i> ' . $row->title . '</span></header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDTITLE') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" value="' . $row->title . '" name="vform-title">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDLABEL') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" value="' . $row->desc . '" name="vform-desc">
					</label>
				  </section>
				</div>';
          if ($row->type != "labelfield" and $row->type != "parafield" and $row->type != "hr"):
          print '<header>' . lang('FORM_EL_OPTATTRIB') . '</header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_ERRORMSG') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-exclamation"></i>
					  <input type="text" value="' . $row->msgerror . '" name="vform-msgerror">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_TOOLTIP') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-info"></i>
					  <input type="text" value="' . $row->tooltip . '" name="vform-tooltip">
					</label>
				  </section>
				</div>';
          endif;
          Forms::updateFormField($row);
          print '<div class="row"><section class="col col-4"><button class="button button-green doleft" name="dosubmit" type="submit">' . lang('FORM_F_UPDATE_FIELD') . '</button>';
          print '<span class="sloading"></span> </section></row>';
          print '<input type="hidden" name="dataType" value="' . $row->type . '">';
      endif;

	  /* == Process Form Data  == */
	  if (isset($_POST['saveFormData'])):
		  Registry::get("Forms")->saveFormData();
	  endif;

	  /* == View Form Data  == */
	  if (isset($_POST['viewFormData'])):
		  $html = getValueById("form_data", Forms::dTable, Filter::$id);
		  print cleanOut($html);
	  endif;

	  /* == Delete Visual Form == */
	  if (isset($_POST['deleteVisualForm'])):
		  $id = intval($_POST['deleteVisualForm']);
		  $db->delete(Forms::mTable, "id='" . $id . "'");
		  $db->delete(Forms::dTable, "form_id='" . $id . "'");
		  $title = sanitize($_POST['title']);
		  print ($db->affected()) ? Filter::msgOk(str_replace("[FORM]", $title, lang('FORM_DELFORM_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
	  endif;

	  /* == Delete Visual Form Data == */
	  if (isset($_POST['deleteFormData'])):
		  $id = intval($_POST['deleteFormData']);
		  $db->delete(Forms::dTable, "id='" . $id . "'");
		  $title = sanitize($_POST['title']);
		  print ($db->affected()) ? Filter::msgOk(str_replace("[FORMDATA]", $title, lang('FORM_DELDATA_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
	  endif;
  endif;
?>
<?php
  /* == Visual Estimator Options == */
  if (isset($_POST['doVisualEstimator'])):
          require_once (BASEPATH . "lib/class_estimator.php");
          Registry::set('Estimator', new Estimator());
          $estimator = Registry::get("Estimator");
		  
      /* == Proccess Estimator == */
      if (isset($_POST['processEstimator'])):
          Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0;
          $estimator->processEstimator();
      endif;

      /* == Load Estimator Fields == */
      if (isset($_POST['loadEstimatorFields'])):
          $fieldrows = Registry::get("Estimator")->getAllFields();
          print '<div id="form-fields" style="min-width:450px">';
          if (!$fieldrows):
              print Filter::msgAlert(lang('FORM_NOFIELDS'), false);
          else:
              print '<div class="row">';
              foreach ($fieldrows as $i => $row):
                  if (!($i % 3) && $i > 0):
                      print '</div>';
                      print '<div class="row">';
                  endif;
                  print '<div class="col grid_8">';
                  print '<div class="field-item" data-id="' . $row->id . '">' . $row->title . '</div>';
                  print '</div>';
              endforeach;
              print '</div>';
              unset($row);
          endif;
              print '</div>';
      endif;
	  
      /* == Retrieve Single Field == */
      if (isset($_POST['retrieveFormField'])):
          if ($row = Core::getRowById(Estimator::fTable, Filter::$id)):
              print '<label class="input label3 label-inverse" data-field="' . $row->id . '">' . cleanOut($row->title) . '</label>';
          else:
              print "N";
          endif;
      endif;

      /* == Add New Field == */
      if (isset($_POST['addField']) and !empty($_POST['fieldType'])):
          print '<header>' . lang('FORM_EL_REQATTRIB') . '<span>' . lang('FORM_F_NEWCREATE') . ' <i class="icon-double-angle-right"></i> ' . sanitize($_POST['ftitle']) . '</span></header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDTITLE') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" name="vform-title">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDLABEL') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" name="vform-desc">
					</label>
				  </section>
				</div>';
          if ($_POST['fieldType'] != "labelfield" and $_POST['fieldType'] != "parafield" and $_POST['fieldType'] != "hr"):
          print '<header>' . lang('FORM_EL_OPTATTRIB') . '</header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_ERRORMSG') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-exclamation"></i>
					  <input type="text" name="vform-msgerror">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_TOOLTIP') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-info"></i>
					  <input type="text" name="vform-tooltip">
					</label>
				  </section>
				</div>';
          endif;
          Estimator::addFormField(sanitize($_POST['fieldType']));
          print '<div class="row"><section class="col col-4"><button class="button button-green doleft" name="dosubmit" type="submit">' . lang('FORM_F_NEWCREATE2') . '</button>';
          print '<span class="sloading"></span> </section></row>';
      endif;

      /* == Process Estimator Field == */
      if (isset($_POST['processEstimatorField'])):
          Registry::get("Estimator")->processEstimatorField();
      endif;
	  
      /* == Update Existing Field == */
      if (isset($_POST['editField']) and !empty(Filter::$id)):
          $row = Core::getRowById(Estimator::fTable, Filter::$id);
          print '<header>' . lang('FORM_EL_REQATTRIB') . '<span>' . lang('FORM_F_EDIT_FIELD') . ' <i class="icon-double-angle-right"></i> ' . $row->title . '</span></header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDTITLE') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" value="' . $row->title . '" name="vform-title">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-important">' . lang('FORM_EL_FLDLABEL') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-asterisk"></i>
					  <input type="text" value="' . $row->desc . '" name="vform-desc">
					</label>
				  </section>
				</div>';
          if ($row->type != "labelfield" and $row->type != "parafield" and $row->type != "hr"):
          print '<header>' . lang('FORM_EL_OPTATTRIB') . '</header>
				<div class="row">
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_ERRORMSG') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-exclamation"></i>
					  <input type="text" value="' . $row->msgerror . '" name="vform-msgerror">
					</label>
				  </section>
				  <section class="col col-2"> <span class="label2 label-success">' . lang('FORM_EL_TOOLTIP') . '</span></section>
				  <section class="col col-4">
					<label class="input"> <i class="icon-append icon-info"></i>
					  <input type="text" value="' . $row->tooltip . '" name="vform-tooltip">
					</label>
				  </section>
				</div>';
          endif;
          Estimator::updateFormField($row);
          print '<div class="row"><section class="col col-4"><button class="button button-green doleft" name="dosubmit" type="submit">' . lang('FORM_F_UPDATE_FIELD') . '</button>';
          print '<span class="sloading"></span> </section></row>';
          print '<input type="hidden" name="dataType" value="' . $row->type . '">';
      endif;

	  /* == Process Estimator Data  == */
	  if (isset($_POST['saveEstimatorData'])):
		  Registry::get("Estimator")->saveEstimatorData();
	  endif;
	  
      /* == Delete Estimator Form == */
      if (isset($_POST['deleteEstimator'])):
          $id = intval($_POST['deleteEstimator']);
          $db->delete(Estimator::mTable, "id='" . $id . "'");
          $title = sanitize($_POST['title']);
          print ($db->affected()) ? Filter::msgOk(str_replace("[FORM]", $title, lang('FORM_DELFORM_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
      endif;
	  
	  /* == View Estimator Data  == */
	  if (isset($_POST['viewFormData'])):
		  $html = getValueById("form_data", Estimator::dTable, Filter::$id);
		  print cleanOut($html);
	  endif;
	  
	  /* == Delete Estimator Form Data == */
	  if (isset($_POST['deleteFormData'])):
		  $id = intval($_POST['deleteFormData']);
		  $db->delete(Estimator::dTable, "id='" . $id . "'");
		  $title = sanitize($_POST['title']);
		  print ($db->affected()) ? Filter::msgOk(str_replace("[FORMDATA]", $title, lang('FORM_DELDATA_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
	  endif;

	  /* == Delete Transaction Record == */
	  if (isset($_POST['deleteTransactionRecord'])):
		  $id = intval($_POST['deleteTransactionRecord']);
		  $db->delete(Estimator::pTable, "id='" . $id . "'");
		  $title = sanitize($_POST['title']);
		  print ($db->affected()) ? Filter::msgOk(str_replace("[TRANSID]", $title, lang('ESTM_DELTRANS_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
	  endif;
  endif;
?>
<?php
  /* == Proccess Message == */
  if (isset($_POST['processMessage']))
      : if (intval($_POST['processMessage']) == 0 || empty($_POST['processMessage']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processMessage();
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
  /* == Reorder Fields == */
  if (isset($_GET['sortfields'])):
	  foreach ($_POST['node'] as $k => $v):
		  $p = $k + 1;
		  $data['sorting'] = intval($p);
		  $db->update("custom_fields", $data, "id='" . (int)$v . "'");
	  endforeach;
	  Filter::msgOk(lang('CUSF_SORT_OK'));
  endif;
  
  /* == Delete Field == */
  if (isset($_POST['deleteField']))
      : if (intval($_POST['deleteField']) == 0 || empty($_POST['deleteField']))
      : die();
  endif;

  $id = intval($_POST['deleteField']);
  $db->delete("custom_fields", "id='" . $id . "'");
  $title = sanitize($_POST['title']);
  
  print ($db->affected) ? Filter::msgOk(str_replace("[NAME]", $title, lang('CUSF_DELETE_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));
  endif;
  
  /* == Proccess Field == */
  if (isset($_POST['processField']))
      : if (intval($_POST['processField']) == 0 || empty($_POST['processField']))
      : die();
  endif;
  Filter::$id = (isset($_POST['id'])) ? $_POST['id'] : 0; 
  $content->processField();
  endif;
?>
<?php
  /* == Latest Sales Stats == */
  if (isset($_GET['getSaleStats'])):
      if (intval($_GET['getSaleStats']) == 0 || empty($_GET['getSaleStats'])):
          die();
      endif;
	
  $range = (isset($_GET['timerange'])) ? sanitize($_GET['timerange']) : 'month';	  
  $data = array();
  $data['order'] = array();
  $data['xaxis'] = array();
  $data['order']['label'] = 'Traffic Statistics';
  
  switch ($range) {
	  case 'day':
	  $date = date('Y-m-d');
		  for ($i = 0; $i < 24; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total FROM tracker" 
			  . "\n WHERE DATE(created) = '" . $db->escape($date) . "'" 
			  . "\n AND HOUR(time) = '" . (int)$i . "'" 
			  . "\n GROUP BY HOUR(time) ORDER BY created ASC");
  
			  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('H', mktime($i, 0, 0, date('n'), date('j'), date('Y'))));
		  }
		  break;
	  case 'week':
		  $date_start = strtotime('-' . date('w') . ' days');
  
		  for ($i = 0; $i < 7; $i++) {
			  $date = date('Y-m-d', $date_start + ($i * 86400));
			  $query = $db->first("SELECT COUNT(*) AS total FROM tracker"
			  . "\n WHERE DATE(created) = '" . $db->escape($date) . "'"
			  . "\n GROUP BY DATE(created)");
  
			  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('D', strtotime($date)));
		  }
  
		  break;
	  default:
	  case 'month':
		  for ($i = 1; $i <= date('t'); $i++) {
			  $date = date('Y') . '-' . date('m') . '-' . $i;
			  $query = $db->first("SELECT COUNT(*) AS total FROM tracker"
			  . "\n WHERE (DATE(created) = '" . $db->escape($date) . "')"
			  . "\n GROUP BY DAY(created)");
  
			  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('j', strtotime($date)));
		  }
		  break;
	  case 'year':
		  for ($i = 1; $i <= 12; $i++) {
			  $query = $db->first("SELECT COUNT(*) AS total FROM tracker"
			  . "\n WHERE YEAR(created) = '" . date('Y') . "'"
			  . "\n AND MONTH(created) = '" . $i . "'"
			  . "\n GROUP BY MONTH(created)");
  
			  ($query) ? $data['order']['data'][] = array($i, (int)$query->total) : $data['order']['data'][] = array($i, 0);
			  $data['xaxis'][] = array($i, date('M', mktime(0, 0, 0, $i, 1, date('Y'))));
		  }
		  break;
  }

   print json_encode($data);
  endif;
  
?>
<?php
  /* == Make Pdf == */
  if (isset($_GET['dopdf'])):
      if (intval($_GET['dopdf']) == 0 || empty($_GET['dopdf'])):
          die();
      endif;
	  
	  Filter::$id = intval($_GET['dopdf']);
	  $title = cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $_GET['title']));
	  ob_start();
	  require_once(BASEPATH . 'admin/print_pdf.php');
	  $pdf_html = ob_get_contents();
	  ob_end_clean();

	  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
	  $dompdf = new DOMPDF();
	  $dompdf->load_html($pdf_html);
	  $dompdf->render();
	  $dompdf->stream($title . ".pdf");
  endif;
  
  /* == Make Quote Pdf == */
  if (isset($_GET['doquotepdf'])):
      if (intval($_GET['doquotepdf']) == 0 || empty($_GET['doquotepdf'])):
          die();
      endif;
	  
	  Filter::$id = intval($_GET['doquotepdf']);
	  $title = cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $_GET['title']));
	  ob_start();
	  require_once(BASEPATH . 'admin/print_quote_pdf.php');
	  $pdf_html = ob_get_contents();
	  ob_end_clean();

	  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
	  $dompdf = new DOMPDF();
	  $dompdf->load_html($pdf_html);
	  $dompdf->render();
	  $dompdf->stream($title . ".pdf");
  endif;
?>