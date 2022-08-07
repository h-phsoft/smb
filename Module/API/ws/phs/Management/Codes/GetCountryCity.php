<?php

if (isset($oRest)) {

    $nId = ph_Get_Post('nId');
    $aList = cPhsCodCity::getArray('`country_id`='.$nId);
    $aData = array();
    $nIdx = 0;
    foreach ($aList as $element) {
        $aData[$nIdx] = array(
            'id' => $element->Id,
            'value' => $element->Id,
            'label' => $element->Code.'-'.$element->Name,
        );
        $nIdx++;
    }
    $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done',
        'Data' => $aData,
    ));
}
