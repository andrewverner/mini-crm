<?php

declare(strict_types = 1);

namespace common\exceptions;

use Exception;

final class NotFoundException extends Exception
{
    protected $code = 404;
}
