<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Rsa;

$rsa = new Rsa(
    __DIR__ . '/../resources/test_private_key.pem',
    __DIR__ . '/../resources/test_public_key.pem'
);

$result = $rsa->encryptWithPrivate('secret');
echo $rsa->decryptWithPublic($result); // secret