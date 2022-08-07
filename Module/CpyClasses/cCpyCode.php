<?php

class cCpyCode {

  var $Id = -999;
  var $Name = '';
  var $Rem = '';
  var $vTable = '';
  public static $aCodes = array(
      'document' => 'cpy_cod_doc',
      'nationality' => 'cpy_cod_nat',
      'language' => 'cpy_cod_language',
      'unit' => 'cpy_cod_unit',
      'str_trn_type' => 'str_cod_trn_type',
      'str_class1' => 'str_cod_spc1',
      'str_class2' => 'str_cod_spc2',
      'str_class3' => 'str_cod_spc3',
      'str_class4' => 'str_cod_spc4',
      'str_class5' => 'str_cod_spc5',
      'str_location1' => 'str_cod_loc1',
      'str_location2' => 'str_cod_loc2',
      'str_location3' => 'str_cod_loc3',
      'clnc_cod_hownow' => 'clnc_cod_hownow',
      'clnc_special' => 'clnc_special',
  );

  const DOCUMENT = 'document';
  const NATIONALITY = 'nationality';
  const LANGUAGE = 'language';
  const UNIT = 'unit';
  const COLOR = 'color';
  const SIZE = 'size';
  const CONTACT_CLASS = 'contact_class';
  const AIRLINE = 'airline';
  const SHIPLINE = 'shipline';
  const RAILLINE = 'railline';
  //
  const FINANCE_METHOD = 'fin_method';
  const FINANCE_CONTRACT = 'fin_contract';
  const FINANCE_KEYDOCS = 'fin_keydocs';
  //
  const CASH_TRANSFER = 'cash_transfer';
  //
  const STR_TRN_TYPE = 'str_trn_type';
  const STR_CLASSIFICATION1 = 'str_class1';
  const STR_CLASSIFICATION2 = 'str_class2';
  const STR_CLASSIFICATION3 = 'str_class3';
  const STR_CLASSIFICATION4 = 'str_class4';
  const STR_CLASSIFICATION5 = 'str_class5';
  const STR_LOCATION1 = 'str_location1';
  const STR_LOCATION2 = 'str_location2';
  const STR_LOCATION3 = 'str_location3';
  //
  const CRM_REPORT_TYPE = 'crm_report_type';
  const CRM_OFFER_STATUS = 'crm_offer_status';
  //
  const EMP_LOCATION = 'emp_location';
  const EMP_DEPARTMENT = 'emp_department';
  const EMP_SECTION = 'emp_section';
  const EMP_JOB = 'emp_job';
  const EMP_LEVEL = 'emp_level';
  const EMP_CLASS = 'emp_class';
  //
  const MAINT_BRAND = 'mnt_cod_brand';
  const MAINT_CAPACITY = 'mnt_cod_capacity';
  const MAINT_MODEL = 'mnt_cod_model';
  const MAINT_OPERATION = 'mnt_cod_operation';
  //
  const FRE_COMMODITY = 'fre_cod_commodity';
  const FRE_PACK_TYPE = 'fre_cod_pack_type';
  const FRE_TRUCK_TYPE = 'fre_cod_truck_type';
  const FRE_OFFER_STATUS = 'fre_cod_offer_status';
  const FRE_PAYTERM = 'fre_cod_payterm';
  const FRE_INCOTERM = 'fre_cod_incoterm';
  const FRE_LOADING_TYPE = 'fre_cod_loading_order_type';
  //
  const CLNC_HOWNOW = 'clnc_cod_hownow';
  const CLNC_SPECIAL = 'clnc_special';

  public static function getSelectStatement($vTable_Name, $vWhere = '', $vOrder = '') {
    $sSQL = 'SELECT id, name, rem'
            . ' FROM ' . self::$aCodes[strtolower($vTable_Name)];
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $vOrder = ' ORDER BY ' . $vOrder;
    }
    $sSQL .= $vOrder;
    return $sSQL;
  }

  public static function getArray($vTable_Name, $vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $res = ph_Execute(self::getSelectStatement($vTable_Name, $vWhere, 'name'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = self::getFields($vTable_Name, $res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($vTable_Name, $nId) {
    $cClass = new cCpyCode();
    $cClass->vTable = $vTable_Name;
    $res = ph_Execute(self::getSelectStatement($vTable_Name, '(id="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($vTable_Name, $res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($vTable_Name, $res) {
    $cClass = new cCpyCode();
    $cClass->vTable = $vTable_Name;
    $cClass->Id = intval($res->fields("id"));
    $cClass->Name = $res->fields("name");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO ' . self::$aCodes[strtolower($this->vTable)]
              . ' (`name`, `rem`, `ins_user`'
              . ') VALUES ('
              . '"' . $this->Name . '"'
              . ', "' . $this->Rem . '"'
              . ', "' . $nUId . '"'
              . ')';
      $res = ph_ExecuteInsert($vSQL);
      if ($res || $res === 0) {
        $nId = ph_InsertedId();
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } else {
      $vSQL = 'UPDATE ' . self::$aCodes[strtolower($this->vTable)] . ' SET'
              . '  `name`="' . $this->Name . '"'
              . ', `rem`="' . $this->Rem . '"'
              . ', `upd_user`="' . $nUId . '"'
              . ' WHERE id = "' . $this->Id . '"';
      //echo $vSQL;
      $res = ph_ExecuteUpdate($vSQL);
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
    $vSQL = 'DELETE FROM ' . self::$aCodes[strtolower($this->vTable)]
            . ' WHERE id = "' . $this->Id . '"';
    $res = ph_ExecuteUpdate($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
