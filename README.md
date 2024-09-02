# Admetrics Data Studio - Magento Module

## Installation

```
# Enable maintenance mode
bin/magento maintenance:enable

# Add latest version of Admetrics Magento Module
composer require admetrics/magento-module

# Install
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:clean

# Disable maintenance mode
bin/magento maintenance:disable
```

## Updating

```
# Enable maintenance mode
bin/magento maintenance:enable

# Get latest version of Admetrics Magento Module
composer update admetrics/magento-module

# Update
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento setup:static-content:deploy
bin/magento cache:clean

# Disable maintenance mode
bin/magento maintenance:disable
```
