<?php namespace MiladRahimi\PHPCrypt;

/**
 * Interface CryptInterface
 *
 * @package MiladRahimi\PHPRouter
 * @author Milad Rahimi <info@miladrahimi.com>
 */
interface CryptInterface
{

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