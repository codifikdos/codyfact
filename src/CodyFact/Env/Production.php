<?php

namespace CodyFact\Env;

use CodyFact\Api\IContext;
use CodyFact\Exception\InvalidContextException;

class Production implements IEnv
{
    const QUERY_API_URL_CDR                         = 'https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService';

    const STATEMENT_API_URL_INVOICE                 = 'https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService';
    const STATEMENT_API_URL_RETENTION_PERCEPTION    = 'https://e-factura.sunat.gob.pe/ol-ti-itemision-otroscpe-gem/billService';
    const STATEMENT_API_URL_GUIDE                   = 'https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService';

    private $headers = ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'DocName' => ''];

    private $options = [];

    private $test = false;

    public function __construct()
    {
    }

    public function getRequestURI($context)
    {
        switch ($context) {
            case IContext::CONTEXT_BILL_CONSULT_SERVICE_CDR:
                return self::QUERY_API_URL_CDR;
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
        return 'production';
    }
}