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
 * @update 2022/04/25 22:08
 *
 */

class cClncInvoice {

  var $Id;
  var $ClinicId;
  var $PatientId;
  var $Num;
  var $Date = 'current_timestamp()';
  var $DiscountId = 0;
  var $DiscountValue = 0.000;
  var $DiscountAmt = 0.000;
  var $DiscountReason = 'NULL';
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  //
  var $oClinic;
  var $oDiscount; 
  var $oPatient; 

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `clinic_id`, `patient_id`, `num`, `date`, `discount_id`, `discount_value`'
      . ', `discount_amt`, `discount_reason`, `ins_user`, `ins_date`, `upd_user`, `upd_date`'
      . ' FROM `clnc_invoice`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_invoice`';
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
    $cClass = new cClncInvoice();
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
    $cClass = new cClncInvoice();
    $cClass->Id = intval($res->fields('id'));
    $cClass->ClinicId = intval($res->fields('clinic_id'));
    $cClass->PatientId = intval($res->fields('patient_id'));
    $cClass->Num = intval($res->fields('num'));
    $cClass->Date = $res->fields('date');
    $cClass->DiscountId = intval($res->fields('discount_id'));
    $cClass->DiscountValue = floatval($res->fields('discount_value'));
    $cClass->DiscountAmt = floatval($res->fields('discount_amt'));
    $cClass->DiscountReason = $res->fields('discount_reason');
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    //
    $cClass->oClinic = cClncClinic::getInstance($cClass->ClinicId);
    $cClass->oDiscount = cPhsCode::getInstance(cPhsCode::DISCOUNT_TYPE, $cClass->DiscountId); 
    $cClass->oPatient = cClncPatient::getInstance($cClass->PatientId); 
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_invoice` ('
        . '  `clinic_id`, `patient_id`, `num`, `date`, `discount_id`, `discount_value`, `discount_amt`'
        . ', `discount_reason`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->ClinicId . '"'
        . ', "' . $this->PatientId . '"'
        . ', "' . $this->Num . '"'
        . ', STR_TO_DATE("' . $this->Date . '","%Y-%m-%d")'
        . ', "' . $this->DiscountId . '"'
        . ', "' . $this->DiscountValue . '"'
        . ', "' . $this->DiscountAmt . '"'
        . ', "' . $this->DiscountReason . '"'
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
      $vSQL = 'UPDATE `clnc_invoice` SET'
        . '  `clinic_id`="' . $this->ClinicId . '"'
        . ', `patient_id`="' . $this->PatientId . '"'
        . ', `num`="' . $this->Num . '"'
        . ', `date`=STR_TO_DATE("' . $this->Date . '","%Y-%m-%d")'
        . ', `discount_id`="' . $this->DiscountId . '"'
        . ', `discount_value`="' . $this->DiscountValue . '"'
        . ', `discount_amt`="' . $this->DiscountAmt . '"'
        . ', `discount_reason`="' . $this->DiscountReason . '"'
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
    $vSQL = 'DELETE FROM `clnc_invoice` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

