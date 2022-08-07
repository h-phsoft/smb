<?php

/**
 * Description of PhsRestVase
 * RESTful web services base class
 * Version 1.0.1
 *
 * @author Haytham
 */
class PhsRestBase {
  /*
    public const RESPONSE_TYPE_JSON = 0;
    public const RESPONSE_TYPE_XML = 1;
    public const RESPONSE_TYPE_HTML = 2;
   */

  private $aContentType = array(
    0 => 'application/json; charset=UTF-8',
    1 => 'application/xml; charset=UTF-8',
    2 => 'application/html; charset=UTF-8'
  );
  private $httpVersion = "HTTP/1.1";
  private $httpStatusCode = '404';
  private $httpStatusMessage = 'Not Found';
  private $aHttpStatus = array(
    100 => 'Continue',
    101 => 'Switching Protocols',
    200 => 'OK',
    201 => 'Created',
    202 => 'Accepted',
    203 => 'Non-Authoritative Information',
    204 => 'No Content',
    205 => 'Reset Content',
    206 => 'Partial Content',
    300 => 'Multiple Choices',
    301 => 'Moved Permanently',
    302 => 'Found',
    303 => 'See Other',
    304 => 'Not Modified',
    305 => 'Use Proxy',
    306 => '(Unused)',
    307 => 'Temporary Redirect',
    400 => 'Bad Request',
    401 => 'Unauthorized',
    402 => 'Payment Required',
    403 => 'Forbidden',
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    406 => 'Not Acceptable',
    407 => 'Proxy Authentication Required',
    408 => 'Request Timeout',
    409 => 'Conflict',
    410 => 'Gone',
    411 => 'Length Required',
    412 => 'Precondition Failed',
    413 => 'Request Entity Too Large',
    414 => 'Request-URI Too Long',
    415 => 'Unsupported Media Type',
    416 => 'Requested Range Not Satisfiable',
    417 => 'Expectation Failed',
    500 => 'Internal Server Error',
    501 => 'Not Implemented',
    502 => 'Bad Gateway',
    503 => 'Service Unavailable',
    504 => 'Gateway Timeout',
    505 => 'HTTP Version Not Supported'
  );

  public function getHttpVersion() {
    return $this->httpVersion;
  }

  public function setHttpVersion($httpVersion) {
    $this->httpVersion = $httpVersion;
  }

  public function getHttpStatusCode() {
    return $this->httpStatusCode;
  }

  public function setHttpStatus($statusCode) {
    $this->httpStatusCode = $statusCode;
    $this->httpStatusMessage = ($this->aHttpStatus[$statusCode]) ? $this->aHttpStatus[$statusCode] : $this->aHttpStatus[404];
  }

  public function getHttpStatusMessage() {
    return $this->httpStatusMessage;
  }

  public function getHttpStatusCodeMessage($statusCode) {
    return ($this->aHttpStatus[$statusCode]) ? $this->aHttpStatus[$statusCode] : $this->aHttpStatus[404];
  }

  public function setHttpHeaders($statusCode) {
    $this->setHttpStatus($statusCode);
    header($this->httpVersion . " " . $statusCode . " " . $this->httpStatusMessage);
    header("Content-Type:" . $this->getContentType());
  }

  public function getContentType($contentType = 0) {
    return ($this->aContentType[$contentType] ? $this->aContentType[$contentType] : $this->aContentType[0]);
  }

  public function encodeHtml($aResponseData) {

    $htmlResponse = "<table border='1'>";
    foreach ($aResponseData as $key => $value) {
      $htmlResponse .= "<tr><td>" . $key . "</td><td>" . $value . "</td></tr>";
    }
    $htmlResponse .= "</table>";
    return $htmlResponse;
  }

  public function encodeJson($aResponseData) {
    $jsonResponse = json_encode($aResponseData);
    return $jsonResponse;
  }

  public function encodeXml($aResponseData) {
// creating object of SimpleXMLElement
    $xml = new SimpleXMLElement('<?xml version="1.0"?><webservice></webservice>');
    foreach ($aResponseData as $key => $value) {
      $xml->addChild($key, $value);
    }
    return $xml->asXML();
  }

  public static function statusMessage($statusCode) {
    $restBase = new PhsRestBase();
    return ($restBase->getHttpStatusMessage($statusCode));
  }

}
