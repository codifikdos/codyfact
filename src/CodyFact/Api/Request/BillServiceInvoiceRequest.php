<?php

namespace CodyFact\Api\Request;

use CodyFact\CodyFact;
use CodyFact\Signature\Signature;
use CodyFact\TemplateGenerator\XMLService;
use CodyFact\TicketInvoice\TicketInvoice;

class BillServiceInvoiceRequest extends AbsRequest implements IRequest
{

    private $command;
    /**
     * The ticketInvoice
     *
     * @var TicketInvoice
     */
    private $ticketinvoice = null;
    /**
     * The signature
     *
     * @var object
     */
    private $signature = null;

    /**
     * The body
     *
     * @var string
     */
    private $body = null;

    public function __construct($command)
    {
        $this->command = (string)$command;
        $this->setContext(self::CONTEXT_BILL_SERVICE_INVOICE);
    }

    public function setTicketInvoice(TicketInvoice $ticketinvoice)
    {
        $this->ticketinvoice = $ticketinvoice;
    }

    public function getTicketInvoice()
    {
        return $this->ticketinvoice;
    }

    public function getSignature()
    {
        return $this->signature;
    }

    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function compilePayload(CodyFact $codyFact)
    {
        $credentials = $codyFact->getCredentials();
        $nameFileXML = $this->getDocName();
        $this->createTicketInvoiceXML($nameFileXML, $this->getTicketInvoice());
        $signature = $this->signXML($nameFileXML, $credentials);
        $this->setSignature($signature['signature']);
        $this->setBody($signature['body']);
    }

    public function compile(CodyFact $codyFact)
    {
        return $this->getBody();
    }

    public function getDocName()
    {
        return $this->getTicketInvoice()->getCompany()->getRuc()
            . "-" . $this->getTicketInvoice()->getDocType()
            . "-" . $this->getTicketInvoice()->getSerie()
            . "-" . $this->getTicketInvoice()->getNumber();
    }

    public function createTicketInvoiceXML($fileXML, TicketInvoice $ticketInvoice)
    {
        $doc = new \DOMDocument();
        $doc->formatOutput = false;
        $doc->preserveWhiteSpace = true;
        $doc->encoding = 'utf-8';

        $doc->loadXML(XMLService::generateInvoice($ticketInvoice));

        $fileName = getenv('CODYFACT_PATH_XML') . $fileXML . '.xml';
        $doc->save($fileName);
    }

    public function signXML($filename, $credentials)
    {
        $pahtXML = getenv('CODYFACT_PATH_XML');
        $credentials = $credentials();
        $signature = new Signature();
        $signature = $signature->signXML($pahtXML . $filename . '.xml', 'ceti');

        $zip = new \ZipArchive();
        $ruta_zip = $pahtXML . $filename . '.zip';

        if ($zip->open($ruta_zip, \ZipArchive::CREATE) == true) {
            $zip->addFile($pahtXML . $filename . '.xml', $filename . '.xml');
            $zip->close();
        }

        return [
            'body' => XMLService::generateEnvelopeDoc(
                $this->getTicketInvoice()->getCompany()->getRuc(), $credentials, $filename . '.zip', base64_encode(file_get_contents($ruta_zip))
            ),
            'signature' => $signature
        ];

    }

}