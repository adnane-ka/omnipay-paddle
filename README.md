
# Omnipay: paddle

**Paddle payments gateway for Omnipay payment processing library**

[![Build Status](https://img.shields.io/travis/com/adnane-ka/omnipay-paddle.svg?style=flat-square)](https://travis-ci.com/adnane-ka/omnipay-paddle)
[![Latest Stable Version](https://img.shields.io/packagist/v/adnane-ka/omnipay-paddle.svg?style=flat-square)](https://packagist.org/packages/adnane-ka/omnipay-paddle)
[![Total Downloads](https://img.shields.io/packagist/dt/adnane-ka/omnipay-paddle.svg?style=flat-square)](https://packagist.org/packages/adnane-ka/omnipay-paddle)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Tap support for Omnipay.

## Installation
```shell
composer require adnane-ka/omnipay-paddle
```
## Basic Usage
The following gateways are provided by this package:

* paddle

This package ineteracts with [paddle's API](https://paddle.vn/lap-trinh-cong-thanh-toan.html). 

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Flow

1. Configure gateway
2. Create a new price for the given product
3. Display an overlay checkout form
4. Proccess Payment by gateway
5. Redirect to proccess payment on website

## Example usage
### Configuration

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('paddle');
$gateway->setApiKey('YOUR_API_KEY');
$gateway->setProductId('YOUR_PRODUCT_ID');
```

### Creating a Purchase
```php
$response = $gateway->purchase([
    'amount' => 100000, // the amount in VND
    'checkoutUrl' => 'http://localhost:8000/checkout.php', // the page where the overlay checkout is displayed
    'returnUrl' => 'http://localhost:8000/complete.php', // the URL to return to after the operation is fully proccessed
    'transactionId' => uniqid() // A unique identifier for the operation
])->send();

if ($response->isRedirect()) {
    // The price is created and you're ready to be redirected to checkout
    $response->redirect(); 
} else {
    // An error occured
    echo $response->getMessage();
}
```

### Checkout
```html

```

### Completing Purchase
When users submit the checkout form after they pay using the overlay checkout, they'll be redirected to `returnUrl` where you'll be proccessing the payment:
```php
$response = $gateway->completePurchase([
    'transactionId' => 'FGJAKANMCHK', // This should be retrieved from request redirect
    'amount' => 100000 // Locate this from your system 
])->send();

if($response->isSuccessful()){
    // Payment was successful and charge was captured
    // $response->getData()
    // $response->getTransactionReference() // payment reference
}else{
    // Charge was not captured and payment failed
    // $response->getData()
}
```
## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/adnane-ka/omnipay-tap/issues),
or better yet, fork the library and submit a pull request.