<?php

class cCpyPerm {

  var $Id = -999;
  var $GrpId = 0;
  var $SysId = 0;
  var $SysName = '';
  var $ProgId = 0;
  var $ProgName = '';
  var $ProgPId = 0;
  var $ProgPName = '';
  var $OK = 0;
  var $Ins = 0;
  var $Upd = 0;
  var $Del = 0;
  var $Qry = 0;
  var $Prt = 0;
  var $Exp = 0;
  var $Imp = 0;
  var $Cmt = 0;
  var $Rvk = 0;
  var $Spc = 0;
  var $isOK = false;
  var $Insert = false;
  var $Update = false;
  var $Delete = false;
  var $Query = false;
  var $Print = false;
  var $Export = false;
  var $Import = false;
  var $Commit = false;
  var $Revoke = false;
  var $Special = false;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT p.id, p.grp_id, v.sys_id, v.sys_name, v.id as prog_id, v.name, v.prog_id as prog_pid, '
            . ' p.isok, p.ins, p.upd, p.del, p.qry, p.prt, p.exp, p.imp, p.cmt, p.rvk, p.spc'
            . ' FROM cpy_perm AS p, phs_vprogram AS v'
            . ' WHERE (p.prog_id=v.id)';
    if ($vWhere != '') {
      $sSQL .= ' AND (' . $vWhere . ') ';
    }
    if ($vOrder != '') {
      $sSQL .= ' ORDER BY ' . $vOrder;
    }
    if ($vLimit != '') {
      $sSQL .= ' LIMIT ' . $vLimit;
    }
    return $sSQL;
  }

  public static function getArray($vWhere = '') {
    $aArray = array();
    $nIdx = 0;
    $res = ph_Execute(self::getSelectStatement($vWhere, 'v.sys_id, p.grp_id, v.prog_id, v.ord'));
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

  public static function getGroupPermissions($vWhere = '') {
    $aArray = array();
    $res = ph_Execute(self::getSelectStatement($vWhere, 'v.sys_id, v.prog_id, v.id'));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[intval($res->fields("prog_id"))] = self::getFields($res);
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cCpyPerm();
    $res = ph_Execute(self::getSelectStatement('(id="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = self::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cCpyPerm();
    $cClass->Id = intval($res->fields("id"));
    $cClass->GrpId = intval($res->fields("grp_id"));
    $cClass->SysId = intval($res->fields("sys_id"));
    $cClass->SysName = $res->fields("sys_name");
    $cClass->ProgId = intval($res->fields("prog_id"));
    $cClass->ProgName = $res->fields("name");
    $cClass->OK = intval($res->fields("isok"));
    $cClass->Ins = intval($res->fields("ins"));
    $cClass->Upd = intval($res->fields("upd"));
    $cClass->Del = intval($res->fields("del"));
    $cClass->Qry = intval($res->fields("qry"));
    $cClass->Prt = intval($res->fields("prt"));
    $cClass->Exp = intval($res->fields("exp"));
    $cClass->Imp = intval($res->fields("imp"));
    $cClass->Cmt = intval($res->fields("cmt"));
    $cClass->Rvk = intval($res->fields("rvk"));
    $cClass->Spc = intval($res->fields("spc"));
    $cClass->isOK = $cClass->OK == 1;
    $cClass->Insert = $cClass->Ins == 1;
    $cClass->Update = $cClass->Upd == 1;
    $cClass->Delete = $cClass->Del == 1;
    $cClass->Query = $cClass->Qry == 1;
    $cClass->Print = $cClass->Prt == 1;
    $cClass->Export = $cClass->Exp == 1;
    $cClass->Import = $cClass->Imp == 1;
    $cClass->Commit = $cClass->Cmt == 1;
    $cClass->Revoke = $cClass->Rvk == 1;
    $cClass->Special = $cClass->Spc == 1;
    $cClass->ProgPId = intval($res->fields("prog_pid"));
    $cClass->ProgPName = ph_GetDBValue('name', 'phs_vprogram', 'id="' . $cClass->ProgPId . '"');
    return $cClass;
  }

  public static function refreshPermissions($nPGrpId, $UserId) {
    $vSQL = 'INSERT INTO cpy_perm (grp_id, prog_id)'
            . ' SELECT ' . $nPGrpId . ', id'
            . ' FROM phs_vprogram'
            . ' WHERE grp_id>=' . $nPGrpId
            . '   AND id NOT IN (SELECT prog_id FROM cpy_perm WHERE grp_id="' . $nPGrpId . '")';
    ph_Execute($vSQL);
  }

}
