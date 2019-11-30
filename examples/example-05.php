<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

try {
    $symmetric = new Symmetric(null, 'aria-256-ctr');
} catch (MethodNotSupportedException $e) {
    // You method is not supported.
}

$result = $symmetric->encrypt('secret');
echo $symmetric->decrypt($result); // Output: secret
