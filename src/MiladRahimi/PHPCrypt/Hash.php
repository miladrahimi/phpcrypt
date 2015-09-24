<?php namespace MiladRahimi\PHPCrypt;

use MiladRahimi\PHPCrypt\Exceptions\InvalidArgumentException;
use MiladRahimi\PHPCrypt\Exceptions\MCryptNotInstalledException;

/**
 * Class Hash
 * Hash class hashes and verifies hashed data.
 * It uses some features of MCrypt library.
 *
 * @package MiladRahimi\PHPRouter
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
class Hash implements HashInterface {

    /**
     * Hash password
     *
     * @param string $password Hash to hash
     *
     * @return string Hashed password
     *
     * @throws InvalidArgumentException
     * @throws MCryptNotInstalledException
     */
    public static function make($password) {
        if (!function_exists("mcrypt_encrypt")) {
            throw new MCryptNotInstalledException;
        }
        if (!isset($password) || !is_scalar($password)) {
            throw new InvalidArgumentException("Hash must be a string/scalar value");
        }
        return $hash = crypt($password, '$2a$07$' . md5(mcrypt_create_iv(32)));
    }

    /**
     * Verify password
     *
     * @param string $raw_password    User input password
     * @param string $hashed_password Stored and hashed password
     *
     * @return bool result
     */
    public static function verify($raw_password, $hashed_password) {
        return crypt($raw_password, $hashed_password) == $hashed_password;
    }
}