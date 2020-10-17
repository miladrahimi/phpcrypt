<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;

/**
 * Class PublicRsa
 * It encrypts/decrypt data using RSA method and a public key
 *
 * @package MiladRahimi\PhpCrypt
 */
class PublicRsa
{
    /**
     * @var resource
     */
    private $key;

    /**
     * PublicRsa constructor.
     *
     * @param string $key The public key file path or content
     * @throws InvalidKeyException
     */
    public function __construct(string $key)
    {
        $this->setKey($key);
    }

    /**
     * Encrypt the given plain data
     * It uses a public key to encrypt the plain data.
     * The encrypted data will be decrypted only with the related private key.
     *
     * @param string $plain
     * @param bool $base64
     * @return string
     * @throws EncryptionException
     */
    public function encrypt(string $plain, bool $base64 = true): string
    {
        $encrypted = '';
        if (openssl_public_encrypt($plain, $encrypted, $this->key) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $base64 ? base64_encode($encrypted) : $encrypted;
    }

    /**
     * Decrypt the given encrypted data
     * It uses the public key to decrypt the given encrypted data.
     *
     * @param string $data
     * @param bool $base64
     * @return string
     * @throws DecryptionException
     */
    public function decrypt(string $data, bool $base64 = true): string
    {
        $data = $base64 ? base64_decode($data) : $data;

        $decrypted = '';
        if (openssl_public_decrypt($data, $decrypted, $this->key) == false) {
            throw new DecryptionException(openssl_error_string());
        }

        return $decrypted;
    }

    /**
     * @param string $key The key file path or content
     * @throws InvalidKeyException
     */
    public function setKey(string $key): void
    {
        if (file_exists($key)) {
            if (!is_readable($key) || !($key = file_get_contents($key))) {
                throw new InvalidKeyException('The key file is not readable.');
            }
        }

        $this->key = openssl_pkey_get_public($key);
        if ($this->key === false) {
            throw new InvalidKeyException(openssl_error_string());
        }
    }
}
