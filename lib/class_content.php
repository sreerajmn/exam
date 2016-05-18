<?php
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Content
  {
      private static $db;


      /**
       * Content::__construct()
       * 
       * @return
       */
      public function __construct()
      {
          self::$db = Registry::get("Database");
      }


      /**
       * Content::getGateways()
       * 
       * @param bool $active
       * @return
       */
      public function getGateways($active = false)
      {
          $where = ($active) ? "WHERE active = '1'" : null;
          $sql = "SELECT * FROM gateways" 
		  . "\n " . $where . "\n ORDER BY name";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;

      }
	  
	  public function is_bot()
	  {
			$botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
			"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
			"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
			"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
			"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
			"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
			"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler","TweetmemeBot",
			"Butterfly","Twitturls","Me.dium","Twiceler");
		 
			foreach($botlist as $bot)
			{
				if(strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false)
					return true;	
			}
			return false;
	  }
	  
	  public function tracker()
      {
		(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '') ? $ip = $_SERVER['REMOTE_ADDR'] : $ip = 'undefined';
		(isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] != '') ? $query_string = $_SERVER['QUERY_STRING'] : $query_string = 'undefined';
		(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') ? $http_referer = $_SERVER['HTTP_REFERER'] : $http_referer = 'undefined';
		(isset($_SERVER['HTTP_USER_AGENT']) && $_SERVER['HTTP_USER_AGENT'] != '') ? $http_user_agent = $_SERVER['HTTP_USER_AGENT'] : $http_user_agent = 'undefined';
		(isset($_SERVER['REMOTE_HOST']) && $_SERVER['REMOTE_HOST'] != '') ? $remote_host = $_SERVER['REMOTE_HOST'] : $remote_host = 'undefined';
		(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '') ? $request_uri = $_SERVER['REQUEST_URI'] : $request_uri = 'undefined';
		// check if it's a bot
		if ($this->is_bot())
			$isbot = 1;
		else
			$isbot = 0;
		
		$country = '';
		$city = '';
		
		if(isset($info['http_code']) && $info['http_code'] === 200) 
		{
			// parse the xml and get country and city from exec
			$objDOM = new DOMDocument(); 
			$objDOM->loadXML($exec); 

			$country1 = $objDOM->getElementsByTagName("CountryName"); 
			$country  = $country1->item(0)->nodeValue;
			
			$city1 = $objDOM->getElementsByTagName("City"); 
			$city  = $city1->item(0)->nodeValue;
		}
		
		$date = date("Y-m-d");
		$time = date("H:i:s");
		
		$data = array(
			'country' => $country, 
			'city' => $city, 
			'created' => $date, 
			'time' => $time, 
			'ip' => $ip, 
			'query_string' => $query_string, 
			'http_referer' => $http_referer, 
			'http_user_agent' => $http_user_agent, 
			'isbot' => $isbot
		);
		
		self::$db->insert("tracker", $data);
      }

      /**
       * Content::processGateway()
       * 
       * @return
       */
      public function processGateway()
      {
          if (empty($_POST['displayname']))
              Filter::$msgs['displayname'] = lang('GATE_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array(
					'displayname' => sanitize($_POST['displayname']), 
					'extra' => sanitize($_POST['extra']), 
					'extra2' => sanitize($_POST['extra2']), 
					'extra3' => sanitize($_POST['extra3']), 
					'live' => intval($_POST['live']), 
					'active' => intval($_POST['active'])
			  );

              self::$db->update("gateways", $data, "id='" . Filter::$id . "'");
              (self::$db->affected()) ? Filter::msgOk(lang('GATE_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getNews()
       * 
       * @return
       */
      public function getNews()
      {
          $sql = "SELECT *, DATE_FORMAT(created, '" . Registry::get("Core")->long_date . "') as start" 
		  . "\n FROM news" 
		  . "\n ORDER BY created ASC";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processNews()
       * 
       * @return
       */
      public function processNews()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('NEWS_NAME_R');

          if (empty($_POST['body']))
              Filter::$msgs['body'] = lang('NEWS_BODY_R');

          if (empty(Filter::$msgs)) {
			  $author = self::$db->first("SELECT CONCAT(fname,' ',lname) as name FROM users WHERE id = '" . Registry::get("Users")->uid . "'");
              $data = array(
					'title' => sanitize($_POST['title']), 
					'body' => $_POST['body'], 
					'author' => $author->name, 
					'created' => sanitize($_POST['created']), 
					'active' => intval($_POST['active'])
			  );

              (Filter::$id) ? self::$db->update("news", $data, "id='" . Filter::$id . "'") : self::$db->insert("news", $data);
              $message = (Filter::$id) ? lang('NEWS_UPDATED') : lang('NEWS_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getCustomFields()
       * 
       * @return
       */
      public function getCustomFields()
      {
          $sql = "SELECT * FROM custom_fields" 
		  . "\n ORDER BY sorting, section";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::fieldSection()
       * 
       * @return
       */
      public static function fieldSection($section)
      {
          switch($section) {
			  case "p":
			  return lang('CUSF_SECTION_P');
			  break;

			  case "c":
			  return lang('CUSF_SECTION_C');
			  break;

			  case "s":
			  return lang('CUSF_SECTION_S');
			  break;

			  case "t":
			  return lang('CUSF_SECTION_T');
			  break;
			  
			  case "sb":
			  return lang('CUSF_SECTION_SB');
			  break;
		  }
      }

      /**
       * Content::getFieldSection()
       * 
       * @return
       */
	  public function loadAnswer($qid)
      {
		$sql = "SELECT * FROM answers WHERE question=$qid ORDER BY id ASC";
        $row = self::$db->fetch_all($sql);
		return $row;
      }
	  
      public static function getFieldSection($section = false)
      {
		  
          $arr = array(
				 'p' => lang('CUSF_SECTION_P'),
				 'c' => lang('CUSF_SECTION_C'),
				 's' => lang('CUSF_SECTION_S'),
				 't' => lang('CUSF_SECTION_T'),
				 'sb' => lang('CUSF_SECTION_SB')
		  );

          $html = '';
          foreach ($arr as $key => $val) {
              if ($key == $section) {
                  $html .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $html .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $html;
      }
	  
      /**
       * Content::rendertCustomFields()
       * 
       * @return
       */
      public function rendertCustomFields($section, $data)
      {
		  $html = '';
          if($fdata = self::$db->fetch_all("SELECT * FROM custom_fields WHERE section = '" . self::$db->escape($section) . "' ORDER BY sorting")) {
			  $value = ($data) ? explode("::", $data) : null;
			  $html .= '<header>' . lang('CUSF_SFSECTION') . '</header>';
			  $html .= '<div class="row">';
			  $counter = count($fdata);
			  foreach ($fdata as $k => $cfrow) {
					$html .= '<section class="col col-6">';
					$html .= '<label class="input">';
					$html .= '<i class="icon-prepend icon-check-empty"></i>';
					$html .= '<input name="custom[]" type="text" placeholder="' . $cfrow->title . '" value="' . $value[$k] . '"/>';
					$html .= '</label>';
					$html .= '<div class="note">' . $cfrow->title . '</div>';
					$html .= '</section>';
			  }
			  $html .= '</div>';
			  $html .= '<hr>';
		  }

          return $html;
      }

      /**
       * Content::rendertCustomFieldsView()
       * 
       * @return
       */
      public function rendertCustomFieldsView($section, $data)
      {
		  $html = '';
          if($fdata = self::$db->fetch_all("SELECT * FROM custom_fields WHERE section = '" . self::$db->escape($section) . "' ORDER BY sorting")) {
			  $value = ($data) ? explode("::", $data) : null;
			  foreach ($fdata as $k => $cfrow) {
				  $html .= '<tr>';
				  $html .= '<td>' . $cfrow->title . ':</td>';
				  $html .= '<td>' . $value[$k] . '</td>';
				  $html .= '</tr>';
			  }
		  }

          return $html;
      }
	  
      /**
       * Content::processField()
       * 
       * @return
       */
      public function processField()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('CUSF_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'fsize' => empty($_POST['fsize']) ? 55 : intval($_POST['fsize']), 
					'section' => sanitize($_POST['section'])
			  );

              (Filter::$id) ? self::$db->update("custom_fields", $data, "id='" . Filter::$id . "'") : self::$db->insert("custom_fields", $data);
              $message = (Filter::$id) ? lang('CUSF_UPDATED') : lang('CUSF_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }
	  
      /**
       * Content::processEmail()
       * 
       * @return
       */
      public function processEmail()
      {
          if (empty($_POST['subject']))
              Filter::$msgs['subject'] = lang('MAIL_REC_SUJECT_R');

          if (empty($_POST['body']))
              Filter::$msgs['body'] = lang('MAIL_BODY_R');

          if ($_POST['recipient'] == 'multiple') {
			  if (empty($_POST['multilist']) or !is_array($_POST['multilist'])) 
                  Filter::$msgs['multilist'] = lang('MAIL_REC_R');
		  }
			  
          if (empty(Filter::$msgs)) {
              $to = sanitize($_POST['recipient']);
              $subject = cleanOut($_POST['subject']);
              $body = cleanOut($_POST['body']);
			  
			  if(file_exists(UPLOADS.'print_logo.png')) {
				  $logo = '<img src="'.UPLOADURL . 'print_logo.png" alt="'. Registry::get("Core")->company.'" />';
			  } elseif(Registry::get("Core")->logo) {
				  $logo = '<img src="'.UPLOADURL . Registry::get("Core")->logo . '" alt="'. Registry::get("Core")->company.'" />';
			  } else {
				$logo = Registry::get("Core")->company;
			  }

              switch ($to) {
                  case "all":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100,30));

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE id != 1";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->company, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

						  if($mailer->batchSend($message, $failures)) {
							  Filter::msgOk(lang('MAIL_SENT'));
						  } else {
							  Filter::msgAlert(lang('MAIL_ALERT'));
							  foreach ($failures as $failed) {
								  print $failed."\n";
							  }
							  unset($failed);
						  }
                      }
                      break;

                  case "clients":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100,30));

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE userlevel = 1";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->company, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

						  if($mailer->batchSend($message, $failures)) {
							  Filter::msgOk(lang('MAIL_SENT'));
						  } else {
							  Filter::msgAlert(lang('MAIL_ALERT'));
							  foreach ($failures as $failed) {
								  print $failed."\n";
							  }
							  unset($failed);
						  }
                      }
                      break;

                  case "staff":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100,30));

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE userlevel = 5";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->company, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

						  if($mailer->batchSend($message, $failures)) {
							  Filter::msgOk(lang('MAIL_SENT'));
						  } else {
							  Filter::msgAlert(lang('MAIL_ALERT'));
							  foreach ($failures as $failed) {
								  print $failed."\n";
							  }
							  unset($failed);
						  }
                      }
                      break;

                  case "multiple":
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100,30));
					  $matches = sanitize($_POST['multilist']);
					  $matches = implode(',', $_POST['multilist']);

                      $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE id IN(" . $matches . ")";
                      $userrow = self::$db->fetch_all($sql);

                      $replacements = array();
                      if ($userrow) {
                          foreach ($userrow as $cols) {
                              $replacements[$cols->email] = array(
									'[COMPANY]' => Registry::get("Core")->company, 
									'[LOGO]' => $logo, 
									'[NAME]' => $cols->name, 
									'[URL]' => Registry::get("Core")->site_url, 
									'[YEAR]' => date('Y')
							  );
                          }

                          $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
                          $mailer->registerPlugin($decorator);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
								  ->setBody($body, 'text/html');

                          foreach ($userrow as $row)
                              $message->addTo($row->email, $row->name);
                          unset($row);

						  if($mailer->batchSend($message, $failures)) {
							  Filter::msgOk(lang('MAIL_SENT'));
						  } else {
							  Filter::msgAlert(lang('MAIL_ALERT'));
							  foreach ($failures as $failed) {
								  print $failed."\n";
							  }
							  unset($failed);
						  }
                      }
                      break;
					  
                  default:
                      require_once (BASEPATH . "lib/class_mailer.php");
                      $mailer = $mail->sendMail();
                      $row = self::$db->first("SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE email LIKE '%" . sanitize($to) . "%'");
                      if ($row) {
                          $newbody = str_replace(
						  array('[COMPANY]', '[LOGO]', '[NAME]', '[URL]', '[YEAR]'), 
						  array(Registry::get("Core")->company, $logo, $row->name, Registry::get("Core")->site_url, date('Y')), $body);

                          $message = Swift_Message::newInstance()
								  ->setSubject($subject)
								  ->setTo(array($to => $row->name))
								  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
								  ->setBody($newbody, 'text/html');
								  
						  if (!empty($_FILES['attach']['name'])) {
							  move_uploaded_file($_FILES['attach']['tmp_name'], UPLOADS . 'tempfiles/' . $_FILES['attach']['name']);
							  $message->attach(Swift_Attachment::fromPath(UPLOADS . 'tempfiles/' . $_FILES['attach']['name']));
						  }

						  if($mailer->batchSend($message, $failures)) {
							  Filter::msgOk(lang('MAIL_SENT'));
						  } else {
							  Filter::msgAlert(lang('MAIL_ALERT'));
							  foreach ($failures as $failed) {
								  print $failed."\n";
							  }
							  unset($failed);
						  }
                      }
                      break;
              }

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjects()
       * 
       * @return
       */
      public function getProjects()
      {
          $sort = sanitize(get('sort'));
          $access = '';
          $order = '';
          if (Registry::get("Users")->userlevel == 5) {
              $extra = ($sort) ? "AND" : "WHERE";
			  $uid = Registry::get("Users")->uid;
              $access = "$extra FIND_IN_SET($uid, p.staff_id)";
			  $q = "SELECT COUNT(*) FROM projects WHERE FIND_IN_SET($uid, staff_id) LIMIT 1";
              $record = Registry::get("Database")->query($q);
			  $total = Registry::get("Database")->fetchrow($record);
			  $counter = $total[0];
          } else {
              $counter = countEntries("projects");
          }
	  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          ($sort) ? $order = "WHERE p.client_id = '" . (int)$sort . "'" : null;

          $sql = "SELECT p.id as pid, p.title, p.p_status, p.b_status, p.cost, p.start_date, u.id as uid," 
		  . "\n CONCAT(u.fname,' ',u.lname) as clientname," 
		  . "\n DATE_FORMAT(p.start_date, '" . Registry::get("Core")->short_date . "') as start," 
		  . "\n (SELECT CONCAT(fname,' ',lname) FROM users WHERE id = p.staff_id) as staffname, i.recurring" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN users as u ON u.id = p.client_id" 
		  . "\n LEFT JOIN invoices as i ON i.project_id = p.id" 
		  . "\n $order $access" 
		  . "\n GROUP BY p.id ORDER BY p.start_date DESC" . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProject()
       * 
       * @return
       */
      public function processProject()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('PROJ_NAME_R');

          if (empty($_POST['project_type']))
              Filter::$msgs['project_type'] = lang('PROJ_TYPE_R');

          if (empty($_POST['client_id']))
              Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

          if (!isset($_POST['staff_id']))
              Filter::$msgs['staff_id'] = lang('PROJ_MANAGER_R');
			  
		  if (empty($_POST['cost']) or $_POST['cost'] == 0 or !is_numeric($_POST['cost']))
              Filter::$msgs['cost'] = lang('PROJ_PRICE_R');

          if (empty(Filter::$msgs)) {
              $progress = str_replace("%", "", $_POST['p_status']);

              $data = array(
					'title' => sanitize($_POST['title']), 
					'client_id' => intval($_POST['client_id']), 
					'staff_id' => Core::_implode($_POST['staff_id']), 
					'project_type' => intval($_POST['project_type']), 
					'body' => $_POST['body'], 
					'start_date' => sanitize($_POST['start_date']), 
					'end_date' => sanitize($_POST['end_date']), 
					'cost' => (float)$_POST['cost'], 
					'p_status' => intval($progress)
			  );

              $pdata['staff_id'] = $data['staff_id'];

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
				  
              if (Filter::$id) {
                  $res = self::$db->update("projects", $data, "id='" . Filter::$id . "'");
                  self::$db->update("permissions", $pdata, "project_id='" . Filter::$id . "'");
              } else {
                  $res = self::$db->insert("projects", $data);
                  $lastid = self::$db->insertid();
                  $pdata['project_id'] = (int)$lastid;
                  self::$db->insert("permissions", $pdata);
              }

              $message = (Filter::$id) ? lang('PROJ_UPDATED') : lang('PROJ_ADDED');

              ($res) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
              if (isset($_POST['notify_staff']) && $_POST['notify_staff'] == 1) {
				  $userrow = self::$db->fetch_all("SELECT email, CONCAT(fname,' ',lname) as staffname FROM users WHERE id IN(" . $data['staff_id'] . ")");
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();
				  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(20,10));
                  $row = $this->getAllInfo($lastid);
                  $subject = lang('PROJ_ESUBJECT') . cleanOut($data['title']);

                  ob_start();
                  require_once (BASEPATH . 'mailer/Project_From_Admin.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();
                  
				  $replacements = array();
				  if($userrow) {
					  foreach ($userrow as $cols) {
						  $replacements[$cols->email] = array('[STAFF_NAME]' => $cols->staffname);
					  }
				  }
				  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
				  $mailer->registerPlugin($decorator);
				  
                  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						  ->setBody($html_message, 'text/html');

						  foreach ($userrow as $urow) {
							  $msg->addTo($urow->email, $urow->staffname);
						  }
						  unset($urow);
						  
                  $numSent = $mailer->batchSend($msg);
              }
			  
          } else
              print Filter::msgStatus();
      }
		
	
		
		
		
	  /**
       * Content::processExam()
       * 
       * @return
       */
      public function processExam()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('EXAM_NAME_R');

          if (empty($_POST['duration']))
              Filter::$msgs['duration'] = lang('EXAM_DUR_R');

          if (empty(Filter::$msgs)) {
              
              $data = array(
					'title' => sanitize($_POST['title']), 
					'course' => intval($_POST['course']),
					'duration' => intval($_POST['duration']),
					'syllabus' => $_POST['syllabus']
			  );
			
			
			
			  (Filter::$id) ? self::$db->update("exams", $data, "id='" . Filter::$id . "'") : self::$db->insert("exams", $data);
              $message = (Filter::$id) ? lang('EXAM_UPDATED') : lang('EXAM_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
          } else
              print Filter::msgStatus();
      }
		
		
	  /**
       * Content::processResource()
       * 
       * @return
       */
      public function processResource()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = 'Please enter resource item title';

          if (empty($_POST['category']))
              Filter::$msgs['category'] = 'Please choose a category';

          if (empty(Filter::$msgs)) {
              
              $data = array(
					'title' => sanitize($_POST['title']), 
					'category' => intval($_POST['category']),
					'content' => $_POST['content']
			  );
			
			  (Filter::$id) ? self::$db->update("resources", $data, "id='" . Filter::$id . "'") : self::$db->insert("resources", $data);
              $message = (Filter::$id) ? 'Resource Item Updated' : 'Resource Item Added';

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
          } else
              print Filter::msgStatus();
      }
	  
	  /**
       * Content::processQuestion()
       * 
       * @return
       */
      public function processQuestion()
      {
          if (empty($_POST['qtype']))
              Filter::$msgs['qtype'] = 'Please choose question type';

          if (empty($_POST['examid']))
              Filter::$msgs['examid'] = 'Please choose an exam';
			  
          if (empty($_POST['marks']))
              Filter::$msgs['marks'] = 'Please provide marks for this question';

          if (empty($_POST['question']))
              Filter::$msgs['question'] = 'Please write the question';
			  
          if (empty(Filter::$msgs)) {
              
              $data = array(
					'type' => intval($_POST['qtype']), 
					'exam' => intval($_POST['examid']),
					'marks' => intval($_POST['marks']),
					'description' => $_POST['question']
			  );
			
			  (Filter::$id) ? self::$db->update("questions", $data, "id='" . Filter::$id . "'") : self::$db->insert("questions", $data);
              $message = (Filter::$id) ? 'Question Updated' : 'Question Added Successfully';

			  
			  $qtype = intval($_POST['qtype']);
			  $lastid = self::$db->insertid();
              
			  if(isset($_POST['answer1'])){
				$answer1 = $_POST['answer1'];
			  }
			  
              $answer2 = $_POST['answer2'];
              $answer3 = $_POST['answer3'];
              $answer4 = $_POST['answer4'];
              $correct2 = $_POST['correct2'];
              $correct3 = $_POST['correct3'];
			  
			  if( $qtype == 2 ){
				foreach($answer2 as $a => $b){				
					$data = array(
						'question' => intval($lastid), 
						'answer' => $answer2[$a],
						'correct' => intval($correct2[$a])
					);
					self::$db->insert("answers", $data);
				  }
			  }
			  else if( $qtype == 3 ){
				foreach($answer3 as $a => $b){				
					$data = array(
						'question' => intval($lastid), 
						'answer' => $answer3[$a],
						'correct' => intval($correct3[$a])
					);
					self::$db->insert("answers", $data);
				  }
			  }
			  else if( $qtype == 1 ){				
				$data = array(
					'question' => intval($lastid), 
					'answer' => intval($answer1),
					'correct' => 1
				);
				self::$db->insert("answers", $data);
			  }
			  else if( $qtype == 4 ){
				$data = array(
					'question' => intval($lastid), 
					'answer' => $answer4,
					'correct' => 1
				);
				self::$db->insert("answers", $data);
			  }			  
			  
              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
          } else
              print Filter::msgStatus();
      }
	  
	  
	  public function updateQuestion()
      {
          if (empty($_POST['uexam']))
              Filter::$msgs['uexam'] = 'Please choose an exam';
			  
          if (empty($_POST['umarks']))
              Filter::$msgs['umarks'] = 'Please provide marks for this question';

          if (empty($_POST['udescription']))
              Filter::$msgs['udescription'] = 'Please write the question';
			  
          if (empty(Filter::$msgs)) {
              
			  $data = array(
					'exam' => intval($_POST['uexam']),
					'marks' => intval($_POST['umarks']),
					'description' => $_POST['udescription']
			  );
				
			  self::$db->update("questions", $data, "id='" . Filter::$id . "'");
			  $message = 'Question Updated Successfully';

			  $utype = intval($_POST['utype']);
			  
			  if( $utype == 1 ){
				$ansid1 = intval($_POST['ansid1']);
				$data = array(
					'answer' => 1,
					'correct' => intval($_POST['answer1'])
				);
				self::$db->update("answers", $data, "id='" . $ansid1 . "'");
			  }
			  else if( $utype == 2 ){
				$correct2 = $_POST['correct2'];
				$answer2 = $_POST['answer2'];
				$ansid2 = $_POST['ansid2'];
				
				foreach($answer2 as $a => $b){
					$data = array( 
						'answer' => $answer2[$a],
						'correct' => $correct2[$a]
					);
					self::$db->update("answers", $data, "id='" . $ansid2[$a] . "'");
				}
			  }
			  else if( $utype == 3 ){				
				$correct3 = $_POST['correct3'];
				$answer3 = $_POST['answer3'];
				$ansid3 = $_POST['ansid3'];
				$banned3 = $_POST['banned3'];
				
				foreach($answer3 as $a => $b){
					$data = array( 
						'answer' => $answer3[$a],
						'correct' => $correct3[$a],
						'banned' => $banned3[$a]
					);
					self::$db->update("answers", $data, "id='" . $ansid3[$a] . "'");
				}
			  }
			  else if( $utype == 4 ){
				$ansid4 = intval($_POST['ansid4']);
				$data = array(
					'answer' => $_POST['answer4'],
					'correct' => 1
				);
				self::$db->update("answers", $data, "id='" . $ansid4 . "'");
			  }
			  
              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
          } else
              print Filter::msgStatus();
      }

	  
	  /**
       * Content::getExams()
       * 
       * @return
       */
      public function getExams()
      {
          $sort = sanitize(get('sort'));
          $access = '';
          $order = '';
		  $counter = countEntries("exams");
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          ($sort) ? $order = "WHERE p.course = '" . (int)$sort . "'" : null;

          $sql = "SELECT p.id as pid, p.course, p.title, p.syllabus, p.duration, u.id as uid," 
		  . "\n FROM exams as p" 
		  . "\n LEFT JOIN project_types as u ON u.id = p.course" 
		  . "\n $order $access" 
		  . "\n GROUP BY p.id" . $pager->limit;
		  
		  
		  if($sort){
			$sql = "SELECT exams.id, exams.course, project_types.title as ctitle, exams.title, exams.syllabus, exams.duration FROM exams 
			INNER JOIN project_types 
			ON exams.course=project_types.id WHERE exams.course=$sort";
		  }else{
			$sql = "SELECT exams.id, exams.course, project_types.title as ctitle, exams.title, exams.syllabus, exams.duration FROM exams 
			INNER JOIN project_types 
			ON exams.course=project_types.id";
		  }
		  
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	  public function getResults()
      {
        $sort = sanitize(get('sort'));
        $uid = sanitize(get('uid'));
        
		if($sort != ''){
			$sql = "SELECT results.id, users.fname as fname, users.lname as lname, results.exam, results.marks, results.fullmarks, results.score, results.date as rdate FROM results 
			INNER JOIN users 
			ON results.user=users.id WHERE results.exam = $sort";
		}else if($uid != ''){
			$sql = "SELECT results.id, users.fname as fname, users.lname as lname, results.exam, results.marks, results.fullmarks, results.score, results.date as rdate FROM results 
			INNER JOIN users 
			ON results.user=users.id WHERE results.user=$uid";
		}else{
			$sql = "SELECT results.id, users.fname as fname, users.lname as lname, results.exam, results.marks, results.fullmarks, results.score, results.date as rdate FROM results 
			INNER JOIN users 
			ON results.user=users.id";
		}
		$row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
      }
	  
	  public function getEnrolment()
      {
        $sort = sanitize(get('sort'));
        $uid = sanitize(get('uid'));
        
		if($sort != ''){
			$sql = "SELECT enrollment.id, users.fname as fname, users.lname as lname, enrollment.course, enrollment.date as rdate FROM enrollment 
			INNER JOIN users 
			ON enrollment.user=users.id WHERE enrollment.course = $sort";
		}else if($uid != ''){
			$sql = "SELECT enrollment.id, users.fname as fname, users.lname as lname, enrollment.course, enrollment.date as rdate FROM enrollment 
			INNER JOIN users 
			ON enrollment.user=users.id WHERE enrollment.user=$uid";
		}else{
			$sql = "SELECT enrollment.id, users.fname as fname, users.lname as lname, enrollment.course, enrollment.date as rdate FROM enrollment 
			INNER JOIN users 
			ON enrollment.user=users.id";
		}
		$row = self::$db->fetch_all($sql);

        return ($row) ? $row : 0;
      }
	  
	  public function getExamtitle($id)
      {
          $exam = self::$db->first("SELECT * FROM exams WHERE id = $id");
          return  $exam->title;
      }
	  
	  public function getCoursetitle($id)
      {
          $course = self::$db->first("SELECT * FROM project_types WHERE id = $id");
          return  $course->title;
      }
	  
	  
	  /**
       * Content::getResources()
       * 
       * @return
       */
      public function getResources()
      {
          $sort = sanitize(get('sort'));
          $access = '';
          $order = '';
              
		  $counter = countEntries("resources");
	  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          ($sort) ? $order = "WHERE p.course = '" . (int)$sort . "'" : null;

          $sql = "SELECT p.id as pid, p.course, p.title, p.syllabus, p.duration, u.id as uid," 
		  . "\n FROM exams as p" 
		  . "\n LEFT JOIN project_types as u ON u.id = p.course" 
		  . "\n $order $access" 
		  . "\n GROUP BY p.id" . $pager->limit;
		  
		  
		  if($sort){
			$sql = "SELECT resources.id, categories.title as ctitle, resources.title, resources.content FROM resources 
			INNER JOIN categories 
			ON resources.category=categories.id WHERE resources.category=$sort ORDER BY resources.id DESC";
		  }else{
			$sql = "SELECT resources.id, categories.title as ctitle, resources.title, resources.content FROM resources 
			INNER JOIN categories 
			ON resources.category=categories.id ORDER BY resources.id DESC";
		  }
		  
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
		/**
       * Content::getFWResources()
       * 
       * @return
       */
      public function getFWResources()
      {
		
		$sql = "SELECT id, title FROM resources ORDER BY `id` DESC LIMIT 5";
		  
          $row = self::$db->fetch_all($sql);
          return ($row) ? $row : 0;
      }
	  
	  
	  /**
       * Content::getQuestions()
       * 
       * @return
       */
      public function getQuestions()
      {
          $sort = sanitize(get('sort'));
          $access = '';
          $order = '';
          $counter = countEntries("questions");
	  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          ($sort) ? $order = "WHERE p.course = '" . (int)$sort . "'" : null;

          $sql = "SELECT p.id as pid, p.course, p.title, p.syllabus, p.duration, u.id as uid," 
		  . "\n FROM exams as p" 
		  . "\n LEFT JOIN project_types as u ON u.id = p.course" 
		  . "\n $order $access" 
		  . "\n GROUP BY p.id" . $pager->limit;
		  
		  if($sort){
			$sql = "SELECT questions.id, exams.title as etitle, questions.type, questions.description, questions.marks FROM questions 
			INNER JOIN exams 
			ON questions.exam=exams.id WHERE questions.exam=$sort";
		  }else{
			$sql = "SELECT questions.id, exams.title as etitle, questions.type, questions.description, questions.marks FROM questions 
			INNER JOIN exams 
			ON questions.exam=exams.id";
		  }
		  
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
	 
      /**
       * Content::getProjectList()
       * 
       * @return
       */
      public function getProjectList()
      {
		  $where = (Registry::get("Users")->userlevel == 5) ? "WHERE FIND_IN_SET(" . Registry::get("Users")->uid . ", staff_id)" : null;
          $sql = "SELECT * FROM projects $where";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getExamTypes()
       * 
       * @return
       */
      public function getExamTypes()
      {
          $sql = "SELECT * FROM exams";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectTypes()
       * 
       * @return
       */
      public function getProjectTypes()
      {
          $sql = "SELECT * FROM project_types";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectType()
       * 
       * @return
       */
      public function processProjectType()
      {

          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('TYPE_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array(
				'title' => sanitize($_POST['title']), 
				'fees' => sanitize($_POST['fees']), 
				'description' => sanitize($_POST['description']),
				'recurring' => sanitize($_POST['recurring']),
				'period' => sanitize($_POST['period']),
				'days' => sanitize($_POST['days']),
			  );

              (Filter::$id) ? self::$db->update("project_types", $data, "id='" . Filter::$id . "'") : self::$db->insert("project_types", $data);
              $message = (Filter::$id) ? lang('TYPE_UPDATED') : lang('TYPE_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

	  
	  
	  /**
       * Content::getCategories()
       * 
       * @return
       */
      public function getFAQs()
      {
          $sql = "SELECT * FROM faqs";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processCategory()
       * 
       * @return
       */
      public function processFAQ()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = 'Please enter FAQ title';

          if (empty(Filter::$msgs)) {
              $data = array('title' => sanitize($_POST['title']), 'content' => sanitize($_POST['content']), 'order' => sanitize($_POST['order']));

              (Filter::$id) ? self::$db->update("faqs", $data, "id='" . Filter::$id . "'") : self::$db->insert("faqs", $data);
              $message = (Filter::$id) ? 'FAQ Item Updated' : 'FAQ Item Added';
              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

	  /**
       * Content::getCategories()
       * 
       * @return
       */
	  
      public function getCategories()
      {
          $sql = "SELECT * FROM categories";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processCategory()
       * 
       * @return
       */
      public function processCategory()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = 'Please enter resource title';

          if (empty(Filter::$msgs)) {
              $data = array('title' => sanitize($_POST['title']), 'description' => sanitize($_POST['description']));

              (Filter::$id) ? self::$db->update("categories", $data, "id='" . Filter::$id . "'") : self::$db->insert("categories", $data);
              $message = (Filter::$id) ? 'Category Updated' : 'Category Added';
              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectFiles()
       * 
       * @return
       */
      public function getProjectFiles($limit = false, $order = false)
      {
          $where = (Registry::get("Users")->userlevel == 5) ? "WHERE f.staff_id = '" . Registry::get("Users")->uid . "'" : $where = null;
		  $sort = ($order) ? "p.title" : "f.created";
		  $limiter = ($limit) ? " LIMIT 0,5" : "";

          $sql = "SELECT f.*, p.title as ptitle, p.id as pid" 
		  . "\n FROM project_files as f" 
		  . "\n LEFT JOIN projects as p ON p.id = f.project_id" 
		  . "\n $where"
		  . "\n ORDER BY $sort $limiter";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getFilesById()
       * 
       * @return
       */
      public function getFilesById()
      {
          $and = (Registry::get("Users")->userlevel == 5) ? "AND staff_id = '" . Registry::get("Users")->uid . "'" : null;
		  
          $sql = "SELECT * FROM project_files " 
		  . "\n WHERE id = " . Filter::$id 
		  . "\n $and";
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Content::getFilesByProject()
       * 
       * @param bool $project_id
       * @return
       */
      public function getFilesByProject($project_id = false)
      {
          $id = ($project_id) ? $project_id : Filter::$id;
          $sql = "SELECT * FROM project_files " 
		  . "\n WHERE project_id = " . $id 
		  . "\n ORDER BY title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectFile()
       * 
       * @return
       */
      public function processProjectFile()
      {

          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('FILE_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('FILE_SELPROJ_R');

          if (!Filter::$id and empty($_FILES['filename']['name']))
              Filter::$msgs['filename'] = lang('FILE_ATTACH_R');

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
					'staff_id' => Registry::get("Users")->uid, 
					'version' => sanitize($_POST['version'])
			  );

              $file = getValue("filename", "project_files", "id = '" . Filter::$id . "'");
              if (!empty($_FILES['filename']['name'])) {
                  if ($file and is_file(UPLOADS . 'data/' . $file)) {
                      unlink(UPLOADS . 'data/' . $file);
                  }
                  $data['filename'] = $upl->fileInfo['fname'];
                  $data['filesize'] = $upl->fileInfo['size'];
              } else {
                  $data['filename'] = $file;
              }

              (Filter::$id) ? self::$db->update("project_files", $data, "id='" . Filter::$id . "'") : self::$db->insert("project_files", $data);
              $message = (Filter::$id) ? lang('FILE_UPDATED') : lang('FILE_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectTasks()
       * 
       * @return
       */
      public function getProjectTasks()
      {
          if (Registry::get("Users")->userlevel == 5) {
			  if (isset($_GET['sort'])) {
				  if ($_GET['sort'] == 'completed') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress = 100 AND staff_id = '" . Registry::get("Users")->uid . "' LIMIT 1";
					  $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "' AND progress = 100";
				  } elseif($_GET['sort'] == 'pending') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress <> 100 AND staff_id = '" . Registry::get("Users")->uid . "' LIMIT 1";
					  $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "' AND progress <> 100";
				  }
			  } else {
				  $q = "SELECT COUNT(*) FROM tasks WHERE staff_id = '" . Registry::get("Users")->uid . "' LIMIT 1";
				  $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "'";
			  }

          } else {
			  if (isset($_GET['sort'])) {
				  if ($_GET['sort'] == 'completed') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress = 100 LIMIT 1";
					  $access = "WHERE progress = 100";
				  } elseif($_GET['sort'] == 'pending') {
					  $q = "SELECT COUNT(*) FROM tasks WHERE progress <>100 LIMIT 1";
					  $access = "WHERE progress <> 100";
				  }
			  } else {
				  $q = "SELECT COUNT(*) FROM tasks LIMIT 1";
				  $access = null;
			  }
				  
          }

		  $record = Registry::get("Database")->query($q);
		  $total = Registry::get("Database")->fetchrow($record);
		  $counter = $total[0];
			  
          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          $sql = "SELECT t.*, p.title as ptitle, p.id as pid," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM tasks as t" 
		  . "\n LEFT JOIN projects as p ON p.id = t.project_id" 
		  . "\n $access" 
		  . "\n ORDER BY p.title, t.created DESC" . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getTasksByProject()
       * 
       * @return
       */
      public function getTasksByProject()
      {
          $access = (Registry::get("Users")->userlevel == 5) ? "AND t.staff_id='" . Registry::get("Users")->uid . "'" : null;

          $sql = "SELECT t.*," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM tasks as t" 
		  //. "\n LEFT JOIN permissions as pp ON pp.project_id = t.project_id" 
		  . "\n WHERE t.project_id = '" . Filter::$id . "'" 
		  . "\n $access" 
		  . "\n ORDER BY t.title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectTask()
       * 
       * @return
       */
      public function processProjectTask()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('TASK_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('TASK_SELPROJ_R');

          if (empty(Filter::$msgs)) {
              $progress = str_replace("%", "", $_POST['progress']);
              $data = array(
					'project_id' => intval($_POST['project_id']), 
					'staff_id' => intval($_POST['staff_id']), 
					'client_access' => intval($_POST['client_access']), 
					'author_id' => Registry::get("Users")->uid, 
					'title' => sanitize($_POST['title']), 
					'details' => $_POST['details'], 
					'duedate' => sanitize($_POST['duedate']) . ' ' . date('H:i:s'), 
					'created' => sanitize($_POST['created']) . ' ' . date('H:i:s'), 
					'progress' => intval($progress)
			  );

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
			  
              (Filter::$id) ? self::$db->update("tasks", $data, "id='" . Filter::$id . "'") : self::$db->insert("tasks", $data);
              $message = (Filter::$id) ? lang('TASK_UPDATED') : lang('TASK_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
              if (isset($_POST['notify_staff']) && $_POST['notify_staff'] == 1) {
				  $user = self::$db->first("SELECT email, CONCAT(fname,' ',lname) as staffname FROM users WHERE id = " . $data['staff_id']);
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();
                  $row = $this->getAllInfo($data['project_id']);
                  $subject = lang('TASK_ESUBJECT') . cleanOut($data['title']);

                  ob_start();
                  require_once (BASEPATH . 'mailer/Task_From_Admin.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();

                  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($user->email => $user->staffname))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						  ->setBody($html_message, 'text/html');

                  $numSent = $mailer->send($msg);
              }
			  
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getTaskTemplates()
       * 
       * @return
       */
      public function getTaskTemplates()
      {

          $sql = "SELECT * FROM task_templates ORDER BY title";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processTaskTemplate()
       * 
       * @return
       */
      public function processTaskTemplate()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('TTASK_NAME_R');

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'details' => $_POST['details']
			  );

              (Filter::$id) ? self::$db->update("task_templates", $data, "id='" . Filter::$id . "'") : self::$db->insert("task_templates", $data);
              $message = (Filter::$id) ? lang('TTASK_UPDATED') : lang('TTASK_ADDED');

              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
			  
          } else
              print Filter::msgStatus();
      }
	  
      /**
       * Content::getProjectSubmissions()
       * 
       * @param bool $all
       * @return
       */
      public function getProjectSubmissions($all = true)
      {
          $where = ($all) ? "project_id = '" . Filter::$id . "'" : "id = '" . Filter::$id . "'";

          $sql = "SELECT *, DATE_FORMAT(created, '" . Registry::get("Core")->long_date . "') as sdate," 
		  . "\n DATE_FORMAT(review_date, '" . Registry::get("Core")->long_date . "') as rdate" 
		  . "\n FROM submissions" 
		  . "\n WHERE $where" 
		  . "\n ORDER BY created";

          $row = ($all) ? self::$db->fetch_all($sql) : self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::processProjectSubmission()
       * 
       * @return
       */
      public function processProjectSubmission()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('SUBS_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');

          if (empty($_POST['description']))
              Filter::$msgs['description'] = lang('SUBS_NOTE_R');

          if (!empty($_FILES['filename']['name'])) {
              $upl = Uploader::instance(Registry::get("Core")->file_max, Registry::get("Core")->file_types);
              $dir = UPLOADS . 'data/';
              $upl->upload('filename', $dir);
          }

          if (empty(Filter::$msgs)) {
              $data = array(
					'project_id' => intval($_POST['project_id']), 
					'staff_id' => intval($_POST['staff_id']), 
					'title' => sanitize($_POST['title']), 
					'description' => $_POST['description'], 
					's_type' => sanitize($_POST['s_type']), 
					'status' => (isset($_POST['revsend']) && $_POST['revsend'] == 1) ? 1 : 0
			  );
              if (!Filter::$id) {
                  $data['created'] = "NOW()";
              }

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
			  
              (Filter::$id) ? self::$db->update("submissions", $data, "id='" . Filter::$id . "'") : $lastid = self::$db->insert("submissions", $data);
              $message = (Filter::$id) ? lang('SUBS_UPDATED') : lang('SUBS_ADDED');

              if (!empty($_FILES['filename']['name'])) {
                  $fdata = array(
						'title' => (empty($_POST['filetitle'])) ? sanitize($_POST['title']) : sanitize($_POST['filetitle']), 
						'created' => "NOW()", 
						'project_id' => intval($_POST['project_id']), 
						'staff_id' => intval($_POST['staff_id']), 
						'filename' => $upl->fileInfo['fname'], 
						'filesize' => $upl->fileInfo['size']
				  );
                  self::$db->insert("project_files", $fdata);
              }

              if (isset($_POST['revsend']) && $_POST['revsend'] == 1) {
                  require_once (BASEPATH . "lib/class_mailer.php");
                  $mailer = $mail->sendMail();
                  $row = $this->getAllInfo($data['project_id']);
                  $subject = lang('SUBS_SUBJECT') . cleanOut($data['title']);

                  ob_start();
                  require_once (BASEPATH . 'mailer/Submission_From_Admin.tpl.php');
                  $html_message = ob_get_contents();
                  ob_end_clean();

                  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($row->email => $row->clientname))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						  ->setBody($html_message, 'text/html');

                  $numSent = $mailer->send($msg);
              }


              (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

      /**
       * Content::getProjectInvoices()
       * 
       * @return
       */
      public function getProjectInvoices()
      {
          $where = (Filter::$id) ? "WHERE project_id = '" . Filter::$id . "'" : null;

          $sql = "SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.fname,' ',u.lname) as name" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n $where" 
		  . "\n ORDER BY i.created";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectInvoiceById()
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
		  . "\n WHERE i.id = '" . Filter::$id . "'";

          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectInvoiceData()
       * 
       * @param bool $invid
       * @return
       */
      public function getProjectInvoiceData($invid = false)
      {
          $id = ($invid) ? intval($invid) : Filter::$id;

          $sql = "SELECT * FROM invoice_data WHERE invoice_id = '" . (int)$id . "' ORDER BY id";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getProjectInvoicePayments()
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
       * Content::updateInvoice()
       * 
       * @return
       */
      public function updateInvoice()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = 'Please Enter Invoice Title';

          if (empty(Filter::$msgs)) {
              $data = array(
					'title' => sanitize($_POST['title']), 
					'duedate' => sanitize($_POST['duedate']), 
					'method' => sanitize($_POST['method']), 
					'status' => sanitize($_POST['status']),
					'notes' => sanitize($_POST['notes']),
					'onhold' => isset($_POST['onhold']) ? intval($_POST['onhold']) : 0,
					'comment' => sanitize($_POST['comment'])
			  );
			  
			  if($_POST['status'] == 'Paid') {
				  $data['amount_paid'] = floatval($_POST['amount_total']);
				  $row = self::$db->first("SELECT SUM(amount_total-tax) as total, project_id FROM invoices WHERE id = '" . Filter::$id . "' GROUP BY id");
				  
				  $edata = array(
						'invoice_id' => Filter::$id, 
						'project_id' => intval($row->project_id), 
						'method' => $data['method'], 
						'amount' => floatval($row->total),
						'created' => "NOW()",
						'description' => "Payment added by admin"
				  );
				  $pdata['b_status'] = $data['amount_paid'];
				  self::$db->insert("invoice_payments", $edata);
				  self::$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");
				  
			  }
			  
              self::$db->update("invoices", $data, "id='" . Filter::$id . "'");
              (self::$db->affected()) ? Filter::msgOk(lang('INVC_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));
			  

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::addInvoice()
       * 
       * @return
       */
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
              (self::$db->affected()) ? Filter::msgOk(lang('INVC_ADDED')) : Filter::msgAlert(lang('NOPROCCESS'));
			  
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

			  self::$db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");
			  self::$db->update("projects", $pdata, "id='" . $data['project_id'] . "'");

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::sendInvoice()
       * 
       * @param mixed $id
       * @return
       */
      public function sendInvoice($id)
      {
          $row = self::$db->first("SELECT i.*," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
		  . "\n p.title as ptitle, CONCAT(u.fname,' ',u.lname) as name, u.email, u.address, u.city, u.company, u.zip, u.state, u.phone" 
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN projects as p ON p.id = i.project_id" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n WHERE i.id = '" . (int)$id . "'");
		  
          if ($row) {
              $invdata = self::$db->fetch_all("SELECT i.*," 
			  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
			  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate," 
			  . "\n id.title as idtitle, id.description, id.amount,id.tax" 
			  . "\n FROM invoices as i" 
			  . "\n LEFT JOIN invoice_data as id ON id.invoice_id = i.id" 
			  . "\n WHERE i.id = '" . (int)$id . "'");

              $paydata = self::$db->fetch_all("SELECT *," 
			  . "\n DATE_FORMAT(created, '" . Registry::get("Core")->short_date . "') as cdate" 
			  . "\n FROM invoice_payments" 
			  . "\n WHERE invoice_id = '" . (int)$id . "'");
              
			  Filter::$id = $id;
			  ob_start();
			  require_once(BASEPATH . 'admin/print_pdf.php');
			  $pdf_html = ob_get_contents();
			  ob_end_clean();

			  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
			  $dompdf = new DOMPDF();
			  $dompdf->load_html($pdf_html);
			  $dompdf->render();
			  $pdf_content = $dompdf->output();
	  
              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = $mail->sendMail();
              $subject = lang('INVC_SUBJECT') . cleanOut($row->ptitle);

              ob_start();
              require_once (BASEPATH . 'mailer/Email_Invoice.tpl.php');
              $html_message = ob_get_contents();
              ob_end_clean();

              $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->name))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setBody($html_message, 'text/html');
					  
              $msg->attach(Swift_Attachment::newInstance($pdf_content, cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $row->title)) . '.pdf', 'application/pdf'));

              ($mailer->send($msg)) ? Filter::msgOk(lang('INVC_SENT_OK')) : Filter::msgError(lang('INVC_SENT_ERR'));
          }
      }

      /**
       * Content::loadInvoiceEntries()
       * 
       * @param mixed $invid
       * @return
       */
	  public function loadInvoiceEntries($invid)
	  {
		  $invdata = $this->getProjectInvoiceData($invid);
		  print '
			<table cellpadding="0" cellspacing="0" class="display">
			  <thead>
				<tr>
				  <th width="20">#</th>
				  <th width="20%" nowrap="nowrap" class="left">' .lang('INVC_ENTRYTITLE') . '</th>
				  <th width="40%" class="left">' . lang('DESC') . '</th>
				  <th class="left">' . lang('AMOUNT') . '</th>
				  <th>' . lang('EDIT') . '</th>
				  <th>' . lang('DELETE') . '</th>
				</tr>
			  </thead>';
		  if (!$invdata) {
			  print '
				<tr>
				  <td colspan="6">' . Filter::msgInfo(lang('INVC_NOENTRY'), false) . '</td>
				</tr>';
		  } else {
			  foreach ($invdata as $irow) {
				  print '
					<tr>
					  <th align="center">' . $irow->id . '.</th>
					  <td>' . $irow->title . '</td>
					  <td>' . $irow->description . '</td>
					  <td>' . $irow->amount . '</td>
					  <td align="center"><a href="index.php?do=invoices&amp;action=editentry&amp;id=' . $irow->id . '">'
					  . '<img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="' . lang('EDIT').': '.$irow->title . '"/></a></td>
					  <td align="center"><a href="javascript:void(0);" class="delete" id="item_' . $irow->id.':'.$irow->project_id.':'.$irow->invoice_id . '" rel="' . $irow->title . '">'
					  . '<img src="../images/delete.png" alt="" class="tooltip img-wrap2" title="' . lang('DELETE').': '.$irow->title . '" /></a></td>
					</tr>';
			  }
			  unset($irow);
		  }
		  print '
			</table>';
	  }

	  /**
	   * Content::processInvoiceEntry()
	   * 
	   * @return
	   */
	  public function processInvoiceEntry()
	  {
		  if (empty($_POST['etitle']))
			  Filter::$msgs['etitle'] = lang('INVC_ENTRYTITLE_R');
	
		  if (empty($_POST['eamount']) or !is_numeric($_POST['eamount']))
			  Filter::$msgs['eamount'] = lang('INVC_ENTRYAMOUNT_R');
	
		  if (empty(Filter::$msgs)) {
			  $edata = array(
				  'title' => sanitize($_POST['etitle']),
				  'project_id' => intval($_POST['project_id']),
				  'invoice_id' => intval($_POST['invoice_id']),
				  'description' => sanitize($_POST['edesc']),
				  'amount' => floatval($_POST['eamount']),
				  'tax' => (intval($_POST['etax']) == 1 and Registry::get("Core")->enable_tax) ? floatval($_POST['eamount']) * Registry::get("Core")->tax_rate : 0.00);
	
			  (Filter::$id) ? self::$db->update("invoice_data", $edata, "id='" . Filter::$id . "'") : $last_id = self::$db->insert("invoice_data", $edata);
			  (Filter::$id) ? Filter::msgOk(lang('INVC_ENTRY_UPDATED')) : '';
	
			  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM invoice_data WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");
			  $data = array('amount_total' => $row->amtotal + $row->itax, 'tax' => $row->itax);
			  $pdata['cost'] = $data['amount_total'];
	
			  self::$db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
			  self::$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");
	
			  if (isset($_POST['add_entry'])) {
				  $html = '
					<tr>
					  <td>' . $edata['title'] . '</td>
					  <td>' . $edata['description'] . '</td>
					  <td>' . $edata['amount'] . '</td>
					  <td><span class="tbicon"> <a href="index.php?do=invoices&amp;action=editentry&amp;id=' . $last_id . '" class="tooltip" data-title="' . lang('EDIT') . ': ' . $edata['title'] . '"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="item_' . $last_id . ':' . $edata['invoice_id'] . ':' . $edata['invoice_id'] . '" class="tooltip delete" data-rel="' . $edata['title'] . '" data-title="' . lang('DELETE') . ': ' . $edata['title'] . '"><i class="icon-trash"></i></a> </span></td>
					</tr>';
	
				  $json['type'] = 'success';
				  $json['message'] = $html;
				  $json['info'] = "<div class=\"green\"><p><span class=\"icon-ok-sign\"></span><i class=\"close icon-double-angle-down\"></i>" . lang('INVC_ENTRY_ADDED') . "</p></div>";
				  print json_encode($json);
			  }
		  } else {
			  if (isset($_POST['add_entry'])) {
				  $json['message'] = Filter::msgStatus();
				  print json_encode($json);
			  } else
				  print Filter::msgStatus();
		  }
	  }

	  /**
	   * Content::deleteInvoiceEntry()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public function deleteInvoiceEntry($data)
	  {
		  list($id, $project_id, $invoice_id) = explode(':', $data);

		  $res = self::$db->delete("invoice_data", "id='" . (int)$id . "'");
		  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM invoice_data WHERE invoice_id = '" . (int)$invoice_id . "' GROUP BY invoice_id");

		  $data = array(
				'amount_total' => ($row) ? $row->amtotal + $row->itax : 0.00, 
				'tax' => ($row) ? $row->itax : 0.00
		  );
		  $pdata['cost'] = $data['amount_total'];
		  $title = sanitize($_POST['title']);

		  self::$db->update("invoices", $data, "id='" . (int)$invoice_id . "'");
		  self::$db->update("projects", $pdata, "id='" . (int)$project_id . "'");

		  print ($res) ? Filter::msgOk(str_replace("[ENTRY]", $title, lang('INVC_DELENTRY_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));

	  }

	  /**
	   * Content::loadInvoiceRecords()
	   * 
	   * @param mixed $invid
	   * @return
	   */
	  public function loadInvoiceRecords($invid)
	  {
		  $paydata = $this->getProjectInvoicePayments($invid);
		  print '
			<table cellpadding="0" cellspacing="0" class="display">
			  <thead>
				<tr>
				  <th width="20">#</th>
				  <th width="20%" nowrap="nowrap" class="left">' . lang('INVC_RECPAID') . '</th>
				  <th width="40%" class="left">' . lang('DESC') . '</th>
				  <th class="left">' . lang('AMOUNT') . '</th>
				  <th>' . lang('EDIT') . '</th>
				  <th>' . lang('DELETE') . '</th>
				</tr>
			  </thead>';
		  if (!$paydata) {
			  print '
				<tr>
				  <td colspan="6">' . Filter::msgInfo(lang('INVC_NORECORD'), false) . '</td>
				</tr>';
		  } else {
			  foreach ($paydata as $prow) {
				  print '
					<tr>
					  <th align="center">' . $prow->id . '.</th>
					  <td>' . $prow->cdate . '</td>
					  <td>' . $prow->description . '</td>
					  <td>' . $prow->amount . '</td>
					  <td align="center"><a href="index.php?do=invoices&amp;action=editentry&amp;id=' . $prow->id . '">'
					  . '<img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="' . lang('EDIT') . '"/></a></td>
					  <td align="center"><a href="javascript:void(0);" class="delete" rel="' . $prow->cdate . '" id="item_' . $prow->id . ':' . $prow->project_id . ':' . $prow->invoice_id . '">'
					  . '<img src="../images/delete.png" alt="" class="tooltip img-wrap2" title="' . lang('DELETE') . '" /></a></td>
					</tr>';
			  }
			  unset($prow);
		  }
		  print '
			</table>';
	  }

	  /**
	   * Content::processInvoiceRecord()
	   * 
	   * @return
	   */
	  public function processInvoiceRecord()
	  {
		  if (empty($_POST['ramount']) or !is_numeric($_POST['ramount']))
			  Filter::$msgs['ramount'] = lang('INVC_RECAMOUNT_R');

		  if (empty(Filter::$msgs)) {
			  $edata = array(
					'project_id' => intval($_POST['project_id']), 
					'invoice_id' => intval($_POST['invoice_id']), 
					'description' => sanitize($_POST['rdesc']), 
					'amount' => floatval($_POST['ramount']), 
					'created' => sanitize($_POST['rcreated']), 
					'method' => sanitize($_POST['method'])
			  );

			  (Filter::$id) ? self::$db->update("invoice_payments", $edata, "id='" . Filter::$id . "'") : $last_id = self::$db->insert("invoice_payments", $edata);
			  (Filter::$id) ? Filter::msgOk(lang('INVC_REC_UPDATED')) : '';

			  $row = self::$db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . $edata['invoice_id'] . "' GROUP BY invoice_id");
			  $data['amount_paid'] = $row->amtotal;
			  $pdata['b_status'] = $data['amount_paid'];

			  self::$db->update("invoices", $data, "id='" . $edata['invoice_id'] . "'");
			  self::$db->update("projects", $pdata, "id='" . $edata['project_id'] . "'");

			  $row2 = self::$db->first("SELECT amount_total, amount_paid FROM invoices WHERE id = '" . $edata['invoice_id'] . "'");
			  $idata['status'] = ($row2->amount_total == $row2->amount_paid) ? 'Paid' : 'Unpaid';
			  self::$db->update("invoices", $idata, "id='" . $edata['invoice_id'] . "'");
			  
			  if (isset($_POST['add_record'])) {
				  $html = '
					<tr>
					  <td>' . Filter::dodate(Registry::get("Core")->short_date, $edata['created']) . '</td>
					  <td>' . $edata['description'] . '</td>
					  <td>' . $edata['amount'] . '</td>
					  <td><span class="tbicon"> <a href="index.php?do=invoices&amp;action=editrecord&amp;id=' . $last_id . '" class="tooltip" data-title="' . lang('EDIT') . '"><i class="icon-pencil"></i></a> </span> <span class="tbicon"> <a href="javascript:void(0);" id="pitem_' . $last_id . ':' . $edata['invoice_id'] . ':' . $edata['invoice_id'] . '" class="tooltip delete" data-rel="' . sanitize($_POST['ptitle']) . '" data-title="' . lang('DELETE') . '"><i class="icon-trash"></i></a> </span></td>
					</tr>';
	
				  $json['type'] = 'success';
				  $json['message'] = $html;
				  $json['info'] = "<div class=\"green\"><p><span class=\"icon-ok-sign\"></span><i class=\"close icon-double-angle-down\"></i>" . lang('INVC_REC_ADDED') . "</p></div>";
				  print json_encode($json);
			  }
		  } else {
			  if (isset($_POST['add_record'])) {
				  $json['message'] = Filter::msgStatus();
				  print json_encode($json);
			  } else
				  print Filter::msgStatus();
		  }
	  }

	  /**
	   * Content::deleteInvoiceRecord()
	   * 
	   * @param mixed $data
	   * @return
	   */
	  public function deleteInvoiceRecord($data)
	  {
		  list($id, $project_id, $invoice_id) = explode(':', $data);

		  $res = self::$db->delete("invoice_payments", "id='" . (int)$id . "'");
		  $row = self::$db->first("SELECT SUM(amount) as amtotal FROM invoice_payments WHERE invoice_id = '" . (int)$invoice_id . "' GROUP BY invoice_id");

		  $idata['amount_paid'] = ($row) ? $row->amtotal : 0.00;
		  $idata['status'] = 'Unpaid';
		  $pdata['b_status'] = ($row) ? $row->amtotal : 0.00;
		  $title = sanitize($_POST['title']);

		  self::$db->update("invoices", $idata, "id='" . (int)$invoice_id . "'");

		  print ($res) ? Filter::msgOk(str_replace("[RECORD]", $title, lang('INVC_DELRECORD_OK'))) : Filter::msgAlert(lang('NOPROCCESS'));

	  }

	  /**
	   * Content::getInvoicesByStatus()
	   * 
	   * @return
	   */
	  public function getInvoicesByStatus()
	  {
          $pager = Paginator::instance();
          $pager->items_total = countEntries("invoices");
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

          if (isset($_GET['sort'])) {
			  $sort = sanitize($_GET['sort']);
			  if (in_array($sort, array("Paid", "Unpaid", "Overdue"))) {
				  $where = " WHERE i.status = '" . $sort . "'";
			  }
          } 

          if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
              if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
                  $enddate = $_POST['enddate'];
              }
              $clause = (isset($where)) ? " AND i.duedate BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'" : " WHERE i.duedate BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
          }

          $where = (isset($where)) ? $where : null;
		  $clause = (isset($clause)) ? $clause : null;
		  
		  $sql = "SELECT i.*, CONCAT(u.fname,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(i.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n DATE_FORMAT(i.duedate, '" . Registry::get("Core")->short_date . "') as ddate"
		  . "\n FROM invoices as i" 
		  . "\n LEFT JOIN users as u ON u.id = i.client_id" 
		  . "\n $where $clause" 
		  . "\n ORDER BY i.duedate" . $pager->limit;
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

      /**
       * Content::addQuote()
       * 
       * @return
       */
      public function addQuote()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('QUTS_NAME_R');

          if (empty($_POST['client_id']))
              Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

          if (empty($_POST['expire']))
              Filter::$msgs['expire'] = lang('QUTS_EXPIRE_R');
          
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
					'expire' => sanitize($_POST['expire']), 
					'amount_total' => $amount_total,
					'method' => sanitize($_POST['method']), 
					'notes' => $_POST['notes'],
					'comment' => sanitize($_POST['comment']),
					'tax' => $tax, 
					'status' => 'Pending'
			  );

              $lastid = self::$db->insert("quotes", $data);
              (self::$db->affected()) ? Filter::msgOk(lang('QUTS_ADDED')) : Filter::msgAlert(lang('NOPROCCESS'));
			  
			  foreach ($_POST['amount'] as $key => $val) {
				  $edata = array(
						'title' => sanitize($_POST['dtitle'][$key]), 
						'project_id' => $data['project_id'], 
						'quote_id' => $lastid, 
						'description' => sanitize($_POST['description'][$key]), 
						'amount' => floatval($_POST['amount'][$key]), 
						'tax' => (intval($_POST['tax']) == 1 and Registry::get("Core")->enable_tax) ? (floatval($_POST['amount'][$key]) * Registry::get("Core")->tax_rate) : 0
				  );
				  self::$db->insert("quotes_data", $edata);
			  }
			  
			  $row = self::$db->first("SELECT SUM(amount) as amtotal, SUM(tax) as itax FROM quotes_data WHERE quote_id = '" . $edata['quote_id'] . "' GROUP BY quote_id");
			  $idata = array('amount_total' => $row->amtotal + $row->itax, 'tax' => $row->itax);

			  self::$db->update("quotes", $idata, "id='" . $lastid . "'");

          } else
              print Filter::msgStatus();
      }

      /**
       * Content::convertQuote()
       * 
       * @return
       */
      public function convertQuote()
      {
          if (empty($_POST['title']))
              Filter::$msgs['title'] = lang('QUTS_NAME_R');

          if (empty($_POST['project_id']))
              Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');
          

          if (empty(Filter::$msgs)) {
			  $row = Registry::get("Core")->getRowById("quotes", Filter::$id);
			  
              $data = array(
					'title' => $row->title, 
					'project_id' => intval($_POST['project_id']), 
					'client_id' => $row->client_id, 
					'created' => "NOW()", 
					'duedate' => sanitize($_POST['duedate']), 
					'amount_total' => $row->amount_total,
					'amount_paid' => 0, 
					'recurring' => 0, 
					'method' => sanitize($_POST['method']), 
					'notes' => $row->notes,
					'comment' => $row->comment,
					'tax' => $row->tax, 
					'onhold' => 0,
					'status' => 'Unpaid'
			  );

              $lastid = self::$db->insert("invoices", $data);
              (self::$db->affected()) ? Filter::msgOk(lang('QUTS_CONVERTED')) : Filter::msgAlert(lang('NOPROCCESS'));
			  
			  $quotedata = $this->getQuoteEntries($qid = false);
			  foreach ($quotedata as $val) {
				  $edata = array(
						'title' => $val->title, 
						'invoice_id' => $lastid, 
						'project_id' => intval($_POST['project_id']), 
						'description' => $val->description, 
						'amount' => $val->amount, 
						'tax' => $val->tax
				  );
				  self::$db->insert("invoice_data", $edata);
			  }
			  
			  self::$db->delete("quotes", "id='" . $row->id . "'");
			  self::$db->delete("quotes_data", "quote_id='" . $row->id . "'");

          } else
              print Filter::msgStatus();
      }
	  
      /**
       * Content::getQuotes()
       * 
       * @return
       */
      public function getQuotes()
      {

          $sql = "SELECT q.*, CONCAT(u.fname,' ',u.lname) as name" 
		  . "\n FROM quotes as q" 
		  . "\n LEFT JOIN users as u ON u.id = q.client_id" 
		  . "\n ORDER BY q.created";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getQuoteById()
       * 
       * @return
       */
      public function getQuoteById()
      {

          $sql = "SELECT q.*, CONCAT(u.fname,' ',u.lname) as name, u.email, u.address, u.city, u.zip, u.state, u.phone, u.company, u.vat" 
		  . "\n FROM quotes as q" 
		  . "\n LEFT JOIN users as u ON u.id = q.client_id" 
		  . "\n WHERE q.id = " . Filter::$id;

          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }
		  
      /**
       * Content::getQuoteEntries()
       * 
       * @return
       */
      public function getQuoteEntries($qid = false)
      {
		  $id = ($qid) ? intval($qid) : Filter::$id;

          $sql = "SELECT * FROM quotes_data" 
		  . "\n WHERE quote_id = " . $id 
		  . "\n ORDER BY id";

          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
		  
		  
      /**
       * Content::loadQuoteEntries()
       * 
       * @param mixed $invid
       * @return
       */
	  public function loadQuoteEntries($qid)
	  {
		  $quotedata = $this->getQuoteEntries($qid);
		  $html =  '
			<table class="myTable">
			  <thead>
				<tr>
				  <th class="header">#</th>
				  <th class="header">' .lang('INVC_ENTRYTITLE') . '</th>
				  <th class="header">' . lang('DESC') . '</th>
				  <th class="header">' . lang('AMOUNT') . '</th>
				</tr>
			  </thead>';
		  
			  foreach ($quotedata as $irow) {
				  $html .= '
					<tr>
					  <th>' . $irow->id . '.</th>
					  <td>' . $irow->title . '</td>
					  <td>' . $irow->description . '</td>
					  <td>' . $irow->amount . '</td>
					</tr>';
			  }
			  unset($irow);

		  $html .= '
			</table>';
			
			return $html;
	  }

      /**
       * Content::sendInvoice()
       * 
       * @param mixed $id
       * @return
       */
      public function sendQuote($id)
      {
		  Filter::$id = $id;
          $row = $this->getQuoteById();
		  
          if ($row) {
              $quotedata = $this->getQuoteEntries($id);
			  
			  ob_start();
			  require_once(BASEPATH . 'admin/print_quote_pdf.php');
			  $pdf_html = ob_get_contents();
			  ob_end_clean();

			  require_once(BASEPATH . 'lib/dompdf/dompdf_config.inc.php');
			  $dompdf = new DOMPDF();
			  $dompdf->load_html($pdf_html);
			  $dompdf->render();
			  $pdf_content = $dompdf->output();
	  
              require_once (BASEPATH . "lib/class_mailer.php");
              $mailer = $mail->sendMail();
              $subject = lang('QUTS_SUBJECT') . cleanOut($row->title);

              ob_start();
              require_once (BASEPATH . 'mailer/Email_Quote.tpl.php');
              $html_message = ob_get_contents();
              ob_end_clean();

              $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->name))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setBody($html_message, 'text/html');
					  
              $msg->attach(Swift_Attachment::newInstance($pdf_content, cleanOut(preg_replace("/[^a-zA-Z0-9\s]/", "", $row->title)) . '.pdf', 'application/pdf'));

              ($mailer->send($msg)) ? Filter::msgOk(lang('QUTS_SENT_OK')) : Filter::msgError(lang('QUTS_SENT_ERR'));
          }
      }
	  
	  /**
	   * Content::getTimeBilling()
	   * 
	   * @return
	   */
	  public function getTimeBilling()
	  {
		  if (Registry::get("Users")->userlevel == 5) {
			  $q = "SELECT COUNT(*) FROM time_billing  WHERE staff_id = " . Registry::get("Users")->uid . " GROUP BY project_id LIMIT 1";
			  $access = "WHERE pp.staff_id='" . Registry::get("Users")->uid . "'";
		  } else {
			  $q = "SELECT COUNT(*) FROM time_billing GROUP BY project_id LIMIT 1";
			  $access = null;
		  }
		  $record = Registry::get("Database")->query($q);
		  $total = Registry::get("Database")->fetchrow($record);
		  $counter = $total[0];

		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();


		  $sql = "SELECT t.*, CONCAT(u.fname,' ',u.lname) as fullname, p.title as ptitle, p.id as pid," 
		  . "\n COUNT(t.project_id) as totalprojects," 
		  . "\n SUM(t.hours) as totalhours" 
		  . "\n FROM time_billing as t" 
		  . "\n LEFT JOIN users as u ON u.id = t.client_id" 
		  . "\n LEFT JOIN projects as p ON p.id = t.project_id" 
		  . "\n LEFT JOIN permissions as pp ON pp.project_id = t.project_id" 
		  . "\n $access" 
		  . "\n GROUP BY t.project_id" . $pager->limit;
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getTimeBillingByProjectId()
	   * 
	   * @param bool $project_id
	   * @return
	   */
	  public function getTimeBillingByProjectId($project_id = false)
	  {
		  $id = ($project_id) ? $project_id : Filter::$id;

		  $sql = "SELECT tb.*, t.title as taskname, t.id as tid," 
		  . "\n DATE_FORMAT(tb.created, '" . Registry::get("Core")->short_date . "') as cdate" 
		  . "\n FROM time_billing as tb" 
		  . "\n LEFT JOIN tasks as t ON t.id = tb.task_id" 
		  . "\n WHERE tb.project_id = " . (int)$id . "" 
		  . "\n ORDER BY tb.created DESC";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getTimeBillingById()
	   * 
	   * @param bool $billing_id
	   * @return
	   */
	  public function getTimeBillingById($billing_id = false)
	  {
		  $id = ($billing_id) ? $billing_id : Filter::$id;

		  $sql = "SELECT tb.*, t.title as taskname, t.id as tid, p.title as ptitle, p.id as pid, " 
		  . "\n CONCAT(uc.fname,' ',uc.lname) as cfullname, CONCAT(us.fname,' ',us.lname) as sfullname," 
		  . "\n DATE_FORMAT(tb.created, '" . Registry::get("Core")->short_date . "') as cdate" 
		  . "\n FROM time_billing as tb" 
		  .  "\n LEFT JOIN tasks as t ON t.id = tb.task_id" 
		  . "\n LEFT JOIN projects as p ON p.id = tb.project_id" 
		  . "\n LEFT JOIN users as uc ON uc.id = tb.client_id" 
		  . "\n LEFT JOIN users as us ON us.id = tb.staff_id" 
		  . "\n WHERE tb.id = '" . $id . "'";
		  $row = self::$db->first($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::processTimeRecord()
	   * 
	   * @return
	   */
	  public function processTimeRecord()
	  {
		  if (empty($_POST['title']))
			  Filter::$msgs['title'] = lang('INVC_ENTRYTITLE_R');

		  if (empty($_POST['client_id']))
			  Filter::$msgs['client_id'] = lang('INVC_CLIENTSELECT_R');

		  if (empty($_POST['project_id']))
			  Filter::$msgs['project_id'] = lang('INVC_PROJCSELETC_R');

		  if (empty(Filter::$msgs)) {
			  $data = array(
					'staff_id' => intval($_POST['staff_id']), 
					'client_id' => intval($_POST['client_id']), 
					'project_id' => intval($_POST['project_id']), 
					'task_id' => intval($_POST['task_id']), 
					'title' => sanitize($_POST['title']), 
					'description' => $_POST['description'], 
					'hours' => floatval($_POST['hours']), 
					'created' => sanitize($_POST['created']) . ' ' . date('H:i:s')
			  );

			  (Filter::$id) ? self::$db->update("time_billing", $data, "id='" . Filter::$id . "'") : self::$db->insert("time_billing", $data);
			  $message = (Filter::$id) ? lang('BILL_UPDATED') : lang('BILL_ADDED');

			  (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));
		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Content::getPaymentTransactions()
	   * 
	   * @param bool $from
	   * @return
	   */
	  public function getPaymentTransactions($from = false)
	  {
		  $pager = Paginator::instance();
		  $pager->items_total = countEntries('invoice_payments');
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();

		  if (isset($_GET['sort'])) {
			  $data = explode("-", $_GET['sort']);
			  if (count($data) > 1) {
				  $sort = sanitize($data[0]);
				  $order = sanitize($data[1]);
				  if (in_array($sort, array("project_id", "invoice_id", "method", "amount", "created"))) {
					  $ord = ($order == 'DESC') ? " DESC" : " ASC";
					  $sorting = " ip." . $sort . $ord;
				  } else
					  $sorting = " ip.created DESC";
			  } else
				  $sorting = " ip.created DESC";
		  } else
			  $sorting = " ip.created DESC";

		  $clause = (isset($clause)) ? $clause : null;

		  if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
			  $enddate = date("Y-m-d");
			  $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
			  if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
				  $enddate = $_POST['enddate'];
			  }
			  $clause .= " WHERE ip.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
		  }
		  $where = (isset($where)) ? $where : null;
		  $sql = "SELECT ip.*," 
		  . "\n DATE_FORMAT(ip.created, '" . Registry::get("Core")->short_date . "') as cdate," 
		  . "\n p.title as ptitle, i.title as ititle" 
		  . "\n FROM invoice_payments as ip" 
		  . "\n LEFT JOIN project_types as p ON p.id = ip.project_id" 
		  . "\n LEFT JOIN invoices as i ON i.id = ip.invoice_id" 
		  . "\n " . $clause 
		  . "\n ORDER BY " . $sorting . $pager->limit;

		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

      /**
       * Content::getSupportTickets()
       * 
       * @return
       */
      public function getSupportTickets()
      {
          if (Registry::get("Users")->userlevel == 5) {
              $access = "WHERE t.staff_id='" . Registry::get("Users")->uid . "'";
              $counter = countEntries("support_tickets", "staff_id", Registry::get("Users")->uid);
          } else {
              $counter = countEntries("support_tickets");
			  $access = null;
          }

          $pager = Paginator::instance();
          $pager->items_total = $counter;
          $pager->default_ipp = Registry::get("Core")->perpage;
          $pager->paginate();

		  if (isset($_GET['sort'])) {
			  $data = explode("-", $_GET['sort']);
			  if (count($data) > 1) {
				  $sort = sanitize($data[0]);
				  $order = sanitize($data[1]);
				  if (in_array($sort, array("staff_id", "client_id", "priority", "status", "created"))) {
					  $ord = ($order == 'DESC') ? " DESC" : " ASC";
					  $sorting = " t." . $sort . $ord;
				  } else
					  $sorting = " t.created DESC";
			  } else
				  $sorting = " t.created DESC";
		  } else
			  $sorting = " t.created DESC";
			  
          $sql = "SELECT t.*, CONCAT(us.fname,' ',us.lname) as staffname, CONCAT(uc.fname,' ',uc.lname) as clientname," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_tickets as t" 
		  . "\n LEFT JOIN users as uc ON uc.id = t.client_id" 
		  . "\n LEFT JOIN users as us ON us.id = t.staff_id"
		  . "\n $access" 
		  . "\n ORDER BY " . $sorting . $pager->limit;
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getSupportTicketById()
       * 
       * @return
       */
      public function getSupportTicketById()
      {
          $sql = "SELECT t.*, CONCAT(uc.fname,' ',uc.lname) as clientname," 
		  . "\n DATE_FORMAT(t.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_tickets as t" 
		  . "\n LEFT JOIN users as uc ON uc.id = t.client_id" 
		  . "\n WHERE t.id = " . Filter::$id;
          $row = self::$db->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Content::getResponseByTicketId()
       * 
       * @return
       */
      public function getResponseByTicketId()
      {
          $sql = "SELECT r.*, CONCAT(u.fname,' ',u.lname) as name," 
		  . "\n DATE_FORMAT(r.created, '" . Registry::get("Core")->long_date . "') as cdate" 
		  . "\n FROM support_responses as r" 
		  . "\n LEFT JOIN users as u ON u.id = r.author_id" 
		  . "\n WHERE r.ticket_id = " . Filter::$id
		  . "\n ORDER BY r.created DESC";
          
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }

	  /**
	   * Content::processSupportTicket()
	   * 
	   * @return
	   */
	  public function processSupportTicket()
	  {
		  $data = array(
				'priority' => sanitize($_POST['priority']), 
				'staff_id' => intval($_POST['staff_id']), 
				'status' => sanitize($_POST['status'])
		  );

		  self::$db->update("support_tickets", $data, "id='" . Filter::$id . "'");

		  (self::$db->affected()) ? Filter::msgOk(lang('SUP_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));

	  }

	  /**
	   * Content::replySupportTicket()
	   * 
	   * @return
	   */
	  public function replySupportTicket()
	  {
		  if (empty($_POST['body']))
			  Filter::$msgs['body'] = lang('SUP_DETAIL_R');

		  if (empty(Filter::$msgs)) {
		  
			  $sql = "SELECT t.*, CONCAT(uc.fname,' ',uc.lname) as clientname, uc.email" 
			  . "\n FROM support_tickets as t" 
			  . "\n LEFT JOIN users as uc ON uc.id = t.client_id" 
			  . "\n WHERE t.id = " . Filter::$id;
			  $row = self::$db->first($sql);
			  
			  $data = array(
					'ticket_id' => $row->id, 
					'author_id' => Registry::get("Users")->uid, 
					'user_type' => 'staff',
					'created' => "NOW()",
					'body' => $_POST['body']
			  );
	
			  self::$db->insert("support_responses", $data);
	
			  require_once (BASEPATH . "lib/class_mailer.php");
			  $mailer = $mail->sendMail();
			  $subject = lang('SUP_ESUBJECT') . cleanOut($row->subject);
	
			  ob_start();
			  require_once (BASEPATH . 'mailer/Reply_Ticket_From_Admin.tpl.php');
			  $html_message = ob_get_contents();
			  ob_end_clean();
	
			  $msg = Swift_Message::newInstance()
					  ->setSubject($subject)
					  ->setTo(array($row->email => $row->clientname))
					  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
					  ->setBody($html_message, 'text/html');
	
			  $numSent = $mailer->send($msg);
			  
			  (self::$db->affected()) ? Filter::msgOk(lang('SUP_SENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));

		  } else
			  print Filter::msgStatus();
	  }

	  /**
	   * Content::addSupportTicket()
	   * 
	   * @return
	   */
	  public function addSupportTicket()
	  {
		  if (empty($_POST['subject']))
			  Filter::$msgs['subject'] = lang('SUP_SUBJECT_R');

		  if (empty($_POST['body']))
			  Filter::$msgs['body'] = lang('SUP_DETAIL_R1');

		  if (empty(Filter::$msgs)) {
			  $data = array(
			        'staff_id' => intval($_POST['staff_id']),
			        'tid' => 'T_' . strtoupper(substr(md5(microtime()),rand(0,26),5)),
					'client_id' => intval($_POST['client_id']),
					'department' => 'Support', 
					'priority' => sanitize($_POST['priority']), 
					'subject' => sanitize($_POST['subject']), 
					'body' => sanitize($_POST['body']), 
					'status' => 'Open',
					'created' => "NOW()"
			  );

			  self::$db->insert("support_tickets", $data);
			  
			  if (isset($_POST['notify_c']) && intval($_POST['notify_c']) == 1) {
				  $row = Registry::get("Core")->getRowById("users", $data['client_id']);
				  
				  require_once (BASEPATH . "lib/class_mailer.php");
				  $mailer = $mail->sendMail();
				  $subject = lang('SUP_ESUBJECT') . cleanOut($data['subject']);
		
				  ob_start();
				  require_once (BASEPATH . 'mailer/New_Ticket_From_Admin.tpl.php');
				  $html_message = ob_get_contents();
				  ob_end_clean();
		
				  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($row->email => $row->fname . ' ' .$row->lname))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						  ->setBody($html_message, 'text/html');
		
				  $numSent = $mailer->send($msg);
			  }

			  if (isset($_POST['notify_s']) && intval($_POST['notify_s']) == 1) {
				  $row = Registry::get("Core")->getRowById("users", $data['staff_id']);
				  
				  require_once (BASEPATH . "lib/class_mailer.php");
				  $mailer = $mail->sendMail();
				  $subject = lang('SUP_ESUBJECT') . cleanOut($data['subject']);
		
				  ob_start();
				  require_once (BASEPATH . 'mailer/New_Ticket_To_Staff.tpl.php');
				  $html_message = ob_get_contents();
				  ob_end_clean();
		
				  $msg = Swift_Message::newInstance()
						  ->setSubject($subject)
						  ->setTo(array($row->email => $row->fname . ' ' .$row->lname))
						  ->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						  ->setBody($html_message, 'text/html');
		
				  $numSent = $mailer->send($msg);
			  }
			  
			  $message = lang('SUP_SENTOK1');

			  (self::$db->affected()) ? Filter::msgOk($message) : Filter::msgAlert(lang('NOPROCCESS'));;
		  } else
			  print Filter::msgStatus();
	  }
	  
	  /**
	   * Content::getMessages()
	   * 
	   * @return
	   */
	  public function getMessages()
	  {

		  $q = "SELECT COUNT(messages.uid1) as total"
		  . "\n FROM messages, users"
		  . "\n WHERE ((messages.user1='" . Registry::get("Users")->uid . "'" 
		  . "\n AND users.id=messages.user2) OR (messages.user2='" . Registry::get("Users")->uid . "'" 
		  . "\n AND users.id=messages.user1))" 
		  . "\n AND messages.uid2='1'" 
		  . "\n LIMIT 1";
		  
		  $record = self::$db->query($q);
		  $total = self::$db->fetchrow($record);
		  $counter = $total[0];


		  $pager = Paginator::instance();
		  $pager->items_total = $counter;
		  $pager->default_ipp = Registry::get("Core")->perpage;
		  $pager->paginate();

		  $sql = "SELECT m1.uid1,m1.id, m1.msgsubject, m1.created, m1.user1read, m1.user2read, m1.user1, m1.user2, m1.uid2," 
		  . "\n CONCAT(users.fname,' ',users.lname) as name," 
		  . "\n COUNT(m2.uid1) as replies, users.id as userid," 
		  . "\n users.username FROM messages as m1, messages as m2,users" 
		  . "\n WHERE ((m1.user1='" . Registry::get("Users")->uid . "'" 
		  . "\n AND users.id=m1.user2) OR (m1.user2='" . Registry::get("Users")->uid . "'" 
		  . "\n AND users.id=m1.user1))" 
		  . "\n AND m1.uid2='1'" 
		  . "\n AND m2.uid1=m1.uid1" 
		  . "\n GROUP BY m1.uid1" 
		  . "\n ORDER BY m1.created DESC" . $pager->limit;
		  $row = self::$db->fetch_all($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::processMessage()
	   * 
	   * @return
	   */
	  public function processMessage()
	  {
	
		  if (empty($_POST['recipient']))
			  Filter::$msgs['recipient'] = lang('MSG_RECEPIENT_R');
	
		  if (empty($_POST['msgsubject']))
			  Filter::$msgs['msgsubject'] = lang('MSG_MSGERR1');
	
		  if (empty($_POST['body']))
			  Filter::$msgs['body'] = lang('MSG_MSGERR2');
	
		  if (empty(Filter::$msgs)) {
			  if (Filter::$id and isset($_POST['update'])) {
				  $data = array(
					  'uid1' => Filter::$id,
					  'uid2' => intval($_POST['uid2']),
					  'msgsubject' => "",
					  'user1' => Registry::get("Users")->uid,
					  'user2' => 0,
					  'body' => $_POST['body'],
					  'created' => "NOW()",
					  'user1read' => "yes",
					  'user2read' => "no",
					  );
				  self::$db->insert("messages", $data);
	
				  $data2 = array('user' . intval($_POST['userp']) . 'read' => "no");
				  self::$db->update("messages", $data2, "uid1='" . Filter::$id . "' AND uid2 = '1'");

				  $sql = "SELECT email, CONCAT(fname,' ',lname) as clientname FROM users WHERE id = " . (int)$_POST['recipient'];
				  $row = self::$db->first($sql);

				  require_once (BASEPATH . "lib/class_mailer.php");
				  $mailer = $mail->sendMail();
				  $subject = lang('MSG_ESUBJECT') . cleanOut($_POST['msgsubject']);
		
				  ob_start();
				  require_once (BASEPATH . 'mailer/Reply_Message_From_Admin.tpl.php');
				  $html_message = ob_get_contents();
				  ob_end_clean();
		
				  $msg = Swift_Message::newInstance()
						->setSubject($subject)
						->setTo(array($row->email => $row->clientname))
						->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						->setBody($html_message, 'text/html');
		
				  $numSent = $mailer->send($msg);

			  } else {
				  $single = self::$db->first("SELECT COUNT(id) as recip, id as recipid, (SELECT COUNT(*) FROM messages) as newmsg FROM users where id='" . intval($_POST['recipient']) . "'");
				  $data = array(
					  'uid1' => intval($single->newmsg + 1),
					  'uid2' => 1,
					  'msgsubject' => sanitize($_POST['msgsubject']),
					  'user1' => Registry::get("Users")->uid,
					  'user2' => intval($single->recipid),
					  'body' => $_POST['body'],
					  'created' => "NOW()",
					  'user1read' => "yes",
					  'user2read' => "no",
					  );
					  
				  self::$db->insert("messages", $data);
				  
				  $sql = "SELECT email, CONCAT(fname,' ',lname) as clientname FROM users WHERE id = " . (int)$_POST['recipient'];
				  $row = self::$db->first($sql);

				  require_once (BASEPATH . "lib/class_mailer.php");
				  $mailer = $mail->sendMail();
				  $subject = lang('MSG_ESUBJECT') . cleanOut($_POST['msgsubject']);
		
				  ob_start();
				  require_once (BASEPATH . 'mailer/Reply_Message_From_Admin.tpl.php');
				  $html_message = ob_get_contents();
				  ob_end_clean();
		
				  $msg = Swift_Message::newInstance()
						->setSubject($subject)
						->setTo(array($row->email => $row->clientname))
						->setFrom(array(Registry::get("Core")->site_email => Registry::get("Core")->company))
						->setBody($html_message, 'text/html');
		
				  $numSent = $mailer->send($msg);

			  }
			  
			  (self::$db->affected()) ? Filter::msgOk(lang('MSG_SENTOK')) : Filter::msgAlert(lang('NOPROCCESS'));

		  } else
			  print Filter::msgStatus();
	  }

      /**
       * Content::renderMessages()
       * 
       * @return
       */
      public function renderMessages()
      {
		  $sql = "SELECT m.created, m.body, m.attachment, u.id as userid, u.username" 
		  . "\n FROM messages as m, users AS u"
		  . "\n WHERE m.uid1='" . Filter::$id. "'" 
		  . "\n AND u.id=m.user1" 
		  . "\n ORDER BY m.uid2";
          $row = self::$db->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Content::getMessageById()
       * 
       * @return
       */
      public function getMessageById()
      {
		  
		  $sql = "SELECT msgsubject, user1, user2 FROM messages WHERE uid1='" . Filter::$id . "' AND uid2=1";
          $row = self::$db->first($sql);

          return ($row) ? $row : Filter::error("You have selected an Invalid Id","Content::getMessageById()");
      }
	  
	  /**
	   * Content::updateMessageStatus()
	   * 
	   * @param int $user_id
	   * @return
	   */
	  public function updateMessageStatus($user_id)
	  {
		  if ($user_id == Registry::get("Users")->uid) {
			  $data['user1read'] = "yes";
			  self::$db->update("messages", $data, "uid1='" . Filter::$id . "' AND uid2 = '1'");
			  return 2;
		  } else {
			  $data['user2read'] = "yes";
			  self::$db->update("messages", $data, "uid1='" . Filter::$id . "' AND uid2 = '1'");
			  return 1;
		  }
	  }
	  
	  /**
	   * Content::progressBarStatus()
	   * 
	   * @param mixed $number
	   * @return
	   */
	  public function progressBarStatus($number)
	  {
		  return ($number == 0) ? lang('NOTSTARTED') : '<div class="progress-bar ui-progressbar ui-widget ui-widget-content"><div class="inner-green ui-corner-left" style="width:' . $number . '%;">' . $number . '%&nbsp;&nbsp;</div></div>';
	  }

	  /**
	   * Content::progressBarBilling()
	   * 
	   * @param mixed $paid
	   * @param mixed $total
	   * @return
	   */
	  public function progressBarBilling($paid, $total)
	  {
		  if($paid == -1) {
			  return lang('UNPAID');
		  } else {
			  if($total == 0) {
				 return '<div class="progress-bar ui-progressbar ui-widget ui-widget-content"><div class="inner-orange ui-corner-left">100%&nbsp;&nbsp;</div></div>';
			  } else {
				$percent = number_format(($paid * 100) / $total);
				return ($paid == 0) ? lang('NOTBILLED') : '<div class="progress-bar ui-progressbar ui-widget ui-widget-content"><div class="inner-orange ui-corner-left" style="width:' . $percent . '%;">' . $percent . '%&nbsp;&nbsp;</div></div>';
			  }
		  }
	  }

	  /**
	   * Content::progressBarRecurring()
	   * 
	   * @return
	   */
	  public function progressBarRecurring()
	  {
		  return '<div class="progress-bar ui-progressbar ui-widget ui-widget-content"><div class="inner-black ui-corner-left">' . lang('INVC_RECURRING_PAY') . '</div></div>';
		  
	  }
	  
	  /**
	   * Content::invoiceStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function invoiceStatusList($selected = '')
	  {
		  $arr = array('Paid' => lang('PAID'), 'Unpaid' => lang('UNPAID'), 'Overdue' => lang('OVERDUE'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::billingStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function billingStatusList($selected = '')
	  {
		  $arr = array('Not Yet Billed' => lang('NOTBILLED'), 'Paid' => lang('PAID'), 'Unpaid' => lang('UNPAID'), 'Overdue' => lang('OVERDUE'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::projectStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function projectStatusList($selected = '')
	  {
		  $arr = array('Not Yet Started' => lang('NOTSTARTED'), 'In Progress' => lang('INPROGRESS'), 'Completed' => lang('COMPLETED'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::projectSubmissionList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function projectSubmissionList($selected = '')
	  {
		  $arr = array('New Concept' => lang('NEW_CONCEPT'), 'Revision' => lang('REVISION'), 'Draft' => lang('DRAFT'), 'Final' => lang('FINAL'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::ticketPriorityList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function ticketPriorityList($selected = '')
	  {
		  $arr = array('High' => lang('HIGH'), 'Medium' => lang('MEDIUM'), 'Low' => lang('LOW'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::renderTicketPriorityList()
	   * 
	   * @param string $attr
	   * @return
	   */
	  public static function renderTicketPriorityList($attr)
	  {
		  switch ($attr) {
			  case 'High':
			  return lang('HIGH');
			  
			  case 'Medium':
			  return lang('MEDIUM');

			  case 'Low':
			  return lang('LOW');
		  }

	  }
	  
	  /**
	   * Content::ticketStatusList()
	   * 
	   * @param string $selected
	   * @return
	   */
	  public function ticketStatusList($selected = '')
	  {
		  $arr = array('Open' => lang('OPEN'), 'Pending' => lang('PENDING'), 'Closed' => lang('CLOSED'));

		  $list = '';
		  foreach ($arr as $key => $val) {
			  $sel = ($key == $selected) ? ' selected="selected"' : '';
			  $list .= "<option value=\"" . $key . "\"" . $sel . ">" . $val . "</option>\n";
		  }
		  unset($val);
		  return $list;
	  }

	  /**
	   * Content::renderTicketStatusList()
	   * 
	   * @param string $attr
	   * @return
	   */
	  public static function renderTicketStatusList($attr)
	  {
		  switch ($attr) {
			  case 'Open':
			  return lang('OPEN');

			  case 'Pending':
			  return lang('PENDING');
			  
			  case 'Closed':
			  return lang('CLOSED');
		  }

	  }

	  /**
	   * Content::submissionStatus()
	   * 
	   * @param string $attr
	   * @return
	   */
	  public static function submissionStatus($attr)
	  {
		  switch ($attr) {
			  case 0:
			  return lang('OPEN');

			  case 1:
			  return lang('FDASH_ACTION1');
			  
			  case 2:
			  return lang('CLOSED');
		  }

	  }
	  
	  /**
	   * Content::getAllInfo()
	   * 
	   * @param mixed $project_id
	   * @return
	   */
	  public function getAllInfo($project_id)
	  {
		  $sql = "SELECT p.id as pid, p.title, p.p_status, p.b_status, p.cost, u.id as uid, u.email," 
		  . "\n CONCAT(u.fname,' ',u.lname) as clientname," 
		  . "\n DATE_FORMAT(p.start_date, '" . Registry::get("Core")->short_date . "') as start," 
		  . "\n DATE_FORMAT(p.end_date, '" . Registry::get("Core")->short_date . "') as enddate," 
		  . "\n (SELECT CONCAT(fname,' ',lname) FROM users WHERE id = p.staff_id) as staffname" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN users as u ON u.id = p.client_id" 
		  . "\n WHERE p.id = '" . (int)$project_id . "'";
		  $row = self::$db->first($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getProjectsForClient()
	   * 
	   * @param mixed $user_id
	   * @return
	   */
	  public function getProjectsForClient($user_id)
	  {
		  $sql = "SELECT p.id as pid, p.title, p.p_status, p.b_status, p.cost, p.start_date," 
		  . "\n (SELECT CONCAT(fname,' ',lname) FROM users WHERE id = p.staff_id) as staffname, i.recurring" 
		  . "\n FROM projects as p" 
		  . "\n LEFT JOIN users as u ON u.id = p.client_id" 
		  . "\n LEFT JOIN invoices as i ON i.project_id = p.id" 
		  . "\n WHERE p.client_id = '" . (int)$user_id . "' GROUP BY p.id";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getInvoiceForClient()
	   * 
	   * @param mixed $user_id
	   * @return
	   */
	  public function getInvoiceForClient($user_id)
	  {
		  $sql = "SELECT *," 
		  . "\n DATE_FORMAT(created, '" . Registry::get("Core")->short_date . "') as start" 
		  . "\n FROM invoices" 
		  . "\n WHERE client_id = '" . (int)$user_id . "'";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getFormsList()
	   * 
	   * @return
	   */
	  public function getFormsList()
	  {
		  $sql = "SELECT id, title" 
		  . "\n FROM forms" 
		  . "\n WHERE active = 1";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Content::getEstimatorList()
	   * 
	   * @return
	   */
	  public function getEstimatorList()
	  {
		  $sql = "SELECT id, title" 
		  . "\n FROM estimator" 
		  . "\n WHERE active = 1";
		  $row = self::$db->fetch_all($sql);

		  return ($row) ? $row : 0;
	  }

      /**
       * Content::getCountryList()
       * 
       * @param bool $parent_id
       * @return
       */
      public function getCountryList($parent_id = false)
	  {	
          ($parent_id) ? $parent_id : 0;
		  
          $sql = "SELECT *"
		  ."\n FROM countries"
		  ."\n WHERE parent_id = '" . (int)$parent_id . "'"
		  ."\n ORDER BY name ASC";
         
		 $row = self::$db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Content::renderMessages()
       * 
       * @return
       */
      public function getTitleById($table)
      {
		  $sql = "SELECT title FROM $table WHERE id = " . Filter::$id;
          $row = self::$db->first($sql);

          return ($row) ? $row->title : 0;
      }
	  
	  /**
	   * Content::getPaymentFilter()
	   * 
	   * @return
	   */
	  public function getPaymentFilter()
	  {
		  $arr = array(
				'project_id-ASC' => lang('PROJ_NAME') . ' &uarr;', 
				'project_id-DESC' => lang('PROJ_NAME') . ' &darr;', 
				'invoice_id-ASC' => lang('INVC_NAME') . ' &uarr;', 
				'invoice_id-DESC' => lang('INVC_NAME') . ' &darr;', 
				'method-ASC' => lang('PAYMETHOD') . ' &uarr;', 
				'method-DESC' => lang('PAYMETHOD') . ' &darr;', 
				'amount-ASC' => lang('TRANS_PAYAMOUNT') . ' &uarr;', 
				'amount-DESC' => lang('TRANS_PAYAMOUNT') . ' &darr;', 
				'created-ASC' => lang('TRANS_PAYDATE') . ' &uarr;', 
				'created-DESC' => lang('TRANS_PAYDATE') . ' &darr;'
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

	  /**
	   * Content::getTicketFilter()
	   * 
	   * @return
	   */
	  public function getTicketFilter()
	  {
		  $arr = array(
				'staff_id-ASC' => lang('SUP_STAFF') . ' &uarr;', 
				'staff_id-DESC' => lang('SUP_STAFF') . ' &darr;', 
				'client_id-ASC' => lang('INVC_CNAME') . ' &uarr;', 
				'client_id-DESC' => lang('INVC_CNAME') . ' &darr;', 
				'priority-ASC' => lang('SUP_PRIORITY1') . ' &uarr;', 
				'priority-DESC' => lang('SUP_PRIORITY1') . ' &darr;', 
				'status-ASC' => lang('SUP_STATUS') . ' &uarr;', 
				'status-DESC' => lang('SUP_STATUS') . ' &darr;', 
				'created-ASC' => lang('SUP_CREATED') . ' &uarr;', 
				'created-DESC' => lang('SUP_CREATED') . ' &darr;'
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

	  /**
	   * Content::getMessageFilter()
	   * 
	   * @return
	   */
	  public function getMessageFilter()
	  {
		  $arr = array(
				'sender-ASC' => lang('MSG_SENDER').' &uarr;', 
				'sender-DESC' => lang('MSG_SENDER').' &darr;', 
				'status_r-ASC' => lang('MSG_STATUS').' &uarr;', 
				'status_r-DESC' => lang('MSG_STATUS').' &darr;', 
				'created-ASC' => lang('MSG_DATESENT').' &uarr;', 
				'created-DESC' => lang('MSG_DATESENT').' &darr;'
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
	  
	  /**
	   * Content::projectSubmissionStatus()
	   * 
	   * @param mixed $status
	   * @return
	   */
	  public function projectSubmissionStatus($status)
	  {
		  switch ($status) {
			  case 0:
				  return '<span class="label2 label-inverse">' . lang('SUBS_STATUS1') . '</span>';
				  break;

			  case 1:
				  return '<span class="label2 label-warning">' . lang('SUBS_STATUS2') . '</span>';
				  break;

			  case 2:
				  return '<span class="label2 label-success">' . lang('SUBS_STATUS3') . '</span>';
				  break;
				  
			  case 3:
				  return '<span class="label2 label-important">' . lang('SUBS_STATUS4') . '</span>';
				  break;
		  }

	  }
	  
  }
?>