<?php

if (isset($oRest)) {

  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => cAccAcc::getJSTree(-1)
  ));
}