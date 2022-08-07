<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $aPerms = ph_Get_Post('permissions');
  foreach ($aPerms as $perms) {
    $vSQL = 'UPDATE `cpy_perm` SET'
      . ' `isOK`="' . $perms['isOK'] . '"'
      . ',`ins`="' . $perms['ins'] . '"'
      . ',`upd`="' . $perms['upd'] . '"'
      . ',`del`="' . $perms['del'] . '"'
      . ',`qry`="' . $perms['qry'] . '"'
      . ',`prt`="' . $perms['prt'] . '"'
      . ',`cmt`="' . $perms['cmt'] . '"'
      . ',`rvk`="' . $perms['rvk'] . '"'
      . ',`exp`="' . $perms['exp'] . '"'
      . ',`imp`="' . $perms['imp'] . '"'
      . ',`spc`="' . $perms['spc'] . '"'
      . ' WHERE (`id`="' . $perms['nId'] . '")';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done'
      ));
    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      $oRest->setMessage($vMsgs);
      throw new Exception($vMsgs);
    }
  }
}
