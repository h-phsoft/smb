<?php

class cAccMst {

  var $Id = -999;
  var $WperId = 0;
  var $SrcId = 0;
  var $Num;
  var $PNum;
  var $Date;
  var $Rem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT '
      . ' `id`, `wper_id`, `src_id`, `num` , `pnum` , `date`, `rem`'
      . ' FROM `acc_mst`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `acc_mst`';
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
      $vOrder = '`date` DESC, `num` DESC';
    }
    $res = ph_Execute(cAccMst::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cAccMst::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cAccMst();
    $res = ph_Execute(cAccMst::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cAccMst::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cAccMst();
    $cClass->Id = intval($res->fields("id"));
    $cClass->WPerId = intval($res->fields("wper_id"));
    $cClass->SrcId = intval($res->fields("src_id"));
    $cClass->Num = intval($res->fields("num"));
    $cClass->PNum = intval($res->fields("pnum"));
    $cClass->Date = $res->fields("date");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = $this->Id;
    if ($this->Id == 0 || $this->Id == -999) {
      $nMaxNum = intval(ph_GetDBValue('max(num)+1', 'acc_mst', 'wper_id="' . $this->WperId . '"'));
      $this->Num = $nMaxNum;
      $vSQL = 'INSERT INTO `acc_mst` (`wper_id`, `src_id`, `num`, `pnum`, `date`, `rem`, `ins_user`)'
        . ' VALUES ("' . $this->WperId . '"'
        . ', "' . $this->SrcId . '"'
        . ', "' . $nMaxNum . '"'
        . ', "' . $nMaxNum . '"'
        . ', STR_TO_DATE("' . $this->Date . '","%Y-%m-%d")'
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
      $vSQL = 'UPDATE `acc_mst` SET'
        . '  `wper_id`="' . $this->WperId . '"'
        . ', `src_id`="' . $this->SrcId . '"'
        . ', `num`="' . $this->Num . '"'
        . ', `pnum`="' . $this->PNum . '"'
        . ', `date`=STR_TO_DATE("' . $this->Date . '","%Y-%m-%d")'
        . ', `rem`="' . $this->Rem . '"'
        . ', `upd_user`="' . $nUId . '"'
        . ' WHERE `id`="' . $this->Id . '"';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {
        /*
          $oldInstance = cAccMst::getInstance($this->Id);
          $oLog = new cCpyLog();
          $oLog->TypeId = 1;
          $oLog->RelId = $this->Id;
          $oLog->TableName = 'AccMst';
          $oLog->OldValue = json_encode($oldInstance);
          $oLog->NewValue = json_encode($this);
          $oLog->Save($nUId);
         */
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `acc_trn` WHERE `mst_id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {
      $vSQL = 'DELETE FROM `acc_mst` WHERE `id`="' . $this->Id . '"';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {
        /*
          $oLog = new cCpyLog();
          $oLog->TypeId = 1;
          $oLog->RelId = $this->Id;
          $oLog->TableName = 'AccMst';
          $oLog->OldValue = json_encode($this);
          $oLog->Save($nUId);
         */
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
