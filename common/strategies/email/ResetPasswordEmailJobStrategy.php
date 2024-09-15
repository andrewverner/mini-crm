<?php

declare(strict_types=1);

namespace common\strategies\email;

use Yii;

final readonly class ResetPasswordEmailJobStrategy implements EmailJobStrategyInterface
{
    public function getHtmlBody(): string
    {
        return Yii::$app->controller->renderFile(
            file: Yii::getAlias(alias: '@common/mail') . '/new-password.php',
            params: [
                'subject' => $this->getSubject()
            ],
        );
    }

    public function getSubject(): string
    {
        return 'New password';
    }
}
