<?php

namespace CodyFact\Api\Response;

use CodyFact\Entity\IEntity;

class BillServiceInvoiceResponse extends AbsResponse implements \Serializable, IEntity
{

    /**
     * Available statuses
     */
    const STATE_PENDING = 'PENDING';
    const STATE_APPROVED = 'APPROVED';
    const STATE_DECLINED = 'DECLINED';
    const STATE_APPROVED_WITH_OBS = 'APPROVED_WITH_OBS';

    /**
     * The hash
     *
     * @var string
     */
    protected $hash = null;

    /**
     * The response message
     *
     * @var string
     */
    protected $responseMessage = null;

    /**
     * The state
     *
     * @var string
     */
    protected $state = null;

    /**
     * The error code
     *
     * @var string
     */
    protected $errorCode = null;

    public function __construct($result = false, $error = null, $options = array())
    {
        parent::__construct($result, $error);
        if ($result) {
            $contents = $options['contents'];
            $signature = $options['signature'];
            $ticketInvoice = $options['ticketInvoice'];

            $data = new \DOMDocument();
            $data->loadXML($contents);
            if (isset($data->getElementsByTagName('applicationResponse')->item(0)->nodeValue)) {
                $cdr = $data->getElementsByTagName('applicationResponse')->item(0)->nodeValue;
                $this->compressCDR($cdr, $signature['hash_cpe'], $this->getDocName($ticketInvoice));
            } else {
                $this->state = self::STATE_DECLINED;
                $this->errorCode = $data->getElementsByTagName('faultcode')->item(0)->nodeValue;
                $this->responseMessage = $data->getElementsByTagName('faultstring')->item(0)->nodeValue;
            }

        }

        return $this;
    }

    private function getDocName($ticketInvoice)
    {
        $company = $ticketInvoice->getCompany();
        return $company->getRuc() . '-' . $ticketInvoice->getDocType() . '-' . $ticketInvoice->getSerie() . '-' . $ticketInvoice->getNumber();
    }

    private function compressCDR($cdr, $hash, $filename)
    {
        $cdrBase64 = base64_decode($cdr);
        $pahtCDR = getenv('CODYFACT_PATH_CDR');

        file_put_contents($pahtCDR . 'R-' . $filename . '.zip', $cdrBase64);

        $zip = new \ZipArchive();
        if ($zip->open($pahtCDR . 'R-' . $filename . '.zip') == true) {
            $zip->extractTo($pahtCDR);
            $zip->close();

            $this->state = self::STATE_APPROVED;
            $this->hash = $hash;

            $xml_cdr = $pahtCDR . 'R-' . $filename . '.xml';
            $data = new \DOMDocument();
            $data->loadXML(file_get_contents($xml_cdr));

            if (isset($data->getElementsByTagName('Description')->item(0)->nodeValue)) {
                $this->responseMessage = $data->getElementsByTagName('Description')->item(0)->nodeValue;
            }

            if (isset($data->getElementsByTagName('Note')->item(0)->nodeValue)) {
                $this->state = self::STATE_APPROVED_WITH_OBS;
                $this->responseMessage .= '. ' . $data->getElementsByTagName('Note')->item(0)->nodeValue;
            }

        }
    }

    public function isPending()
    {
        return $this->state == self::STATE_PENDING;
    }

    public function isApproved()
    {
        return $this->state == self::STATE_APPROVED || $this->state == self::STATE_APPROVED_WITH_OBS;
    }

    public function isDeclined()
    {
        return $this->state == self::STATE_DECLINED;
    }

    public function isApprovedWithObs()
    {
        return $this->state == self::STATE_APPROVED_WITH_OBS;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getResponseMessage()
    {
        return $this->responseMessage;
    }

    public function setResponseMessage($responseMessage)
    {
        $this->responseMessage = $responseMessage;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }

    public function serialize()
    {
        return serialize([
            $this->result,
            $this->error,
            $this->hash,
            $this->responseMessage,
            $this->state,
            $this->errorCode,
        ]);
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);
        list(
            $this->result,
            $this->error,
            $this->hash,
            $this->responseMessage,
            $this->state,
            $this->errorCode,
            ) = $data;

        return $this;
    }

    public function toArray()
    {
        return [
            'result' => $this->result,
            'error' => $this->error,
            'hash' => $this->hash,
            'responseMessage' => $this->responseMessage,
            'state' => $this->state,
            'errorCode' => $this->errorCode,
        ];
    }
}