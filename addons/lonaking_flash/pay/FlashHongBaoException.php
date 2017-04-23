<?php
/*
 __________________________________________________
|  Encode by BajieTeam on we7                      |
|__________________________________________________|
*/
 class FlashHongBaoException extends Exception { private $error_message; private $error_code; public function __construct($error_message, $error_code) { goto XPFr5; pmhor: $this->message = $error_message; goto kYDQw; RRFih: $this->error_code = $error_code; goto pmhor; kYDQw: $this->code = $error_code; goto RBrzd; XPFr5: $this->error_message = $error_message; goto RRFih; RBrzd: } public function getErrorCode() { return $this->error_code; } public function setErrorCode($error_code) { $this->error_code = $error_code; } public function getErrorMessage() { return $this->error_message; } public function setErrorMessage($error_message) { $this->error_message = $error_message; } }
