<?php include_once "PhsClasses/cPhsCodCountry.php" ?>
<?php include_once "PhsClasses/cPhsCodCity.php" ?>
<?php include_once "PhsClasses/cPhsCodAirports.php" ?>
<?php include_once "PhsClasses/cPhsCodSeaports.php" ?>

<?php include_once "PhsClasses/cPhsCpy.php" ?>
<?php include_once "PhsClasses/cPhsCode.php" ?>
<?php include_once "PhsClasses/cPhsProgram.php" ?>
<?php include_once "PhsClasses/cPhsPref.php" ?>
<?php include_once "PhsClasses/cPhsLang.php" ?>
<?php include_once "PhsClasses/cPhsSystem.php" ?>
<?php include_once "PhsClasses/cPhsCustomize.php" ?>
<?php

/**
 * PhSoft Common classes and functions
 * (C) 2000-2021 PhSoft.
 */
//date_default_timezone_set('+3:00');
date_default_timezone_set('Asia/Damascus');

if (!function_exists('isMoble')) {

  function isMoble() {
    $bisModile = false;
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) ||
            preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
      $bisModile = true;
    }
    return $bisModile;
  }

}

if (!function_exists('getLabel')) {

  function getLabel($vKey = '') {
    global $aPhLabels;
    $sRetVar = $vKey;
    if ($vKey != null && $vKey != '') {
      $key = strtolower($vKey);
      if (is_array($aPhLabels) && array_key_exists($key, $aPhLabels)) {
        $sRetVar = $aPhLabels[$key];
      }
    }
    return $sRetVar;
  }

}

if (!function_exists('initLabels')) {

  function initLabels() {
    global $aPhLabels;
    $aLbls = array();
    foreach ($aPhLabels as $key => $value) {
      $vKey = strtolower($key);
      $aLbls[$vKey] = $value;
    }
    $aPhLabels = $aLbls;
  }

}

if (!function_exists('ph_FormatDate')) {

  function ph_FormatDate($dDate, $vFormat = 'Y-m-d') {
    $objDateTime = new DateTime($dDate);
    return $objDateTime->format($vFormat);
  }

}

if (!function_exists('ph_DateFormat')) {

  function ph_DateFormat($dDate, $vFormat = 'Y-m-d') {
    return date_format(date_create($dDate), $vFormat);
  }

}

if (!function_exists('ph_GetDateYMD')) {

  function ph_GetDateYMD() {
    $objDateTime = new DateTime('NOW');
    return $objDateTime->format('Ymd');
  }

}

if (!function_exists('ph_GetCurrentDate')) {

  function ph_GetCurrentDate() {
    $objDateTime = new DateTime('NOW');
    return $objDateTime->format('Y-m-d');
  }

}

if (!function_exists('ph_GetCurrentDateTime')) {

  function ph_GetCurrentDateTime() {
    $objDateTime = new DateTime('NOW');
    return $objDateTime->format('Y-m-d H:i');
  }

}

if (!function_exists('ph_GetAge')) {

  function ph_GetAge($birthday) {
    $objDateTime = new DateTime($birthday);
    return $objDateTime->diff(new DateTime('NOW'))->format('%yy %mm %dd');
  }

}

if (!function_exists('getGUID')) {

  function getGUID() {
    $vGUID = '';
    if (function_exists('com_create_guid')) {
      $vGUID = strtolower(com_create_guid());
    } else {
      //mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
      $charid = strtolower(md5(uniqid(rand(), true)));
      $hyphen = chr(45); // "-"
      $vGUID = chr(123)// "{"
              . substr($charid, 0, 8) . $hyphen
              . substr($charid, 8, 4) . $hyphen
              . substr($charid, 12, 4) . $hyphen
              . substr($charid, 16, 4) . $hyphen
              . substr($charid, 20, 12)
              . chr(125); // "}";
    }
    return str_replace("{", "", str_replace("}", "", $vGUID));
  }

}

if (!function_exists('getRequestHeaders')) {

  function getRequestHeaders() {
    $headers = array();
    foreach ($_SERVER as $key => $value) {
      if (substr($key, 0, 5) === 'HTTP_') {
        $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
        $headers[$header] = $value;
      }
    }
    return $headers;
  }

}

if (!function_exists('callPhsAPI')) {

  function callPhsAPI($aHeader, $aParams = array(), $method = 'POST') {
    $vServiceURL = 'http://localhost:8080/PhAPI/';
    $headers = array(
        'Content-type: text/json;charset="utf-8"',
        'Accept: text/json',
        'Cache-Control: no-cache',
        'Pragma: no-cache',
        'Api-Key: 03C51C525544E2741588735FFDF085E4',
        'Username: Nart',
        'Password: PNHOhaanSryeottGfhotadm165',
        'Copy: ' . $aHeader['vCopy'],
        'Token: ' . $aHeader['vToken']
    );
    return callAPI($vServiceURL, $aParams, $headers, $method);
  }

}

