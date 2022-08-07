<?php

class cAccTrn {

  var $Id = -999;
  var $MstId = -999;
  var $CostId = 0;
  var $AccId = 0;
  var $AccRId = 0;
  var $CurnId = 1;
  var $Rate = 1;
  var $BCurnId = 1;
  var $BRate = 1;
  var $RId = 0;
  var $Ord = 0;
  var $Deb = 0;
  var $DebC = 0;
  var $Crd = 0;
  var $BDeb = 0;
  var $CrdC = 0;
  var $BCrd = 0;
  var $SRem;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT '
      . ' `id`, `mst_id`, `acc_id`, `acc_rid`, `cost_id`, `rid`,'
      . ' `curn_id`, `rate`, `bcurn_id`, `brate`, `ord`,'
      . ' `deb`, `debc`, `debb`,'
      . ' `crd`, `crdc`, `crdb`,'
      . ' `srem`, `rem`'
      . 'FROM `acc_trn`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `acc_trn`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ') ';
    }
    $res = ph_Execute($sSQL);
    if ($res != '' && !$res->EOF) {
      $nCount = intval($res->fields("nCnt"));
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
      $vOrder = '`mst_id`, `id`';
    }
    $res = ph_Execute(cAccTrn::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAccTrn::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAccTrn();
    $res = ph_Execute(cAccTrn::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAccTrn::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAccTrn();
    $cClass->Id = intval($res->fields("id"));
    $cClass->MstId = intval($res->fields("mst_id"));
    $cClass->RId = intval($res->fields("rid"));
    $cClass->Ord = intval($res->fields("ord"));
    $cClass->AccId = intval($res->fields("acc_id"));
    $cClass->AccRId = intval($res->fields("acc_rid"));
    $cClass->CostId = intval($res->fields("cost_id"));
    $cClass->CurnId = intval($res->fields("curn_id"));
    $cClass->BCurnId = intval($res->fields("bcurn_id"));
    $cClass->Rate = floatval($res->fields("rate"));
    $cClass->BRate = floatval($res->fields("brate"));
    $cClass->Deb = floatval($res->fields("deb"));
    $cClass->DebC = floatval($res->fields("debc"));
    $cClass->BDeb = floatval($res->fields("debb"));
    $cClass->Crd = floatval($res->fields("crd"));
    $cClass->CrdC = floatval($res->fields("crdc"));
    $cClass->BCrd = floatval($res->fields("crdb"));
    $cClass->SRem = $res->fields("srem");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `acc_trn` (`mst_id`, `rid`, `acc_id`, `acc_rid`, `cost_id`,'
        . ' `ord`, `curn_id`, `rate`, `bcurn_id`, `brate`,'
        . ' `deb`, `debc`, `debb`, `crd`, `crdc`, `crdb`,'
        . ' `srem`, `rem`, `ins_user`)'
        . ' VALUES ("' . $this->MstId . '"'
        . ', "' . $this->RId . '"'
        . ', "' . $this->AccId . '"'
        . ', "' . $this->AccRId . '"'
        . ', "' . $this->CostId . '"'
        . ', "' . $this->Ord . '"'
        . ', "' . $this->CurnId . '"'
        . ', "' . $this->Rate . '"'
        . ', "' . $this->BCurnId . '"'
        . ', "' . $this->BRate . '"'
        . ', "' . $this->Deb . '"'
        . ', "' . $this->DebC . '"'
        . ', "' . $this->BDeb . '"'
        . ', "' . $this->Crd . '"'
        . ', "' . $this->CrdC . '"'
        . ', "' . $this->BCrd . '"'
        . ', "' . $this->SRem . '"'
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
      $vSQL = 'UPDATE `acc_trn` SET'
        . '  `mst_id`="' . $this->MstId . '"'
        . ', `rid`="' . $this->RId . '"'
        . ', `ord`="' . $this->Ord . '"'
        . ', `acc_id`="' . $this->AccId . '"'
        . ', `acc_rid`="' . $this->AccRId . '"'
        . ', `cost_id`="' . $this->CostId . '"'
        . ', `curn_id`="' . $this->CurnId . '"'
        . ', `rate`="' . $this->Rate . '"'
        . ', `bcurn_id`="' . $this->BCurnId . '"'
        . ', `brate`="' . $this->BRate . '"'
        . ', `deb`="' . $this->Deb . '"'
        . ', `debc`="' . $this->DebC . '"'
        . ', `debb`="' . $this->BDeb . '"'
        . ', `crd`="' . $this->Crd . '"'
        . ', `crdc`="' . $this->CrdC . '"'
        . ', `crdb`="' . $this->BCrd . '"'
        . ', `srem`="' . $this->SRem . '"'
        . ', `rem`="' . $this->Rem . '"'
        . ', `upd_user`="' . $nUId . '"'
        . ' WHERE `id` = "' . $this->Id . '"';
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
    $vSQL = 'DELETE FROM `acc_trn` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
