<?php

/**
 * MySQL API
 * (C) 2000-2015
 *
 * This script (phmysql.php) is based on:
 * V1.42 ADOdb Lite 11 January 2007 (C) 2005-2007 Mark Dickenson. Released LGPL.
 */
// Database connection info
define("PH_MYSQL_TIMEZONE", '+3:00');
define("PH_MYSQL_ERRORS", 'MySQL_Erros');
// Show SQL for debug
define("PH_DEBUG_ENABLED", TRUE); // TRUE to debug
if (PH_DEBUG_ENABLED) {
  @ini_set("display_errors", "1"); // Display errors
  error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE
}

/**
 * MySQL charset (for SET NAMES statement, not used by default)
 * Note: Read http://dev.mysql.com/doc/refman/5.0/en/charset-connection.html
 * before using this setting.
 */
define("PH_MYSQL_CHARSET", "utf8");

define('ADODB_FETCH_DEFAULT', 0);
define('ADODB_FETCH_NUM', 1);
define('ADODB_FETCH_ASSOC', 2);
define('ADODB_FETCH_BOTH', 3);
define('PH_USE_MYSQLI', TRUE && extension_loaded("mysqli"));

/**
 * ADOConnection
 */
class ADOConnection {

  var $connectionId = false;
  var $record_set = false;
  var $database;
  var $dbtype;
  var $dataProvider;
  var $host;
  var $open;
  var $password;
  var $username;
  var $persistent;
  var $debug = false;
  var $debug_console = false;
  var $debug_echo = true;
  var $debug_output;
  var $forcenewconnection = false;
  var $createdatabase = false;
  var $last_module_name;
  var $socket = false;
  var $port = false;
  var $clientFlags = 0;
  var $nameQuote = '"';
  var $sysDate = false; /// name of function that returns the current date
  var $sysTimeStamp = false; /// name of function that returns the current timestamp
  var $sql;
  var $raiseErrorFn = 'ph_ErrorFn'; // = false;
  var $query_count = 0;
  var $query_time_total = 0;
  var $query_list = array();
  var $query_list_time = array();
  var $query_list_errors = array();
  var $_logsql = false;

  function __construct() {

  }

  /**
   * Returns floating point version number of PhSoft
   * Usage: $db->Version();
   *
   * @access public
   */
  function Version() {
    global $PhSoft_vers;
    return (float) substr($PhSoft_vers, 1);
  }

  /**
   * Returns true if connected to database
   * Usage: $db->IsConnected();
   *
   * @access public
   */
  function IsConnected() {
    if ($this->connectionId === false || $this->connectionId == false) {
      return false;
    } else {
      return true;
    }
  }

  /**
   * Normal Database connection
   * Usage: $result = $db->Connect('host', 'username', 'password', 'database');
   *
   * @access public
   * @param string $host
   * @param string $username
   * @param string $password
   * @param string $database
   * @param string $forcenew // private
   */
  function Connect($host = "", $username = "", $password = "", $database = "", $forcenew = false) {
    return $this->_connect($host, $username, $password, $database, false, $forcenew);
  }

  /**
   * Persistent Database connection
   * Usage: $result = $db->PConnect('host', 'username', 'password', 'database');
   *
   * @access public
   * @param string $host
   * @param string $username
   * @param string $password
   * @param string $database
   */
  function PConnect($host = "", $username = "", $password = "", $database = "") {
    return $this->_connect($host, $username, $password, $database, true, false);
  }

  /**
   * Force New Database connection
   * Usage: $result = $db->NConnect('host', 'username', 'password', 'database');
   *
   * @access public
   * @param string $host
   * @param string $username
   * @param string $password
   * @param string $database
   */
  function NConnect($host = "", $username = "", $password = "", $database = "") {
    return $this->_connect($host, $username, $password, $database, false, true);
  }

  /**
   * Returns SQL query and instantiates sql statement & resultset driver
   * Usage: $linkId =& $db->execute( 'SELECT * FROM foo ORDER BY id' );
   *
   * @access public
   * @param string $sql
   * @return mixed Resource ID, Array
   */
  function &Execute($sql, $inputarr = false) {

    // adodb_log_sql will time the query execution and log the sql query
    // note: the later $this->do_query() should not run since adodb_log_sql() independently executes the query itself.

    if ($this->_logsql === true) {
      $ret = & adodb_log_sql($this, $sql, $inputarr);
      if (isset($ret)) {
        return $ret;
      }
    }
    $rs = & $this->do_query($sql, -1, -1, $inputarr);
    return $rs;
  }

