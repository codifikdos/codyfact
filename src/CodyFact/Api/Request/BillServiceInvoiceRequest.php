<?php

namespace CodyFact\Api\Request;

use CodyFact\CodyFact;
use CodyFact\Signature\Signature;
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

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
            <ext:UBLExtensions>
                <ext:UBLExtension>
                    <ext:ExtensionContent />
                </ext:UBLExtension>
            </ext:UBLExtensions>
            <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
            <cbc:CustomizationID>2.0</cbc:CustomizationID>
            <cbc:ID>' . $ticketInvoice->getSerie() . '-' . $ticketInvoice->getNumber() . '</cbc:ID>
            <cbc:IssueDate>' . $ticketInvoice->getDateRegister() . '</cbc:IssueDate>
            <cbc:IssueTime>' . $ticketInvoice->getTimeRegister() . '</cbc:IssueTime>
            <cbc:DueDate>' . $ticketInvoice->getDateExpiration() . '</cbc:DueDate>
            <cbc:InvoiceTypeCode listID="0101">' . $ticketInvoice->getDocType() . '</cbc:InvoiceTypeCode>
            <cbc:Note languageLocaleID="1000"><![CDATA[' . $ticketInvoice->getTotalText() . ']]></cbc:Note>
            <cbc:DocumentCurrencyCode>' . $ticketInvoice->getCurrency() . '</cbc:DocumentCurrencyCode>
            <cac:Signature>
                <cbc:ID>' . $ticketInvoice->getCompany()->getRuc() . '</cbc:ID>
                <cbc:Note><![CDATA[' . $ticketInvoice->getCompany()->getBusinessName() . ']]></cbc:Note>
                <cac:SignatoryParty>
                    <cac:PartyIdentification>
                    <cbc:ID>' . $ticketInvoice->getCompany()->getRuc() . '</cbc:ID>
                    </cac:PartyIdentification>
                    <cac:PartyName>
                    <cbc:Name><![CDATA[' . $ticketInvoice->getCompany()->getTradeName() . ']]></cbc:Name>
                    </cac:PartyName>
                </cac:SignatoryParty>
                <cac:DigitalSignatureAttachment>
                    <cac:ExternalReference>
                    <cbc:URI>#SIGN-EMPRESA</cbc:URI>
                    </cac:ExternalReference>
                </cac:DigitalSignatureAttachment>
            </cac:Signature>
            <cac:AccountingSupplierParty>
                <cac:Party>
                    <cac:PartyIdentification>
                    <cbc:ID schemeID="' . $ticketInvoice->getCompany()->getDocType() . '">' . $ticketInvoice->getCompany()->getRuc() . '</cbc:ID>
                    </cac:PartyIdentification>
                    <cac:PartyName>
                    <cbc:Name><![CDATA[' . $ticketInvoice->getCompany()->getBusinessName() . ']]></cbc:Name>
                    </cac:PartyName>
                    <cac:PartyLegalEntity>
                    <cbc:RegistrationName><![CDATA[' . $ticketInvoice->getCompany()->getTradeName() . ']]></cbc:RegistrationName>
                    <cac:RegistrationAddress>
                        <cbc:ID>' . $ticketInvoice->getCompany()->getUbigeo() . '</cbc:ID>
                        <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>
                        <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>
                        <cbc:CityName>' . $ticketInvoice->getCompany()->getProvince() . '</cbc:CityName>
                        <cbc:CountrySubentity>' . $ticketInvoice->getCompany()->getDepartment() . '</cbc:CountrySubentity>
                        <cbc:District>' . $ticketInvoice->getCompany()->getDistrict() . '</cbc:District>
                        <cac:AddressLine>
                            <cbc:Line><![CDATA[' . $ticketInvoice->getCompany()->getAddress() . ']]></cbc:Line>
                        </cac:AddressLine>
                        <cac:Country>
                            <cbc:IdentificationCode>' . $ticketInvoice->getCompany()->getCountry() . '</cbc:IdentificationCode>
                        </cac:Country>
                    </cac:RegistrationAddress>
                    </cac:PartyLegalEntity>
                </cac:Party>
            </cac:AccountingSupplierParty>
            <cac:AccountingCustomerParty>
                <cac:Party>
                    <cac:PartyIdentification>
                    <cbc:ID schemeID="' . $ticketInvoice->getCustomer()->getDocType() . '">' . $ticketInvoice->getCustomer()->getRuc() . '</cbc:ID>
                    </cac:PartyIdentification>
                    <cac:PartyLegalEntity>
                    <cbc:RegistrationName><![CDATA[' . $ticketInvoice->getCustomer()->getTradeName() . ']]></cbc:RegistrationName>
                    <cac:RegistrationAddress>
                        <cac:AddressLine>
                            <cbc:Line><![CDATA[' . $ticketInvoice->getCustomer()->getAddress() . ']]></cbc:Line>
                        </cac:AddressLine>
                        <cac:Country>
                            <cbc:IdentificationCode>' . $ticketInvoice->getCustomer()->getCountry() . '</cbc:IdentificationCode>
                        </cac:Country>
                    </cac:RegistrationAddress>
                    </cac:PartyLegalEntity>
                </cac:Party>
            </cac:AccountingCustomerParty>';

        if ($ticketInvoice->getDocType() == '01') {
            if ($ticketInvoice->getPayType() == 'Contado') {
                $xml = $xml . '<cac:PaymentTerms>
                                        <cbc:ID>FormaPago</cbc:ID>
                                        <cbc:PaymentMeansID>' . $ticketInvoice->getPayType() . '</cbc:PaymentMeansID>
                                </cac:PaymentTerms>';
            }

            if ($ticketInvoice->getPayType() == 'Credito') {
                $xml = $xml . '<cac:PaymentTerms>
                                        <cbc:ID>FormaPago</cbc:ID>
                                        <cbc:PaymentMeansID>' . $ticketInvoice->getPayType() . '</cbc:PaymentMeansID>
                                        <cbc:Amount currencyID="PEN">' . $ticketInvoice->getAmountSlope() . '</cbc:Amount>
                                </cac:PaymentTerms>';

                foreach (array() as $value) {
                    $xml = $xml .
                        '<cac:PaymentTerms>
                                <cbc:ID>FormaPago</cbc:ID>
                                <cbc:PaymentMeansID>' . $value['cuota'] . '</cbc:PaymentMeansID>
                                <cbc:Amount currencyID="PEN">' . $value['monto'] . '</cbc:Amount>
                                <cbc:PaymentDueDate>' . $value['fecha'] . '</cbc:PaymentDueDate>
                            </cac:PaymentTerms>';
                }
            }
        }

        $xml = $xml . '<cac:TaxTotal>
                <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . ($ticketInvoice->getAmountTax() + $ticketInvoice->getAmountIcbper()) . '</cbc:TaxAmount>';

        if ($ticketInvoice->getAmountRecorded() > 0) {
            $xml .= '<cac:TaxSubtotal>
                        <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountRecorded() . '</cbc:TaxableAmount>
                        <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountTax() . '</cbc:TaxAmount>
                        <cac:TaxCategory>
                        <cac:TaxScheme>
                            <cbc:ID>1000</cbc:ID>
                            <cbc:Name>IGV</cbc:Name>
                            <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                        </cac:TaxCategory>
                    </cac:TaxSubtotal>';
        }

        if ($ticketInvoice->getAmountExonerated() > 0) {
            $xml .= '<cac:TaxSubtotal>
                    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountExonerated() . '</cbc:TaxableAmount>
                    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">0.00</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                        <cac:TaxScheme>
                            <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>
                            <cbc:Name>EXO</cbc:Name>
                            <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                    </cac:TaxSubtotal>';
        }

        if ($ticketInvoice->getAmountUnaffected() > 0) {
            $xml .= '<cac:TaxSubtotal>
                    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountUnaffected() . '</cbc:TaxableAmount>
                    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">0.00</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>
                        <cac:TaxScheme>
                            <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>
                            <cbc:Name>INA</cbc:Name>
                            <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                    </cac:TaxSubtotal>';
        }

        if ($ticketInvoice->getAmountIcbper() > 0) {
            $xml .= '<cac:TaxSubtotal>
                    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountIcbper() . '</cbc:TaxAmount>
                    <cac:TaxCategory>
                        <cac:TaxScheme>
                            <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">7152</cbc:ID>
                            <cbc:Name>ICBPER</cbc:Name>
                            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                        </cac:TaxScheme>
                    </cac:TaxCategory>
                </cac:TaxSubtotal>';
        }

        $total_antes_de_impuestos = $ticketInvoice->getAmountRecorded() + $ticketInvoice->getAmountExonerated() + $ticketInvoice->getAmountUnaffected();

        $xml .= '</cac:TaxTotal>
            <cac:LegalMonetaryTotal>
                <cbc:LineExtensionAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $total_antes_de_impuestos . '</cbc:LineExtensionAmount>
                <cbc:TaxInclusiveAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountTotal() . '</cbc:TaxInclusiveAmount>
                <cbc:PayableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountTotal() . '</cbc:PayableAmount>
            </cac:LegalMonetaryTotal>';

        foreach ($ticketInvoice->getDetail() as $item) {

            $xml .= '<cac:InvoiceLine>
                    <cbc:ID>' . $item->getItemId() . '</cbc:ID>
                    <cbc:InvoicedQuantity unitCode="' . $item->getItemUnid() . '">' . $item->getItemQty() . '</cbc:InvoicedQuantity>
                    <cbc:LineExtensionAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemPriceWithoutTax() . '</cbc:LineExtensionAmount>
                    <cac:PricingReference>
                        <cac:AlternativeConditionPrice>
                        <cbc:PriceAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemPrice() . '</cbc:PriceAmount>
                        <cbc:PriceTypeCode>' . $item->getItemTypePrice() . '</cbc:PriceTypeCode>
                        </cac:AlternativeConditionPrice>
                    </cac:PricingReference>';


            if ($item->getItemWithBag() == 'SI') {
                $xml .= '<cac:TaxTotal>
                            <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . ($item->getItemQty() * 0.40 + $item->getItemTax()) . '</cbc:TaxAmount>
                            <cac:TaxSubtotal>
                                    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTotalWithoutTax() . '</cbc:TaxableAmount>
                                    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTax() . '</cbc:TaxAmount>
                                    <cac:TaxCategory>
                                    <cbc:Percent>' . $item->getItemTaxPercent() . '</cbc:Percent>
                                    <cbc:TaxExemptionReasonCode>' . $item->getItemTypeAffectTax() . '</cbc:TaxExemptionReasonCode>
                                    <cac:TaxScheme>
                                        <cbc:ID>' . $item->getItemCodeTypeTribute() . '</cbc:ID>
                                        <cbc:Name>' . $item->getItemNameTribute() . '</cbc:Name>
                                        <cbc:TaxTypeCode>' . $item->getItemTypeTribute() . '</cbc:TaxTypeCode>
                                    </cac:TaxScheme>
                                    </cac:TaxCategory>
                            </cac:TaxSubtotal>
                            <cac:TaxSubtotal>
                                <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . ($item->getItemQty() * 0.40) . '</cbc:TaxAmount>                    
                                <cbc:BaseUnitMeasure unitCode="' . $item->getItemUnid() . '">' . $item->getItemQty() . '</cbc:BaseUnitMeasure>
                                <cac:TaxCategory>                 
                                    <cbc:PerUnitAmount currencyID="PEN">0.40</cbc:PerUnitAmount>                                
                                    <cac:TaxScheme>
                                        <cbc:ID schemeName="Codigo de tributos" schemeAgencyName="PE:SUNAT" >7152</cbc:ID>
                                        <cbc:Name>ICBPER</cbc:Name>
                                        <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>                    
                                    </cac:TaxScheme>                    
                                </cac:TaxCategory>                    
                            </cac:TaxSubtotal>';
            } else {
                $xml .= '<cac:TaxTotal>
                    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTax() . '</cbc:TaxAmount>
                    <cac:TaxSubtotal>
                        <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTotalWithoutTax() . '</cbc:TaxableAmount>
                        <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTax() . '</cbc:TaxAmount>
                        <cac:TaxCategory>
                            <cbc:Percent>' . $item->getItemTaxPercent() . '</cbc:Percent>
                            <cbc:TaxExemptionReasonCode>' . $item->getItemTypeAffectTax() . '</cbc:TaxExemptionReasonCode>
                            <cac:TaxScheme>
                                <cbc:ID>' . $item->getItemCodeTypeTribute() . '</cbc:ID>
                                <cbc:Name>' . $item->getItemNameTribute() . '</cbc:Name>
                                <cbc:TaxTypeCode>' . $item->getItemTypeTribute() . '</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                    </cac:TaxSubtotal>';
            }


            $xml .= '</cac:TaxTotal>
                    <cac:Item>
                        <cbc:Description><![CDATA[' . $item->getItemDescription() . ']]></cbc:Description>
                        <cac:SellersItemIdentification>
                        <cbc:ID>' . $item->getItemCode() . '</cbc:ID>
                        </cac:SellersItemIdentification>
                    </cac:Item>
                    <cac:Price>
                        <cbc:PriceAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemPriceWithoutTax() . '</cbc:PriceAmount>
                    </cac:Price>
                </cac:InvoiceLine>';

        }

        $xml .= "</Invoice>";
        $doc->loadXML($xml);

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

        $zip_codificado = base64_encode(file_get_contents($ruta_zip));
        $file_name_zip = $filename . '.zip';

        $xml_envelope = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"
        xmlns:ser="http://service.sunat.gob.pe" xmlns:wsse="http://docs.oasisopen.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
         <soapenv:Header>
            <wsse:Security>
                <wsse:UsernameToken>
                    <wsse:Username>' . $this->getTicketInvoice()->getCompany()->getRuc() . $credentials['apiUsername'] . '</wsse:Username>
                    <wsse:Password>' . $credentials['apiPasssword'] . '</wsse:Password>
                </wsse:UsernameToken>
            </wsse:Security>
         </soapenv:Header>
         <soapenv:Body>
            <ser:sendBill>
                <fileName>' . $file_name_zip . '</fileName>
                <contentFile>' . $zip_codificado . '</contentFile>
            </ser:sendBill>
         </soapenv:Body>
        </soapenv:Envelope>';

        return [
            'body' => $xml_envelope,
            'signature' => $signature
        ];

    }

}