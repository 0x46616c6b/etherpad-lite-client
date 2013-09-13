<?php

namespace EtherpadLite;

class Request
{
    const API_VERSION = '1.2.7';

    private $apikey = null;
    private $url = null;
    private $method;
    private $args;

    public function __construct($url, $apikey, $method, $args = array())
    {
        $this->url = $url;
        $this->apikey = $apikey;
        $this->method = $method;
        $this->args = $args;
    }

    /**
     * Send the built request url against the etherpad lite instance
     *
     * @return \Guzzle\Http\Message\Response
     */
    public function send()
    {
        $client = new \Guzzle\Http\Client($this->url);

        $request = $client->get(
            $this->getUrlPath(),
            array(),
            array(
                'query' => $this->getParams()
            )
        );

        return $request->send();
    }

    /**
     * Returns the path of the request url
     *
     * @return string
     */
    protected function getUrlPath()
    {
        return sprintf(
            '/api/%s/%s',
            self::API_VERSION,
            $this->method
        );
    }

    /**
     * Maps the given arguments from Client::__call to the parameter of the api method
     *
     * @return array
     */
    protected function getParams()
    {
        $params = array();
        $args = $this->args;

        $params['apikey'] = $this->apikey;

        $methods = Client::getMethods();

        foreach ($methods[$this->method] as $key => $paramName) {
            if (isset($args[$key])) {
                $params[$paramName] = $args[$key];
            }
        }

        return $params;
    }
}