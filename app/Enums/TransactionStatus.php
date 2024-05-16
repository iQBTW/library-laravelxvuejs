<?php

namespace App\Enums;

enum TransactionStatus
{
    case ACTIVE = 'active';
    case COMPLETE = 'complete';
    case DUE = 'due';
}
