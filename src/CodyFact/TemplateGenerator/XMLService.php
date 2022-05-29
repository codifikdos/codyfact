<?php

namespace CodyFact\TemplateGenerator;

class XMLService
{
    public static function generateEnvelopeDoc($ruc, $credentials, $file_name_zip, $zip_codificado)
    {
        $__envelope = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"' . PHP_EOL;
        $__envelope .= '          xmlns:ser="http://service.sunat.gob.pe"' . PHP_EOL;
        $__envelope .= '          xmlns:wsse="http://docs.oasisopen.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">' . PHP_EOL;
        $__envelope .= '    <soapenv:Header>' . PHP_EOL;
        $__envelope .= '        <wsse:Security>' . PHP_EOL;
        $__envelope .= '            <wsse:UsernameToken>' . PHP_EOL;
        $__envelope .= '                <wsse:Username>' . $ruc . $credentials['apiUsername'] . '</wsse:Username>' . PHP_EOL;
        $__envelope .= '                <wsse:Password>' . $credentials['apiPasssword'] . '</wsse:Password>' . PHP_EOL;
        $__envelope .= '            </wsse:UsernameToken>' . PHP_EOL;
        $__envelope .= '        </wsse:Security>' . PHP_EOL;
        $__envelope .= '    </soapenv:Header>' . PHP_EOL;
        $__envelope .= '    <soapenv:Body>' . PHP_EOL;
        $__envelope .= '        <ser:sendBill>' . PHP_EOL;
        $__envelope .= '            <fileName>' . $file_name_zip . '</fileName>' . PHP_EOL;
        $__envelope .= '            <contentFile>' . $zip_codificado . '</contentFile>' . PHP_EOL;
        $__envelope .= '        </ser:sendBill>' . PHP_EOL;
        $__envelope .= '    </soapenv:Body>' . PHP_EOL;
        $__envelope .= '</soapenv:Envelope>' . PHP_EOL;

        return $__envelope;
    }

