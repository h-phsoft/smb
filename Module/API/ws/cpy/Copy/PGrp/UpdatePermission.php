<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  $nisOK = ph_Get_Post('isOK');
  $nInsert = ph_Get_Post('ins');
  $nUpdate = ph_Get_Post('upd');
  $nDelete = ph_Get_Post('del');
  $nQuery = ph_Get_Post('qry');
  $nPrint = ph_Get_Post('prt');
  $nCommit = ph_Get_Post('cmt');
  $nRevoke = ph_Get_Post('rvk');
  $nExport = ph_Get_Post('exp');
  $nImport = ph_Get_Post('imp');
  $nSpecial = ph_Get_Post('spc');
  $vSQL = 'UPDATE `cpy_perm` SET'
    . ' `isOK`="' . $nisOK . '"'
    . ',`ins`="' . $nInsert . '"'
    . ',`upd`="' . $nUpdate . '"'
    . ',`del`="' . $nDelete . '"'
    . ',`qry`="' . $nQuery . '"'
    . ',`prt`="' . $nPrint . '"'
    . ',`cmt`="' . $nCommit . '"'
    . ',`rvk`="' . $nRevoke . '"'
    . ',`exp`="' . $nExport . '"'
    . ',`imp`="' . $nImport . '"'
    . ',`spc`="' . $nSpecial . '"'
    . ' WHERE (`id`="' . $nId . '")';
  ph_Execute($vSQL);
  $oRest->setRowData(array(
    'Status' => true,
    'Message' => 'Done'
  ));
}
