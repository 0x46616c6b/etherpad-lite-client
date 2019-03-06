<?php

namespace EtherpadLite;

use EtherpadLite\Exception\UnsupportedMethodException;

/**
 * Class Client
 *
 * @package EtherpadLite
 *
 * @method Response createGroup() creates a new group
 * @method Response createGroupIfNotExistsFor($groupMapper) this functions helps you to map your application group ids to etherpad lite group ids
 * @method Response deleteGroup($groupID) deletes a group
 * @method Response listPads($groupID) returns all pads of this group
 * @method Response createGroupPad($groupID, $padName, $text = null) creates a new pad in this group
 * @method Response listAllGroups() lists all existing groups
 *
 * @method Response createAuthor($name = null) creates a new author
 * @method Response createAuthorIfNotExistsFor($authorMapper, $name = null) this functions helps you to map your application author ids to etherpad lite author ids
 * @method Response listPadsOfAuthor($authorID) returns an array of all pads this author contributed to
 * @method Response getAuthorName($authorID) Returns the Author Name of the author
 *
 * @method Response createSession($groupID, $authorID, $validUntil) creates a new session. validUntil is an unix timestamp in seconds
 * @method Response deleteSession($sessionID) deletes a session by id
 * @method Response getSessionInfo($sessionID) returns informations about a session
 * @method Response listSessionsOfGroup($groupID) returns all sessions of a group
 * @method Response listSessionsOfAuthor($authorID) returns all sessions of an author
 *
 * @method Response getText($padID, $rev = null) returns the text of a pad
 * @method Response setText($padID, $text) sets the text of a pad
 * @method Response getHTML($padID, $rev = null) returns the text of a pad formatted as HTML
 *
 * @method Response getChatHistory($padID, $start = null, $end = null) a part of the chat history, when start and end are given, the whole chat histroy, when no extra parameters are given
 * @method Response getChatHead($padID) returns the chatHead (last number of the last chat-message) of the pad
 *
 * @method Response createPad($padID, $text = null) creates a new (non-group) pad. Note that if you need to create a group Pad, you should call createGroupPad.
 * @method Response getRevisionsCount($padID) returns the number of revisions of this pad
 * @method Response padUsersCount($padID) returns the number of user that are currently editing this pad
 * @method Response padUsers($padID) returns the list of users that are currently editing this pad
 * @method Response deletePad($padID) deletes a pad
 * @method Response getReadOnlyID($padID) returns the read only link of a pad
 * @method Response setPublicStatus($padID, $publicStatus) sets a boolean for the public status of a pad
 * @method Response getPublicStatus($padID) return true of false
 * @method Response setPassword($padID, $password) returns ok or a error message
 * @method Response isPasswordProtected($padID) returns true or false
 * @method Response listAuthorsOfPad($padID) returns an array of authors who contributed to this pad
 * @method Response getLastEdited($padID) returns the timestamp of the last revision of the pad
 * @method Response sendClientsMessage($padID, $msg) sends a custom message of type $msg to the pad
 * @method Response checkToken() returns ok when the current api token is valid
 *
 * @method Response listAllPads() lists all pads on this epl instance
 *
 */
class Client
{
    const API_VERSION = '1.2.13';

    /**
     * @var string|null
     */
    private $apikey = null;
    /**
     * @var string|null
     */
    private $url = null;

    /**
     * @param string $apikey
     * @param string $url
     */
    public function __construct(string $apikey, string $url = 'http://localhost:9001')
    {
        $this->apikey = $apikey;
        $this->url = $url;
    }

    /**
     * @param string $method
     * @param array $args
     * @return Response
     * @throws Exception\UnsupportedMethodException
     */
    public function __call(string $method, $args = []): Response
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
    public function generatePadID(): string
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $length = 16;
        $padID = "";

        for ($i = 0; $i < $length; $i++) {
            $padID .= $chars[rand() % strlen($chars)];
        }

        return $padID;
    }

    /**
     * Array that holds the available methods and their required parameter names
     *
     * @return array
     */
    public static function getMethods(): array
    {
        return [
            'createGroup' => [],
            'createGroupIfNotExistsFor' => ['groupMapper'],
            'deleteGroup' => ['groupID'],
            'listPads' => ['groupID'],
            'createGroupPad' => ['groupID', 'padName', 'text'],
            'listAllGroups' => [],
            'createAuthor' => ['name'],
            'createAuthorIfNotExistsFor' => ['authorMapper', 'name'],
            'listPadsOfAuthor' => ['authorID'],
            'getAuthorName' => ['authorID'],
            'createSession' => ['groupID', 'authorID', 'validUntil'],
            'deleteSession' => ['sessionID'],
            'getSessionInfo' => ['sessionID'],
            'listSessionsOfGroup' => ['groupID'],
            'listSessionsOfAuthor' => ['authorID'],
            'getText' => ['padID', 'rev'],
            'setText' => ['padID', 'text'],
            'getHTML' => ['padID', 'rev'],
            'getAttributePool' => ['padID'],
            'getChatHistory' => ['padID', 'start', 'end'],
            'getChatHead' => ['padID'],
            'createPad' => ['padID', 'text'],
            'getRevisionsCount' => ['padID'],
            'listSavedRevisions' => ['padID'],
            'padUsersCount' => ['padID'],
            'padUsers' => ['padID'],
            'deletePad' => ['padID'],
            'getReadOnlyID' => ['padID'],
            'setPublicStatus' => ['padID', 'publicStatus'],
            'getPublicStatus' => ['padID'],
            'setPassword' => ['padID', 'password'],
            'isPasswordProtected' => ['padID'],
            'listAuthorsOfPad' => ['padID'],
            'getLastEdited' => ['padID'],
            'sendClientsMessage' => ['padID', 'msg'],
            'checkToken' => [],
            'listAllPads' => [],
        ];
    }
}
