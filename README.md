[![Latest Stable Version](https://poser.pugx.org/miladrahimi/phpcrypt/v/stable)](https://packagist.org/packages/miladrahimi/phpcrypt)
[![Total Downloads](https://poser.pugx.org/miladrahimi/phpcrypt/downloads)](https://packagist.org/packages/miladrahimi/phpcrypt)
[![Build Status](https://travis-ci.org/miladrahimi/phpcrypt.svg?branch=master)](https://travis-ci.org/miladrahimi/phpcrypt)
[![Coverage Status](https://coveralls.io/repos/github/miladrahimi/phpcrypt/badge.svg?branch=master)](https://coveralls.io/github/miladrahimi/phpcrypt?branch=master)
[![License](https://poser.pugx.org/miladrahimi/phpcrypt/license)](https://packagist.org/packages/miladrahimi/phpcrypt)

# PhpCrypt

PhpCrypt is a package for encryption, decryption, and password hashing in PHP projects. It provides an easy-to-use and fluent interface.

Features:
* Symmetric encryption/decryption using AES and other symmetric methods.
* Asymmetric encryption/decryption using the RSA method.
* Hashing and verifying passwords using the BCrypt method.

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

## Symmetric Encryption

This example shows how to encrypt and decrypt data using symmetric algorithms like AES.

```php
use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
$encryptedData = $symmetric->encrypt('secret');
echo $symmetric->decrypt($encryptedData); // secret
```

It generates a random key and uses `aes-256-cbc` as the method for encrypting/decrypting.

### Custom Key

If you have already a key, you can use it this way:

```php
use MiladRahimi\PhpCrypt\Symmetric;

$key = '1234567890123456';
$symmetric = new Symmetric($key);
// ...
```

And if you want to generate a key:

```
$key = Symmetric::generateKey();
```

### Custom method

In default, The `Symmetric` class uses `aes-256-cbc` method. You can change it to your preferred method this way:

```php
use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

try {
    $symmetric = new Symmetric('YOUR-KEY', 'aria-256-ctr');
    // ...
} catch (MethodNotSupportedException $e) {
    // You method is not supported.
}
```

If you still like to have an auto-generated key for your custom method, pass null for the first argument.

```php
use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

try {
    $symmetric = new Symmetric(null, 'aria-256-ctr');
    // ...
} catch (MethodNotSupportedException $e) {
    // You method is not supported.
}
```

### Supported Methods

If you want to know which methods are currently supported by your installed OpenSSL extension, see the snippet below:

```php
use MiladRahimi\PhpCrypt\Symmetric;

print_r(Symmetric::supportedMethods());
```

## RSA Encryption

The examples below illustrates how to encrypt/decrypt data using the RSA algorithm.

### Encryption with private

In this example, we encrypt with a private key and decrypt with the related public key.

```php
use MiladRahimi\PhpCrypt\Rsa;

$rsa = new Rsa('./private_key.pem', './public_key.pem');

$result = $rsa->encryptWithPrivate('secret');
echo $rsa->decryptWithPublic($result); // secret
```

### Encryption with public

In this example, we encrypt with a public key and decrypt with the related private key.

```php
use MiladRahimi\PhpCrypt\Rsa;

$rsa = new Rsa('./private_key.pem', './public_key.pem');

$result = $rsa->encryptWithPublic('secret');
echo $rsa->decryptWithPrivate($result); // secret
```

## Hashing

This example shows how to hash data and verify it.

```php
use MiladRahimi\PhpCrypt\Hash;

$hash = new Hash();

$hashedPassword = $hash->make('MyPassword');
echo $hash->verify('MyPassword', $hashedPassword); // true
echo $hash->verify('AnotherPassword', $hashedPassword); // false
```

## Error Handling

The `symmetric` and `RSA` classes may throw these exceptions:

* `EncryptionException`: When it cannot encrypt.
* `DecryptionException`: When it cannot decrypt.
* `HashingException`: When it cannot hash.
* `MethodNotSupportedException`: When the passed method to the `Symmetric` class is not supported.
* `InvalidKeyException`: When the passed key to `RSA` class is not valid.



