<?php

namespace CodyFact\Env;

use CodyFact\Api\IContext;
use CodyFact\Exception\InvalidContextException;
use CodyFact\Exception\InvalidContextInSandboxException;

class Sandbox implements IEnv
{
    const STATEMENT_API_URL_INVOICE                 = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
    const STATEMENT_API_URL_RETENTION_PERCEPTION    = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService';
    const STATEMENT_API_URL_GUIDE                   = 'https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService';

    private $headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'DocName' => ''];

    private $options = ['verify' => false];

    private $test = true;

    public function __construct()
    {
    }

    public function getRequestURI($context)
    {
        switch ($context) {
            case IContext::CONTEXT_BILL_CONSULT_SERVICE_CDR:
                throw new InvalidContextInSandboxException();
                break;

            case IContext::CONTEXT_BILL_SERVICE_INVOICE:
                return self::STATEMENT_API_URL_INVOICE;
                break;
            case IContext::CONTEXT_BILL_SERVICE_RETENTION_PERCEPTION:
                return self::STATEMENT_API_URL_RETENTION_PERCEPTION;
                break;
            case IContext::CONTEXT_BILL_SERVICE_GUIDE:
                return self::STATEMENT_API_URL_GUIDE;
                break;
            default:
                throw new InvalidContextException();
        }
    }

    public function isEnvTest()
    {
        return $this->test;
    }

    public function getHTTPHeaders()
    {
        return $this->headers;
    }

    public function getHTTPOptions()
    {
        return $this->options;
    }

    public function __toString()
    {
        return 'sandbox';
    }
}