if (!function_exists('callAPI')) {

// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value
  function callAPI($url,
          $aParams = array(),
          $headers = '',
          $method = 'POST',
          $authUser = "username",
          $authPassword = "password") {
    $url = sprintf("%s?%s", $url, http_build_query($aParams));
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_ENCODING, "UTF-8");
    curl_setopt($curl, CURLOPT_URL, $url);
    switch ($method) {
      case "POST":
        curl_setopt($curl, CURLOPT_POST, true);
        break;
      case "GET":
        curl_setopt($curl, CURLOPT_GET, true);
        break;
      case "DELETE":
        curl_setopt($curl, CURLOPT_DELETE, true);
        break;
      case "PUT":
        curl_setopt($curl, CURLOPT_PUT, true);
        break;
      default:
        curl_setopt($curl, CURLOPT_POST, true);
        break;
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($curl, CURLOPT_USERPWD, $authUser . ":" . $authPassword);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    $result = curl_exec($curl);
    curl_close($curl);

    return $result;
  }

}


if (!function_exists('callPhSOAPAPI')) {

  /*
    $aParams = array(
    'header' => array(
    'Copy' => '8468AA959D294C7381AFBABB12C75480',
    'Token' => '0'
    ),
    'Service' => 'Cpy/User',
    'Operation' => 'cpy:login',
    'params' => array(
    'vCopy' => '8468AA959D294C7381AFBABB12C75480',
    'vUsername' => 'admin',
    'vPassword' => 'admin'
    )
    );
    $response = callPhSOAPAPI($aParams);
   */

  function callPhSOAPAPI($aParams,
          $rootUrl = "http://localhost:9090/PhElectricityAPI",
          $soapUser = "username",
          $soapPassword = "password") {

    $soapUrl = $rootUrl . '/' . $aParams['Service']; // asmx URL of WSDL
    // xml post structure
    $xml_post_string = '<soapenv:Envelope'
            . ' xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"'
            . ' xmlns:cpy="http://cpy.ws.phsoft.com/">';
    $xml_post_string .= '<soapenv:Header/>';
    $xml_post_string .= '<soapenv:Body>';
    if (isset($aParams['params']) && is_array($aParams['params']) && count($aParams['params']) > 0) {
      $xml_post_string .= '<' . $aParams['Operation'] . '>';
      foreach ($aParams['params'] as $key => $value) {
        $xml_post_string .= '<' . $key . '>' . $value . '</' . $key . '>';
      }
      $xml_post_string .= '</' . $aParams['Operation'] . '>';
    } else {
      $xml_post_string .= '<' . $aParams['Operation'] . '/>';
    }
    $xml_post_string .= '</soapenv:Body>';
    $xml_post_string .= '</soapenv:Envelope>';

    $headers = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        "SOAPAction: " . $soapUrl,
        "Content-length: " . strlen($xml_post_string),
        "hapikey: 56A6A8851DAF44B388D0C7BA43BB7EB5",
        "husername: Nart",
        "hpassword: PNhaSrotfHtaOyntehGaomd165",
        "hcopy: " . $aParams['header']['Copy'],
        "htoken: " . $aParams['header']['Token']
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_URL, $soapUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $soapUser . ":" . $soapPassword);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $vResponse = curl_exec($ch);
    curl_close($ch);

    $vResponse = str_replace("</soap:Body>", "", str_replace("<soap:Body>", "", $vResponse));
    $vResponse = substr($vResponse, strpos($vResponse, '<return>') + 8);
    $vResponse = substr($vResponse, 0, strpos($vResponse, '</return>'));

    return $vResponse;
  }

}

if (!function_exists('ph_EncodePassword')) {

  function ph_EncodePassword($sPass) {
    $vRet = md5(ph_Clean_Password($sPass));
    return $vRet;
  }

}


if (!function_exists('writeFile')) {

  function writeFile($base64_string, $output_file, $fileExtension, $folderName = ".") {
    $vFileName = $output_file . "_" . date("ymd_His") . '.' . $fileExtension;
    try {
      if (!file_exists($folderName)) {
        mkdir($folderName);
      }
      file_put_contents($folderName . '/' . $vFileName, base64_decode($base64_string));
    } catch (Exception $ex) {
      $vFileName = '';
    }
    return $vFileName;
  }

}

if (!function_exists('base64_to_file')) {

  function base64_to_file($base64_string, $output_file, $fileExtension, $folderName = ".") {
    $vFileName = $output_file . "_" . date("ymd_His") . '.' . $fileExtension;
    $data = explode(',', $base64_string);
    try {
      if (!file_exists($folderName)) {
        mkdir($folderName);
      }
      file_put_contents($folderName . '/' . $vFileName, base64_decode($data[1]));
    } catch (Exception $ex) {
      $vFileName = '';
    }
    return $vFileName;
  }

}

if (!function_exists('file_to_base64')) {

  function file_to_base64($fileName, $folderName = ".") {
    $base64_string = '';
    if (file_exists($folderName . '/' . $fileName)) {
      $base64_string = base64_encode(file_get_contents($folderName . '/' . $fileName));
    }
    return $base64_string;
  }

}