  /**
   * Returns SQL query and instantiates sql statement & resultset driver
   * Usage: $linkId =& $db->SelectLimit( 'SELECT * FROM foo ORDER BY id', $nrows, $offset );
   *        $nrows and $offset are optional
   *
   * @access public
   * @param string $sql
   * @param string $nrows
   * @param string $offset
   * @return mixed Resource ID, Array
   */
  function &SelectLimit($sql, $nrows = -1, $offset = -1, $inputarr = false, $secs2cache = 0) {
    $rs = & $this->do_query($sql, $offset, $nrows, $inputarr);
    return $rs;
  }

  /**
   * Display debug output and database error.
   *
   * @access private
   */
  function outp($text, $newline = true) {
    global $ADODB_OUTP;
    $this->debug_output = "<br>\n(" . $this->dbtype . "): " . htmlspecialchars($text) . "<br>\n Error (" . $this->ErrorNo() . '): ' . $this->ErrorMsg() . "<br>\n";
    if (defined('ADODB_OUTP')) {
      $fn = ADODB_OUTP;
    } else if (isset($ADODB_OUTP)) {
      $fn = $ADODB_OUTP;
    }
    if (defined('ADODB_OUTP') || isset($ADODB_OUTP)) {
      $fn($this->debug_output, $newline);
      return;
    }
    if ($this->debug_echo) {
      echo $this->debug_output;
    }
  }

}

/**
 * Empty result record set for updates, inserts, ect
 *
 * @access private
 */
class ADORecordSet_empty {

  var $fields = false;
  var $EOF = true;

  function MoveNext() {
    return;
  }

  function RecordCount() {
    return 0;
  }

  function FieldCount() {
    return 0;
  }

  function EOF() {
    return TRUE;
  }

  function Close() {
    return true;
  }

}

/**
 * mysqlt_driver_ADOConnection
 */
class mysqlt_driver_ADOConnection extends ADOConnection {

  var $autoCommit = true;
  var $transOff = 0;
  var $transCnt = 0;
  var $transaction_status = true;
  var $nameQuote = '`';
  var $sysDate = 'CURDATE()';
  var $sysTimeStamp = 'NOW()';
  var $isoDates = true; // accepts dates in ISO format

  function __construct() {
    $this->dbtype = 'mysqlt';
    $this->dataProvider = 'mysql';
    $this->last_module_name = 'mysqlt_driver';
  }

  /**
   * Connection to database server and selected database
   *
   * @access private
   * @param string $host
   * @param string $username
   * @param string $password
   * @param string $database
   * @param string $persistent
   * @param string $forcenew
   */
  function _connect($host = "", $username = "", $password = "", $database = "", $persistent = "", $forcenew = "") {
    if (PH_USE_MYSQLI) {
      if (!function_exists('mysqli_real_connect')) {
        return false;
      }
      $this->host = $host;
      $this->username = $username;
      $this->password = $password;
      $this->database = $database;
      $this->persistent = $persistent;
      $this->forcenewconnection = $forcenew;
      $this->connectionId = @mysqli_init();
      @mysqli_real_connect($this->connectionId, $this->host, $this->username, $this->password, $this->database, $this->port, $this->socket, $this->clientFlags);
      if (mysqli_connect_errno() != 0) {
        $this->connectionId = false;
      }
    } else {
      if (!function_exists('mysql_connect')) {
        return false;
      }
      $this->host = $host;
      if (!empty($this->port))
        $this->host .= ":" . $this->port;
      $this->username = $username;
      $this->password = $password;
      $this->database = $database;
      $this->persistent = $persistent;
      $this->forcenewconnection = $forcenew;
      if ($this->persistent == 1) {
        $this->connectionId = @mysql_pconnect($this->host, $this->username, $this->password, $this->clientFlags);
      } else {
        $this->connectionId = @mysql_connect($this->host, $this->username, $this->password, $this->forcenewconnection, $this->clientFlags);
      }
    }
    if ($this->connectionId === false) {
      return false;
    }
    if (!empty($this->database)) {
      if ($this->SelectDB($this->database) == false) {
        $this->connectionId = false;
        return false;
      }
    }
    return true;
  }

  /**
   * Choose a database to connect.
   *
   * @param dbname 	is the name of the database to select
   * @return 		true or false
   * @access public
   */
  function SelectDB($dbname) {
    $this->database = $dbname;
    if ($this->connectionId === false) {
      $this->connectionId = false;
      return false;
    } else {
      if (PH_USE_MYSQLI) {
        $result = @mysqli_select_db($this->connectionId, $this->database);
      } else {
        $result = @mysql_select_db($this->database, $this->connectionId);
      }
      if ($result === false) {
        if ($this->createdatabase == true) {
          if (PH_USE_MYSQLI) {
            $result = @mysqli_query($this->connectionId, "CREATE DATABASE IF NOT EXISTS " . $this->database);
          } else {
            $result = @mysql_query("CREATE DATABASE IF NOT EXISTS " . $this->database, $this->connectionId);
          }
          if ($result === false) { // error handling if query fails
            return false;
          }
          if (PH_USE_MYSQLI) {
            $result = @mysqli_select_db($this->connectionId, $this->database);
          } else {
            $result = @mysql_select_db($this->database, $this->connectionId);
          }
          if ($result === false) {
            return false;
          }
        } else {
          return false;
        }
      }
      return true;
    }
  }

