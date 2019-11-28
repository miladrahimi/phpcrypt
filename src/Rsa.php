<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Base64\Base64Parser;
use MiladRahimi\PhpCrypt\Base64\SafeBase64Parser;
use MiladRahimi\PhpCrypt\Exceptions\EncryptionException;
use MiladRahimi\PhpCrypt\Exceptions\InvalidKeyException;

class Rsa
{
    /**
     * @var string
     */
    private $publicKey;

    /**
     * @var string
     */
    private $privateKey;

    /**
     * @var Base64Parser
     */
    private $base64Parser;

    /**
     * Rsa constructor.
     *
     * @param string $privateKey
     * @param string $publicKey
     * @param Base64Parser|null $base64Parser
     * @throws InvalidKeyException
     */
    public function __construct(string $privateKey, string $publicKey, Base64Parser $base64Parser = null)
    {
        $this->setPrivateKey($privateKey);
        $this->setPublicKey($publicKey);
        $this->setBase64Parser($base64Parser ?: new SafeBase64Parser());
    }

    /**
     * Encrypt the given plain data
     *
     * @param string $data
     * @return string
     * @throws EncryptionException
     */
    public function encryptWithPrivate(string $data): string
    {
        $encrypted = '';
        if (openssl_private_encrypt($data, $encrypted, $this->privateKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $encrypted;
    }

    /**
     * Encrypt the given plain data
     *
     * @param string $data
     * @return string
     * @throws EncryptionException
     */
    public function encryptWithPublic(string $data): string
    {
        $encrypted = '';
        if (openssl_public_encrypt($data, $encrypted, $this->publicKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $encrypted;
    }

    /**
     * Decrypt the given plain data
     *
     * @param string $data
     * @return string
     * @throws EncryptionException
     */
    public function decryptWithPublic(string $data): string
    {
        $decrypted = '';
        if (openssl_public_decrypt($data, $decrypted, $this->publicKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $decrypted;
    }

    /**
     * Decrypt the given plain data
     *
     * @param string $data
     * @return string
     * @throws EncryptionException
     */
    public function decryptWithPrivate(string $data): string
    {
        $decrypted = '';
        if (openssl_private_decrypt($data, $decrypted, $this->privateKey) == false) {
            throw new EncryptionException(openssl_error_string());
        }

        return $decrypted;
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
     * @param string $publicKey
     * @throws InvalidKeyException
     */
    public function setPublicKey(string $publicKey): void
    {
        if (file_exists($publicKey)) {
            if (is_readable($publicKey)) {
                $this->publicKey = openssl_pkey_get_public(file_get_contents($publicKey));
                if ($this->publicKey === false) {
                    throw new InvalidKeyException(openssl_error_string());
                }
            } else {
                throw new InvalidKeyException('The public key file is not readable.');
            }
        } else {
            throw new InvalidKeyException('The public key file is not found.');
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
            if (is_readable($privateKey)) {
                $this->privateKey = openssl_pkey_get_private(file_get_contents($privateKey), $passphrase);
                if ($this->privateKey === false) {
                    throw new InvalidKeyException(openssl_error_string());
                }
            } else {
                throw new InvalidKeyException('The private key file is not readable.');
            }
        } else {
            throw new InvalidKeyException('The private key file is not found.');
        }
    }
}
