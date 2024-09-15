<?php

declare(strict_types=1);

namespace common\strategies\email;

interface EmailJobStrategyInterface
{
    public function getHtmlBody(): string;

    public function getSubject(): string;
}
