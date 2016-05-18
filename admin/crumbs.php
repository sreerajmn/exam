<?php

  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  switch (Filter::$do) {
      case "users";

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-user"></i> ' . lang('STAFF_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-user"></i> ' . lang('STAFF_TITLE1');
                  break;
              case "view":
                  echo '<i class="icon-user"></i> ' . lang('STAFF_TITLE3');
                  break;
              default:
                  echo '<i class="icon-user"></i> ' . lang('STAFF_TITLE2');
                  break;
          }

          break;


      case "clients":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-group"></i> ' . lang('CLIENT_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-group"></i> ' . lang('CLIENT_TITLE1');
                  break;
              default:
                  echo '<i class="icon-group"></i> ' . lang('CLIENT_TITLE2');
                  break;
          }


          break;
		  
		  
	  case "courses":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-copy"></i> Manage Courses <i class="icon-angle-right"></i> Editing Courses';
                  break;
              case "add":
                  echo '<i class="icon-copy"></i> Manage Courses <i class="icon-angle-right"></i> Ad New Course';
                  break;
              default:
                  echo '<i class="icon-copy"></i> Manage Courses <i class="icon-angle-right"></i> Courses Overview';
                  break;
          }
      break;
	  
	  case "exams":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-exams"></i> Manage Exams <i class="icon-angle-right"></i> Editing Exam';
                  break;
              case "add":
                  echo '<i class="icon-exams"></i> Manage Exams <i class="icon-angle-right"></i> Ad New Exam';
                  break;
              default:
                  echo '<i class="icon-exams"></i> Manage Exams <i class="icon-angle-right"></i> Exams Overview';
                  break;
          }
      break;

	  case "questions":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-ques"></i> Manage Questions <i class="icon-angle-right"></i> Editing Question';
                  break;
              case "add":
                  echo '<i class="icon-ques"></i> Manage Questions <i class="icon-angle-right"></i> Ad New Question';
                  break;
              default:
                  echo '<i class="icon-ques"></i> Manage Questions <i class="icon-angle-right"></i> Questions Overview';
                  break;
          }
      break;

	  case "categories":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-category"></i> Resource Category <i class="icon-angle-right"></i> Editing Category';
                  break;
              case "add":
                  echo '<i class="icon-category"></i> Resource Category <i class="icon-angle-right"></i> Ad New Category';
                  break;
              default:
                  echo '<i class="icon-category"></i> Resource Category <i class="icon-angle-right"></i> Categories Overview';
                  break;
          }
      break;

	  case "resources":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-resource"></i> Resource Items <i class="icon-angle-right"></i> Editing Resource Item';
                  break;
              case "add":
                  echo '<i class="icon-resource"></i> Resource Items <i class="icon-angle-right"></i> Ad Resource Item';
                  break;
              default:
                  echo '<i class="icon-resource"></i> Resource Items <i class="icon-angle-right"></i> Resource Items Overview';
                  break;
          }
      break;
	  
	  
	  case "faqs":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-faq"></i> Manage FAQs <i class="icon-angle-right"></i> Editing FAQ Item';
                  break;
              case "add":
                  echo '<i class="icon-faq"></i> Manage FAQs <i class="icon-angle-right"></i> Ad New FAQ Item';
                  break;
              default:
                  echo '<i class="icon-faq"></i> Manage FAQs <i class="icon-angle-right"></i> FAQ Items Overview';
                  break;
          }
      break;

	  case "results":

         echo '<i class="icon-result"></i> Manage result';
		 
      break;

	  case "enrolment":

         echo '<i class="icon-enrol"></i> Manage Enrolment';
		 
      break;

      case "config":

      default:
          echo '<i class="icon-config"></i> ' . lang('CONF_TITLE');
          break;

      case "backup":

      default:
          echo '<i class="icon-database"></i> ' . lang('DB_TITLE');
          break;

      case "gateways":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-payment"></i> ' . lang('GATE_TITLE');
                  break;
              default:
                  echo '<i class="icon-payment"></i> ' . lang('GATE_TITLE1');
                  break;
          }


          break;

      case "fields":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-th-list"></i> ' . lang('CUSF_TITLE1');
                  break;
              case "add":
                  echo '<i class="icon-th-list"></i> ' . lang('CUSF_TITLE2');
                  break;
              default:
                  echo '<i class="icon-th-list"></i> ' . lang('CUSF_TITLE');
                  break;
          }


          break;

      case "forms":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE1');
                  break;
              case "view":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE4');
                  break;
              case "viewdata":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE3');
                  break;
              case "fields":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE2');
                  break;
              default:
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE4');
                  break;
          }

          break;

      case "estimator":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-th-list"></i> ' . lang('ESTM_TITLE1');
                  break;
              case "fields":
                  echo '<i class="icon-th-list"></i> ' . lang('ESTM_TITLE3');
                  break;
              case "view":
                  echo '<i class="icon-th-list"></i> ' . lang('ESTM_TITLE2');
                  break;
              case "viewdata":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE4');
                  break;
              case "transaction":
                  echo '<i class="icon-th-list"></i> ' . lang('FORM_TITLE5');
                  break;
              default:
                  echo '<i class="icon-th-list"></i> ' . lang('ESTM_TITLE2');
                  break;
          }

          break;

      case "news":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-news"></i> ' . lang('NEWS_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-news"></i> ' . lang('NEWS_TITLE1');
                  break;
              default:
                  echo '<i class="icon-news"></i> ' . lang('NEWS_TITLE2');
                  break;
          }

          break;

      case "email":

      default:
          echo '<i class="icon-email"></i> ' . lang('MAIL_TITLE');
          break;

      case "timebilling":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-time"></i> ' . lang('BILL_TITLE1');
                  break;
              case "add":
                  echo '<i class="icon-time"></i> ' . lang('BILL_TITLE2');
                  break;
              case "view":
                  echo '<i class="icon-time"></i> ' . lang('BILL_TITLE');
                  break;
              default:
                  echo '<i class="icon-time"></i> ' . lang('BILL_TITLE3');
                  break;
          }

          break;

      case "invoices":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-bookmark"></i> ' . lang('INVC_TITLE');
                  break;
              case "editentry":
                  echo '<i class="icon-bookmark"></i> ' . lang('INVC_ENTRYTITLE2');
                  break;
              case "editrecord":
                  echo '<i class="icon-bookmark"></i> ' . lang('INVC_RECTITLE2');
                  break;
              case "add":
                  echo '<i class="icon-bookmark"></i> ' . lang('INVC_TITLE2');
                  break;
              default:
                  echo '<i class="icon-bookmark"></i> ' . lang('INVC_TITLE3');
                  break;
          }

          break;

      case "invstatus":

      default:
          echo '<i class="icon-suitcase"></i> ' . lang('INVC_TITLE4');
          break;

      case "quotes":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-book"></i> ' . lang('QUTS_TITLE2');
                  break;
              case "add":
                  echo '<i class="icon-book"></i> ' . lang('QUTS_TITLE3');
                  break;
              default:
                  echo '<i class="icon-book"></i> ' . lang('QUTS_TITLE');
                  break;
          }

          break;

      case "transactions":

      default:
          echo '<i class="icon-trans"></i> Manage Transactions';
          break;

      case "calendar":

      default:
          echo '<i class="icon-calendar"></i> ' . lang('CAL_TITLE');
          break;

      case "files":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-file-alt "></i> ' . lang('FILE_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-file-alt "></i> ' . lang('FILE_TITLE1');
                  break;
              default:
                  echo '<i class="icon-file-alt "></i> ' . lang('FILE_TITLE2');
                  break;
          }

          break;

      case "task_template":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-tasks"></i> ' . lang('TTASK_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-tasks"></i> ' . lang('TTASK_TITLE1');
                  break;
              default:
                  echo '<i class="icon-tasks"></i> ' . lang('TTASK_TITLE2');
                  break;
          }

          break;

      case "tasks":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-tasks"></i> ' . lang('TASK_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-tasks"></i> ' . lang('TASK_TITLE1');
                  break;
              default:
                  echo '<i class="icon-tasks"></i> ' . lang('TASK_TITLE2');
                  break;
          }

          break;

      case "types":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-ticket"></i> ' . lang('TYPE_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-ticket"></i> ' . lang('TYPE_TITLE1');
                  break;
              default:
                  echo '<i class="icon-ticket"></i> ' . lang('TYPE_TITLE2');
                  break;
          }

          break;

      case "projects":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-suitcase"></i> ' . lang('PROJ_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-suitcase"></i> ' . lang('PROJ_TITLE1');
                  break;
              case "details":
                  echo '<i class="icon-suitcase"></i> ' . lang('PROJ_TITLE2');
                  break;
              default:
                  echo '<i class="icon-suitcase"></i> ' . lang('PROJ_TITLE3');
                  break;
          }

          break;

      case "overview":

      default:
          echo '<i class="icon-suitcase"></i> ' . lang('OVER_TITLE');
          break;

      case "submissions":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-suitcase"></i> ' . lang('SUBS_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-suitcase"></i> ' . lang('SUBS_TITLE1');
                  break;
              default:
                  echo '<i class="icon-suitcase"></i> ' . lang('SUBS_TITLE2');
                  break;
          }

          break;

      case "support":

          switch (Filter::$action) {
              case "edit":
                  echo '<i class="icon-ticket"></i> ' . lang('SUP_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-ticket"></i> ' . lang('SUP_TITLE2');
                  break;
              default:
                  echo '<i class="icon-ticket"></i> ' . lang('SUP_TITLE1');
                  break;
          }

          break;

      case "messages":

          switch (Filter::$action) {
              case "view":
                  echo '<i class="icon-envelope-alt"></i> ' . lang('MSG_TITLE');
                  break;
              case "add":
                  echo '<i class="icon-envelope-alt"></i> ' . lang('MSG_TITLE1');
                  break;
              default:
                  echo '<i class="icon-envelope-alt"></i> ' . lang('MSG_TITLE2');
                  break;
          }

          break;

      default:
          if (file_exists(BASEPATH . 'plugins/' . Filter::$do . '/crumbs_admin.php')):
              include_once (BASEPATH . 'plugins/' . Filter::$do . '/crumbs_admin.php');
          else:
              echo '<i class="icon-ques"></i> ' . lang('DASH_TITLE');
          endif;

      break;
  }
?>