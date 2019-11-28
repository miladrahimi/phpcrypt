<?php

namespace MiladRahimi\PhpCrypt\Tests;

use MiladRahimi\PhpCrypt\Exceptions\HashingException;
use MiladRahimi\PhpCrypt\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    /**
     * @throws HashingException
     */
    public function test_make_and_verify_secret_hash()
    {
        $hash = new Hash();
        $hashed = $hash->make('secret');
        $this->assertTrue($hash->verify('secret', $hashed));
    }

    /**
     * @throws HashingException
     */
    public function test_make_and_verify_a_random_hash()
    {
        $plain = md5(mt_rand(1, 999999));

        $hash = new Hash();
        $hashed = $hash->make($plain);
        $this->assertTrue($hash->verify($plain, $hashed));
    }
}
