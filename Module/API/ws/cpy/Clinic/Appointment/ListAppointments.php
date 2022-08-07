<?php

if (isset($oRest)) {

  $aGrps = array();
  $aGrps[0] = ph_Get_Post('nGrp1');
  $aGrps[1] = ph_Get_Post('nGrp2');
  $aGrps[2] = ph_Get_Post('nGrp3');
  $aGrps[3] = ph_Get_Post('nGrp4');
  $dSDate = ph_Get_Post('SDate');
  $dEDate = ph_Get_Post('EDate');
  $nClinicId = ph_Get_Post('UClinic');

  $aFids = array();
  $aFids[0] = '';
  $aFids[1] = array('lbl' => 'Clinic', 'fld' => '`clinic_name`');
  $aFids[2] = array('lbl' => 'Special', 'fld' => '`special_name`');
  $aFids[3] = array('lbl' => 'Doctor', 'fld' => '`doctor_name`');
  $aFids[4] = array('lbl' => 'Type', 'fld' => '`type_name`');
  $aFids[5] = array('lbl' => 'Status', 'fld' => '`status_name`');
  $aFids[6] = array('lbl' => 'Date', 'fld' => '`date`');
  $aFlds[7] = array('lbl' => 'Nationality', 'fld' => '`patient_nat_name`');
  $aFlds[9] = array('lbl' => 'Gender', 'fld' => '`patient_gender_name`');

  $nGrp = 0;
  $aGrpFlds = array();
  $vComma = '';
  $vGrpBy = '';
  $vOrdBy = '';
  $vSQL = 'SELECT ';
  for ($index = 0; $index < count($aGrps); $index++) {
    if ($aGrps[$index] != 0) {
      $vSQL .= $vComma . $aFids[$aGrps[$index]]['fld'] . ' AS grp' . $index;
      $vGrpBy .= $vComma . $aFids[$aGrps[$index]]['fld'];
      $vOrdBy .= $vComma . ' grp' . $index;
      $vComma = ',';
      $aGrpFlds[$nGrp] = array(
          'grp' => 'grp' . $index,
          'lbl' => $aFids[$aGrps[$index]]['lbl']
      );
      $nGrp++;
    }
  }
  $vSQL .= ', count(*) AS nCount';
  $vSQL .= ' FROM `clnc_vappointment`';
  $vSQL .= ' WHERE `clinic_id` = "' . $nClinicId . '" AND STR_TO_DATE(DATE_FORMAT(`date`, "%d-%m-%Y"), "%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '", "%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '", "%d-%m-%Y")';
  $vSQL .= ' Group By ' . $vGrpBy;
  $vSQL .= ' Order By ' . $vOrdBy;
  $aData = array();
  $nIdx = 0;
  $res = ph_Execute($vSQL);
  if ($res != '') {
    while (!$res->EOF) {
      $aData[$nIdx] = array();
      $nGrp = 0;
      for ($index = 0; $index < count($aGrpFlds); $index++) {
        $aData[$nIdx][$aGrpFlds[$index]['lbl']] = $res->fields($aGrpFlds[$index]['grp']);
        $nGrp++;
      }
      $aData[$nIdx]['Count'] = intval($res->fields('nCount'));
      $nIdx++;
      $res->MoveNext();
    }
    $res->Close();
  }
  $aDesc = array();
  $nGrp = 0;
  $vComma = '';
  $vTitle = 'Appointments per<br/>';
  for ($index = 0; $index < count($aGrpFlds); $index++) {
    $aDesc[$nGrp] = array(
        'title' => $aGrpFlds[$index]['lbl'],
        'field' => $aGrpFlds[$index]['lbl'],
        'hozAlign' => "left",
        'headerFilter' => "input"
    );
    $vTitle .= $vComma . $aGrpFlds[$index]['lbl'];
    $nGrp++;
    $vComma = ', ';
  }
  $aDesc[$nGrp] = array(
      'title' => 'Count',
      'field' => 'Count',
      'hozAlign' => "left",
      'headerFilter' => "input"
  );
  $vTitle .= '<br/>Between<br/>' . $dSDate . ' And ' . $dEDate;

  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Data' => $aData,
      'Columns' => $aDesc,
      'Title' => $vTitle
  );
  $oRest->setRowData($response);
}
