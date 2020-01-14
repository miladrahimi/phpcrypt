<?php

namespace MiladRahimi\PhpCrypt\Tests;

use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;
use MiladRahimi\PhpCrypt\Rsa;
use PHPUnit\Framework\TestCase;

class RsaTest extends TestCase
{
    /**
     * @return Rsa
     * @throws InvalidKeyException
     */
    private function rsa(): Rsa
    {
        return new Rsa(
            __DIR__ . '/../resources/test_private_key.pem',
            __DIR__ . '/../resources/test_public_key.pem'
        );
    }

    /**
     * @throws InvalidKeyException
     * @throws EncryptionException
     */
    public function test_encrypt_with_private_key()
    {
        $rsa = $this->rsa();
        $encrypted = $rsa->encryptWithPrivate('secret');
        $this->assertEquals('secret', $rsa->decryptWithPublic($encrypted));
    }

    /**
     * @throws InvalidKeyException
     * @throws EncryptionException
     */
    public function test_encrypt_with_private_key_and_base64_off()
    {
        $rsa = $this->rsa();
        $encrypted = $rsa->encryptWithPrivate('secret', false);
        $this->assertEquals('secret', $rsa->decryptWithPublic($encrypted, false));
    }

    /**
     * @throws InvalidKeyException
     * @throws EncryptionException
     */
    public function test_encrypt_with_public_key()
    {
        $rsa = $this->rsa();
        $encrypted = $rsa->encryptWithPublic('secret');
        $this->assertEquals('secret', $rsa->decryptWithPrivate($encrypted));
    }

    /**
     * @throws DecryptionException
     * @throws InvalidKeyException
     */
    public function test_decrypt_with_public_key_it_should_fail()
    {
        $rsa = $this->rsa();
        $this->expectException(DecryptionException::class);
        $this->assertEquals('secret', $rsa->decryptWithPublic('WRONG-CIPHER'));
    }

    /**
     * @throws DecryptionException
     * @throws InvalidKeyException
     */
    public function test_decrypt_with_private_key_it_should_fail()
    {
        $rsa = $this->rsa();
        $this->expectException(DecryptionException::class);
        $this->assertEquals('secret', $rsa->decryptWithPrivate('WRONG-CIPHER'));
    }

    /**
     * @throws EncryptionException
     * @throws InvalidKeyException
     * @throws DecryptionException
     */
    public function test_encrypt_with_public_key_and_base64_off()
    {
        $rsa = $this->rsa();
        $encrypted = $rsa->encryptWithPublic('secret', false);
        $this->assertEquals('secret', $rsa->decryptWithPrivate($encrypted, false));
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_set_and_get_public_key()
    {
        $key = file_get_contents(__DIR__ . '/../resources/test_public_key.pem');

        $rsa = $this->rsa();
        $rsa->setPublicKey($key);

        $this->assertTrue(true);
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_set_and_get_private_key()
    {
        $key = file_get_contents(__DIR__ . '/../resources/test_private_key.pem');

        $rsa = $this->rsa();
        $rsa->setPrivateKey($key);

        $this->assertTrue(true);
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_set_and_get_invalid_public_key_it_should_fail()
    {
        $rsa = $this->rsa();
        $this->expectException(InvalidKeyException::class);
        $rsa->setPublicKey('invalid.pem');
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_set_and_get_invalid_private_key_it_should_fail()
    {
        $rsa = $this->rsa();
        $this->expectException(InvalidKeyException::class);
        $rsa->setPrivateKey('invalid.pem');
    }
}