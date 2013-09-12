<?php

namespace EtherpadLite;

class Response
{
    const CODE_OK = 0;
    const CODE_WRONG_PARAMETERS = 1;
    const CODE_INTERNAL_ERROR = 2;
    const CODE_NO_SUCH_FUNCTION = 3;
    const CODE_NO_OR_WRONG_API_KEY = 4;

    protected $code = null;
    protected $message = '';
    protected $data = array();


    public function __construct($jsonResponse)
    {
        $response = json_decode($jsonResponse, true);

        if (is_array($response)) {
            foreach ($response as $key => $value) {
                $this->$key = $value;
            }
        }
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getMessage()
    {
        return $this->getMessage();
    }

    public function getData()
    {
        return $this->data;
    }
}