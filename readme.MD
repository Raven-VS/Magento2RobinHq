# Magento 2 RobinHQ module
Providers API integrations with the RobinHQ platform / dashboards

## Installation
Install package using composer
```sh
composer require emico/magento-2-robinhq
```

Run installers
```sh
php bin/magento setup:upgrade
```

## Dynamic API

This module provides 5 endpoints for the RobinHQ dynamic API integration.
This endpoints are called directly from within the RobinHQ dashboard, providing the latest up to date information from Magento.

The following endpoints are available:
 - /robinhq/api/customer?email=`mail`
 - /robinhq/api/order?orderNumber=`number`
 - /robinhq/api/customerOrders?email=`mail`
 - /robinhq/api/search?searchTerm=`search`
 - /robinhq/api/customerLifetime?email=`email`
   
Those are accessible from the root of your magento domain. http://my.shop.nl/robinhq/api/customer

To enable the dynamic API functionality you have to enable it in the configuration.

`Stores` -> `Configuration` -> `Emico` -> `RobinHQ` -> `Enable dynamic API`

#### Authentication

The authentication of the dynamic API is done by a pre shared key which must be communicated to RobinHQ.

You can define an API key and secret in the RobinHQ configuration.

When issueing requests to the dynamic API endpoint you have to include a Basic authentication header.
The value you have to sent is a base64-encoding of `{apiKey}:{apiSecret}`.

For example you have set up API key to `abc` and API secret to `def`.
The value would be `base64(abc:def)`, which resolves to `YWJjOmRlZg==`.
The full authorization header is:
`Authorization: Basic YWJjOmRlZg==`