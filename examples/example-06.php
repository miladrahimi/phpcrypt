<?php

require('../vendor/autoload.php');

use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
print_r($symmetric->supportedMethods());
