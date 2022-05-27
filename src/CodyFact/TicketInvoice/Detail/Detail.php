<?php

namespace CodyFact\TicketInvoice\Detail;

use CodyFact\Entity\IEntity;

class Detail implements IEntity
{

    protected $itemId = null;
    protected $itemCode = null;
    protected $itemDescription = null;
    protected $itemQty = null;
    protected $itemPriceWithoutTax = null;
    protected $itemPrice = null;
    protected $itemTypePrice = null;
    public $itemTax = null;
    protected $itemTaxPercent = null;
    public $itemTotalWithoutTax = null;
    public $itemTotal = null;
    protected $itemUnid = null;
    public $itemTypeAffectTax = null;
    protected $itemCodeTypeTribute = null;
    protected $itemTypeTribute = null;
    protected $itemNameTribute = null;
    protected $itemWithBag = null;

    public function __construct()
    {
    }

    public function getItemId()
    {
        return $this->itemId;
    }

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

    public function getItemCode()
    {
        return $this->itemCode;
    }

    public function setItemCode($itemCode)
    {
        $this->itemCode = $itemCode;
    }

    public function getItemDescription()
    {
        return $this->itemDescription;
    }

    public function setItemDescription($itemDescription)
    {
        $this->itemDescription = $itemDescription;
    }

    public function getItemQty()
    {
        return $this->itemQty;
    }

    public function setItemQty($itemQty)
    {
        $this->itemQty = $itemQty;
    }

    public function getItemPriceWithoutTax()
    {
        return $this->itemPriceWithoutTax;
    }

    public function setItemPriceWithoutTax($itemPriceWithoutTax)
    {
        $this->itemPriceWithoutTax = $itemPriceWithoutTax;
    }

    public function getItemPrice()
    {
        return $this->itemPrice;
    }

    public function setItemPrice($itemPrice)
    {
        $this->itemPrice = $itemPrice;
    }

    public function getItemTypePrice()
    {
        return $this->itemTypePrice;
    }

    public function setItemTypePrice($itemTypePrice)
    {
        $this->itemTypePrice = $itemTypePrice;
    }

    public function getItemTax()
    {
        return $this->itemTax;
    }

    public function setItemTax($itemTax)
    {
        $this->itemTax = $itemTax;
    }

    public function getItemTaxPercent()
    {
        return $this->itemTaxPercent;
    }

    public function setItemTaxPercent($itemTaxPercent)
    {
        $this->itemTaxPercent = $itemTaxPercent;
    }

    public function getItemTotalWithoutTax()
    {
        return $this->itemTotalWithoutTax;
    }

    public function setItemTotalWithoutTax($itemTotalWithoutTax)
    {
        $this->itemTotalWithoutTax = $itemTotalWithoutTax;
    }

    public function getItemTotal()
    {
        return $this->itemTotal;
    }

    public function setItemTotal($itemTotal)
    {
        $this->itemTotal = $itemTotal;
    }

    public function getItemUnid()
    {
        return $this->itemUnid;
    }

    public function setItemUnid($itemUnid)
    {
        $this->itemUnid = $itemUnid;
    }

    public function getItemTypeAffectTax()
    {
        return $this->itemTypeAffectTax;
    }

    public function setItemTypeAffectTax($itemTypeAffectTax)
    {
        $this->itemTypeAffectTax = $itemTypeAffectTax;
    }

    public function getItemCodeTypeTribute()
    {
        return $this->itemCodeTypeTribute;
    }

    public function setItemCodeTypeTribute($itemCodeTypeTribute)
    {
        $this->itemCodeTypeTribute = $itemCodeTypeTribute;
    }

    public function getItemTypeTribute()
    {
        return $this->itemTypeTribute;
    }

    public function setItemTypeTribute($itemTypeTribute)
    {
        $this->itemTypeTribute = $itemTypeTribute;
    }

    public function getItemNameTribute()
    {
        return $this->itemNameTribute;
    }

    public function setItemNameTribute($itemNameTribute)
    {
        $this->itemNameTribute = $itemNameTribute;
    }

    public function getItemWithBag()
    {
        return $this->itemWithBag;
    }

    public function setItemWithBag($itemWithBag)
    {
        $this->itemWithBag = $itemWithBag;
    }


    public function toArray()
    {
        return [
            'itemId' => $this->itemId,
            'itemCode' => $this->itemCode,
            'itemDescription' => $this->itemDescription,
            'itemQty' => $this->itemQty,
            'itemPriceWithoutTax' => $this->itemPriceWithoutTax,
            'itemPrice' => $this->itemPrice,
            'itemTypePrice' => $this->itemTypePrice,
            'itemTax' => $this->itemTax,
            'itemTaxPercent' => $this->itemTaxPercent,
            'itemTotalWithoutTax' => $this->itemTotalWithoutTax,
            'itemTotal' => $this->itemTotal,
            'itemUnid' => $this->itemUnid,
            'itemTypeAffectTax' => $this->itemTypeAffectTax,
            'itemCodeTypeTribute' => $this->itemCodeTypeTribute,
            'itemTypeTribute' => $this->itemTypeTribute,
            'itemNameTribute' => $this->itemNameTribute,
            'itemWithBag' => $this->itemWithBag,
        ];
    }
}