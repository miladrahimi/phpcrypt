<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Base64\Base64Parser;
use MiladRahimi\PhpCrypt\Base64\SafeBase64Parser;
use MiladRahimi\PhpCrypt\Exceptions\CipherMethodNotSupportedException;
use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;

class Symmetric
{
    /**
     * @var string
     */
    private $method = 'aes-256-cbc';

    /**
     * @var string
     */
    private $iv;

    /**
     * @var string
     */
    private $key;

    /**
     * @var int
     */
    private $options = 0;

    /**
     * @var Base64Parser
     */
    private $base64Parser;

    /**
     * Symmetric constructor.
     *
     * @param Base64Parser|null $base64Parser
     */
    public function __construct(Base64Parser $base64Parser = null)
    {
        $this->setBase64Parser($base64Parser ?: new SafeBase64Parser());
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
        $this->prepare();

        $encrypted = openssl_encrypt($plain, $this->method, $this->key, $this->options, $this->iv);
        if ($encrypted === false) {
            throw new EncryptionException(openssl_error_string());
        }

        return join(':', [
            $this->base64Parser->encode($this->iv),
            $this->base64Parser->encode($encrypted),
        ]);
    }

    /**
     * Decrypt the given encrypted data
     *
     * @param string $encryptedData
     * @return string
     * @throws DecryptionException
     * @throws InvalidKeyException
     */
    public function decrypt(string $encryptedData): string
    {
        if (empty($this->key)) {
            throw new InvalidKeyException('The key is not set.');
        }

        $parts = explode(':', $encryptedData);
        if (count($parts) != 2) {
            throw new DecryptionException('Encrypted data is in invalid format.');
        }

        $iv = $this->base64Parser->decode($parts[0]);
        $encryptedPayload = $this->base64Parser->decode($parts[1]);

        $plain = openssl_decrypt($encryptedPayload, $this->method, $this->key, $this->options, $iv);
        if ($plain === false) {
            throw new DecryptionException(openssl_error_string());
        }

        return $plain;
    }

    /**
     * Generate a random key
     *
     * @return string
     */
    public function generateKey(): string
    {
        return $this->key = bin2hex(openssl_random_pseudo_bytes(32));
    }

    /**
     * Generate a random key
     *
     * @return string
     */
    public function generateIv(): string
    {
        return $this->iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->method));
    }

    /**
     * Return all supported cipher methods
     *
     * @return array
     */
    public function supportedMethods(): array
    {
        return openssl_get_cipher_methods(true);
    }

    /**
     * Initialize the key and iv if not set
     */
    private function prepare(): void
    {
        if (empty($this->key)) {
            $this->key = $this->generateKey();
        }

        if (empty($this->iv)) {
            $this->iv = $this->generateIv();
        }
    }

    /**
     * @return string|null
     */
    public function getIv(): ?string
    {
        return $this->iv;
    }

    /**
     * @param string $iv
     */
    public function setIv(string $iv): void
    {
        $this->iv = $iv;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return Base64Parser
     */
    public function getBase64Parser(): Base64Parser
    {
        return $this->base64Parser;
    }

    /**
     * @param Base64Parser $base64Parser
     */
    public function setBase64Parser(Base64Parser $base64Parser): void
    {
        $this->base64Parser = $base64Parser;
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
     * @throws CipherMethodNotSupportedException
     */
    public function setMethod(string $method): void
    {
        if (in_array($method, openssl_get_cipher_methods()) == false) {
            throw new CipherMethodNotSupportedException();
        }

        $this->method = $method;
    }

    /**
     * @return int
     */
    public function getOptions(): int
    {
        return $this->options;
    }

    /**
     * @param int $options
     */
    public function setOptions(int $options)
    {
        $this->options = $options;
    }
}
