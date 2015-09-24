<?php namespace MiladRahimi\PHPCrypt;

use MiladRahimi\PHPCrypt\Exceptions\InvalidArgumentException;
use MiladRahimi\PHPCrypt\Exceptions\MCryptNotInstalledException;

/**
 * Interface Hash
 * Interface for hash and verify hashed data
 *
 * @package MiladRahimi\PHPRouter
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
interface HashInterface {

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
    public static function make($password);

    /**
     * Verify password
     *
     * @param string $raw_password    User input password
     * @param string $hashed_password Stored and hashed password
     *
     * @return bool result
     */
    public static function verify($raw_password, $hashed_password);

}