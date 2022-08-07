<?php

if (isset($oRest)) {

  $nId = ph_Get_Post('nId');
  if ($oUser->oGrp->getPermission(ph_Get_Post('progId'))->Delete) {
    $oInstance = cSalMprice::getInstance($nId);
    try {
      $aList = cSalTprice::getArray('price_id=' . $nId);
            foreach ($aList as $element) {
                $element->delete();
            }
      $oInstance->delete();
      $oRest->setRowData(array(
        'Status' => true,
        'Message' => getLabel('Done')
      ));
    } catch (Exception $exc) {
      $oRest->setMessage($exc->getMessage());
    }
  }
}
