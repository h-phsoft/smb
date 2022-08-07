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

class cClncAppointment {

  var $Id = -999;
  var $Date;
  var $Hour;
  var $Minute;
  var $Minutes;
  var $Amount = 0;
  var $IUserId = -9;
  var $IDate = '';
  var $UUserId = -9;
  var $UDate = '';
  var $Description;
  var $StatusId;
  var $StatusName;
  var $StatusIcon;
  var $StatusColor;
  var $ClinicId;
  var $ClinicName;
  var $ClinicEmail;
  var $ClinicPhone1;
  var $ClinicPhone2;
  var $ClinicPhone3;
  var $ClinicAddress;
  var $ClinicStatusId;
  var $DoctorId;
  var $DoctorName;
  var $DoctorMobile;
  var $DoctorGenderId;
  var $DoctorGenderName;
  var $DoctorStatusId;
  var $DoctorSpecialId;
  var $TypeId;
  var $TypeName;
  var $TypeCapacity;
  var $TypeTime;
  var $TypeTitlebgId;
  var $TypeTitlfgId;
  var $TypeNamefgId;
  var $SpecialId;
  var $SpecialName;
  var $PatientId;
  var $PatientNum;
  var $PatientName;
  var $PatientMobile;
  var $PatientNatId;
  var $PatientNatNum;
  var $PatientGenderId;

