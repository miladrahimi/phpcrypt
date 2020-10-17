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
    public function test_making_a_hash_from_a_secret_and_verifying_it()
    {
        $hash = new Hash();
        $hashed = $hash->make('secret');
        $this->assertTrue($hash->verify('secret', $hashed));
    }

    /**
     * @throws HashingException
     */
    public function test_making_a_hash_from_a_random_string_and_verifying_it()
    {
        $plain = md5(mt_rand(1, 999999));

        $hash = new Hash();
        $hashed = $hash->make($plain);
        $this->assertTrue($hash->verify($plain, $hashed));
    }
}