if (!function_exists('file_to_fullbase64')) {

  function file_to_fullbase64($fileName, $folderName = ".") {
    $nPos = strpos($fileName, '.', -1);
    $base64_string = 'data:image/' . substr($fileName, $nPos) . ';base64,' . file_to_base64($fileName, $folderName);
    return $base64_string;
  }

}

if (!function_exists('ph_CurrentUserIP')) {

// Get user IP
  function ph_CurrentUserIP() {
    return ph_ServerVar("REMOTE_ADDR");
  }

}

if (!function_exists('ph_CheckEmail')) {

// Check email
  function ph_CheckEmail($value) {
    $retVar = TRUE;
    if (strval($value) == "") {
      $retVar = TRUE;
    } else {
      $retVar = preg_match('/^[\w.%+-]+@[\w.-]+\.[A-Z]{2,6}$/i', trim($value));
    }
    return $retVar;
  }

}

/* * ****************************** */

if (!function_exists('getAddress')) {

  function getAddress() {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS'])) {
      $protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http';
    }
    return $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  }

}

if (!function_exists('getURIArray')) {

  function getURIArray() {
    $vURI = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $aURI = explode('/', $vURI);
    return array_values(array_filter($aURI));
  }

}

if (!function_exists('getURIAsArray')) {

  function getURIAsArray($nRootLen = 0, $vCopy = 'nscc', $vLang = 'en') {
    $aReturn = array();
    $vURL = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $nRootLen);
    $vParams = '';
    $nPos = strpos($vURL, '#');
    if ($nPos !== false) {
      $vParams = substr($vURL, $nPos + 1);
      $vURL = substr($vURL, 0, $nPos);
    }
    $aURI = explode('/', $vURL);
    $aReturn['Copy'] = (count($aURI) >= 1 && $aURI[0] != '') ? $aURI[0] : $vCopy;
    $aReturn['Lang'] = (count($aURI) >= 2 && $aURI[1] != '') ? $aURI[1] : $vLang;
    $aReturn['Page'] = (count($aURI) >= 3 && $aURI[2] != '') ? $aURI[2] : '';
    $aReturn['Action'] = (count($aURI) >= 4 && $aURI[3] != '') ? $aURI[3] : '';
    $aReturn['QId'] = (count($aURI) >= 5 && $aURI[4] != '') ? $aURI[4] : 0;
    $aReturn['Params'] = $vParams;
    return $aReturn;
  }

}

if (!function_exists('getURLArray')) {

  function getURLArray($nRootLen = 0) {
    $aReturn = array();
    $vURL = substr(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), $nRootLen);
    $vParams = '';
    $nPos = strpos($vURL, '#');
    if ($nPos !== false) {
      $vParams = substr($vURL, $nPos + 1);
      $vURL = substr($vURL, 0, $nPos);
    }
    $aURI = explode('/', $vURL);
    $aReturn['Lang'] = (count($aURI) >= 1 && $aURI[0] != '') ? $aURI[0] : 'nscc';
    $aReturn['Page'] = (count($aURI) >= 2 && $aURI[1] != '') ? $aURI[1] : 'en';
    $aReturn['Action'] = (count($aURI) >= 3 && $aURI[2] != '') ? $aURI[2] : '';
    $aReturn['QId'] = (count($aURI) >= 4 && $aURI[3] != '') ? $aURI[3] : '';
    $aReturn['Params'] = $vParams;
    return $aReturn;
  }

}
/* * ****************************** */

// Get server variable by name
if (!function_exists('ph_ServerVar')) {

  function ph_ServerVar($Name) {
    $str = $_SERVER[$Name];
    if (empty($str)) {
      $str = $_ENV[$Name];
    }
    return $str;
  }

}

/* * ****************************** */

