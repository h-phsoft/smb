<?php

/**
 * Description of PhsRest
 * RESTful web services class
 * Version 1.0.1
 *
 * @author Haytham
 */
class PhsRest extends PhsRestBase {

  public $RESPONSE_TYPE_JSON = 0;
  public $RESPONSE_TYPE_XML = 1;
  public $RESPONSE_TYPE_HTML = 2;
  private $responseType = 0;
  private $aRowData = array(
    'Status' => false,
    'Message' => 'Bad Request'
  );

  public function getResponeType() {
    return $this->responseType;
  }

  public function setResponeType($responseType) {
    $this->responseType = $responseType;
  }

  public function addRowDataValue($vKey, $vValue) {
    $this->aRowData[$vKey] = $vValue;
  }

  public function removeRowDataValue($vKey) {
    if (isset($this->aRowData[$vKey])) {
      unset($this->aRowData[$vKey]);
    }
  }

  public function getStatus() {
    return $this->aRowData['Status'];
  }

  public function setStatus($bStatus) {
    $this->aRowData['Status'] = $bStatus;
  }

  public function getMessage() {
    return $this->aRowData['Message'];
  }

  public function setMessage($vMessage) {
    $this->aRowData['Message'] = $vMessage;
  }

  public function addToMessage($vMessage) {
    $this->aRowData['Message'] .= '<br>' . $vMessage;
  }

  public function getRowData() {
    return $this->aRowData;
  }

  public function setRowData($aRowData) {
    $this->aRowData = $aRowData;
  }

  public function htmlResponse() {

    return $this->encodeHtml($this->aRowData);
  }

  public function jsonResponse() {
    return $this->encodeJson($this->aRowData);
  }

  public function xmlResponse() {
    return $this->encodeXml($this->aRowData);
  }

  public function getResponse() {
    $vResponse = '';
    switch ($this->responseType) {
      case $this->RESPONSE_TYPE_JSON:
        $vResponse = $this->jsonResponse();
        break;

      case $this->RESPONSE_TYPE_XML:
        $vResponse = $this->xmlResponse();
        break;

      case $this->RESPONSE_TYPE_HTML:
        $vResponse = $this->htmlResponse();
        break;
      default :
        $vResponse = $this->jsonResponse();
    }
    return $vResponse;
  }

  public function returnResponse() {
    //header($this->getHttpVersion() . " " . $this->getHttpStatusCode() . " " . $this->getHttpStatusMessage());
    //header("Content-Type:" . $this->getContentType());
    echo $this->getResponse();
  }

}
