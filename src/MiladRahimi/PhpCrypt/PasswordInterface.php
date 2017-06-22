<?php namespace MiladRahimi\PhpCrypt;

/**
 * Interface Password
 *
 * @package MiladRahimi\PHPRouter
 * @author Milad Rahimi <info@miladrahimi.com>
 */
interface PasswordInterface
{

    /**
     * Hash password
     *
     * @param string $password : Password to hash
     * @return string : Hashed password
     * @throws InvalidArgumentException
     * @throws PhpCryptException
     */
    public static function hash($password);

    /**
     * Verify password
     *
     * @param string $raw_password : User input password
     * @param string $hashed_password : Stored and hashed password
     * @return bool : result
     */
    public static function verify($raw_password, $hashed_password);

}