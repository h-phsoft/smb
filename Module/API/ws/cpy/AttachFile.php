<?php

if (isset($oRest)) {

  $vFile = ph_Get_Post('vFile');
  $vFileName = ph_Get_Post('vFileName');
  $vType = ph_Get_Post('vType');
  $vExtention = ph_Get_Post('vExt');
  $vFolder = ph_Get_Post('vFolder');
  $fileName = base64_to_file($vFile, 'cpy_Attache', $vExtention, $vAttacheRootPath . $vFolder);

  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done',
    'Filename' => $fileName
  ));
}
