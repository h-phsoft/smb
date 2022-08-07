<?php

class cStrOuMst {

  var $MstId = -999;
  var $WPerId = 0;
  var $WPerName = '';
  var $StorId = 0;
  var $StorNum = 0;
  var $StorName = '';
  var $AccId = 0;
  var $AccNum = 0;
  var $AccName = '';
  var $CosId = 0;
  var $CosNum = 0;
  var $CosName = '';
  var $MstNum;
  var $MstDate;
  var $DocId = 0;
  var $DocName = 'None';
  var $DocNum;
  var $DocDate;
  var $MstRem;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT '
      . '  `mst_id` , `type_id`  '
      . ', `wper_id`, `wper_name`'
      . ', `stor_id`, `stor_num` , `stor_name`'
      . ', `acc_id` , `acc_num`  , `acc_name` '
      . ', `cost_id`, `cost_num` , `cost_name`'
      . ', `mst_num`, `mst_date`'
      . ', `doc_id` , `doc_name` , `mst_docn` , `mst_docd`'
      . ', `mst_rem`'
      . ' FROM `str_vfoumst`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `str_vfoumst`';
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
      $vOrder = '`mst_date` DESC, `doc_id`, `stor_num`, `mst_num` DESC, `mst_docd` DESC, `mst_docn` DESC';
    }
    $res = ph_Execute(cStrOuMst::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrOuMst::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrOuMst();
    $res = ph_Execute(cStrOuMst::getSelectStatement('(`mst_id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrOuMst::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrOuMst();
    $cClass->MstId = intval($res->fields("mst_id"));
    $cClass->WPerId = intval($res->fields("wper_id"));
    $cClass->WPerName = $res->fields("wper_name");
    $cClass->StorId = intval($res->fields("stor_id"));
    $cClass->StorNum = $res->fields("stor_num");
    $cClass->StorName = $res->fields("stor_name");
    $cClass->AccId = intval($res->fields("acc_id"));
    $cClass->AccNum = $res->fields("acc_num");
    $cClass->AccName = $res->fields("acc_name");
    $cClass->CostId = intval($res->fields("cost_id"));
    $cClass->CostNum = $res->fields("cost_num");
    $cClass->CostName = $res->fields("cost_name");
    $cClass->MstNum = intval($res->fields("mst_num"));
    $cClass->MstDate = $res->fields("mst_date");
    $cClass->DocId = intval($res->fields("doc_id"));
    $cClass->DocName = $res->fields("doc_name");
    $cClass->DocNum = $res->fields("mst_docn");
    $cClass->DocDate = $res->fields("mst_docd");
    $cClass->MstRem = $res->fields("mst_rem");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->MstId == 0 || $this->MstId == -999) {
      $vSQL = 'INSERT INTO `str_oumst` ('
        . ' `wper_id`, `stor_id`, `acc_id`, `cost_id`, `doc_id`,'
        . ' `num`   , `date`  , `docn`  , `docd`   , `rem`, `ins_user`'
        . ') VALUES ('
        . ' "' . $this->WPerId . '"'
        . ',"' . $this->StorId . '"'
        . ',"' . $this->AccId . '"'
        . ',"' . $this->CosId . '"'
        . ',"' . $this->DocId . '"'
        . ',"' . $this->MstNum . '"'
        . ', STR_TO_DATE("' . $this->MstDate . '","%Y-%m-%d")'
        . ',"' . $this->DocNum . '"'
        . ', ' . ($this->DocDate == '' ? 'null' : 'STR_TO_DATE("' . $this->DocDate . '","%Y-%m-%d")')
        . ',"' . $this->MstRem . '"'
        . ',"' . $nUId . '"'
        . ')';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {
        $nId = ph_InsertedId();
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'] . ' SQL: ' . $vSQL;
        throw new Exception($vMsgs);
      }
    } else {
      $nId = $this->MstId;
      $vSQL = 'UPDATE `str_oumst` SET'
        . ' `wper_id`="' . $this->WPerId . '"'
        . ',`stor_id`="' . $this->StorId . '"'
        . ',`acc_id`="' . $this->AccId . '"'
        . ',`cost_id`="' . $this->CosId . '"'
        . ',`num`="' . $this->MstNum . '"'
        . ',`date`=STR_TO_DATE("' . $this->MstDate . '","%Y-%m-%d")'
        . ',`doc_id`="' . $this->DocId . '"'
        . ',`docn`="' . $this->DocNum . '"'
        . ',`docd`=STR_TO_DATE("' . $this->DocDate . '","%Y-%m-%d")'
        . ',`rem`="' . $this->MstRem . '"'
        . ',`upd_user`="' . $nUId . '"'
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
    $aTrn = cStrInTrn::getArray('(`mst_id`="' . $this->MstId . '")');
    try {
      foreach ($aTrn as $oTrn) {
        $oStrItem = cStrStoreItem::getMaterial('(`stor_id`="' . $this->StorId . '" AND `item_id`="' . $oTrn->ItemId . '")');
        $oStrItem->addQnt($oTrn->Qnt, $oTrn->Amt);
        $oTrn->delete();
      }
      $vSQL = 'DELETE FROM `str_oumst` WHERE `id`="' . $this->MstId . '"';
      $res = ph_Execute($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    } catch (Exception $exc) {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
