<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/23/2017
 * Time: 12:26 AM
 */

namespace MiladRahimi\PhpCrypt;

use MiladRahimi\PhpCrypt\Exceptions\InvalidArgumentException;
use MiladRahimi\PhpCrypt\Exceptions\OpenSSLNotInstalledException;

interface HashGeneratorInterface
{
    /**
     * Hash input
     *
     * @param string $plainText
     * @return string
     */
    public function make($plainText);

    /**
     * Verify input
     *
     * @param string $plainText
     * @param string $hashedText
     * @return bool result
     */
    public function verify($plainText, $hashedText);

}