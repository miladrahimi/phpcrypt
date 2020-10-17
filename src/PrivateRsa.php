<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;

/**
 * Class PrivateRsa
 * It encrypts/decrypt data using RSA method and a private key
 *
 * @package MiladRahimi\PhpCrypt
 */
class PrivateRsa
{
    /**
     * @var resource
     */
    private $key;

    /**
     * PrivateRsa constructor.
     *
     * @param string $key The private key file path or content
     * @throws InvalidKeyException
     */
    public function __construct(string $key)
    {
        $this->setKey($key);
    }

    /**
     * Encrypt the given plain data
     * It uses a private key to encrypt the plain data.
     * The encrypted data will be decrypted only with the related public key.
     *
     * @param string $plain
     * @param bool $base64
     * @return string
     * @throws EncryptionException
     */
    public function encrypt(string $plain, bool $base64 = true): string
    {
        $encrypted = '';
        if (openssl_private_encrypt($plain, $encrypted, $this->key) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $base64 ? base64_encode($encrypted) : $encrypted;
    }

    /**
     * Decrypt the given encrypted data
     * It uses the private key to decrypt the given encrypted data.
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
        if (openssl_private_decrypt($data, $decrypted, $this->key) == false) {
            throw new DecryptionException(openssl_error_string());
        }

        return $decrypted;
    }

    /**
     * @param string $key
     * @param string $passphrase
     * @throws InvalidKeyException
     */
    public function setKey(string $key, string $passphrase = ''): void
    {
        if (file_exists($key)) {
            if (!is_readable($key) || !($key = file_get_contents($key))) {
                throw new InvalidKeyException('The key file is not readable.');
            }
        }

        $this->key = openssl_pkey_get_private($key, $passphrase);
        if ($this->key === false) {
            throw new InvalidKeyException(openssl_error_string());
        }
    }
}
