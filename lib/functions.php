<?php
  if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  /**
   * redirect_to()
   * 
   * @param mixed $location
   * @return
   */
  function redirect_to($location)
  {
      if (!headers_sent()) {
          header('Location: ' . $location);
		  exit;
	  } else
          echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
  }
  
  /**
   * countEntries()
   * 
   * @param mixed $table
   * @param string $where
   * @param string $what
   * @return
   */
  function countEntries($table, $where = '', $what = '')
  {
      if (!empty($where) && isset($what)) {
          $q = "SELECT COUNT(*) FROM " . $table . "  WHERE " . $where . " = '" . $what . "' LIMIT 1";
      } else
          $q = "SELECT COUNT(*) FROM " . $table . " LIMIT 1";
      
      $record = Registry::get("Database")->query($q);
      $total = Registry::get("Database")->fetchrow($record);
      return $total[0];
  }
  
  /**
   * getChecked()
   * 
   * @param mixed $row
   * @param mixed $status
   * @return
   */
  function getChecked($row, $status)
  {
      if ($row == $status) {
          echo "checked=\"checked\"";
      }
  }
  
  /**
   * post()
   * 
   * @param mixed $var
   * @return
   */
  function post($var)
  {
      if (isset($_POST[$var]))
          return $_POST[$var];
  }
  
  /**
   * get()
   * 
   * @param mixed $var
   * @return
   */
  function get($var)
  {
      if (isset($_GET[$var]))
          return $_GET[$var];
  }
  
  /**
   * sanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function sanitize($string, $trim = false, $int = false, $str = false)
  {
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim)
          $string = substr($string, 0, $trim);
      if ($int)
		  $string = preg_replace("/[^0-9\s]/", "", $string);
      if ($str)
		  $string = preg_replace("/[^a-zA-Z\s]/", "", $string);
		  
      return $string;
  }

  /**
   * cleanSanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function cleanSanitize($string, $trim = false,  $end_char = '&#8230;')
  {
	  $string = cleanOut($string);
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim) {
        if (strlen($string) < $trim)
        {
            return $string;
        }

        $string = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $string));

        if (strlen($string) <= $trim)
        {
            return $string;
        }

        $out = "";
        foreach (explode(' ', trim($string)) as $val)
        {
            $out .= $val.' ';

            if (strlen($out) >= $trim)
            {
                $out = trim($out);
                return (strlen($out) == strlen($string)) ? $out : $out.$end_char;
            }       
        }
	  }
      return $string;
  }

  /**
   * truncate()
   * 
   * @param mixed $string
   * @param mixed $length
   * @param bool $ellipsis
   * @return
   */
  function truncate($string, $length, $ellipsis = true)
  {
      $wide = strlen(preg_replace('/[^A-Z0-9_@#%$&]/', '', $string));
      $length = round($length - $wide * 0.2);
      $clean_string = preg_replace('/&[^;]+;/', '-', $string);
      if (strlen($clean_string) <= $length)
          return $string;
      $difference = $length - strlen($clean_string);
      $result = substr($string, 0, $difference);
      if ($result != $string and $ellipsis) {
          $result = add_ellipsis($result);
      }
      return $result;
  }

  /**
   * add_ellipsis()
   * 
   * @param mixed $string
   * @return
   */
  function add_ellipsis($string)
  {
      $string = substr($string, 0, strlen($string) - 3);
      return trim(preg_replace('/ .{1,3}$/', '', $string)) . '...';
  }


  /**
   * getValue()
   * 
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
   * @return
   */
  function getValue($what, $table, $where)
  {
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  }  

  /**
   * getValueById()
   * 
   * @param mixed $what
   * @param mixed $table
   * @param mixed $id
   * @return
   */
  function getValueById($what, $table, $id)
  {
      $sql = "SELECT $what FROM $table WHERE id = $id";
      $row = Registry::get("Database")->first($sql);
      return ($row) ? $row->$what : '';
  } 
  
  /**
   * tooltip()
   * 
   * @param mixed $tip
   * @return
   */
  function tooltip($tip)
  {
      return '<i class="icon-info-sign tooltip" data-title="' . $tip . '" style="margin-left:5px"></i>';
  }
  
  /**
   * required()
   * 
   * @return
   */
  function required()
  {
      return '<img src="' . SITEURL . '/images/required.png" alt="Required Field" class="tooltip" title="Required Field" />';
  }


  /**
   * getSize()
   * 
   * @param mixed $size
   * @param integer $precision
   * @param bool $long_name
   * @param bool $real_size
   * @return
   */
  function getSize($size, $precision = 2, $long_name = false, $real_size = true)
  {
      if ($size == 0) {
          return '-/-';
      } else {
          $base = $real_size ? 1024 : 1000;
          $pos = 0;
          while ($size > $base) {
              $size /= $base;
              $pos++;
          }
          $prefix = _getSizePrefix($pos);
          $size_name = $long_name ? $prefix . "bytes" : $prefix[0] . 'B';
          return round($size, $precision) . ' ' . ucfirst($size_name);


      }
  }

  /**
   * _getSizePrefix()
   * 
   * @param mixed $pos
   * @return
   */  
  function _getSizePrefix($pos)
  {
      switch ($pos) {
          case 00:
              return "";
          case 01:
              return "kilo";
          case 02:
              return "mega";
          case 03:
              return "giga";
          default:
              return "?-";
      }
  }
    
  /**
   * stripTags()
   * 
   * @param mixed $start
   * @param mixed $end
   * @param mixed $string
   * @return
   */
  function stripTags($start, $end, $string)
  {
	  $string = stristr($string, $start);
	  $doend = stristr($string, $end);
	  return substr($string, strlen($start), -strlen($doend));
  }

  /**
   * cleanOut()
   * 
   * @param mixed $text
   * @return
   */
  function cleanOut($text) {
	 $text =  strtr($text, array('\r\n' => "", '\r' => "", '\n' => ""));
	 $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	 $text = str_replace('<br>', '<br />', $text);
	 return stripslashes($text);
  }
    
  /**
   * isActive()
   * 
   * @param mixed $id
   * @return
   */
  function isActive($id)
  {
	  if ($id == 1) {
		  $display = '<img src="images/yes.png" alt="" class="tooltip" title="Published"/>';
	  } else {
		  $display = '<img src="images/no.png" alt="" class="tooltip" title="Unpublished"/>';
	  }

      return $display;;
  }
  /**
   * getTemplates()
   * 
   * @param mixed $dir
   * @param mixed $site
   * @return
   */
  function getTemplates($dir, $site)
  {
      $getDir = dir($dir);
      while (false !== ($templDir = $getDir->read())) {
          if ($templDir != "." && $templDir != ".." && $templDir != "index.php") {
              $selected = ($site == $templDir) ? " selected=\"selected\"" : "";
              echo "<option value=\"{$templDir}\"{$selected}>{$templDir}</option>\n";
          }
      }
      $getDir->close();
  }
  /**
   * randName()
   * 
   * @param chars
   * @return
   */ 
  function randName($char = 6) {
	  $code = '';
	  for($x = 0; $x<$char; $x++) {
		  $code .= '-'.substr(strtoupper(sha1(rand(0,999999999999999))),2,$char);
	  }
	  $code = substr($code,1);
	  return $code;
  }
?>