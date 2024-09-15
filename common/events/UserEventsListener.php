<?php

declare(strict_types=1);

namespace common\events;

use common\models\User;
use common\services\TokenServiceInterface;
use Yii;
use yii\base\Event;

final class UserEventsListener
{
    public static function createActivationToken(Event $event): void
    {
        assert($event->sender instanceof User);

        $tokenService = Yii::$container->get(class: TokenServiceInterface::class);
        $tokenService->createActivationToken(user: $event->sender);
    }
}
