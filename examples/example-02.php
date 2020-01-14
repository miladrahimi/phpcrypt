<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Symmetric;

$key = '1234567890123456';
$symmetric = new Symmetric($key);

$result = $symmetric->encrypt('secret');
echo $symmetric->decrypt($result); // secret
