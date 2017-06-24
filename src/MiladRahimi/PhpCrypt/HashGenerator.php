<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/23/2017
 * Time: 12:26 AM
 */

namespace MiladRahimi\PhpCrypt;

class HashGenerator implements HashGeneratorInterface
{
    /**
     * Hash input
     *
     * @param string $plainText
     * @return string
     */
    public function make($plainText)
    {
        $salt = md5(openssl_random_pseudo_bytes(16));
        return $hash = crypt($plainText, '$2a$07$' . $salt);
    }

    /**
     * Verify input
     *
     * @param string $plainText User input password
     * @param string $hashedText Stored and hashed password
     *
     * @return bool result
     */
    public function verify($plainText, $hashedText)
    {
        return crypt($plainText, $hashedText) == $hashedText;
    }
}