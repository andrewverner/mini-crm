<?php

declare(strict_types=1);

namespace common\services;

interface TicketServiceInterface
{
    public function createTicket(array $data): bool;
}
