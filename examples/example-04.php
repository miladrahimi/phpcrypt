<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

$key = '1234567890123456';

try {
    $symmetric = new Symmetric($key, 'aria-256-ctr');
} catch (MethodNotSupportedException $e) {
    // You method is not supported.
}

$result = $symmetric->encrypt('secret');
echo $symmetric->decrypt($result); // secret
