<?php

class cPhsLang {

  var $Id = -999;
  var $Name = '';
  var $Code = '';
  var $Direction = '';
  var $Rem = '';

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `name`, `code`, `dir`, `rem`'
            . ' FROM `phs_lang`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `phs_lang`';
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

  public static function getInstanceByCode($vCode) {
    $cClass = new cPhsLang();
    $sSQL = 'SELECT `id`, `name`, `code`, `dir`, `rem`'
            . ' FROM ' . PHS_SMB_ADMIN_FULL . '`phs_lang`'
            . ' WHERE (`code`="' . $vCode . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getInstanceById($nId) {
    $cClass = new cPhsLang();
    $sSQL = 'SELECT `id`, `name`, `code`, `dir`, `rem`'
            . ' FROM ' . PHS_SMB_ADMIN_FULL . '`phs_lang`'
            . ' WHERE (`id`="' . $nId . '")';
    $res = ph_Execute($sSQL);
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cPhsLang();
    $cClass->Id = intval($res->fields("id"));
    $cClass->Name = $res->fields("name");
    $cClass->Code = $res->fields("code");
    $cClass->Direction = $res->fields("dir");
    $cClass->Rem = $res->fields("rem");
    return $cClass;
  }

}
