<?php

namespace CodyFact\TicketInvoice\Person;

abstract class AbsPerson
{

    protected $docType = null;

    protected $ruc = null;

    protected $tradeName = null;

    protected $address = null;

    protected $country = null;

    public function getDocType()
    {
        return $this->docType;
    }

    public function setDocType($docType)
    {
        $this->docType = $docType;
    }

    public function getRuc()
    {
        return $this->ruc;
    }

    public function setRuc($ruc)
    {
        $this->ruc = $ruc;
    }

    public function getTradeName()
    {
        return $this->tradeName;
    }

    public function setTradeName($tradeName)
    {
        $this->tradeName = $tradeName;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }


}