<?php

namespace EtherpadLite\Tests;

use EtherpadLite\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    const API_URL = 'http://localhost:9001';
    const API_KEY = 'abcdef';

    /**
     * @dataProvider dataGetParamsProvider
     */
    public function testGetParams($method, $args)
    {
        $request = $this->getRequest($method, $args);

        $this->assertArrayHasKey('apikey', $request->getParams());
        $this->assertEquals(1 + count($args), count($request->getParams()));
    }

    public function dataGetParamsProvider()
    {
        return array(
            array('createGroup', array()),
            array('createGroupIfNotExistsFor', array('groupMapper')),
            array('deleteGroup', array('groupID')),
            array('listPads', array('groupID')),
            array('createGroupPad', array('groupID', 'padName', 'text')),
            array('listAllGroups', array()),
            array('createAuthor', array('name')),
            array('createAuthorIfNotExistsFor', array('authorMapper', 'name')),
            array('listPadsOfAuthor', array('authorID')),
            array('getAuthorName', array('authorID')),
            array('createSession', array('groupID', 'authorID', 'validUntil')),
            array('deleteSession', array('sessionID')),
            array('getSessionInfo', array('sessionID')),
            array('listSessionsOfGroup', array('groupID')),
            array('listSessionsOfAuthor', array('authorID')),
            array('getText', array('padID', 'rev')),
            array('setText', array('padID', 'text')),
            array('getHTML', array('padID', 'rev')),
            array('setHTML', array('padID', 'html')),
            array('getChatHistory', array('padID', 'start', 'end')),
            array('getChatHead', array('padID')),
            array('createPad', array('padID', 'text')),
            array('getRevisionsCount', array('padID')),
            array('padUsersCount', array('padID')),
            array('padUsers', array('padID')),
            array('deletePad', array('padID')),
            array('getReadOnlyID', array('padID')),
            array('setPublicStatus', array('padID', 'publicStatus')),
            array('getPublicStatus', array('padID')),
            array('setPassword', array('padID', 'password')),
            array('isPasswordProtected', array('padID')),
            array('listAuthorsOfPad', array('padID')),
            array('getLastEdited', array('padID')),
            array('sendClientsMessage', array('padID', 'msg')),
            array('checkToken', array()),
            array('listAllPads', array()),
        );
    }

    protected function getRequest($method, $args = array())
    {
        return new Request(
            self::API_URL,
            self::API_KEY,
            $method,
            $args
        );
    }
}