  /**
   * Return database error message
   * Usage: $errormessage =& $db->ErrorMsg();
   *
   * @access public
   */
  function ErrorMsg() {
    if ($this->connectionId === false) {
      if (PH_USE_MYSQLI) {
        return @mysqli_connect_error();
      } else {
        return @mysql_error();
      }
    } else {
      if (PH_USE_MYSQLI) {
        return @mysqli_error($this->connectionId);
      } else {
        return @mysql_error($this->connectionId);
      }
    }
  }

  /**
   * Return database error number
   * Usage: $errorbo =& $db->ErrorNo();
   *
   * @access public
   */
  function ErrorNo() {
    if ($this->connectionId === false) {
      if (PH_USE_MYSQLI) {
        return @mysqli_connect_errno();
      } else {
        return @mysql_errno();
      }
    } else {
      if (PH_USE_MYSQLI) {
        return @mysqli_errno($this->connectionId);
      } else {
        return @mysql_errno($this->connectionId);
      }
    }
  }

  /**
   * Returns # of affected rows from insert/delete/update query
   *
   * @access public
   * @return integer Affected rows
   */
  function Affected_Rows() {
    if (PH_USE_MYSQLI) {
      return @mysqli_affected_rows($this->connectionId);
    } else {
      return @mysql_affected_rows($this->connectionId);
    }
  }

  /**
   * Returns the last record id of an inserted item
   * Usage: $db->Insert_ID();
   *
   * @access public
   */
  function Insert_ID() {
    if (PH_USE_MYSQLI) {
      return @mysqli_insert_id($this->connectionId);
    } else {
      return @mysql_insert_id($this->connectionId);
    }
  }

  /**
   * Correctly quotes a string so that all strings are escape coded.
   * An example is  $db->qstr("Haven't a clue.");
   *
   * @param string			the string to quote
   * @param [magic_quotes]	if $s is GET/POST var, set to get_magic_quotes_gpc().
   *
   * @return  single-quoted string IE: 'Haven\'t a clue.'
   */
  function qstr($string, $magic_quotes = false) {
    if (!$magic_quotes) {
      if (PH_USE_MYSQLI) {
        if (function_exists('mysqli_real_escape_string')) {
          return "'" . mysqli_real_escape_string($this->connectionId, $string) . "'";
        }
      } else {
        return "'" . mysql_real_escape_string($string, $this->connectionId) . "'";
      }
      $string = str_replace("'", "\\'", str_replace('\\', '\\\\', str_replace("\0", "\\\0", $string)));
      return "'" . $string . "'";
    }
    return "'" . str_replace('\\"', '"', $string) . "'";
  }

  function QMagic($string) {
    return $this->qstr($string, get_magic_quotes_gpc());
  }

  /**
   * Returns concatenated string
   * Usage: $db->Concat($str1,$str2);
   *
   * @return concatenated string
   */
  function Concat() {
    $arr = func_get_args();
    $list = implode(', ', $arr);
    if (strlen($list) > 0) {
      return "CONCAT($list)";
    } else {
      return '';
    }
  }

  function IfNull($field, $ifNull) {
    return " IFNULL($field, $ifNull) ";
  }

  /**
   * Closes database connection
   * Usage: $db->close();
   *
   * @access public
   */
  function Close() {
    if (PH_USE_MYSQLI) {
      @mysqli_close($this->connectionId);
    } else {
      @mysql_close($this->connectionId);
    }
    $this->connectionId = false;
  }

  function StartTrans($errfn = 'ADODB_TransMonitor') {
    if ($this->transOff > 0) {
      $this->transOff += 1;
      return;
    }
    $this->transaction_status = true;
    if ($this->debug && $this->transCnt > 0) {
      ADOConnection::outp("Bad Transaction: StartTrans called within BeginTrans");
    }
    $this->BeginTrans();
    $this->transOff = 1;
  }

  function BeginTrans() {
    if ($this->transOff) {
      return true;
    }
    $this->transCnt += 1;
    $this->Execute('SET AUTOCOMMIT=0');
    $this->Execute('BEGIN');
    return true;
  }

