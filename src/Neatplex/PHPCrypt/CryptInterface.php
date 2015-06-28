<?php namespace Neatplex\PHPCrypt;

/**
 * Interface CryptInterface
 *
 * CryptInterface define "encrypt()" and "decrypt()" APIs.
 * The "encrypt()" API must encrypt the given content.
 * The "decrypt()" API must decrypt the given content.
 *
 * @package Neatplex\PHPRouter
 *
 * @author Milad Rahimi <info@miladrahimi.com>
 */
interface CryptInterface {

    /**
     * Encrypt the given content
     *
     * @param string $content
     * @return string
     */
    function encrypt($content);

    /**
     * Decrypt the given content
     *
     * @param string $content
     * @return string
     */
    function decrypt($content);

}