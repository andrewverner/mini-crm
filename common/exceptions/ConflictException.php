<?php

declare(strict_types=1);

namespace common\exceptions;

use Exception;

class ConflictException extends Exception
{
    protected $code = 409;
}
