<?php

if (is_array($aParams)) {
  $aParams[0] = 'phs_cod_' . $aParams[0];
  include_once "addCode.php";
}