if (!function_exists('ph_PrepareGets')) {

  function ph_PrepareGets() {
    foreach ($_GET as $key => $value) {
      if (!is_array($key) && (gettype($value) === 'string')) {
        $_GET[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
      }
    }
  }

}

if (!function_exists('ph_PreparePosts')) {

  function ph_PreparePosts() {
    foreach ($_POST as $key => $value) {
      if (!is_array($key) && (gettype($value) === 'string')) {
        $_POST[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
      }
    }
  }

}

if (!function_exists('ph_PrepareRequests')) {

  function ph_PrepareRequests() {
    foreach ($_REQUEST as $key => $value) {
      if (!is_array($key) && (gettype($value) == 'string')) {
        $_REQUEST[$key] = htmlspecialchars(stripslashes(trim(strip_tags($value))));
      }
    }
  }

}

/**
 * Get GET input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_RemoveGet')) {

  function ph_RemoveGet($key, $value = null) {
    if (isset($_GET[$key])) {
      $_GET[$key] = $value;
    }
  }

}
/**
 * Get GET input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Get')) {

  function ph_Get($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_GET, $filter) : $_GET;
      } else {
        $retVar = $_GET;
      }
    } else {
      if (isset($_GET[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_GET, $key, $filter) : $_GET[$key];
        } else {
          $retVar = $_GET[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}
/**
 * Get POST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Post')) {

  function ph_Post($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_POST, $filter) : $_POST;
      } else {
        $retVar = $_POST;
      }
    } else {
      if (isset($_POST[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_POST, $key, $filter) : $_POST[$key];
        } else {
          $retVar = $_POST[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get GET_POST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Get_Post')) {

  function ph_Get_Post($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!isset($GLOBALS['_GET_POST'])) {
      $GLOBALS['_GET_POST'] = array_merge($_GET, $_POST);
    }
    if (!$key) {
      if (function_exists('filter_var_array')) {
        $retVar = $filter ? filter_var_array($GLOBALS['_GET_POST'], $filter) : $GLOBALS['_GET_POST'];
      } else {
        $retVar = $GLOBALS['_GET_POST'];
      }
    } else {
      if (isset($GLOBALS['_GET_POST'][$key])) {
        if (function_exists('filter_var')) {
          $retVar = $filter ? filter_var($GLOBALS['_GET_POST'][$key], $filter) : $GLOBALS['_GET_POST'][$key];
        } else {
          $retVar = $GLOBALS['_GET_POST'][$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get REQUEST input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Request')) {

  function ph_Request($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_input_array')) {
        $retVar = $filter ? filter_input_array(INPUT_REQUEST, $filter) : $_REQUEST;
      } else {
        $retVar = $_REQUEST;
      }
    } else {
      if (isset($_REQUEST[$key])) {
        if (function_exists('filter_input')) {
          $retVar = $filter ? filter_input(INPUT_REQUEST, $key, $filter) : $_REQUEST[$key];
        } else {
          $retVar = $_REQUEST[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Get COOKIE input
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Cookie')) {

  function ph_Cookie($key = null) {
    $retVar = '';
    if (!$key) {
      if (isset($_COOKIE[$key])) {
        $retVar = $_COOKIE[$key];
      }
    }
    return $retVar;
  }

}

/**
 * Set COOKIE input
 *
 * time can be set in seconds
 *
 * @param String $key
 * @param Mixed  $value
 * @param Int    $time
 */
if (!function_exists('ph_SetCookie')) {

  function ph_SetCookie($key, $value, $time = 0) {
    if ($time < 0) {
      $time = time() + 10 * 365 * 24 * 60 * 60;
    }
    setcookie($key, $value, time() + $time, "/");
  }

}

/**
 * Delete COOKIE input
 *
 * @param String $key
 */
if (!function_exists('ph_DeleteCookie')) {

  function ph_DeleteCookie($key) {
    setcookie($key, null, time() - SECONDS_IN_A_HOUR, "/");
    unset($_COOKIE[$key]);
  }

}

/**
 * Get a session variable.
 *
 * @param String $key
 * @param mixed  $filter
 * @param bool   $fillWithEmptyString
 *
 * @return mixed
 */
if (!function_exists('ph_Session')) {

  function ph_Session($key = null, $filter = null, $fillWithEmptyString = false) {
    $retVar = null;
    if (!$key) {
      if (function_exists('filter_var_array')) {
        $retVar = $filter ? filter_var_array($_SESSION, $filter) : $_SESSION;
      } else {
        $retVar = $_SESSION;
      }
    } else {
      if (isset($_SESSION[$key])) {
        if (function_exists('filter_var')) {
          $retVar = $filter ? filter_var($_SESSION[$key], $filter) : $_SESSION[$key];
        } else {
          $retVar = $_SESSION[$key];
        }
      } else if ($fillWithEmptyString == true) {
        $retVar = '';
      }
    }
    return $retVar;
  }

}

/**
 * Set a session variable.
 *
 * @param String $key
 * @param mixed  $value
 */
if (!function_exists('ph_SetSession')) {

  function ph_SetSession($key, $value = '') {
    if (isset($key)) {
      if ($value === '') {
        unset($_SESSION[$key]);
      } else {
        $_SESSION[$key] = $value;
      }
    }
  }

}

if (!function_exists('ph_UploadFile')) {

  function ph_UploadFile($srcFilename, $target_dir = 'uploads/', $newFileName = '') {

    $uploadOk = 0;
    if ($newFileName == '') {
      $newFileName = $srcFilename;
    }
    $distFilename = $target_dir . $newFileName . date("ymdHis") . '.' . pathinfo(basename($_FILES[$srcFilename]["name"]), PATHINFO_EXTENSION);
    $imageFileType = pathinfo(basename($_FILES[$srcFilename]["name"]), PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES[$srcFilename]["tmp_name"]);
    if ($check !== false) {
      //echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 0;
    } else {
      //echo "File is not an image.";
      $uploadOk = 1;
    }

// Check if file already exists
    if (file_exists($distFilename)) {
      //echo "Sorry, file already exists.";
      $uploadOk = 2;
    }
// Check file size
    if ($_FILES[$srcFilename]["size"] > 200000) {
      //echo "Sorry, your file is too large.";
      $uploadOk = 3;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
      //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 4;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk != 0) {
      //echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES[$srcFilename]["tmp_name"], $distFilename)) {
        //echo "The file " . basename($_FILES["idImage1"]["name"]) . " has been uploaded.";
      } else {
        //echo "Sorry, there was an error uploading your file.";
        $uploadOk = 2;
      }
    }
    return array("Status" => $uploadOk, "NewFileName" => $distFilename);
  }

}
/* * ****************************** */

if (!function_exists('ph_Clean_String')) {

  function ph_Clean_String($sString) {
    $aKeyWords = array('"', '?', "'", '(', ')', '<', '=', '>', '[', '\\', ']', '`', '{', '|', '}', ";", "--", "\0",
        '#', '&', ' ', '!', '$', '%', '*', '+', ',', '-', '.', '/', ':', '^', '_', '`', '~',
        "select", "update", "delete", "union", "from", "concat", "usrnam", "passwod", "cmslog", "drop");
    foreach ($aKeyWords as $keyWord) {
      $sString = str_ireplace($keyWord, '', $sString);
    }
    return strip_tags(htmlspecialchars($sString));
  }

}

if (!function_exists('ph_Clean_EMail')) {

  function ph_Clean_EMail($sString) {
    $aKeyWords = array('"', '?', "'", '(', ')', '<', '=', '>', '[', '\\', ']', '`', '{', '|', '}', ";", "--", "\0",
        '#', '&', ' ', '!', '$', '%', '*', '+', ',', '-', '/', ':', '^', '_', '`', '~',
        "select", "update", "delete", "union", "from", "concat", "usrnam", "passwod", "cmslog", "drop");
    foreach ($aKeyWords as $keyWord) {
      $sString = str_ireplace($keyWord, '', $sString);
    }
    return strip_tags(htmlspecialchars($sString));
  }

}

if (!function_exists('ph_Clean_Password')) {

  function ph_Clean_Password($sString) {
    $aKeyWords = array('"', '?', "'", '(', ')', '<', '=', '>', '[', '\\', ']', '`', '{', '|', '}', ";", "--", "\0",
        "select", "update", "delete", "union", "from", "concat", "usrnam", "passwod", "cmslog", "drop");
    foreach ($aKeyWords as $keyWord) {
      $sString = str_ireplace($keyWord, '', $sString);
    }
    return strip_tags(htmlspecialchars($sString));
  }

}

/*
  Usage: EXPORT_DATABASE("localhost", "user", "pass", "db_name");
 * (optional) 5th parameter: to backup specific tables only,like: array("mytable1","mytable2",...)
 * (optional) 6th parameter: backup filename (otherwise, it creates random name)
 */
if (!function_exists('PhExportDB')) {

  function PhExportDB($host, $user, $pass, $name, $tables = false, $backup_name = false) {
    set_time_limit(3000);
    $mysqli = new mysqli($host, $user, $pass, $name);
    $mysqli->select_db($name);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
      $target_tables[] = $row[0];
    }
    if ($tables !== false) {
      $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "";
    $content .= "--\r\n";
    $content .= "-- PhSoft Backup\r\n";
    $content .= "--\r\n\r\n";
    $content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\n";
    $content .= "SET time_zone = \"+00:00\";\r\n\r\n";
    $content .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n";
    $content .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n";
    $content .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n";
    $content .= "/*!40101 SET NAMES utf8 */;\r\n";
    $content .= "--\r\n";
    $content .= "-- Database: `" . $name . "`\r\n";
    $content .= "--\r\n";
    foreach ($target_tables as $table) {
      if (empty($table)) {
        continue;
      }
      $result = $mysqli->query('SELECT * FROM `' . $table . '`');
      $fields_amount = $result->field_count;
      $rows_num = $mysqli->affected_rows;
      $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
      $TableMLine = $res->fetch_row();
      $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
      $content .= "\n\n" . $TableMLine[1] . ";\n";
      if (substr($TableMLine[1], 0, 12) == 'CREATE TABLE') {
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
          while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
            if ($st_counter % 100 == 0 || $st_counter == 0) {
              $content .= "\nINSERT INTO " . $table . " VALUES";
            }
            $content .= "\n(";
            for ($j = 0; $j < $fields_amount; $j++) {
              $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
              if (isset($row[$j])) {
                $content .= '"' . $row[$j] . '"';
              } else {
                $content .= '""';
              }
              if ($j < ($fields_amount - 1)) {
                $content .= ',';
              }
            }
            $content .= ")";
            //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
            if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
              $content .= ";";
            } else {
              $content .= ",";
            }
            $st_counter = $st_counter + 1;
          }
        }
      }
      $content .= "\n";
    }
    $content .= "\r\n\r\n";
    $content .= "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n";
    $content .= "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n";
    $content .= "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\r\n";
    $backup_name = $backup_name ? $backup_name : $name . '_' . date('Y-m-d') . '_' . date('H-i-s') . '.sql';
    ob_get_clean();
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
    echo $content;
    exit;
  }

}

