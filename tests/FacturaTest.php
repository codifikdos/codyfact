<?php

namespace Codifikdos\CodyFactSDK\Tests;

use CodyFact\CodyFact;
use CodyFact\Merchant\Credentials;
use CodyFact\TicketInvoice\Detail\Detail;
use CodyFact\TicketInvoice\Person\Company;
use CodyFact\TicketInvoice\Person\Customer;
use CodyFact\TicketInvoice\TicketInvoice;
use PHPUnit\Framework\TestCase;

class FacturaTest extends TestCase
{
    /**
     * @test
     */
    public function itSendFactura()
    {
        putenv("CODYFACT_PATH_CERTIFICATE=" . __DIR__ . '/CERTIFICADO-DEMO.pfx');
        putenv("CODYFACT_PATH_ROOT=" . __DIR__);

        $credentials = Credentials::factory('MODDATOS', 'MODDATOS');

        $codyFact = CodyFact::factory(CodyFact::LANGUAGE_SPANISH, CodyFact::ENV_SANDBOX);

        $codyFact->setCredentials($credentials);

        $company = new Company();
        $company->setDocType('6');
        $company->setRuc('20123456789');
        $company->setTradeName('CETI ORG');
        $company->setBusinessName('CETI');
        $company->setAddress('VIRTUAL');
        $company->setUbigeo('130101');
        $company->setDepartment('LAMBAYEQUE');
        $company->setProvince('CHICLAYO');
        $company->setDistrict('CHICLAYO');
        $company->setCountry('PE');

        $customer = new Customer();
        $customer->setDocType('6');
        $customer->setRuc('10123456789');
        $customer->setTradeName('CLIENTE DE PRUEBA');
        $customer->setAddress('VIRTUAL');
        $customer->setCountry('PE');

        $detail = array();

        $item = new Detail();
        $item->setItemId(1);
        $item->setItemCode('COD01');
        $item->setItemDescription('LAPTOP HP');
        $item->setItemQty(1);
        $item->setItemPriceWithoutTax(1016.95);
        $item->setItemPrice(1200);
        $item->setItemTypePrice('01');
        $item->setItemTax(183.05);
        $item->setItemTaxPercent(18);
        $item->setItemTotalWithoutTax(1016.95);
        $item->setItemTotal(1200.00);
        $item->setItemUnid('NIU');
        $item->setItemTypeAffectTax('10');
        $item->setItemCodeTypeTribute('1000');
        $item->setItemTypeTribute('VAT');
        $item->setItemNameTribute('IGV');
        $item->setItemWithBag('NO');

        $detail[] = $item;

        $ticketInvoice = new TicketInvoice();

        $ticketInvoice->setCompany($company);
        $ticketInvoice->setCustomer($customer);
        $ticketInvoice->setDetail($detail);

        $ticketInvoice->setDocType('03');
        $ticketInvoice->setSerie('B001');
        $ticketInvoice->setNumber('500');
        $ticketInvoice->setDateRegister(date('Y-m-d'));
        $ticketInvoice->setTimeRegister(date('H:i:s'));
        $ticketInvoice->setDateExpiration(date('Y-m-d'));
        $ticketInvoice->setCurrency('PEN');

//Inicializamos variables
        $total_opgravadas = 0.00;
        $total_opexoneradas = 0.00;
        $total_opinafectas = 0.00;
        $total_impbolsas = 0.00;
        $igv = 0.00;
        $total = 0.00;

        foreach ($detail as $value) {
            if ($value->itemTypeAffectTax == 10) { //OP GRAVADAS
                $total_opgravadas += $value->itemTotalWithoutTax;
            }
            if ($value->itemTypeAffectTax == 20) { //OP EXONERADAS
                $total_opexoneradas += $value->itemTotalWithoutTax;
            }
            if ($value->itemTypeAffectTax == 30) { //OP INAFECTAS
                $total_opinafectas += $value->itemTotalWithoutTax;
            }

            $igv += $value->itemTax;
            $total += $value->itemTotal + $total_impbolsas;
        }

        $ticketInvoice->setAmountRecorded($total_opgravadas);
        $ticketInvoice->setAmountExonerated($total_opexoneradas);
        $ticketInvoice->setAmountUnaffected($total_opinafectas);
        $ticketInvoice->setAmountIcbper($total_impbolsas);
        $ticketInvoice->setAmountTax($igv);
        $ticketInvoice->setAmountTotal($total);
        $ticketInvoice->setTotalText('test');
        $ticketInvoice->setPayType('');
        $ticketInvoice->setAmountSlope(0);

        $response = $codyFact->sendTicketInvoice($ticketInvoice);

        var_dump($response);

    }
}