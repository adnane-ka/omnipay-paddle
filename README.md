
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

* Paddle

This package ineteracts with [paddle's API](https://paddle.vn/lap-trinh-cong-thanh-toan.html). 

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Flow

1. Configure gateway
2. Create a draft transaction
3. Display an overlay checkout form for the draft transaction
4. Proccess Payment by gateway
5. Redirect to proccess payment on website

## Example usage
### Configuration

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Paddle');
$gateway->setApiKey('YOUR_API_KEY');
$gateway->setTestMode(true);
```

### Creating a Purchase
```php
$response = $gateway->purchase([
    'amount' => 5.00 * 100, // in cents
    'checkoutUrl' => 'http://localhost:8000/checkout.php', // where you'll display the overlay / inline checkout
    'returnUrl' => 'http://localhost:8000/complete.php',  // where you'll be proccessing the payment 
    'currency' => 'USD'
])->send();

if ($response->isRedirect()) {
    // The transaction is created as a draft and you're ready to be redirected to checkout
    $response->redirect(); 
} else {
    // An error occured
    echo $response->getMessage();
}
```

### Checkout
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paddle Checkout</title>
</head>
<body>
<script src="https://cdn.paddle.com/paddle/v2/paddle.js"></script>
<script type="text/javascript">
    Paddle.Environment.set("sandbox");
    Paddle.Initialize({ 
      token: "test_4c116d8b4cc5cd9756de9765db9", // Your public API key 
    });
    Paddle.Checkout.open({
      transactionId: "<?php echo $_GET['transactionId']; ?>", // Locate this from request 
      settings: {
        successUrl: "<?php echo urldecode($_GET['returnUrl']); ?>" // Locate this from request
      }
    });
</script>
</body>
</html>
```

### Completing Purchase
When users submit the checkout form after they pay using the overlay checkout, they'll be redirected to `returnUrl` where you'll be proccessing the payment:
```php
$response = $gateway->completePurchase([
    'transactionId' => $_GET['transactionId'] // sent in request or retrieved from backend
])->send();

if($response->isSuccessful()){
    // Payment was successful and charge was captured
    // $response->getData()
    echo $response->getTransactionReference(); // payment reference
}else{
    // Charge was not captured and payment failed
    echo $response->getMessage();
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
