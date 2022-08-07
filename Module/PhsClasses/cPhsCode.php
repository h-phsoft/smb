<?php

class cPhsCode {

  var $Id = -999;
  var $Name = '';
  var $Rem = '';
  var $vTable = '';
  public static $aCodes = array(
      'status' => 'phs_cod_status',
      'gender' => 'phs_cod_gender',
      'martial' => 'phs_cod_martial',
      'military' => 'phs_cod_military',
      'education' => 'phs_cod_education',
      'warranty' => 'phs_cod_warranty',
      'customize_type' => 'phs_cod_customize_type',
      'balancemode' => 'phs_cod_cont_blm',
      'contacttype' => 'phs_cod_cont_type',
      'phs_program_type' => 'phs_cod_prog_type',
      'dbcr' => 'phs_cod_dbcr',
      'month' => 'phs_cod_month',
      'day' => 'phs_cod_day',
      'domain' => 'phs_cod_domain',
      'discounttype' => 'phs_cod_discount_type',
      'cash_trt' => 'phs_cod_cash_trt',
      'documentstatus' => 'phs_cod_mst_status',
      'documentsource' => 'phs_cod_src',
      'treetype' => 'phs_cod_tree_type',
      'workperiodstatus' => 'phs_cod_wpstatus',
      'yesno' => 'phs_cod_yes_no',
      'str_item_type' => 'phs_cod_str_item_type',
      'str_cost_type' => 'phs_cod_str_costtype',
      'str_method' => 'phs_cod_str_method',
      'phs_cod_idtype' => 'phs_cod_idtype',
      'phs_cod_payment_type' => 'phs_cod_payment_type',
      'phs_cod_vat' => 'phs_cod_vat',
      'phs_cod_treatment_status' => 'phs_cod_treatment_status',
      'phs_cod_visa' => 'phs_cod_visa',
  );

  const STATUS = 'status';
  const GENDER = 'gender';
  const YES_NO = 'yesno';
  const WARRANTY = 'warranty';
  const MARTIAL = 'martial';
  const MILITARY = 'military';
  const EDUCATION = 'education';
  const CUSTOMIZE_TYPE = 'customize_type';
  //
  const BALANCE_MODE = 'balancemode';
  const CONTACT_TYPE = 'contacttype';
  const DBCR = 'dbcr';
  const MONTH = 'month';
  const DAY = 'day';
  const DOMAIN = 'domain';
  const DOCUMENT_STATUS = 'documentstatus';
  const DOCUMENT_SOURCE = 'documentsource';
  const TREE_TYPE = 'treetype';
  const DISCOUNT_TYPE = 'discounttype';
  const WORKPERIOD_STATUS = 'workperiodstatus';
  //
  const CASH_TRT = 'cash_trt';
  //
  const PROGRAM_TYPE = 'phs_program_type';
  //
  const INVENTORY_ITEM_TYPE = 'str_item_type';
  const INVENTORY_COST_TYPE = 'str_cost_type';
  const INVENTORY_METHOD = 'str_method';
  //
  const IDTYPE = 'phs_cod_idtype';
  const PAYMENT_TYPE = 'phs_cod_payment_type';
  const VAT = 'phs_cod_vat';
  const TREATMENT_STATUS = 'phs_cod_treatment_status';
  const VISA = 'phs_cod_visa';

  public static function getSelectStatement($vTableName, $vWhere = '', $vOrder = '') {
    $sSQL = 'SELECT id, name, rem'
            . ' FROM ' . self::$aCodes[strtolower($vTableName)];
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $vOrder = ' ORDER BY ' . $vOrder;
    }
    $sSQL .= $vOrder;

    return $sSQL;
  }

  public static function getArray($vTableName, $vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $res = ph_Execute(self::getSelectStatement($vTableName, $vWhere, 'id, name'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = self::getFields($vTableName, $res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($vTableName, $nId) {
    $cClass = new cPhsCode();
    $res = ph_Execute(self::getSelectStatement($vTableName, '(id="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($vTableName, $res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($vTableName, $res) {
    $cClass = new cPhsCode();
    $cClass->vTable = $vTableName;
    $cClass->Id = intval($res->fields("id"));
    $cClass->Name = getLabel($res->fields("name"));
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save() {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO ' . self::$aCodes[strtolower($this->vTable)] . ' (name, rem)'
              . ' VALUES ("' . $this->Name . '", "' . $this->Rem . '")';
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
              . '  name = "' . $this->Name . '"'
              . ', rem = "' . $this->Rem . '"'
              . ' WHERE id = "' . $this->Id . '"';
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
