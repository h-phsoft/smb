<?php

if (isset($oRest)) {

  $oRest->setMessage(getLabel('Invalid username or password'));
  $nUId = -99;
  $vName = '';
  $nType = -99;
  $vUName = ph_Get_Post('vUsername');
  $vUPass = ph_Get_Post('vPassword');
  if ($vUName == MASTER_KEYN && $vUPass == MASTER_KEYP) {
    $oUser = cCpyUser::getInstance(-1);
  } else {
    $vPass = ph_EncodePassword($vUPass);
    $oUser = cCpyUser::checkUserLogin($vUName, $vPass);
  }
  $oRest->setMessage(getLabel('Invalid username or password ' . $oUser->Id));
  if ($oUser->Id != -999) {
    $vLang = cCpyPref::getPref('def_language');
    $oLang = cPhsLang::getInstanceByCode($vLang);
    $oToken = cCpyToken::getNewInstance(ph_ServerVar('REMOTE_ADDR'), ' +30 day', $oUser->Id);
    $aGUId = array(
        'UId' => $oUser->Id,
        'GId' => $oToken->Gid,
        'WPId' => cCpyPref::getPref('Def_Workperiod'),
        'vLang' => $oLang->Code,
        'vDir' => $oLang->Direction,
        'SDate' => $oToken->Sdate,
        'EDate' => $oToken->Edate,
        'Status' => 1
    );
    ph_SetSession('User', serialize($oUser));
    ph_SetSession('GUId', serialize($aGUId));
    $oRest->setRowData(array(
        'Status' => true,
        'Message' => getLabel('Welcome') . ' ' . $oUser->Name,
        'Data' => $oUser,
        "GUId" => $aGUId
    ));
  }
}