<?php

namespace CodyFact\TicketInvoice;

use CodyFact\Entity\IEntity;
use CodyFact\TicketInvoice\Detail\Detail;
use CodyFact\TicketInvoice\Detail\Installments;
use CodyFact\TicketInvoice\Person\Company;
use CodyFact\TicketInvoice\Person\Customer;

class TicketInvoice implements IEntity
{

    /**
     * The company
     *
     * @var Company
     */
    protected $company = null;
    /**
     * The customer
     *
     * @var Customer
     */
    protected $customer = null;

    /**
     * The detail
     *
     * @var Detail array()
     */
    protected $detail = array();

    /**
     * The installments
     *
     * @var Installments array()
     */
    protected $installments = array();

    protected $docType = null;
    protected $serie = null;
    protected $number = null;
    protected $dateRegister = null;
    protected $timeRegister = null;
    protected $dateExpiration = null;
    protected $currency = null;
    protected $amountRecorded = null;
    protected $amountExonerated = null;
    protected $amountUnaffected = null;
    protected $amountIcbper = null;
    protected $amountTax = null;
    protected $amountTotal = null;
    protected $totalText = null;
    protected $payType = null;
    protected $amountSlope = null;

    public function __construct()
    {
    }

    /**
     *
     * Get the company
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set the company
     *
     * @param Company $company
     * @return TicketInvoice
     */
    public function setCompany($company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Get the customer
     *
     * @return Customer
     */

    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the customer
     *
     * @param Customer $customer
     * @return TicketInvoice
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * Get the detail
     *
     * @return Detail array()
     */

    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set the detail
     *
     * @param Detail array() $detail
     * @return TicketInvoice
     */

    public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }

    /**
     * Get the installments
     *
     * @return Installments array()
     */

    public function getInstallments()
    {
        return $this->installments;
    }

    /**
     * Set the installments
     *
     * @param Installments array() $installments
     * @return TicketInvoice
     */

    public function setInstallments($installments)
    {
        $this->installments = $installments;
        return $this;
    }

    public function getDocType()
    {
        return $this->docType;
    }

    public function setDocType($docType)
    {
        $this->docType = $docType;
    }

    public function getSerie()
    {
        return $this->serie;
    }

    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function setNumber($number)
    {
        $this->number = $number;
    }

    public function getDateRegister()
    {
        return $this->dateRegister;
    }

    public function setDateRegister($dateRegister)
    {
        $this->dateRegister = $dateRegister;
    }

    public function getTimeRegister()
    {
        return $this->timeRegister;
    }

    public function setTimeRegister($timeRegister)
    {
        $this->timeRegister = $timeRegister;
    }

    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;
    }

    public function getCurrency()
    {
        return $this->currency;
    }

    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function getAmountRecorded()
    {
        return $this->amountRecorded;
    }

    public function setAmountRecorded($amountRecorded)
    {
        $this->amountRecorded = $amountRecorded;
    }

    public function getAmountExonerated()
    {
        return $this->amountExonerated;
    }

    public function setAmountExonerated($amountExonerated)
    {
        $this->amountExonerated = $amountExonerated;
    }

    public function getAmountUnaffected()
    {
        return $this->amountUnaffected;
    }

    public function setAmountUnaffected($amountUnaffected)
    {
        $this->amountUnaffected = $amountUnaffected;
    }

    public function getAmountIcbper()
    {
        return $this->amountIcbper;
    }

    public function setAmountIcbper($amountIcbper)
    {
        $this->amountIcbper = $amountIcbper;
    }

    public function getAmountTax()
    {
        return $this->amountTax;
    }

    public function setAmountTax($amountTax)
    {
        $this->amountTax = $amountTax;
    }

    public function getAmountTotal()
    {
        return $this->amountTotal;
    }

    public function setAmountTotal($amountTotal)
    {
        $this->amountTotal = $amountTotal;
    }

    public function getTotalText()
    {
        return $this->totalText;
    }

    public function setTotalText($totalText)
    {
        $this->totalText = $totalText;
    }

    public function getPayType()
    {
        return $this->payType;
    }

    public function setPayType($payType)
    {
        $this->payType = $payType;
    }

    public function getAmountSlope()
    {
        return $this->amountSlope;
    }

    public function setAmountSlope($amountSlope)
    {
        $this->amountSlope = $amountSlope;
    }

    public function toArray()
    {
        return [
            'company' => $this->company->toArray(),
            'customer' => $this->customer->toArray(),
            'detail' => $this->detail,
            'installments' => $this->installments,
            'docType' => $this->docType,
            'serie' => $this->serie,
            'number' => $this->number,
            'dateRegister' => $this->dateRegister,
            'timeRegister' => $this->timeRegister,
            'dateExpiration ' => $this->dateExpiration,
            'currency' => $this->currency,
            'amountRecorded' => $this->amountRecorded,
            'amountExonerated' => $this->amountExonerated,
            'amountUnaffected ' => $this->amountUnaffected,
            'amountIcbper ' => $this->amountIcbper,
            'amountTax ' => $this->amountTax,
            'amountTotal ' => $this->amountTotal,
            'totalText ' => $this->totalText,
            'payType ' => $this->payType,
            'amountSlope ' => $this->amountSlope,
        ];
    }
}