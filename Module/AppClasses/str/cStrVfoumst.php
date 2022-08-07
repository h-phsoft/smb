<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 *
 * Generate MySQL Database tables Classes
 * PhGenDBClasses
 * 1.0.0.210930.1850
 *
 * at : ????/??/?? ??:??:??
 *
 * @author Haytham
 * @version 1.0.0.210930.1850
 * @update ????/??/?? ??:??
 *
 */

class cStrVfoumst {

  var $MstId;
  var $WperId;
  var $WperName;
  var $StorId;
  var $StorNum;
  var $StorName;
  var $AccId;
  var $AccNum;
  var $AccName;
  var $CostId;
  var $CostNum;
  var $CostName;
  var $DocId;
  var $DocName;
  var $SrcId;
  var $TypeId;
  var $RelId;
  var $VhrId;
  var $FinId;
  var $CurnId;
  var $BcurnId;
  var $CurnRate;
  var $BcurnRate;
  var $MstDocn;
  var $MstDocd;
  var $MstNum;
  var $MstDate;
  var $MstPerson;
  var $MstPhone;
  var $MstRem;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `mst_id`, `wper_id`, `wper_name`, `stor_id`, `stor_num`, `stor_name`, `acc_id`'
      . ', `acc_num`, `acc_name`, `cost_id`, `cost_num`, `cost_name`, `doc_id`, `doc_name`'
      . ', `src_id`, `type_id`, `rel_id`, `vhr_id`, `fin_id`, `curn_id`, `bcurn_id`'
      . ', `curn_rate`, `bcurn_rate`, `mst_docn`, `mst_docd`, `mst_num`, `mst_date`, `mst_person`'
      . ', `mst_phone`, `mst_rem`'
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
    $res = ph_Execute(cStrVfoumst::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cStrVfoumst::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cStrVfoumst();
    $res = ph_Execute(cStrVfoumst::getSelectStatement('(`id` = "' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cStrVfoumst::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cStrVfoumst();
    $cClass->MstId = intval($res->fields('mst_id'));
    $cClass->WperId = intval($res->fields('wper_id'));
    $cClass->WperName = $res->fields('wper_name');
    $cClass->StorId = intval($res->fields('stor_id'));
    $cClass->StorNum = intval($res->fields('stor_num'));
    $cClass->StorName = $res->fields('stor_name');
    $cClass->AccId = intval($res->fields('acc_id'));
    $cClass->AccNum = $res->fields('acc_num');
    $cClass->AccName = $res->fields('acc_name');
    $cClass->CostId = intval($res->fields('cost_id'));
    $cClass->CostNum = $res->fields('cost_num');
    $cClass->CostName = $res->fields('cost_name');
    $cClass->DocId = intval($res->fields('doc_id'));
    $cClass->DocName = $res->fields('doc_name');
    $cClass->SrcId = intval($res->fields('src_id'));
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->RelId = intval($res->fields('rel_id'));
    $cClass->VhrId = intval($res->fields('vhr_id'));
    $cClass->FinId = intval($res->fields('fin_id'));
    $cClass->CurnId = intval($res->fields('curn_id'));
    $cClass->BcurnId = intval($res->fields('bcurn_id'));
    $cClass->CurnRate = floatval($res->fields('curn_rate'));
    $cClass->BcurnRate = floatval($res->fields('bcurn_rate'));
    $cClass->MstDocn = $res->fields('mst_docn');
    $cClass->MstDocd = $res->fields('mst_docd');
    $cClass->MstNum = intval($res->fields('mst_num'));
    $cClass->MstDate = $res->fields('mst_date');
    $cClass->MstPerson = $res->fields('mst_person');
    $cClass->MstPhone = $res->fields('mst_phone');
    $cClass->MstRem = $res->fields('mst_rem');
    //
    return $cClass;
  }


}
