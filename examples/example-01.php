<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
$result = $symmetric->encrypt('secret');
echo $symmetric->decrypt($result); // Output: secret
