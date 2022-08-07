<?php

if (isset($oRest)) {

  $nUId = ph_Get_Post('nUId');

  $aList = cCpyNotification::getArray('`status_id`="1" AND `user_id` IN (-9,' . $nUId . ')');
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    if ($element->UserId == $nId) {
      $element->seen();
    }
    $aData[$nIdx] = array(
      'nId' => $element->Id,
      'nUserId' => $element->UserId,
      'nType' => $element->Type,
      'nStatus' => $element->StatuId,
      'vTitle' => $element->Title,
      'vIcon' => $element->Icon,
      'vBody' => $element->Body,
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => getLabel('Done'),
    'Data' => $aData
  ));
}