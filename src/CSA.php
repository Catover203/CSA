<?php
namespace Catover203\Crypto;
class CSA{
	function __construct($number_1st = 900, $number_2nd = 700){
		if(!empty($number_1st) and !empty($number_2nd)){
			$this->num1st = $number_1st;
			$this->num2nd = $number_2nd;
		}elseif(empty($number_1st) and empty($number_2nd) and (($number_1st - $number_2nd) >= 200)){
			$this->error('start CSA construct', 'missing fist or last number');
		}elseif(!(($number_1st - $number_2nd) >= 200)){
			$this->error('start CSA construct', 'fist_number - last_number >= 200');
		}
	}
	function private_key_to_public_key($private_key){
		$number_1st = $this->num1st;
		$number_2nd = $this->num2nd;
		if(!empty($private_key)){
			$key = $this->text2ascii(base64_decode($private_key));
			$keysize = count($key);
			$cipher = "";
			for($i = 0; $i < $keysize; $i++){
				$cipher .= chr(258 ^ ($key[$i % $keysize] % $number_1st));
			}
			return base64_encode($cipher);
		}else{
			return false;
			$this->error('turn private key to public key', 'missing private key');
		}
	}
	 function decrypt($text, $private_key) {
		$number_1st = $this->num1st;
		$number_2nd = $this->num2nd;
		if(!empty($private_key)){
			$key = $this->text2ascii(base64_decode($private_key));
			$text = $this->text2ascii($text);
			$keysize = count($key);
			$text_size = count($text);
			$x1 = "";
			for ($i = 0; $i < $text_size; $i++){
				$x1 .= chr($text[$i] ^ (258 ^ ($key[$i % $keysize] % $number_2nd)));
			}
			$text = $this->text2ascii($x1);
			$text_size = count($text);
			$cipher = "";
			for($i = 0; $i < $text_size; $i++){
				$cipher .= chr($text[$i] ^ (258 ^ ($key[$i % $keysize] / $number_2nd)));
			}
			return $cipher;
		}else{
			return false;
			$this->error('decrypt');
		}
	}
	 function encrypt($text, $public_key){
		$number_1st = $this->num1st;
		$number_2nd = $this->num2nd;
		if(!empty($public_key)){
			$key = $this->text2ascii(base64_decode($public_key));
			$text = $this->text2ascii($text);
			$keysize = count($key);
			$text_size = count($text);
			$cipher = "";
			for($i = 0; $i < $text_size; $i++){
				$cipher .= chr($text[$i] ^ (258 ^ ($key[$i % $keysize] % $number_1st)));
			}
			return $cipher;
		}else{
			return false;
			$this->error('encrypt');
		}
	 }
	 function create_prvivate_key($bit = 2048){
		$number_1st = $this->num1st;
		$number_2nd = $this->num2nd;
		if(in_array($bit, array(512, 1024, 2048, 4056, 8112, 16224))){
			for($x = 0; $x < $bit; $x++){
				$key .= rand(0, 9);
			}
			$key = $this->text2ascii($key);
			$keysize = count($key);
			$cipher = "";
			for($i = 0; $i < $keysize; $i++){
				$cipher .= chr(258 ^ ($key[$i % $keysize] % $number_2nd));
			}
			return base64_encode($cipher);
		}else{
			return false;
			$this->error('Create private key', 'invalid bit length');
		}
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
		echo "<b>CSA Error:</b> Could not ".$name.", ".$reason." in <b>".$_SERVER['DOCUMENT_ROOT'].substr($_SERVER['SCRIPT_NAME'],1)."</b>.";
	}
}
?>
