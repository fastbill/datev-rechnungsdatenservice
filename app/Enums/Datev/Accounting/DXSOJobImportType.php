<?php

namespace App\Enums\Datev\Accounting;

enum DXSOJobImportType: string
{
    case INCOMING_INVOICES = 'accountsPayableLedgerImport';
    case OUTGOING_INVOICES = 'accountsReceivableLedgerImport';
    case CASH_ENTRIES = 'cashLedgerImport';
}
