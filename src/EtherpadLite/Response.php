<?php

namespace EtherpadLite;

class Response
{
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