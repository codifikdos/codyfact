<?php

namespace CodyFact\Api;

interface ICommand
{

    const QUERY_DOCUMENT_CDR                        = 'DOCUMENT_CDR';

    const STATEMENT_SEND_INVOICE                    = 'SEND_INVOICE';
    const STATEMENT_SEND_RETENTION_PERCEPTION       = 'SEND_RETENTION_PERCEPTION';
    const STATEMENT_SEND_GUIDE                      = 'SEND_GUIDE';

}