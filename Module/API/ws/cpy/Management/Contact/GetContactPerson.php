<?php

if (isset($oRest)) {

  $nContId = ph_Get_Post('nContId');
  $aArray = cMngContCont::getArray('`cont_id`="' . $nContId . '"');
  $aData = array();
  $idx = 0;
  foreach ($aArray as $person) {
    $aData[$idx] = array(
      'Id' => $person->Id,
      'Name' => $person->Name,
    );
    $idx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}
