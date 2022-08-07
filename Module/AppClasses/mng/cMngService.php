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

class cMngService {

  var $Id = -999;
  var $Code;
  var $Name;
  var $Cst;
  var $CostId;
  var $AccCid;
  var $AccRid;
  var $UnitId;
  var $Grp;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `code`, `name`, `cst`, `cost_id`, `acc_cid`, `acc_rid`'
      . ', `unit_id`, `grp`, `rem`'
      . ' FROM `mng_service`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `mng_service`';
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
    $res = ph_Execute(cMngService::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cMngService::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cMngService();
    $res = ph_Execute(cMngService::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cMngService::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cMngService();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Code = $res->fields('code');
    $cClass->Name = $res->fields('name');
    $cClass->Cst = floatval($res->fields('cst'));
    $cClass->CostId = intval($res->fields('cost_id'));
    $cClass->AccCid = intval($res->fields('acc_cid'));
    $cClass->AccRid = intval($res->fields('acc_rid'));
    $cClass->UnitId = intval($res->fields('unit_id'));
    $cClass->Grp = $res->fields('grp');
    $cClass->Rem = $res->fields('rem');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `mng_service` ('
        . '  `code`, `name`, `cst`, `cost_id`, `acc_cid`, `acc_rid`, `unit_id`'
        . ', `grp`, `rem`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->Code . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Cst . '"'
        . ', "' . $this->CostId . '"'
        . ', "' . $this->AccCid . '"'
        . ', "' . $this->AccRid . '"'
        . ', "' . $this->UnitId . '"'
        . ', "' . $this->Grp . '"'
        . ', "' . $this->Rem . '"'
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
      $vSQL = 'UPDATE `mng_service` SET'
        . '  `code`="' . $this->Code . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `cst`="' . $this->Cst . '"'
        . ', `cost_id`="' . $this->CostId . '"'
        . ', `acc_cid`="' . $this->AccCid . '"'
        . ', `acc_rid`="' . $this->AccRid . '"'
        . ', `unit_id`="' . $this->UnitId . '"'
        . ', `grp`="' . $this->Grp . '"'
        . ', `rem`="' . $this->Rem . '"'
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
    $vSQL = 'DELETE FROM `mng_service` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
