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
 * @update 2022/02/23 12:53
 *
 */

class cPhsCodCountry {

  var $Id;
  var $Phone;
  var $Code;
  var $Name;
  var $Symbol;
  var $Capital;
  var $Currency;
  var $Continent;
  var $ContinentCode;
  var $Alpha3;

  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `phone`, `code`, `name`, `symbol`, `capital`, `currency`'
            . ', `continent`, `continent_code`, `alpha_3`'
            . ' FROM `phs_cod_country`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `phs_cod_country`';
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
    $cClass = new cPhsCodCountry();
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
    $cClass = new cPhsCodCountry();
    $cClass->Id = intval($res->fields('id'));
    $cClass->Phone = intval($res->fields('phone'));
    $cClass->Code = $res->fields('code');
    $cClass->Name = $res->fields('name');
    $cClass->Symbol = $res->fields('symbol');
    $cClass->Capital = $res->fields('capital');
    $cClass->Currency = $res->fields('currency');
    $cClass->Continent = $res->fields('continent');
    $cClass->ContinentCode = $res->fields('continent_code');
    $cClass->Alpha3 = $res->fields('alpha_3');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `phs_cod_country` ('
              . '  `phone`, `code`, `name`, `symbol`, `capital`, `currency`, `continent`'
              . ', `continent_code`, `alpha_3`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->Phone . '"'
              . ', "' . $this->Code . '"'
              . ', "' . $this->Name . '"'
              . ', "' . $this->Symbol . '"'
              . ', "' . $this->Capital . '"'
              . ', "' . $this->Currency . '"'
              . ', "' . $this->Continent . '"'
              . ', "' . $this->ContinentCode . '"'
              . ', "' . $this->Alpha3 . '"'
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
      $vSQL = 'UPDATE `phs_cod_country` SET'
              . '  `phone`="' . $this->Phone . '"'
              . ', `code`="' . $this->Code . '"'
              . ', `name`="' . $this->Name . '"'
              . ', `symbol`="' . $this->Symbol . '"'
              . ', `capital`="' . $this->Capital . '"'
              . ', `currency`="' . $this->Currency . '"'
              . ', `continent`="' . $this->Continent . '"'
              . ', `continent_code`="' . $this->ContinentCode . '"'
              . ', `alpha_3`="' . $this->Alpha3 . '"'
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
    $vSQL = 'DELETE FROM `phs_cod_country` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}
