<?php namespace MiladRahimi\PHPCrypt;

use MiladRahimi\PHPCrypt\Exceptions\UnsupportedCipherException;
use MiladRahimi\PHPCrypt\Exceptions\UnsupportedCipherModeException;
use MiladRahimi\PHPCrypt\Exceptions\UnsupportedKeySizeException;

/**
 * Interface CryptInterface
 * Interface for encrypt and decrypt data
 *
 * @package MiladRahimi\PHPCrypt
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
interface CryptInterface {

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
     */
    function encrypt($content);

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
     */
    function decrypt($content);

}