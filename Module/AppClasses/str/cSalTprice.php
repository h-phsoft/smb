<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 * 
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.22.220220.2202
 * 
 * @author Haytham
 * @version 2.0.22.220220.2202
 * @update 2022/03/04 00:19
 *
 */

class cSalTprice {

  var $Id;
  var $PriceId;
  var $TypeId = 1;
  var $ItemId = 0;
  var $ServId = 0;
  var $Price = 0.000;
  var $Rem;
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  //
  var $oItem;
  var $oPrice;
  var $oServ;
  var $oType;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `price_id`, `type_id`, `item_id`, `serv_id`, `price`, `rem`'
      . ', `ins_user`, `ins_date`, `upd_user`, `upd_date`'
      . ' FROM `sal_tprice`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `sal_tprice`';
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
    $res = ph_Execute(cSalTprice::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cSalTprice::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cSalTprice();
    $res = ph_Execute(cSalTprice::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cSalTprice::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cSalTprice();
    $cClass->Id = intval($res->fields('id'));
    $cClass->PriceId = intval($res->fields('price_id'));
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->ItemId = intval($res->fields('item_id'));
    $cClass->ServId = intval($res->fields('serv_id'));
    $cClass->Price = floatval($res->fields('price'));
    $cClass->Rem = $res->fields('rem');
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    //
    $cClass->oItem = cStrItem::getInstance($cClass->ItemId);
    $cClass->oServ = cMngService::getInstance($cClass->ServId);
    $cClass->oType = cPhsCode::getInstance(cPhsCode::FIN_ELEMENT_TYPE, $cClass->TypeId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `sal_tprice` ('
        . '  `price_id`, `type_id`, `item_id`, `serv_id`, `price`, `rem`,`ins_user` '
        . ') VALUES ('
        . '  "' . $this->PriceId . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->ItemId . '"'
        . ', "' . $this->ServId . '"'
        . ', "' . $this->Price . '"'
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
      $vSQL = 'UPDATE `sal_tprice` SET'
        . '  `price_id`="' . $this->PriceId . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `item_id`="' . $this->ItemId . '"'
        . ', `serv_id`="' . $this->ServId . '"'
        . ', `price`="' . $this->Price . '"'
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
    $vSQL = 'DELETE FROM `sal_tprice` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

