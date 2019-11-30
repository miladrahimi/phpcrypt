<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\HashingException;

/**
 * Class Hash
 * It hashes and verifies passwords.
 *
 * @package MiladRahimi\PhpCrypt
 */
class Hash
{
    /**
     * Make a hash from the given password
     *
     * @param string $password
     * @return string
     * @throws HashingException
     */
    public function make(string $password): string
    {
        $result = password_hash($password, PASSWORD_BCRYPT);
        if ($result === false) {
            throw new HashingException();
        }

        return $result;
    }

    /**
     * Verify the given plain password with the given hashed password
     *
     * @param string $plainPassword
     * @param string $hashedPassword
     * @return bool
     */
    public function verify(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
