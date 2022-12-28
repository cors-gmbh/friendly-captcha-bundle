Elma Friendly Captcha Bundle
--------

[![CI](https://github.com/elma/friendly-captcha-bundle/actions/workflows/build.yml/badge.svg)](https://github.com/elma/friendly-captcha-bundle/actions/workflows/build.yml)

This bundle provides easy [friendlycaptcha.com](https://www.friendlycaptcha.com) form field for Symfony.

This is a fork of the [cors][https://github.com/cors-gmbh/friendly-captcha-bundle] bundle, that does not seems to be maintened,  [see this PR for details][https://github.com/cors-gmbh/friendly-captcha-bundle/pull/3]

## Installation

### Step 1: Use composer and enable Bundle

To install CORSFriendlyCaptchaBundle with Composer just type in your terminal:

```bash
php composer.phar require elma/friendly-captcha-bundle
```

Now, Composer will automatically download all required files, and install them
for you. All that is left to do is to update your ``AppKernel.php`` file, and
register the new bundle:

```php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new CORS\Bundle\FriendlyCaptchaBundle\CORSFriendlyCaptchaBundle(),
    // ...
);
```

### Step2: Configure the bundle's

```yaml
cors_friendly_captcha:
    sitekey: here_is_your_sitekey
    secret: here_is_your_secret
    use_eu_endpoints: true|false
```

#### Optionally, change endpoints

```yaml
cors_friendly_captcha:
  puzzle: 
    endpoint: https://api.friendlycaptcha.com/api/v1/puzzle
    eu_endpoint: https://eu-api.friendlycaptcha.eu/api/v1/puzzle
  validation: 
    endpoint: https://api.friendlycaptcha.com/api/v1/siteverify
    eu_endpoint: https://eu-api.friendlycaptcha.eu/api/v1/siteverify
```
