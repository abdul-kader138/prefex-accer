<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

include 'GoogleAuthenticator/PHPGangsta/GoogleAuthenticator.php';
class QRAuthenticator {
    private $google_authenticator;
    private $secret;
    private $qrCodeURL;
    private $code;

    public function __construct() {
      $this->ci =& get_instance();
      $this->google_authenticator = new PHPGangsta_GoogleAuthenticator();
    }
    public function createSecret() {
      $this->secret = $this->google_authenticator->createSecret();
      return $this->secret;
    }

    public function getURL($sercret_key = null, $title = 'CRMS') {
    	if($this->google_authenticator != null && $sercret_key != null) {
    		$this->qrCodeURL = $this->google_authenticator->getQRCodeGoogleUrl($title, $sercret_key);
    	}
    	return $this->qrCodeURL;
    }

    public function getCode() {
      if($this->google_authenticator != null && $this->secret != null) {
        $this->code = $this->google_authenticator->getCode($this->secret);
      }
      return $this->code;
    }

    public function verifyCode($sercret_key = null, $code_for_verify = null) {
      if($code_for_verify != null && $this->google_authenticator != null && $sercret_key != null) {
        return $this->google_authenticator->verifyCode($sercret_key, $code_for_verify, 2);
      }
      return false;
    }
}

?>