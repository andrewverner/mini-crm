<?php

declare(strict_types=1);

namespace common\enums;

enum TokenTypeEnum: int
{
    case ACTIVATION = 1;
    case RESET_PASSWORD = 2;
}
