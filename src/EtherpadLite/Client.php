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

    public function __construct($apikey, $url = 'http://localhost:9001')
    {
        $this->apikey = $apikey;
        $this->url = $url;
    }

    public function __call($method, $args = array())
    {
        if (!in_array($method, array_keys(self::getMethods()))) {
            throw new UnsupportedMethodException();
        }

        $request = new Request($this->url, $this->apikey, $method, $args);
        return new Response($request->send());
    }

    /**
     * Generates a random padID
     *
     * @return string
     */
    public function generatePadID()
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $length = 16;
        $padID = "";

        for ($i = 0; $i < $length; $i++) {
            $padID .= $chars[rand()%strlen($chars)];
        }

        return $padID;
    }

    /**
     * Array that holds the available methods and their required parameter names
     *
     * @return array
     */
    public static function getMethods()
    {
        return array(
            'createGroup' => array(),
            'createGroupIfNotExistsFor' => array('groupMapper'),
            'deleteGroup' => array('groupID'),
            'listPads' => array('groupID'),
            'createGroupPad' => array('groupID', 'padName', 'text'),
            'listAllGroups' => array(),
            'createAuthor' => array('name'),
            'createAuthorIfNotExistsFor' => array('authorMapper', 'name'),
            'listPadsOfAuthor' => array('authorID'),
            'getAuthorName' => array('authorID'),
            'createSession' => array('groupID', 'authorID', 'validUntil'),
            'deleteSession' => array('sessionID'),
            'getSessionInfo' => array('sessionID'),
            'listSessionsOfGroup' => array('groupID'),
            'listSessionsOfAuthor' => array('authorID'),
            'getText' => array('padID', 'rev'),
            'setText' => array('padID', 'text'),
            'getHTML' => array('padID', 'rev'),
            'getChatHistory' => array('padID', 'start', 'end'),
            'getChatHead' => array('padID'),
            'createPad' => array('padID', 'text'),
            'getRevisionsCount' => array('padID'),
            'padUsersCount' => array('padID'),
            'padUsers' => array('padID'),
            'deletePad' => array('padID'),
            'getReadOnlyID' => array('padID'),
            'setPublicStatus' => array('padID', 'publicStatus'),
            'getPublicStatus' => array('padID'),
            'setPassword' => array('padID', 'password'),
            'isPasswordProtected' => array('padID'),
            'listAuthorsOfPad' => array('padID'),
            'getLastEdited' => array('padID'),
            'sendClientsMessage' => array('padID', 'msg'),
            'checkToken' => array(),
            'listAllPads' => array(),
        );
    }
}
