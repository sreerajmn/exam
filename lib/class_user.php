<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  class Users
  {
      const uTable = "users";
	  const spTable = "staff_payment";
      public $logged_in = null;
      public $uid = 0;
      public $userid = 0;
      public $username;
      public $sesid;
      public $email;
      public $name;
	  public $ucompany;
	  public $avatar;
	  public $currency;
      public $userlevel;
      private $lastlogin = "NOW()";
      private static $db;

      /**
       * Users::__construct()
       * 
       * @return
       */
      function __construct()
      {
          self::$db = Registry::get("Database");

          $this->getUserId();
          $this->startSession();
      }

      /**
       * Users::getUserId()
       * 
       * @return
       */
      private function getUserId()
      {
          if (isset($_GET['userid'])) {
              $userid = (is_numeric($_GET['userid']) && $_GET['userid'] > -1) ? intval($_GET['userid']) : false;
              $userid = sanitize($userid);

              if ($userid == false) {
                  Filter::error("You have selected an Invalid Userid", "Users::getUserId()");
              } else
                  return $this->userid = $userid;
          }
      }


      /**
       * Users::startSession()
       * 
       * @return
       */
      private function startSession()
      {
		  if (strlen(session_id()) < 1)
			  session_start();
			  
          $this->logged_in = $this->loginCheck();

          if (!$this->logged_in) {
              $this->username = $_SESSION['username'] = "Guest";
              $this->sesid = sha1(session_id());
              $this->userlevel = 0;
          }
      }

      /**
       * Users::loginCheck()
       * 
       * @return
       */
      private function loginCheck()
      {
          if (isset($_SESSION['username']) && $_SESSION['username'] != "Guest") {

              $row = $this->getUserInfo($_SESSION['username']);
              $this->uid = $row->id;
              $this->username = $row->username;
              $this->email = $row->email;
              $this->name = $row->fname . ' ' . $row->lname;
			  $this->ucompany = $row->company;
              $this->userlevel = $row->userlevel;
			  $this->avatar = $row->avatar;
              $this->sesid = sha1(session_id());
			  $this->currency = $row->currency;
              return true;
          } else {
              return false;
          }
      }

      /**
       * Users::is_Admin()
       * 
       * @return
       */
      public function is_Admin()
      {
          return ($this->userlevel == 9 or $this->userlevel == 5);

      }

      /**
       * Users::login()
       * 
       * @param mixed $username
       * @param mixed $password
       * @return
       */
      public function login($username, $password)
      {
          if ($username == "" && $password == "") {
              Filter::$msgs['username'] = lang('LOGIN_R5');
          } else {
              $status = $this->checkStatus($username, $password);

              switch ($status) {
                  case 0:
                      Filter::$msgs['username'] = lang('LOGIN_R1');
                      break;

                  case 1:
                      Filter::$msgs['username'] = lang('LOGIN_R2');
                      break;

                  case 2:
                      Filter::$msgs['username'] = lang('LOGIN_R3');
                      break;

                  case 3:
                      Filter::$msgs['username'] = lang('LOGIN_R4');
                      break;
              }
          }
          if (empty(Filter::$msgs) && $status == 5) {
              $row = $this->getUserInfo($username);
              $this->uid = $_SESSION['userid'] = $row->id;
              $this->username = $_SESSION['username'] = $row->username;
              $this->email = $_SESSION['email'] = $row->email;
              $this->userlevel = $_SESSION['userlevel'] = $row->userlevel;
			  $this->currency = $_SESSION['currency'] = $row->currency;
			  $this->avatar = $_SESSION['avatar'] = $row->avatar;

              $data = array('lastlogin' => $this->lastlogin, 'lastip' => sanitize($_SERVER['REMOTE_ADDR']));
              self::$db->update(self::uTable, $data, "username='" . $this->username . "'");

              return true;
          } else
              Filter::msgStatus();
      }

      /**
       * Users::logout()
       * 
       * @return
       */
      public function logout()
      {
          unset($_SESSION['username']);
          unset($_SESSION['email']);
          unset($_SESSION['name']);
          unset($_SESSION['userid']);
          unset($_SESSION['uid']);
          session_destroy();
          session_regenerate_id();

          $this->logged_in = false;
          $this->username = "Guest";
          $this->userlevel = 0;
      }

      /**
       * Users::getUserInfo()
       * 
       * @param mixed $username
       * @return
       */
      public function getUserInfo($username)
      {
          $username = sanitize($username);
          $username = self::$db->escape($username);

          $sql = "SELECT * FROM " . self::uTable . " WHERE username = '" . $username . "'";
          $row = self::$db->first($sql);
          if (!$username)
              return false;

          return ($row) ? $row : 0;
      }
		
	  public function getEnrolment($uid)
      {
		$sql = "SELECT enrollment.id, enrollment.course, project_types.title as ctitle, project_types.fees as cfees, enrollment.date as rdate FROM enrollment 
		INNER JOIN project_types 
		ON enrollment.course=project_types.id WHERE enrollment.user=$uid";
		$row = self::$db->fetch_all($sql);
        return ($row) ? $row : 0;
      }
	  
	  public function getResults($uid)
      {
		$sql = "SELECT results.id, results.exam, exams.title as etitle, results.fullmarks, results.duration, results.marks, results.score, results.remarks, results.date as rdate FROM results 
		INNER JOIN exams 
		ON results.exam=exams.id WHERE results.user=$uid";
		$row = self::$db->fetch_all($sql);
        return ($row) ? $row : 0;
      }
		
		
      /**
       * Users::getUserList()
       * 
       * @param mixed $userlevel
	   * @param bool $is_staff
       * @return
       */
      public function getUserList($userlevel, $is_staff = false)
      {
		  $and = (Registry::get("Users")->userlevel == 5 and $is_staff) ? "AND id = '" . Registry::get("Users")->uid . "'" : null;
		  
          $sql = "SELECT id, CONCAT(fname,' ',lname) as name, email  FROM " . self::uTable . " WHERE userlevel = '" . $userlevel . "' $and";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getUserListForStaff()
       * 
       * @return
       */
      public function getUserListForStaff()
      {
		  $uid = Registry::get("Users")->uid;
		  
		  $sql = "SELECT p.client_id, CONCAT(u.fname,' ',u.lname) as name, u.id as id" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN " . self::uTable . " as u ON u.id = p.client_id"
		  . "\n WHERE FIND_IN_SET($uid, p.staff_id) GROUP BY p.client_id";
		  $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
      /**
       * Users::checkStatus()
       * 
       * @param mixed $username
       * @param mixed $password
       * @return
       */
      public function checkStatus($username, $password)
      {

          $username = sanitize($username);
          $username = self::$db->escape($username);
          $password = sanitize($password);

          $sql = "SELECT password, active FROM " . self::uTable . " WHERE username = '" . $username . "'";
          $result = self::$db->query($sql);

          if (self::$db->numrows($result) == 0)
              return 0;

          $row = self::$db->fetch($result);
          $entered_pass = sha1($password);

          switch ($row->active) {
              case "b":
                  return 1;
                  break;

              case "n":
                  return 2;
                  break;

              case "t":
                  return 3;
                  break;

              case "y" && $entered_pass == $row->password:
                  return 5;
                  break;
          }
      }

      /**
       * Users::getClients()
       * 
       * @param bool $from
       * @return
       */
      public function getClients($from = false)
      {
          $pager = Paginator::instance();
          $pager->items_total = countEntries(self::uTable, 'userlevel', 1);
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          if (isset($_GET['sort'])) {
              $data = explode("-", $_GET['sort']);
              if (count($data) > 1) {
                  $sort = sanitize($data[0]);
                  $order = sanitize($data[1]);
                  if (in_array($sort, array("company", "fname", "lname", "email"))) {
                      $ord = ($order == 'DESC') ? " DESC" : " ASC";
                      $sorting = " u." . $sort . $ord;
                  } else
                      $sorting = " u.created DESC";
              } else
                  $sorting = " u.created DESC";
          } else
              $sorting = " u.created DESC";

          $clause = (isset($clause)) ? $clause : null;

          if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
              if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
                  $enddate = $_POST['enddate'];
              }
              $clause .= " AND u.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
          }

          $where = (isset($where)) ? $where : null;
          $sql = "SELECT u.*, u.id as id, CONCAT(u.fname,' ',u.lname) as fullname," 
		  . "\n DATE_FORMAT(u.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(u.lastlogin, '" . Registry::get("Core")->short_date . "') as adate,"  
		  . "\n (SELECT SUM(amount_total - amount_paid) FROM invoices WHERE status <> 'Paid' AND client_id = u.id) as balance" 
		  . "\n FROM " . self::uTable . " as u" 
		  . "\n WHERE userlevel = 1" 
		  . "\n " . $clause 
		  . "\n ORDER BY " . $sorting . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getAllUsers()
       * 
       * @return
       */
      public function getAllUsers()
      {
          $sql = "SELECT id, username, CONCAT(fname,' ',lname) as name  FROM " . self::uTable . " WHERE userlevel <> 9 ORDER BY username";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getUsers()
       * 
       * @return
       */
      public function getUsers()
      {
          if (Registry::get("Users")->userlevel == 5) {
              $access = "WHERE id='" . Registry::get("Users")->uid . "'";
          } else {
              $access = "WHERE userlevel <> 1";
          }
		  
          $sql = "SELECT * FROM " . self::uTable . " $access ORDER BY created";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Users::processUser()
       * 
       * @return
       */
      public function processUser()
      {
          if (!Filter::$id) {
              if (empty($_POST['username']))
                  Filter::$msgs['username'] = lang('USERNAME_R1');

              if ($value = $this->usernameExists($_POST['username'])) {
                  if ($value == 1)
                      Filter::$msgs['username'] = lang('USERNAME_R2');
                  if ($value == 2)
                      Filter::$msgs['username'] = lang('USERNAME_R3');
                  if ($value == 3)
                      Filter::$msgs['username'] = lang('USERNAME_R4');
              }
          }

          if (empty($_POST['fname']))
              Filter::$msgs['fname'] = lang('FNAME_R');

          if (empty($_POST['lname']))
              Filter::$msgs['lname'] = lang('LNAME_R');

          if (!Filter::$id) {
              if (empty($_POST['password']))
                  Filter::$msgs['password'] = lang('PASSWORD_R1');
          }

          if (empty($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R1');
          if (!Filter::$id) {
              if ($this->emailExists($_POST['email']))
                  Filter::$msgs['email'] = lang('EMAIL_R2');
          }
          if (!$this->isValidEmail($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R3');

		  if (!empty($_FILES['avatar']['name'])) {
			  if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['avatar']['name'])) {
				  Filter::$msgs['avatar'] = lang('CONF_LOGO_R');
			  }
			  $file_info = getimagesize($_FILES['avatar']['tmp_name']);
			  if(empty($file_info))
				  Filter::$msgs['avatar'] = lang('CONF_LOGO_R');
		  }
		  
          if (empty(Filter::$msgs)) {

              $data = array(
					'username' => sanitize($_POST['username']), 
					'email' => sanitize($_POST['email']), 
					'pp_email' => isset($_POST['pp_email']) ? sanitize($_POST['pp_email']) : "NULL", 
					'lname' => sanitize($_POST['lname']), 
					'fname' => sanitize($_POST['fname']), 
					'company' => isset($_POST['company']) ? sanitize($_POST['company']) : "NULL", 
					'address' => sanitize($_POST['address']),
					'city' => sanitize($_POST['city']), 
					'state' => sanitize($_POST['state']), 
					'country' => intval($_POST['country']),
					'zip' => sanitize($_POST['zip']), 
					'phone' => sanitize($_POST['phone']), 
					'currency' => isset($_POST['currency']) ? sanitize($_POST['currency']) : "NULL",
					'vat' => isset($_POST['vat']) ? sanitize($_POST['vat']) : 'NULL',
					'notes' => sanitize($_POST['notes']), 
					'userlevel' => intval($_POST['userlevel']), 
					'active' => 'y'
			  );

              if (!Filter::$id)
                  $data['created'] = "NOW()";

              if (Filter::$id)
                  $userrow = Registry::get("Core")->getRowById(self::uTable, Filter::$id);

              if ($_POST['password'] != "") {
                  $data['password'] = sha1($_POST['password']);
              } else
                  $data['password'] = $userrow->password;

			  if (isset($_POST['custom'])) {
				  $fields = $_POST['custom'];
				  $total = count($fields);
				  if (is_array($fields)) {
					  $fielddata = '';
					  foreach ($fields as $fid) {
						  $fielddata .= $fid . "::";
					  }
				  }
				  $data['custom_fields'] = $fielddata;
			  } 

              // Procces Avatar
			  if (!empty($_FILES['avatar']['name'])) {
				  $thumbdir = UPLOADS . "avatars/";
				  $tName = "AVT_" . randName();
				  $text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
				  $thumbName = $thumbdir . $tName . "." . strtolower($text);
				  if (Filter::$id && $thumb = getValueById("avatar", self::uTable, Filter::$id)) {
					  @unlink($thumbdir . $thumb);
				  }
				  move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
	
				  $data['avatar'] = $tName . "." . strtolower($text);
			  }
			  
              (Filter::$id) ? self::$db->update(self::uTable, $data, "id='" . Filter::$id . "'") : self::$db->insert(self::uTable, $data);
              $message = (Filter::$id) ? lang('STAFF_UPDATED') : lang('STAFF_ADDED');

              if (self::$db->affected()) {
                  Filter::msgOk($message);
                  if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
                      require_once (BASEPATH . "lib/class_mailer.php");
					  $pass = sanitize($_POST['password']);
                      $mailer = $mail->sendMail();
                      $subject = lang('STAFF_ACTIVATION') . $data['fname'] . ' ' . $data['lname'];

                      ob_start();
                      ($data['userlevel'] == 5) ? require_once (BASEPATH . 'mailer/Staff_Welcome_Message.tpl.php') : require_once (BASEPATH . 'mailer/Member_Welcome_Message.tpl.php');
                      $html_message = ob_get_contents();
                      ob_end_clean();

                      $msg = Swift_Message::newInstance()
							  ->setSubject($subject)
							  ->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
							  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
							  ->setBody($html_message, 'text/html');

                      $numSent = $mailer->send($msg);
                  }
              } else
                  Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Users::updateProfile()
       * 
       * @return
       */
      public function updateProfile()
      {
          if (empty($_POST['fname']))
              Filter::$msgs['fname'] = lang('FNAME_R');

          if (empty($_POST['lname']))
              Filter::$msgs['lname'] = lang('LNAME_R');

          if (empty($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R1');

          if (!$this->isValidEmail($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R3');

		  if (!empty($_FILES['avatar']['name'])) {
			  if (!preg_match("/(\.jpg|\.png)$/i", $_FILES['avatar']['name'])) {
				  Filter::$msgs['avatar'] = lang('CONF_LOGO_R');
			  }
			  $file_info = getimagesize($_FILES['avatar']['tmp_name']);
			  if(empty($file_info))
				  Filter::$msgs['avatar'] = lang('CONF_LOGO_R');
		  }
		  
          if (empty(Filter::$msgs)) {
              $data = array(
					'email' => sanitize($_POST['email']), 
					'lname' => sanitize($_POST['lname']), 
					'fname' => sanitize($_POST['fname']), 
					'company' => sanitize($_POST['company']), 
					'address' => sanitize($_POST['address']), 
					'city' => sanitize($_POST['city']), 
					'state' => sanitize($_POST['state']), 
					'country' => intval($_POST['country']),
					'zip' => sanitize($_POST['zip']), 
					'vat' => sanitize($_POST['vat']), 
					'phone' => sanitize($_POST['phone'])
			  );

              // Procces Avatar
			  if (!empty($_FILES['avatar']['name'])) {
				  $thumbdir = UPLOADS . "avatars/";
				  $tName = "AVT_" . randName();
				  $text = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
				  $thumbName = $thumbdir . $tName . "." . strtolower($text);
				  if (Filter::$id && $thumb = getValueById("avatar", self::uTable, Filter::$id)) {
					  @unlink($thumbdir . $thumb);
				  }
				  move_uploaded_file($_FILES['avatar']['tmp_name'], $thumbName);
				  $data['avatar'] = $tName . "." . strtolower($text);
			  }
			  
              $userpass = getValue("password", self::uTable, "id = '" . $this->uid . "'");

              if ($_POST['password'] != "") {
                  $data['password'] = sha1($_POST['password']);
              } else
                  $data['password'] = $userpass;

              self::$db->update(self::uTable, $data, "id='" . $this->uid . "'");
              (self::$db->affected()) ? Filter::msgOk(lang('PRO_MSGOK')) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Users::register()
       * 
       * @return
       */
      public function register()
      {
          if (empty($_POST['username']))
              Filter::$msgs['username'] = lang('USERNAME_R1');

          if ($value = $this->usernameExists($_POST['username'])) {
              if ($value == 1)
                  Filter::$msgs['username'] = lang('USERNAME_R2');
              if ($value == 2)
                  Filter::$msgs['username'] = lang('USERNAME_R3');
              if ($value == 3)
                  Filter::$msgs['username'] = lang('USERNAME_R4');
          }

          if (empty($_POST['fname']))
              Filter::$msgs['fname'] = lang('FNAME_R');

          if (empty($_POST['lname']))
              Filter::$msgs['lname'] = lang('LNAME_R');

          if (empty($_POST['pass']))
              $this->msgs['pass'] = lang('PASSWORD_R1');

          if (strlen($_POST['pass']) < 6)
              Filter::$msgs['pass'] = lang('PASSWORD_T2');
          elseif (!preg_match("/^([0-9a-z])+$/i", ($_POST['pass'] = trim($_POST['pass']))))
              Filter::$msgs['pass'] = lang('PASSWORD_R2');
          elseif ($_POST['pass'] != $_POST['pass2'])
              Filter::$msgs['pass'] = lang('PASSWORD_R3');

          if (empty($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R1');

          if ($this->emailExists($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R2');

          if (!$this->isValidEmail($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R3');

          if (empty(Filter::$msgs)) {

              $pass = sanitize($_POST['pass']);
              $data = array(
					'username' => sanitize($_POST['username']), 
					'password' => sha1($_POST['pass']), 
					'email' => sanitize($_POST['email']), 
					'fname' => sanitize($_POST['fname']), 
					'lname' => sanitize($_POST['lname']), 
					'company' => sanitize($_POST['company']), 
					'address' => sanitize($_POST['address']),
					'city' => sanitize($_POST['city']), 
					'state' => sanitize($_POST['state']), 
					'country' => intval($_POST['country']),
					'zip' => sanitize($_POST['zip']), 
					'active' => 'y', 
					'created' => "NOW()"
			  );

              self::$db->insert(self::uTable, $data);
			  
			  if(self::$db->affected()) {
				  $msg = '<div class="green"><p><span class="icon-ok-sign"></span><i class="close icon-double-angle-down"></i>' . lang('REG_MSGOK') . '</p></div>';
			  } else {
				  $msg = '<div class="red"><p><span class="icon-ok-sign"></span><i class="close icon-minus-sign></i>' . lang('REG_ERR') . '</p></div>';
			  }
			  
			  $json['type'] = 'success';
			  $json['info'] = $msg;
			  print json_encode($json);
			  

              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = $mail->sendMail();
              $subject = lang('REG_ESUBJECT') . Registry::get("Core")->company;

              ob_start();
              require_once (BASEPATH . 'mailer/Member_Welcome_Message.tpl.php');
              $html_message = ob_get_contents();
              ob_end_clean();

              $msg = Swift_Message::newInstance()
					->setSubject($subject)
					->setTo(array($data['email'] => $data['fname'] . ' ' . $data['lname']))
					->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					->setBody($html_message, 'text/html');

              $mailer->send($msg);

		  } else {
			  $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
      }
	  
	  
	  public function addInvoice()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('INVC_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');

          if (empty($_POST['client_id']))
              Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

          if (empty($_POST['duedate']))
              Filter::$msgs['duedate'] = lang('INVC_DUEDATE_R');
          
		  $dtitle = array_filter($_POST['dtitle'], 'strlen');
          if (empty($dtitle))
              Filter::$msgs['dtitle'] = lang('INVC_ENTRYTITLE_R');
			  
          $amount = array_filter($_POST['amount'], 'is_numeric');
          if (!$amount or array_sum($_POST['amount']) == 0)
              Filter::$msgs['amount'] = lang('INVC_ENTRYAMOUNT_R');

          if (empty(Filter::$msgs)) {
			  
              $amount_total = array_sum($_POST['amount']);
              if (intval($_POST['tax']) == 1 and Registry::get("Core")->enable_tax) {
                  $tax = (floatval($amount_total) * Registry::get("Core")->tax_rate);
                  $amount_total = ($amount_total + $tax);
              } else {
                  $tax = 0;
              }
              $data = array(
					'title' => sanitize($_POST['title']), 
					'project_id' => intval($_POST['project_id']), 
					'client_id' => intval($_POST['client_id']), 
					'created' => (empty($_POST['created'])) ? "NOW()" : sanitize($_POST['created']), 
					'duedate' => sanitize($_POST['duedate']), 
					'amount_total' => $amount_total,
					'amount_paid' => 0, 
					'recurring' => intval($_POST['recurring']), 
					'method' => sanitize($_POST['method']), 
					'notes' => $_POST['notes'],
					'comment' => sanitize($_POST['comment']),
					'tax' => $tax, 
					'onhold' => intval($_POST['onhold']),
					'status' => 'Unpaid'
			  );

              $lastid = self::$db->insert("invoices", $data);
			  
			  foreach ($_POST['amount'] as $key => $val) {
				  $edata = array(
						'title' => sanitize($_POST['dtitle'][$key]), 
						'invoice_id' => $lastid, 
						'description' => sanitize($_POST['description'][$key]), 
						'amount' => floatval($_POST['amount'][$key]), 
						'recurring' => intval($_POST['recurring']),
						'days' => intval($_POST['days']),
						'period' => sanitize($_POST['period']),
						'tax' => (intval($_POST['tax']) == 1 and Registry::get("Core")->enable_tax) ? (floatval($_POST['amount'][$key]) * Registry::get("Core")->tax_rate) : 0
				  );
				  self::$db->insert("invoice_data", $edata);
			  }
			  
			  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM invoice_data WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");
			  $idata = array('amount_total' => $row->amtotal + $row->itax, 'tax' => $row->itax);
			  $pdata['cost'] = $idata['amount_total'];
			  $pdata['b_status'] = -1.00;
			  
			  if(self::$db->affected()) {
				  $msg = '<div class="green"><p><span class="icon-ok-sign"></span><i class="close icon-double-angle-down"></i>' . lang('REG_MSGOK') . '</p></div>';
			  } else {
				  $msg = '<div class="red"><p><span class="icon-ok-sign"></span><i class="close icon-minus-sign></i>' . lang('REG_ERR') . '</p></div>';
			  }
			  
			  $json['type'] = 'success';
			  $json['info'] = $lastid;
			  print json_encode($json);
			  

          } else
              print Filter::msgStatus();
      }
	  
	  
	  public function addEnrol()
      {
          if (empty($_POST['course']))
              Filter::$msgs['course'] = 'Course is required.';

          if (empty($_POST['user']))
              Filter::$msgs['user'] = 'User is required.';

          if (empty($_POST['date']))
              Filter::$msgs['date'] = 'Date is required.';
          
          if (empty(Filter::$msgs)) {
			
              $data = array(
					'course' => intval($_POST['course']), 
					'user' => intval($_POST['user']), 
					'date' => (empty($_POST['date'])) ? "NOW()" : sanitize($_POST['date']), 
					'banned' => 0
			  );

              $lastid = self::$db->insert("enrollment", $data);
			 
			  if(self::$db->affected()) {
				  $msg = '<div class="green"><p><span class="icon-ok-sign"></span><i class="close icon-double-angle-down"></i>You have successfully enrolled. <a href="exams.php?sort=' . $data['course'] . '" title="View Exams">Click here</a> to view exams of this course </p></div>';
			  } else {
				  $msg = '<div class="red"><p><span class="icon-ok-sign"></span><i class="close icon-minus-sign></i>Sorry, something went wrong.</p></div>';
			  }
			  
			  $json['type'] = 'success';
			  $json['info'] = $msg;
			  print json_encode($json);
			  

          } else
              print Filter::msgStatus();
      }
	  
	  public function doQuize()
      {
		  $data = array(
				'uid' => intval($_POST['uid']), 
				'token' => $_SESSION['token'], 
				'qid' => intval($_POST['qid']), 
				'exam' => intval($_SESSION['eid']),
				'description' => $_POST['description'],
				'marks' => $_POST['marks']
		  );

		  $lastid = self::$db->insert("tquestions", $data);
		  
		  $answer = $_POST['answer'];
		  $correct = $_POST['correct'];
		  $marked = $_POST['marked'];	
		  
		  if (sizeof($marked) > 0){
			  foreach($marked as $a => $b){
				$data = array(
					'tquestion' => intval($lastid), 
					'uid' => intval($_POST['uid']),
					'answer' => $answer[$a],
					'correct' => $correct[$a],
					'marked' => $marked[$a]
				);
				self::$db->insert("tanswers", $data);
			  }
		  }
		  
		  $msg = '<div class="green"><p><span class="icon-ok-sign"></span><i class="close icon-minus-sign></i>Sorry, something went wrong.</p></div>';

		  $json['type'] = 'success';
		  $json['info'] = $msg;
		  print json_encode($json);
      }
	  
	  public function checkEnrol($uid,$cid)
      {
		  $sql = "SELECT *  FROM enrollment WHERE user = $uid AND course = $cid";
          $row = self::$db->fetch_all($sql);
          return ($row) ? $row : 0;
      }
	  
	  public function checkTaken($uid,$eid)
      {
		  $sql = "SELECT *  FROM results WHERE user = $uid AND exam = $eid";
          $row = self::$db->fetch_all($sql);
          return ($row) ? $row : 0;
      }
	  
	  public function getResult($uid,$eid)
      {
		  $sql = "SELECT *  FROM results WHERE user = $uid AND exam = $eid";
		  $row = self::$db->first($sql);
          return ($row) ? $row : 0;
      }
	  
	  public function totalQues($eid)
      {
		$sql = "SELECT *  FROM questions WHERE exam = $eid AND banned = 0";
        $result = self::$db->query($sql);
		$count = self::$db->numrows($result);
        return $count;
      }
	  
	  public function deleteTemp($uid)
      {
		self::$db->delete('tquestions','user='.$uid);
		self::$db->delete('tanswers','user='.$uid);
      }
	  
	  public function sumMarks($eid)
      {
		$row = self::$db->first("SELECT SUM(marks) as total FROM questions WHERE exam=$eid AND banned=0");
		$total = floatval($row->total);
		return $total;
      }
	  
	  public function token(){
		$alpha = "abcdefghijklmnopqrstuvwxyz";
		$alpha_upper = strtoupper($alpha);
		$numeric = "0123456789";
		$special = ".-+=_,!@$#*%<>[]{}";
		//$chars = $alpha . $alpha_upper . $numeric . $special;
		$chars = mktime();
		$length = 16;
		$chars = str_shuffle($chars);
		$len = strlen($chars);
		$pw = '';
		for ($i=0;$i<$length;$i++)
				$pw .= substr($chars, rand(0, $len-1), 1);
		 
		$pw = str_shuffle($pw);

		return $pw;
	  }
	  
	  public function pfile()
	  {
		$file = $_SERVER["SCRIPT_NAME"];
		$break = Explode('/', $file);
		$pfile = $break[count($break) - 1]; 
		return $pfile;
	  }
	  
	  public function startExam($eid,$duration)
      {
        $_SESSION['eid'] = $eid;
        $_SESSION['duration'] = $duration;
		$_SESSION['qn'] = 0;
		$_SESSION['token'] = $this->token();
		$_SESSION['reid'] = NULL;
		
		$today = date("H:i:s");
		$newdate = strtotime ( $duration , strtotime ( $today ) ) ;
		$durattion = $duration . ' minutes';
		$_SESSION['quizend'] = date ( 'H:i:s' , strtotime ($durattion , strtotime (date("H:i:s"))) );
		$_SESSION['fullmarks'] = $this->sumMarks($eid);
		$_SESSION['total'] = $this->totalQues($eid);
      }
	  
	  public function loadQuestion($eid,$qn)
      {
        $row = self::$db->first("SELECT * FROM questions WHERE exam=$eid AND banned=0 LIMIT $qn,1");
		return $row;
      }
	  
	  public function loadTQuestion($eid,$token,$qn)
      {
        $row = self::$db->first("SELECT * FROM tquestions WHERE exam=$eid AND token=$token LIMIT $qn,1");
		return $row;
      }
	  
	  public function loadAnswer($qid)
      {
		$sql = "SELECT * FROM answers WHERE question=$qid AND banned=0";
        $row = self::$db->fetch_all($sql);
		return $row;
      }

	  public function yourAnswer($qid)
      {
		$sql = "SELECT * FROM tanswers WHERE tquestion=$qid";
        $row = self::$db->fetch_all($sql);
		return $row;
      }

	  public function tQuestions($token, $eid)
      {
		$sql = "SELECT * FROM tquestions WHERE token=$token AND exam=$eid";
        $row = self::$db->fetch_all($sql);
		return $row;
      }

	  public function tAnswers($tqid, $totalans, $marks)
      {
		$sql = "SELECT * FROM tanswers WHERE tquestion=$tqid";
        $row = self::$db->fetch_all($sql);		
		$score = 0;
		foreach ($row as $ansrow):
			if($ansrow->correct == $ansrow->marked){
				$score = $score + ($marks / $totalans);
			}
		endforeach;
		unset($ansrow);
		return $score;
      }
	  
	  public function totalAnswers($qid)
      {
		$sql = "SELECT *  FROM answers WHERE question = $qid AND correct = 1 AND banned = 0";
        $result = self::$db->query($sql);
		$count = self::$db->numrows($result);
        return $count;
      }
	  
	  public function processResult($uid,$eid,$token,$fullmarks,$duration,$totalscore,$pscore,$remarks)
      {
		$sql = "SELECT *  FROM results WHERE user=$uid AND exam=$eid";
        $result = self::$db->query($sql);
		$count = self::$db->numrows($result);

		$data = array(
			'user' => $uid, 
			'exam' => $eid,
			'token' => $token,
			'fullmarks' => $fullmarks,
			'duration' => $duration,
			'marks' => $totalscore,
			'score' => $pscore,
			'remarks' => $remarks,
			'date' => 'NOW()',
			'banned' => 0
		);
		
		if($count == 0){
			self::$db->insert("results", $data);
		}else{
			self::$db->update("results", $data, "user='" . $uid . "' AND exam='" . $eid . "'");
		}	
		
		$_SESSION['rtoken'] = $_SESSION['token'];
		$_SESSION['reid'] = $_SESSION['eid'];
		$_SESSION['rqn'] = 0;
		$_SESSION['rtotal'] = $this->totalQues($eid);
		
		$_SESSION['token'] = NULL;
		$_SESSION['eid'] = NULL;
		$_SESSION['qn'] = NULL;
		$_SESSION['duration'] = NULL;
		$_SESSION['total'] = NULL;
		$_SESSION['fullmarks'] = NULL;
      }
	  

      /**
       * Users::passReset()
       * 
       * @return
       */
      public function passReset()
      {
          if (empty($_POST['uname']))
              Filter::$msgs['uname'] = lang('USERNAME_R1');

          $uname = $this->usernameExists($_POST['uname']);
          if (strlen($_POST['uname']) < 4 || strlen($_POST['uname']) > 30 || !preg_match("/^([0-9a-z])+$/i", $_POST['uname']) || $uname != 3)
              Filter::$msgs['uname'] = lang('USERNAME_R5');

          if (empty($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R1');

          if (!$this->emailExists($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R4');

          if (empty($_POST['captcha']))
              Filter::$msgs['captcha'] = lang('FORM_ERROR6');
			  
		  if ($_SESSION['captchacode'] != $_POST['captcha'])
			  Filter::$msgs['captcha'] = lang('FORM_ERROR7');

          if (empty(Filter::$msgs)) {

              $userdata = $this->getUserInfo($_POST['uname']);
              $randpass = $this->getUniqueCode(12);
              $newpass = sha1($randpass);

              $data['password'] = $newpass;

              self::$db->update(self::uTable, $data, "username = '" . $userdata->username . "'");

              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = $mail->sendMail();
              $subject = lang('PASS_ESUBJECT') . Registry::get("Core")->company;

              ob_start();
              require_once (BASEPATH . 'mailer/Password_Reset.tpl.php');
              $html_message = ob_get_contents();
              ob_end_clean();

              $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($userdata->email => $userdata->fname . ' ' . $userdata->lname))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setBody($html_message, 'text/html');

              (self::$db->affected() && $mailer->send($msg)) ? Filter::msgOk(lang('PASS_OK'), false) : Filter::msgError(lang('PASS_ERR'), false);

          } else
              print Filter::msgStatus();
      }

      /**
       * Users::getProjects()
       * 
       * @return
       */
      public function getProjects()
      {
          $sql = "SELECT p.*, pt.title as typetitle," 
		  . "\n DATE_FORMAT(p.end_date, '" . Registry::get("Core")->short_date . "') as enddate" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN project_types as pt ON pt.id = p.project_type" 
		  . "\n WHERE client_id = " . $this->uid;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getSubmissions()
       * 
       * @return
       */
      public function getSubmissions()
      {
          $sql = "SELECT s.*, p.title as ptitle," 
		  . "\n DATE_FORMAT(s.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM submissions as s" 
		  . "\n LEFT JOIN projects as p ON p.id = s.project_id" 
		  . "\n WHERE p.client_id = " . $this->uid . " AND s.status <> 0"
		  . "\n ORDER BY s.created DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getProjectById()
       * 
       * @return
       */
      public function getProjectById()
      {
          $sql = "SELECT p.*, pt.title as typetitle, CONCAT(u.fname,' ',u.lname) as staffname, u.avatar," 
		  . "\n DATE_FORMAT(p.end_date, '" . Registry::get("Core")->short_date . "') as enddate," 
		  . "\n DATE_FORMAT(p.start_date, '" . Registry::get("Core")->short_date . "') as startdate" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN project_types as pt ON pt.id = p.project_type" 
		  . "\n LEFT JOIN users as u ON u.id = p.staff_id" 
		  . "\n WHERE p.id = " . Filter::$id . " AND client_id = " . $this->uid;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getSubmissionsByProjectId()
       * 
       * @return
       */
      public function getSubmissionsByProjectId()
      {
          $sql = "SELECT s.*, p.title as ptitle," 
		  . "\n DATE_FORMAT(s.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM submissions as s" 
		  . "\n LEFT JOIN projects as p ON p.id = s.project_id" 
		  . "\n WHERE p.client_id = " . $this->uid . " AND s.status <> 0" 
		  . "\n AND p.id = " . Filter::$id 
		  . "\n ORDER BY s.created DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getSingleSubmissionsById()
       * 
       * @param bool $subid
       * @return
       */
      public function getSingleSubmissionsById($subid = false)
      {
          $id = ($subid) ? $subid : Filter::$id;
          $sql = "SELECT s.*, p.title as ptitle, CONCAT(u.fname,' ',u.lname) as staffname, u.email," 
		  . "\n DATE_FORMAT(s.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM submissions as s" 
		  . "\n LEFT JOIN projects as p ON p.id = s.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = s.staff_id" 
		  . "\n WHERE p.client_id = " . $this->uid . " AND s.status <> 0" 
		  . "\n AND s.id = " . $id;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getTasksByProjectId()
       * 
       * @return
       */
      public function getTasksByProjectId()
      {
          $sql = "SELECT t.*, p.title as ptitle, p.id as pid," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->short_date . "') as start," 
		  . "\n DATE_FORMAT(t.duedate, '" . Registry::get("Core")->short_date . "') as duedate" 
		  . "\n FROM tasks as t" 
		  . "\n LEFT JOIN projects as p ON p.id = t.project_id" 
		  . "\n WHERE p.client_id = " . $this->uid . " AND client_access = 1 AND p.id = " . Filter::$id 
		  . "\n ORDER BY t.created DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getTaskByProjectId()
       * 
	   * @param int $tid
       * @return
       */
      public function getTaskByProjectId($tid)
      {
          $sql = "SELECT t.*, p.title as ptitle, p.id as pid" 
		  . "\n FROM tasks as t" 
		  . "\n LEFT JOIN projects as p ON p.id = t.project_id" 
		  . "\n WHERE p.client_id = " . $this->uid
		  . "\n AND t.id = " . (int)$tid
		  . "\n AND client_access = 1"
		  . "\n AND p.id = " . Filter::$id;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Users::getFilesByProject()
       * 
       * @param bool $project_id
       * @return
       */
      public function getFilesByProject($project_id = false)
      {
          $id = ($project_id) ? $project_id : Filter::$id;

          $sql = "SELECT f.*, p.title as ptitle, p.id as pid" 
		  . "\n FROM project_files as f" 
		  . "\n LEFT JOIN projects as p ON p.id = f.project_id" 
		  . "\n WHERE p.client_id = " . $this->uid . " AND project_id = " . $id 
		  . "\n AND f.client_id = 0" 
		  . "\n ORDER BY f.created";
          $row = self::$db->fetch_all($sql);
          return ($row) ? $row : 0;
      }

      /**
       * Users::processProjectFile()
       * 
       * @return
       */
      public function processProjectFile()
      {

          if (empty($_POST['title']))
              Filter::$msgs['title'] = "Please Enter Project File Name";

          if (empty($_FILES['filename']['name']))
              Filter::$msgs['filename'] = "Please Select File To Upload";

          $upl = Uploader::instance(Registry::get("Core")->file_max, Registry::get("Core")->file_types);
          if (!empty($_FILES['filename']['name']) and empty(Filter::$msgs)) {
              $dir = UPLOADS . 'data/';
              $upl->upload('filename', $dir);
          }

          if (empty(Filter::$msgs)) {
              $data = array(
				  'title' => sanitize($_POST['title']), 
				  'filedesc' => $_POST['filedesc'], 
				  'created' => "NOW()", 
				  'project_id' => intval($_POST['project_id']), 
				  'client_id' => Registry::get("Users")->uid, 
				  'filename' => $upl->fileInfo['fname'], 
				  'filesize' => $upl->fileInfo['size']
			  );

              self::$db->insert("project_files", $data);

              (self::$db->affected()) ? Filter::msgOk(lang('FPRO_FILESENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));;
          } else
              print Filter::msgStatus();
      }

      /**
       * Users::getLatestNews()
       * 
       * @return
       */
      public function getLatestNews()
      {
          $sql = "SELECT *" 
		  . "\n FROM news" 
		  . "\n WHERE active = 1" 
		  . "\n AND created <= NOW()" 
		  . "\n ORDER BY created ASC";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getClientInvoices()
       * 
       * @param mixed $status
       * @return
       */
      public function getClientInvoices($status)
      {
          $sql = "SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.fname,' ',u.lname) as name" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN project_types as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n WHERE i.client_id = " . $this->uid 
		  . "\n AND i.status $status" 
		  . "\n AND i.onhold = 0"
		  . "\n ORDER BY i.created";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getInvoiceById()
       * 
       * @param bool $inv_id
       * @return
       */
      public function getInvoiceById($inv_id = false)
      {
          $id = ($inv_id) ? (int)$inv_id : Filter::$id;
          $sql = "SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, id.recurring as irecurring, id.days, id.period" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN invoice_data as id ON id.invoice_id = i.id" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n WHERE i.client_id = " . $this->uid . " AND i.id = " . $id;

          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getProjectInvoiceById()
       * 
       * @return
       */
      public function getProjectInvoiceById()
      {
          $sql = "SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.fname,' ',u.lname) as name, u.email, u.address, u.city, u.zip, u.state, u.phone, u.company, u.vat" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n WHERE i.client_id = " . $this->uid . " AND i.id = '" . Filter::$id . "'";

          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getProjectInvoiceData()
       * 
       * @param bool $invid
       * @return
       */
      public function getProjectInvoiceData($invid = false)
      {
          $id = ($invid) ? intval($invid) : Filter::$id;

          $sql = "SELECT * FROM invoice_data WHERE invoice_id = '" . (int)$id . "'";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getProjectInvoicePayments()
       * 
       * @param bool $invid
       * @return
       */
      public function getProjectInvoicePayments($invid = false)
      {
          $id = ($invid) ? intval($invid) : Filter::$id;

          $sql = "SELECT *," 
		  . "\n DATE_FORMAT(created, '" . Registry::get("Core")->short_date . "') as cdate" 
		  . "\n FROM invoice_payments" 
		  . "\n WHERE invoice_id = '" . (int)$id . "'";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getSupportTickets()
       * 
       * @param bool $invid
       * @return
       */
      public function getSupportTickets()
      {

          $sql = "SELECT t.*, CONCAT(us.fname,' ',us.lname) as staffname," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_tickets as t" 
		  . "\n LEFT JOIN users as us ON us.id = t.staff_id"
		  . "\n WHERE client_id = " .$this->uid
		  . "\n ORDER BY t.created DESC";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Users::getSupportTicketById()
       * 
       * @return
       */
      public function getSupportTicketById()
      {
          $sql = "SELECT t.*, CONCAT(us.fname,' ',us.lname) as staffname," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_tickets as t" 
		  . "\n LEFT JOIN users as us ON us.id = t.staff_id" 
		  . "\n WHERE t.client_id = " . $this->uid . " AND t.id = " . Filter::$id;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::getResponseByTicketId()
       * 
       * @return
       */
      public function getResponseByTicketId()
      {
          $sql = "SELECT r.*, CONCAT(u.fname,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(r.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_responses as r" 
		  . "\n LEFT JOIN users as u ON u.id = r.author_id" 
		  . "\n LEFT JOIN support_tickets as st ON st.id = r.ticket_id"
		  . "\n WHERE st.client_id = " . $this->uid . " AND  r.ticket_id = " . Filter::$id
		  . "\n ORDER BY r.created DESC";
          
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

	  /**
	   * Users::replySupportTicket()
	   * 
	   * @return
	   */
	  public function replySupportTicket()
	  {
		  if (empty($_POST['body']))
			  Filter::$msgs['body'] = lang('SUP_DETAIL_R');

		  if (empty(Filter::$msgs)) {
		  
			  $sql = "SELECT t.*, CONCAT(us.fname,' ',us.lname) as staffname, us.email" 
			  . "\n FROM support_tickets as t" 
			  . "\n LEFT JOIN users as us ON us.id = t.staff_id" 
			  . "\n WHERE t.id = " . Filter::$id;
			  $row = self::$db->first($sql);
			  
			  $data = array(
					'ticket_id' => $row->id, 
					'author_id' => $this->uid,
					'user_type' => 'client',
					'created' => "NOW()",
					'body' => $_POST['body']
			  );
	
			  self::$db->insert("support_responses", $data);
	
			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('SUP_ESUBJECT') . cleanOut($row->subject);
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Reply_Ticket_From_Client.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->staffname))
					  ->setFrom(array(Registry::get("Users")->email => Registry::get("Users")->name))
					  ->setBody($html_message, 'text/html');
	
			  $numSent = $mailer->send($msg);
			  
			  (self::$db->affected()) ? Filter::msgOk(lang('SUP_SENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));;

		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Users::processSupportTicket()
	   * 
	   * @return
	   */
	  public function processSupportTicket()
	  {
		  if (empty($_POST['subject']))
			  Filter::$msgs['subject'] = lang('SUP_SUBJECT_R');

		  if (empty($_POST['body']))
			  Filter::$msgs['body'] = lang('SUP_DETAIL_R1');

		  $upl = Uploader::instance(Registry::get("Core")->file_max, Registry::get("Core")->file_types);
		  if (!empty($_FILES['attachment']['name']) and empty(Filter::$msgs)) {
			  $dir = UPLOADS . 'tempfiles/';
			  $upl->upload('attachment', $dir, "ATT_");
		  }
	  
		  if (empty(Filter::$msgs)) {
			  $data = array(
			        'staff_id' => 1,
					'tid' => 'T_' . strtoupper(substr(md5(microtime()),rand(0,26),5)),
					'client_id' => $this->uid, 
					'department' => 'Support', 
					'priority' => sanitize($_POST['priority']), 
					'subject' => sanitize($_POST['subject']), 
					'body' => sanitize($_POST['body']), 
					'attachment' => !empty($_FILES['attachment']['name']) ? $upl->fileInfo['fname'] : "",
					'status' => 'Open',
					'created' => "NOW()"
			  );

			  self::$db->insert("support_tickets", $data);
			  
			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('SUP_ESUBJECT') . cleanOut($data['subject']);
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Send_Ticket.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setFrom(array(Registry::get("Users")->email => Registry::get("Users")->name))
					  ->setBody($html_message, 'text/html');
	
			  $numSent = $mailer->send($msg);
			  
			  $message = lang('SUP_SENTOK1');

			  (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));;
		  } else
			  print Filter::msgStatus();
	  }

      /**
       * Users::staffPay()
       * 
       * @return
       */
      public function staffPay()
      {
          if (empty($_POST['email']))
              Filter::$msgs['email'] = lang('EMAIL_R1');

          if (empty($_POST['amount']) or !is_numeric($_POST['amount']))
              Filter::$msgs['amount'] = lang('STAFF_PAYAMOUNT_R');

          if (!getValue("id", "users", "id = '" . Filter::$id . "'"))
              Filter::$msgs['amount'] = lang('STAFF_STAFFID_ERR');
			  
          if (empty(Filter::$msgs)) {
			  
			  $emailSubject = urlencode(lang('STAFF_PAYSTAFF_E'));
			  $receiverType = urlencode('EmailAddress');
			  $currency = urlencode(sanitize($_POST['cur']));
			
			  // Add request-specific fields to the request string.
			  $nvpStr = "&EMAILSUBJECT=$emailSubject&RECEIVERTYPE=$receiverType&CURRENCYCODE=$currency";
			
			  $receiversArray = array();
			
			  for ($i = 0; $i < 1; $i++) {
				  $receiverData = array(
					  'receiverEmail' => sanitize($_POST['email']),
					  'amount' => $_POST['amount'],
					  'uniqueID' => time() . "_$i",
					  'note' => sanitize($_POST['note'])
					  );
				  $receiversArray[$i] = $receiverData;
			  }
			
			  foreach ($receiversArray as $i => $receiverData) {
				  $receiverEmail = urlencode($receiverData['receiverEmail']);
				  $amount = urlencode($receiverData['amount']);
				  $uniqueID = urlencode($receiverData['uniqueID']);
				  $note = urlencode($receiverData['note']);
				  $nvpStr .= "&L_EMAIL$i=$receiverEmail&L_Amt$i=$amount&L_UNIQUEID$i=$uniqueID&L_NOTE$i=$note";
			  }
			
			  $httpParsedResponseAr = $this->PPHttpPost('MassPay', $nvpStr);
			
			  if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
			  
				  $data = array(
						'txn_id' => sanitize($httpParsedResponseAr['CORRELATIONID']), 
						'staff_id' => Filter::$id, 
						'amount' => floatval($_POST['amount']), 
						'currency' => sanitize($_POST['cur']),
						'note' => sanitize($_POST['note']),
						'created' => "NOW()"
				  );

				  self::$db->insert(self::spTable, $data);
				  
				  $json['type'] = 'success';
				  $json['info'] = '<div class="msgOk">' . lang('STAFF_PAYCOMPLETE_OK') . $httpParsedResponseAr['CORRELATIONID'] . '</div>';
				  print json_encode($json);
				  
			  } else {
				  $json['type'] = 'success';
				  $json['info'] = '<div class="msgError">Pay failed: <pre>' . print_r($httpParsedResponseAr, true) . '</pre></div>';
				  exit();
			  }

          } else {
              $json['message'] = Filter::msgStatus();
			  print json_encode($json);
		  }
      }

      /**
       * Users::staffPay()
       * 
       * @return
       */
	  private function PPHttpPost($methodName_, $nvpStr_)
	  {
		  $environment = Registry::get("Core")->pp_mode == 1 ? "live" : "sandbox";
	
		  // Set up your API credentials, PayPal end point, and API version.
		  $API_UserName = urlencode(Registry::get("Core")->pp_email);
		  $API_Password = urlencode(Registry::get("Core")->pp_pass);
		  $API_Signature = urlencode(Registry::get("Core")->pp_api);
		  $API_Endpoint = "https://api-3t.paypal.com/nvp";
		  if ("sandbox" === $environment || "beta-sandbox" === $environment) {
			  $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
		  }
		  $version = urlencode('51.0');
	
		  // Set the curl parameters.
		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
		  curl_setopt($ch, CURLOPT_VERBOSE, 1);
	
		  // Turn off the server and peer verification (TrustManager Concept).
		  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_POST, 1);
	
		  // Set the API operation, version, and API signature in the request.
		  $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";
	
		  // Set the request as a POST FIELD for curl.
		  curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);
	
		  // Get response from the server.
		  $httpResponse = curl_exec($ch);
	
		  if (!$httpResponse) {
			  exit(Filter::msgError($methodName_ . "failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')'));
		  }
	
		  // Extract the response details.
		  $httpResponseAr = explode("&", $httpResponse);
	
		  $httpParsedResponseAr = array();
		  foreach ($httpResponseAr as $i => $value) {
			  $tmpAr = explode("=", $value);
			  if (sizeof($tmpAr) > 1) {
				  $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
			  }
		  }
	
		  if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
			  exit(Filter::msgError("Invalid HTTP Response for POST request(" . $nvpreq . ") to " . $API_Endpoint));
		  }
	
		  return $httpParsedResponseAr;
	  }

      /**
       * Users::getStafPaymentHistory()
       * 
       * @return
       */
      public function getStafPaymentHistory()
      {
		  
		  $sql = "SELECT t.*, CONCAT(us.fname,' ',us.lname) as staffname" 
		  . "\n FROM " . self::spTable . " as t" 
		  . "\n LEFT JOIN " . self::uTable . " as us ON us.id = t.staff_id" 
		  . "\n WHERE t.staff_id = " . Filter::$id;

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Users::checkProjectAccess()
       * 
       * @param mixed $pid
       * @return
       */
      public function checkProjectAccess($pid)
      {

		  if($this->userlevel == 9) {
		     return true;
		  } elseif ($this->userlevel == 5 and $this->getProjectAccessData($pid)) {
              return true;
		  } else {
			  return false;
		  }

      }

      /**
       * Users::getProjectAccessData()
       * 
       * @return
       */
      private function getProjectAccessData($pid)
      {
          $sql = "SELECT id FROM projects WHERE id = $pid AND FIND_IN_SET(" . $this->uid . ", staff_id)";
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;

      }

      /**
       * Users::getUserData()
       * 
       * @return
       */
      public function getUserData()
      {
          $sql = "SELECT *, DATE_FORMAT(created, '" . Registry::get("Core")->long_date . "') as cdate," 
		  . "\n DATE_FORMAT(lastlogin, '" . Registry::get("Core")->long_date . "') as ldate" 
		  . "\n FROM " . self::uTable 
		  . "\n WHERE id = '" . $this->uid . "'";
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Users::doUserNames()
	   * 
       * @param array $userids
       * @return
       */
	  public function doUserNames($userids)
	  {
		  if ($rowdata = self::$db->fetch_all("SELECT id, CONCAT(fname,' ',lname) as staffname FROM  " . self::uTable . " WHERE id IN($userids)")) {
			  $data = '';
			  foreach ($rowdata as $row) {
				  if (strlen($data) > 0) {
					  $data .= ", ";
				  }
				  $data .= $row->staffname;
			  }
			  return $data;
		  } else
			  return '...';
	  }
	  

      /**
       * Users::usernameExists()
       * 
       * @param mixed $username
       * @return
       */
      private function usernameExists($username)
      {
          $username = sanitize($username);
          if (strlen(self::$db->escape($username)) < 4)
              return 1;
			  
          //Username should contain only alphabets, numbers, underscores or hyphens.Should be between 4 to 15 characters long
		  $valid_uname = "/^[a-zA-Z0-9_-]{4,15}$/";
          if (!preg_match($valid_uname, $username))
              return 2;

          $sql = self::$db->query("SELECT username FROM users WHERE username = '" . $username . "' LIMIT 1");
          $count = self::$db->numrows($sql);

          return ($count > 0) ? 3 : false;
      }

      /**
       * Users::emailExists()
       * 
       * @param mixed $email
       * @return
       */
      private function emailExists($email)
      {
		  $email = self::$db->escape($email);
          $sql = self::$db->query("SELECT email FROM users WHERE email = '" . sanitize($email) . "' LIMIT 1");

          if (self::$db->numrows($sql) == 1) {
              return true;
          } else
              return false;
      }

      /**
       * Users::isValidEmail()
       * 
       * @param mixed $email
       * @return
       */
      private function isValidEmail($email)
      {
          if (function_exists('filter_var')) {
              if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                  return true;
              } else
                  return false;
          } else
              return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
      }

      /**
       * Users::getUniqueCode()
       * 
       * @param string $length
       * @return
       */
      private function getUniqueCode($length = "")
      {
          $code = md5(uniqid(rand(), true));
          if ($length != "") {
              return substr($code, 0, $length);
          } else
              return $code;
      }

      /**
       * Users::generateRandID()
       * 
       * @return
       */
      private function generateRandID()
      {
          return sha1($this->getUniqueCode(24));
      }

      /**
       * Users::getClientFilter()
       * 
       * @return
       */
      public function getClientFilter()
      {
          $arr = array(
				'company-ASC' => lang('COMPANY').' &uarr;', 
				'company-DESC' => lang('COMPANY').' &darr;', 
				'fname-ASC' => lang('FNAME').' &uarr;', 
				'fname-DESC' => lang('FNAME').' &darr;', 
				'lname-ASC' => lang('LNAME').' &uarr;', 
				'lname-DESC' => lang('LNAME').' &darr;', 
				'email-ASC' => lang('EMAIL').' &uarr;', 
				'email-DESC' => lang('EMAIL').' &darr;'
		  );

          $filter = '';
          foreach ($arr as $key => $val) {
              if ($key == get('sort')) {
                  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
              } else
                  $filter .= "<option value=\"$key\">$val</option>\n";
          }
          unset($val);
          return $filter;
      }
  }
?>