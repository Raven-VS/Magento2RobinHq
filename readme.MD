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
Follow the following steps to get it up and running:

 - Enable the API.... @todo

#### Authentication

The authentication of the dynamic API is done by a pre shared key.

@todo