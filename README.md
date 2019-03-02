# Elatebrain Gdpr for Magento 2



[![Latest Stable Version](https://poser.pugx.org/elatebrain/module-gdpr/v/stable)](https://packagist.org/packages/elatebrain/module-gdpr)
[![Total Downloads](https://poser.pugx.org/elatebrain/module-gdpr/downloads)](https://packagist.org/packages/elatebrain/module-gdpr)


## How to install & upgrade Elatebrain_Gdpr


#### 1. Install via composer (recommended)

We recommend you to install Elatebrain_Gdpr module via composer. It is easy to install, update and maintain.

Run the following command in Magento 2 root directory.

##### 1.1 Install

```
composer require elatebrain/module-gdpr
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

##### 1.2 Upgrade

```
composer update elatebrain/module-gdpr
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

Run setup:di:compile command if your store is in Production mode:

```
php bin/magento setup:di:compile
```

#### 2. Copy and paste

If you don't want to install this module via composer, you can use this way. 

- Download [the latest version here](https://github.com/elatebrain/module-gdpr/archive/master.zip) 
- Extract `master.zip` file to `app/code/Elatebrain/Gdpr` ; You have to create a folder path `app/code/Elatebrain/Gdpr` if not exist.
- Go to Magento root folder and run upgrade command line to install `Elatebrain_Gdpr`:

```
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```
