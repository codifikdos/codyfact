<?php

namespace CodyFact\Api\Request;

use CodyFact\Api\IContext;

abstract class AbsRequest implements IContext
{

    protected $context;

    public function setContext($context)
    {
        switch ($context) {
            case self::CONTEXT_BILL_CONSULT_SERVICE_CDR:
                $this->context = self::CONTEXT_BILL_CONSULT_SERVICE_CDR;
                break;

            case self::CONTEXT_BILL_SERVICE_INVOICE:
                $this->context = self::CONTEXT_BILL_SERVICE_INVOICE;
                break;
            case self::CONTEXT_BILL_SERVICE_RETENTION_PERCEPTION:
                $this->context = self::CONTEXT_BILL_SERVICE_RETENTION_PERCEPTION;
                break;
            case self::CONTEXT_BILL_SERVICE_GUIDE:
                $this->context = self::CONTEXT_BILL_SERVICE_GUIDE;
                break;
            default:
        }
    }

    public function getContext()
    {
        return $this->context;
    }
}