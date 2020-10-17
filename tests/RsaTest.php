<?php

namespace MiladRahimi\PhpCrypt\Tests;

use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;
use MiladRahimi\PhpCrypt\PrivateRsa;
use MiladRahimi\PhpCrypt\PublicRsa;
use PHPUnit\Framework\TestCase;

class RsaTest extends TestCase
{
    /**
     * @var PrivateRsa
     */
    protected $private;

    /**
     * @var PublicRsa
     */
    protected $public;

    /**
     * @throws InvalidKeyException
     */
    public function setUp()
    {
        parent::setUp();

        $this->private = new PrivateRsa(__DIR__ . '/resources/test_private_key.pem');
        $this->public = new PublicRsa(__DIR__ . '/resources/test_public_key.pem');
    }

    /**
     * @throws DecryptionException
     * @throws EncryptionException
     */
    public function test_encrypting_with_the_private_key()
    {
        $encrypted = $this->private->encrypt('secret');
        $this->assertEquals('secret', $this->public->decrypt($encrypted));
    }

    /**
     * @throws DecryptionException
     * @throws EncryptionException
     */
    public function test_encrypting_with_the_private_key_and_base64_off()
    {
        $encrypted = $this->private->encrypt('secret', false);
        $this->assertEquals('secret', $this->public->decrypt($encrypted, false));
    }

    /**
     * @throws DecryptionException
     * @throws EncryptionException
     */
    public function test_encrypting_with_the_public_key()
    {
        $encrypted = $this->public->encrypt('secret');
        $this->assertEquals('secret', $this->private->decrypt($encrypted));
    }

    /**
     * @throws DecryptionException
     * @throws EncryptionException
     */
    public function test_encrypting_with_the_public_key_and_base64_off()
    {
        $encrypted = $this->public->encrypt('secret', false);
        $this->assertEquals('secret', $this->private->decrypt($encrypted, false));
    }

    /**
     * @throws DecryptionException
     */
    public function test_decrypting_an_invalid_cipher_with_the_public_key_it_should_fail()
    {
        $this->expectException(DecryptionException::class);
        $this->assertEquals('secret', $this->public->decrypt('INVALID-CIPHER'));
    }

    /**
     * @throws DecryptionException
     */
    public function test_decrypting_an_invalid_cipher_with_the_private_key_it_should_fail()
    {
        $this->expectException(DecryptionException::class);
        $this->assertEquals('secret', $this->private->decrypt('INVALID-CIPHER'));
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_setting_a_public_key()
    {
        $key = file_get_contents(__DIR__ . '/resources/test_public_key.pem');
        $this->public->setKey($key);
        $this->assertTrue(true);
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_setting_a_private_key()
    {
        $key = file_get_contents(__DIR__ . '/resources/test_private_key.pem');
        $this->private->setKey($key);
        $this->assertTrue(true);
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_setting_an_invalid_public_key_file_it_should_fail()
    {
        $this->expectException(InvalidKeyException::class);
        $this->public->setKey('invalid.pem');
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_setting_an_invalid_public_key_path_it_should_fail()
    {
        $this->expectException(InvalidKeyException::class);
        $this->expectExceptionMessage('The key file is not readable.');
        $this->public->setKey('..');
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_setting_an_invalid_private_key_file_it_should_fail()
    {
        $this->expectException(InvalidKeyException::class);
        $this->private->setKey('invalid.pem');
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_setting_an_invalid_private_key_path_it_should_fail()
    {
        $this->expectException(InvalidKeyException::class);
        $this->expectExceptionMessage('The key file is not readable.');
        $this->private->setKey('..');
    }
}