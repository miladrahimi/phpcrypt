<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;

/**
 * Class Symmetric
 * It encrypts/decrypts data using symmetric key methods
 *
 * @package MiladRahimi\PhpCrypt
 */
class Symmetric
{
    /**
     * @var string
     */
    private $method = 'aes-256-cbc';

    /**
     * @var string
     */
    private $key;

    /**
     * Symmetric constructor.
     * It auto-generates the key if given one is null
     *
     * @param string|null $key
     */
    public function __construct(?string $key = null)
    {
        $this->setKey($key ?: static::generateKey());
    }

    /**
     * Encrypt the given plain data
     *
     * @param string $plain
     * @return string
     * @throws EncryptionException
     */
    public function encrypt(string $plain): string
    {
        $iv = $this->generateIv();

        $encrypted = openssl_encrypt($plain, $this->method, $this->key, 0, $iv);
        if ($encrypted === false) {
            throw new EncryptionException(openssl_error_string());
        }

        return join('.', [base64_encode($iv), base64_encode($encrypted)]);
    }

    /**
     * Decrypt the given encrypted data
     *
     * @param string $data
     * @return string
     * @throws DecryptionException
     */
    public function decrypt(string $data): string
    {
        $parts = explode('.', $data);
        if (count($parts) != 2) {
            throw new DecryptionException('Encrypted data is in invalid format.');
        }

        $iv = base64_decode($parts[0]);
        $encryptedPayload = base64_decode($parts[1]);

        $plain = openssl_decrypt($encryptedPayload, $this->method, $this->key, 0, $iv);
        if ($plain === false) {
            throw new DecryptionException(openssl_error_string());
        }

        return $plain;
    }

    /**
     * Generate a random key
     *
     * @param int $size
     * @return string
     */
    public static function generateKey(int $size = 256): string
    {
        return openssl_random_pseudo_bytes($size / 8);
    }

    /**
     * Generate a random IV
     *
     * @return string
     */
    private function generateIv(): string
    {
        return openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    /**
     * Return all the supported cipher methods
     *
     * @return array
     */
    public static function supportedMethods(): array
    {
        return openssl_get_cipher_methods(true);
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string|null $key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @throws MethodNotSupportedException
     */
    public function setMethod(string $method): void
    {
        if (in_array($method, openssl_get_cipher_methods()) == false) {
            throw new MethodNotSupportedException("The $method method is not supported.");
        }

        $this->method = $method;
    }
}
