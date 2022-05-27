<?php

namespace CodyFact\Api\Response;

abstract class AbsResponse
{

    protected $result = false;

    protected $error = null;

    public function __construct($result = false, $error = null)
    {
        if (is_bool($result)) {
            $this->result = $result;
        }

        if (is_string($error)) {
            $this->error = $error;
        }
    }


    public function getResult()
    {
        return $this->result;
    }


    public function isSuccess()
    {
        return $this->result;
    }

    public function getError()
    {
        return $this->error;
    }
}