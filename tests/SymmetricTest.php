<?php

namespace MiladRahimi\PhpCrypt\Tests;

error_reporting(E_ERROR | E_PARSE);

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
     */
    public function test_encrypting_and_decrypting_without_key()
    {
        $symmetric = new Symmetric();
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    /**
     * @throws DecryptionException
     * @throws EncryptionException
     */
    public function test_encrypting_and_decrypting_with_a_given_key()
    {
        $symmetric = new Symmetric();
        $symmetric->setKey(Symmetric::generateKey());
        $result = $symmetric->encrypt('secret');

        $this->assertEquals('secret', $symmetric->decrypt($result));
    }

    /**
     * @throws DecryptionException
     */
    public function test_decrypting_an_invalid_cipher_it_should_fail()
    {
        $symmetric = new Symmetric();

        $this->expectException(DecryptionException::class);
        $this->expectExceptionMessage('Encrypted data is in invalid format.');
        $symmetric->decrypt('Invalid Encrypted Data!');
    }

    /**
     * @throws DecryptionException
     */
    public function test_decrypting_another_invalid_cipher_it_should_fail()
    {
        $symmetric = new Symmetric();

        $this->expectException(DecryptionException::class);
        $symmetric->decrypt('WRONG-IV.WRONG-DATE');
    }

    public function test_supportedMethods()
    {
        $methods = Symmetric::supportedMethods();
        $this->assertIsArray($methods);
    }

    public function test_setting_and_getting_a_key()
    {
        $symmetric = new Symmetric();

        $symmetric->setKey('key');
        $this->assertEquals('key', $symmetric->getKey());
    }

    /**
     * @throws MethodNotSupportedException
     */
    public function test_setting_and_getting_a_method()
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
