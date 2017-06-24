<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/24/2017
 * Time: 9:31 PM
 */

namespace MiladRahimi\PhpCrypt;

class Hash
{
    /** @var HashGeneratorInterface $generator */
    private static $generator = null;

    /**
     * Init
     */
    private static function init()
    {
        if (self::$generator == null) {
            self::$generator = new HashGenerator();
        }
    }

    /**
     * Hash input
     *
     * @param string $plainText
     * @return string
     */
    public static function make($plainText)
    {
        self::init();

        return self::$generator->make($plainText);
    }

    /**
     * Verify input
     *
     * @param string $plainText
     * @param string $hashedText
     * @return bool result
     */
    public static function verify($plainText, $hashedText)
    {
        self::init();

        return self::$generator->verify($plainText, $hashedText);
    }
}