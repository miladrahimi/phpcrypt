<?php namespace MiladRahimi\PHPCrypt;

/**
 * Class Crypt
 * Crypt class encrypts and decrypts contents using PHP native MCrypt package.
 *
 * @package MiladRahimi\PHPRouter
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
     * @param string|null $key : Cryptography key (salt)
     * @throws InvalidArgumentException
     * @throws PHPCryptException
     */
    public function __construct($key = null)
    {
        if (!function_exists("mcrypt_encrypt"))
            throw new PHPCryptException("MCrypt is not installed");
        $this->cipher_algorithm = MCRYPT_RIJNDAEL_256;
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
     * @throws InvalidArgumentException
     * @throws PHPCryptException
     */
    public function setKey($key)
    {
        if (!isset($key) || !is_string($key))
            throw new InvalidArgumentException("Key must be a string value");
        if (!in_array(strlen($key), mcrypt_module_get_supported_key_sizes($this->cipher_algorithm)))
            throw new PHPCryptException("Key size is not supported");
        $this->key = $key;
    }

    /**
     * Encrypt data
     *
     * @param string $content : Content to encrypt
     * @return string : Encrypted content
     * @throws InvalidArgumentException
     * @see http://goo.gl/ENz2sJ
     */
    function encrypt($content)
    {
        if (!isset($content) || !is_scalar($content))
            throw new InvalidArgumentException("Content must be a scalar value");
        $iv_size = mcrypt_get_iv_size($this->cipher_algorithm, $this->cipher_mode);
        $iv = mcrypt_create_iv($iv_size);
        $r = mcrypt_encrypt($this->cipher_algorithm, $this->key, $content, $this->cipher_mode, $iv);
        return base64_encode($iv . $r);
    }

    /**
     * Decrypt Data
     *
     * @param string $content
     * @return bool|string
     * @throws InvalidArgumentException
     * @see http://goo.gl/ENz2sJ
     */
    function decrypt($content)
    {
        if (!isset($content) || !is_scalar($content))
            throw new InvalidArgumentException("Content must be a scalar value");
        $content = base64_decode($content);
        $iv_size = mcrypt_get_iv_size($this->cipher_algorithm, $this->cipher_mode);
        $iv = substr($content, 0, $iv_size);
        $ec = substr($content, $iv_size);
        return mcrypt_decrypt($this->cipher_algorithm, $this->key, $ec, $this->cipher_mode, $iv);
    }

    /**
     * @return int
     */
    public function getCipherAlgorithm()
    {
        return $this->cipher_algorithm;
    }

    /**
     * @param int $cipher_algorithm
     * @throws InvalidArgumentException
     * @throws PHPCryptException
     */
    public function setCipherAlgorithm($cipher_algorithm)
    {
        if (!isset($cipher_algorithm) || !is_scalar($cipher_algorithm))
            throw new InvalidArgumentException("Cipher algorithm must be a int value");
        if (!in_array($cipher_algorithm, mcrypt_list_algorithms()))
            throw new PHPCryptException("Unsupported cipher name");
        $this->cipher_algorithm = $cipher_algorithm;
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
     * @throws InvalidArgumentException
     * @throws PHPCryptException
     */
    public function setCipherMode($cipher_mode)
    {
        if (!isset($cipher_mode) || !is_string($cipher_mode))
            throw new InvalidArgumentException("Cipher type must be a string value");
        if (!in_array($cipher_mode, mcrypt_list_modes()))
            throw new PHPCryptException("Unsupported cipher mode");
        $this->cipher_algorithm = $cipher_mode;
    }

    /**
     * Return all supported key sizes for current cipher
     *
     * @return array
     */
    public function supportedKeySizes()
    {
        return mcrypt_module_get_supported_key_sizes($this->cipher_algorithm);
    }

    /**
     * Return all supported ciphers
     *
     * @return array
     */
    public function supportedCipherAlgorithms()
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