/*
  Usage: PhImport_Tables("localhost", "user", "pass", "db_name", "my_baseeee.sql"); //TABLES WILL BE OVERWRITTEN
 */
if (!function_exists('PhImport_Tables')) {

  function PhImport_Tables($host, $user, $pass, $dbname, $sql_file_OR_content) {
    set_time_limit(3000);
    $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content));
    $allLines = explode("\n", $SQL_CONTENT);
    $mysqli = new mysqli($host, $user, $pass, $dbname);
    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    $zzzzzz = $mysqli->query('SET foreign_key_checks = 0');
    preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
    foreach ($target_tables[2] as $table) {
      $mysqli->query('DROP TABLE IF EXISTS ' . $table);
    }
    $zzzzzz = $mysqli->query('SET foreign_key_checks = 1');
    $mysqli->query("SET NAMES 'utf8'");
    $templine = ''; // Temporary variable, used to store current query
    foreach ($allLines as $line) { // Loop through each line
      if (substr($line, 0, 2) != '--' && $line != '') {
        $templine .= $line;  // (if it is not a comment..) Add this line to the current segment
        if (substr(trim($line), -1, 1) == ';') {  // If it has a semicolon at the end, it's the end of the query
          if (!$mysqli->query($templine)) {
            print('Error performing query \'<strong>' . $templine . '\': ' . $mysqli->error . '<br /><br />');
          }
          $templine = ''; // set variable to empty, to start picking up the lines after ";"
        }
      }
    }
    return 'Importing finished. Now, Delete the import file.';
  }

}