  function CompleteTrans($autoComplete = true) {
    if ($this->transOff > 1) {
      $this->transOff -= 1;
      return true;
    }
    $this->transOff = 0;
    if ($this->transaction_status && $autoComplete) {
      if (!$this->CommitTrans()) {
        $this->transaction_status = false;
        if ($this->debug) {
          ADOConnection::outp("Smart Commit failed");
        }
      } else
      if ($this->debug) {
        ADOConnection::outp("Smart Commit occurred");
      }
    } else {
      $this->RollbackTrans();
      if ($this->debug) {
        ADOCOnnection::outp("Smart Rollback occurred");
      }
    }
    return $this->transaction_status;
  }

  function CommitTrans($ok = true) {
    if ($this->transOff) {
      return true;
    }
    if (!$ok) {
      return $this->RollbackTrans();
    }
    if ($this->transCnt) {
      $this->transCnt -= 1;
    }
    $this->Execute('COMMIT');
    $this->Execute('SET AUTOCOMMIT=1');
    return true;
  }

  function RollbackTrans() {
    if ($this->transOff) {
      return true;
    }
    if ($this->transCnt) {
      $this->transCnt -= 1;
    }
    $this->Execute('ROLLBACK');
    $this->Execute('SET AUTOCOMMIT=1');
    return true;
  }

  function FailTrans() {
    if ($this->debug) {
      if ($this->transOff == 0) {
        ADOConnection::outp("FailTrans outside StartTrans/CompleteTrans");
      } else {
        ADOConnection::outp("FailTrans was called");
      }
    }
    $this->transaction_status = false;
  }

  function HasFailedTrans() {
    if ($this->transOff > 0) {
      return $this->transaction_status == false;
    }
    return false;
  }

  function RowLock($tables, $where, $flds = '1 as ignore') {
    if ($this->transCnt == 0) {
      $this->BeginTrans();
    }
    return $this->GetOne("select $flds from $tables where $where for update");
  }

  function CommitLock($table) {
    return $this->CommitTrans();
  }

  function RollbackLock($table) {
    return $this->RollbackTrans();
  }

  /**
   * Returns All Records in an array
   *
   * Usage: $db->GetAll($sql);
   * @access public
   */
  function &GetAll($sql, $inputarr = false) {
    $data = & $this->GetArray($sql, $inputarr);
    return $data;
  }

  /**
   * Returns All Records in an array
   *
   * Usage: $db->GetArray($sql);
   * @access public
   */
  function &GetArray($sql, $inputarr = false) {
    $data = false;
    $result = & $this->Execute($sql, $inputarr);
    if ($result) {
      $data = & $result->GetArray();
      $result->Close();
    }
    return $data;
  }

  /**
   * Return first element of first row of sql statement. Recordset is disposed
   * for you.
   *
   * @param sql SQL statement
   * @param [inputarr] input bind array
   */
  function GetOne($sql, $inputarr = false) {
    $ret = false;
    $rs = & $this->Execute($sql, $inputarr);
    if ($rs) {
      if (!$rs->EOF) {
        $ret = reset($rs->fields);
      }
      $rs->Close();
    }
    return $ret;
  }

