<?php

declare(strict_types=1);

namespace common\queue\jobs;

use common\strategies\email\EmailJobStrategyInterface;
use Yii;
use yii\queue\JobInterface;

final readonly class EmailJob implements JobInterface
{
    public function __construct(
        private string $email,
        private EmailJobStrategyInterface $emailJobStrategy,
    ) {
    }

    public function execute($queue): void
    {
        Yii::$app->mailer->compose()
            ->setFrom(from: Yii::$app->params['noReplySenderEmail'])
            ->setTo(to: $this->email)
            ->setSubject(subject: $this->emailJobStrategy->getSubject())
            ->setHtmlBody(html: $this->emailJobStrategy->getHtmlBody())
            ->send();
    }
}
