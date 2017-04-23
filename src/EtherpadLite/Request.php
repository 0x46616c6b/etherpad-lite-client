<?php

namespace EtherpadLite;

use GuzzleHttp\Client as HttpClient;
use Psr\Http\Message\ResponseInterface;

class Request
{
    const API_VERSION = '1.2.7';

    private $apiKey = null;
    private $url = null;
    private $method;
    private $args;

    /**
     * @param $url
     * @param $apiKey
     * @param $method
     * @param array $args
     */
    public function __construct($url, $apiKey, $method, $args = array())
    {
        $this->url = $url;
        $this->apiKey = $apiKey;
        $this->method = $method;
        $this->args = $args;
    }

    /**
     * Send the built request url against the etherpad lite instance
     *
     * @return ResponseInterface
     */
    public function send()
    {
        $client = new HttpClient(['base_uri' => $this->url]);

        return $client->get(
            $this->getUrlPath(),
            array(
                'query' => $this->getParams()
            )
        );
    }

    /**
     * Returns the path of the request url
     *
     * @return string
     */
    protected function getUrlPath()
    {
        $existingPath = parse_url($this->url, PHP_URL_PATH);

        return $existingPath . sprintf(
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
    public function getParams()
    {
        $params = array();
        $args = $this->args;

        $params['apikey'] = $this->apiKey;

        $methods = Client::getMethods();

        foreach ($methods[$this->method] as $key => $paramName) {
            if (isset($args[$key])) {
                $params[$paramName] = $args[$key];
            }
        }

        return $params;
    }
}