  /**
   * Executes SQL query and instantiates resultset methods
   *
   * @access private
   * @return mixed Resultset methods
   */
  function &do_query($sql, $offset, $nrows, $inputarr = false) {
    global $ADODB_FETCH_MODE;
    $false = false;
    $limit = '';
    if ($offset >= 0 || $nrows >= 0) {
      $offset = ($offset >= 0) ? $offset . "," : '';
      $nrows = ($nrows >= 0) ? $nrows : '18446744073709551615';
      $limit = ' LIMIT ' . $offset . ' ' . $nrows;
    }
    if ($inputarr && is_array($inputarr)) {
      $sqlarr = explode('?', $sql);
      if (!is_array(reset($inputarr))) {
        $inputarr = array($inputarr);
      }
      foreach ($inputarr as $arr) {
        $sql = '';
        $i = 0;
        foreach ($arr as $v) {
          $sql .= $sqlarr[$i];
          switch (gettype($v)) {
            case 'string':
              $sql .= $this->qstr($v);
              break;
            case 'double':
              $sql .= str_replace(',', '.', $v);
              break;
            case 'boolean':
              $sql .= $v ? 1 : 0;
              break;
            default:
              if ($v === null) {
                $sql .= 'NULL';
              } else {
                $sql .= $v;
              }
          }
          $i += 1;
        }
        $sql .= $sqlarr[$i];
        if ($i + 1 != sizeof($sqlarr)) {
          return $false;
        }
        $this->sql = $sql . $limit;
        $time_start = array_sum(explode(' ', microtime()));
        $this->query_count++;
        if (PH_USE_MYSQLI) {
          $resultId = @mysqli_query($this->connectionId, $this->sql);
        } else {
          $resultId = @mysql_query($this->sql, $this->connectionId);
        }
        $time_total = (array_sum(explode(' ', microtime())) - $time_start);
        $this->query_time_total += $time_total;
        if ($this->debug_console) {
          $this->query_list[] = $this->sql;
          $this->query_list_time[] = $time_total;
          $this->query_list_errors[] = $this->ErrorMsg();
        }
        if ($this->debug) {
          $this->outp($sql . $limit);
        }
      }
    } else {
      $this->sql = $sql . $limit;
      $time_start = array_sum(explode(' ', microtime()));
      $this->query_count++;
      if (PH_USE_MYSQLI) {
        $resultId = @mysqli_query($this->connectionId, $this->sql);
      } else {
        $resultId = @mysql_query($this->sql, $this->connectionId);
      }
      $time_total = (array_sum(explode(' ', microtime())) - $time_start);
      $this->query_time_total += $time_total;
      if ($this->debug_console) {
        $this->query_list[] = $this->sql;
        $this->query_list_time[] = $time_total;
        $this->query_list_errors[] = $this->ErrorMsg();
      }
      if ($this->debug) {
        $this->outp($sql . $limit);
      }
    }
    if ($resultId === false) { // error handling if query fails
      if ($this->raiseErrorFn) {
        ph_ErrorFn($this->dbtype, 'EXECUTE', $this->ErrorNo(), $this->ErrorMsg(), $this->sql, $inputarr, $this);
      }
      return $false;
    }
    if ($resultId === true) { // return simplified recordset for inserts/updates/deletes with lower overhead
      $recordset = new ADORecordSet_empty();
      return $recordset;
    }
    $resultset_name = $this->last_module_name . "_ResultSet";
    $recordset = new $resultset_name($resultId, $this->connectionId);
    $recordset->_currentRow = 0;
    if (PH_USE_MYSQLI) {
      switch ($ADODB_FETCH_MODE) {
        case ADODB_FETCH_NUM: $recordset->fetchMode = MYSQLI_NUM;
          break;
        case ADODB_FETCH_ASSOC:$recordset->fetchMode = MYSQLI_ASSOC;
          break;
        default:
        case ADODB_FETCH_DEFAULT:
        case ADODB_FETCH_BOTH:$recordset->fetchMode = MYSQLI_BOTH;
          break;
      }
    } else {
      switch ($ADODB_FETCH_MODE) {
        case ADODB_FETCH_NUM: $recordset->fetchMode = MYSQL_NUM;
          break;
        case ADODB_FETCH_ASSOC:$recordset->fetchMode = MYSQL_ASSOC;
          break;
        default:
        case ADODB_FETCH_DEFAULT:
        case ADODB_FETCH_BOTH:$recordset->fetchMode = MYSQL_BOTH;
          break;
      }
    }
    if (PH_USE_MYSQLI) {
      $recordset->_numOfRows = @mysqli_num_rows($resultId);
    } else {
      $recordset->_numOfRows = @mysql_num_rows($resultId);
    }
    if ($recordset->_numOfRows == 0) {
      $recordset->EOF = true;
    }
    if (PH_USE_MYSQLI) {
      $recordset->_numOfFields = @mysqli_num_fields($resultId);
    } else {
      $recordset->_numOfFields = @mysql_num_fields($resultId);
    }
    $recordset->_fetch();
    return $recordset;
  }

}

class mysqlt_driver_ResultSet {

  var $connectionId;
  var $fields;
  var $resultId;
  var $_currentRow = 0;
  var $_numOfRows = -1;
  var $_numOfFields = -1;
  var $fetchMode;
  var $EOF;

  /**
   * mysqlResultSet Constructor
   *
   * @access private
   * @param string $resultId
   * @param string $connectionId
   */
  function __construct($resultId, $connectionId) {
    $this->fields = array();
    $this->connectionId = $connectionId;
    $this->record = array();
    $this->resultId = $resultId;
    $this->EOF = false;
  }

  /**
   * Frees resultset
   *
   * @access public
   */
  function Close() {
    if (PH_USE_MYSQLI) {
      @mysqli_free_result($this->resultId);
    } else {
      @mysql_free_result($this->resultId);
    }
    $this->fields = array();
    $this->resultId = false;
  }

  /**
   * Returns field name from select query
   *
   * @access public
   * @param string $field
   * @return string Field name
   */
  function fields($field) {
    if (empty($field)) {
      return $this->fields;
    } else {
      return $this->fields[$field];
    }
  }

  /**
   * Returns numrows from select query
   *
   * @access public
   * @return integer Numrows
   */
  function RecordCount() {
    return $this->_numOfRows;
  }

  /**
   * Returns num of fields from select query
   *
   * @access public
   * @return integer numfields
   */
  function FieldCount() {
    return $this->_numOfFields;
  }