/*
  Usage: EXPORT_DATABASE("localhost", "user", "pass", "db_name");
 * (optional) 5th parameter: to backup specific tables only,like: array("mytable1","mytable2",...)
 * (optional) 6th parameter: backup filename (otherwise, it creates random name)
 */
if (!function_exists('PhDBExpTables')) {

  function PhDBExpTables($host, $user, $pass, $dbName, $tables = false) {
    $mysqli = new mysqli($host, $user, $pass, $dbName);
    $mysqli->select_db($dbName);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
      $target_tables[] = $row[0];
    }
    if ($tables !== false) {
      $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "";
    $content .= "\r\n";
    $content .= "--\r\n";
    $content .= "-- Tables\r\n";
    $content .= "--\r\n";
    foreach ($target_tables as $table) {
      if (empty($table)) {
        continue;
      }
      $result = $mysqli->query('SELECT * FROM `' . $table . '`');
      $fields_amount = $result->field_count;
      $rows_num = $mysqli->affected_rows;
      $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
      $TableMLine = $res->fetch_row();
      $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
      $TableMLine[1] = str_ireplace('CREATE ALGORITHM=UNDEFINED DEFINER=`' . $user . '`@`localhost` SQL SECURITY DEFINER ', 'CREATE ', $TableMLine[1]);
      if (substr($TableMLine[1], 0, 12) == 'CREATE TABLE') {
        $content .= "\r\n";
        $content .= "--\r\n";
        $content .= "-- TABLE " . $table . "\r\n";
        $content .= "--\r\n";
        $content .= $TableMLine[1] . ";\r\n";
        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
          while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
            if ($st_counter % 100 == 0 || $st_counter == 0) {
              $content .= "\nINSERT INTO " . $table . " VALUES";
            }
            $content .= "\n(";
            for ($j = 0; $j < $fields_amount; $j++) {
              $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
              if (isset($row[$j])) {
                $content .= '"' . $row[$j] . '"';
              } else {
                $content .= '""';
              }
              if ($j < ($fields_amount - 1)) {
                $content .= ',';
              }
            }
            $content .= ")";
            //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
            if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
              $content .= ";";
            } else {
              $content .= ",";
            }
            $st_counter = $st_counter + 1;
          }
        }
      }
      $content .= "\n";
    }
    $content .= "--\r\n";
    $content .= "commit;\r\n";
    $content .= "--\r\n";
    return $content;
  }

}

/*
  Usage: EXPORT_DATABASE("localhost", "user", "pass", "db_name");
 * (optional) 5th parameter: to backup specific tables only,like: array("mytable1","mytable2",...)
 * (optional) 6th parameter: backup filename (otherwise, it creates random name)
 */
if (!function_exists('PhDBExpViews')) {

  function PhDBExpViews($host, $user, $pass, $dbName, $tables = false) {
    $mysqli = new mysqli($host, $user, $pass, $dbName);
    $mysqli->select_db($dbName);
    $mysqli->query("SET NAMES 'utf8'");
    $queryTables = $mysqli->query('SHOW TABLES');
    while ($row = $queryTables->fetch_row()) {
      $target_tables[] = $row[0];
    }
    if ($tables !== false) {
      $target_tables = array_intersect($target_tables, $tables);
    }
    $content = "";
    $content .= "\r\n";
    $content .= "--\r\n";
    $content .= "-- Views\r\n";
    $content .= "--\r\n";
    foreach ($target_tables as $table) {
      if (empty($table)) {
        continue;
      }
      $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
      $TableMLine = $res->fetch_row();
      $TableMLine[1] = str_ireplace('CREATE TABLE `', 'CREATE TABLE IF NOT EXISTS `', $TableMLine[1]);
      $TableMLine[1] = str_ireplace('CREATE ALGORITHM=UNDEFINED DEFINER=`' . $user . '`@`localhost` SQL SECURITY DEFINER ', 'CREATE ', $TableMLine[1]);
      if (substr($TableMLine[1], 0, 11) == 'CREATE VIEW') {
        $content .= "\r\n";
        $content .= "--\r\n";
        $content .= "-- VIEW " . $table . "\r\n";
        $content .= "--\r\n";
        $content .= $TableMLine[1] . ";\r\n";
      }
    }
    return $content;
  }

}

