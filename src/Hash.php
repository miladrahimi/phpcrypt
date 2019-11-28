<?php

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\HashingException;

class Hash
{
    /**
     * @var int
     */
    private $algorithm = PASSWORD_BCRYPT;

    /**
     * Make a hash from the given password
     *
     * @param string $password
     * @return string
     * @throws HashingException
     */
    public function make(string $password): string
    {
        $result = password_hash($password, $this->algorithm);
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
    public function verify(string $plainPassword, string $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
