<?php

namespace EtherpadLite\Tests;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \EtherpadLite\Exception\UnsupportedMethodException
     */
    public function testUnsupportedMethods()
    {
        $client = new \EtherpadLite\Client('T6UnYqgl19');
        $client->fetchUnsupportedMethod();
    }
}