  /**
   * Returns next record
   *
   * @access public
   */
  function MoveNext() {
    if (PH_USE_MYSQLI) {
      $this->fields = @mysqli_fetch_array($this->resultId, $this->fetchMode);
    } else {
      $this->fields = @mysql_fetch_array($this->resultId, $this->fetchMode);
    }
    if ($this->fields) {
      $this->_currentRow += 1;
      return true;
    }
    if (!$this->EOF) {
      $this->_currentRow += 1;
      $this->EOF = true;
    }
    return false;
  }

  /**
   * Move to the first row in the recordset. Many databases do NOT support this.
   *
   * @return true or false
   */
  function MoveFirst() {
    if ($this->_currentRow == 0) {
      return true;
    }
    return $this->Move(0);
  }

  /**
   * Returns the Last Record
   *
   * @access public
   */
  function MoveLast() {
    if ($this->EOF) {
      return false;
    }
    return $this->Move($this->_numOfRows - 1);
  }

  /**
   * Random access to a specific row in the recordset. Some databases do not support
   * access to previous rows in the databases (no scrolling backwards).
   *
   * @param rowNumber is the row to move to (0-based)
   *
   * @return true if there still rows available, or false if there are no more rows (EOF).
   */
  function Move($rowNumber = 0) {
    if ($rowNumber == $this->_currentRow) {
      return true;
    }
    $this->EOF = false;
    if ($this->_numOfRows > 0) {
      if ($rowNumber >= $this->_numOfRows - 1) {
        $rowNumber = $this->_numOfRows - 1;
      }
    }
    if ($this->_seek($rowNumber)) {
      $this->_currentRow = $rowNumber;
      if ($this->_fetch()) {
        return true;
      }
      $this->fields = false;
    }
    $this->EOF = true;
    return false;
  }

  /**
   * Perform Seek to specific row
   *
   * @access private
   */
  function _seek($row) {
    if ($this->_numOfRows == 0) {
      return false;
    }
    if (PH_USE_MYSQLI) {
      return @mysqli_data_seek($this->resultId, $row);
    } else {
      return @mysql_data_seek($this->resultId, $row);
    }
  }

  /**
   * Fills field array with first database element when query initially executed
   *
   * @access private
   */
  function _fetch() {
    if (PH_USE_MYSQLI) {
      $this->fields = @mysqli_fetch_array($this->resultId, $this->fetchMode);
    } else {
      $this->fields = @mysql_fetch_array($this->resultId, $this->fetchMode);
    }
    return is_array($this->fields);
  }

  /**
   * Check to see if last record reached
   *
   * @access public
   */
  function EOF() {
    if ($this->_currentRow < $this->_numOfRows) {
      return false;
    } else {
      $this->EOF = true;
      return true;
    }
  }

  /**
   * Returns All Records in an array
   *
   * @access public
   * @param [nRows]  is the number of rows to return. -1 means every row.
   */
  function &GetArray($nRows = -1) {
    $results = array();
    $cnt = 0;
    while (!$this->EOF && $nRows != $cnt) {
      $results[] = $this->fields;
      $this->MoveNext();
      $cnt++;
    }
    return $results;
  }

  function &GetRows($nRows = -1) {
    $arr = & $this->GetArray($nRows);
    return $arr;
  }

  function &GetAll($nRows = -1) {
    $arr = & $this->GetArray($nRows);
    return $arr;
  }

  /**
   * Fetch field information for a table.
   *
   * @return object containing the name, type and max_length
   */
  function FetchField($fieldOffset = -1) {
    if (PH_USE_MYSQLI) {

      // $fieldOffset not supported by mysqli
      $fieldObject = @mysqli_fetch_field($this->resultId);
    } else {
      if ($fieldOffset != -1) {
        $fieldObject = @mysql_fetch_field($this->resultId, $fieldOffset);
        $fieldObject->max_length = @mysql_field_len($this->resultId, $fieldOffset);
      } else {
        $fieldObject = @mysql_fetch_field($this->resultId);
        $fieldObject->max_length = @mysql_field_len($this->resultId);
      }
    }
    return $fieldObject;
  }

}

define('MASTER_KEYN', 'PhSoft');
define('MASTER_KEYP', 'OneGod165');

if (!function_exists('ph_AddLog')) {

  function ph_AddLog($vText) {
    $sReturn = -999;
    if ($vText != '') {
      $sSQL = "INSERT INTO `phs_log` (`log_date`, `log_text`) VALUES (NOW(), '" . $vText . "')";
      ph_Execute($sSQL);
      $sReturn = ph_InsertedId();
    }
    return $sReturn;
  }

}

// Get value from database from table by condition
function ph_GetDBValue($sField, $sTable = '', $sWhere = '') {
  $sRetVal = '';
  $sSQL = "SELECT " . $sField . " AS `vValue`";
  if ($sTable != '') {
    $sSQL .= " FROM " . $sTable;
  }
  if ($sWhere != '') {
    $sSQL .= " WHERE " . $sWhere;
  }
  try {
    $res = ph_Execute($sSQL);
    if ($res != "") {
      if (!$res->EOF) {
        $sRetVal = $res->fields('vValue');
      }
      $res->Close();
    }
  } catch (Exception $ex) {
    $sRetVal = "";
  }
  return $sRetVal;
}

