<?php

if (isset($oRest)) {

  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => cFundDiary::getTotals(date("Y-m-d"))
  ));
}
