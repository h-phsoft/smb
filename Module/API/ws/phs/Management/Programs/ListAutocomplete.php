<?php

if (isset($oRest)) {

  $term = ph_Get_Post('term');
  $vWhere = '';
  if (isset($term)) {
    $vWhere .= 'UPPER(concat(`id`,"-",`sys_name`,"-",`name`)) LIKE UPPER("%' . $term . '%")';
  }
  $aList = cPhsProgram::getQArray($vWhere, '`sys_id`, `prog_id`, `ord`, `id`', 1, 100);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
      'id' => $element->Id,
      'value' => $element->Id,
      'label' => $element->Id . '-' . $element->vSystem . '-' . $element->Name
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => $aData
  ));
}