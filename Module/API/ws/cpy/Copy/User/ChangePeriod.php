<?php

if (isset($oRest)) {

  ph_SetSession('GUId', serialize($aGUId));
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}