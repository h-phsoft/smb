<?php

if (isset($oRest)) {

  $nType = intval(ph_Get_Post('nType'));
  $nBox = ph_Get_Post('nBox');
  $dDate = date_format(date_create(ph_Get_Post('dDate')), 'Y-m-d');
  $ddDate = $dDate;

  $vWhere = '(1=2)';
  switch ($nType) {
    case -1:
      $ddDate = cFundDiary::getDateBefore($nBox, $dDate);
      break;
    case 1:
      $ddDate = cFundDiary::getDateAfter($nBox, $dDate);
      break;
  }
  if ($ddDate != '') {
    $dDate = $ddDate;
  }
  $vWhere = '(`box_id`="' . $nBox . '" AND `date`=STR_TO_DATE("' . $dDate . '","%Y-%m-%d"))';
  $aList = cFundDiary::getArray($vWhere);
  $aBalance = cFundDiary::getaBalances($nBox, $dDate);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
        'Id' => $element->Id,
        'BId' => $element->BoxId,
        'CCId' => $element->CurnId,
        'CCode' => $element->CurnCode,
        'CColor' => $element->CurnColor,
        'TId' => $element->TypeId,
        'TName' => $element->TypeName,
        'AId' => $element->AccId,
        'ANum' => $element->AccNum,
        'AName' => $element->AccName,
        'CId' => $element->CostId,
        'CNum' => $element->CostNum,
        'CName' => $element->CostName,
        'Date' => date_format(date_create($element->Date), 'Y-m-d'),
        'Print' => $element->Print,
        'Deb' => $element->Deb,
        'Crd' => $element->Crd,
        'CAmt' => $element->CAmt,
        'Rate' => $element->Rate,
        'Amt' => $element->Amt,
        'Rem' => $element->Rem,
        'Attach' => $vMediaPath . 'diary/' . $element->Attach,
    );
    $nIdx++;
  }
  $aBlncs = array();
  $nIdx = 0;
  foreach ($aBalance as $element) {
    $aBlncs[$nIdx] = array(
        'vCode' => $element['code'],
        'nOpen' => $element['blnc']
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
      'Status' => true,
      'Message' => 'Done',
      'Date' => $dDate,
      'aBlncs' => $aBlncs,
      'Data' => $aData
  ));
}