// Connect to database
function &ph_Connect($dbName = '', $info = NULL) {
  if ($dbName === '') {
    $dbName = ph_Session('dbName');
  }
  if ($dbName === '') {
    $dbName = PHS_SMB_ADMIN;
  }
  $GLOBALS["ADODB_FETCH_MODE"] = ADODB_FETCH_BOTH;
  $conn = new mysqlt_driver_ADOConnection();
  $conn->debug = PH_DEBUG_ENABLED;
  $conn->debug_echo = FALSE;
  if (!$info) {
    $info = array("host" => PH_CONN_HOST,
        "port" => PH_CONN_PORT,
        "user" => PH_CONN_USER,
        "pass" => PH_CONN_PASS,
        "db" => $dbName);
  }
  // Database connecting event
  $conn->port = intval($info["port"]);
  $conn->Connect($info["host"], $info["user"], $info["pass"], $info["db"]);
  if (PH_MYSQL_CHARSET <> "") {
    $conn->Execute("SET NAMES '" . PH_MYSQL_CHARSET . "'");
  }
  $conn->Execute("SET GLOBAL time_zone = '" . PH_MYSQL_TIMEZONE . "'");
  return $conn;
}

// Connection/Query error handler
function ph_ErrorFn($DbType, $ErrorType, $ErrorNo, $ErrorMsg, $Param1, $Param2, $Object) {
  if ($ErrorType == 'CONNECT') {
    $msg = "Failed to connect to $Param2 at $Param1. Error: " . $ErrorMsg;
  } elseif ($ErrorType == 'EXECUTE') {
    if (PH_DEBUG_ENABLED) {
      $msg = "Failed to execute SQL: $Param1. Error: " . $ErrorMsg;
    } else {
      $msg = "Failed to execute SQL. Error: " . $ErrorMsg;
    }
  }
  $error = array(
      'Datetime' => (new DateTime('NOW'))->format('Y-m-d H:i'),
      'DBType' => $DbType,
      'ErrType' => $ErrorType,
      'ErrNo' => $ErrorNo,
      'ErrMsg' => $ErrorMsg,
      'ErrParam1' => $Param1,
      'ErrParam2' => $Param2,
      'ErrMessage' => $msg
  );
  ph_AddMessage(PH_MYSQL_ERRORS, $error);
}

// Add message
if (!function_exists('ph_AddMessage')) {

  function ph_AddMessage($msgType, $msgtoadd) {
    if (!isset($_SESSION[$msgType])) {
      $_SESSION[$msgType] = array();
    }
    array_push($_SESSION[$msgType], $msgtoadd);
  }

}


// Get messages
if (!function_exists('ph_GetMessages')) {

  function ph_GetMessages($msgType, $vNewLine = '<br>') {
    $vMsgs = '';
    if (isset($_SESSION[$msgType]) && is_array($_SESSION[$msgType])) {
      foreach ($_SESSION[$msgType] as $element) {
        $vMsgs .= strtoupper($element['DBType'])
                . '-'
                . $element['ErrNo']
                . ': '
                . $element['ErrParam1']
                . '<br>'
                . $element['ErrMsg']
                . $vNewLine;
      }
    }
    return $vMsgs;
  }

}

// Get message to get Last Message pushed into Error array
if (!function_exists('ph_GetMessage')) {

  function ph_GetMessage($msgType, $vNewLine = '<br>') {
    $vMsgs = '';
    if (isset($_SESSION[$msgType]) && is_array($_SESSION[$msgType])) {
      foreach ($_SESSION[$msgType] as $element) {
        $vMsgs = $element['Datetime'] . ': ' . strtoupper($element['DBType'])
                . '-' . $element['ErrNo']
                . ': ' . $element['ErrParam1']
                . '<br>'
                . $element['ErrMsg']
                . $vNewLine;
      }
    }
    return $vMsgs;
  }

}

// Get MySQL message to get Last Message pushed into Error array
if (!function_exists('ph_GetMySQLMessage')) {

  function ph_GetMySQLMessage($vNewLine = '<br>') {
    return ph_GetMessage(PH_MYSQL_ERRORS);
  }

}

// Get MySQL message to get Last Message pushed into Error array
if (!function_exists('ph_GetMySQLMessageAsArray')) {

  function ph_GetMySQLMessageAsArray($vNewLine = '<br>') {
    return ph_GetMessageAsArray(PH_MYSQL_ERRORS);
  }

}

