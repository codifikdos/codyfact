<?php

namespace CodyFact\Api;

interface IContext
{
    const CONTEXT_BILL_CONSULT_SERVICE_CDR              = 'bcs_cdr';

    const CONTEXT_BILL_SERVICE_INVOICE                  = 'bs_invoice';
    const CONTEXT_BILL_SERVICE_RETENTION_PERCEPTION     = 'bs_retention_perception';
    const CONTEXT_BILL_SERVICE_GUIDE                    = 'bs_guide';

    public function setContext($context);

    public function getContext();
}