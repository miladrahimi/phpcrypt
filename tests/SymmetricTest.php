<?php

namespace MiladRahimi\PhpCrypt\Tests;

use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Symmetric;
use PHPUnit\Framework\TestCase;

class SymmetricTest extends TestCase
{
    /**
     * @throws DecryptionException
     * @throws EncryptionException
     * @throws MethodNotSupportedException
     */
    public function test_encrypt_and_decrypt_without_key()
    {
        $symmetric = new Symmetric(null);
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    /**
     * @throws DecryptionException
     * @throws EncryptionException
     * @throws MethodNotSupportedException
     */
    public function test_encrypt_and_decrypt_with_custom_key()
    {
        $symmetric = new Symmetric();
        $symmetric->setKey(Symmetric::generateKey());
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    /**
     * @throws DecryptionException
     * @throws MethodNotSupportedException
     */
    public function test_decrypt_with_invalid_data_it_should_fail()
    {
        $symmetric = new Symmetric();

        $this->expectException(DecryptionException::class);
        $this->expectExceptionMessage('Encrypted data is in invalid format.');
        $symmetric->decrypt('Invalid Encrypted Data!');
    }

    public function test_supportedMethods()
    {
        $methods = Symmetric::supportedMethods();
        $this->assertIsArray($methods);
    }

    public function test_set_and_get_key()
    {
        $symmetric = new Symmetric();

        $symmetric->setKey('key');
        $this->assertEquals('key', $symmetric->getKey());
    }

    /**
     * @throws MethodNotSupportedException
     */
    public function test_set_and_get_method()
    {
        $symmetric = new Symmetric();

        $method = $symmetric->supportedMethods()[0];
        $symmetric->setMethod($method);
        $this->assertEquals($method, $symmetric->getMethod());
    }

    /**
     * @throws MethodNotSupportedException
     */
    public function test_setting_an_invalid_method_it_should_fail()
    {
        $symmetric = new Symmetric();
        $this->expectException(MethodNotSupportedException::class);
        $this->expectExceptionMessageRegExp('/^The (.+?) method is not supported.$/');
        $symmetric->setMethod('Invalid Method');
    }
}
