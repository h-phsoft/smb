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

class cClncTreatmentProcedures {

  var $Id;
  var $TreatmentId;
  var $ProcedureId;
  var $VatId = 0;
  var $Qnt = 1.000;
  var $Price = 0.000;
  var $Discount = 0.000;
  var $Amt = 0.000;
  var $VatValue = 0;
  var $VatAmt = 0;
  var $Datetime = 'current_timestamp()';
  var $Description = 'NULL';
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  // 
  var $oProcedure;
  var $oTreatment; 
  var $oVat;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `treatment_id`, `procedure_id`, `vat_id`, `qnt`, `price`, `discount`'
      . ', `amt`, `vat_value`, `vat_amt`, `datetime`, `description`, `ins_user`, `ins_date`'
      . ', `upd_user`, `upd_date`'
      . ' FROM `clnc_treatment_procedures`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_treatment_procedures`';
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
    $cClass = new cClncTreatmentProcedures();
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
    $cClass = new cClncTreatmentProcedures();
    $cClass->Id = intval($res->fields('id'));
    $cClass->TreatmentId = intval($res->fields('treatment_id'));
    $cClass->ProcedureId = intval($res->fields('procedure_id'));
    $cClass->VatId = intval($res->fields('vat_id'));
    $cClass->Qnt = floatval($res->fields('qnt'));
    $cClass->Price = floatval($res->fields('price'));
    $cClass->Discount = floatval($res->fields('discount'));
    $cClass->Amt = floatval($res->fields('amt'));
    $cClass->VatValue = floatval($res->fields('vat_value'));
    $cClass->VatAmt = floatval($res->fields('vat_amt'));
    $cClass->Datetime = $res->fields('datetime');
    $cClass->Description = $res->fields('description');
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    // 
    $cClass->oProcedure = cClncProcedure::getInstance($cClass->ProcedureId);
    $cClass->oTreatment = cClncTreatment::getInstance($cClass->TreatmentId); 
    $cClass->oVat = cPhsCode::getInstance(cPhsCode::VAT, $cClass->VatId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_treatment_procedures` ('
        . '  `treatment_id`, `procedure_id`, `vat_id`, `qnt`, `price`, `discount`, `amt`'
        . ', `vat_value`, `vat_amt`, `description`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->TreatmentId . '"'
        . ', "' . $this->ProcedureId . '"'
        . ', "' . $this->VatId . '"'
        . ', "' . $this->Qnt . '"'
        . ', "' . $this->Price . '"'
        . ', "' . $this->Discount . '"'
        . ', "' . $this->Amt . '"'
        . ', "' . $this->VatValue . '"'
        . ', "' . $this->VatAmt . '"' 
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
      $vSQL = 'UPDATE `clnc_treatment_procedures` SET'
        . '  `treatment_id`="' . $this->TreatmentId . '"'
        . ', `procedure_id`="' . $this->ProcedureId . '"'
        . ', `vat_id`="' . $this->VatId . '"'
        . ', `qnt`="' . $this->Qnt . '"'
        . ', `price`="' . $this->Price . '"'
        . ', `discount`="' . $this->Discount . '"'
        . ', `amt`="' . $this->Amt . '"'
        . ', `vat_value`="' . $this->VatValue . '"'
        . ', `vat_amt`="' . $this->VatAmt . '"' 
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
    $vSQL = 'DELETE FROM `clnc_treatment_procedures` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

