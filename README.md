[![Latest Stable Version](https://poser.pugx.org/miladrahimi/phpcrypt/v/stable)](https://packagist.org/packages/miladrahimi/phpcrypt)
[![Total Downloads](https://poser.pugx.org/miladrahimi/phpcrypt/downloads)](https://packagist.org/packages/miladrahimi/phpcrypt)
[![Build Status](https://travis-ci.org/miladrahimi/phpcrypt.svg?branch=master)](https://travis-ci.org/miladrahimi/phpcrypt)
[![Coverage Status](https://coveralls.io/repos/github/miladrahimi/phpcrypt/badge.svg?branch=master)](https://coveralls.io/github/miladrahimi/phpcrypt?branch=master)
[![License](https://poser.pugx.org/miladrahimi/phpcrypt/license)](https://packagist.org/packages/miladrahimi/phpcrypt)

# PhpCrypt

PhpCrypt is a package for encryption, decryption, and hashing data in PHP projects.
It provides an easy-to-use and fluent interface.

Features:
* Symmetric encryption/decryption using AES and other symmetric methods.
* Asymmetric encryption/decryption using the RSA method.
* Hashing and verifying data (e.g. passwords) using the BCrypt method.

## Versions

* v5.x.x
* v4.x.x
* v3.x.x (Unsupported)
* v2.x.x (Unsupported)
* v1.x.x (Unsupported)

## Installation

Install [Composer](https://getcomposer.org) and run the following command in your project's root directory:

```bash
composer require miladrahimi/phpcrypt "5.*"
```

## Symmetric Encryption

This example shows how to encrypt and decrypt data using symmetric algorithms like AES.

```php
use MiladRahimi\PhpCrypt\Symmetric;

$symmetric = new Symmetric();
$encryptedData = $symmetric->encrypt('secret');
echo $symmetric->decrypt($encryptedData); // secret
```

It generates a random key and uses `aes-256-cbc` method for encrypting/decrypting data.

### Custom Key

If you have already a key, you can use your own key like this:

```php
use MiladRahimi\PhpCrypt\Symmetric;

$key = '1234567890123456';

// Set the key using the constructor
$symmetric = new Symmetric($key);

// Or set the key using the setter
$symmetric = new Symmetric();
$symmetric->setKey($key);

// And get the key using the getter
$myKey = $symmetric->getKey();
```

The method `generateKey` can help you to generate a new random key.
See the snippet below.

```php
use MiladRahimi\PhpCrypt\Symmetric;

$key = Symmetric::generateKey();
```

### Custom Methods

In default, The `Symmetric` class uses `aes-256-cbc` method to encrypt/decrypt data.
You can use your preferred method as well.
See the following example.

```php
use MiladRahimi\PhpCrypt\Exceptions\MethodNotSupportedException;
use MiladRahimi\PhpCrypt\Symmetric;

try {
    $symmetric = new Symmetric();
    $symmetric->setMethod('aria-256-ctr');
    // ...
} catch (MethodNotSupportedException $e) {
    // The method is not supported.
}
```

### Supported Methods

If you want to know which methods do your installed OpenSSL extension support, see the snippet below:

```php
use MiladRahimi\PhpCrypt\Symmetric;

print_r(Symmetric::supportedMethods());
```

## RSA Encryption

RSA is a popular asymmetric encryption/decryption algorithm.
The examples below illustrate how to encrypt/decrypt data using the RSA algorithm.

### Encryption with private key

In this example, we encrypt data with a private key and decrypt it with the related public key.

```php
use MiladRahimi\PhpCrypt\PrivateRsa;
use MiladRahimi\PhpCrypt\PublicRsa;

$privateRsa = new PrivateRsa('private_key.pem');
$publicRsa = new PublicRsa('public_key.pem');

$result = $privateRsa->encrypt('secret');
echo $publicRsa->decrypt($result); // secret
```

### Encryption with public key

In this example, we encrypt data with a public key and decrypt it with the related private key.

```php
use MiladRahimi\PhpCrypt\PrivateRsa;
use MiladRahimi\PhpCrypt\PublicRsa;

$privateRsa = new PrivateRsa('private_key.pem');
$publicRsa = new PublicRsa('public_key.pem');

$result = $publicRsa->encrypt('secret');
echo $privateRsa->decrypt($result); // secret
```

### Base64 Encoding

In default, the encrypted data returned by `PrivateRsa::encrypt()` and `PublicRsa::encrypt()` methods will be Base64 encoded.
You can disable this encoding like the example below.

```php
use MiladRahimi\PhpCrypt\PrivateRsa;
use MiladRahimi\PhpCrypt\PublicRsa;

$privateRsa = new PrivateRsa('private_key.pem');
$publicRsa = new PublicRsa('public_key.pem');

// Disable Base64 encoding for public encryption
$result = $publicRsa->encrypt('secret', false);

// Disable Base64 encoding for private encryption
$result = $privateRsa->encrypt('secret', false);
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

The `Symmetric`, `PrivateRsa`, `PublicRsa`, and `Hash` classes may throw these exceptions:

* `EncryptionException`: When it cannot encrypt data.
* `DecryptionException`: When it cannot decrypt data.
* `HashingException`: When it cannot hash data.
* `MethodNotSupportedException`: When the passed encryption method to the `Symmetric` class is not supported.
* `InvalidKeyException`: When the passed key to `PrivateRsa` or `PublicRsa` classes is not valid.

## License

PhpCrypt is initially created by [Milad Rahimi](https://miladrahimi.com) and released under the [MIT License](http://opensource.org/licenses/mit-license.php).
