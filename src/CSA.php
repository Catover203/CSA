<?php
/*----------------------------------------*/
// @name: CSA                             //
// @author: Catover203                    //
// @version: 1.0                          //
/*----------------------------------------*/
namespace Catover203\Crypto;
class CSA{
	function __construct($secret = 2068, $key = ['encrypt_key' => 'Default_KEY','encrypt_key_num' => 500]){
		if(file_exists('csa.config.php')){
			require('csa.config.php');
			$this->secret_number = $CSA['config']['secret'];
			$this->secret_item = $CSA['config']['secret_item'];
			if(!isset($this->secret_number)){
				$this->error('start CSA construct', 'missing secret number');
			}
		}else{
			if(!empty($secret)){
				$this->secret_number = $secret;
				$this->secret_item = $key;
			}elseif(!empty($secret)){
				$this->error('start CSA construct', 'missing secret number');
			}
		}
	}
	function private_key_to_public_key($private_key){
		$secret_number = $this->secret_number;
		if(!empty($private_key)){
			$key = explode('-', $this->decrypt_key(base64_decode($private_key)));
			$keysize = count($key);
			$cipher = "";
			for($i = 0; $i < $keysize; $i++){
				$cipher .= '-'.($key[$i] ^ $secret_number);
			}
			return base64_encode($this->encrypt_key(substr($cipher,1)));
		}else{
			return false;
			$this->error('turn private key to public key', 'missing private key');
		}
	}
	 function decrypt($text, $private_key) {
		$secret_number = $this->secret_number;
		if(!empty($private_key)){
			$key = explode('-',$this->decrypt_key(base64_decode($private_key)));
			$text = $this->text2ascii($text);
			$keysize = count($key);
			$text_size = count($text);
			$x1 = "";
			for ($i = 0; $i < $text_size; $i++){
				$x1 .= chr($text[$i] - ($key[$i] ^ $secret_number));
			}
			return $x1;
		}else{
			return false;
			$this->error('decrypt','missing private key');
		}
	}
	 function encrypt($text, $public_key){
		$secret_number = $this->secret_number;
		if(!empty($public_key)){
			$alt_key = $this->decrypt_key(base64_decode($public_key));
			$key = explode('-', $alt_key);
			$text = $this->text2ascii($text);
			$keysize = count($key);
			$text_size = count($text);
			$cipher = "";
			for($i = 0; $i < $text_size; $i++){
				$cipher .= chr($text[$i] + $key[$i]);
			}
			return $cipher;
		}else{
			return false;
			$this->error('encrypt', 'missing public key');
		}
	 }
	 function create_private_key($bit = 2048){
		if(in_array($bit, array(512, 1024, 2048, 4056, 8112, 16224))){
			$key = '';
			for($x = 0; $x < $bit; $x++){
				$key .= '-'.rand(0, 9);
			}
			$key = substr($key,1);
			return base64_encode($this->encrypt_key($key));
		}else{
			return false;
			$this->error('Create private key', 'invalid bit length');
		}
	}
	private function encrypt_key($plaintext) {
		$secret = $this->secret_item;
		$key = $this->text2ascii($plaintext);
		$keysize = count($key);
		$cipher = "";
		for ($i = 0; $i < $keysize; $i++)
	    $cipher .= chr($key[$i] + $secret['encrypt_key_num']);
		return $cipher;
    }
    private function decrypt_key($plaintext) {
		$secret = $this->secret_item;
		$key = $this->text2ascii($plaintext);
		$keysize = count($key);
		$cipher = "";
		for ($i = 0; $i < $keysize; $i++)
	    $cipher .= chr($key[$i] - $secret['encrypt_key_num']);
		return $cipher;
    }
	private function text2ascii($text){
		return array_map('ord', str_split($text));
	}
	private function ascii2text($ascii) {
		$text = "";
		foreach($ascii as $char){
			$text .= chr($char);
		}
		return $text;
	}
	private function error($name, $reason){
		echo "<br><b>CSA Error:</b> Could not ".$name.", ".$reason." in <b>".$_SERVER['DOCUMENT_ROOT'].substr($_SERVER['SCRIPT_NAME'],1)."</b>.";
	}
}
?>
