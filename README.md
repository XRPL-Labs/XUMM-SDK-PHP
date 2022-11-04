![main workflow](https://github.com/XRPL-Labs/XUMM-SDK-PHP/actions/workflows/main.yml/badge.svg)

# Xumm SDK (PHP)

## Requirements
- PHP 8.1 or higher
- [Composer](https://getcomposer.org/)
- [Docker](https://docs.docker.com/get-docker/) and [docker compose](https://docs.docker.com/compose/install/) if you want to run acceptance tests

## Installation
This SDK is still in **beta**. To install, run:

```
composer require xrpl/xumm-sdk-php
```

## Usage
First obtain Xumm API credentials by [registering your app](https://xumm.readme.io/docs/register-your-app).

Initialize the Xumm SDK in your application: 
```PHP
// Either pass API credentials through the constructor 
$sdk = new XummSdk($apiKey, $apiSecret);

// Or set them as environment variables. See .env.example for the expected variable names.
// Note: the .env file is mostly applicable when contributing to the SDK itself.  
$sdk = XummSdk();
```

Each call on the SDK object will return a corresponding value object implementing the `XummResponse` interface.

### Create a payload
To create a payload, pass an instance of `Xrpl\XummSdkPhp\Payload` to `XummSdk::createPayload()`. This instance
should hold an associative array `transactionBody`, and can hold some options and custom metadata. For more 
elaborate documentation on how to construct a payload, please refer to 
[the API docs](https://xumm.readme.io/docs/your-first-payload).

A simple example could look like this:
```PHP
$sdk->createPayload(
    new Payload(
        transactionBody: [
            'TransactionType' => 'Payment',
            'Destination' => 'rPdvC6ccq8hCdPKSPJkPmyZ4Mi1oG2FFkT',
            'Fee' => '12'
        ],
        customMeta: new CustomMeta(identifier: 'my-custom-identifier'),
    )
);
```
This will return an instance of `Xrpl\XummSdkPhp\Response\CreatePayload\CreatedPayload`.

### Subscribe to a payload
After you create a payload, you can pass the returned `CreatedPayload` to `XummSdk::subscribe()` to subscribe to live
payload status changes. This returns an instance of `Xrpl\XummSdkPhp\Subscriber\Subscription`.

Changes to a payload status include:
- The payload was by a XUMM App user (web page)
- The payload was by a XUMM App user (in the app)
- Payload expiration updates (remaining time in seconds)
- The payload was resolved by rejecting
- The payload was resolved by accepting (signing)

Status updates can be handled by passing a callback function as a second argument to `XummSdk::subscribe`. 
The subscription ends by either:
- returning non-void from the callback function, or
- explicitly calling `Subscription::end()`.

### Other methods
The SDK also supports the XUMM API's helper methods, such as `ping`, `getCuratedAssets`, and `getRates`. Again, these
will all return corresponding implementations of `XummResponse`.

## Contributing
For contributing to development of this package, refer to [CONTRIBUTING.md](CONTRIBUTING.md).