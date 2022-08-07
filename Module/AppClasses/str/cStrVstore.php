<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 * 
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.1.211108.0840
 * 
 * @author Haytham
 * @version 2.0.1.211108.0840
 * @update ????/??/?? ??:??
 *
 */

class cStrVstore {

  var $Id;
  var $Num;
  var $Name;
  var $TypeId;
  var $StatusId;
  var $SalesId;
  var $Isowned;
  var $Sdate;
  var $Edate;
  var $Address;
  var $Rem;
  var $CostId;
  var $CostName;
  var $AccSid;
  var $AccSname;
  var $AccCid;
  var $AccCname;
  var $AccRid;
  var $AccRname;
  var $AccMid;
  var $AccMname;
  var $AccDid;
  var $AccDname;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `num`, `name`, `type_id`, `status_id`, `sales_id`, `isowned`'
      . ', `sdate`, `edate`, `address`, `rem`, `cost_id`, `cost_name`, `acc_sid`'
      . ', `acc_sname`, `acc_cid`, `acc_cname`, `acc_rid`, `acc_rname`, `acc_mid`, `acc_mname`'
      . ', `acc_did`, `acc_dname`'
      . ' FROM `str_vstore`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_vstore`';
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
    $res = ph_Execute(cStrVstore::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrVstore::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrVstore();
    $res = ph_Execute(cStrVstore::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrVstore::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrVstore();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Num = intval($res->fields('num'));
    $cClass->Name = $res->fields('name');
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->StatusId = intval($res->fields('status_id'));
    $cClass->SalesId = intval($res->fields('sales_id'));
    $cClass->Isowned = intval($res->fields('isowned'));
    $cClass->Sdate = $res->fields('sdate');
    $cClass->Edate = $res->fields('edate');
    $cClass->Address = $res->fields('address');
    $cClass->Rem = $res->fields('rem');
    $cClass->CostId = intval($res->fields('cost_id'));
    $cClass->CostName = $res->fields('cost_name');
    $cClass->AccSid = intval($res->fields('acc_sid'));
    $cClass->AccSname = $res->fields('acc_sname');
    $cClass->AccCid = intval($res->fields('acc_cid'));
    $cClass->AccCname = $res->fields('acc_cname');
    $cClass->AccRid = intval($res->fields('acc_rid'));
    $cClass->AccRname = $res->fields('acc_rname');
    $cClass->AccMid = intval($res->fields('acc_mid'));
    $cClass->AccMname = $res->fields('acc_mname');
    $cClass->AccDid = intval($res->fields('acc_did'));
    $cClass->AccDname = $res->fields('acc_dname');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `str_vstore` ('
        . '  `num`, `name`, `type_id`, `status_id`, `sales_id`, `isowned`, `sdate`'
        . ', `edate`, `address`, `rem`, `cost_id`, `cost_name`, `acc_sid`, `acc_sname`'
        . ', `acc_cid`, `acc_cname`, `acc_rid`, `acc_rname`, `acc_mid`, `acc_mname`, `acc_did`'
        . ', `acc_dname`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->Num . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->StatusId . '"'
        . ', "' . $this->SalesId . '"'
        . ', "' . $this->Isowned . '"'
        . ', "' . $this->Sdate . '"'
        . ', "' . $this->Edate . '"'
        . ', "' . $this->Address . '"'
        . ', "' . $this->Rem . '"'
        . ', "' . $this->CostId . '"'
        . ', "' . $this->CostName . '"'
        . ', "' . $this->AccSid . '"'
        . ', "' . $this->AccSname . '"'
        . ', "' . $this->AccCid . '"'
        . ', "' . $this->AccCname . '"'
        . ', "' . $this->AccRid . '"'
        . ', "' . $this->AccRname . '"'
        . ', "' . $this->AccMid . '"'
        . ', "' . $this->AccMname . '"'
        . ', "' . $this->AccDid . '"'
        . ', "' . $this->AccDname . '"'
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
      $vSQL = 'UPDATE `str_vstore` SET'
        . '  `num`="' . $this->Num . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `status_id`="' . $this->StatusId . '"'
        . ', `sales_id`="' . $this->SalesId . '"'
        . ', `isowned`="' . $this->Isowned . '"'
        . ', `sdate`="' . $this->Sdate . '"'
        . ', `edate`="' . $this->Edate . '"'
        . ', `address`="' . $this->Address . '"'
        . ', `rem`="' . $this->Rem . '"'
        . ', `cost_id`="' . $this->CostId . '"'
        . ', `cost_name`="' . $this->CostName . '"'
        . ', `acc_sid`="' . $this->AccSid . '"'
        . ', `acc_sname`="' . $this->AccSname . '"'
        . ', `acc_cid`="' . $this->AccCid . '"'
        . ', `acc_cname`="' . $this->AccCname . '"'
        . ', `acc_rid`="' . $this->AccRid . '"'
        . ', `acc_rname`="' . $this->AccRname . '"'
        . ', `acc_mid`="' . $this->AccMid . '"'
        . ', `acc_mname`="' . $this->AccMname . '"'
        . ', `acc_did`="' . $this->AccDid . '"'
        . ', `acc_dname`="' . $this->AccDname . '"'
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
    $vSQL = 'DELETE FROM `str_vstore` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

