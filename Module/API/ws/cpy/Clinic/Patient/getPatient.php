<?php

if (isset($oRest)) {
  $nPId = ph_Get_Post('nPId');
  $dSDate = ph_Get_Post('SDate');
  $dEDate = ph_Get_Post('EDate');
  $nClinicId = ph_Session('UClinicId');

  $oPatient = cClncPatient::getInstance($nPId);
  $aPatientNotes = cClncPatientNote::getArray(
                  '`patient_id`="' . $oPatient->Id . '"'
                  . ' AND STR_TO_DATE(DATE_FORMAT(`datetime`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'
  );
  $aPatientTreats = cClncTreatmentProcedures::getArray(
                  '`clinic_id`="' . $nClinicId . '"'
                  . ' AND `patient_id`="' . $oPatient->Id . '"'
                  . ' AND STR_TO_DATE(DATE_FORMAT(`datetime`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'
  );
  $aPatientCard = cClncPatientCard::getArray(
                  '`clinic_id`="' . $nClinicId . '" AND'
                  . ' `patient_id`="' . $oPatient->Id . '"'
                  . ' AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'
  );
  $aPatientApps = cClncAppointment::getArray(
                  '`clinic_id`="' . $nClinicId . '" AND'
                  . ' `patient_id`="' . $oPatient->Id . '"'
                  . ' AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'
  );
  $nOpen = floatval(ph_GetDBValue('sum(`net`)', '`clnc_vpatient_card`', '`patient_id`="' . $oPatient->Id . '" AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y")<STR_TO_DATE("' . $dSDate . '","%d-%m-%Y")'));
  $nInvoices = floatval(ph_GetDBValue('sum(`net`)', '`clnc_vinvoice`', '`patient_id`="' . $oPatient->Id . '" AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'));
  $nPayments = floatval(ph_GetDBValue('sum(`amt`)', '`clnc_payment`', '`patient_id`="' . $oPatient->Id . '" AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'));
  $nDiscounts = floatval(ph_GetDBValue('sum(`amt`)', '`clnc_discount`', '`patient_id`="' . $oPatient->Id . '" AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'));
  $nRefunds = floatval(ph_GetDBValue('sum(`amt`)', '`clnc_refund`', '`patient_id`="' . $oPatient->Id . '" AND STR_TO_DATE(DATE_FORMAT(`date`,"%d-%m-%Y"),"%d-%m-%Y") BETWEEN STR_TO_DATE("' . $dSDate . '","%d-%m-%Y") AND STR_TO_DATE("' . $dEDate . '","%d-%m-%Y")'));
  $nNet = $nOpen + $nInvoices - $nPayments - $nDiscounts + $nRefunds;
  $response = array(
      'Status' => true,
      'Message' => 'Done',
      'Patient' => $oPatient,
      'Open' => $nOpen,
      'Invoices' => $nInvoices,
      'Payments' => $nPayments,
      'Discounts' => $nDiscounts,
      'Refunds' => $nRefunds,
      'Net' => $nNet,
      'aNotes' => $aPatientNotes,
      'aTreats' => $aPatientTreats,
      'aCard' => $aPatientCard,
      'aApps' => $aPatientApps,
  );
  $oRest->setRowData($response);
}