if (!function_exists('PhDBExpAutoIncrement')) {

  function PhDBExpAutoIncrement($host, $user, $pass, $dbName) {
    $mysqli = new mysqli($host, $user, $pass, $dbName);
    $mysqli->select_db($dbName);
    $mysqli->query("SET NAMES 'utf8'");
    $content = "";
    $content .= "\r\n";
    $content .= "--\r\n";
    $content .= "-- AutoIncrements\r\n";
    $content .= "--\r\n";
    $nTableLen = 32;
    $nColLen = 32;
    $vSQL = "SELECT max(length(TABLE_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.COLUMNS";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND EXTRA = UPPER('AUTO_INCREMENT')";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nTableLen = $row[0] + 2;
    }
    $vSQL = "SELECT max(length(COLUMN_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.COLUMNS";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND EXTRA = UPPER('AUTO_INCREMENT')";
    $vSQL .= " ORDER BY TABLE_NAME ASC";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nColLen = $row[0] + 2;
    }
    // export the statement for creating an auto-increment field
    $vSQL = "SELECT CONCAT('ALTER TABLE ', rpad(CONCAT('`', TABLE_NAME, '`'), " . $nTableLen . ", ' '),' ','MODIFY COLUMN ',rpad(CONCAT('`', COLUMN_NAME, '`'), " . $nColLen . ", ' '),' ',IF(UPPER(DATA_TYPE) = 'INT',REPLACE(SUBSTRING_INDEX(UPPER(COLUMN_TYPE),')',1),'INT','INTEGER'),UPPER(COLUMN_TYPE)),') UNSIGNED NOT NULL AUTO_INCREMENT;') AS cmd";
    $vSQL .= "  FROM information_schema.COLUMNS";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND EXTRA = UPPER('AUTO_INCREMENT')";
    $vSQL .= " ORDER BY TABLE_NAME ASC";
    $result = $mysqli->query($vSQL);
    while ($row = $result->fetch_row()) {
      $content .= $row[0] . "\r\n";
    }
    return $content;
  }

}

if (!function_exists('PhDBExpForeignKeys')) {

  function PhDBExpForeignKeys($host, $user, $pass, $dbName) {
    $mysqli = new mysqli($host, $user, $pass, $dbName);
    $mysqli->select_db($dbName);
    $mysqli->query("SET NAMES 'utf8'");
    $content = "";
    $content .= "\r\n";
    $content .= "--\r\n";
    $content .= "-- Foreign Keys\r\n";
    $content .= "--\r\n";
    //
    $nTableLen = 32;
    $nRSchemaLen = 32;
    $nRTableLen = 32;
    $nConstLen = 32;
    $nColLen = 32;
    $nRColLen = 32;
    $vSQL = "SELECT max(length(TABLE_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nTableLen = $row[0] + 2;
    }
    $vSQL = "SELECT max(length(REFERENCED_TABLE_SCHEMA)) AS nLen";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nRSchemaLen = $row[0] + 2;
    }
    $vSQL = "SELECT max(length(REFERENCED_TABLE_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nRTableLen = $row[0] + 2;
    }
    $vSQL = "SELECT max(length(CONSTRAINT_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nConstLen = $row[0] + 2;
    }
    $vSQL = "SELECT max(length(COLUMN_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nColLen = $row[0] + 2;
    }
    $vSQL = "SELECT max(length(REFERENCED_COLUMN_NAME)) AS nLen";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $result = $mysqli->query($vSQL);
    if ($row = $result->fetch_row()) {
      $nRColLen = $row[0] + 2;
    }
    // export all indexes
    $vSQL = "SELECT CONCAT('ALTER TABLE ', rpad(CONCAT('`', TABLE_NAME, '`'), " . $nTableLen . ", ' '),' ADD CONSTRAINT ', rpad(CONCAT('`', CONSTRAINT_NAME, '`'), " . $nConstLen . ", ' '), ' FOREIGN KEY (', rpad(CONCAT('`', COLUMN_NAME, '`'), " . $nColLen . ", ' '), ') REFERENCES ', rpad(IF(UPPER(TABLE_SCHEMA)=upper(REFERENCED_TABLE_SCHEMA), CONCAT('`',REFERENCED_TABLE_NAME,'`'), CONCAT('`',REFERENCED_TABLE_SCHEMA,'`.`', REFERENCED_TABLE_NAME,'`')), " . ($nRSchemaLen + $nRTableLen + 1) . ", ' '), ' (', rpad(CONCAT('`', REFERENCED_COLUMN_NAME, '`'), " . $nRColLen . ", ' '),');') AS cmd";
    $vSQL .= "  FROM information_schema.KEY_COLUMN_USAGE";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= "   AND REFERENCED_TABLE_SCHEMA IS NOT NULL";
    $vSQL .= " ORDER BY TABLE_NAME ASC, REFERENCED_TABLE_SCHEMA ASC, COLUMN_NAME ASC";
    $result = $mysqli->query($vSQL);
    while ($row = $result->fetch_row()) {
      $content .= $row[0] . "\r\n";
    }
    return $content;
  }

}

