# PHP Client for Etherpad Lite

[![Build Status](https://travis-ci.org/0x46616c6b/etherpad-lite-client.svg?branch=master)](https://travis-ci.org/0x46616c6b/etherpad-lite-client) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/0x46616c6b/etherpad-lite-client/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/0x46616c6b/etherpad-lite-client/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/0x46616c6b/etherpad-lite-client/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/0x46616c6b/etherpad-lite-client/?branch=master) [![Latest Stable Version](https://poser.pugx.org/0x46616c6b/etherpad-lite-client/v/stable.png)](https://packagist.org/packages/0x46616c6b/etherpad-lite-client) [![License](https://poser.pugx.org/0x46616c6b/etherpad-lite-client/license.png)](https://packagist.org/packages/0x46616c6b/etherpad-lite-client)

This package provides an easy access to [Etherpad Lite](https://github.com/ether/etherpad-lite) throw there built-in [HTTP API](http://etherpad.org/doc/v1.2.11/#index_http_api).

**Supported API Version: 1.2.13 (Release: 1.6.1)**

## Installation

Install the package via Composer

    composer require 0x46616c6b/etherpad-lite-client

Example (after install)

    <?php
    
    $client = new \EtherpadLite\Client($apikey);
    // if you don't use http://localhost:9001
    //$client = new \EtherpadLite\Client($apikey, 'http://example.com:9001');
    
    /** @var $response \EtherpadLite\Response */
    $response = $client->checkToken();

    echo $response->getCode();
    echo $response->getMessage();
    echo $response->getData();

## Testing

    vendor/bin/phpunit
    
    # Integration Tests
    # > requires a running etherpad lite instance
    #
    # Environment Variables:
    # ----------------------
    # 		API_KEY=cqOtzCYEUyzR23s8tftePVo8HHO
    # 		BASE_URL=http://localhost:9001
    
    vendor/bin/behat -f progress

## Contributing

Feel free to contribute to this repository.

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request
