<?php

class cAccCost {

  var $Id = -999;
  var $StatusId;
  var $StatusName;
  var $TypeId;
  var $TypeName;
  var $Num;
  var $Name;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id` , `num`, `name`, `type_id`, `type_name`, `status_id`, `status_name`, `rem`'
      . ' FROM `acc_vcost`';
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

  public static function getArray($vWhere = '', $vOrder = '', $nPage = 0, $nPageSize = 0) {
    $aArray = array();
    $nIdx = 0;
    $vLimit = '';
    if ($nPage != 0 && $nPageSize != 0) {
      $vLimit = ((($nPage - 1) * $nPageSize)) . ', ' . $nPageSize;
    }
    if ($vOrder == '') {
      $vOrder = '`num`, `id`';
    }
    $res = ph_Execute(cAccCost::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAccCost::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAccCost();
    $res = ph_Execute(cAccCost::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAccCost::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAccCost();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Num = $res->fields("num");
    $cClass->Name = $res->fields("name");
    $cClass->TypeId = intval($res->fields("type_id"));
    $cClass->TypeName = $res->fields("type_name");
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->StatusName = $res->fields("status_name");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `acc_cost` (`num`, `name`, `type_id`, `status_id`, `rem`, `ins_user`)'
        . ' VALUES ('
        . '   "' . $this->Num . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->StatusId . '"'
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
      $vSQL = 'UPDATE `acc_cost` SET'
        . ' `num`="' . $this->Num . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `status_id`="' . $this->StatusId . '"'
        . ', `rem`="' . $this->Rem . '"'
        . ', `upd_user`="' . $nUId . '"'
        . ' WHERE `id`="' . $this->Id . '"';
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
    if ($this->Id > 0) {
      $vSQL = 'DELETE FROM `acc_cost` WHERE `id` = "' . $this->Id . '"';
      $res = ph_ExecuteUpdate($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
  }

  public static function refreshTree() {
    $vSQL = 'UPDATE `acc_cost` SET `pid`=-1';
    ph_ExecuteUpdate($vSQL);
    $sSQL = 'SELECT `id` , `num`'
      . ' FROM `acc_cost`'
      . ' WHERE `type_id`=1'
      . ' ORDER BY `num`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $vSQL = 'UPDATE `acc_cost` SET'
          . ' `pid`="' . $res->fields("id") . '"'
          . ' WHERE `id`!="' . $res->fields("id") . '"'
          . ' AND `num` LIKE "' . $res->fields("num") . '%"';
        ph_ExecuteUpdate($vSQL);
        $res->MoveNext();
      }
      $res->Close();
    }
  }

  public static function getTree($nPId = -1) {
    cAccAcc::refreshTree();
    $aAccTree = array();
    $nIdx = 0;
    $sSQL = 'SELECT `id` , `num`, `name`, `rem`, `type_id`, `type_name`,'
      . ' `status_id`, `status_name`'
      . ' FROM `acc_vcost`'
      . ' WHERE `pid`="' . $nPId . '"'
      . ' ORDER BY `num`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aAccTree[$nIdx] = array();
        $aAccTree[$nIdx]['Node'] = cAccCost::getFields($res);
        $aAccTree[$nIdx]['Subs'] = array();
        if ($res->fields("type_id") == 1) {
          $aAccTree[$nIdx]['Subs'] = cAccCost::getTree($res->fields("id"));
        }
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aAccTree;
  }

  public static function getJSTree($nPId = -1) {
    $aAccTree = array();
    $nIdx = 0;
    $sSQL = 'SELECT `id` , `num`, `name`, `rem`, `type_id`,  `status_id`'
      . ' FROM `acc_cost`'
      . ' WHERE `pid`=' . $nPId
      . ' ORDER BY `num`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aAccTree[$nIdx] = array();
        $aAccTree[$nIdx]['text'] = $res->fields("num") . ' - ' . $res->fields("name");
        $aAccTree[$nIdx]['type'] = $res->fields("type_id");
        $aAccTree[$nIdx]['data'] = array(
          'Id' => intval($res->fields("id")),
          'Num' => $res->fields("num"),
          'Name' => $res->fields("name"),
          'TypeId' => intval($res->fields("type_id")),
          'StatusId' => intval($res->fields("status_id")),
          'Rem' => $res->fields("rem")
        );
        if (intval($res->fields("type_id")) == 1) {
          $aAccTree[$nIdx]['children'] = cAccCost::getJSTree($res->fields("id"));
        }
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aAccTree;
  }

}
