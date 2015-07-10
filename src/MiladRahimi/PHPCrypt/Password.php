<?php namespace MiladRahimi\PHPCrypt;

/**
 * Class Password
 *
 * Password class is used to work with passwords
 * It uses some features of MCrypt library.
 *
 * @package MiladRahimi\PHPRouter
 *
 * @author Milad Rahimi <info@miladrahimi.com>
 */
class Password implements PasswordInterface
{

    /**
     * Hash password
     *
     * @param $password
     * @return string
     * @throws InvalidArgumentException
     * @throws PHPCryptException
     */
    public static function hash($password)
    {
        if (!function_exists("mcrypt_encrypt"))
            throw new PHPCryptException("MCrypt is not installed");
        if (!isset($password) && is_scalar($password) || method_exists($password, "__toString"))
            throw new InvalidArgumentException("Password must be a string/scalar value");
        return $hash = crypt($password, '$2a$07$' . md5(mcrypt_create_iv(32)));
    }

    /**
     * Verify password
     *
     * @param string $password
     * @param $hashed_password
     * @return string
     */
    public static function verify($password, $hashed_password)
    {
        return crypt($password, $hashed_password) == $hashed_password;
    }
}