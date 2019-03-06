<?php

namespace EtherpadLite\Tests;

use EtherpadLite\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class ResponseTest extends TestCase
{
    /**
     * @dataProvider jsonResponseProvider
     */
    public function testResponse($rawResponse, $expected)
    {
        $response = $this->getMockedResponse($rawResponse);

        $this->assertNotEmpty($response->getResponse());
        $this->assertArrayHasKey('code', $response->getResponse());
        $this->assertArrayHasKey('message', $response->getResponse());
        $this->assertArrayHasKey('data', $response->getResponse());
        $this->assertEquals($expected['code'], $response->getCode());
        $this->assertEquals($expected['message'], $response->getMessage());
        $this->assertEquals($expected['data'], $response->getData());
    }

    public function jsonResponseProvider()
    {
        return [
            [
                '{"code":0,"message":"ok","data":{"groupID": "g.s8oes9dhwrvt0zif"}}',
                [
                    'code' => 0,
                    'message' => 'ok',
                    'data' => [
                        'groupID' => 'g.s8oes9dhwrvt0zif',
                    ],
                ],
            ],
            [
                '{"code":0,"message":"ok","data":{"padIDs":["g.OTeVWJ4KuZyRBlDI$aaa","meinNEUESPad","sjImkoFqDK","t08dXmHh1t"]}}',
                [
                    'code' => 0,
                    'message' => 'ok',
                    'data' => [
                        'padIDs' => ['g.OTeVWJ4KuZyRBlDI$aaa', 'meinNEUESPad', 'sjImkoFqDK', 't08dXmHh1t'],
                    ],
                ],
            ],
            [
                '{"code":4,"message":"no or wrong API Key","data":null}',
                [
                    'code' => 4,
                    'message' => 'no or wrong API Key',
                    'data' => null,
                ],
            ],
            [
                '{"code":0,"message":"ok","data":null}',
                [
                    'code' => 0,
                    'message' => 'ok',
                    'data' => null,
                ],
            ],
        ];
    }

    public function testGetData()
    {
        $rawResponse = '{"code":0,"message":"ok","data":{"groupID": "g.s8oes9dhwrvt0zif"}}';
        $response = $this->getMockedResponse($rawResponse);

        $this->assertEquals('g.s8oes9dhwrvt0zif', $response->getData('groupID'));
        $this->assertNull($response->getData('padID'));
    }

    /**
     * @param $rawResponse
     * @return Response
     */
    private function getMockedResponse($rawResponse)
    {
        $httpResponse = $this->getMockBuilder('\Psr\Http\Message\ResponseInterface')
            ->setConstructorArgs([200, null, $rawResponse])
            ->getMock();

        $httpResponse
            ->expects($this->once())
            ->method('getStatusCode')
            ->will($this->returnValue(200));

        $httpResponse
            ->expects($this->once())
            ->method('getBody')
            ->will($this->returnValue($rawResponse));

        /** @var ResponseInterface $httpResponse */
        $response = new Response($httpResponse);

        return $response;
    }
}