    public static function generateInvoice($ticketInvoice)
    {
        $__invoice = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $__invoice .= '<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">' . PHP_EOL;
        $__invoice .= '            <ext:UBLExtensions>' . PHP_EOL;
        $__invoice .= '                <ext:UBLExtension>' . PHP_EOL;
        $__invoice .= '                    <ext:ExtensionContent />' . PHP_EOL;
        $__invoice .= '                </ext:UBLExtension>' . PHP_EOL;
        $__invoice .= '            </ext:UBLExtensions>' . PHP_EOL;
        $__invoice .= '            <cbc:UBLVersionID>2.1</cbc:UBLVersionID>' . PHP_EOL;
        $__invoice .= '            <cbc:CustomizationID>2.0</cbc:CustomizationID>' . PHP_EOL;
        $__invoice .= '            <cbc:ID>' . $ticketInvoice->getSerie() . '-' . $ticketInvoice->getNumber() . '</cbc:ID>' . PHP_EOL;
        $__invoice .= '            <cbc:IssueDate>' . $ticketInvoice->getDateRegister() . '</cbc:IssueDate>' . PHP_EOL;
        $__invoice .= '            <cbc:IssueTime>' . $ticketInvoice->getTimeRegister() . '</cbc:IssueTime>' . PHP_EOL;
        $__invoice .= '            <cbc:DueDate>' . $ticketInvoice->getDateExpiration() . '</cbc:DueDate>' . PHP_EOL;
        $__invoice .= '            <cbc:InvoiceTypeCode listID="0101">' . $ticketInvoice->getDocType() . '</cbc:InvoiceTypeCode>' . PHP_EOL;
        $__invoice .= '            <cbc:Note languageLocaleID="1000"><![CDATA[' . $ticketInvoice->getTotalText() . ']]></cbc:Note>' . PHP_EOL;
        $__invoice .= '            <cbc:DocumentCurrencyCode>' . $ticketInvoice->getCurrency() . '</cbc:DocumentCurrencyCode>' . PHP_EOL;
        $__invoice .= '            <cac:Signature>' . PHP_EOL;
        $__invoice .= '                <cbc:ID>' . $ticketInvoice->getCompany()->getRuc() . '</cbc:ID>' . PHP_EOL;
        $__invoice .= '                <cbc:Note><![CDATA[' . $ticketInvoice->getCompany()->getBusinessName() . ']]></cbc:Note>' . PHP_EOL;
        $__invoice .= '                <cac:SignatoryParty>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyIdentification>' . PHP_EOL;
        $__invoice .= '                    <cbc:ID>' . $ticketInvoice->getCompany()->getRuc() . '</cbc:ID>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyIdentification>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyName>' . PHP_EOL;
        $__invoice .= '                    <cbc:Name><![CDATA[' . $ticketInvoice->getCompany()->getTradeName() . ']]></cbc:Name>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyName>' . PHP_EOL;
        $__invoice .= '                </cac:SignatoryParty>' . PHP_EOL;
        $__invoice .= '                <cac:DigitalSignatureAttachment>' . PHP_EOL;
        $__invoice .= '                    <cac:ExternalReference>' . PHP_EOL;
        $__invoice .= '                    <cbc:URI>#SIGN-EMPRESA</cbc:URI>' . PHP_EOL;
        $__invoice .= '                    </cac:ExternalReference>' . PHP_EOL;
        $__invoice .= '                </cac:DigitalSignatureAttachment>' . PHP_EOL;
        $__invoice .= '            </cac:Signature>' . PHP_EOL;
        $__invoice .= '            <cac:AccountingSupplierParty>' . PHP_EOL;
        $__invoice .= '                <cac:Party>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyIdentification>' . PHP_EOL;
        $__invoice .= '                    <cbc:ID schemeID="' . $ticketInvoice->getCompany()->getDocType() . '">' . $ticketInvoice->getCompany()->getRuc() . '</cbc:ID>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyIdentification>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyName>' . PHP_EOL;
        $__invoice .= '                    <cbc:Name><![CDATA[' . $ticketInvoice->getCompany()->getBusinessName() . ']]></cbc:Name>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyName>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyLegalEntity>' . PHP_EOL;
        $__invoice .= '                    <cbc:RegistrationName><![CDATA[' . $ticketInvoice->getCompany()->getTradeName() . ']]></cbc:RegistrationName>' . PHP_EOL;
        $__invoice .= '                    <cac:RegistrationAddress>' . PHP_EOL;
        $__invoice .= '                        <cbc:ID>' . $ticketInvoice->getCompany()->getUbigeo() . '</cbc:ID>' . PHP_EOL;
        $__invoice .= '                        <cbc:AddressTypeCode>0000</cbc:AddressTypeCode>' . PHP_EOL;
        $__invoice .= '                        <cbc:CitySubdivisionName>NONE</cbc:CitySubdivisionName>' . PHP_EOL;
        $__invoice .= '                        <cbc:CityName>' . $ticketInvoice->getCompany()->getProvince() . '</cbc:CityName>' . PHP_EOL;
        $__invoice .= '                        <cbc:CountrySubentity>' . $ticketInvoice->getCompany()->getDepartment() . '</cbc:CountrySubentity>' . PHP_EOL;
        $__invoice .= '                        <cbc:District>' . $ticketInvoice->getCompany()->getDistrict() . '</cbc:District>' . PHP_EOL;
        $__invoice .= '                        <cac:AddressLine>' . PHP_EOL;
        $__invoice .= '                            <cbc:Line><![CDATA[' . $ticketInvoice->getCompany()->getAddress() . ']]></cbc:Line>' . PHP_EOL;
        $__invoice .= '                        </cac:AddressLine>' . PHP_EOL;
        $__invoice .= '                        <cac:Country>' . PHP_EOL;
        $__invoice .= '                            <cbc:IdentificationCode>' . $ticketInvoice->getCompany()->getCountry() . '</cbc:IdentificationCode>' . PHP_EOL;
        $__invoice .= '                        </cac:Country>' . PHP_EOL;
        $__invoice .= '                    </cac:RegistrationAddress>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyLegalEntity>' . PHP_EOL;
        $__invoice .= '                </cac:Party>' . PHP_EOL;
        $__invoice .= '            </cac:AccountingSupplierParty>' . PHP_EOL;
        $__invoice .= '            <cac:AccountingCustomerParty>' . PHP_EOL;
        $__invoice .= '                <cac:Party>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyIdentification>' . PHP_EOL;
        $__invoice .= '                    <cbc:ID schemeID="' . $ticketInvoice->getCustomer()->getDocType() . '">' . $ticketInvoice->getCustomer()->getRuc() . '</cbc:ID>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyIdentification>' . PHP_EOL;
        $__invoice .= '                    <cac:PartyLegalEntity>' . PHP_EOL;
        $__invoice .= '                    <cbc:RegistrationName><![CDATA[' . $ticketInvoice->getCustomer()->getTradeName() . ']]></cbc:RegistrationName>' . PHP_EOL;
        $__invoice .= '                    <cac:RegistrationAddress>' . PHP_EOL;
        $__invoice .= '                        <cac:AddressLine>' . PHP_EOL;
        $__invoice .= '                            <cbc:Line><![CDATA[' . $ticketInvoice->getCustomer()->getAddress() . ']]></cbc:Line>' . PHP_EOL;
        $__invoice .= '                        </cac:AddressLine>' . PHP_EOL;
        $__invoice .= '                        <cac:Country>' . PHP_EOL;
        $__invoice .= '                            <cbc:IdentificationCode>' . $ticketInvoice->getCustomer()->getCountry() . '</cbc:IdentificationCode>' . PHP_EOL;
        $__invoice .= '                        </cac:Country>' . PHP_EOL;
        $__invoice .= '                    </cac:RegistrationAddress>' . PHP_EOL;
        $__invoice .= '                    </cac:PartyLegalEntity>' . PHP_EOL;
        $__invoice .= '                </cac:Party>' . PHP_EOL;
        $__invoice .= '            </cac:AccountingCustomerParty>' . PHP_EOL;

        if ($ticketInvoice->getDocType() == '01') {
            if ($ticketInvoice->getPayType() == 'Contado') {
                $__invoice .= '<cac:PaymentTerms>' . PHP_EOL;
                $__invoice .= '    <cbc:ID>FormaPago</cbc:ID>' . PHP_EOL;
                $__invoice .= '    <cbc:PaymentMeansID>' . $ticketInvoice->getPayType() . '</cbc:PaymentMeansID>' . PHP_EOL;
                $__invoice .= '</cac:PaymentTerms>' . PHP_EOL;
            }

            if ($ticketInvoice->getPayType() == 'Credito') {
                $__invoice .= '<cac:PaymentTerms>' . PHP_EOL;
                $__invoice .= '    <cbc:ID>FormaPago</cbc:ID>' . PHP_EOL;
                $__invoice .= '    <cbc:PaymentMeansID>' . $ticketInvoice->getPayType() . '</cbc:PaymentMeansID>' . PHP_EOL;
                $__invoice .= '    <cbc:Amount currencyID="PEN">' . $ticketInvoice->getAmountSlope() . '</cbc:Amount>' . PHP_EOL;
                $__invoice .= '</cac:PaymentTerms>' . PHP_EOL;

                foreach (array() as $value) {
                    $__invoice .= '<cac:PaymentTerms>' . PHP_EOL;
                    $__invoice .= '    <cbc:ID>FormaPago</cbc:ID>' . PHP_EOL;
                    $__invoice .= '    <cbc:PaymentMeansID>' . $value['cuota'] . '</cbc:PaymentMeansID>' . PHP_EOL;
                    $__invoice .= '    <cbc:Amount currencyID="PEN">' . $value['monto'] . '</cbc:Amount>' . PHP_EOL;
                    $__invoice .= '    <cbc:PaymentDueDate>' . $value['fecha'] . '</cbc:PaymentDueDate>' . PHP_EOL;
                    $__invoice .= '</cac:PaymentTerms>' . PHP_EOL;
                }
            }
        }

        $__invoice .= '<cac:TaxTotal>' . PHP_EOL;
        $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . ($ticketInvoice->getAmountTax() + $ticketInvoice->getAmountIcbper()) . '</cbc:TaxAmount>' . PHP_EOL;

        if ($ticketInvoice->getAmountRecorded() > 0) {
            $__invoice .= '<cac:TaxSubtotal>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountRecorded() . '</cbc:TaxableAmount>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountTax() . '</cbc:TaxAmount>' . PHP_EOL;
            $__invoice .= '    <cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '    <cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '        <cbc:ID>1000</cbc:ID>' . PHP_EOL;
            $__invoice .= '        <cbc:Name>IGV</cbc:Name>' . PHP_EOL;
            $__invoice .= '        <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>' . PHP_EOL;
            $__invoice .= '    </cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '    </cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '</cac:TaxSubtotal>' . PHP_EOL;
        }

        if ($ticketInvoice->getAmountExonerated() > 0) {
            $__invoice .= '<cac:TaxSubtotal>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountExonerated() . '</cbc:TaxableAmount>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">0.00</cbc:TaxAmount>' . PHP_EOL;
            $__invoice .= '    <cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '        <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>' . PHP_EOL;
            $__invoice .= '        <cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '            <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9997</cbc:ID>' . PHP_EOL;
            $__invoice .= '            <cbc:Name>EXO</cbc:Name>' . PHP_EOL;
            $__invoice .= '            <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>' . PHP_EOL;
            $__invoice .= '        </cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '    </cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '</cac:TaxSubtotal>' . PHP_EOL;
        }

        if ($ticketInvoice->getAmountUnaffected() > 0) {
            $__invoice .= '<cac:TaxSubtotal>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountUnaffected() . '</cbc:TaxableAmount>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">0.00</cbc:TaxAmount>' . PHP_EOL;
            $__invoice .= '    <cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '        <cbc:ID schemeID="UN/ECE 5305" schemeName="Tax Category Identifier" schemeAgencyName="United Nations Economic Commission for Europe">E</cbc:ID>' . PHP_EOL;
            $__invoice .= '        <cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '            <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">9998</cbc:ID>' . PHP_EOL;
            $__invoice .= '            <cbc:Name>INA</cbc:Name>' . PHP_EOL;
            $__invoice .= '            <cbc:TaxTypeCode>FRE</cbc:TaxTypeCode>' . PHP_EOL;
            $__invoice .= '        </cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '    </cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '</cac:TaxSubtotal>' . PHP_EOL;
        }

        if ($ticketInvoice->getAmountIcbper() > 0) {
            $__invoice .= '<cac:TaxSubtotal>' . PHP_EOL;
            $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountIcbper() . '</cbc:TaxAmount>' . PHP_EOL;
            $__invoice .= '    <cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '        <cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '            <cbc:ID schemeID="UN/ECE 5153" schemeAgencyID="6">7152</cbc:ID>' . PHP_EOL;
            $__invoice .= '            <cbc:Name>ICBPER</cbc:Name>' . PHP_EOL;
            $__invoice .= '            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>' . PHP_EOL;
            $__invoice .= '        </cac:TaxScheme>' . PHP_EOL;
            $__invoice .= '    </cac:TaxCategory>' . PHP_EOL;
            $__invoice .= '</cac:TaxSubtotal>' . PHP_EOL;
        }

        $total_antes_de_impuestos = $ticketInvoice->getAmountRecorded() + $ticketInvoice->getAmountExonerated() + $ticketInvoice->getAmountUnaffected();

        $__invoice .= '</cac:TaxTotal>' . PHP_EOL;
        $__invoice .= '<cac:LegalMonetaryTotal>' . PHP_EOL;
        $__invoice .= '    <cbc:LineExtensionAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $total_antes_de_impuestos . '</cbc:LineExtensionAmount>' . PHP_EOL;
        $__invoice .= '    <cbc:TaxInclusiveAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountTotal() . '</cbc:TaxInclusiveAmount>' . PHP_EOL;
        $__invoice .= '    <cbc:PayableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $ticketInvoice->getAmountTotal() . '</cbc:PayableAmount>' . PHP_EOL;
        $__invoice .= '</cac:LegalMonetaryTotal>' . PHP_EOL;

        foreach ($ticketInvoice->getDetail() as $item) {

            $__invoice .= '<cac:InvoiceLine>' . PHP_EOL;
            $__invoice .= '<cbc:ID>' . $item->getItemId() . '</cbc:ID>' . PHP_EOL;
            $__invoice .= '<cbc:InvoicedQuantity unitCode="' . $item->getItemUnid() . '">' . $item->getItemQty() . '</cbc:InvoicedQuantity>' . PHP_EOL;
            $__invoice .= '<cbc:LineExtensionAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemPriceWithoutTax() . '</cbc:LineExtensionAmount>' . PHP_EOL;
            $__invoice .= '<cac:PricingReference>' . PHP_EOL;
            $__invoice .= '    <cac:AlternativeConditionPrice>' . PHP_EOL;
            $__invoice .= '    <cbc:PriceAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemPrice() . '</cbc:PriceAmount>' . PHP_EOL;
            $__invoice .= '    <cbc:PriceTypeCode>' . $item->getItemTypePrice() . '</cbc:PriceTypeCode>' . PHP_EOL;
            $__invoice .= '    </cac:AlternativeConditionPrice>' . PHP_EOL;
            $__invoice .= '</cac:PricingReference>' . PHP_EOL;


            if ($item->getItemWithBag() == 'SI') {
                $__invoice .= '<cac:TaxTotal>' . PHP_EOL;
                $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . ($item->getItemQty() * 0.40 + $item->getItemTax()) . '</cbc:TaxAmount>' . PHP_EOL;
                $__invoice .= '    <cac:TaxSubtotal>' . PHP_EOL;
                $__invoice .= '            <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTotalWithoutTax() . '</cbc:TaxableAmount>' . PHP_EOL;
                $__invoice .= '            <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTax() . '</cbc:TaxAmount>' . PHP_EOL;
                $__invoice .= '            <cac:TaxCategory>' . PHP_EOL;
                $__invoice .= '            <cbc:Percent>' . $item->getItemTaxPercent() . '</cbc:Percent>' . PHP_EOL;
                $__invoice .= '            <cbc:TaxExemptionReasonCode>' . $item->getItemTypeAffectTax() . '</cbc:TaxExemptionReasonCode>' . PHP_EOL;
                $__invoice .= '            <cac:TaxScheme>' . PHP_EOL;
                $__invoice .= '                <cbc:ID>' . $item->getItemCodeTypeTribute() . '</cbc:ID>' . PHP_EOL;
                $__invoice .= '                <cbc:Name>' . $item->getItemNameTribute() . '</cbc:Name>' . PHP_EOL;
                $__invoice .= '                <cbc:TaxTypeCode>' . $item->getItemTypeTribute() . '</cbc:TaxTypeCode>' . PHP_EOL;
                $__invoice .= '            </cac:TaxScheme>' . PHP_EOL;
                $__invoice .= '            </cac:TaxCategory>' . PHP_EOL;
                $__invoice .= '    </cac:TaxSubtotal>' . PHP_EOL;
                $__invoice .= '    <cac:TaxSubtotal>' . PHP_EOL;
                $__invoice .= '        <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . ($item->getItemQty() * 0.40) . '</cbc:TaxAmount>' . PHP_EOL;
                $__invoice .= '        <cbc:BaseUnitMeasure unitCode="' . $item->getItemUnid() . '">' . $item->getItemQty() . '</cbc:BaseUnitMeasure>' . PHP_EOL;
                $__invoice .= '        <cac:TaxCategory>' . PHP_EOL;
                $__invoice .= '            <cbc:PerUnitAmount currencyID="PEN">0.40</cbc:PerUnitAmount>' . PHP_EOL;
                $__invoice .= '            <cac:TaxScheme>' . PHP_EOL;
                $__invoice .= '                <cbc:ID schemeName="Codigo de tributos" schemeAgencyName="PE:SUNAT" >7152</cbc:ID>' . PHP_EOL;
                $__invoice .= '                <cbc:Name>ICBPER</cbc:Name>' . PHP_EOL;
                $__invoice .= '                <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>' . PHP_EOL;
                $__invoice .= '            </cac:TaxScheme>' . PHP_EOL;
                $__invoice .= '        </cac:TaxCategory>' . PHP_EOL;
                $__invoice .= '    </cac:TaxSubtotal>' . PHP_EOL;
            } else {
                $__invoice .= '<cac:TaxTotal>' . PHP_EOL;
                $__invoice .= '<cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTax() . '</cbc:TaxAmount>' . PHP_EOL;
                $__invoice .= '<cac:TaxSubtotal>' . PHP_EOL;
                $__invoice .= '    <cbc:TaxableAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTotalWithoutTax() . '</cbc:TaxableAmount>' . PHP_EOL;
                $__invoice .= '    <cbc:TaxAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemTax() . '</cbc:TaxAmount>' . PHP_EOL;
                $__invoice .= '    <cac:TaxCategory>' . PHP_EOL;
                $__invoice .= '        <cbc:Percent>' . $item->getItemTaxPercent() . '</cbc:Percent>' . PHP_EOL;
                $__invoice .= '        <cbc:TaxExemptionReasonCode>' . $item->getItemTypeAffectTax() . '</cbc:TaxExemptionReasonCode>' . PHP_EOL;
                $__invoice .= '        <cac:TaxScheme>' . PHP_EOL;
                $__invoice .= '            <cbc:ID>' . $item->getItemCodeTypeTribute() . '</cbc:ID>' . PHP_EOL;
                $__invoice .= '            <cbc:Name>' . $item->getItemNameTribute() . '</cbc:Name>' . PHP_EOL;
                $__invoice .= '            <cbc:TaxTypeCode>' . $item->getItemTypeTribute() . '</cbc:TaxTypeCode>' . PHP_EOL;
                $__invoice .= '        </cac:TaxScheme>' . PHP_EOL;
                $__invoice .= '    </cac:TaxCategory>' . PHP_EOL;
                $__invoice .= '</cac:TaxSubtotal>' . PHP_EOL;
            }


            $__invoice .= '</cac:TaxTotal>' . PHP_EOL;
            $__invoice .= '    <cac:Item>' . PHP_EOL;
            $__invoice .= '        <cbc:Description><![CDATA[' . $item->getItemDescription() . ']]></cbc:Description>' . PHP_EOL;
            $__invoice .= '        <cac:SellersItemIdentification>' . PHP_EOL;
            $__invoice .= '        <cbc:ID>' . $item->getItemCode() . '</cbc:ID>' . PHP_EOL;
            $__invoice .= '        </cac:SellersItemIdentification>' . PHP_EOL;
            $__invoice .= '    </cac:Item>' . PHP_EOL;
            $__invoice .= '    <cac:Price>' . PHP_EOL;
            $__invoice .= '        <cbc:PriceAmount currencyID="' . $ticketInvoice->getCurrency() . '">' . $item->getItemPriceWithoutTax() . '</cbc:PriceAmount>' . PHP_EOL;
            $__invoice .= '    </cac:Price>' . PHP_EOL;
            $__invoice .= '</cac:InvoiceLine>' . PHP_EOL;
        }

        $__invoice .= '</Invoice>' . PHP_EOL;

        return $__invoice;
    }
}

?>