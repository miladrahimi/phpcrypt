# PhpCrypt
Free PHP cryptography tools for neat and powerful projects!

## Documentation

### Overview
PhpCrypt is a lightweight package for encrypting, decrypting, hashing and verifying data.
It uses PHP MCrypt extension and crypt based on your project security key.
You can provide a key for it, or a random key will be generated for you.


### Installation

#### Using Composer (Recommended)

Read
[How to use composer in php projects](http://miladrahimi.com/blog/2015/04/12/how-to-use-composer-in-php-projects)
article if you are not familiar with [Composer](http://getcomposer.org).

Run following command in your project root directory:

```
composer require miladrahimi/phpcrypt
```

#### Manually

You may use your own autoloader as long as it follows [PSR-0](http://www.php-fig.org/psr/psr-0) or
[PSR-4](http://www.php-fig.org/psr/psr-4) standards.
Just put `src` directory contents in your vendor directory.

### Getting Started

It's so easy to work with PhpCrypt! Just take a look at following example:

```
use MiladRahimi\PhpCrypt\Crypt;

$crypt = new Crypt();
echo $crypt->encrypt("This is an important content!");
```

### Encryption

The `encrypt()` method encrypts data. See following example.

```
use MiladRahimi\PhpCrypt\Crypt;

$crypt = new Crypt();
echo $crypt->encrypt("This is an important content!");
```

The output is something like:

```
aqxDpuiyuGbOI2JKz9krhUEzrbEPk9zmjcPXhMAx72EfBBjWOxhscwXRaL7OOjg5GDUxdanOQtmjbjtMZ2sP4Q==
```

* Encrypted data will be encoded via base64 algorithm to be maintainable easily anywhere.
* PhpCrypt generates a key automatically when you don't set it.

### Decryption

The `decrypt()` method decrypts data. See following example.

```
use MiladRahimi\PhpCrypt\Crypt;

$crypt = new Crypt();
$r = $crypt->encrypt("This is an important content!");
echo $crypt->decrypt($r);
```

The output is like:

```
This is an important content!
```

*   Don't forget you must set the same key when you have encrypted the data.

### Key

PhpCrypt uses key to encrypt and decrypt data.
You can pass this key to `Crypt` instances or it generates a random one.
To get the generated key, you can call `getKey()` method.
To set your project key, you can call `setKey()` method.

You must keep the key and use it for whole the project lifetime.

Following example shows how to set the security key:

```
use MiladRahimi\PhpCrypt\Crypt;

$crypt = new Crypt();
$crypt->setKey(" THIS IS THE SECRET KEY ");
$r = $crypt->encrypt("This is the content!");
echo $crypt->decrypt($r);
```

*   Default cipher is `rijndael-256` and supported key sizes (lengths) are 16, 24 and 32 bytes (characters).

### Ciphers

Cyphers are algorithms to encrypt data.
PHP MCrypt extension supports multi ciphers and modes.
In default, PhpCrypt uses `rijndael-256` cipher and `cbc` mode.
To see all supported ciphers you can call following method:

```
$crypt->supportedCipherAlgorithms();
```

To see all supported modes call this method:

```
$crypt->supportedCipherModes();
```

Size (length) of the key you must pass to `Crypt` instances depends on cipher.
If you don't know the supported key lengths for the selected cipher you can use following method:

```
$crypt->supportedKeySizes();
```

*   Call this method after setting cipher name.

To set your desired cipher, use following method:

```
$crypt->setCipherAlgorithm(MCRYPT_TRIPLEDES);
```

*   The default cipher is `MCRYPT_RIJNDAEL_256`.

To set your desired mode, use following method:

```
$crypt->setCipherMode(MCRYPT_MODE_CFB);
```

*   The default cipher mode is `MCRYPT_MODE_CBC`.

### Hashing

PhpCrypt provides easiest way to hash and verify password or any other content.
See following example:

```
use MiladRahimi\PhpCrypt\Password;

$hashed_password = HashGenerator::make("s3cr3t");
```

### Verifying

Once you hashed data (a password), you may need to verify it next times.

It's so easy and following examples illustrates how to verify use password:

```
use MiladRahimi\PhpCrypt\Password;

$r = HashGenerator::verify($user_input_password, $stored_hashed_password);
if($r) {
    // Sign in...
    echo "Signed in successfully!";
} else {
    echo "The password you entered is wrong";
}
```

### Framework Integration
You can install the package using Composer.
While all of modern PHP frameworks supports Composer packages,
you can use it in the most of popular frameworks easily.

## License
This package is released under the [MIT License](http://opensource.org/licenses/mit-license.php).
