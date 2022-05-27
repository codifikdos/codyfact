<?php

namespace CodyFact\Api\Response\Builder;

use CodyFact\Api\IContext;
use CodyFact\Api\Request\IRequest;
use CodyFact\Api\Response\BillServiceInvoiceResponse;
use CodyFact\Exception\InvalidContextException;
use Psr\Http\Message\ResponseInterface;

class ResponseBuilder implements IContext, IBuilder
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
                throw new InvalidContextException();
        }
    }

    public function getContext()
    {
        return $this->context;
    }

    public function build(IRequest $request, ResponseInterface $response, $context = null)
    {
        if (!is_null($context)) {
            $this->setContext($context);
        } else {
            $this->setContext($request->getContext());
        }

        switch ($this->context) {
            case self::CONTEXT_BILL_CONSULT_SERVICE_CDR:
                break;
            case self::CONTEXT_BILL_SERVICE_INVOICE:
                return $this->buildBillServiceInvoiceResponse($request, $response);
                break;
            case self::CONTEXT_BILL_SERVICE_RETENTION_PERCEPTION:
                break;
            case self::CONTEXT_BILL_SERVICE_GUIDE:
                break;
            default:
                return null;
        }
    }

    private function buildBillServiceInvoiceResponse(IRequest $request, ResponseInterface $response)
    {
        $data = $response->getBody()->getContents();

        $result = ($response->getStatusCode() == 200) ? true : false;

        $payment_response = new BillServiceInvoiceResponse($result, null, $data, $request);

        return $payment_response;
    }
}