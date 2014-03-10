# PHP Client for Etherpad Lite

[![Latest Stable Version](https://poser.pugx.org/0x46616c6b/etherpad-lite-client/v/stable.png)](https://packagist.org/packages/0x46616c6b/etherpad-lite-client) [![License](https://poser.pugx.org/0x46616c6b/etherpad-lite-client/license.png)](https://packagist.org/packages/0x46616c6b/etherpad-lite-client) [![Build Status](https://travis-ci.org/0x46616c6b/etherpad-lite-client.png?branch=master)](https://travis-ci.org/0x46616c6b/etherpad-lite-client) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/0x46616c6b/etherpad-lite-client/badges/quality-score.png?s=0242a9f3d615ba0ed839a42bbb6aeaefc3aa8370)](https://scrutinizer-ci.com/g/0x46616c6b/etherpad-lite-client/)

This package provides an easy access to [Etherpad Lite](https://github.com/ether/etherpad-lite) throw there built-in [HTTP API](http://etherpad.org/doc/v1.2.11/#index_http_api).

## Installation

Install the package via Composer

	composer require 0x46616c6b/etherpad-lite-client:dev-master

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
