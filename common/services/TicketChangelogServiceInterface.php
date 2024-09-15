<?php

declare(strict_types=1);

namespace common\services;

use common\models\Ticket;

interface TicketChangelogServiceInterface
{
    public function logChanges(array $changedAttributes, Ticket $ticket): void;
}
