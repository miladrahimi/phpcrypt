[![Latest Stable Version](https://poser.pugx.org/miladrahimi/phpcrypt/v/stable)](https://packagist.org/packages/miladrahimi/phpcrypt)
[![Total Downloads](https://poser.pugx.org/miladrahimi/phpcrypt/downloads)](https://packagist.org/packages/miladrahimi/phpcrypt)
[![Build Status](https://travis-ci.org/miladrahimi/phpcrypt.svg?branch=master)](https://travis-ci.org/miladrahimi/phpcrypt)
[![Coverage Status](https://coveralls.io/repos/github/miladrahimi/phpcrypt/badge.svg?branch=master)](https://coveralls.io/github/miladrahimi/phpcrypt?branch=master)
[![License](https://poser.pugx.org/miladrahimi/phpcrypt/license)](https://packagist.org/packages/miladrahimi/phpcrypt)

# PhpCrypt

PhpCrypt is a package for encryption, decryption, and password hashing in PHP projects. It hides complexity and provides an easy-to-use and fluent interface.

Features:
* Symmetric encryption/decryption using AES and other symmetric methods.
* Asymmetric encryption/decryption using the RSA method.
* Hashing and verifying passwords using the Bcrypt method.

## Versions

* **v4.x.x (LTS)**
* v3.x.x (Unsupported)
* v2.x.x (Unsupported)
* v1.x.x (Unsupported)

## Installation

Install [Composer](https://getcomposer.org) and run following command in your project's root directory:

```bash
composer require miladrahimi/phpcrypt "4.*"
```

## Symmetric encryption

Symmetric methods use only one key to both encrypt and decrypt data. To use symmetric methods, take a look at this example:

```php
use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
$result = $symmetric->encrypt('secret');
echo $symmetric->decrypt($result); // Output: secret
```

It generates a random key and selects `aes-256-cbc` as the method for further encryptions/decryptions.

### Custom Key

If you have already a key, you can use it for encryption./decryption this way:

```php
use MiladRahimi\PhpCrypt\Symmetric;

$key = '1234567890123456';
$symmetric = new Symmetric($key);
```

You can generate a new key using `Symmetric` class like this:

```
$key = $symmetric->generateKey();
```

### Custom method

In default, The `Symmetric` class use `aes-256-cbc` as the encryption method. You can pass another method to the class constructor this way:

```php
use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

try {
    $symmetric = new Symmetric('YOUR-KEY', 'aria-256-ctr');
} catch (MethodNotSupportedException $e) {
    // You method is not supported.
}
```

If you still like to have an auto-generated key, pass null as the first argument.

```php
use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

try {
    $symmetric = new Symmetric(null, 'aria-256-ctr');
} catch (MethodNotSupportedException $e) {
    // You method is not supported.
}
```

### Supported Methods

If you want to know which methods are currently supported by your installed OpenSSL extension, see the snippet below:

```
use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
print_r($symmetric->supportedMethods());
```
