<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  cCpyPerm::refreshPermissions($nId, $oUser->Id);
  $aList = cCpyPerm::getArray('p.grp_id="' . $nId . '" AND (v.prog_id=0 OR v.prog_id>99)');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $object) {
    $vName = ''; //$object->ProgId . ' - ';
    $vName .= getLabel($object->SysName) . ' - ' . getLabel($object->ProgPName) . ' - ' . getLabel($object->ProgName);
    $aData[$nIdx] = array(
      'Id' => $object->Id,
      'ProgId' => $object->ProgId,
      'Name' => $vName,
      'isOK' => $object->isOK,
      'Insert' => $object->Insert,
      'Update' => $object->Update,
      'Delete' => $object->Delete,
      'Query' => $object->Query,
      'Print' => $object->Print,
      'Commit' => $object->Commit,
      'Revoke' => $object->Revoke,
      'Export' => $object->Export,
      'Import' => $object->Import,
      'Special' => $object->Special
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}
