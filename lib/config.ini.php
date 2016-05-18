<?php 
	/** 
	* Configuration

	* @package Exam Board
	* @author aladinsoft.com
	* @copyright 2014
	* @version Id: config.ini.php
	*/
 
	 if (!defined("_VALID_PHP")) 
     die('Direct access to this location is not allowed.');
 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_SERVER', 'localhost'); 
	 define('DB_USER', 'root'); 
	 define('DB_PASS', ''); 
	 define('DB_DATABASE', 'wp_exam');
 
	/** 
	* Show MySql Errors. 
	* Not recomended for live site. true/false 
	*/
	 define('DEBUG', false);
?>