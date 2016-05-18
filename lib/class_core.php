<?php
  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Core
  {

      const sTable = "settings";
      public $year = null;
      public $month = null;
      public $day = null;
	  public $language;


      /**
       * Core::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->getSettings();
		  $this->getLanguage();

          ($this->dtz) ? date_default_timezone_set($this->dtz) : date_default_timezone_set('GMT');

          $this->year = (get('year')) ? get('year') : strftime('%Y');
          $this->month = (get('month')) ? get('month') : strftime('%m');
          $this->day = (get('day')) ? get('day') : strftime('%d');

          return mktime(0, 0, 0, $this->month, $this->day, $this->year);
      }


      /**
       * Core::getSettings()
       * 
       * @return
       */
      private function getSettings()
      {
          $sql = "SELECT * FROM " . self::sTable;
          $row = Registry::get("Database")->first($sql);

          $this->company = $row->company;
          $this->site_url = $row->site_url;
          $this->site_email = $row->site_email;
          $this->address = $row->address;
          $this->city = $row->city;
          $this->state = $row->state;
          $this->zip = $row->zip;
          $this->phone = $row->phone;
          $this->fax = $row->fax;
          $this->logo = $row->logo;
          $this->short_date = $row->short_date;
          $this->long_date = $row->long_date;
          $this->dtz = $row->dtz;
		  $this->lang  = $row->lang;
		  $this->weekstart  = $row->weekstart;
		  $this->theme  = $row->theme;
		  $this->enable_reg = $row->enable_reg;
          $this->enable_tax = $row->enable_tax;
          $this->tax_name = $row->tax_name;
          $this->tax_rate = $row->tax_rate;
		  $this->tax_number = $row->tax_number;
		  $this->enable_offline = $row->enable_offline;
		  $this->offline_info = $row->offline_info;
		  $this->invoice_note = $row->invoice_note;
		  $this->invoice_number = $row->invoice_number;
		  $this->quote_number = $row->quote_number;
          $this->enable_uploads = $row->enable_uploads;
          $this->file_types = $row->file_types;
          $this->file_max = $row->file_max;
          $this->perpage = $row->perpage;
          $this->sbackup = $row->sbackup;
          $this->currency = $row->currency;
          $this->cur_symbol = $row->cur_symbol;
		  $this->tsep = $row->tsep;
		  $this->dsep = $row->dsep;
		  $this->pp_email = $row->pp_email;
		  $this->pp_pass = $row->pp_pass;
		  $this->pp_api = $row->pp_api;
		  $this->pp_mode = $row->pp_mode;
		  $this->invdays = $row->invdays;
          $this->mailer = $row->mailer;
          $this->smtp_host = $row->smtp_host;
          $this->smtp_user = $row->smtp_user;
          $this->smtp_pass = $row->smtp_pass;
          $this->smtp_port = $row->smtp_port;
		  $this->sendmail = $row->sendmail;
		  $this->is_ssl = $row->is_ssl;

          $this->crmv = $row->crmv;
		  
		  $this->google_analytics = $row->google_analytics;
		  $this->passing_score = $row->passing_score;
		  $this->social_gplus = $row->social_gplus;
		  $this->social_facebook = $row->social_facebook;
		  $this->social_twitter = $row->social_twitter;
		  $this->social_pinterest = $row->social_pinterest;
		  $this->social_linkedin = $row->social_linkedin;
		  $this->social_rss = $row->social_rss;
      }

      /**
       * Core::processConfig()
       * 
       * @return
       */
      public function processConfig()
      {
          if (empty($_POST['company']))
              Filter::$msgs['company'] = lang('CONF_COMPANY_R');

          if (empty($_POST['site_url']))
              Filter::$msgs['site_url'] = lang('CONF_URL_R');

          if (empty($_POST['site_email']))
              Filter::$msgs['site_email'] = lang('CONF_EMAIL_R');

          if (empty($_POST['currency']))
              Filter::$msgs['currency'] = lang('CONF_CURRENCY_R');

          switch($_POST['mailer']) {
			  case "SMTP" :
				  if (empty($_POST['smtp_host']))
					  Filter::$msgs['smtp_host'] = lang('CONF_SMTP_HOST_R');
				  if (empty($_POST['smtp_user']))
					  Filter::$msgs['smtp_user'] = lang('CONF_SMTP_USER_R');
				  if (empty($_POST['smtp_pass']))
					  Filter::$msgs['smtp_pass'] = lang('CONF_SMTP_PASS_R');
				  if (empty($_POST['smtp_port']))
					  Filter::$msgs['smtp_port'] = lang('CONF_SMTP_PORT_R');
				  break;
			  
			  case "SMAIL" :
				  if (empty($_POST['sendmail']))
					  Filter::$msgs['sendmail'] = lang('CONF_SMAILPATH_R');
			  break;
		  }

          if (!empty($_FILES['logo']['name'])) {
              $file_info = getimagesize($_FILES['logo']['tmp_name']);
              if (empty($file_info))
                  Filter::$msgs['logo'] = lang('CONF_LOGO_R');
          }

          if (empty(Filter::$msgs)) {
              $data = array(
					  'company' => sanitize($_POST['company']),
					  'site_url' => sanitize($_POST['site_url']),
					  'site_email' => sanitize($_POST['site_email']),
					  'address' => sanitize($_POST['address']), 
					  'city' => sanitize($_POST['city']),
					  'state' => sanitize($_POST['state']),
					  'zip' => sanitize($_POST['zip']),
					  'phone' => sanitize($_POST['phone']),
					  'fax' => sanitize($_POST['fax']),
					  'short_date' => sanitize($_POST['short_date']),
					  'long_date' => sanitize($_POST['long_date']),
					  'dtz' => trim($_POST['dtz']),
					  //'weekstart' => intval($_POST['weekstart']),
					  'theme' => sanitize($_POST['theme']),
					  'lang' => sanitize($_POST['lang']),
					  'enable_reg' => intval($_POST['enable_reg']),
					  //'enable_tax' => intval($_POST['enable_tax']),
					  //'tax_name' => sanitize($_POST['tax_name']),
					  //'tax_rate' => sanitize($_POST['tax_rate']) / 100,
					  //'tax_number' => sanitize($_POST['tax_number']),
					  'enable_offline' => intval($_POST['enable_offline']),
					  'offline_info' => $_POST['offline_info'],
					  'invoice_note' => $_POST['invoice_note'],
					  'invoice_number' => sanitize($_POST['invoice_number']),
					  'quote_number' => sanitize($_POST['quote_number']),
					  //'enable_uploads' => intval($_POST['enable_uploads']),
					  //'file_types' => trim($_POST['file_types']),
					  //'file_max' => intval($_POST['file_max']*1048576),		  
					  'perpage' => intval($_POST['perpage']),
					  'currency' => sanitize($_POST['currency']),
					  'cur_symbol' => sanitize($_POST['cur_symbol']),
					  'tsep' => empty($_POST['tsep']) ? "," : sanitize($_POST['tsep']),
					  'dsep' => empty($_POST['dsep']) ? "." : sanitize($_POST['dsep']),
					  'invdays' => sanitize($_POST['invdays']),  
					  //'pp_email' => sanitize($_POST['pp_email']), 
					  //'pp_pass' => sanitize($_POST['pp_pass']), 
					  //'pp_api' => sanitize($_POST['pp_api']), 
					  'pp_mode' => intval($_POST['pp_mode']), 
					  'mailer' => sanitize($_POST['mailer']),
					  'sendmail' => sanitize($_POST['sendmail']),
					  'smtp_host' => sanitize($_POST['smtp_host']),
					  'smtp_user' => sanitize($_POST['smtp_user']),
					  'smtp_pass' => sanitize($_POST['smtp_pass']),
					  'smtp_port' => intval($_POST['smtp_port']),
					  'is_ssl' => intval($_POST['is_ssl']),
					  'google_analytics' => $_POST['google_analytics'],
					  'passing_score' => sanitize($_POST['passing_score']),
					  'social_gplus' => sanitize($_POST['social_gplus']),
					  'social_facebook' => sanitize($_POST['social_facebook']),
					  'social_twitter' => sanitize($_POST['social_twitter']),
					  'social_pinterest' => sanitize($_POST['social_pinterest']),
					  'social_linkedin' => sanitize($_POST['social_linkedin']),
					  'social_rss' => sanitize($_POST['social_rss'])
				  );

			  if (isset($_POST['dellogo']) and $_POST['dellogo'] == 1) {
				  $data['logo'] = "NULL";
			  } elseif (!empty($_FILES['logo']['name'])) {
				  if ($this->logo) {
					  @unlink(UPLOADS . $this->logo);
				  }
					  move_uploaded_file($_FILES['logo']['tmp_name'], UPLOADS.$_FILES['logo']['name']);

				  $data['logo'] = sanitize($_FILES['logo']['name']);
			  } else {
				$data['logo'] = $this->logo;
			  }
			  
              Registry::get("Database")->update(self::sTable, $data);
              (Registry::get("Database")->affected()) ? Filter::msgOk(lang('CONF_UPDATED')) : Filter::msgAlert(lang('NOPROCCESS'));
          } else
              print Filter::msgStatus();
      }

	  /**
	   * Core:::getLanguage()
	   * 
	   * @return
	   */
	  private function getLanguage()
	  {
		  $this->langdir = BASEPATH . "lang/";
		  
		  if (isset($_COOKIE['LANG_FM_'])) {
			  $sel_lang = sanitize($_COOKIE['LANG_FM_'], 2);
			  $vlang = $this->fetchLanguage();
			  if(in_array($sel_lang, $vlang)) {
				  $this->language = $sel_lang;
			  } else {
				  $this->language = $this->lang;
			  }
			  if (file_exists($this->langdir . $this->language . ".lang.php")) {
				  include($this->langdir . $this->language . ".lang.php");
			  } else {
				  include($this->langdir . $this->lang . ".lang.php");
			  }
		  } else {
			  $this->language = $this->lang;
			  include($this->langdir . $this->lang . ".lang.php");
		  }
	  }
	  
      /**
       * Core::fetchLanguage()
       * 
       * @return
       */
	  public function fetchLanguage()
	  {
		  if (!is_dir(BASEPATH . 'lang/')) {
			  return false;
		  } else {
			  $lang_array = array();
			  $ext = array('html','png');
			  if ($handle = opendir(BASEPATH . 'lang/')) {
				  while (false !== ($file = readdir($handle))) {
					  if ($file != "." && $file != ".." && !in_array(pathinfo($file, PATHINFO_EXTENSION), $ext)) {
						  $lang_array[] = substr($file, 0, 2);
					  }
				  }
				  closedir($handle);
			  }
			  return $lang_array;
		  }
	  }

      /**
       * Core::fetchPluginInfo()
       * 
       * @return
       */
	  public static function fetchPluginInfo()
	  {
		  if (!is_dir(BASEPATH . 'plugins/')) {
			  return false;
		  } else {
			  $options = glob("" . BASEPATH . "plugins/*.xml");
			  $data = array();
			  if ($options) {
				  foreach ($options as $val) {
					  $data[] = simplexml_load_file($val);
				  }
			  }
			  return $data;
		  }
	  }
	  
      /**
       * Core::getPluginLanguage()
       * 
       * @return
       */
      public function getPluginLanguage($plugname)
      {
		  return (file_exists(BASEPATH . "plugins/" . $plugname . "/lang/" . $this->lang . "lang.php")) ? BASEPATH . "plugins/" . $plugname . "/lang/" . $this->lang . "lang.php" : BASEPATH . "plugins/" . $plugname . "/lang/en.lang.php";
      }
	  	  
      /**
       * Core::getShortDate()
       * 
       * @return
       */
      public function getShortDate()
      {
          $arr = array(
				 '%m-%d-%Y' => '12-21-2009 (MM-DD-YYYY)',
				 '%e-%m-%Y' => '21-12-2009 (D-MM-YYYY)',
				 '%m-%e-%y' => '12-21-09 (MM-D-YY)',
				 '%e-%m-%y' => '21-12-09 (D-MM-YY)',
				 '%b %d %Y' => 'Dec 21 2009'
		  );

          $shortdate = '';
          foreach ($arr as $key => $val) {
              if ($key == $this->short_date) {
                  $shortdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $shortdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $shortdate;
      }


      /**
       * Core::getLongDate()
       * 
       * @return
       */
      public function getLongDate()
      {
          $arr = array(
				'%B %d, %Y' => 'December 21, 2009',
				'%d %B %Y %H:%M' => '21 December 2009 19:00',
				'%B %d, %Y %I:%M %p' => 'December 21, 2009 4:00 am',
				'%A %d %B, %Y' => 'Monday 21 December, 2009',
				'%A %d %B, %Y %H:%M' => 'Monday 21 December 2009 07:00',
				'%a %d, %B' => 'Mon. 12, December'
		  );

          $longdate = '';
          foreach ($arr as $key => $val) {
              if ($key == $this->long_date) {
                  $longdate .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $longdate .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
          return $longdate;
      }

      /**
       * Core::yearlyStats()
       * 
       * @return
       */
      public function yearlyStats()
      {
          $sql = "SELECT *, YEAR(created) as year, MONTH(created) as month," 
		  . "\n COUNT(id) as total, SUM(amount) as totalprice" 
		  . "\n FROM invoice_payments" 
		  . "\n WHERE YEAR(created) = '" . $this->year . "'" 
		  . "\n GROUP BY year DESC, month DESC ORDER by created";

          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Core::yearlyStatsServices()
       * 
       * @return
       */
      public function yearlyStatsServices()
      {
          $sql = "SELECT *, YEAR(created) as year, MONTH(created) as month," 
		  . "\n COUNT(id) as total, SUM(price) as totalprice" 
		  . "\n FROM payments" 
		  . "\n WHERE YEAR(created) = '" . $this->year . "'" 
		  . "\n GROUP BY year DESC, month DESC ORDER by created";

          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Core::getYearlySummary()
       * 
       * @return
       */
      public function getYearlySummary()
      {
          $sql = "SELECT YEAR(created) as year, MONTH(created) as month," 
		  . "\n COUNT(id) as total, SUM(amount) as totalprice" 
		  . "\n FROM invoice_payments" 
		  . "\n WHERE YEAR(created) = '" . $this->year . "' GROUP BY year";

          $row = Registry::get("Database")->first($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Core::getYearlySummaryServices()
       * 
       * @return
       */
      public function getYearlySummaryServices()
      {
          $sql = "SELECT YEAR(created) as year, MONTH(created) as month," 
		  . "\n COUNT(id) as total, SUM(price) as totalprice" 
		  . "\n FROM payments" 
		  . "\n WHERE YEAR(created) = '" . $this->year . "' GROUP BY year";

          $row = Registry::get("Database")->first($sql);

          return ($row) ? $row : 0;
      }
	  
      /**
       * Core::yearList()
       * 
       * @param mixed $start_year
       * @param mixed $end_year
       * @return
       */
      function yearList($start_year, $end_year)
      {
          $selected = is_null(get('year')) ? date('Y') : get('year');
          $r = range($start_year, $end_year);

          $select = '';
          foreach ($r as $year) {
              $select .= "<option value=\"$year\"";
              $select .= ($year == $selected) ? ' selected="selected"' : '';
              $select .= ">$year</option>\n";
          }
          return $select;
      }


      /**
       * Core::monthList()
       * 
       * @return
       */
      public function monthList()
      {
          $selected = is_null(get('month')) ? strftime('%m') : get('month');

          $arr = array(
		          '01' => lang('JAN'), 
		          '02' => lang('FEB'), 
		          '03' => lang('MAR'), 
		          '04' => lang('APR'), 
		          '05' => lang('MAY'), 
		          '06' => lang('JUN'), 
		          '07' => lang('JUL'), 
		          '08' => lang('AUG'), 
		          '09' => lang('SEP'), 
		          '10' => lang('OCT'), 
		          '11' => lang('NOV'), 
		          '12' => lang('DEC')
          );

          $monthlist = '';
          foreach ($arr as $key => $val) {
              $monthlist .= "<option value=\"$key\"";
              $monthlist .= ($key == $selected) ? ' selected="selected"' : '';
              $monthlist .= ">$val</option>\n";
          }
          unset($val);
          return $monthlist;
      }

      /**
       * Core::weekList()
       * 
       * @return
       */
      public function weekList()
      {
          $arr = array(
		          '1' => lang('SUN'), 
		          '2' => lang('MON'), 
		          '3' => lang('TUE'), 
		          '4' => lang('WED'), 
		          '5' => lang('THU'), 
		          '6' => lang('FRI'), 
		          '7' => lang('SAT')
          );

          $weeklist = '';
          foreach ($arr as $key => $val) {
              $weeklist .= "<option value=\"$key\"";
              $weeklist .= ($key == $this->weekstart) ? ' selected="selected"' : '';
              $weeklist .= ">$val</option>\n";
          }
          unset($val);
          return $weeklist;
      }

	  
      /**
       * Core::projectStats()
       * 
       * @return
       */
      public function projectStats()
      {
		  $and = (Registry::get("Users")->userlevel == 5) ? "AND FIND_IN_SET(" . Registry::get("Users")->uid . ", staff_id)" : null;
		  
          $sql = "SELECT * FROM projects" 
		  . "\n WHERE p_status <> 100" 
		  . "\n $and" 
		  //. "\n AND YEAR(start_date) <> '" . $this->year . "'" 
		  . "\n ORDER by p_status DESC";

          $row = Registry::get("Database")->fetch_all($sql);

          return ($row) ? $row : 0;
      }

      /**
       * Core::progressBarBilling()
       * 
       * @param mixed $paid
       * @param mixed $total
       * @return
       */
      public function progressBarBilling($paid, $total)
      {
          $percent = number_format(($paid * 100) / $total);
          return $percent;
      }

      /**
       * Core::getTimezones()
       * 
       * @return
       */
      public function getTimezones()
      {
          $data = '';
          $tzone = DateTimeZone::listIdentifiers();
          foreach ($tzone as $zone) {
              $selected = ($zone == $this->dtz) ? ' selected="selected"' : '';
              $data .= '<option value="' . $zone . '"' . $selected . '>' . $zone . '</option>';
          }
          return $data;
      }

      /**
       * Core::formatMoney()
       * 
       * @param mixed $amount
       * @return
       */
      public function formatMoney($amount)
      {
		  return $this->cur_symbol . number_format($amount, 2, $this->dsep, $this->tsep) . $this->currency;
      }

      /**
       * Core::formatMoney()
       * 
       * @param mixed $amount
       * @return
       */
      public function formatClientCurrency($amount, $cur = '')
      {
		  $client_currency = ($cur !='') ? $cur : $this->currency;
		  return number_format($amount, 2, $this->dsep, $this->tsep) . $client_currency;
      }
	  
      /**
       * Core::getRowById()
       * 
       * @param mixed $table
       * @param mixed $id
       * @param bool $and
       * @param bool $is_admin
       * @return
       */
      public static function getRowById($table, $id, $and = false, $is_admin = true)
      {
          $id = sanitize($id, 8, true);
          if ($and) {
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "' AND " . Registry::get("Database")->escape($and) . "";
          } else
              $sql = "SELECT * FROM " . (string )$table . " WHERE id = '" . Registry::get("Database")->escape((int)$id) . "'";

          $row = Registry::get("Database")->first($sql);

          if ($row) {
              return $row;
          } else {
              if ($is_admin)
                  Filter::error("You have selected an Invalid Id - #" . $id, "Core::getRowById()");
          }
      }

      /**
       * Core::getPeriod()
       * 
       * @param bool $value
       * @return
       */
      public function getPeriod($value)
	  {
		  switch($value) {
			  case "D" :
			  return lang('INVC_REC_DAYS');
			  break;
			  case "W" :
			  return lang('INVC_REC_WEEKS');
			  break;
			  case "M" :
			  return lang('INVC_REC_MONTHS');
			  break;
			  case "Y" :
			  return lang('INVC_REC_YEARS');
			  break;
		  }

      }
	  
      /**
       * Core::countInvoices()
       * 
       * @return
       */
      public function countInvoices()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM invoices"
		  . "\n WHERE status = 'Unpaid' AND recurring = 0 AND onhold = 0";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }

      /**
       * Core::countProjects()
       * 
       * @return
       */
      public function countProjects()
      {
		  $access = (Registry::get("Users")->userlevel == 5) ? "AND FIND_IN_SET(" . Registry::get("Users")->uid . ", staff_id)" : "";
		  
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM projects"
		  . "\n WHERE p_status <> 100"
		  . "\n $access";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }

      /**
       * Core::countTasks()
       * 
       * @return
       */
      public function countTasks()
      {
		  $access = (Registry::get("Users")->userlevel == 5) ? "AND staff_id='" . Registry::get("Users")->uid . "'" : "";
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM tasks"
		  . "\n WHERE progress <> 100"
		  . "\n $access";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }

      /**
       * Core::countTickets()
       * 
       * @return
       */
      public function countTickets()
      {
		  $access = (Registry::get("Users")->userlevel == 5) ? "AND staff_id='" . Registry::get("Users")->uid . "'" : "";
		  
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM support_tickets"
		  . "\n WHERE status = 'Open'"
		  . "\n $access";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }
	  
	  public function countCourses()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM project_types";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }
	  
	  public function countTraffic()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM project_types";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }
	  
	  public function countExams()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM exams";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }
	  
	  public function countEnrol()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM enrollment"
		  . "\n WHERE banned = '0'";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }
	  
	  public function countQues()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM questions"
		  . "\n WHERE banned = '0'";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }
	  
	  public function countResources()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM resources";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }
	  
	  public function countFaqs()
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM faqs";
		  
		  $row = Registry::get("Database")->first($sql);  
		  return ($row) ? $row->total : 0;
      }

      /**
       * Core::countFrontTickets()
       * 
       * @return
       */
      public function countFrontTickets()
      {
		  $access = (Registry::get("Users")->userlevel == 1) ? "AND client_id='" . Registry::get("Users")->uid . "'" : "";
		  
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM support_tickets"
		  . "\n WHERE status = 'Open'"
		  . "\n $access";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }
      /**
       * Core::countMessages()
       * 
       * @return
       */
      public function countMessages()
      {
		  $sql = "SELECT COUNT(uid1) as total"
		  . "\n FROM messages"
		  . "\n WHERE (user1='" . Registry::get("Users")->uid . "' AND user1read='no')"
		  . "\n OR (user2='" . Registry::get("Users")->uid . "' AND user2read='no')"
		  . "\n AND uid2 = 1";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }
	  
      /**
       * Core::countUsers()
       * 
       * @return
       */
      public function countUsers($ul)
      {
		  $sql = "SELECT COUNT(id) as total"
		  . "\n FROM users"
		  . "\n WHERE userlevel = $ul";
		  $row = Registry::get("Database")->first($sql);
		  
		  return ($row) ? $row->total : 0;

      }

	  /**
	   * Core::_implode()
	   * 
	   * @param mixed $array
	   * @return
	   */
	  public static function _implode($array)
	  {
          if (is_array($array)) {
			  $result = array();
			  foreach ($array as $row) {
				  if ($row != '') {
					  array_push($result, sanitize($row));
				  }
			  }
			  return implode(',', $result);
          }
		  return false;
	  }

	  /**
	   * Core::_explode()
	   * 
	   * @param mixed $string
	   * @return
	   */
	  public static function _explode($string, $sep = ",")
	  {
		  $data = explode($sep, $string);
          if (count($data) >= 1) {
			  return $data;
          }
		  return false;
	  }
	  
      /**
       * Core::msgStatus()
       * 
       * @param mixed $user1
       * @param string $user2
       * @param string $user1read
       * @param string $user2read
       * @param string $uid2
       * @return
       */
      public function msgStatus($user1, $user2, $user1read, $user2read, $uid2)
      {

		  if (($user1 == Registry::get("Users")->uid  and $user1read=='no') or ($user2 == Registry::get("Users")->uid and $user2read == 'no') and $uid2 = 1)
		      return 'closed';

      }
	  	  
      /**
       * Core::doForm()
       * 
       * @param mixed $data
       * @param string $url
       * @param integer $reset
       * @param integer $clear
       * @param string $form_id
       * @param string $msgholder
       * @return
       */
      public static function doForm($data, $url = "controller.php", $reset = 0, $clear = 0, $form_id = "admin_form", $msgholder = "msgholder")
      {
          $display = '
		  <script type="text/javascript">
		  // <![CDATA[
			  $(document).ready(function () {
				  var options = {
					  target: "#' . $msgholder . '",
					  beforeSubmit:  showLoader,
					  success: showResponse,
					  url: "' . $url . '",
					  resetForm : ' . $reset . ',
					  clearForm : ' . $clear . ',
					  data: {
						  ' . $data . ': 1
					  }
				  };
				  $("#' . $form_id . '").ajaxForm(options);
			  });
			  function showResponse(msg) {
				  hideLoader();
				  $(this).html(msg);
				  $("html, body").animate({
					  scrollTop: 0
				  }, 600);
			  }
			  ';
          $display .= '
		  // ]]>
		  </script>';

          print $display;
      }


      /**
       * Core::doDelete()
       * 
       * @param mixed $title
       * @param mixed $varpost
       * @param string $url
       * @param string $attr
       * @param string $id
	   * @param string $extra
       * @return
       */
      public static function doDelete($title, $varpost, $url = 'controller.php', $attr = 'item_', $id = 'a.delete', $extra = false)
      {
          $display = "
		  <script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function () {
		      $('body').on('click', '" . $id . "', function () {
		          var id = $(this).attr('id').replace('" . $attr . "', '')
		          var parent = $(this).parent().parent().parent();
		          var name = $(this).attr('data-rel');
		          new Messi('<i class=\"icon-warning-sign icon-3x pull-left\"></i>" . lang('DELCONFIRM') . "', {
		              title: '" . $title . "',
		              titleClass: '',
		              modal: true,
		              closeButton: true,
		              buttons: [{
		                  id: 0,
		                  label: '" . lang('DELETE') . "',
		                  class: '',
		                  val: 'Y'
		              }],
		              callback: function (val) {
		                  if (val === 'Y') {
		                      $.ajax({
		                          type: 'post',
		                          url: '" . $url . "',
		                          data: {
									  '" . $varpost . "': id,
									  'title':encodeURIComponent(name)
									  " . $extra . "
								  },
		                          beforeSend: function () {
		                              parent.animate({
		                                  'backgroundColor': '#FFBFBF'
		                              }, 400);
		                          },
		                          success: function (msg) {
		                              parent.fadeOut(400, function () {
		                                  parent.remove();
		                              });
		                              $('html, body').animate({
		                                  scrollTop: 0
		                              }, 600);
		                              $('#msgholder').html(decodeURIComponent(msg));
		                          }
		                      });
		                  }
		              }

		          });
		      });
		  });
		  // ]]>
		  </script>";

          print $display;
      }
  }
?>