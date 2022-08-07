<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 *
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.2.220201.1330
 *
 * @author Haytham
 * @version 2.0.2.220201.1330
 * @update 2022/02/06 09:21
 *
 */

class cPhsCustomize {

  var $Id;
  var $Ord;
  var $Name;
  var $Pname;
  var $StatusId;
  var $Value;
  var $TypeId;
  var $Idfld;
  var $Namefld;
  var $TableName;
  var $Cond;
  var $Order;
  //
  var $oStatus;
  var $oType;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `ord`, `name`, `pname`, `status_id`, `value`, `type_id`'
            . ', `table_idfld`, `table_namefld`, `table_name`, `table_cond`, `table_order`'
            . ' FROM `phs_customize`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `phs_customize`';
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
      $vOrder = '`ord`, `pname`';
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
    $cClass = new cPhsCustomize();
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
    $cClass = new cPhsCustomize();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Ord = intval($res->fields('ord'));
    $cClass->Name = $res->fields('name');
    $cClass->Pname = $res->fields('pname');
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->Value = $res->fields('value');
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->Idfld = $res->fields('table_idfld');
    $cClass->Namefld = $res->fields('table_namefld');
    $cClass->TableName = $res->fields('table_name');
    $cClass->Cond = $res->fields('table_cond');
    $cClass->Order = $res->fields('table_order');
    //
    $cClass->oStatus = cPhsCode::getInstance(cPhsCode::STATUS, $cClass->StatusId);
    $cClass->oType = cPhsCode::getInstance(cPhsCode::CUSTOMIZE_TYPE, $cClass->TypeId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `phs_customize` ('
              . '  `ord`, `name`, `pname`, `status_id`, `value`, `type_id`, `table_idfld`'
              . ', `table_namefld`, `table_name`, `table_cond`, `table_order`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Ord . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->Pname . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->Value . '"'
              . ', "' . $this->TypeId . '"'
              . ', "' . $this->TableIdfld . '"'
              . ', "' . $this->TableNamefld . '"'
              . ', "' . $this->TableName . '"'
              . ', "' . $this->TableCond . '"'
              . ', "' . $this->TableOrder . '"'
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
      $vSQL = 'UPDATE `phs_customize` SET'
              . '  `ord`="' . $this->Ord . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `pname`="' . $this->Pname . '"'
              . ', `status_id`="' . $this->StatusId . '"'
              . ', `value`="' . $this->Value . '"'
              . ', `type_id`="' . $this->TypeId . '"'
              . ', `table_idfld`="' . $this->TableIdfld . '"'
              . ', `table_namefld`="' . $this->TableNamefld . '"'
              . ', `table_name`="' . $this->TableName . '"'
              . ', `table_cond`="' . $this->TableCond . '"'
              . ', `table_order`="' . $this->TableOrder . '"'
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
    $vSQL = 'DELETE FROM `phs_customize` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
