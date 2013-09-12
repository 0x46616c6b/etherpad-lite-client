# PHP Client for Etherpad Lite

This package provides to give you an easy access to [Etherpad Lite](https://github.com/ether/etherpad-lite) throw there built-in [HTTP API](http://etherpad.org/doc/v1.2.11/#index_http_api).

## Installation

Install the package via Composer

	composer require 0x46616c6b/etherpad-lite-client:dev-master

Example (after install)

	<?php
	
	$client = \EtherpadLite\Client($apikey);
	// if you don't use http://localhost:9001
	//$client = \EtherpadLite\Client($apikey, 'http://example.com:9001');
	
	/** @var $response \EtherpadLite\Response */
	$response = $client->checkToken();

	echo $response->getCode();
	echo $response->getMessage();
	echo $response->getData();


