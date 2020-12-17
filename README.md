# CSA
<div align="center"><img alt="CSA" src="https://github.com/Catover203/CSA/raw/main/CSA.png" width="500" height="250"></div>


![Build status](https://travis-ci.org/php/php-src.svg?branch=master)

CSA a catover203-secure-algorithm

When i finding how RSA encrypted and I found something.

There are how I making own public/private key encrypt/decrypt

## Use
 There a example to you.
 
 Create private key
```php
<?php
require('CSA.php');
use Catover203\Crypto\CSA;
$csa = new CSA;
$bit = 2048;
$private_key = $csa->create_prvivate_key($bit);
echo 'Private key is: '.$private_key;
?>
```

 Create public key

 ```php
<?php
require('CSA.php');
use Catover203\Crypto\CSA;
$csa = new CSA;
$bit = 2048;
$private_key = $csa->create_prvivate_key($bit);
$public_key = $csa->private_key_to_public_key($private_key);
echo 'Public key is: '.$public_key;
?>
```
Encrypt
```php
<?php
require('CSA.php');
use Catover203\Crypto\CSA;
$csa = new CSA;
$bit = 2048;
$private_key = $csa->create_prvivate_key($bit);
$public_key = $csa->private_key_to_public_key($private_key);
$encrypt = $csa->encrypt('Hi', $public_key);
echo 'Encrypted data: Hi -> '.$encrypt;
?>
```

Decrypt
```php
<?php
require('CSA.php');
use Catover203\Crypto\CSA;
$csa = new CSA;
$bit = 2048;
$private_key = $csa->create_prvivate_key($bit);
$public_key = $csa->private_key_to_public_key($private_key);
$encrypt = $csa->encrypt('Hi', $public_key);
$decrypt = $csa->decrypt('Hi', $private_key);
echo 'Decrypted data: '.$encrypt.' => '.$decrypt;
?>
```
