<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/22/2017
 * Time: 2:03 PM
 */

namespace MiladRahimi\PhpCrypt\Tests;

require_once "bootstrap.php";

use MiladRahimi\PhpCrypt\HashGenerator;
use PHPUnit\Framework\TestCase;

class HashGeneratorTest extends TestCase
{
    public function test_a_simple_hashing_and_verifying()
    {
        $plainText = 'Dariush Eghbali - Dastaye To';

        $hashGenerator = new HashGenerator();
        $hashedText = $hashGenerator->make($plainText);
        $verification = $hashGenerator->verify($plainText, $hashedText);

        $this->assertTrue($verification);
    }

    public function test_a_simple_hashing_and_verifying_with_empty_plain_text()
    {
        $plainText = '';

        $hashGenerator = new HashGenerator();
        $hashedText = $hashGenerator->make($plainText);
        $verification = $hashGenerator->verify($plainText, $hashedText);

        $this->assertTrue($verification);
    }
}
