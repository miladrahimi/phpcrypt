<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\HashingException;

/**
 * Class Hash
 * It hashes and verifies hashed data (e.g. passwords).
 *
 * @package MiladRahimi\PhpCrypt
 */
class Hash
{
    /**
     * Make a hash from the given plain data
     *
     * @param string $plain
     * @return string
     * @throws HashingException
     */
    public function make(string $plain): string
    {
        $result = password_hash($plain, PASSWORD_BCRYPT);
        if ($result === false) {
            throw new HashingException();
        }

        return $result;
    }

    /**
     * Verify the given plain with the given hashed value
     *
     * @param string $plain
     * @param string $hashed
     * @return bool
     */
    public function verify(string $plain, string $hashed): bool
    {
        return password_verify($plain, $hashed);
    }
}
