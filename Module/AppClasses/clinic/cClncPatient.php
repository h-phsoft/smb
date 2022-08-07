<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 *
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.22.220220.2202
 *
 * @author Haytham
 * @version 2.0.22.220220.2202
 * @update 2022/04/29 05:27
 *
 */

class cClncPatient {

  var $Id;
  var $ClinicId;
  var $Name;
  var $Num;
  var $Birthday;
  var $GenderId = 1;
  var $MartialId = 1;
  var $NatId = 0;
  var $VisaId = 1;
  var $HormonalId = 2;
  var $SmokedId = 2;
  var $AlcoholicId = 2;
  var $PregnancyId = 2;
  var $BreastfeedId = 2;
  var $NatNum = 'NULL';
  var $IdtypeId = 1;
  var $Idnum = 'NULL';
  var $Mobile;
  var $Land1 = 'NULL';
  var $Land2 = 'NULL';
  var $JobName;
  var $Addr;
  var $ChronicDiseases;
  var $PreOperations;
  var $MedicinesUsed;
  var $Patrem;
  var $Rem;
  var $Hownow;
  var $HownowId;
  var $Email = 'NULL';
  var $Company = 'NULL';
  var $Langs = 'NULL';
  var $Description = 'NULL';
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  //
  var $oAlcoholic;
  var $oHowNow;
  var $oBreastfeed;
  var $oClinic;
  var $oGender;
  var $oHormonal;
  var $oIdtype;
  var $oMartial;
  var $oNat;
  var $oPregnancy;
  var $oSmoked;
  var $oVisa;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `clinic_id`, `name`, `num`, `birthday`, `gender_id`, `martial_id`'
            . ', `nat_id`, `visa_id`, `hormonal_id`, `smoked_id`, `alcoholic_id`, `pregnancy_id`, `breastfeed_id`'
            . ', `nat_num`, `idtype_id`, `idnum`, `mobile`, `land1`, `land2`, `job_name`'
            . ', `addr`, `chronic_diseases`, `pre_operations`, `medicines_used`, `patrem`, `rem`,`hownowid`,`hownow`'
            . ', `email`, `company`, `langs`, `description`, `ins_user`, `ins_date`, `upd_user`'
            . ', `upd_date`'
            . ' FROM `clnc_patient`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $sSQL .= ' ORDER BY ' . $vOrder;
    }
    if ($vLimit != '') {
      $sSQL .= ' LIMIT ' . $vLimit;
    }
    return $sSQL;
  }

  public static function getCount($vWhere = '') {
    $nCount = 0;
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_patient`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    $res = ph_Execute($sSQL);
    if ($res != '' && !$res->EOF) {
      $nCount = intval($res->fields('nCnt'));
      $res->Close();
    }
    return $nCount;
  }

  public static function getArray($vWhere = '', $vOrder = '', $nPage = 0, $nPageSize = 0) {
    $aArray = array();
    $nIdx = 0;
    $vLimit = '';
    if ($nPage != 0 && $nPageSize != 0) {
      $vLimit = ((($nPage - 1) * $nPageSize)) . ', ' . $nPageSize;
    }
    if ($vOrder == '') {
      $vOrder = '`id`';
    }
    $res = ph_Execute(self::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = self::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cClncPatient();
    $res = ph_Execute(self::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cClncPatient();
    $cClass->Id = intval($res->fields('id'));
    $cClass->ClinicId = intval($res->fields('clinic_id'));
    $cClass->Name = $res->fields('name');
    $cClass->Num = $res->fields('num');
    $cClass->Birthday = $res->fields('birthday');
    $cClass->GenderId = intval($res->fields('gender_id'));
    $cClass->MartialId = intval($res->fields('martial_id'));
    $cClass->NatId = intval($res->fields('nat_id'));
    $cClass->VisaId = intval($res->fields('visa_id'));
    $cClass->HormonalId = intval($res->fields('hormonal_id'));
    $cClass->SmokedId = intval($res->fields('smoked_id'));
    $cClass->AlcoholicId = intval($res->fields('alcoholic_id'));
    $cClass->PregnancyId = intval($res->fields('pregnancy_id'));
    $cClass->BreastfeedId = intval($res->fields('breastfeed_id'));
    $cClass->NatNum = $res->fields('nat_num');
    $cClass->IdtypeId = intval($res->fields('idtype_id'));
    $cClass->Idnum = $res->fields('idnum');
    $cClass->Mobile = $res->fields('mobile');
    $cClass->Land1 = $res->fields('land1');
    $cClass->Land2 = $res->fields('land2');
    $cClass->JobName = $res->fields('job_name');
    $cClass->Addr = $res->fields('addr');
    $cClass->ChronicDiseases = $res->fields('chronic_diseases');
    $cClass->PreOperations = $res->fields('pre_operations');
    $cClass->MedicinesUsed = $res->fields('medicines_used');
    $cClass->Patrem = $res->fields('patrem');
    $cClass->Rem = $res->fields('rem');
    $cClass->Hownow = $res->fields('hownow');
    $cClass->HownowId = $res->fields('hownowid');
    $cClass->Email = $res->fields('email');
    $cClass->Company = $res->fields('company');
    $cClass->Langs = $res->fields('langs');
    $cClass->Description = $res->fields('description');
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    //
    $cClass->oAlcoholic = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->AlcoholicId);
    $cClass->oHowNow = cCpyCode::getInstance(cCpyCode::CLNC_HOWNOW, $cClass->HownowId);
    $cClass->oBreastfeed = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->BreastfeedId);
    $cClass->oClinic = cClncClinic::getInstance($cClass->ClinicId);
    $cClass->oGender = cPhsCode::getInstance(cPhsCode::GENDER, $cClass->GenderId);
    $cClass->oHormonal = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->HormonalId);
    $cClass->oIdtype = cPhsCode::getInstance(cPhsCode::IDTYPE, $cClass->IdtypeId);
    $cClass->oMartial = cPhsCode::getInstance(cPhsCode::MARTIAL, $cClass->MartialId);
    $cClass->oNat = cPhsCodNationality::getInstance($cClass->NatId);
    $cClass->oPregnancy = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->PregnancyId);
    $cClass->oSmoked = cPhsCode::getInstance(cPhsCode::YES_NO, $cClass->SmokedId);
    $cClass->oVisa = cPhsCode::getInstance(cPhsCode::VISA, $cClass->VisaId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_patient` ('
              . '  `clinic_id`, `name`, `num`, `birthday`, `gender_id`, `martial_id`, `nat_id`'
              . ', `visa_id`, `hormonal_id`, `smoked_id`, `alcoholic_id`, `pregnancy_id`, `breastfeed_id`, `nat_num`'
              . ', `idtype_id`, `idnum`, `mobile`, `land1`, `land2`, `job_name`, `addr`'
              . ', `chronic_diseases`, `pre_operations`, `medicines_used`, `patrem`, `rem`,`hownowid`,`hownow`, `email`'
              . ', `company`, `langs`, `description`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->ClinicId . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->Num . '"'
              . ', STR_TO_DATE("' . $this->Birthday . '","%Y-%m-%d")'
              . ', "' . $this->GenderId . '"'
              . ', "' . $this->MartialId . '"'
              . ', "' . $this->NatId . '"'
              . ', "' . $this->VisaId . '"'
              . ', "' . $this->HormonalId . '"'
              . ', "' . $this->SmokedId . '"'
              . ', "' . $this->AlcoholicId . '"'
              . ', "' . $this->PregnancyId . '"'
              . ', "' . $this->BreastfeedId . '"'
              . ', "' . $this->NatNum . '"'
              . ', "' . $this->IdtypeId . '"'
              . ', "' . $this->Idnum . '"'
              . ', "' . $this->Mobile . '"'
              . ', "' . $this->Land1 . '"'
              . ', "' . $this->Land2 . '"'
              . ', "' . $this->JobName . '"'
              . ', "' . $this->Addr . '"'
              . ', "' . $this->ChronicDiseases . '"'
              . ', "' . $this->PreOperations . '"'
              . ', "' . $this->MedicinesUsed . '"'
              . ', "' . $this->Patrem . '"'
              . ', "' . $this->Rem . '"'
              . ', "' . $this->HownowId . '"'
              . ', "' . $this->Hownow . '"'
              . ', "' . $this->Email . '"'
              . ', "' . $this->Company . '"'
              . ', "' . $this->Langs . '"'
              . ', "' . $this->Description . '"'
              . ', "' . $nUId . '"'
              . ')';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {
        $nId = ph_InsertedId();
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } else {
      $nId = $this->Id;
      $vSQL = 'UPDATE `clnc_patient` SET'
              . '  `clinic_id`="' . $this->ClinicId . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `num`="' . $this->Num . '"'
              . ', `birthday`=STR_TO_DATE("' . $this->Birthday . '","%Y-%m-%d")'
              . ', `gender_id`="' . $this->GenderId . '"'
              . ', `martial_id`="' . $this->MartialId . '"'
              . ', `nat_id`="' . $this->NatId . '"'
              . ', `visa_id`="' . $this->VisaId . '"'
              . ', `hormonal_id`="' . $this->HormonalId . '"'
              . ', `smoked_id`="' . $this->SmokedId . '"'
              . ', `alcoholic_id`="' . $this->AlcoholicId . '"'
              . ', `pregnancy_id`="' . $this->PregnancyId . '"'
              . ', `breastfeed_id`="' . $this->BreastfeedId . '"'
              . ', `nat_num`="' . $this->NatNum . '"'
              . ', `idtype_id`="' . $this->IdtypeId . '"'
              . ', `idnum`="' . $this->Idnum . '"'
              . ', `mobile`="' . $this->Mobile . '"'
              . ', `land1`="' . $this->Land1 . '"'
              . ', `land2`="' . $this->Land2 . '"'
              . ', `job_name`="' . $this->JobName . '"'
              . ', `addr`="' . $this->Addr . '"'
              . ', `chronic_diseases`="' . $this->ChronicDiseases . '"'
              . ', `pre_operations`="' . $this->PreOperations . '"'
              . ', `medicines_used`="' . $this->MedicinesUsed . '"'
              . ', `patrem`="' . $this->Patrem . '"'
              . ', `rem`="' . $this->Rem . '"'
              . ', `hownowid`="' . $this->HownowId . '"'
              . ', `hownow`="' . $this->Hownow . '"'
              . ', `email`="' . $this->Email . '"'
              . ', `company`="' . $this->Company . '"'
              . ', `langs`="' . $this->Langs . '"'
              . ', `description`="' . $this->Description . '"'
              . ', `upd_user`="' . $nUId . '"'
              . ' WHERE `id`="' . $this->Id . '"';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `clnc_patient` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
