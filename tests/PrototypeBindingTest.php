<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/22/2017
 * Time: 2:03 PM
 */

namespace MiladRahimi\PhpCrypt\Tests;

require_once "bootstrap.php";

use DateTime;
use MiladRahimi\PhpContainer\Container;
use PHPUnit\Framework\TestCase;

class PrototypeBindingTest extends TestCase
{
    public function test_binding_a_closure()
    {
        print_r(openssl_get_cipher_methods(true));
    }
}
