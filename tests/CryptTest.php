<?php
/**
 * Created by PhpStorm.
 * User: Milad Rahimi <info@miladrahimi.com>
 * Date: 6/22/2017
 * Time: 2:03 PM
 */

namespace MiladRahimi\PhpCrypt\Tests;

require_once "bootstrap.php";

use MiladRahimi\PhpCrypt\Crypt;
use PHPUnit\Framework\TestCase;

class CryptTest extends TestCase
{
    public function test_a_simple_encrypt_decrypt_process()
    {
        $plainText = 'Pink Floyd - The Wall (1971)';

        $crypt = new Crypt();
        $encrypted = $crypt->encrypt($plainText);
        $decrypted = $crypt->decrypt($encrypted);

        $this->assertSame($plainText, $decrypted);
    }

    public function test_encrypt_decrypt_with_custom_key()
    {
        $plainText = 'Pink Floyd - The Wall (1971)';
        $key = 'This is a secret key!';

        $crypt = new Crypt($key);
        $encrypted = $crypt->encrypt($plainText);
        $decrypted = $crypt->decrypt($encrypted);

        $this->assertSame($plainText, $decrypted);
    }

    public function test_encrypt_decrypt_with_custom_method()
    {
        $plainText = 'Pink Floyd - The Wall (1971)';
        $method = 'AES-192-CBC';

        $crypt = new Crypt(null, $method);
        $encrypted = $crypt->encrypt($plainText);
        $decrypted = $crypt->decrypt($encrypted);

        $this->assertSame($plainText, $decrypted);
    }

    public function test_encrypt_decrypt_with_custom_method_and_custom_key()
    {
        $plainText = 'Pink Floyd - The Wall (1971)';
        $method = 'AES-192-CBC';
        $key = 'This is a secret key!';

        $crypt = new Crypt($key, $method);
        $encrypted = $crypt->encrypt($plainText);
        $decrypted = $crypt->decrypt($encrypted);

        $this->assertSame($plainText, $decrypted);
    }

    public function test_encrypt_decrypt_empty_plain_text()
    {
        $plainText = '';

        $crypt = new Crypt();
        $encrypted = $crypt->encrypt($plainText);
        $decrypted = $crypt->decrypt($encrypted);

        $this->assertSame($plainText, $decrypted);
    }

    public function test_encrypt_decrypt_with_empty_key()
    {
        $plainText = 'Pink Floyd - The Wall (1971)';
        $key = '';

        $crypt = new Crypt($key);
        $encrypted = $crypt->encrypt($plainText);
        $decrypted = $crypt->decrypt($encrypted);

        $this->assertSame($plainText, $decrypted);
    }

    /**
     * @expectedException \MiladRahimi\PhpCrypt\Exceptions\CipherMethodNotSupportedException
     */
    public function test_attempting_to_encrypt_decrypt_with_an_invalid_method()
    {
        new Crypt(null, 'INVALID-SHIT');
    }

    /**
     * @expectedException \MiladRahimi\PhpCrypt\Exceptions\DecryptionException
     */
    public function test_attempting_to_decrypt_an_invalid_text()
    {
        $crypt = new Crypt();
        $crypt->decrypt('INVALID-SHIT');
    }
}
