<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/23/2017
 * Time: 12:26 AM
 */

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\DecryptionException;

interface CryptInterface
{
    /**
     * Encrypt text
     *
     * @param string $plainText
     * @return string
     */
    function encrypt($plainText);

    /**
     * Decrypt text
     *
     * @param string $encryptedText
     * @return string
     * @throws DecryptionException
     */
    function decrypt($encryptedText);
}