<?php

declare(strict_types=1);

namespace common\enums;

enum UserStatusEnum: int
{
    case ACTIVE = 1;
    case INACTIVE = 2;
    case BLOCKED = 3;
    case DELETED = 4;
}
