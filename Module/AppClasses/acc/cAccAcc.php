<?php

class cAccAcc {

  var $Id = -999;
  var $StatusId;
  var $StatusName;
  var $TypeId;
  var $TypeName;
  var $DbCrId;
  var $DbCrName;
  var $CloseId;
  var $CloseName;
  var $Num;
  var $Name;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id` , `num`, `name`, `rem`,'
            . ' `type_id`, `type_name`,'
            . ' `status_id`, `status_name`,'
            . ' `dbcr_id`, `dbcr_name`,'
            . ' `close_id`, `close_name`'
            . ' FROM `acc_vacc`';
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
    $res = ph_Execute(cAccAcc::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAccAcc::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAccAcc();
    $res = ph_Execute(cAccAcc::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAccAcc::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAccAcc();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Num = $res->fields("num");
    $cClass->Name = $res->fields("name");
    $cClass->TypeId = intval($res->fields("type_id"));
    $cClass->TypeName = $res->fields("type_name");
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->StatusName = $res->fields("status_name");
    $cClass->DbCrId = intval($res->fields("dbcr_id"));
    $cClass->DbCrName = $res->fields("dbcr_name");
    $cClass->CloseId = intval($res->fields("close_id"));
    $cClass->CloseName = $res->fields("close_name");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `acc_acc`(`num`, `name`, `type_id`, `status_id`, `dbcr_id`, `close_id`, `rem`, `ins_user`)'
              . ' VALUES('
              . '  "' . $this->Num . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->TypeId . '"'
              . ', "' . $this->StatusId . '"'
              . ', "' . $this->DbCrId . '"'
              . ', "' . $this->CloseId . '"'
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
      $vSQL = 'UPDATE `acc_acc` SET'
              . '  `num`="' . $this->Num . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `type_id`="' . $this->TypeId . '"'
              . ', `status_id`="' . $this->StatusId . '"'
              . ', `dbcr_id`="' . $this->DbCrId . '"'
              . ', `close_id`="' . $this->CloseId . '"'
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
      $vSQL = 'DELETE FROM `acc_acc` WHERE `id` = "' . $this->Id . '"';
      $res = ph_ExecuteUpdate($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'] . ', SQL=' . $vSQL;
        throw new Exception($vMsgs);
      }
    }
  }

  public static function refreshTree() {
    $vSQL = 'UPDATE `acc_acc` SET `pid`=-1';
    ph_ExecuteUpdate($vSQL);
    $sSQL = 'SELECT `id` , `num`'
            . ' FROM `acc_acc`'
            . ' WHERE `type_id`=1'
            . ' ORDER BY `num`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $vSQL = 'UPDATE `acc_acc` SET'
                . ' `pid`="' . $res->fields("id") . '"'
                . ' WHERE `id`!="' . $res->fields("id") . '"'
                . ' AND `num` LIKE "' . $res->fields("num") . '%"';
        ph_ExecuteUpdate($vSQL);
        $res->MoveNext();
      }
      $res->Close();
    }
    return 0;
  }

  public static function getTree($nPId = -1) {
    $aAccTree = array();
    $nIdx = 0;
    $sSQL = 'SELECT `id` , `num`, `name`, `rem`,'
            . ' `type_id`, `type_name`,'
            . ' `status_id`, `status_name`,'
            . ' `dbcr_id`, `dbcr_name`,'
            . ' `close_id`, `close_name`'
            . ' FROM `acc_vacc`'
            . ' WHERE `pid`="' . $nPId . '"'
            . ' ORDER BY `num`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aAccTree[$nIdx] = array();
        $aAccTree[$nIdx]['Node'] = cAccAcc::getFields($res);
        $aAccTree[$nIdx]['Subs'] = array();
        if ($res->fields("type_id") == 1) {
          $aAccTree[$nIdx]['Subs'] = cAccAcc::getTree($res->fields("id"));
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
    $sSQL = 'SELECT `id` , `num`, `name`, `rem`,'
            . ' `type_id`, `status_id`, `dbcr_id`, `close_id`'
            . ' FROM `acc_acc`'
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
            'DbCrId' => intval($res->fields("dbcr_id")),
            'CloseId' => intval($res->fields("close_id")),
            'Rem' => $res->fields("rem")
        );
        if (intval($res->fields("type_id")) == 1) {
          $aAccTree[$nIdx]['children'] = cAccAcc::getJSTree($res->fields("id"));
        }
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aAccTree;
  }

}
