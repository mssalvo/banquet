<?php
namespace Banquet\Core;

final class Encryption {
	private $key;
	private $cipher = 'aes-256-cbc';

	public function __construct($key) {
		$this->key = hash('sha256', $key, true);
	}

	public function encrypt($value) {
		$ivLen = openssl_cipher_iv_length($this->cipher);
		$iv = openssl_random_pseudo_bytes($ivLen);
		$encrypted = openssl_encrypt($value, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
		return strtr(base64_encode($iv . $encrypted), '+/=', '-_,');
	}

	public function decrypt($value) {
		$data = base64_decode(strtr($value, '-_,', '+/='));
		$ivLen = openssl_cipher_iv_length($this->cipher);
		$iv = substr($data, 0, $ivLen);
		$encrypted = substr($data, $ivLen);
		return trim(openssl_decrypt($encrypted, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv));
	}
}
?>