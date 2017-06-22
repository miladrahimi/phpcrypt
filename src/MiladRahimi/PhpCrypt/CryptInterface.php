<?php namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\UnsupportedCipherException;
use MiladRahimi\PhpCrypt\Exceptions\CipherMethodNotSupportedException;
use MiladRahimi\PhpCrypt\Exceptions\UnsupportedKeySizeException;

/**
 * Interface CryptInterface
 * Interface for encrypt and decrypt data
 *
 * @package MiladRahimi\PhpCrypt
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
interface CryptInterface {

    /**
     * Encrypt data
     *
     * @param string $plainText Content to encrypt
     *
     * @return string Encrypted content
     *
     * @throws UnsupportedCipherException
     * @throws CipherMethodNotSupportedException
     * @throws UnsupportedKeySizeException
     */
    function encrypt($plainText);

    /**
     * Decrypt Data
     *
     * @param string $ecryptedText
     *
     * @return bool|string
     *
     * @throws UnsupportedCipherException
     * @throws CipherMethodNotSupportedException
     * @throws UnsupportedKeySizeException
     */
    function decrypt($ecryptedText);

}