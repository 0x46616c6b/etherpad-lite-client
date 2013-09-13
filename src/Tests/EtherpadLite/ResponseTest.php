<?php

namespace EtherpadLite\Tests;

class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonResponseProvider
     */
    public function testResponse($json)
    {
        $bodyArray = json_decode($json, true);

        $httpResponse = $this->getMockBuilder('\Guzzle\Http\Message\Response')
            ->setConstructorArgs(array(200, null, $json))
            ->getMock();

        $httpResponse
            ->expects($this->once())
            ->method('isSuccessful')
            ->will($this->returnValue(true));

        $httpResponse
            ->expects($this->once())
            ->method('json')
            ->will($this->returnValue($bodyArray));

        $response = new \EtherpadLite\Response($httpResponse);

        $this->assertEquals($bodyArray, $response->getResponse());
        $this->assertEquals($bodyArray['code'], $response->getCode());
        $this->assertEquals($bodyArray['message'], $response->getMessage());
        $this->assertEquals($bodyArray['data'], $response->getData());
    }

    public function jsonResponseProvider()
    {
        return array(
            array('{"code": 0, "message":"ok", "data": {"groupID": "g.s8oes9dhwrvt0zif"}}'),
            array('{"code":0,"message":"ok","data":{"padIDs":["g.OTeVWJ4KuZyRBlDI$aaa","meinNEUESPad","sjImkoFqDK","t08dXmHh1t"]}}'),
            array('{"code":4,"message":"no or wrong API Key","data":null}'),
            array('{"code":0,"message":"ok","data":null}')
        );
    }
}