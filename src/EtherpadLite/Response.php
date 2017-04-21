<?php

namespace EtherpadLite;

use Psr\Http\Message\ResponseInterface;

class Response
{
    const CODE_OK = 0;
    const CODE_WRONG_PARAMETERS = 1;
    const CODE_INTERNAL_ERROR = 2;
    const CODE_NO_SUCH_FUNCTION = 3;
    const CODE_NO_OR_WRONG_API_KEY = 4;

    /** @var \stdClass */
    private $data;

    /**
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        if ($response->getStatusCode() === 200) {
            $this->data = \GuzzleHttp\json_decode($response->getBody(), true);
        } else {
            $this->data = array();
        }
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return $this->getResponseKey('code');
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->getResponseKey('message');
    }

    /**
     * @return string|null
     */
    public function getData()
    {
        return $this->getResponseKey('data');
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @return mixed
     */
    private function getResponseKey($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
