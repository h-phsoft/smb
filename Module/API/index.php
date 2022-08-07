<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Pragma: no-cache");
?>
<?php

if (session_id() == "") {
  @session_start();
}
?>
<?php include_once "../PhsClasses/cPhsRestBase.php" ?>
<?php include_once "../PhsClasses/cPhsRest.php" ?>
<?php include_once "../PhCFG.php" ?>
<?php include_once "../MySQL.php" ?>
<?php include_once "../PhFunctions.php" ?>
<?php include_once "../CpyFunctions.php" ?>
<?php

ph_PrepareGets();
ph_PreparePosts();

$vMessage = getLabel('Bad Request');
$response = array(
    'Status' => false,
    'Message' => getLabel('Bad Request')
);

$aCDId = ph_Get_Post('vCDId');
$aGUId = ph_Get_Post('vGUId');
$vOperation = ph_Get_Post('vOperation');
$vCpy = $aCDId['vCId'];
$bIsAPIOk = true;
$oRest = new PhsRest();
$oRest->setHttpStatus(200);

$oRest->setMessage(getLabel('Unknown Copy'));
$oCopy = cPhsCpy::getInstanceByGId($aCDId['vCId']);
if ($oCopy->Id != -999) {
  global $conn;
  $conn = ph_Connect($oCopy->dbName);
  cCpyToken::deleteExpired();

  cCpyPref::$Prefs = cCpyPref::loadDBKeys();
  if (isset($aGUId['vLang']) && file_exists("../PhLabels-" . $aGUId['vLang'] . ".php")) {
    include_once "../PhLabels-" . $aGUId['vLang'] . ".php";
  } else {
    include_once "../PhLabels-en.php";
  }
  initLabels();

  if ($oCopy->Devices > 0 || $oCopy->Restriction > 0) {
    $oRest->setMessage(getLabel('Device not Mathced'));
    $bIsAPIOk = false;
    if ($aCDId['vCId'] == $oCopy->GId) {
      $oRest->setMessage(getLabel('Invalid Device Id'));
      $oDevice = cCpyDevice::getInstanceByGId($aCDId['vDId']);
      if ($oDevice->Id != -999) {
        $oRest->setMessage(getLabel('Device is not Active'));
        if ($oDevice->StatusId == 1) {
          $oRest->setMessage(getLabel('Device not Available now'));
          if ($oDevice->isAvailable()) {
            $bIsAPIOk = true;
          }
        }
      }
    }
  }
  if ($bIsAPIOk) {
    $oRest->setMessage(getLabel('Invalid User Status'));
    $oUser = cCpyUser::getInstance($aGUId['UId']);
    if ($oUser->StatusId == 1) {
      $oWPeriod = cCpyWPeriod::getInstance($aGUId['WPId']);
      $vMediaPath = PHS_MEDIA_PATH;
      $vMediaCopyRootPath = str_ireplace('{{COPY}}', $oCopy->URL, PHS_MEDIA_COPY_PATH);
      $vAttacheRootPath = PHS_SERVER_ROOT_PATH . 'assets/media/' . $oCopy->URL . '/';
      $vMediaRootPath = $vAttacheRootPath;
      if ($oCopy->URL != '' && !file_exists($vAttacheRootPath)) {
        mkdir($vAttacheRootPath);
      }
      $oProgram = cPhsProgram::getInstance(intval(ph_Get_Post('progId')));
      $oUserPerms = null;
      if (($oUser->oGrp != null) && ($oProgram != null)) {
        $oUserPerms = $oUser->oGrp->getPermission($oProgram->Id);
      }
      $serviceName = 'ws/' . str_ireplace('-', '/', $vOperation) . '.php';
      $oRest->setMessage(getLabel('Unknown Service'));
      if (file_exists($serviceName)) {
        $oRest->setMessage('No Permissions');
        include $serviceName;
      }
    }
  }
}
$oRest->returnResponse();
