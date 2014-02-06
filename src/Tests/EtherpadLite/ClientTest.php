<?php

namespace EtherpadLite\Tests;

use EtherpadLite\Client;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    const API_KEY = 'T6UnYqgl19';

    /**
     * @expectedException \EtherpadLite\Exception\UnsupportedMethodException
     * @dataProvider unsupportedMethodProvider
     */
    public function testUnsupportedMethods($method)
    {
        $client = new Client(self::API_KEY);
        $client->$method();
    }

    public function unsupportedMethodProvider()
    {
        return array(
            array('listMyImportantPad'),
            array('getPad'),
            array('setPadName')
        );
    }
}
