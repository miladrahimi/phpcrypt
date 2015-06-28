<?php namespace Neatplex\PHPCrypt;

/**
 * Interface Password
 *
 * PasswordInterface define "hash()" and "verify()" APIs.
 * The "hash()" API must hash the given password.
 * The "verify()" API must verify if the given password is hashed of given raw password.
 *
 * @package Neatplex\PHPRouter
 *
 * @author Milad Rahimi <info@miladrahimi.com>
 */
interface PasswordInterface
{

    /**
     * Hash password
     *
     * @param $password
     * @return string
     * @internal param string $content
     */
    public static function hash($password);

    /**
     * Verify password
     *
     * @param string $password
     * @param $hashed_password
     * @return string
     */
    public static function verify($password, $hashed_password);

}