  public static function getSelectStatement($vWhere = '', $vOrder = '', $vLimit = '') {
    $sSQL = 'SELECT `id`, `date`, `hour`, `minute`, `minutes`, `amount`, `description`,'
            . ' `iuser_id`, DATE_FORMAT(`idate`,"%Y-%m-%d %H:%i") AS `idate`,'
            . ' `uuser_id`, DATE_FORMAT(`udate`,"%Y-%m-%d %H:%i") AS `udate`,'
            . ' `status_id`          , `status_name`        , `status_icon`        , `status_color`       ,'
            . ' `clinic_id`          , `clinic_name`        , `clinic_email`       , `clinic_phone1`      ,'
            . ' `clinic_phone2`      , `clinic_phone3`      , `clinic_address`     , `clinic_status_id`   ,'
            . ' `doctor_id`          , `doctor_name`        , `doctor_mobile`      , `doctor_gender_id`   ,'
            . ' `doctor_status_id`   , `doctor_special_id`  ,'
            . ' `type_id`            , `type_name`          , `type_capacity`      ,`type_time`           ,'
            . ' `type_titlebg_id`    , `type_titlfg_id`     , `type_namefg_id`     ,'
            . ' `special_id`         , `special_name`       , '
            . ' `patient_id`         , `patient_num`        , `patient_name`       , `patient_mobile`     ,'
            . ' `patient_nat_num`    , `patient_nat_id`     , `patient_gender_id`'
            . ' FROM `clnc_vappointment`'
            . ' WHERE (`doctor_status_id`=1)';
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

  public static function getCount($vWhere = '') {
    $nCount = 0;
    $sSQL = 'SELECT count(*) nCnt FROM `clnc_vappointment`';
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

  public static function getArray($vWhere = '', $vOrder = '`date` DESC, `hour` DESC, `doctor_id`, `type_id`', $nPage = 0, $nPageSize = 0) {
    $aArray = array();
    $nIdx = 0;
    $vLimit = '';
    if ($nPage != 0 && $nPageSize != 0) {
      $vLimit = ((($nPage - 1) * $nPageSize)) . ', ' . $nPageSize;
    }
    $res = ph_Execute(cClncAppointment::getSelectStatement($vWhere, $vOrder, $vLimit));
    if ($res != '') {
      while (!$res->EOF) {
        $aArray[$nIdx] = cClncAppointment::getFields($res);
        $nIdx++;
        $res->MoveNext();
      }
      $res->Close();
    }
    return $aArray;
  }

  public static function getInstance($nId) {
    $cClass = new cClncAppointment();
    $res = ph_Execute(cClncAppointment::getSelectStatement('(`id`="' . $nId . '")'));
    if ($res != '') {
      if (!$res->EOF) {
        $cClass = cClncAppointment::getFields($res);
      }
      $res->Close();
    }
    return $cClass;
  }

  public static function getFields($res) {
    $cClass = new cClncAppointment();
    $cClass->IUserId = $res->fields("iuser_id");
    $cClass->IDate = $res->fields("idate");
    $cClass->UUserId = $res->fields("uuser_id");
    $cClass->UDate = $res->fields("udate");
    $cClass->Id = intval($res->fields("id"));
    $cClass->Date = $res->fields("date");
    $cClass->Hour = $res->fields("hour");
    $cClass->Minute = $res->fields("minute");
    $cClass->Minutes = $res->fields("minutes");
    $cClass->Amount = $res->fields("amount");
    $cClass->Description = $res->fields("description");
    $cClass->StatusId = intval($res->fields("status_id"));
    $cClass->StatusName = $res->fields("status_name");
    $cClass->StatusIcon = $res->fields("status_icon");
    $cClass->StatusColor = $res->fields("status_color");
    $cClass->ClinicId = intval($res->fields("clinic_id"));
    $cClass->ClinicName = $res->fields("clinic_name");
    $cClass->ClinicEmail = $res->fields("clinic_email");
    $cClass->ClinicPhone1 = $res->fields("clinic_phone1");
    $cClass->ClinicPhone2 = $res->fields("clinic_phone2");
    $cClass->ClinicPhone3 = $res->fields("clinic_phone3");
    $cClass->ClinicAddress = $res->fields("clinic_address");
    $cClass->ClinicStatusId = intval($res->fields("clinic_status_id"));
    $cClass->DoctorId = intval($res->fields("doctor_id"));
    $cClass->DoctorName = $res->fields("doctor_name");
    $cClass->DoctorMobile = $res->fields("doctor_mobile");
    $cClass->DoctorGenderId = intval($res->fields("doctor_gender_id"));
    $cClass->DoctorStatusId = intval($res->fields("doctor_status_id"));
    $cClass->DoctorSpecialId = intval($res->fields("doctor_special_id"));
    $cClass->TypeId = intval($res->fields("type_id"));
    $cClass->TypeName = $res->fields("type_name");
    $cClass->TypeCapacity = $res->fields("type_capacity");
    $cClass->TypeTime = $res->fields("type_time");
    $cClass->TypeTitlebgId = intval($res->fields("type_titlebg_id"));
    $cClass->TypeTitlfgId = intval($res->fields("type_titlfg_id"));
    $cClass->TypeNamefgId = intval($res->fields("type_namefg_id"));
    $cClass->SpecialId = intval($res->fields("special_id"));
    $cClass->SpecialName = $res->fields("special_name");
    $cClass->PatientId = intval($res->fields("patient_id"));
    $cClass->PatientNum = $res->fields("patient_num");
    $cClass->PatientName = $res->fields("patient_name");
    $cClass->PatientMobile = $res->fields("patient_mobile");
    $cClass->PatientNatNum = $res->fields("patient_nat_num");
    $cClass->PatientNatId = $res->fields("patient_nat_id");
    $cClass->PatientGenderId = intval($res->fields("patient_gender_id"));
    return $cClass;
  }

  public function save($nUId) {
    $nId = $this->Id;
    if ($this->Id == 0 || $this->Id == -999) {
      $vSQL = 'INSERT INTO `clnc_appointment`'
              . '(`type_id`, `clinic_id`, `doctor_id`, `patient_id`, `special_id`,'
              . ' `date`, `hour`, `minute`, `amt`, `description`, `ins_user`'
              . ') VALUES ('
              . '  "' . $this->TypeId . '"'
              . ', "' . $this->ClinicId . '"'
              . ', "' . $this->DoctorId . '"'
              . ', "' . $this->PatientId . '"'
              . ', "' . $this->SpecialId . '"'
              . ', STR_TO_DATE("' . $this->Date . '","%Y-%m-%d")'
              . ', "' . $this->Hour . '"'
              . ', "' . $this->Minute . '"'
              . ', "' . $this->Amount . '"'
              . ', "' . $this->Description . '"'
              . ', "' . $nUId . '"'
              . ')';
      $res = ph_ExecuteInsert($vSQL);
      if ($res || $res === 0) {
        $nId = ph_InsertedId();
      } else {
        $aMsg = ph_GetMySQLMessageAsArray();
        $vMsgs = $aMsg['ErrNo'] . ': ' . $aMsg['ErrMsg'] . ' Num=[' . $this->Num . '] res=[' . $res . ']';
        throw new Exception($vMsgs);
      }
    } else {
      $vSQL = 'UPDATE `clnc_appointment` SET'
              . '  `type_id`="' . $this->TypeId . '"'
              . ', `clinic_id`="' . $this->ClinicId . '"'
              . ', `doctor_id`="' . $this->DoctorId . '"'
              . ', `patient_id`="' . $this->PatientId . '"'
              . ', `special_id`="' . $this->SpecialId . '"'
              . ', `date`=STR_TO_DATE("' . $this->Date . '","%Y-%m-%d")'
              . ', `hour`="' . $this->Hour . '"'
              . ', `minute`="' . $this->Minute . '"'
              //. ', `amt`="' . $this->Amount . '"'  // لايمكن تعديل الدفعة على الموعد
              . ', `upd_user`="' . $nUId . '"'
              . ', `description`="' . $this->Description . '"'
              . ' WHERE `id`="' . $this->Id . '"';
      ph_ExecuteUpdate($vSQL);
    }
    return $nId;
  }

  public function delete() {
    $vSQL = 'DELETE FROM `clnc_appointment` WHERE `id`="' . $this->Id . '"';
    ph_Execute($vSQL);
  }

  public function updateStatus($nStatus = 0) {
    if ($this->Id > 0 || $nStatus > 0) {
      $vSQL = 'UPDATE `clnc_appointment` SET'
              . ' `status_id`="' . $nStatus . '"'
              . ', `upd_user`="' . $this->UUserId . '"'
              . ' WHERE `id`="' . $this->Id . '"';
      ph_Execute($vSQL);
    }
  }

}
