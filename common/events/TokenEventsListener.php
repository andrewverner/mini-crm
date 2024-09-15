<?php

declare(strict_types=1);

namespace common\events;

use common\enums\TokenTypeEnum;
use common\models\Token;
use common\queue\jobs\EmailJob;
use common\strategies\email\ActivationTokenEmailJobStrategy;
use common\strategies\email\ResetPasswordEmailJobStrategy;
use common\strategies\email\ResetPasswordTokenEmailJobStrategy;
use Yii;
use yii\base\Event;

final class TokenEventsListener
{
    public static function sendEmailOnCreate(Event $event): void
    {
        assert($event->sender instanceof Token);

        $jobStrategy = match ($event->sender->type) {
            TokenTypeEnum::ACTIVATION->value => new ActivationTokenEmailJobStrategy(token: $event->sender),
            TokenTypeEnum::RESET_PASSWORD->value => new ResetPasswordTokenEmailJobStrategy(token: $event->sender),
        };

        Yii::$app->queue->push(new EmailJob(
            email: $event->sender->user->email,
            emailJobStrategy: $jobStrategy,
        ));
    }

    public static function sendEmailOnUse(Event $event): void
    {
        if (
            !$event->sender instanceof Token
            || $event->sender->type !== TokenTypeEnum::RESET_PASSWORD->value
        ) {
            return;
        }

        Yii::$app->queue->push(new EmailJob(
            email: $event->sender->user->email,
            emailJobStrategy: new ResetPasswordEmailJobStrategy(),
        ));
    }
}
