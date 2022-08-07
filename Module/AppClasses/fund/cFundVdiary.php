<?php

/*
 * PhSoft(R) 1989-2021
 * Copyrights(c) 2021
 * 
 * Generate PHP APIs
 * PhGenPHPAPIs
 * 2.0.1.211108.0840
 * 
 * @author Haytham
 * @version 2.0.1.211108.0840
 * @update ????/??/?? ??:??
 *
 */

class cFundVdiary {

  var $AccId;
  var $AccNum;
  var $AccName;
  var $AccRem;
  var $CostId;
  var $CostNum;
  var $CostName;
  var $CurnId;
  var $CurnName;
  var $CurnRate;
  var $CurnColor;
  var $CurnCode;
  var $TypeId;
  var $TypeName;
  var $BoxId;
  var $BoxUserId;
  var $BoxAccId;
  var $BoxStatusId;
  var $BoxName;
  var $BoxRem;
  var $Id;
  var $Ccrd;
  var $Cdeb;
  var $Crd;
  var $Deb;
  var $Print;
  var $Date;
  var $Camt;
  var $Rate;
  var $Amt;
  var $Rem;
  //

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `acc_id`, `acc_num`, `acc_name`, `acc_rem`, `cost_id`, `cost_num`, `cost_name`'
      . ', `curn_id`, `curn_name`, `curn_rate`, `curn_color`, `curn_code`, `type_id`, `type_name`'
      . ', `box_id`, `box_user_id`, `box_acc_id`, `box_status_id`, `box_name`, `box_rem`, `id`'
      . ', `ccrd`, `cdeb`, `crd`, `deb`, `print`, `date`, `camt`'
      . ', `rate`, `amt`, `rem`'
      . ' FROM `fund_vdiary`';
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
    $sSQL = 'SELECT count(*) nCnt FROM `fund_vdiary`';
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
    $res = ph_Execute(cFundVdiary::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cFundVdiary::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cFundVdiary();
    $res = ph_Execute(cFundVdiary::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cFundVdiary::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cFundVdiary();
    $cClass->AccId = intval($res->fields('acc_id'));
    $cClass->AccNum = $res->fields('acc_num');
    $cClass->AccName = $res->fields('acc_name');
    $cClass->AccRem = $res->fields('acc_rem');
    $cClass->CostId = intval($res->fields('cost_id'));
    $cClass->CostNum = $res->fields('cost_num');
    $cClass->CostName = $res->fields('cost_name');
    $cClass->CurnId = intval($res->fields('curn_id'));
    $cClass->CurnName = $res->fields('curn_name');
    $cClass->CurnRate = floatval($res->fields('curn_rate'));
    $cClass->CurnColor = $res->fields('curn_color');
    $cClass->CurnCode = $res->fields('curn_code');
    $cClass->TypeId = intval($res->fields('type_id'));
    $cClass->TypeName = $res->fields('type_name');
    $cClass->BoxId = intval($res->fields('box_id'));
    $cClass->BoxUserId = intval($res->fields('box_user_id'));
    $cClass->BoxAccId = intval($res->fields('box_acc_id'));
    $cClass->BoxStatusId = intval($res->fields('box_status_id'));
    $cClass->BoxName = $res->fields('box_name');
    $cClass->BoxRem = $res->fields('box_rem');
    $cClass->Id = intval($res->fields('id'));
    $cClass->Ccrd = floatval($res->fields('ccrd'));
    $cClass->Cdeb = floatval($res->fields('cdeb'));
    $cClass->Crd = floatval($res->fields('crd'));
    $cClass->Deb = floatval($res->fields('deb'));
    $cClass->Print = intval($res->fields('print'));
    $cClass->Date = $res->fields('date');
    $cClass->Camt = floatval($res->fields('camt'));
    $cClass->Rate = floatval($res->fields('rate'));
    $cClass->Amt = floatval($res->fields('amt'));
    $cClass->Rem = $res->fields('rem');
    //
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `fund_vdiary` ('
        . '  `acc_num`, `acc_name`, `acc_rem`, `cost_id`, `cost_num`, `cost_name`, `curn_id`'
        . ', `curn_name`, `curn_rate`, `curn_color`, `curn_code`, `type_id`, `type_name`, `box_id`'
        . ', `box_user_id`, `box_acc_id`, `box_status_id`, `box_name`, `box_rem`, `id`, `ccrd`'
        . ', `cdeb`, `crd`, `deb`, `print`, `date`, `camt`, `rate`'
        . ', `amt`, `rem`, `ins_user`'
        . ') VALUES ('
        . '  "' . $this->AccNum . '"'
        . ', "' . $this->AccName . '"'
        . ', "' . $this->AccRem . '"'
        . ', "' . $this->CostId . '"'
        . ', "' . $this->CostNum . '"'
        . ', "' . $this->CostName . '"'
        . ', "' . $this->CurnId . '"'
        . ', "' . $this->CurnName . '"'
        . ', "' . $this->CurnRate . '"'
        . ', "' . $this->CurnColor . '"'
        . ', "' . $this->CurnCode . '"'
        . ', "' . $this->TypeId . '"'
        . ', "' . $this->TypeName . '"'
        . ', "' . $this->BoxId . '"'
        . ', "' . $this->BoxUserId . '"'
        . ', "' . $this->BoxAccId . '"'
        . ', "' . $this->BoxStatusId . '"'
        . ', "' . $this->BoxName . '"'
        . ', "' . $this->BoxRem . '"'
        . ', "' . $this->Id . '"'
        . ', "' . $this->Ccrd . '"'
        . ', "' . $this->Cdeb . '"'
        . ', "' . $this->Crd . '"'
        . ', "' . $this->Deb . '"'
        . ', "' . $this->Print . '"'
        . ', "' . $this->Date . '"'
        . ', "' . $this->Camt . '"'
        . ', "' . $this->Rate . '"'
        . ', "' . $this->Amt . '"'
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
      $vSQL = 'UPDATE `fund_vdiary` SET'
        . '  `acc_num`="' . $this->AccNum . '"'
        . ', `acc_name`="' . $this->AccName . '"'
        . ', `acc_rem`="' . $this->AccRem . '"'
        . ', `cost_id`="' . $this->CostId . '"'
        . ', `cost_num`="' . $this->CostNum . '"'
        . ', `cost_name`="' . $this->CostName . '"'
        . ', `curn_id`="' . $this->CurnId . '"'
        . ', `curn_name`="' . $this->CurnName . '"'
        . ', `curn_rate`="' . $this->CurnRate . '"'
        . ', `curn_color`="' . $this->CurnColor . '"'
        . ', `curn_code`="' . $this->CurnCode . '"'
        . ', `type_id`="' . $this->TypeId . '"'
        . ', `type_name`="' . $this->TypeName . '"'
        . ', `box_id`="' . $this->BoxId . '"'
        . ', `box_user_id`="' . $this->BoxUserId . '"'
        . ', `box_acc_id`="' . $this->BoxAccId . '"'
        . ', `box_status_id`="' . $this->BoxStatusId . '"'
        . ', `box_name`="' . $this->BoxName . '"'
        . ', `box_rem`="' . $this->BoxRem . '"'
        . ', `id`="' . $this->Id . '"'
        . ', `ccrd`="' . $this->Ccrd . '"'
        . ', `cdeb`="' . $this->Cdeb . '"'
        . ', `crd`="' . $this->Crd . '"'
        . ', `deb`="' . $this->Deb . '"'
        . ', `print`="' . $this->Print . '"'
        . ', `date`="' . $this->Date . '"'
        . ', `camt`="' . $this->Camt . '"'
        . ', `rate`="' . $this->Rate . '"'
        . ', `amt`="' . $this->Amt . '"'
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
    $vSQL = 'DELETE FROM `fund_vdiary` WHERE `id`="' . $this->Id . '"';
    $res = ph_Execute($vSQL);
    if ($res || $res === 0) {

    } else {
      $aMsg = ph_GetMySQLMessageAsArray();
      $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
      throw new Exception($vMsgs);
    }
  }

}

