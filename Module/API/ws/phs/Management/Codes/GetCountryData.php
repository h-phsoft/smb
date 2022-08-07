<?php

if (isset($oRest)) {
    $nId = ph_Get_Post('nId');
    $aList = cPhsCodCity::getArray('`country_id`='.$nId); 
    $aList1 = cPhsCodSeaports::getArray('`country_id`='.$nId);
    $aList2 = cPhsCodAirports::getArray('`country_id`='.$nId); 
    $aData = array();
    $aData1 = array();
    $aData2 = array();
    $nIdx = 0; 
    $nIdx1 = 0;
    $nIdx2 = 0; 
    foreach ($aList as $element) {
        $aData[$nIdx] = array(
            'id' => $element->Id,
            'value' => $element->Id,
            'label' => $element->Code.'-'.$element->Name,
        );
        $nIdx++;
    } 
    foreach ($aList1 as $element) {
        $aData1[$nIdx1] = array(
            'id' => $element->Id,
            'value' => $element->Id,
            'label' => $element->Code.'-'.$element->Name,
        );
        $nIdx1++;
    }
    foreach ($aList2 as $element) {
        $aData2[$nIdx2] = array(
            'id' => $element->Id,
            'value' => $element->Id,
            'label' => $element->Code.'-'.$element->Name,
        );
        $nIdx2++;
    } 
    $oRest->setRowData(array(
        'Status' => true,
        'Message' => 'Done',
        'Cities' => $aData, 
        'Seaports' => $aData1,
        'Airports' => $aData2, 
    ));
}