if (!function_exists('PhDBExpIndexes')) {

  function PhDBExpIndexes($host, $user, $pass, $dbName) {
    $mysqli = new mysqli($host, $user, $pass, $dbName);
    $mysqli->select_db($dbName);
    $mysqli->query("SET NAMES 'utf8'");
    $content = "";
    $content .= "\r\n";
    $content .= "--\r\n";
    $content .= "-- AutoIncrements\r\n";
    $content .= "--\r\n";
    // export all indexes
    $vSQL = "SELECT CONCAT('ALTER TABLE `',TABLE_NAME,'` ', 'ADD ', IF(NON_UNIQUE = 1, CASE UPPER(INDEX_TYPE) WHEN 'FULLTEXT' THEN 'FULLTEXT INDEX' WHEN 'SPATIAL' THEN 'SPATIAL INDEX' ELSE CONCAT('INDEX `', INDEX_NAME, '` USING ', INDEX_TYPE )END,IF(UPPER(INDEX_NAME) = 'PRIMARY', CONCAT('PRIMARY KEY USING ', INDEX_TYPE ),CONCAT('UNIQUE INDEX `', INDEX_NAME, '` USING ', INDEX_TYPE))),'(', GROUP_CONCAT(DISTINCT CONCAT('`', COLUMN_NAME, '`') ORDER BY SEQ_IN_INDEX ASC SEPARATOR ', '), ');') AS 'Show_Add_Indexes'";
    $vSQL .= "  FROM information_schema.STATISTICS";
    $vSQL .= " WHERE TABLE_SCHEMA = '" . $dbName . "'";
    $vSQL .= " GROUP BY TABLE_NAME, INDEX_NAME";
    $vSQL .= " ORDER BY TABLE_NAME ASC, INDEX_NAME ASC";
    $result = $mysqli->query($vSQL);
    while ($row = $result->fetch_row()) {
      $content .= $row[0] . "\r\n";
    }
    return $content;
  }

}

/*
  Usage: EXPORT_DATABASE("localhost", "user", "pass", "db_name");
 * (optional) 5th parameter: to backup specific tables only,like: array("mytable1","mytable2",...)
 * (optional) 6th parameter: backup filename (otherwise, it creates random name)
 */
if (!function_exists('PhDBExp')) {

  function PhDBExp($host, $user, $pass, $dbName, $tables = false) {
    $content = "";
    $content .= PhDBExpTables($host, $user, $pass, $dbName, $tables);
    $content .= PhDBExpViews($host, $user, $pass, $dbName, $tables);
    $content .= PhDBExpAutoIncrement($host, $user, $pass, $dbName, $tables);
    $content .= PhDBExpForeignKeys($host, $user, $pass, $dbName, $tables);
    return $content;
  }

}

/*
  Usage: EXPORT_DATABASE("localhost", "user", "pass", ["db_name", ...]);
 * (optional) 5th parameter: to backup specific tables only,like: array("mytable1","mytable2",...)
 * (optional) 6th parameter: backup filename (otherwise, it creates random name)
 */
if (!function_exists('PhDBExport')) {

  function PhDBExport($host, $user, $pass, $aDatabases, $fileName = false) {
    set_time_limit(3000);
    $content = "";
    $content .= "--\r\n";
    $content .= "-- PhSoft Backup\r\n";
    $content .= "--\r\n\r\n";
    $content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\n";
    $content .= "SET FOREIGN_KEY_CHECKS=0;\r\n";
    $content .= "SET time_zone = \"+00:00\";\r\n\r\n";
    $content .= "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n";
    $content .= "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n";
    $content .= "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n";
    $content .= "/*!40101 SET NAMES utf8 */;\r\n";
    for ($index = 0; $index < count($aDatabases); $index++) {
      $content .= "\r\n";
      $content .= "--\r\n";
      $content .= "-- Database: `" . $aDatabases[$index] . "` Begin\r\n";
      $content .= "--\r\n";
      $content .= PhDBExp($host, $user, $pass, $aDatabases[$index]);
      $content .= "--\r\n";
      $content .= "-- Database: `" . $aDatabases[$index] . "` End\r\n";
      $content .= "--\r\n";
      $content .= "\r\n";
    }
    $content .= "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n";
    $content .= "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n";
    $content .= "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\r\n";
    $content .= "\r\n";
    $backup_name = ($fileName ? $fileName : 'DBExport') . '_' . date('Y-m-d') . '_' . date('H-i-s') . '.sql';
    ob_get_clean();
    header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary");
    header('Content-Length: ' . (function_exists('mb_strlen') ? mb_strlen($content, '8bit') : strlen($content)));
    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
    echo $content;
    exit;
  }

}
//$aDBs = array('phs_smb_admin', 'phs_smb_rasco');
//PhDBExport("localhost", "root", "RootPass", $aDBs);
