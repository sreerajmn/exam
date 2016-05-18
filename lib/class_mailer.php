<?php  
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Mailer
  {
      private $company;
      private $mailer;
	  private $sendmail;
      private $smtp_host;
      private $smtp_user;
      private $smtp_pass;
      private $smtp_port;
	  private $is_ssl;

      /**
       * Mailer::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->company = Registry::get("Core")->company;
          $this->mailer = Registry::get("Core")->mailer;
		  $this->sendmail = Registry::get("Core")->sendmail;
          $this->smtp_host = Registry::get("Core")->smtp_host;
          $this->smtp_user = Registry::get("Core")->smtp_user;
          $this->smtp_pass = Registry::get("Core")->smtp_pass;
          $this->smtp_port = Registry::get("Core")->smtp_port;
		  $this->is_ssl = Registry::get("Core")->is_ssl;
      }

      /**
       * Mailer::sendMail()
       * 
       * @return
       */
      public function sendMail()
      {
          require_once (BASEPATH . 'lib/swift/swift_required.php');

          if ($this->mailer == "SMTP") {
			  $SSL = ($this->is_ssl) ? 'ssl' : null;
              $transport = Swift_SmtpTransport::newInstance($this->smtp_host, $this->smtp_port, $SSL)
						  ->setUsername($this->smtp_user)
						  ->setPassword($this->smtp_pass);
		  } elseif ($this->mailer == "SMAIL") {
			  $transport = Swift_SendmailTransport::newInstance($this->sendmail);
          } else
              $transport = Swift_MailTransport::newInstance();
          
          return Swift_Mailer::newInstance($transport);
	  }

  }
  $mail = new Mailer();
?>