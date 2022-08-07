<?php

class cFundDiary {

  var $Id = -999;
  var $BoxId;
  var $BoxName;
  var $BoxRem;
  var $BoxUserId;
  var $BoxAccId;
  var $BoxStatusId;
  var $CurnId;
  var $CurnCode;
  var $CurnName;
  var $CurnColor;
  var $CurnRate;
  var $TypeId;
  var $TypeName;
  var $AccId;
  var $AccNum;
  var $AccName;
  var $CostId;
  var $CostNum;
  var $CostName;
  var $Date;
  var $Print;
  var $Deb;
  var $Crdt;
  var $CAmt;
  var $Rate;
  var $Amt;
  var $Rem;
  var $Attach;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `crd`, `deb`, `print`, `date`, `amt`, `camt`, `rem`, `attach`,'
            . '`acc_id`, `acc_num`, `acc_name`,'
            . '`cost_id`, `cost_num`, `cost_name`,'
            . '`curn_id`, `curn_name`, `curn_rate`, `curn_color`, `curn_code`,'
            . '`type_id`, `type_name`,'
            . '`box_id`, `box_user_id`, `box_acc_id`, `box_status_id`,'
            . '`box_name`, `box_rem`'
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
      $vOrder = '`date` DESC, `id` DESC';
    }
    $res = ph_Execute(cFundDiary::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cFundDiary::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cFundDiary();
    $res = ph_Execute(cFundDiary::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cFundDiary::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cFundDiary();
    $cClass->Id = intval($res->fields("id"));
    $cClass->BoxUserId = intval($res->fields("box_user_id"));
    $cClass->BoxAccId = intval($res->fields("box_acc_id"));
    $cClass->BoxStatusId = intval($res->fields("box_status_id"));
    $cClass->BoxId = intval($res->fields("box_id"));
    $cClass->BoxName = $res->fields("box_name");
    $cClass->BoxRem = $res->fields("box_rem");
    $cClass->AccId = intval($res->fields("acc_id"));
    $cClass->AccNum = $res->fields("acc_num");
    $cClass->AccName = $res->fields("acc_name");
    $cClass->CostId = intval($res->fields("cost_id"));
    $cClass->CostNum = $res->fields("cost_num");
    $cClass->CostName = $res->fields("cost_name");
    $cClass->TypeId = intval($res->fields("type_id"));
    $cClass->TypeName = $res->fields("type_name");

    $cClass->CurnId = intval($res->fields("curn_id"));
    $cClass->CurnCode = $res->fields("curn_code");
    $cClass->CurnName = $res->fields("curn_name");
    $cClass->CurnRate = $res->fields("curn_rate");
    $cClass->CurnColor = $res->fields("curn_color");

    $cClass->Date = $res->fields("date");
    $cClass->Print = $res->fields("print");

    $cClass->Crd = floatval($res->fields("crd"));
    $cClass->Deb = floatval($res->fields("deb"));
    //$cClass->CCrd = floatval($res->fields("ccrd"));
    //$cClass->CDeb = floatval($res->fields("cdeb"));
    //$cClass->Rate = floatval($res->fields("rate"));
    $cClass->Amt = floatval($res->fields("amt"));
    $cClass->CAmt = floatval($res->fields("camt"));

    $cClass->Rem = $res->fields("rem");
    $cClass->Rem = (($cClass->Rem == 'null' || $cClass->Rem == null) ? '' : $cClass->Rem);
    $cClass->Attach = $res->fields("attach");
    return $cClass;
  }

  public function save($nUId) {
    $nId = 0;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `fund_diary` ('
              . '`box_id`, `type_id`, `acc_id`, `cost_id`, `curn_id`, `date`, `rate`'
              . ', `camt`, `amt`, `rem`, `attach`, `ins_user`'
              . ') VALUES ('
              . ' "' . $this->BoxId . '"'
              . ',"' . $this->TypeId . '"'
              . ',"' . $this->AccId . '"'
              . ',"' . $this->CostId . '"'
              . ',"' . $this->CurnId . '"'
              . ',"' . $this->Date . '"'
              . ',"' . $this->Rate . '"'
              . ',"' . $this->CAmt . '"'
              . ',"' . $this->Amt . '"'
              . ',"' . $this->Rem . '"'
              . ',"' . $this->Attach . '"'
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
      $nId = $this->Id;
      $vSQL = 'UPDATE `fund_diary` SET'
              . ' `box_id`="' . $this->BoxId . '"'
              . ',`type_id`="' . $this->TypeId . '"'
              . ',`acc_id`="' . $this->AccId . '"'
              . ',`cost_id`="' . $this->CostId . '"'
              . ',`curn_id`="' . $this->CurnId . '"'
              . ',`date`="' . $this->Date . '"'
              . ',`rate`="' . $this->Rate . '"'
              . ',`camt`="' . $this->CAmt . '"'
              . ',`amt`="' . $this->Amt . '"'
              . ',`rem`="' . $this->Rem . '"'
              . ',`attach`="' . $this->Attach . '"'
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
    if ($this->Id > 0) {
      $vSQL = 'DELETE FROM `fund_diary` WHERE `id` = "' . $this->Id . '"';
      $res = ph_ExecuteUpdate($vSQL);
      if ($res || $res === 0) {

      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrCod'] . ': ' . $aMsg['ErrMsg'];
        throw new Exception($vMsgs);
      }
    }
  }

  public static function getDateBefore($nBox, $dDate) {
    $dDayDate = '';
    $sSQL = 'SELECT MAX(`date`) AS `dDate`'
            . ' FROM `fund_diary`'
            . ' WHERE `box_id`="' . $nBox . '"'
            . ' AND `date`<STR_TO_DATE("' . $dDate . '","%Y-%m-%d")';
    $res = ph_Execute($sSQL);
    if ($res != "" && !$res->EOF) {
      $dDayDate = $res->fields('dDate');
      if ($dDayDate == null) {
        $dDayDate = '';
      }
    }
    return $dDayDate;
  }

  public static function getDateAfter($nBox, $dDate) {
    $dDayDate = '';
    $sSQL = 'SELECT MIN(`date`) AS `dDate`'
            . ' FROM `fund_diary`'
            . ' WHERE `box_id`="' . $nBox . '"'
            . ' AND `date`>STR_TO_DATE("' . $dDate . '","%Y-%m-%d")';
    $res = ph_Execute($sSQL);
    if ($res != "" && !$res->EOF) {
      $dDayDate = $res->fields('dDate');
      if ($dDayDate == null) {
        $dDayDate = '';
      }
    }
    return $dDayDate;
  }

  public static function getBalance($nBox, $dDate, $nCurn) {
    $nBalance = 0;
    $sSQL = 'SELECT'
            . ' SUM((case when (`type_id`=1) then `amt` else 0 end)) AS `Crd`,'
            . ' SUM((case when (`type_id`=2) then `amt` else 0 end)) AS `Deb`'
            . ' FROM `fund_diary`'
            . ' WHERE `box_id`="' . $nBox . '"'
            . ' AND `date`<STR_TO_DATE("' . $dDate . '","%Y-%m-%d")'
            . ' AND `curn_id`="' . $nCurn . '"';
    $res = ph_Execute($sSQL);
    if ($res != "" && !$res->EOF) {
      $nBalance = floatval($res->fields('Crd')) - floatval($res->fields('Deb'));
    }
    return $nBalance;
  }

  public static function getaBalances($nBox, $dDate) {
    $aBalances = array();
    $sSQL = 'SELECT `curn_id`, `curn_code`,'
            . ' SUM((case when (`type_id`=1) then `camt` else 0 end)) AS `Crd`,'
            . ' SUM((case when (`type_id`=2) then `camt` else 0 end)) AS `Deb`'
            . ' FROM `fund_vdiary`'
            . ' WHERE `box_id`="' . $nBox . '"'
            . ' AND `date`<STR_TO_DATE("' . $dDate . '","%Y-%m-%d")'
            . ' GROUP BY `curn_id`, `curn_code`'
            . ' ORDER BY `curn_id`, `curn_code`';
    $res = ph_Execute($sSQL);
    if ($res != "") {
      while (!$res->EOF) {
        $aBalances[$res->fields('curn_code')] = array(
            'code' => $res->fields('curn_code'),
            'blnc' => floatval($res->fields('Crd')) - floatval($res->fields('Deb'))
        );
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aBalances;
  }

  public static function getSummary($dDate) {
    $aTotals = array();
    $nIdx = 0;
    $sSQL = 'SELECT `box_id`, `box_name`, SUM(`Opn`) AS `Opn`, SUM(`Crd`) AS `Crd`, SUM(`Deb`) AS `Deb`, SUM(`Opn`+`Crd`-`Deb`) AS `Bln`'
            . ' FROM ('
            . ' SELECT `box_id`, `box_name`, SUM(`crd`)-SUM(`deb`) AS `Opn`, 0 AS `Crd`, 0 AS `Deb`'
            . ' FROM `fund_vdiary`'
            . ' WHERE `date`<STR_TO_DATE("' . $dDate . '", "%Y-%m-%d")'
            . ' GROUP BY `box_id`, `box_name`'
            . ' UNION ALL '
            . ' SELECT `box_id`, `box_name`, 0 AS `Opn`, SUM(`crd`) AS `Crd`, SUM(`deb`) AS `Deb`'
            . ' FROM `fund_vdiary`'
            . ' WHERE `date` = STR_TO_DATE("' . $dDate . '", "%Y-%m-%d")'
            . ' GROUP BY `box_id`, `box_name`'
            . ') AS `aa` '
            . ' GROUP BY `box_id`, `box_name`'
            . ' ORDER BY `box_name`';
    $res = ph_Execute($sSQL);
    if ($res != "") {
      while (!$res->EOF) {
        $aTotals[$nIdx] = array(
            'nBox' => intval($res->fields('box_id')),
            'vBox' => $res->fields('box_name'),
            'nOpn' => floatval($res->fields('Opn')),
            'nCrd' => floatval($res->fields('Crd')),
            'nDeb' => floatval($res->fields('Deb')),
            'nBln' => floatval($res->fields('Bln'))
        );
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aTotals;
  }

}
