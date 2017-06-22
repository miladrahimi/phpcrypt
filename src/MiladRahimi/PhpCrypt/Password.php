<?php namespace MiladRahimi\PhpCrypt;

/**
 * Class Password
 * Password class hashes and verifies hashed passwords.
 * It uses some features of MCrypt library.
 *
 * @package MiladRahimi\PHPRouter
 * @author Milad Rahimi <info@miladrahimi.com>
 */
class Password implements PasswordInterface
{

    /**
     * Hash password
     *
     * @param string $password : Password to hash
     * @return string : Hashed password
     * @throws InvalidArgumentException
     * @throws PhpCryptException
     */
    public static function hash($password)
    {
        if (!function_exists("mcrypt_encrypt"))
            throw new PhpCryptException("MCrypt is not installed");
        if (!isset($password) || !is_scalar($password))
            throw new InvalidArgumentException("Password must be a string/scalar value");
        return $hash = crypt($password, '$2a$07$' . md5(mcrypt_create_iv(32)));
    }

    /**
     * Verify password
     *
     * @param string $raw_password : User input password
     * @param string $hashed_password : Stored and hashed password
     * @return bool : result
     */
    public static function verify($raw_password, $hashed_password)
    {
        return crypt($raw_password, $hashed_password) == $hashed_password;
    }
}