// Get message to get Last Message pushed into Error array
if (!function_exists('ph_GetMessageAsArray')) {

  function ph_GetMessageAsArray($msgType, $vNewLine = '<br>') {
    $aMsg = array();
    if (isset($_SESSION[$msgType]) && is_array($_SESSION[$msgType])) {
      foreach ($_SESSION[$msgType] as $element) {
        $aMsg = $element;
      }
    }
    return $aMsg;
  }

}

// Clear messages
if (!function_exists('ph_ClearMessages')) {

  function ph_ClearMessages($msgType) {
    if (isset($_SESSION[$msgType])) {
      unset($_SESSION[$msgType]);
    }
  }

}

if (!function_exists('ph_BeginTransaction')) {

  function ph_BeginTransaction() {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $conn->BeginTrans();
  }

}

if (!function_exists('ph_CommitTransaction')) {

  function ph_CommitTransaction() {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $conn->CommitTrans();
  }

}

if (!function_exists('ph_RollbackTransaction')) {

  function ph_RollbackTransaction() {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $conn->RollbackTrans();
  }

}

// Execute UPDATE, INSERT, or DELETE statements
if (!function_exists('ph_Execute')) {

  function ph_Execute($SQL, $callBack = NULL) {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $rs = $conn->Execute($SQL);
    if (is_callable($callBack) && $rs) {
      while (!$rs->EOF) {
        $callBack($rs->fields);
        $rs->MoveNext();
      }
      $rs->MoveFirst();
    }
    return $rs;
  }

}

// Execute INSERT
if (!function_exists('ph_ExecuteInsert')) {

  function ph_ExecuteInsert($SQL) {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $conn->raiseErrorFn = 'ph_ErrorFn';
    $conn->Execute($SQL);
    return $conn->Insert_ID();
  }

}

// Execute UPDATE OR DELETE
if (!function_exists('ph_ExecuteUpdate')) {

  function ph_ExecuteUpdate($SQL) {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $rs = $conn->Execute($SQL);
    if ($rs) {
      return $conn->Affected_Rows();
    } else {
      return $rs;
    }
  }

}


// Execute Select
if (!function_exists('ph_ExecuteJson')) {

  // Executes the query, and returns the row(s) as JSON
  function ph_ExecuteJson($SQL, $FirstOnly = TRUE) {
    $retVar = "false";
    $rs = ph_LoadRecordset($SQL);
    if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
      $res = ($FirstOnly) ? array($rs->fields) : $rs->GetRows();
      $rs->Close();
      $retVar = json_encode($res);
    }
    return $retVar;
  }

}

// Inserted Id
if (!function_exists('ph_InsertedId')) {

  function ph_InsertedId() {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    return $conn->Insert_ID();
  }

}

// Executes the query, and returns the first column of the first row
if (!function_exists('ph_ExecuteScalar')) {

  function ph_ExecuteScalar($SQL) {
    $res = FALSE;
    $rs = ph_LoadRecordset($SQL);
    if ($rs && !$rs->EOF && $rs->FieldCount() > 0) {
      $res = $rs->fields[0];
      $rs->Close();
    }
    return $res;
  }

}

// Executes the query, and returns the first row
if (!function_exists('ph_ExecuteRow')) {

  function ph_ExecuteRow($SQL) {
    $res = FALSE;
    $rs = ph_LoadRecordset($SQL);
    if ($rs && !$rs->EOF) {
      $res = $rs->fields;
      $rs->Close();
    }
    return $res;
  }

}

// Load recordset
if (!function_exists('ph_LoadRecordset')) {

  function &ph_LoadRecordset($SQL) {
    global $conn;
    if (!isset($conn)) {
      $conn = ph_Connect();
    }
    $rs = ph_Execute($SQL);
    return $rs;
  }

}

if (!function_exists('nextVal')) {

  function ph_NextVal($vSequence = 'public') {
    $nCurVal = ph_GetDBValue('cur_value', 'phs_sequence', 'name="' . $vSequence . '"');
    if ($nCurVal === null || $nCurVal === '') {
      $nCurVal = 0;
      $vSQL = 'INSERT INTO phs_sequence (name, cur_value) VALUES ("' . $vSequence . '", 0)';
      ph_Execute($vSQL);
    } else {
      $vSQL = 'UPDATE phs_sequence SET'
              . ' cur_value=IF(((cur_value + increment) > max_value OR (cur_value + increment) < min_value),'
              . ' IF (cycle = TRUE,'
              . ' IF ((cur_value + increment) > max_value, min_value, max_value), NULL),cur_value + increment)'
              . 'WHERE name="' . $vSequence . '"';
      $vSQL = 'UPDATE phs_sequence SET cur_value="' . ($nCurVal + 1) . '"'
              . 'WHERE name="' . $vSequence . '"';
      ph_Execute($vSQL);
    }
    return $nCurVal;
  }

}
