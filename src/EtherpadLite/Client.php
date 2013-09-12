<?php

namespace EtherpadLite;

use EtherpadLite\Exception\UnsupportedMethodException;
use Guzzle\Http\Client as HttpClient;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Class Client
 *
 * @package EtherpadLite
 *
 * @method \EtherpadLite\Response createGroup() creates a new group
 * @method \EtherpadLite\Response createGroupIfNotExistsFor($groupMapper) this functions helps you to map your application group ids to etherpad lite group ids
 * @method \EtherpadLite\Response deleteGroup($groupID) deletes a group
 * @method \EtherpadLite\Response listPads($groupID) returns all pads of this group
 * @method \EtherpadLite\Response createGroupPad($groupID, $padName, $text = null) creates a new pad in this group
 * @method \EtherpadLite\Response listAllGroups() lists all existing groups
 *
 * @method \EtherpadLite\Response createAuthor($name = null) creates a new author
 * @method \EtherpadLite\Response createAuthorIfNotExistsFor($authorMapper, $name = null) this functions helps you to map your application author ids to etherpad lite author ids
 * @method \EtherpadLite\Response listPadsOfAuthor($authorID) returns an array of all pads this author contributed to
 * @method \EtherpadLite\Response getAuthorName($authorID) Returns the Author Name of the author
 *
 * @method \EtherpadLite\Response createSession($groupID, $authorID, $validUntil) creates a new session. validUntil is an unix timestamp in seconds
 * @method \EtherpadLite\Response deleteSession($sessionID) creates a new session. validUntil is an unix timestamp in seconds
 * @method \EtherpadLite\Response getSessionInfo($sessionID) returns informations about a session
 * @method \EtherpadLite\Response listSessionsOfGroup($groupID) returns all sessions of a group
 * @method \EtherpadLite\Response listSessionsOfAuthor($authorID) returns all sessions of an author
 *
 * @method \EtherpadLite\Response getText($padID, $rev = null) returns the text of a pad
 * @method \EtherpadLite\Response setText($padID, $text) sets the text of a pad
 * @method \EtherpadLite\Response getHTML($padID, $rev = null) returns the text of a pad formatted as HTML
 *
 * @method \EtherpadLite\Response getChatHistory($padID, $start = null, $end = null) a part of the chat history, when start and end are given, the whole chat histroy, when no extra parameters are given
 * @method \EtherpadLite\Response getChatHead($padID) returns the chatHead (last number of the last chat-message) of the pad
 *
 * @method \EtherpadLite\Response createPad($padID, $text = null) creates a new (non-group) pad. Note that if you need to create a group Pad, you should call createGroupPad.
 * @method \EtherpadLite\Response getRevisionsCount($padID) returns the number of revisions of this pad
 * @method \EtherpadLite\Response padUsersCount($padID) returns the number of user that are currently editing this pad
 * @method \EtherpadLite\Response padUsers($padID) returns the list of users that are currently editing this pad
 * @method \EtherpadLite\Response deletePad($padID) deletes a pad
 * @method \EtherpadLite\Response getReadOnlyID($padID) returns the read only link of a pad
 * @method \EtherpadLite\Response setPublicStatus($padID, $publicStatus) sets a boolean for the public status of a pad
 * @method \EtherpadLite\Response getPublicStatus($padID) return true of false
 * @method \EtherpadLite\Response setPassword($padID, $password) returns ok or a error message
 * @method \EtherpadLite\Response isPasswordProtected($padID) returns true or false
 * @method \EtherpadLite\Response listAuthorsOfPad($padID) returns an array of authors who contributed to this pad
 * @method \EtherpadLite\Response getLastEdited($padID) returns the timestamp of the last revision of the pad
 * @method \EtherpadLite\Response sendClientsMessage($padID, $msg) sends a custom message of type $msg to the pad
 * @method \EtherpadLite\Response checkToken() returns ok when the current api token is valid
 *
 * @method \EtherpadLite\Response listAllPads() lists all pads on this epl instance
 *
 */
class Client
{
    const API_VERSION = '1.2.7';

    private $apikey = null;
    private $url = null;

    private $methods = array(
        'createGroup',
        'createGroupIfNotExistsFor',
        'deleteGroup',
        'listPads',
        'createGroupPad',
        'listAllGroups',
        'createAuthor',
        'createAuthorIfNotExistsFor',
        'listPadsOfAuthor',
        'getAuthorName',
        'createSession',
        'deleteSession',
        'getSessionInfo',
        'listSessionsOfGroup',
        'listSessionsOfAuthor',
        'getText',
        'setText',
        'getHTML',
        'getChatHistory',
        'getChatHead',
        'createPad',
        'getRevisionsCount',
        'padUsersCount',
        'padUsers',
        'deletePad',
        'getReadOnlyID',
        'setPublicStatus',
        'getPublicStatus',
        'getPublicStatus',
        'setPassword',
        'isPasswordProtected',
        'listAuthorsOfPad',
        'getLastEdited',
        'sendClientsMessage',
        'checkToken',
        'listAllPads',
    );

    public function __construct($apikey, $url = 'http://localhost:9001')
    {
        $this->apikey = $apikey;
        $this->url = $url;
    }

    public function __call($method, $args = array()) {
        if (!in_array($method, $this->methods)) {
            throw new UnsupportedMethodException();
        }

        $params = array();

        switch ($method) {
            case 'deleteGroup':
                $params = array(
                    'groupID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'listPads':
                $params = array(
                    'groupID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'createGroupPad':
                $params = array(
                    'groupID' => isset($args[0]) ? $args[0] : '',
                    'padName' => isset($args[1]) ? $args[1] : '',
                    'text' => isset($args[2]) ? $args[2] : ''
                );
                break;
            case 'createPad':
                $params = array(
                    'padID' => isset($args[0]) ? $args[0] : '',
                    'text' => isset($args[1]) ? $args[1] : ''
                );
                break;
            case 'createAuthor':
                if (isset($args[0])) {
                    $params = array(
                        'name' => $args[0]
                    );
                }
                break;
            case 'listPadsOfAuthor':
                $params = array(
                    'authorID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'getAuthorName':
                $params = array(
                    'authorID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'createSession':
                $params = array(
                    'groupID' => isset($args[0]) ? $args[0] : '',
                    'authorID' => isset($args[1]) ? $args[1] : '',
                    'validUntil' => isset($args[2]) ? $args[2] : ''
                );
                break;
            case 'deleteSession':
                $params = array(
                    'sessionID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'getSessionInfo':
                $params = array(
                    'sessionID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'listSessionsOfGroup':
                $params = array(
                    'groupID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            case 'listSessionsOfAuthor':
                $params = array(
                    'authorID' => isset($args[0]) ? $args[0] : ''
                );
                break;
            default:
                break;
        }

        return $this->getResponse($method, $params);
    }

    protected function getResponse($method, $params = array())
    {
        $httpClient = new HttpClient($this->url);

        $params = array_merge(
            array(
                'apikey' => $this->apikey
            ),
            $params
        );

        $url = sprintf(
            '/api/%s/%s',
            self::API_VERSION,
            $method
        );

        $request = $httpClient->get($url, array(), array('query' => $params));
        $response = $request->send();

        if ($response->isError()) {
            throw new BadResponseException();
        }

        return new Response($response->getBody());
    }
}