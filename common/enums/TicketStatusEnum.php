<?php

declare(strict_types=1);

namespace common\enums;

enum TicketStatusEnum: int
{
    case RECEIVED = 1;
    case REJECTED = 2;
    case DEFECT = 3;
}
