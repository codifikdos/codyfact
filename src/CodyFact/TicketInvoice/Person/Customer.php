<?php

namespace CodyFact\TicketInvoice\Person;

use CodyFact\Entity\IEntity;

class Customer extends AbsPerson implements IEntity
{

    public function __construct()
    {
    }

    public function toArray()
    {
        return [
            'docType' => $this->docType,
            'ruc' => $this->ruc,
            'tradeName' => $this->tradeName,
            'address' => $this->address,
            'country ' => $this->country,
        ];
    }
}