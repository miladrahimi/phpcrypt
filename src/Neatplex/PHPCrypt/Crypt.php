<?php namespace Neatplex\PHPCrypt;

/**
 * Class Crypt
 *
 * Crypt class is the main package class.
 * This class encrypt and decrypt contents based on PHP native MCrypt package.
 *
 * @package Neatplex\PHPRouter
 *
 * @author Milad Rahimi <info@miladrahimi.com>
 */
class Crypt implements CryptInterface
{
    /**
     * Crypt KEY
     *
     * @var string
     */
    private $key = null;

    /**
     * Cipher Type
     *
     * @var int
     */
    private $cipher_name;

    /**
     * @var int
     */
    private $cipher_mode;

    /**
     * Construct
     *
     * @param string|null $key
     */
    public function __construct($key = null)
    {
        $this->cipher_name = MCRYPT_RIJNDAEL_256;
        $this->cipher_mode = MCRYPT_MODE_CBC;
        if (!is_null($key)) {
            $this->setKey($key);
        } else {
            $this->key = md5(microtime() . rand());
        }
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
     *
     * @throws PHPCryptException
     */
    public function setKey($key)
    {
        if (!isset($key) || !is_string($key))
            throw new \InvalidArgumentException("Key must be a string value");
        if (!in_array(strlen($key), mcrypt_module_get_supported_key_sizes($this->cipher_name)))
            throw new PHPCryptException("Unsupported key size");
        $this->key = $key;
    }

    /**
     * Encrypt data
     *
     * @param string $content
     * @return string
     * @throws PHPCryptException
     *
     * @see http://goo.gl/ENz2sJ
     */
    function encrypt($content)
    {
        if (!isset($content) || !is_scalar($content))
            throw new \InvalidArgumentException("Content must be a scalar value");
        $iv_size = mcrypt_get_iv_size($this->cipher_name, $this->cipher_mode);
        $iv = mcrypt_create_iv($iv_size);
        $r = mcrypt_encrypt($this->cipher_name, $this->key, $content, $this->cipher_mode, $iv);
        return base64_encode($iv . $r);
    }

    /**
     * Decrypt Data
     *
     * @param string $content
     * @return bool|string
     * @throws PHPCryptException
     *
     * @see http://goo.gl/ENz2sJ
     */
    function decrypt($content)
    {
        if (!isset($content) || !is_scalar($content))
            throw new \InvalidArgumentException("Content must be a scalar value");
        $content = base64_decode($content);
        $iv_size = mcrypt_get_iv_size($this->cipher_name, $this->cipher_mode);
        $iv = substr($content, 0, $iv_size);
        $ec = substr($content, $iv_size);
        return mcrypt_decrypt($this->cipher_name, $this->key, $ec, $this->cipher_mode, $iv);
    }

    /**
     * @return int
     */
    public function getCipherName()
    {
        return $this->cipher_name;
    }

    /**
     * @param int $cipher_name
     * @throws PHPCryptException
     */
    public function setCipherName($cipher_name)
    {
        if (!isset($cipher_name) || !is_string($cipher_name))
            throw new \InvalidArgumentException("Cipher type must be a string value");
        if (!in_array($cipher_name, mcrypt_list_algorithms()))
            throw new PHPCryptException("Unsupported cipher name");
        $this->cipher_name = $cipher_name;
    }

    /**
     * @return int
     */
    public function getCipherMode()
    {
        return $this->cipher_mode;
    }

    /**
     * @param int $cipher_mode
     * @throws PHPCryptException
     */
    public function setCipherMode($cipher_mode)
    {
        if (!isset($cipher_mode) || !is_string($cipher_mode))
            throw new \InvalidArgumentException("Cipher type must be a string value");
        if (!in_array($cipher_mode, mcrypt_list_modes()))
            throw new PHPCryptException("Unsupported cipher mode");
        $this->cipher_name = $cipher_mode;
    }

    /**
     * Return all supported key sizes for current cipher
     *
     * @return array
     */
    public function supportedKeySizes()
    {
        return mcrypt_module_get_supported_key_sizes($this->cipher_name);
    }

    /**
     * Return all supported ciphers
     *
     * @return array
     */
    public function supportedCipherNames()
    {
        return mcrypt_list_algorithms();
    }

    /**
     * Return all supported cipher modes
     *
     * @return array
     */
    public function supportedCipherModes()
    {
        return mcrypt_list_modes();
    }
}