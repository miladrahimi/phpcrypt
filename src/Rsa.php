<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;

/**
 * Class Rsa
 * It encrypts/decrypts data using RSA method
 *
 * @package MiladRahimi\PhpCrypt
 */
class Rsa
{
    /**
     * @var resource
     */
    private $publicKey;

    /**
     * @var resource
     */
    private $privateKey;

    /**
     * Rsa constructor.
     *
     * @param string $privateKey The key file path or content
     * @param string $publicKey The key file path or content
     * @throws InvalidKeyException
     */
    public function __construct(string $privateKey, string $publicKey)
    {
        $this->setPrivateKey($privateKey);
        $this->setPublicKey($publicKey);
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
    public function encryptWithPrivate(string $plain, bool $base64 = true): string
    {
        $encrypted = '';
        if (openssl_private_encrypt($plain, $encrypted, $this->privateKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $base64 ? base64_encode($encrypted) : $encrypted;
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
    public function encryptWithPublic(string $plain, bool $base64 = true): string
    {
        $encrypted = '';
        if (openssl_public_encrypt($plain, $encrypted, $this->publicKey) == false) {
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
     * @throws EncryptionException
     */
    public function decryptWithPublic(string $data, bool $base64 = true): string
    {
        $data = $base64 ? base64_decode($data) : $data;

        $decrypted = '';
        if (openssl_public_decrypt($data, $decrypted, $this->publicKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $decrypted;
    }

    /**
     * Decrypt the given encrypted data
     * It uses the private key to decrypt the given encrypted data.
     *
     * @param string $data
     * @param bool $base64
     * @return string
     * @throws EncryptionException
     */
    public function decryptWithPrivate(string $data, bool $base64 = true): string
    {
        $data = $base64 ? base64_decode($data) : $data;

        $decrypted = '';
        if (openssl_private_decrypt($data, $decrypted, $this->privateKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $decrypted;
    }

    /**
     * @param string $publicKey The key file path or content
     * @throws InvalidKeyException
     */
    public function setPublicKey(string $publicKey): void
    {
        if (file_exists($publicKey)) {
            if (!is_readable($publicKey) || !($publicKey = file_get_contents($publicKey))) {
                throw new InvalidKeyException('The private key file is not readable.');
            }
        }

        $this->publicKey = openssl_pkey_get_public($publicKey);
        if ($this->publicKey === false) {
            throw new InvalidKeyException(openssl_error_string());
        }
    }

    /**
     * @param string $privateKey
     * @param string $passphrase
     * @throws InvalidKeyException
     */
    public function setPrivateKey(string $privateKey, string $passphrase = ''): void
    {
        if (file_exists($privateKey)) {
            if (!is_readable($privateKey) || !($privateKey = file_get_contents($privateKey))) {
                throw new InvalidKeyException('The private key file is not readable.');
            }
        }

        $this->privateKey = openssl_pkey_get_private($privateKey, $passphrase);
        if ($this->privateKey === false) {
            throw new InvalidKeyException(openssl_error_string());
        }
    }
}
