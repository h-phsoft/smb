<?php

if (isset($oRest)) {

  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => cAccAcc::refreshTree()
  ));
}