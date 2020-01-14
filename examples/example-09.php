<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Hash;

$hash = new Hash();

$hashedPassword = $hash->make('MyPassword');
echo $hash->verify('MyPassword', $hashedPassword); // true
echo $hash->verify('AnotherPassword', $hashedPassword); // false