<?php

declare(strict_types=1);

namespace common\services;

use common\repositories\TicketRepositoryInterface;

final class TicketService implements TicketServiceInterface
{
    public function createTicket(array $data): bool
    {
        return true;
    }
}
