<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
$encryptedData = $symmetric->encrypt('secret');
echo $symmetric->decrypt($encryptedData); // secret
