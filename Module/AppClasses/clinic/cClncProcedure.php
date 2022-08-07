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
 * @update 2022/04/25 22:08
 *
 */

class cClncProcedure {

  var $Id;
  var $CatId;
  var $Code;
  var $Name;
  var $Price = 0.000;
  var $VatId = 0;
  var $Vat = 0;
  var $InsUser = -9;
  var $InsDate = 'current_timestamp()';
  var $UpdUser = -9;
  var $UpdDate = 'current_timestamp()';
  //
  var $oCat;
  var $oVat;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `cat_id`, `code`, `name`, `price`, `vat_id`, `vat`'
      . ', `ins_user`, `ins_date`, `upd_user`, `upd_date`'
      . ' FROM `clnc_procedure`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_procedure`';
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
    $cClass = new cClncProcedure();
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
    $cClass = new cClncProcedure();
    $cClass->Id = intval($res->fields('id'));
    $cClass->CatId = intval($res->fields('cat_id'));
    $cClass->Code = $res->fields('code');
    $cClass->Name = $res->fields('name');
    $cClass->Price = floatval($res->fields('price'));
    $cClass->VatId = intval($res->fields('vat_id'));
    $cClass->Vat = floatval($res->fields('vat'));
    $cClass->InsUser = intval($res->fields('ins_user'));
    $cClass->InsDate = $res->fields('ins_date');
    $cClass->UpdUser = intval($res->fields('upd_user'));
    $cClass->UpdDate = $res->fields('upd_date');
    //
    $cClass->oCat = cClncProcedureCategory::getInstance($cClass->CatId);
    $cClass->oVat = cPhsCode::getInstance(cPhsCode::VAT, $cClass->VatId);
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_procedure` ('
        . '  `cat_id`, `code`, `name`, `price`, `vat_id`, `vat`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->CatId . '"'
        . ', "' . $this->Code . '"'
        . ', "' . $this->Name . '"'
        . ', "' . $this->Price . '"'
        . ', "' . $this->VatId . '"'
        . ', "' . $this->Vat . '"'
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
      $vSQL = 'UPDATE `clnc_procedure` SET'
        . '  `cat_id`="' . $this->CatId . '"'
        . ', `code`="' . $this->Code . '"'
        . ', `name`="' . $this->Name . '"'
        . ', `price`="' . $this->Price . '"'
        . ', `vat_id`="' . $this->VatId . '"'
        . ', `vat`="' . $this->Vat . '"'
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
    $vSQL = 'DELETE FROM `clnc_procedure` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {
    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }


  public static function getArrayWithOffer($vWhere = '', $nOffer = 0) {
    $aArray = array();
    $nIdx = 0;
    $sSQL = '';
    // اضطررت لعمل هذه الطريقة في ال
    // select
    // بسبب عدم دعم
    // MYSQL
    // لتعليمة
    // MINUS
    $sSQL .= 'select `id`, `code`, `name`, `price`, `vat`,'
      . ' `vat_id`, `vat_name`, `cat_id`, `cat_name`'
      . ' FROM (select `pr`.`id`, `pr`.`code`, `pr`.`name`, `pr`.`price`, `pr`.`vat`,'
      . ' `pr`.`vat_id`, `pr`.`vat_name`, `pr`.`cat_id`, `pr`.`cat_name`'
      . ' from `clnc_vprocedure` AS `pr`,'
      . '       (select `id`, count(*), min(flg)'
      . '          from (select `id`          , 1 flg from `clnc_vprocedure`'
      . '                union all'
      . '                select `procedure_id`, 2 flg from `clnc_voffer_procedure` where `offer_id` = "' . $nOffer . '"'
      . '               ) AS `minus_tbl0`'
      . '          group by `id`  '
      . '          having count(*) = 1 and min(flg) = 1'
      . '       ) AS `minus_tbl1`'
      . ' where `minus_tbl1`.`id`=`pr`.`id`'
      . ' UNION ALL '
      . ' select `procedure_id`, `procedure_code`, `procedure_name`, `price`, `procedure_vat`, '
      . ' `vat_id`, `vat_name`, `cat_id`, `cat_name`'
      . ' from `clnc_voffer_procedure`'
      . ' where `offer_id` = "' . $nOffer . '"'
      . ') AS `p`';
    if ($vWhere != '') {
      $sSQL .= ' WHERE (' . $vWhere . ')';
    }
    $sSQL .= ' ORDER BY `cat_id`, `id`';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cClncProcedure::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }
}
