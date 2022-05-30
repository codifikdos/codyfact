<?php

namespace CodyFact\TicketInvoice\Installments;

use CodyFact\Entity\IEntity;

class Installments implements IEntity
{

    protected $description = null;
    protected $amount = null;
    protected $paymentDate = null;

    public function __construct()
    {
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    public function toArray()
    {
        return [
            'description' => $this->description,
            'amount' => $this->amount,
            'paymentDate' => $this->paymentDate,
        ];
    }
}