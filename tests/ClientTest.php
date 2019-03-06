<?php

namespace EtherpadLite\Tests;

use EtherpadLite\Client;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
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

    public function testGeneratePadID()
    {
        $client = new Client(self::API_KEY);
        $padId = $client->generatePadID();

        $this->assertTrue(is_string($padId));
        $this->assertEquals(16,strlen($padId));
    }
}
