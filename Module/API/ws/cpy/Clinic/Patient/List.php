<?php

if (isset($oRest)) {

  $page = ph_Get_Post('page');
  $size = ph_Get_Post('size');
  $sorters = ph_Get_Post('sorters');
  $filter = ph_Get_Post('filters');
  $aFields = array(
      'nId' => array(
          'Name' => '`id`',
          'Cond' => '`id`="COND_VALUE"'
      ),
      'nClinicId' => array(
          'Name' => '`clinic_id`',
          'Cond' => '`clinic_id`="COND_VALUE"'
      ),
      'vName' => array(
          'Name' => '`name`',
          'Cond' => '`name` LIKE "%COND_VALUE%"'
      ),
      'vNum' => array(
          'Name' => '`num`',
          'Cond' => '`num` LIKE "%COND_VALUE%"'
      ),
      'dBirthday' => array(
          'Name' => '`birthday`',
          'Cond' => '`birthday`=STR_TO_DATE("COND_VALUE", "%Y-%m-%d")'
      ),
      'nGenderId' => array(
          'Name' => '`gender_id`',
          'Cond' => '`gender_id`="COND_VALUE"'
      ),
      'nMartialId' => array(
          'Name' => '`martial_id`',
          'Cond' => '`martial_id`="COND_VALUE"'
      ),
      'nNatId' => array(
          'Name' => '`nat_id`',
          'Cond' => '`nat_id`="COND_VALUE"'
      ),
      'nVisaId' => array(
          'Name' => '`visa_id`',
          'Cond' => '`visa_id`="COND_VALUE"'
      ),
      'nHormonalId' => array(
          'Name' => '`hormonal_id`',
          'Cond' => '`hormonal_id`="COND_VALUE"'
      ),
      'nSmokedId' => array(
          'Name' => '`smoked_id`',
          'Cond' => '`smoked_id`="COND_VALUE"'
      ),
      'nAlcoholicId' => array(
          'Name' => '`alcoholic_id`',
          'Cond' => '`alcoholic_id`="COND_VALUE"'
      ),
      'nPregnancyId' => array(
          'Name' => '`pregnancy_id`',
          'Cond' => '`pregnancy_id`="COND_VALUE"'
      ),
      'nBreastfeedId' => array(
          'Name' => '`breastfeed_id`',
          'Cond' => '`breastfeed_id`="COND_VALUE"'
      ),
      'vNatNum' => array(
          'Name' => '`nat_num`',
          'Cond' => '`nat_num` LIKE "%COND_VALUE%"'
      ),
      'nIdtypeId' => array(
          'Name' => '`idtype_id`',
          'Cond' => '`idtype_id`="COND_VALUE"'
      ),
      'vIdnum' => array(
          'Name' => '`idnum`',
          'Cond' => '`idnum` LIKE "%COND_VALUE%"'
      ),
      'vMobile' => array(
          'Name' => '`mobile`',
          'Cond' => '`mobile` LIKE "%COND_VALUE%"'
      ),
      'vLand1' => array(
          'Name' => '`land1`',
          'Cond' => '`land1` LIKE "%COND_VALUE%"'
      ),
      'vLand2' => array(
          'Name' => '`land2`',
          'Cond' => '`land2` LIKE "%COND_VALUE%"'
      ),
      'vJobName' => array(
          'Name' => '`job_name`',
          'Cond' => '`job_name` LIKE "%COND_VALUE%"'
      ),
      'vAddr' => array(
          'Name' => '`addr`',
          'Cond' => '`addr` LIKE "%COND_VALUE%"'
      ),
      'vChronicDiseases' => array(
          'Name' => '`chronic_diseases`',
          'Cond' => '`chronic_diseases` LIKE "%COND_VALUE%"'
      ),
      'vPreOperations' => array(
          'Name' => '`pre_operations`',
          'Cond' => '`pre_operations` LIKE "%COND_VALUE%"'
      ),
      'vMedicinesUsed' => array(
          'Name' => '`medicines_used`',
          'Cond' => '`medicines_used` LIKE "%COND_VALUE%"'
      ),
      'vPatrem' => array(
          'Name' => '`patrem`',
          'Cond' => '`patrem` LIKE "%COND_VALUE%"'
      ),
      'vRem' => array(
          'Name' => '`rem`',
          'Cond' => '`rem` LIKE "%COND_VALUE%"'
      ),
      'vHownow' => array(
          'Name' => '`hownow`',
          'Cond' => '`hownow` LIKE "%COND_VALUE%"'
      ),
      'vEmail' => array(
          'Name' => '`email`',
          'Cond' => '`email` LIKE "%COND_VALUE%"'
      ),
      'vCompany' => array(
          'Name' => '`company`',
          'Cond' => '`company` LIKE "%COND_VALUE%"'
      ),
      'vLangs' => array(
          'Name' => '`langs`',
          'Cond' => '`langs` LIKE "%COND_VALUE%"'
      ),
      'vDescription' => array(
          'Name' => '`description`',
          'Cond' => '`description` LIKE "%COND_VALUE%"'
      ),
      'vAlcoholicName' => array(
          'Name' => '`alcoholic_id`',
          'Cond' => '`alcoholic_id` IN (SELECT `id` FROM `phs_cod_yes_no` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vBreastfeedName' => array(
          'Name' => '`breastfeed_id`',
          'Cond' => '`breastfeed_id` IN (SELECT `id` FROM `phs_cod_yes_no` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vClinicName' => array(
          'Name' => '`clinic_id`',
          'Cond' => '`clinic_id` IN (SELECT `id` FROM `clnc_clinic` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vGenderName' => array(
          'Name' => '`gender_id`',
          'Cond' => '`gender_id` IN (SELECT `id` FROM `phs_cod_gender` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vHormonalName' => array(
          'Name' => '`hormonal_id`',
          'Cond' => '`hormonal_id` IN (SELECT `id` FROM `phs_cod_yes_no` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vIdtypeName' => array(
          'Name' => '`idtype_id`',
          'Cond' => '`idtype_id` IN (SELECT `id` FROM `phs_cod_idtype` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vMartialName' => array(
          'Name' => '`martial_id`',
          'Cond' => '`martial_id` IN (SELECT `id` FROM `phs_cod_martial` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vNatName' => array(
          'Name' => '`nat_id`',
          'Cond' => '`nat_id` IN (SELECT `id` FROM `phs_cod_nationality` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vPregnancyName' => array(
          'Name' => '`pregnancy_id`',
          'Cond' => '`pregnancy_id` IN (SELECT `id` FROM `phs_cod_yes_no` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vSmokedName' => array(
          'Name' => '`smoked_id`',
          'Cond' => '`smoked_id` IN (SELECT `id` FROM `phs_cod_yes_no` WHERE `name` LIKE "%COND_VALUE%")'
      ),
      'vVisaName' => array(
          'Name' => '`visa_id`',
          'Cond' => '`visa_id` IN (SELECT `id` FROM `phs_cod_visa` WHERE `name` LIKE "%COND_VALUE%")'
      ),
  );
  $vWhere = '';
  $vAnd = '';
  if (isset($filter) && is_array($filter)) {
    foreach ($filter as $field) {
      if (isset($aFields[$field['field']])) {
        $vWhere .= $vAnd . str_replace('COND_VALUE', $field['value'], $aFields[$field['field']]['Cond']);
        $vAnd = ' AND ';
      }
    }
  }
  $vOrder = '';
  $vComma = '';
  if (isset($sorters) && is_array($sorters)) {
    foreach ($sorters as $field) {
      if (isset($aFields[$field['field']])) {
        $vOrder .= $vComma . $aFields[$field['field']]['Name'] . ' ' . strtoupper($field['dir']);
        $vComma = ', ';
      }
    }
  }
  $nPages = 0;
  $nCount = cClncPatient::getCount($vWhere);
  if (isset($size) && intval($size) > 0) {
    $nPages = ceil($nCount / $size);
  }
  $aList = cClncPatient::getArray($vWhere, $vOrder, $page, $size);
  $aData = array();
  $nIdx = 0;
  foreach ($aList as $element) {
    $aData[$nIdx] = array(
        'nId' => $element->Id,
        'nClinicId' => $element->ClinicId,
        'vName' => $element->Name,
        'vNum' => $element->Num,
        'dBirthday' => date_format(date_create($element->Birthday), 'Y-m-d'),
        'nGenderId' => $element->GenderId,
        'nMartialId' => $element->MartialId,
        'nNatId' => $element->NatId,
        'nVisaId' => $element->VisaId,
        'nHormonalId' => $element->HormonalId,
        'nSmokedId' => $element->SmokedId,
        'nAlcoholicId' => $element->AlcoholicId,
        'nPregnancyId' => $element->PregnancyId,
        'nBreastfeedId' => $element->BreastfeedId,
        'vNatNum' => $element->NatNum,
        'nIdtypeId' => $element->IdtypeId,
        'vIdnum' => $element->Idnum,
        'vMobile' => $element->Mobile,
        'vLand1' => $element->Land1,
        'vLand2' => $element->Land2,
        'vJobName' => $element->JobName,
        'vAddr' => $element->Addr,
        'vChronicDiseases' => $element->ChronicDiseases,
        'vPreOperations' => $element->PreOperations,
        'vMedicinesUsed' => $element->MedicinesUsed,
        'vPatrem' => $element->Patrem,
        'vRem' => $element->Rem,
        'nHownowId' => $element->HownowId,
        'vHownow' => $element->Hownow,
        'vEmail' => $element->Email,
        'vCompany' => $element->Company,
        'vLangs' => $element->Langs,
        'vDescription' => $element->Description,
        'vAlcoholicName' => $element->oAlcoholic->Name,
        'vBreastfeedName' => $element->oBreastfeed->Name,
        'vClinicName' => $element->oClinic->Name,
        'vGenderName' => $element->oGender->Name,
        'vHormonalName' => $element->oHormonal->Name,
        'vIdtypeName' => $element->oIdtype->Name,
        'vMartialName' => $element->oMartial->Name,
        'vNatName' => $element->oNat->Nationality,
        'vPregnancyName' => $element->oPregnancy->Name,
        'vSmokedName' => $element->oSmoked->Name,
        'vVisaName' => $element->oVisa->Name,
    );
    $nIdx++;
  }
  $oRest->setRowData(array(
      'Status' => true,
      'Message' => getLabel('Done'),
      'Data' => array(
          'last_page' => $nPages,
          'data' => $aData
      )
  ));
}
