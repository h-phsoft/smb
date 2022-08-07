<?php

if (isset($oRest)) {

  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Data' => cAccCost::getJSTree(-1)
  ));
}