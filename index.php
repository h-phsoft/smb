<?phpif (session_id() == "") {  @session_start();}?><?php include_once "Module/PhCFG.php" ?><?php include_once "Module/MySQL.php" ?><?php include_once "Module/PhFunctions.php" ?><?php include_once "Module/CpyFunctions.php" ?><?php$dbName = ph_Session('dbName');if ($dbName === null || $dbName === '') {  ph_SetSession('dbName', PHS_SMB_ADMIN);}cPhsPref::getDBKeys();$vLang = cPhsPref::getPref('def_language');$vTheme = cPhsPref::getPref('def_theme');$bASide = cPhsPref::isPref('def_gui_aside');$bASideMinimized = cPhsPref::isPref('Def_GUI_ASide_Min');$bTopMenu = cPhsPref::isPref('def_gui_top_menu');$bTopButtons = cPhsPref::isPref('def_gui_top_btns');$aPhLabels = array();ph_PrepareGets();ph_PreparePosts();$vRootPath = PHS_ROOT_PATH;$vMediaPath = PHS_MEDIA_PATH;$nRootLen = strlen($vRootPath);$vMainPage = 'page404.php';$aURI = getURIArray();if (count($aURI) >= PHS_URI_IDX && isset($aURI[PHS_URI_IDX])) {  $vCopy = $aURI[PHS_URI_IDX];} else {  $vCopy = PHS_DEFAULT_COPY;}$oCopy = cPhsCpy::getInstanceByURL($vCopy);if ($oCopy->Id !== -999) {  ph_SetSession('dbName');  ph_SetSession('dbName', $oCopy->dbName);  global $conn;  $conn = ph_Connect();  $vMediaCopyRootPath = str_ireplace('{{COPY}}', $vCopy, PHS_MEDIA_COPY_PATH);  cCpyPref::getDBKeys();  $vLang = cCpyPref::getPref('def_language');  $vTheme = cCpyPref::getPref('def_theme');  $bASide = cCpyPref::isPref('def_gui_aside');  $bASideMinimized = cCpyPref::isPref('def_gui_aside_min');  $bIsASideHidden = cCpyPref::isPref('Def_GUI_ASide_Hidden');  $bTopMenu = cCpyPref::isPref('def_gui_top_menu');  $bTopButtons = cCpyPref::isPref('def_gui_top_btns');  $bIsWorkPeriod = cCpyPref::isPref('isWorkperiod');  $oWorkperiod = cCpyWPeriod::getInstance(0);  $GUID = ph_Session('GUId');  $aGUId = null;  if ($GUID != null && $GUID != '') {    $aGUId = unserialize(ph_Session('GUId'));  }  if ($aGUId != null && is_array($aGUId)) {    if (isset($aGUId['WPId'])) {      $oWorkperiod = cCpyWPeriod::getInstance($aGUId['WPId']);    }    if (isset($aGUId['vLang'])) {      $vLang = $aGUId['vLang'];    }  }  $oLang = cPhsLang::getInstanceByCode($vLang);  $vDir = 'ltr';  $vCode = 'en';  if ($oLang->Code) {    $vCode = $oLang->Code;  }  if ($oLang->Direction) {    $vDir = strtolower($oLang->Direction);  }  cCpyPref::$Prefs = cCpyPref::loadDBKeys();  $vHTMLDirection = 'lang="' . $vLang . '" direction="' . $vDir . '" style="direction: ' . $vDir . ';"';  $vStyles = 'section/index_styles_' . $vTheme . '_' . $vDir . '.php';  $vURI = ph_ServerVar('REQUEST_URI');  if ($vURI !== '' && file_exists("Module/PhLabels-" . $vCode . ".php")) {    include_once "Module/PhLabels-" . $vCode . ".php";  } else {    include_once "Module/PhLabels-" . $vLang . ".php";  }  initLabels();  $vCopyRootPath = $vRootPath . $vCopy;  ph_SetSession('copyName');  ph_SetSession('copyName', $vCopy);  $requestPage = substr($vURI, $nRootLen + strlen($vCopy) + 1);  $requestProg = cPhsProgram::getInstanceByFile($requestPage);  $vPage = 'app/' . $requestPage . '.php';  $vPageStyles = '';  $vPageScript = '';  if ($requestProg->Id != -999) {    $vPageStyles = ($requestProg->CSS === null || $requestProg->CSS === '' ? '' : 'assets/css/' . $requestProg->CSS . '.css');    $vPageScript = ($requestProg->JS === null || $requestProg->JS === '' ? '' : 'assets/js/' . $requestProg->JS . '.js');  }  $vMainPage = 'login.php';  $sUser = ph_Session('User');  if ($sUser != null && $sUser != '') {    $oUser = unserialize(ph_Session('User'));    if ($oUser != null && $oUser->Id !== -999) {      if ($requestPage === 'logout') {        ph_SetSession('User');        ph_SetSession('GUId');      } else {        $vMainPage = 'main.php';        if ($requestProg->Open === 1) {          $vMainPage = $vPage;        }      }    }  }}include $vMainPage;