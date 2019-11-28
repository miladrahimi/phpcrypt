<?php

namespace MiladRahimi\PhpCrypt\Tests;

use MiladRahimi\PhpCrypt\Base64\SafeBase64Parser;
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
    public function test_encrypt_with_public_key()
    {
        $rsa = $this->rsa();
        $encrypted = $rsa->encryptWithPublic('secret');
        $this->assertEquals('secret', $rsa->decryptWithPrivate($encrypted));
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_set_and_get_base64_parser()
    {
        $rsa = $this->rsa();

        $parser = new SafeBase64Parser();
        $rsa->setBase64Parser($parser);
        $this->assertSame($parser, $rsa->getBase64Parser());
    }

    /**
     * @throws InvalidKeyException
     */
    public function test_set_and_get_public_key()
    {
        $rsa = $this->rsa();

        $key = __DIR__ . '/../resources/test_public_key.pem';
        $rsa->setPublicKey($key);

        $this->assertTrue();
    }
}