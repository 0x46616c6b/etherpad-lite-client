<?php

namespace EtherpadLite;

class Response
{
    const CODE_OK = 0;
    const CODE_WRONG_PARAMETERS = 1;
    const CODE_INTERNAL_ERROR = 2;
    const CODE_NO_SUCH_FUNCTION = 3;
    const CODE_NO_OR_WRONG_API_KEY = 4;

    private $response = array();

    public function __construct(\Guzzle\Http\Message\Response $response)
    {
        if ($response->isSuccessful()) {
            $this->response = $response->json();

            foreach ($this->response as $key => $value) {
                $this->$key = $value;
            }
        } else {
            // TODO: Error handling
        }
    }

    /**
     * @return string|null
     */
    public function getCode()
    {
        return isset($this->response['code']) ? $this->response['code'] : null;
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return isset($this->response['message']) ? $this->response['message'] : null;
    }

    /**
     * @return string|null
     */
    public function getData()
    {
        return isset($this->response['data']) ? $this->response['data'] : null;
    }

    /**
     * Returns the entire response from Etherpad Lite API
     *
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }
}