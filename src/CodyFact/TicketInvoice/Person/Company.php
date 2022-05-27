<?php

namespace CodyFact\TicketInvoice\Person;

use CodyFact\Entity\IEntity;

class Company extends AbsPerson implements IEntity
{

    protected $businessName = null;
    protected $ubigeo = null;
    protected $department = null;
    protected $province = null;
    protected $district = null;

    public function __construct()
    {
    }

    public function getBusinessName()
    {
        return $this->businessName;
    }

    public function setBusinessName($businessName)
    {
        $this->businessName = $businessName;
    }

    public function getUbigeo()
    {
        return $this->ubigeo;
    }

    public function setUbigeo($ubigeo)
    {
        $this->ubigeo = $ubigeo;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function setDepartment($department)
    {
        $this->department = $department;
    }

    public function getProvince()
    {
        return $this->province;
    }

    public function setProvince($province)
    {
        $this->province = $province;
    }

    public function getDistrict()
    {
        return $this->district;
    }

    public function setDistrict($district)
    {
        $this->district = $district;
    }

    public function toArray()
    {
        return [
            'docType' => $this->docType,
            'ruc' => $this->ruc,
            'businessName' => $this->businessName,
            'tradeName' => $this->tradeName,
            'ubigeo' => $this->ubigeo,
            'department' => $this->department,
            'province' => $this->province,
            'district' => $this->district,
            'address' => $this->address,
            'country ' => $this->country,
        ];
    }
}