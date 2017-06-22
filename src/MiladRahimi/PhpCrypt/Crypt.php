<?php namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\InvalidArgumentException;
use MiladRahimi\PhpCrypt\Exceptions\MCryptNotInstalledException;
use MiladRahimi\PhpCrypt\Exceptions\UnsupportedCipherException;
use MiladRahimi\PhpCrypt\Exceptions\UnsupportedCipherModeException;
use MiladRahimi\PhpCrypt\Exceptions\UnsupportedKeySizeException;

/**
 * Class Crypt
 * Crypt class encrypts and decrypts contents using PHP native MCrypt package.
 *
 * @package MiladRahimi\PHPRouter
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
class Crypt implements CryptInterface {

    /**
     * Crypt KEY
     *
     * @var string
     */
    private $key;

    /**
     * Cipher Algorithm
     *
     * @var int
     */
    private $cipher_algorithm;

    /**
     * @var int
     */
    private $cipher_mode;

    /**
     * Constructor
     *
     * @param string|null $key Cryptography key (salt)
     *
     * @throws MCryptNotInstalledException
     */
    public function __construct($key = null) {
        if (!function_exists("mcrypt_encrypt")) {
            throw new MCryptNotInstalledException;
        }
        if (!is_null($key) && !is_scalar($key)) {
            throw new InvalidArgumentException("Key must be a string value");
        }
        $this->cipher_algorithm = MCRYPT_RIJNDAEL_256;
        $this->cipher_mode      = MCRYPT_MODE_CBC;
        $this->setKey((is_null($key) ? md5(mcrypt_create_iv(32)) : $key));
    }

    /**
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @throws InvalidArgumentException
     */
    public function setKey($key) {
        if (!isset($key) || !is_string($key)) {
            throw new InvalidArgumentException("Key must be a string value");
        }
        $this->key = $key;
    }

    /**
     * Encrypt data
     *
     * @param string $content Content to encrypt
     *
     * @return string Encrypted content
     *
     * @throws UnsupportedCipherException
     * @throws UnsupportedCipherModeException
     * @throws UnsupportedKeySizeException
     *
     * @see http://goo.gl/ENz2sJ
     */
    function encrypt($content) {
        if (!isset($content) || !is_scalar($content)) {
            throw new InvalidArgumentException("Content must be a scalar value");
        }
        if (!in_array(strlen($this->key), mcrypt_module_get_supported_key_sizes($this->cipher_algorithm))) {
            throw new UnsupportedKeySizeException;
        }
        if (!in_array($this->cipher_algorithm, mcrypt_list_algorithms())) {
            throw new UnsupportedCipherException;
        }
        if (!in_array($this->cipher_mode, mcrypt_list_modes())) {
            throw new UnsupportedCipherModeException;
        }
        $iv_size = mcrypt_get_iv_size($this->cipher_algorithm, $this->cipher_mode);
        $iv      = mcrypt_create_iv($iv_size);
        $r       = mcrypt_encrypt($this->cipher_algorithm, $this->key, $content, $this->cipher_mode, $iv);
        return base64_encode($iv . $r);
    }

    /**
     * Decrypt Data
     *
     * @param string $content
     *
     * @return bool|string
     *
     * @throws UnsupportedCipherException
     * @throws UnsupportedCipherModeException
     * @throws UnsupportedKeySizeException
     *
     * @see http://goo.gl/ENz2sJ
     */
    function decrypt($content) {
        if (!isset($content) || !is_scalar($content)) {
            throw new InvalidArgumentException("Content must be a scalar value");
        }
        if (!in_array(strlen($this->key), mcrypt_module_get_supported_key_sizes($this->cipher_algorithm))) {
            throw new UnsupportedKeySizeException;
        }
        if (!in_array($this->cipher_algorithm, mcrypt_list_algorithms())) {
            throw new UnsupportedCipherException;
        }
        if (!in_array($this->cipher_mode, mcrypt_list_modes())) {
            throw new UnsupportedCipherModeException;
        }
        $content = base64_decode($content);
        $iv_size = mcrypt_get_iv_size($this->cipher_algorithm, $this->cipher_mode);
        $iv      = substr($content, 0, $iv_size);
        $ec      = substr($content, $iv_size);
        return mcrypt_decrypt($this->cipher_algorithm, $this->key, $ec, $this->cipher_mode, $iv);
    }

    /**
     * @return int
     */
    public function getCipherAlgorithm() {
        return $this->cipher_algorithm;
    }

    /**
     * @param int $cipher_algorithm
     *
     * @throws InvalidArgumentException
     */
    public function setCipherAlgorithm($cipher_algorithm) {
        if (!isset($cipher_algorithm) || !is_scalar($cipher_algorithm)) {
            throw new InvalidArgumentException("Cipher algorithm must be an int value");
        }
        $this->cipher_algorithm = $cipher_algorithm;
    }

    /**
     * @return int
     */
    public function getCipherMode() {
        return $this->cipher_mode;
    }

    /**
     * @param int $cipher_mode
     *
     * @throws InvalidArgumentException
     */
    public function setCipherMode($cipher_mode) {
        if (!isset($cipher_mode) || !is_string($cipher_mode)) {
            throw new InvalidArgumentException("Cipher type must be a string value");
        }
        $this->cipher_algorithm = $cipher_mode;
    }

    /**
     * Return all supported key sizes for current cipher
     *
     * @return array
     */
    public function supportedKeySizes() {
        return mcrypt_module_get_supported_key_sizes($this->cipher_algorithm);
    }

    /**
     * Return all supported ciphers
     *
     * @return array
     */
    public function supportedCipherAlgorithms() {
        return mcrypt_list_algorithms();
    }

    /**
     * Return all supported cipher modes
     *
     * @return array
     */
    public function supportedCipherModes() {
        return mcrypt_list_modes();
    }

}