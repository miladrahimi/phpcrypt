# PHPCrypt
Free PHP cryptography tools for neat and powerful projects!

## Documentation
PHPCrypt is a tiny package for encrypting and decrypting data.
It uses PHP MCrypt extension.
It is used to in [Neatplex](http://neatplex.com) packages.


### Installation
#### Using Composer
It's strongly recommended to use [Composer](http://getcomposer.org).
If you are not familiar with Composer, The article
[How to use composer in php projects](http://www.miladrahimi.com/blog/2015/04/12/how-to-use-composer-in-php-projects)
can be useful.
After installing Composer, go to your project directory and run following command there:
```
php composer.phar require neatplex/phpcrypt
```
Or if you have `composer.json` file already in your application,
you may add this package to your application requirements
and update your dependencies:
```
"require": {
    "neatplex/phpcrypt": "~1.0"
}
```
```
php composer.phar update
```
#### Using VendorLoader
If you don't use Composer you may use [VendorLoader](https://github.com/miladrahimi/vendorloader).
Copy `src` directory content in your application vendor directory,
then include the `vendorloader.php` in your application.
#### Manually
You can use your own autoloader as long as it follows [PSR-0](http://www.php-fig.org/psr/psr-0) or
[PSR-4](http://www.php-fig.org/psr/psr-4) standards.
In this case you can put `src` directory content in your vendor directory.

### Getting Started
It's so easy to work with!
```
use Neatplex\PHPCrypt\Crypt;
$crypt = new Crypt();
echo $crypt->encrypt("This is the content!");
```

### Encryption
The `encrypt()` method encrypts data. See following example.
```
use Neatplex\PHPCrypt\Crypt;
$crypt = new Crypt();
echo $crypt->encrypt("This is the content!");
```
It prints something like:
```
aqxDpuiyuGbOI2JKz9krhUEzrbEPk9zmjcPXhMAx72EfBBjWOxhscwXRaL7OOjg5GDUxdanOQtmjbjtMZ2sP4Q==
```

### Decryption
The `decrypt()` method decrypts data. See following example.
```
use Neatplex\PHPCrypt\Crypt;

$crypt = new Crypt();
$r = $crypt->encrypt("This is the content!");
echo $crypt->decrypt($r);
```
It prints the content (`This is the content!`).

### Key
PHPCrypt uses key to encrypt and decrypt data.
You can pass this key to `Crypt` instances or it generates a random one.
To get the generated key, you can call `getKey()` method.
To set your application key, you can call `setKey()` method.
You should hold the application key in the project and use it whenever you use PHPCrypt APIs.
```
use Neatplex\PHPCrypt\Crypt;

$crypt = new Crypt();
$crypt->setKey(" THIS IS THE SECRET KEY ");
$r = $crypt->encrypt("This is the content!");
echo $crypt->decrypt($r);
```
*   Default cipher is `rijndael-256` and supported key sizes are 16, 24 and 32 bytes.

### Ciphers
PHP MCrypt extension supports multi ciphers and modes.
In default, PHPCrypt uses `rijndael-256` cipher and `cbc` mode.
To see all supported ciphers you can call following method:
```
$crypt->supportedCipherNames();
```
To see all supported modes call this method:
```
$crypt->supportedCipherModes();
```
Size of the key you must pass to `Crypt` instances depends on cipher.
If you don't know which sizes the selected cipher supports you can use following method:
```
$crypt->supportedKeySizes();
```
*   Call method above after setting cipher name.

You can set another cipher with following method:
```
$crypt->setCipherName(MCRYPT_TRIPLEDES);
```
*   The default cipher is `MCRYPT_RIJNDAEL_256`.

You can set another cipher mode with following method:
```
$crypt->setCipherMode(MCRYPT_MODE_CFB);
```
*   The default cipher mode is `MCRYPT_MODE_CBC`.

### PHPCryptException
There are some situation which PHPCryptException will be thrown.
Here are methods and messages:
*   `Unsupported key size` in `setKey()` when the given key size is not supported by selected cipher.
*   `Unsupported cipher name` in `setCipherName()` when the given cipher is not supported by current MCrypt version.
*   `Unsupported cipher mode` in `setCipherMode()` when the given mode is not supported by current MCrypt version.

## Contributor
*	[Milad Rahimi](http://miladrahimi.com)

## Official homepage
*   [PHPSession](http://phpsession.neatplex.com) (Soon!)

## License
PHPSession is created by [Neatplex](http://neatplex.com)
and released under the [MIT License](http://opensource.org/licenses/mit-license.php).
