<?php

if (isset($oRest)) {

  $oUser = unserialize(ph_Session('User'));
  $nId = ph_Get_Post('id');
  $nCId = ph_Get_Post('nCId');
  $nDId = ph_Get_Post('nDId');
  $nPId = ph_Get_Post('nPId');
  $nProc = ph_Get_Post('nProcId');
  $nQnt = ph_Get_Post('nQnt');
  $nPrice = ph_Get_Post('nPrice');
  $nAmt = ph_Get_Post('nAmt');
  $oProcedure = cClncProcedure::getInstance($nProc);
  $nVatValue = $oProcedure->Vat;
  $nVatAmt = 0;
  if ($oProcedure->VatId === 1) {
    $nVatAmt = $nAmt * $nVatValue / 100;
  } else if ($oProcedure->VatId === 2) {
    $nVatAmt = $nVatValue * $nQnt;
  }

  $nCount = intval(ph_GetDBValue('count(*)', '`clnc_treatment`', '`clinic_id`="' . $nCId . '" AND `patient_id`="' . $nPId . '" AND `status_id`=1'));
  if ($nCount == 0) {
    $oInstance = new cClncTreatment();
    $oInstance->ClinicId = $nCId;
    $oInstance->DoctorId = $nDId;
    $oInstance->PatientId = $nPId;
    $oInstance->IUserId = $oUser->Id;
    $oInstance->save($oUser->Id);
  }
  $nTreatId = intval(ph_GetDBValue('`id`', '`clnc_treatment`', '`clinic_id`="' . $nCId . '" AND `patient_id`="' . $nPId . '" AND `status_id`=1'));
  if ($nTreatId > 0) {
    $oTInstance = new cClncTreatmentProcedures();
    $oTInstance->TreatmentId = $nTreatId;
    $oTInstance->ProcedureId = $nProc;
    $oTInstance->Qnt = $nQnt;
    $oTInstance->Price = $nPrice;
    $oTInstance->Amount = $nAmt;
    $oTInstance->VatId = $oProcedure->VatId;
    $oTInstance->VatValue = $nVatValue;
    $oTInstance->VatAmount = $nVatAmt;
    $oTInstance->IUserId = $oUser->Id;
    $oTInstance->save($oUser->Id);
  }

  $response = array(
      'Status' => true,
      'Message' => 'Done'
  );
  $oRest->setRowData($response);
}