# OXID Academy: Exercise extensions (Skeleton)

This package contains a module skeleton for training purposes at OXID Academy. 

## Installation instructions

### Register and require the package

In the local development environment, cd into the root directory of your compilation
and run Composer as follows:
 
```
composer config repositories.oxid-academy/feefreepayments vcs https://github.com/oxid-academy/feefreepayments.git
```

This should result in the following change to `composer.json`:
```
...
  "repositories": {
    ...,
    "oxid-academy/feefreepayments": {
      "type": "vcs",
      "url": "https://github.com/oxid-academy/feefreepayments.git"
    }
  },
  ...
```

And then, ...
```
composer require oxid-academy/feefreepayments
```

... which makes it:
```
  "require": {
    ...,
    "oxid-academy/feefreepayments": "dev-master"
  },
```

## Build compilation

Now, run Composer to build the compilation:
```
composer update
```

## Running tests
`./vendor/bin/runtests /var/www/oxideshop/source/modules/oxac/feefreepayments/Tests/`
