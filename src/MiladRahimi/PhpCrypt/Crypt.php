<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/23/2017
 * Time: 12:26 AM
 */

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\OpenSSLNotInstalledException;
use MiladRahimi\PhpCrypt\Exceptions\CipherMethodNotSupportedException;

class Crypt implements CryptInterface
{
    /**
     * Crypt key
     *
     * @var string
     */
    private $key;

    /**
     * Crypt Algorithm
     *
     * @var int
     */
    private $method;

    /**
     * Constructor
     *
     * @param string|null $key Cryptography key (salt)
     * @param int $method
     * @throws OpenSSLNotInstalledException
     */
    public function __construct($key = null, $method = OPENSSL_CIPHER_AES_256_CBC)
    {
        if (extension_loaded('openssl') == false) {
            throw new OpenSSLNotInstalledException();
        }

        if ($key == null) {
            $key = self::generateRandomKey();
        }

        $this->setMethod($method);
        $this->setKey($key);
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Encrypt text
     *
     * @param string $plainText
     * @return string Encrypted content
     */
    function encrypt($plainText)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->key));
        $encrypted = openssl_encrypt($plainText, $this->method, $this->key, OPENSSL_RAW_DATA, $iv);
        return $encrypted . ':' . base64_encode($iv);
    }

    /**
     * Decrypt text
     *
     * @param string $encryptedText
     * @return bool|string
     */
    function decrypt($encryptedText)
    {
        $parts = explode(':', $encryptedText);
        $main = $parts[0];
        $iv = base64_decode($parts[1]);
        return openssl_decrypt($main, $this->method, $this->key, OPENSSL_RAW_DATA, $iv);
    }

    /**
     * @return int
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param int $method
     * @throws CipherMethodNotSupportedException
     */
    public function setMethod($method)
    {
        if (in_array($method, openssl_get_cipher_methods()) == false) {
            throw new CipherMethodNotSupportedException();
        }

        $this->method = $method;
    }

    /**
     * Return all supported cipher methods
     *
     * @return array
     */
    public static function methods()
    {
        return openssl_get_cipher_methods(true);
    }

    /**
     * Generate a random key
     *
     * @return string
     */
    public static function generateRandomKey()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }
}