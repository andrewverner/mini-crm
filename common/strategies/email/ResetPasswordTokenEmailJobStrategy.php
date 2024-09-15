<?php

declare(strict_types=1);

namespace common\strategies\email;

use common\models\Token;
use Yii;

final readonly class ResetPasswordTokenEmailJobStrategy implements EmailJobStrategyInterface
{
    public function __construct(
        private Token $token,
    ) {
    }

    public function getHtmlBody(): string
    {
        return Yii::$app->controller->renderFile(
            file: Yii::getAlias(alias: '@common/mail') . '/reset-password.php',
            params: [
                'token' => $this->token,
                'subject' => $this->getSubject()
            ],
        );
    }

    public function getSubject(): string
    {
        return 'Password reset';
    }
}
