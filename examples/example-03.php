<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
$key = $symmetric->generateKey();

echo bin2hex($key);
